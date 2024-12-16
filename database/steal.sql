DROP SCHEMA IF EXISTS lbaw2435 CASCADE;

CREATE SCHEMA lbaw2435;

SET search_path TO lbaw2435;


DROP TABLE IF EXISTS Users CASCADE;
DROP TABLE IF EXISTS Administrator CASCADE;
DROP TABLE IF EXISTS Buyer CASCADE;
DROP TABLE IF EXISTS Seller CASCADE;
DROP TABLE IF EXISTS Game CASCADE;
DROP TABLE IF EXISTS CDK CASCADE;
DROP TABLE IF EXISTS GameStock CASCADE;
DROP TABLE IF EXISTS Platform CASCADE;
DROP TABLE IF EXISTS Category CASCADE;
DROP TABLE IF EXISTS Language CASCADE;
DROP TABLE IF EXISTS Player CASCADE;
DROP TABLE IF EXISTS GamePlatform CASCADE;
DROP TABLE IF EXISTS GameCategory CASCADE;
DROP TABLE IF EXISTS GameLanguage CASCADE;
DROP TABLE IF EXISTS GamePlayer CASCADE;
DROP TABLE IF EXISTS Media CASCADE;
DROP TABLE IF EXISTS Wishlist CASCADE;
DROP TABLE IF EXISTS ShoppingCart CASCADE;
DROP TABLE IF EXISTS PaymentMethod CASCADE;
DROP TABLE IF EXISTS Payment CASCADE;
DROP TABLE IF EXISTS Orders CASCADE;
DROP TABLE IF EXISTS Purchase CASCADE;
DROP TABLE IF EXISTS PrePurchase CASCADE;
DROP TABLE IF EXISTS CanceledPurchase CASCADE;
DROP TABLE IF EXISTS DeliveredPurchase CASCADE;
DROP TABLE IF EXISTS Review CASCADE;
DROP TABLE IF EXISTS ReviewLike CASCADE;
DROP TABLE IF EXISTS Notifications CASCADE;
DROP TABLE IF EXISTS NotificationWishlist CASCADE;
DROP TABLE IF EXISTS NotificationShoppingCart CASCADE;
DROP TABLE IF EXISTS NotificationGame CASCADE;
DROP TABLE IF EXISTS NotificationReview CASCADE;
DROP TABLE IF EXISTS NotificationPurchase CASCADE;
DROP TABLE IF EXISTS Reason CASCADE;
DROP TABLE IF EXISTS Report CASCADE;
DROP TABLE IF EXISTS FAQ CASCADE;
DROP TABLE IF EXISTS About CASCADE;
DROP TABLE IF EXISTS Contacts CASCADE;


CREATE TABLE Users (
    id SERIAL PRIMARY KEY,
    username TEXT UNIQUE NOT NULL,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    is_blocked BOOLEAN DEFAULT FALSE,
    remember_token VARCHAR(100) NULL,
    google_id VARCHAR,
    profile_picture TEXT
);

CREATE TABLE Administrator(
    id SERIAL PRIMARY KEY,
    username TEXT UNIQUE NOT NULL,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    remember_token VARCHAR(100) NULL
);

CREATE TABLE Buyer (
    id INT PRIMARY KEY REFERENCES Users(id) ON UPDATE CASCADE,
    NIF TEXT,
    birth_date DATE NOT NULL CHECK(birth_date <= CURRENT_DATE),
    coins INT NOT NULL CHECK(coins >= 0) DEFAULT 0
);

CREATE TABLE Seller(
    id INT PRIMARY KEY REFERENCES Users(id) ON UPDATE CASCADE
);

CREATE TABLE PasswordReset (
    email TEXT NOT NULL,
    token TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL,
    PRIMARY KEY (email)
);

CREATE TABLE Age (
    id SERIAL PRIMARY KEY,
    minimum_age INT NOT NULL,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    image_path TEXT NOT NULL
);

