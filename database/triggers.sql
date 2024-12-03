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
