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