CREATE TABLE Game(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    price FLOAT NOT NULL CHECK(price > 0.0),
    overall_rating INT NOT NULL CHECK(overall_rating >= 0 AND overall_rating <= 100) DEFAULT 0,
    positive_reviews INT NOT NULL CHECK(positive_reviews >= 0) DEFAULT 0,
    negative_reviews INT NOT NULL CHECK(negative_reviews >= 0) DEFAULT 0,
    owner INT NOT NULL REFERENCES Seller(id) ON UPDATE CASCADE,
    is_active BOOLEAN DEFAULT TRUE,
    block_reason TEXT,
    block_time TIMESTAMP,
    release_date DATE CHECK(release_date <= CURRENT_DATE),
    age_id INT NOT NULL REFERENCES Age(id) ON UPDATE CASCADE,
    thumbnail_small_path TEXT,
    thumbnail_large_path TEXT
);

CREATE TABLE CDK(
    id SERIAL PRIMARY KEY,
    code TEXT UNIQUE NOT NULL,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE
);

CREATE TABLE Platform(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE Category(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE Language(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE Player(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE GamePlatform(
    id SERIAL PRIMARY KEY,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE,
    platform INT NOT NULL REFERENCES Platform(id) ON UPDATE CASCADE,
    CONSTRAINT game_platform_pair_unique UNIQUE (game,platform)
);

CREATE TABLE GameCategory(
    id SERIAL PRIMARY KEY,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE,
    category INT NOT NULL REFERENCES Category(id) ON UPDATE CASCADE,
    CONSTRAINT game_category_pair_unique UNIQUE (game,category)
);

CREATE TABLE GameLanguage(
    id SERIAL PRIMARY KEY,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE,
    language INT NOT NULL REFERENCES Language(id) ON UPDATE CASCADE,
    CONSTRAINT game_language_pair_unique UNIQUE (game,language)
);

CREATE TABLE GamePlayer(
    id SERIAL PRIMARY KEY,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE,
    player INT NOT NULL REFERENCES Player(id) ON UPDATE CASCADE,
    CONSTRAINT game_player_pair_unique UNIQUE (game,player)
);

CREATE TABLE GameMedia(
    id SERIAL PRIMARY KEY,
    path TEXT NOT NULL,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE
);

CREATE TABLE Wishlist(
    id SERIAL PRIMARY KEY,
    buyer INT NOT NULL REFERENCES Buyer(id) ON UPDATE CASCADE,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE,
    CONSTRAINT buyer_game_pair_unique UNIQUE (buyer, game)
);

CREATE TABLE ShoppingCart(
    id SERIAL PRIMARY KEY,
    quantity INT NOT NULL CHECK (quantity >= 0) DEFAULT 0,
    buyer INT NOT NULL REFERENCES Buyer(id) ON UPDATE CASCADE,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE,
    CONSTRAINT buyer_game_pair_2_unique UNIQUE (buyer, game)
);

CREATE TABLE PaymentMethod(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    image_path TEXT NOT NULL
);

CREATE TABLE Payment(
    id SERIAL PRIMARY KEY,
    method INT NOT NULL REFERENCES PaymentMethod(id) ON UPDATE CASCADE,
    value FLOAT NOT NULL CHECK(value >= 0.0)
);

CREATE TABLE Orders(
    id SERIAL PRIMARY KEY,
    buyer INT NOT NULL REFERENCES Buyer(id) ON UPDATE CASCADE,
    payment INT NOT NULL UNIQUE REFERENCES Payment(id) ON UPDATE CASCADE,
    time TIMESTAMP NOT NULL CHECK (time <= CURRENT_TIMESTAMP) DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT buyer_time_pair_unique UNIQUE (buyer, time)
);

CREATE TABLE Purchase(
    id SERIAL PRIMARY KEY,
    value FLOAT NOT NULL CHECK(value >= 0.0),
    order_ INT NOT NULL REFERENCES Orders(id) ON UPDATE CASCADE,
    coins INT NOT NULL CHECK(coins >= 0) DEFAULT 0
);

CREATE TABLE PrePurchase(
    id INT PRIMARY KEY REFERENCES Purchase(id) ON UPDATE CASCADE,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE
);

CREATE TABLE CanceledPurchase(
    id INT PRIMARY KEY REFERENCES Purchase(id) ON UPDATE CASCADE,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE
);

CREATE TABLE DeliveredPurchase(
    id INT PRIMARY KEY REFERENCES Purchase(id) ON UPDATE CASCADE,
    cdk INT UNIQUE NOT NULL REFERENCES CDK(id) ON UPDATE CASCADE
);

CREATE TABLE Review(
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    positive BOOLEAN NOT NULL,
    author INT NOT NULL REFERENCES Buyer(id) ON UPDATE CASCADE,
    game INT NOT NULL REFERENCES Game(id) ON UPDATE CASCADE,
    CONSTRAINT author_game_pair_unique UNIQUE (author, game)
);

CREATE TABLE ReviewLike(
    id SERIAL PRIMARY KEY,
    review INT NOT NULL REFERENCES Review(id) ON UPDATE CASCADE,
    author INT NOT NULL REFERENCES Buyer(id) ON UPDATE CASCADE,
    CONSTRAINT review_author_pair_unique UNIQUE (review, author)
);

CREATE TABLE Notifications(
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    time TIMESTAMP NOT NULL CHECK (time <= CURRENT_TIMESTAMP) DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE NotificationWishlist(
    id INT PRIMARY KEY REFERENCES Notifications(id) ON DELETE CASCADE ON UPDATE CASCADE,
    wishlist INT REFERENCES Wishlist(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE NotificationShoppingCart(
    id INT PRIMARY KEY REFERENCES Notifications(id) ON DELETE CASCADE ON UPDATE CASCADE,
    shopping_cart INT REFERENCES ShoppingCart(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE NotificationGame(
    id INT PRIMARY KEY REFERENCES Notifications(id) ON DELETE CASCADE ON UPDATE CASCADE,
    game INT REFERENCES Game(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE NotificationOrder(
    id INT PRIMARY KEY REFERENCES Notifications(id) ON DELETE CASCADE ON UPDATE CASCADE,
    order_ INT NOT NULL REFERENCES Orders(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE NotificationReview(
    id INT PRIMARY KEY REFERENCES Notifications(id) ON DELETE CASCADE ON UPDATE CASCADE,
    review INT REFERENCES Review(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Reason(
    id SERIAL PRIMARY KEY,
    description TEXT NOT NULL
);

CREATE TABLE Report(
    id SERIAL PRIMARY KEY,
    buyer INT NOT NULL REFERENCES Buyer(id) ON UPDATE CASCADE,
    review INT NOT NULL REFERENCES Review(id) ON UPDATE CASCADE,
    reason INT REFERENCES Reason(id) ON UPDATE CASCADE,
    description TEXT,
    CONSTRAINT reason_or_description_not_null CHECK (reason IS NOT NULL OR description IS NOT NULL)
);

CREATE TABLE FAQ(
    id SERIAL PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL
);

CREATE TABLE About(
    id SERIAL PRIMARY KEY,
    content TEXT NOT NULL
);

CREATE TABLE Contacts(
    id SERIAL PRIMARY KEY,
    contact TEXT NOT NULL
);


ALTER TABLE Game
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION game_search_update() RETURNS TRIGGER AS $$
DECLARE
    owner_name TEXT;
BEGIN
    SELECT u.name INTO owner_name
    FROM Seller s
    JOIN Users u ON s.id = u.id
    WHERE s.id = NEW.owner;

    -- Update tsvectors
    NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.name), 'A') ||
        setweight(to_tsvector('english', NEW.description), 'B') ||
        setweight(to_tsvector('english', COALESCE(owner_name, '')), 'C')
    );

    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER game_search_update
    BEFORE INSERT OR UPDATE ON Game
    FOR EACH ROW
    EXECUTE FUNCTION game_search_update();

CREATE INDEX search_idx ON game USING GIN (tsvectors); 