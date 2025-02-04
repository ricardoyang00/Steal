-- Create the anonymization function, ensuring it returns a TRIGGER type
CREATE OR REPLACE FUNCTION anonymize_user_data() RETURNS TRIGGER AS
$BODY$
BEGIN
    -- Anonymize data in Users table
    UPDATE Users
    SET username = 'Anonymous' || OLD.id,
        name = 'Anonymous',
        email = 'anonymous' || OLD.id || '@example.com',
        password = 'anonymous'
    WHERE id = OLD.id;

    -- Anonymize data in Buyer table
    UPDATE Buyer
    SET NIF = NULL,
        birth_date = '1111-11-11', -- Placeholder date
        coins = 0
    WHERE id = OLD.id;

    RETURN NULL; -- Trigger functions should return a value (NULL for BEFORE triggers)
END;
$BODY$
LANGUAGE plpgsql;

-- Create the trigger to call the function before updating Users
CREATE TRIGGER trg_anonymize_user_data
BEFORE UPDATE ON Users
FOR EACH ROW
WHEN (NEW.is_active IS FALSE)  -- Trigger when is_active is set to FALSE
EXECUTE FUNCTION anonymize_user_data();



-- Function to check if the buyer has purchased the game
CREATE OR REPLACE FUNCTION check_review_eligibility() RETURNS TRIGGER AS
$BODY$
BEGIN
    -- Check if the buyer has purchased the game through a delivered purchase
    IF NOT EXISTS (
        SELECT 1 
        FROM DeliveredPurchase dp
        JOIN Purchase p ON dp.id = p.id
        JOIN Orders o ON p.order_ = o.id
        WHERE dp.cdk IN (
            SELECT cd.id 
            FROM CDK cd 
            JOIN Game g ON cd.game = g.id 
            WHERE g.id = NEW.game
        )
        AND o.buyer = NEW.author
    ) THEN
        RAISE EXCEPTION 'A buyer can only review games they have purchased.';
    END IF;

    RETURN NEW;
END;
$BODY$ LANGUAGE plpgsql;

-- Trigger to check review eligibility
CREATE TRIGGER trg_check_review_eligibility
BEFORE INSERT ON Review
FOR EACH ROW
EXECUTE FUNCTION check_review_eligibility();


CREATE OR REPLACE FUNCTION clear_cart_and_wishlist_after_delivery()
RETURNS TRIGGER AS
$BODY$
DECLARE
    game_id INT;
    buyer_id INT;
BEGIN
    -- Retrieve the game associated with the delivered CDK
    SELECT Game.id INTO game_id
    FROM Game
    JOIN CDK ON CDK.game = Game.id
    WHERE CDK.id = NEW.cdk;

    -- Retrieve the buyer associated with the order
    SELECT Orders.buyer INTO buyer_id
    FROM Orders
    JOIN Purchase ON Purchase.order_ = Orders.id
    WHERE Purchase.id = NEW.id;

    -- Delete the game from the buyer's ShoppingCart
    DELETE FROM ShoppingCart
    WHERE buyer = buyer_id
      AND game = game_id;

    -- Delete the game from the buyer's Wishlist
    DELETE FROM Wishlist
    WHERE buyer = buyer_id
      AND game = game_id;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

-- Create the trigger to invoke the function after an insert on DeliveredPurchase
CREATE TRIGGER trg_clear_cart_and_wishlist_after_delivery
AFTER INSERT ON DeliveredPurchase
FOR EACH ROW
EXECUTE FUNCTION clear_cart_and_wishlist_after_delivery();



CREATE OR REPLACE FUNCTION update_game_rating_after_review() RETURNS TRIGGER AS
$BODY$
DECLARE
    total_reviews INT;
    recommended_reviews INT;
    rating_percentage INT;
