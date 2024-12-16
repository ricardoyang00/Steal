/* Trigger to anonymize user data*/
-- Create the anonymization function, ensuring it returns a TRIGGER type
CREATE OR REPLACE FUNCTION anonymize_user_data() RETURNS TRIGGER AS
$BODY$
BEGIN
    -- Anonymize user data only when is_active transitions from TRUE to FALSE
    IF NEW.is_active = FALSE AND OLD.is_active = TRUE THEN
        -- Update the NEW row directly to anonymize user data
        NEW.username := 'Anonymous' || OLD.id;
        NEW.name := 'Anonymous';
        NEW.email := 'anonymous' || OLD.id || 'mail';
        NEW.password := 'anonymous';
        NEW.google_id := NULL;
        NEW.profile_picture := NULL;

        -- Update Buyer table
        UPDATE Buyer
        SET NIF = NULL,
            birth_date = '1111-11-11', -- Placeholder date
            coins = 0
        WHERE id = OLD.id;
    END IF;

    -- Return the NEW row for the update
    RETURN NEW;
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


-- Trigger to clean notifications table after shoppingCartNotifications or wishlistNotifications entries are deleted
CREATE OR REPLACE FUNCTION delete_notification_after_specific_notification_delete()
RETURNS trigger AS $$
BEGIN
    DELETE FROM Notifications WHERE id = OLD.id;
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER delete_notification_after_shoppingcart
AFTER DELETE ON NotificationShoppingCart
FOR EACH ROW
EXECUTE PROCEDURE delete_notification_after_specific_notification_delete();

CREATE TRIGGER delete_notification_after_wishlist
AFTER DELETE ON NotificationWishlist
FOR EACH ROW
EXECUTE PROCEDURE delete_notification_after_specific_notification_delete();

CREATE TRIGGER delete_notification_after_review
AFTER DELETE ON NotificationReview
FOR EACH ROW
EXECUTE PROCEDURE delete_notification_after_specific_notification_delete();

CREATE TRIGGER delete_notification_after_game
AFTER DELETE ON NotificationGame
FOR EACH ROW
EXECUTE PROCEDURE delete_notification_after_specific_notification_delete();

CREATE TRIGGER delete_notification_after_order
AFTER DELETE ON NotificationOrder
FOR EACH ROW
EXECUTE PROCEDURE delete_notification_after_specific_notification_delete();

/* Trigger to clear cart and wishlist after delivery */
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

/* Trigger to check age upon checkout */
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

    -- Get the minimum age of the game from the Age table
    SELECT minimum_age INTO game_minimum_age
    FROM Age
    JOIN Game ON Game.age_id = Age.id
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


/* Trigger to check age upon prepurchase */
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

    -- Get the minimum age of the game from the Age table
    SELECT minimum_age INTO game_minimum_age
    FROM Age
    JOIN Game ON Game.age_id = Age.id
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

-- Trigger to invoke the function before inserting into PrePurchase
CREATE TRIGGER check_age_before_prepurchase_insert
BEFORE INSERT ON PrePurchase
FOR EACH ROW
EXECUTE FUNCTION check_age_requirement_prepurchase();


/* Trigger to increase and decrease S-Coins upon orders */
CREATE FUNCTION add_scoin_on_order() RETURNS TRIGGER AS 
$BODY$
DECLARE
    buyer_id INT;
    total_spent FLOAT;
    scoin_reward INT;
    coins_used INT;
BEGIN
    -- Find the buyer ID, total spent, and coins used for the new order
    SELECT o.buyer, p.value, o.coins INTO buyer_id, total_spent, coins_used
    FROM Orders o
    JOIN Payment p ON o.payment = p.id
    WHERE o.id = NEW.id;

    -- Calculate SCoins reward: 5 SCoins per 1 euro spent, rounding up
    scoin_reward := CEIL(total_spent * 5);

    -- Update the buyer's coins with the calculated SCoins and decrement the used coins
    UPDATE Buyer
    SET coins = coins + scoin_reward - coins_used
    WHERE id = buyer_id;

    RETURN NEW;
END;
$BODY$ 
LANGUAGE plpgsql;

-- Trigger to invoke the function after inserting into Orders
CREATE TRIGGER trg_add_scoin_on_order
AFTER INSERT ON Orders
FOR EACH ROW
EXECUTE FUNCTION add_scoin_on_order();
CREATE FUNCTION update_game_rating_after_review() RETURNS TRIGGER AS
$BODY$
DECLARE
    total_reviews INT;
    positive_reviews INT;
    rating_percentage INT;
    game_id INT;
BEGIN
    -- Determine the game ID based on the operation
    IF TG_OP = 'DELETE' THEN
        game_id := OLD.game;
    ELSE
        game_id := NEW.game;
    END IF;

    -- Calculate the total number of reviews for the game
    SELECT COUNT(*) INTO total_reviews
    FROM Review
    WHERE game = game_id;

    -- Calculate the number of positive reviews (positive = TRUE) for the game
    SELECT COUNT(*) INTO positive_reviews
    FROM Review
    WHERE game = game_id AND positive = TRUE;

    -- Calculate the positive percentage and round to the nearest integer
    IF total_reviews > 0 THEN
        rating_percentage := ROUND((positive_reviews * 100.0) / total_reviews);
    ELSE
        rating_percentage := 0;  -- If no reviews, set rating to 0
    END IF;

    -- Update the overall_rating in the game table
    UPDATE Game
    SET overall_rating = rating_percentage
    WHERE id = game_id;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER trg_update_game_rating_after_review
AFTER INSERT OR UPDATE OR DELETE ON Review
FOR EACH ROW
EXECUTE FUNCTION update_game_rating_after_review();
