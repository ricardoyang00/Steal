CREATE OR REPLACE FUNCTION process_order(
    game_list INT[], 
    buyer_id INT, 
    scoin_amount INT, 
    payment_method INT
) RETURNS VOID AS $$
DECLARE
    payment_id INT;
    order_id INT;
    purchase_id INT;
    game_id INT;
    game_stock INT;
    total_price FLOAT;
BEGIN
    -- 1. Calculate the total price of all games in the game_list
    SELECT SUM(price) INTO total_price
    FROM Game
    WHERE id = ANY(game_list);

    -- 2. Insert the payment with the specified payment method and calculated total price
    INSERT INTO Payment (method, value) VALUES (payment_method, total_price) RETURNING id INTO payment_id;

    -- 3. Create a new order for the user
    INSERT INTO Orders (buyer, payment) VALUES (buyer_id, payment_id) RETURNING id INTO order_id;

    -- 4. For each game in the game_list, create a purchase
    FOREACH game_id IN ARRAY game_list LOOP

        -- Check if there are CDKs in stock for the current game
        SELECT quantity INTO game_stock FROM GameStock WHERE game = game_id;

        IF game_stock > 0 THEN
            -- Stock is available

            -- Create a purchase with the game price and specified SCoins
            INSERT INTO Purchase (value, order_, coins) 
            VALUES ((SELECT price FROM Game WHERE id = game_id), order_id, scoin_amount) RETURNING id INTO purchase_id;

            -- Assign the CDK to the delivered purchase
            INSERT INTO DeliveredPurchase (id, cdk) 
            VALUES (purchase_id, (SELECT id FROM CDK WHERE game = game_id LIMIT 1));

            -- Decrement stock
            UPDATE GameStock SET quantity = quantity - 1 WHERE game = game_id;

        ELSE
            -- No stock available

            -- Create a purchase with zero value and SCoins
            INSERT INTO Purchase (value, order_, coins) 
            VALUES (0, order_id, 0) RETURNING id INTO purchase_id;

            -- Record as a canceled purchase
            INSERT INTO CanceledPurchase (id, game) VALUES (purchase_id, game_id);
        END IF;

    END LOOP;

    COMMIT;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION add_game_with_stock(
    game_name TEXT,
    game_description TEXT,
    game_minimum_age INT,
    game_price FLOAT,
    game_overall_rating INT,
    game_owner INT,
    game_active BOOLEAN
)
RETURNS VOID AS $$
DECLARE
    new_game_id INT;
BEGIN
    -- Insert a new game into the Game table
    INSERT INTO Game (name, description, minimum_age, price, overall_rating, owner, is_active)
    VALUES (game_name, game_description, game_minimum_age, game_price, game_overall_rating, game_owner, game_active)
    RETURNING id INTO new_game_id;

    -- Insert the corresponding entry into GameStock with quantity = 0
    INSERT INTO GameStock (game, quantity)
    VALUES (new_game_id, 0);

EXCEPTION
    WHEN OTHERS THEN
        -- Handle exceptions by raising the error
        RAISE EXCEPTION 'Error occurred while adding game with stock: %', SQLERRM;
END;
$$ LANGUAGE plpgsql;