BEGIN
    -- Calculate the total number of reviews for the game
    SELECT COUNT(*) INTO total_reviews
    FROM Review
    WHERE id_game = NEW.id_game;

    -- Calculate the number of recommended reviews (recommend = TRUE) for the game
    SELECT COUNT(*) INTO recommended_reviews
    FROM Review
    WHERE id_game = NEW.id_game AND recommend = TRUE;

    -- Calculate the recommendation percentage and round to the nearest integer
    IF total_reviews > 0 THEN
        rating_percentage := ROUND((recommended_reviews * 100.0) / total_reviews);
    ELSE
        rating_percentage := 0;  -- If no reviews, set rating to 0
    END IF;

    -- Update the overall_rating in the game table
    UPDATE Game
    SET overall_rating = rating_percentage
    WHERE id = NEW.id_game;

    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER trg_update_game_rating_after_review
AFTER INSERT OR DELETE ON Review
FOR EACH ROW
EXECUTE FUNCTION update_game_rating_after_review();



-- Function to check if the user is trying to like their own review
CREATE OR REPLACE FUNCTION prevent_self_like()
RETURNS TRIGGER AS $$
BEGIN
    IF (SELECT author FROM Review WHERE id = NEW.review) = NEW.author THEN
        RAISE EXCEPTION 'A user cannot like their own review';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_prevent_self_like
BEFORE INSERT ON ReviewLike
FOR EACH ROW
EXECUTE FUNCTION prevent_self_like();


-- Function to check age requirement before insert
CREATE OR REPLACE FUNCTION check_age_requirement() 
RETURNS TRIGGER AS $$
DECLARE
    buyer_birth_date DATE;
    game_minimum_age INT;
    buyer_age INT;
BEGIN
    -- Get the buyer's birth date
    SELECT birth_date INTO buyer_birth_date
    FROM Buyer
    JOIN Orders ON Orders.buyer = Buyer.id
    JOIN Purchase ON Purchase.order_ = Orders.id
    WHERE Purchase.id = NEW.id;

    -- Get the minimum age of the game
    SELECT minimum_age INTO game_minimum_age
    FROM Game
    JOIN CDK ON CDK.game = Game.id
    WHERE CDK.id = NEW.cdk;

    -- Calculate buyer's age
    buyer_age := DATE_PART('year', CURRENT_DATE) - DATE_PART('year', buyer_birth_date);

    -- Check if the buyer is old enough
    IF buyer_age < game_minimum_age THEN
        RAISE EXCEPTION 'Buyer does not meet the minimum age requirement for this game';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger to invoke the function before inserting into DeliveredPurchase
CREATE TRIGGER check_age_before_insert
BEFORE INSERT ON DeliveredPurchase
FOR EACH ROW
EXECUTE FUNCTION check_age_requirement();


-- Function to check age requirement before insert into PrePurchase
CREATE OR REPLACE FUNCTION check_age_requirement_prepurchase() 
RETURNS TRIGGER AS $$
DECLARE
    buyer_birth_date DATE;
    game_minimum_age INT;
    buyer_age INT;
BEGIN
    -- Get the buyer's birth date
    SELECT birth_date INTO buyer_birth_date
    FROM Buyer
    JOIN Orders ON Orders.buyer = Buyer.id
    JOIN Purchase ON Purchase.order_ = Orders.id
    WHERE Purchase.id = NEW.id;

    -- Get the minimum age of the game
    SELECT minimum_age INTO game_minimum_age
    FROM Game
    WHERE Game.id = NEW.game;

    -- Calculate buyer's age
    buyer_age := DATE_PART('year', CURRENT_DATE) - DATE_PART('year', buyer_birth_date);

    -- Check if the buyer is old enough
    IF buyer_age < game_minimum_age THEN
        RAISE EXCEPTION 'Buyer does not meet the minimum age requirement for this game';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger to invoke the function before inserting into PrePurchase
CREATE TRIGGER check_age_before_prepurchase_insert
BEFORE INSERT ON PrePurchase
FOR EACH ROW
EXECUTE FUNCTION check_age_requirement_prepurchase();


-- Function to add SCoins on purchase
CREATE OR REPLACE FUNCTION add_scoin_on_purchase() 
RETURNS TRIGGER AS $$
DECLARE
    buyer_id INT;
    purchase_value FLOAT;
    scoin_reward INT;
BEGIN
    SELECT o.buyer, p.value INTO buyer_id, purchase_value
    FROM Purchase p
    JOIN Orders o ON p.order_ = o.id
    WHERE p.id = NEW.id;

    IF NEW.coins = 0 THEN
        scoin_reward := FLOOR(purchase_value / 10);
        UPDATE Buyer
        SET coins = coins + scoin_reward
        WHERE id = buyer_id;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER add_scoin_on_purchase
AFTER INSERT ON Purchase
FOR EACH ROW
EXECUTE FUNCTION add_scoin_on_purchase();

-- Function to decrease SCoins
CREATE OR REPLACE FUNCTION decrease_scoins()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE Buyer
    SET coins = coins - NEW.coins
    WHERE id = (SELECT buyer FROM Orders WHERE id = NEW.order_);
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER decrease_scoins_on_purchase
AFTER INSERT ON Purchase
FOR EACH ROW
EXECUTE FUNCTION decrease_scoins();

-- Function to process pre-purchase on CDK addition
CREATE OR REPLACE FUNCTION process_prepurchase_on_cdk_addition()
RETURNS TRIGGER AS $$
DECLARE
    pre_purchase_record RECORD;
BEGIN
    FOR pre_purchase_record IN
        SELECT id, game
        FROM PrePurchase
        WHERE game = NEW.game
    LOOP
        DELETE FROM PrePurchase WHERE id = pre_purchase_record.id;
        INSERT INTO DeliveredPurchase (id, cdk)
        VALUES (pre_purchase_record.id, NEW.id);
    END LOOP;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_process_prepurchase_on_cdk_addition
AFTER INSERT ON CDK
FOR EACH ROW
EXECUTE FUNCTION process_prepurchase_on_cdk_addition();

-- Function to increment game stock
CREATE OR REPLACE FUNCTION increment_game_stock()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE GameStock
    SET quantity = quantity + 1
    WHERE game = NEW.game;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_game_stock
AFTER INSERT ON CDK
FOR EACH ROW
EXECUTE FUNCTION increment_game_stock();

-- Function to decrement game stock with a stock check
CREATE OR REPLACE FUNCTION decrement_game_stock()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE GameStock
    SET quantity = quantity - 1
    WHERE game = (SELECT game FROM CDK WHERE id = NEW.cdk) AND quantity > 0;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER decrement_game_stock
AFTER INSERT ON DeliveredPurchase
FOR EACH ROW
EXECUTE FUNCTION decrement_game_stock();

-- Function to update game table on category, player, language, platform change
CREATE OR REPLACE FUNCTION touch_game_table() RETURNS TRIGGER AS 
$BODY$
BEGIN
    -- Update the Game table
    UPDATE game SET id = id WHERE id = NEW.game;
    RETURN NEW;
END;
$BODY$ 
LANGUAGE plpgsql;

-- Trigger on GameCategory for updates
CREATE TRIGGER touch_game_on_gamecategory_update
AFTER INSERT OR UPDATE ON GameCategory
FOR EACH ROW
EXECUTE FUNCTION touch_game_table();

-- Trigger on GamePlayer for updates
CREATE TRIGGER touch_game_on_gameplayer_update
AFTER INSERT OR UPDATE ON GamePlayer
FOR EACH ROW
EXECUTE FUNCTION touch_game_table();

-- Trigger on GameLanguage for updates
CREATE TRIGGER touch_game_on_gamelanguage_update
AFTER INSERT OR UPDATE ON GameLanguage
FOR EACH ROW
EXECUTE FUNCTION touch_game_table();

-- Trigger on GamePlatform for updates
CREATE TRIGGER touch_game_on_gameplatform_update
AFTER INSERT OR UPDATE ON GamePlatform
FOR EACH ROW
EXECUTE FUNCTION touch_game_table();