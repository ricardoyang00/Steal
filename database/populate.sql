SET search_path TO lbaw2435;

-- POPULATE DATABASE
-- USERS
insert into Users (username, name, email, password, is_active, is_blocked, profile_picture) values 
('buyer1', 'Buyer One', 'buyer1@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('buyer2', 'Buyer Two', 'buyer2@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('buyer3', 'Buyer Three', 'buyer3@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('buyer4', 'Buyer Four', 'buyer4@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('buyer5', 'Buyer Five', 'buyer5@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('buyer6', 'Buyer Six', 'buyer6@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('buyer7', 'Buyer Seven', 'buyer7@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('buyer8', 'Buyer Eight', 'buyer8@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('buyer9', 'Buyer Nine', 'buyer9@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('buyer10', 'Buyer Ten', 'buyer10@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller1', 'Nintendo', 'seller1@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller2', 'Sony', 'seller2@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller3', 'Microsoft', 'seller3@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller4', 'Ubisoft', 'seller4@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller5', 'Electronic Arts', 'seller5@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller6', 'Activision', 'seller6@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller7', 'Square Enix', 'seller7@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller8', 'Capcom', 'seller8@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller9', 'Bethesda', 'seller9@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller10', 'Rockstar Games', 'seller10@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, false, 'images/profile_pictures/default-profile-picture.png'),
('seller11', 'Blizzard Entertainment', 'seller11@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', true, true, 'images/profile_pictures/default-profile-picture.png'),
('seller12', 'Bandai Namco', 'seller12@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrLWy9Sj/W', true, true, 'images/profile_pictures/default-profile-picture.png'),
('Anonymous23', 'Anonymous', 'anonymous23mail', 'anonymous', false, false, null),
('buyer12', 'Buyer Twelve', 'buyer12@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrLWy9Sj/W', true, true, 'images/profile_pictures/default-profile-picture.png'),
('buyer13', 'Buyer Thirteen', 'buyer13@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrLWy9Sj/W', true, true, 'images/profile_pictures/default-profile-picture.png'),
('buyer14', 'Buyer Fourteen', 'buyer14@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrLWy9Sj/W', true, true, 'images/profile_pictures/default-profile-picture.png'),
('buyer15', 'Buyer Fifteen', 'buyer15@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrLWy9Sj/W', true, true, 'images/profile_pictures/default-profile-picture.png'),
('buyer16', 'Buyer Sixteen', 'buyer16@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrLWy9Sj/W', true, true, 'images/profile_pictures/default-profile-picture.png'),
('buyer17', 'Buyer Seventeen', 'buyer17@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrLWy9Sj/W', true, true, 'images/profile_pictures/default-profile-picture.png');


-- ADMINISTRATOR
insert into Administrator (username, name, email, password) values ('admin', 'Admin John', 'admin@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W');
insert into Administrator (username, name, email, password) values ('sbeckson1', 'Saxon Beckson', 'sbeckson1@feedburner.com', '$2a$04$irfv6UVFd5wJseTyvBFEq.h6KZ6/EGyPuQuIMC.BvJCNYAyL5naqq');
insert into Administrator (username, name, email, password) values ('apeffer2', 'Allix Peffer', 'apeffer2@nba.com', '$2a$04$DDqwRdaW5YbhOtfCzLWCVe2nxXZ5IQFD1eVE/UD1cZxNfe9Ouud9y');
insert into Administrator (username, name, email, password) values ('ebaird3', 'Ely Baird', 'ebaird3@canalblog.com', '$2a$04$w2f140crfq6RhNHkSPbysOTuJbvVUbZxvH6kxGzXeWOcdJdfVYZGG');
insert into Administrator (username, name, email, password) values ('jbarnewell4', 'Jameson Barnewell', 'jbarnewell4@patch.com', '$2a$04$KjrRrmujzf5AnIWXNVxql.F.J1U1abkHGxV51MwwgbTBF99zg0d/a');


-- BUYER
insert into Buyer (id, nif, birth_date, coins) values (1, 204514179, '1962-06-28', 3075);
insert into Buyer (id, nif, birth_date, coins) values (2, 202847662, '1996-10-12', 750);
insert into Buyer (id, nif, birth_date, coins) values (3, 263252425, '1985-11-05', 750);
insert into Buyer (id, nif, birth_date, coins) values (4, 209296387, '1974-06-09', 750);
insert into Buyer (id, nif, birth_date, coins) values (5, 235322905, '1962-06-01', 600);
insert into Buyer (id, nif, birth_date, coins) values (6, 237686039, '1978-02-19', 675);
insert into Buyer (id, nif, birth_date, coins) values (7, 258088894, '1958-07-06', 700);
insert into Buyer (id, nif, birth_date, coins) values (8, 244749380, '1951-07-27', 725);
insert into Buyer (id, nif, birth_date, coins) values (9, 277064361, '1987-06-09', 625);
insert into Buyer (id, nif, birth_date, coins) values (10, 255313470, '1990-05-17', 500);
insert into Buyer (id, nif, birth_date, coins) values (23, 255311273, '1990-05-17', 500);
insert into Buyer (id, nif, birth_date, coins) values (24, 255571273, '1990-05-17', 500);
insert into Buyer (id, nif, birth_date, coins) values (25, 255411273, '1990-05-17', 500);
insert into Buyer (id, nif, birth_date, coins) values (26, 241311273, '1990-05-17', 500);
insert into Buyer (id, nif, birth_date, coins) values (27, 242311273, '1990-05-17', 500);
insert into Buyer (id, nif, birth_date, coins) values (28, 242311273, '1990-05-17', 500);
insert into Buyer (id, nif, birth_date, coins) values (29, 242311273, '1990-05-17', 500);


-- SELLER
insert into Seller (id) values (11);
insert into Seller (id) values (12);
insert into Seller (id) values (13);
insert into Seller (id) values (14);
insert into Seller (id) values (15);
insert into Seller (id) values (16);
insert into Seller (id) values (17);
insert into Seller (id) values (18);
insert into Seller (id) values (19);
insert into Seller (id) values (20);
insert into Seller (id) values (21);
insert into Seller (id) values (22);

-- AGE
insert into Age (minimum_age, name, description, image_path) values (0, 'PEGI 3', 'Suitable for all ages. Contains no violence, inappropriate language, or anything that could scare or harm young children. However, PEGI does recommend parental guidance for children under 3 years old, as the minimum age officially starts at 3. So while there’s no real restriction, the "PEGI 3" label still suggests an age starting point.', 'images/age/PEGI_3.svg');
insert into Age (minimum_age, name, description, image_path) values (7, 'PEGI 7', 'May include mild violence or scenes and sounds that could be slightly scary for younger children. Typically suitable for children aged 7 and older.', 'images/age/PEGI_7.svg');
insert into Age (minimum_age, name, description, image_path) values (12, 'PEGI 12', 'Includes more realistic violence against fantasy characters or humans, mild swearing, or suggestive themes such as romance or mild danger. Suitable for players aged 12 and older.', 'images/age/PEGI_12.svg');
insert into Age (minimum_age, name, description, image_path) values (16, 'PEGI 16', 'Features more explicit violence or sexual activity, strong language, or the depiction of alcohol, tobacco, or drugs. Suitable for players aged 16 and older.', 'images/age/PEGI_16.svg');
insert into Age (minimum_age, name, description, image_path) values (18, 'PEGI 18', 'Contains extreme violence, explicit sexual content, glamorization of drugs, or very offensive language. Suitable only for adults aged 18 and older.', 'images/age/PEGI_18.svg');

-- GAME
INSERT INTO Game (name, description, price, overall_rating, owner, is_active, block_reason, block_time, release_date, age_id) VALUES
-- Total 60 Games
-- Seller 1
('A Epic Odyssey', 'An immersive adventure game with stunning visuals.', 49.99, 0, 11, TRUE, NULL, NULL, '2024-03-15', 3),
('Galactic Blitz', 'A fast-paced sci-fi shooter set in a dystopian universe.', 34.99, 0, 11, TRUE, NULL, NULL, '2024-05-20', 4),
('Haunted Secrets', 'Solve challenging puzzles in a haunted mansion.', 19.99, 0, 11, TRUE, NULL, NULL, '2024-07-10', 2),
('Legend of Heroes', 'A captivating role-playing game with unique characters.', 59.99, 0, 11, TRUE, NULL, NULL, '2024-09-05', 5),
('Night Riders', 'High-speed street racing with realistic physics.', 39.99, 0, 11, TRUE, NULL, NULL, '2024-11-22', 3),

-- Seller 2
('Space Crusade', 'A journey through space fighting alien invasions.', 44.99, 0, 12, TRUE, NULL, NULL, '2024-02-20', 3),
('Cryptic Quest', 'Uncover mysteries in a dark and enigmatic world.', 24.99, 0, 12, TRUE, NULL, NULL, '2024-06-11', 2),
('Steel Horizon', 'Navigate a post-apocalyptic wasteland to survive.', 34.99, 0, 12, TRUE, NULL, NULL, '2024-09-15', 4),
('Solaris Rising', 'Explore a vibrant galaxy with endless possibilities.', 49.99, 0, 12, TRUE, NULL, NULL, '2024-11-05', 5),
('Chaos Circuit', 'Battle robots in a high-tech arena.', 39.99, 0, 12, TRUE, NULL, NULL, '2024-12-12', 4),

-- Seller 3
('Phantom Realms', 'A dark fantasy RPG set in a shattered world.', 54.99, 0, 13, TRUE, NULL, NULL, '2023-01-20', 5),
('Wasteland Chronicles', 'Survive in a barzxren and dangerous world.', 44.99, 0, 13, TRUE, NULL, NULL, '2023-03-11', 3),
('Shadow Siege', 'Fight off hordes of enemies in a strategic shooter.', 29.99, 0, 13, TRUE, NULL, NULL, '2023-05-27', 4),
('Puzzle Haven', 'Solve relaxing puzzles in a magical setting.', 19.99, 0, 13, TRUE, NULL, NULL, '2023-08-18', 2),
('Cyber Rebellion', 'Rebel against the system in a cyberpunk future.', 49.99, 0, 13, TRUE, NULL, NULL, '2023-10-10', 3),

-- Seller 4
('Titan Conquest', 'Lead your army to victory in massive battles.', 39.99, 0, 14, TRUE, NULL, NULL, '2023-02-15', 1),
('Neon Drift', 'Race through a neon-lit city in high-performance cars.', 29.99, 0, 14, TRUE, NULL, NULL, '2023-04-25', 3),
('Mystic Valley', 'Explore a hidden valley filled with ancient secrets.', 49.99, 0, 14, TRUE, NULL, NULL, '2024-06-30', 5),
('Dragon Ascent', 'Ride dragons and battle mythical creatures.', 59.99, 0, 14, TRUE, NULL, NULL, '2024-09-01', 4),
('Frozen Legacy', 'Survive a harsh winter in a desolate land.', 24.99, 0, 14, TRUE, NULL, NULL, '2024-12-10', 2),

-- Seller 5
('Inferno Tactics', 'A strategy game set in a fiery underworld.', 39.99, 0, 15, TRUE, NULL, NULL, '2024-01-18', 4),
('Arcane Arena', 'Compete in a magical dueling tournament.', 34.99, 0, 15, TRUE, NULL, NULL, '2024-03-22', 2),
('Blazing Trails', 'Embark on a daring journey across the wild.', 44.99, 0, 15, TRUE, NULL, NULL, '2024-05-15', 3),
('Stellar Voyage', 'Pilot a spaceship and explore distant planets.', 54.99, 0, 15, TRUE, NULL, NULL, '2024-08-10', 5),
('Iron Bastion', 'Defend your fortress from invading armies.', 29.99, 0, 15, TRUE, NULL, NULL, '2024-11-03', 1),

-- Seller 6
('Zombie Rising', 'Survive waves of the undead in a horror-filled town.', 24.99, 0, 16, TRUE, NULL, NULL, '2023-02-14', 4),
('Galaxy Builders', 'Construct and manage a sprawling intergalactic empire.', 49.99, 0, 16, TRUE, NULL, NULL, '2024-05-30', 5),
('Echoes of War', 'Relive epic battles from a distant past.', 34.99, 0, 16, TRUE, NULL, NULL, '2023-07-15', 1),
('Tranquil Tiles', 'Solve serene puzzles to unwind.', 14.99, 0, 16, TRUE, NULL, NULL, '2023-10-21', 2),
('Virtual Metropolis', 'Build and manage a futuristic city.', 54.99, 0, 16, TRUE, NULL, NULL, '2023-12-05', 3),

-- Seller 7
('Eternal Quest', 'A magical journey to save a kingdom from darkness.', 59.99, 0, 17, TRUE, NULL, NULL, '2024-01-12', 5),
('Ocean Abyss', 'Explore the secrets of the deep sea.', 29.99, 0, 17, TRUE, NULL, NULL, '2024-03-05', 3),
('Skyward Journey', 'Embark on an aerial adventure across floating islands.', 49.99, 0, 17, TRUE, NULL, NULL, '2024-05-19', 4),
('Forgotten Sands', 'Survive in a harsh desert environment.', 34.99, 0, 17, TRUE, NULL, NULL, '2024-07-24', 2),
('Ironclad Warriors', 'Command a fleet in naval warfare.', 44.99, 0, 17, TRUE, NULL, NULL, '2024-09-30', 1),

-- Seller 8
('Dark Dominion', 'Unleash power and conquer a fantasy realm.', 49.99, 0, 18, TRUE, NULL, NULL, '2024-02-14', 4),
('Neon Storm', 'Fight through cyberpunk cityscapes.', 39.99, 0, 18, TRUE, NULL, NULL, '2024-04-18', 3),
('Shadowline', 'A stealth-based action game in a sprawling city.', 29.99, 0, 18, TRUE, NULL, NULL, '2024-06-22', 2),
('Crimson Throne', 'Claim the throne in a medieval war simulator.', 54.99, 0, 18, TRUE, NULL, NULL, '2024-08-17', 5),
('Element Clash', 'Battle foes using elemental powers.', 34.99, 0, 18, TRUE, NULL, NULL, '2024-10-10', 3),

-- Seller 9
('Voidwalker', 'Traverse dimensions in this mind-bending platformer.', 44.99, 0, 19, TRUE, NULL, NULL, '2024-01-20', 4),
('Frostbound', 'Explore a frozen wasteland in search of survivors.', 39.99, 0, 19, TRUE, NULL, NULL, '2024-03-25', 2),
('Star Forge', 'Build and expand your interstellar empire.', 49.99, 0, 19, TRUE, NULL, NULL, '2024-05-15', 5),
('Hidden Realms', 'Uncover hidden treasures in ancient ruins.', 24.99, 0, 19, TRUE, NULL, NULL, '2024-07-07', 1),
('Battle Circuit', 'Test your skills in this fast-paced arena fighter.', 34.99, 0, 19, TRUE, NULL, NULL, '2024-09-12', 3),

-- Seller 10
('Primordial Rift', 'Unite factions in a land torn by magic.', 54.99, 0, 20, TRUE, NULL, NULL, '2024-02-01', 5), -- no thumbnails
('Pixel Racers', 'Fast-paced arcade-style racing action.', 29.99, 0, 20, TRUE, NULL, NULL, '2024-04-10', 1), -- no thumbnails
('Chrono Legacy', 'Time-traveling RPG with dynamic storytelling.', 49.99, 0, 20, TRUE, NULL, NULL, '2024-06-05', 4),
('Rogue Marauder', 'Engage in thrilling heists across the galaxy.', 39.99, 0, 20, TRUE, NULL, NULL, '2024-08-23', 3), -- no thumbnails
('Hollow Depths', 'Dive into a mysterious underground labyrinth.', 24.99, 0, 20, TRUE, NULL, NULL, '2024-11-02', 2), -- no thumbnails

-- Seller 11 (Blocked)
('Ancient Prophecy', 'Solve mysteries in a world of ancient gods.', 39.99, 0, 21, FALSE, 'Blocked due to incorrect product description and missing key details', '2024-05-01 10:15:00', '2024-03-14', 5),
('Turbo Clash', 'Experience the thrill of high-speed combat.', 29.99, 0, 21, FALSE, 'Blocked due to invalid CDK codes provided', '2024-06-01 12:30:00', '2024-05-11', 3),
('Crystal Shores', 'Explore a breathtaking tropical paradise.', 44.99, 0, 21, FALSE, 'Blocked due to price mismatch and unauthorized distribution', '2024-08-01 09:45:00', '2024-07-29', 4),
('Iron Rebellion', 'Reclaim your homeland in a mech-filled future.', 59.99, 0, 21, FALSE, 'Blocked due to expired distribution agreement with the publisher', '2024-10-01 14:00:00', '2024-09-25', 1),
('Nightfall Siege', 'Defend your base from nightly invasions.', 34.99, 0, 21, FALSE, 'Blocked due to missing or invalid regional license', '2024-12-15 08:30:00', '2024-12-12', 2),

-- Seller 12 (Blocked)
('Skyforge Arena', 'Compete in a battle royale set in the clouds.', 44.99, 0, 22, FALSE, 'Blocked due to invalid CDK activation region mismatch', '2024-02-01 11:00:00', '2024-01-18', 3),
('Eclipse Bound', 'Save the world from eternal darkness.', 54.99, 0, 22, FALSE, 'Blocked due to missing key codes from the supplier', '2024-04-01 16:45:00', '2024-03-21', 5),
('Circuit Breaker', 'Solve complex puzzles with futuristic tech.', 34.99, 0, 22, FALSE, 'Blocked due to outdated product listing and pricing errors', '2024-06-01 13:25:00', '2024-05-08', 2),
('Cinderfall', 'Fight through a land covered in volcanic ash.', 39.99, 0, 22, FALSE, 'Blocked due to unauthorized product code distribution', '2024-09-01 17:20:00', '2024-07-16', 4),
('Astro Nexus', 'Build alliances in a multiplayer space sim.', 49.99, 0, 22, FALSE, 'Blocked due to invalid or missing activation keys from distributor', '2024-11-01 20:10:00', '2024-10-04', 1);


-- Game Ratings
UPDATE Game
SET overall_rating = 93.33,
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_1.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_1.jpg'
WHERE id = 1;

UPDATE Game
SET overall_rating = 0,
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_2.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_2.png'
WHERE id = 2;

UPDATE Game
SET overall_rating = 50,
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_3.png',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_3.jpg'
WHERE id = 3;

UPDATE Game
SET overall_rating = 100,
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_4.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_4.jpg'
WHERE id = 4;

UPDATE Game
SET overall_rating = 0,
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_5.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_5.jpg'
WHERE id = 5;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_6.png',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_6.jpg'
WHERE id = 6;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_7.jpeg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_7.jpg'
WHERE id = 7;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_8.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_8.jpg'
WHERE id = 8;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_9.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_9.jpg'
WHERE id = 9;

UPDATE Game
SET overall_rating = 100,
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_10.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_10.jpg'
WHERE id = 10;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_11.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_11.jpg'
WHERE id = 11;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_12.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_12.jpg'
WHERE id = 12;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_13.jpeg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_13.jpeg'
WHERE id = 13;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_14.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_14.jpg'
WHERE id = 14;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_15.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_15.jpg'
WHERE id = 15;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_16.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_16.jpg'
WHERE id = 16;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_17.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_17.jpg'
WHERE id = 17;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_18.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_18.jpg'
WHERE id = 18;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_19.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_19.jpg'
WHERE id = 19;

UPDATE Game
SET overall_rating = 66.67,
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_20.jpeg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_20.png'
WHERE id = 20;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_21.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_21.jpg'
WHERE id = 21;

UPDATE Game
SET 
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_22.jpeg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_22.png'
WHERE id = 22;

UPDATE Game
SET 
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_23.jpeg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_23.jpg'
WHERE id = 23;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_24.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_24.jpg'
WHERE id = 24;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_25.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_25.jpg'
WHERE id = 25;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_26.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_26.jpg'
WHERE id = 26;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_27.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_27.jpg'
WHERE id = 27;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_28.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_28.jpg'
WHERE id = 28;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_29.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_29.jpg'
WHERE id = 29;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_30.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_30.jpg'
WHERE id = 30;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_31.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_31.jpg'
WHERE id = 31;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_32.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_32.jpg'
WHERE id = 32;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_33.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_33.jpg'
WHERE id = 33;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_34.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_34.jpg'
WHERE id = 34;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_35.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_35.jpg'
WHERE id = 35;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_36.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_36.jpg'
WHERE id = 36;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_37.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_37.jpg'
WHERE id = 37;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_38.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_38.jpg'
WHERE id = 38;

UPDATE Game
SET 
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_39.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_39.jpg'
WHERE id = 39;

UPDATE Game
SET 
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_40.jpg'
WHERE id = 40;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_41.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_41.jpg'
WHERE id = 41;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_42.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_42.jpg'
WHERE id = 42;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_43.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_43.jpg'
WHERE id = 43;

UPDATE Game
SET
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_44.jpg',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_44.jpg'
WHERE id = 44;

UPDATE Game
SET 
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_45.png',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_45.jpg'
WHERE id = 45;

UPDATE Game
SET 
thumbnail_small_path = 'images/thumbnail_small/thumbnail_s_48.png',
thumbnail_large_path = 'images/thumbnail_large/thumbnail_l_48.jpg'
WHERE id = 48;


-- GAME MEDIA
insert into GameMedia (game, path) values (1, 'images/gamemedia/extra_1_1.jpg');
insert into GameMedia (game, path) values (1, 'images/gamemedia/extra_1_2.jpg');
insert into GameMedia (game, path) values (1, 'images/gamemedia/extra_1_3.jpg');
insert into GameMedia (game, path) values (2, 'images/gamemedia/extra_2_1.jpg');
insert into GameMedia (game, path) values (2, 'images/gamemedia/extra_2_2.png');
insert into GameMedia (game, path) values (2, 'images/gamemedia/extra_2_3.jpg');
insert into GameMedia (game, path) values (2, 'images/gamemedia/extra_2_4.jpg');
insert into GameMedia (game, path) values (20, 'images/gamemedia/extra_20_1.jpg');
insert into GameMedia (game, path) values (20, 'images/gamemedia/extra_20_2.png');
insert into GameMedia (game, path) values (22, 'images/gamemedia/extra_22_1.jpg');
insert into GameMedia (game, path) values (22, 'images/gamemedia/extra_22_2.jpeg');
insert into GameMedia (game, path) values (23, 'images/gamemedia/extra_23_1.jpg');
insert into GameMedia (game, path) values (23, 'images/gamemedia/extra_23_2.jpg');
insert into GameMedia (game, path) values (45, 'images/gamemedia/extra_45_1.jpg');
insert into GameMedia (game, path) values (45, 'images/gamemedia/extra_45_2.png');
insert into GameMedia (game, path) values (45, 'images/gamemedia/extra_45_3.jpg');
insert into GameMedia (game, path) values (48, 'images/gamemedia/extra_48_1.jpg');
insert into GameMedia (game, path) values (48, 'images/gamemedia/extra_48_2.jpg');

INSERT INTO GameMedia (game, path) VALUES (1, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (1, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (1, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (1, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (1, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (2, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (2, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (2, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (2, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (2, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (3, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (3, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (3, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (3, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (3, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (4, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (4, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (4, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (4, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (4, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (5, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (5, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (5, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (5, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (5, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (6, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (6, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (6, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (6, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (6, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (7, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (7, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (7, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (7, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (7, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (8, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (8, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (8, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (8, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (8, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (9, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (9, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (9, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (9, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (9, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (10, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (10, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (10, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (10, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (10, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (11, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (11, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (11, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (11, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (11, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (12, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (12, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (12, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (12, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (12, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (13, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (13, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (13, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (13, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (13, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (14, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (14, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (14, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (14, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (14, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (15, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (15, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (15, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (15, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (15, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (16, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (16, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (16, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (16, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (16, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (17, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (17, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (17, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (17, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (17, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (18, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (18, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (18, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (18, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (18, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (19, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (19, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (19, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (19, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (19, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (20, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (20, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (20, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (20, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (20, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (21, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (21, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (21, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (21, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (21, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (22, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (22, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (22, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (22, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (22, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (23, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (23, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (23, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (23, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (23, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (24, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (24, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (24, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (24, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (24, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (25, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (25, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (25, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (25, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (25, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (26, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (26, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (26, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (26, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (26, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (27, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (27, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (27, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (27, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (27, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (28, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (28, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (28, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (28, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (28, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (29, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (29, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (29, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (29, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (29, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (30, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (30, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (30, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (30, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (30, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (31, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (31, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (31, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (31, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (31, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (32, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (32, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (32, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (32, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (32, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (33, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (33, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (33, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (33, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (33, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (34, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (34, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (34, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (34, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (34, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (35, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (35, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (35, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (35, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (35, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (36, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (36, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (36, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (36, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (36, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (37, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (37, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (37, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (37, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (37, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (38, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (38, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (38, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (38, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (38, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (39, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (39, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (39, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (39, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (39, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (40, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (40, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (40, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (40, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (40, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (41, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (41, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (41, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (41, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (41, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (42, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (42, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (42, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (42, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (42, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (43, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (43, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (43, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (43, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (43, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (44, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (44, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (44, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (44, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (44, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (45, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (45, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (45, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (45, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (45, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (46, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (46, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (46, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (46, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (46, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (47, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (47, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (47, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (47, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (47, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (48, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (48, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (48, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (48, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (48, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (49, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (49, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (49, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (49, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (49, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (50, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (50, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (50, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (50, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (50, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (51, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (51, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (51, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (51, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (51, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (52, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (52, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (52, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (52, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (52, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (53, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (53, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (53, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (53, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (53, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (54, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (54, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (54, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (54, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (54, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (55, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (55, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (55, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (55, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (55, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (56, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (56, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (56, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (56, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (56, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (57, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (57, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (57, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (57, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (57, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (58, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (58, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (58, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (58, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (58, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (59, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (59, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (59, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (59, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (59, 'images/gamemedia/extra_all_5.jpg');
INSERT INTO GameMedia (game, path) VALUES (60, 'images/gamemedia/extra_all_1.jpg');
INSERT INTO GameMedia (game, path) VALUES (60, 'images/gamemedia/extra_all_2.jpg');
INSERT INTO GameMedia (game, path) VALUES (60, 'images/gamemedia/extra_all_3.jpg');
INSERT INTO GameMedia (game, path) VALUES (60, 'images/gamemedia/extra_all_4.jpg');
INSERT INTO GameMedia (game, path) VALUES (60, 'images/gamemedia/extra_all_5.jpg');


-- CDK
INSERT INTO CDK (code, game) VALUES
-- 10 codes per game
-- Game 1 (20)
('ZWTWQRAKXBV1JHLATPXKV112II', 1), -- sold
('S32MXSVQRDSNXN79E76S01HVFD', 1), -- sold
('DPWQ13S5XFPARMA0VEOU2IA4MN', 1), -- sold
('N95JKOMMBIA3PV5SIWJB9NRE66', 1), -- sold
('ANKBBME5P2BIMKU672L3VT7Q5D', 1), -- sold
('PTPQ2KZY7DPNWCKYLIK22ZEFP6', 1), -- sold
('Q7E5LV40X8CYJ3PSC5OZG2KS3L', 1), -- sold
('R4XMASJLXMU1AIRHZJ1O9D4YF1', 1), -- sold
('UO2W51HKCP5A7QMOJ4PLVEW0AM', 1), -- sold
('QWO8FK8GBDEJC3X89COZCIAJFH', 1), -- sold (10)
('AWO8FK8GBDEJC3X89COZCIAJFH', 1),
('BWO8FK8GBDEJC3X89COZCIAJFH', 1),
('CWO8FK8GBDEJC3X89COZCIAJFH', 1),
('DWO8FK8GBDEJC3X89COZCIAJFH', 1),
('EWO8FK8GBDEJC3X89COZCIAJFH', 1),
('FWO8FK8GBDEJC3X89COZCIAJFH', 1),
('GWO8FK8GBDEJC3X89COZCIAJFH', 1),
('HWO8FK8GBDEJC3X89COZCIAJFH', 1),
('IWO8FK8GBDEJC3X89COZCIAJFH', 1),
('JWO8FK8GBDEJC3X89COZCIAJFH', 1),
-- Game 2
('9H6JRU7AZ2QRX6TJ7815D9RZGN', 2), -- sold
('7RV6UVGAG8X1PSD9J8V86COK9L', 2), -- sold (22)
('RAMOI9DWYTD3B8YGVENT0O527T', 2),
('QHC5BXL8HLX289GYFLXGFK4LHK', 2),
('HCTIOZ64DTZCISAHK7E44KJK1S', 2),
('8AZN7KC61FSH4E5GB0Q6J0LKWQ', 2),
('P5RWOK8JI0QUOPH7T2R291KYF1', 2),
('AGNMPPXZB8Y9WS8WGKT9KHUU85', 2),
('S57BQ9QZPDHJ1FJGEXN3PHMF75', 2),
('18I8T319HZIH9LEINHBAWRFPZC', 2),
-- Game 3
('4H9UOP8Z8RJ58SZTIUOXIMHU4N', 3), -- sold
('7KF7URMJY37YQ9I1MVSSWNXD3P', 3), -- sold (32)
('X2KFFV38Q0SDSDYLWL03GBXI4N', 3),
('OQ2341NUQUSOQ2QOX5P55JT70J', 3),
('STN1B3XVJ5ROIHD4FV51VILGZW', 3),
('QB8UP0JLNWMR4EJQCLOA68FDWE', 3),
('7NB63U2YQN5GTUDJVD21OEA210', 3),
('E1CFK3LXBYNOZDCGPUBWQ792IW', 3),
('H05UWIJ1QAESA3UM4IDK57B8X7', 3),
('4NZAHH32567Y9J24GWZGJPHT3C', 3),
-- Game 4
('HVS8P3KVRV0P5FLZSI7LV2OVFE', 4),
('KA9QLWPIL3J164OWPCGJ30AILF', 4),
('10XAO28LLJOEECVN2IFY6S9VBG', 4),
('X6412V3WIEMHQ6KCL7Y77MCT9H', 4),
('LPM4CBEHEZ4E2QFJ9ODU6P0GG4', 4),
('S3LCJCVK9XJ4RWEAGN144I3SAS', 4),
('5MWAGASW6CENE62ER44IT0RN0N', 4),
('MCR6AUVXFYHZBKN05MMWFEQ3FG', 4),
('KNBFBWIAM74DRUO9GPC26GR5UH', 4),
('0J1JF21B9X8NBII3H5BLMIPXKB', 4),
-- Game 5
('8QC1K9K9GPLAJMR0WVKE35ZYXQ', 5), -- sold (51)
('YVQFF7KCYCJUYD2QSQ4TT8G3LA', 5),
('V2846CAXWTEEI3X5PD8UZELHI1', 5),
('KHUI1M8EZO978K5BCS5003TDMB', 5),
('SH8KL8PJ5269YNLFRPF5P2COZJ', 5),
('Q81W7IUZSIH3UPD4UMXLTTEHXZ', 5),
('UM26AFU4PSIUJLCNIAM5NJCUOP', 5),
('OUWEQXUHZGTI8ZBQOCG67PBP8M', 5),
('GD5SZX66VSPZKUP7S8UNOSGYLX', 5),
('F8W2E0H3R1MGYZV7N6QX7T060D', 5),
-- Game 6
('7JOXRYQHLOLKGM64OFSV17YA2M', 6),
('QHVZCZ5I5O1U89Y1OCKDJCSYJT', 6),
('BZWFP3GKY746WV2DTBSD5RYVOF', 6),
('98ACWJF0ZMZOEK3H09A8WV3QXC', 6),
('Q52LXTXQPFRM5571MVUTAWCL2H', 6),
('8YWDFL4YW5LANZI9NAA5CEJF6A', 6),
('ICAVTIY5OH80QVAD6Q63QO6GOQ', 6),
('GSDZ7VFEA6RFIHL6CFJEVQEUMK', 6),
('VA5W90JAIE93OGCIQP9ZP38A8Q', 6),
('DDFNDYFKC9VYX50UYD5J7QT0J3', 6),
-- Game 7
('S6DAOIT3FMAWUF3QMNQI20W06Q', 7),
('ES0Z7PDJZZNUBZVO5ZA25MDZE6', 7),
('N3X5IU84BEYY7RX5OILTEK6BDG', 7),
('K3QROPTFOAGDOADF0HRJW41S5M', 7),
('9RIVQU1GGUMBE2MC54Q5CT7Q4A', 7),
('HUSVJ165NVD1P298VCXDZWZY0P', 7),
('CDTZNKGH28J85K5SLWGYC6PWP9', 7),
('12S76N426U5966VYTY1Z6HJ1K2', 7),
('WA25MIPG8EXYYS9FPMHW3BCRBL', 7),
('6HJ09MD6CKP3GIP3IYTIRSC8SZ', 7),
-- Game 8
('GC8K774W667WZH9BRXIE9DZGTF', 8),
('8T0WFJ1UJ8SDG1CVN81AFKZA95', 8),
('XVJ5RV2AA2Q7F6ENQGUBN92SCS', 8),
('DKCINO3YK1DXGH8Z7ZJGSAOFU8', 8),
('KRD0ODYELT4EDFPHYSI2UIKUMI', 8),
('YWMI3OOK2V4PHJXOGK2LLWZS97', 8),
('2MBSQB7C08V308XABHJP9F9I6L', 8),
('V6BTIPQF20LW2DK78UCLFI0OE5', 8),
('R1HIMPSSOAATJVEF7OO23EOSMG', 8),
('MDWX7PB57H6U9VIT3M62R7C3QT', 8),
-- Game 9
('TYF3FW79LYIXXLUP3DTX6RA0PG', 9),
('45VRUAVO5N1FCH004ATJY0IGCS', 9),
('SZ7NK52AR2BR3TVM49PFT8Y6V4', 9),
('WUK9X5Z6ATYWR54QXBXSFMK7PT', 9),
('7HOGNM6O2G496LH5ZTV8NC31F7', 9),
('RFL4SV3KEIRFXCRPOWBJEX3KC9', 9),
('J9M29O07F152ET2E7NXHJ1NT07', 9),
('V4ROVUQ7DNU49Q357FTONCRE7K', 9),
('W2PZ4E120OE0VRACV468A0BWQD', 9),
('JNZ9IMIHDLY91759CSHDE0VKCQ', 9),
-- Game 10
('T2LEWHG70JLNLMSQ8XHNT8KJHD', 10),
('IXHXSBUAYGPRSG01HOE48KHJ8Q', 10),
('KH7IG1XC1FW0RWBTY3A92IT981', 10),
('4I6K4ERVGEUE8GTL3IFWL6OS4D', 10),
('H4XVA1JPB14MO81RAI5DXCRFMZ', 10),
('5ZWM463PSMAW94QUA5RQPBXGRN', 10),
('0NDZJXEDFI6K9RWBPOWCWLTN8V', 10),
('TGPE7B88GUU5NZLPNV6RSLA6QF', 10),
('IN8VA2S4W55NBY3SQXF08V0W5V', 10),
('NZGJPMCP2Q34EIU84EU8SISILZ', 10),
-- Game 11
('GS6M05MBK81E0XHPGS13J434KG', 11),
('JR57ZW0DEZYUOVEPTI6DM5LXHP', 11),
('43J7U524XQKMUXVY9B7SM87ZS1', 11),
('UE5KFZDKTGVNP2CJJ2ZA2QNKAO', 11),
('K01EHBWWC98JRPU9ZPVP0VT4JX', 11),
('QYY701HOTBOB8Q415GNPIECDMA', 11),
('HYCJVTGTCWJSUVCIDHIG1EB5CJ', 11),
('SSDDLBX9PUQNJTXPK89W5R2LOE', 11),
('YQGOAYVOM4DK4JLPVBP9QLWLJV', 11),
('X14KA9E5TL1M5Q7IHYB9BDWLB9', 11),
-- Game 12
('2VTJM41CRDJNOBF4MOI821N9FG', 12),
('EKKVQ9LTGFZL4S8JOP43Q5CKE2', 12),
('QZTCGIIVG4DZ95LCLA8WYWIUYJ', 12),
('GBZUKN5G61CPXQV7YEM7GEE9PM', 12),
('C9CYBYJ7RA7FG351QLF472WSZ7', 12),
('KSG3JJ2BEMOW46X0MZ4Y5NK829', 12),
('EJEDDAJ12EUWOG77VE33LB8MH3', 12),
('DGHAU3Y5EV34HD7TWBQDL1W1FU', 12),
('AF0Y9E53FWS9PAKCJCK9ZMV4N5', 12),
('LWJMS8C4NJVMTI9ZOQYJ9WMETI', 12),
-- Game 13
('Q3MVGN7Y1MAKW7DK34L4IDBF3Y', 13),
('UP2EE82EP4XYI82GIJMM8LEYZD', 13),
('6R6AA20NZT1W1DRXENMPLH08L8', 13),
('FFJL6I5T2PDD6SI1KL6FVMYAMZ', 13),
('3HDO2WJ6Z2XEL3UOZYY3YGLA08', 13),
('DLLOIPZKQOLIJSNYMC2TKHVMPV', 13),
('14XVKHSZYZIF9HL6JZXKKVSBEN', 13),
('GTHEONOX9XVC3SOJTCJVUGHW4J', 13),
('I66HSMVF7YDYPLRHZOA42QPVXG', 13),
('BZFMNLV1NCPYQKNR03DFOPAQJA', 13),
-- Game 14
('26371GN307ESGABU48QPMPNJHP', 14),
('GAAOQEQVPTG4WIALYRZBR04UYU', 14),
('SIMHPPNY9GWHOH1DNZ830Q55LJ', 14),
('OP1M35VUGYI3VN0YN0Y9FXQ4DI', 14),
('CKQGG071AD5R3NTBJ2UZBUI9JO', 14),
('TF3WKB318VTICQDC6MAPWD1ORY', 14),
('AMFNSADG9MOXT3ROC6XVHN1V1H', 14),
('GFUSHIIUQV1KOL2L6GQR2I179G', 14),
('3NYQCVPU4DIHST0OWODPW1YOEX', 14),
('LHMO6V6PMHRBBBY1K3XSNX839B', 14),
-- Game 15
('Z47Z8DAN4VKLAQ9B9GZTWG1HA3', 15),
('2BXJ82WDYUVXM7J7U8LKNSNHQ8', 15),
('M23UFV5X8OSCDSU151QAQF9XM6', 15),
('ANG5IW32EFVEVURULFQC1E5TPH', 15),
('9QZNA9RZNG2KUFBSBE6NJEJF3W', 15),
('R6AWDI5727RX1ACKPBB66IGEIJ', 15),
('QUKSA5DZT3PF4VVDBILD68VI4B', 15),
('YWWP2GJ83ZNTDRF39341B4F388', 15),
('TRTOJ5JYQHEBTRQ9YFUCWOL62B', 15),
('5PJSVZSKKZQ0T9RL5TDTJC0ZXC', 15),
-- Game 16
('7TULI3IKP2VU7ZKQV8O6L06DB4', 16),
('7DF1RPHDUJULWOXYECQQX0325L', 16),
('RRTD0C99SH4FJDKJ4UPJVFVVAI', 16),
('5YEUF5XCJWX79FFN55GY37N68P', 16),
('QSXODM839IQTTINFDM8HGQ8DG0', 16),
('G4VPWFVXVDBGSS2EKGGMQWDZJ5', 16),
('JL5OPDFMJFUHKJQ7G25IB97YUV', 16),
('ERQTZHZGCV14UKKK5AWFQQ1AR8', 16),
('5SAPUA3J7AMIU3MXZ966QWUNIY', 16),
('52G80ZZFP5WMJB76WHMJ7A8X12', 16),
-- Game 17
('A111RELEAPX48S3Q4NAQAJ91UB', 17),
('NO3J1RZF0SMTGTZJDF8MVO66WC', 17),
('0O5S3WYOB6T5PNB8LYYWQR2U2K', 17),
('YQVYKU22RYDQFXDC3W4A5QBWEP', 17),
('876M8J7Y0D17I0NEDNT4YS6EGS', 17),
('N0CV0I8WC1OR3VHH70JAX16OJL', 17),
('0ZY5ZMUP8TBYQCXFBG44INDXKP', 17),
('R02Z2EUOAVAER6209I0655V2EK', 17),
('5I9Y7YONGH9T8QUY0TLPVTM2JQ', 17),
('1IIG8W2H66Q0WMI5Y82W2ML6DF', 17),
-- Game 18
('PCFV24VYLCJSX4K7NTY7JSHCKL', 18),
('X74U7UPXW6CR6KEUIM1GMN389I', 18),
('3WRTR6X3TH2LBH50X1X931ADY7', 18),
('E9ZO67CW8W1Y0CAERF3EQQZMPJ', 18),
('51LD8B9QHHWCZCU9GGH5XTS5YF', 18),
('2M8HPQHADMSJW3DJOC27PL9LLZ', 18),
('ZLL2S97TSXPJP07EXYYQ4NKN44', 18),
('LNXJMVFACLGZAQOZKWGWOVSS3K', 18),
('UCTAVJBWG5ML7T7C7TS0L2I569', 18),
('L6H57G9XMNO8WTH35PVO3HF6B8', 18),
-- Game 19
('SRPYJXY68AGMBS09D1CZ31OUB3', 19),
('NQKD5F2MRV8938HC8ZIHQUNI42', 19),
('P8TTMLS3NX17FW9J0XL9EQU2WN', 19),
('273K8EWZO09MA7LMZX36W1SA4M', 19),
('O9N2ZPSTMMIDKE2WU87HW5VUM5', 19),
('EJN3A4GC22RPTTMYO3LIZ34TO2', 19),
('KS7WXX45GBTP1UPSTRE0OF5MOM', 19),
('75BHJM7MUOX3I9FWMC58WMH7R9', 19),
('AS5PDH5BBTH5J6VJ5U8ECZIFJI', 19),
('OIVNCHWQ500D7AWGWPTUCSTVLG', 19),
-- Game 20
('HUK56ONUJKL0BA702CZDT5L6MP', 20), -- sold (201)
('UNG6LXNAZ92PLXDV3PTN9ZMCM2', 20), -- sold (202)
('LQMNI2LWHUNA0CJ36KNFEFLQXP', 20), -- sold (203)
('MZYGK8Y5V2SUN9Q05BUZPASWUQ', 20), -- sold (204)
('99QNDI266RTLJTW2YFW2UTU8ZM', 20),
('624CGBSC1EW1ENF1IL3LTKMAL4', 20),
('IYMC5J39K7OF8HKFQO0QF8KLBE', 20),
('NUYQXOLY0LY7RNDAD6FDD0F5K6', 20),
('MT99WZNA5HFW1YP8C841JUPPFF', 20),
('MY07VNLASYBQ7VHDEYNZZQ60W1', 20),
-- Game 21
('7SBXGVOVQSOJQVSRNKK4VHQJ6C', 21),
('8NMRYLQBH24I6DP20NECB7BI6L', 21),
('81F9NFKTHOMG3YU7PCMVV5MLBM', 21),
('GMM32BL3KV9LNVC2ZF1O66OPQT', 21),
('VTJPL2I3QL7USK5CPQO8K50TZC', 21),
('0B319TVMTYECCEYHX6REE01HWE', 21),
('KPTMFKROKBIODLVPWW0WD14PZC', 21),
('65VDHE95G8N0HQAUSOV6SQ4BVQ', 21),
('8TU77UHX1SD0IYQFYT2YUTYOR3', 21),
('MXQ6EAPHI93EA5RS6RI6SSS2CN', 21),
-- Game 22
('7SP8MFBXJ57U4UM6OUUYACC7U6', 22),
('5CV1VOSHB95UCDPD9TXL71XP47', 22),
('HUF2VMO73CHWHEETSR1NHAZZCD', 22),
('HQX5OZQWID9F9JE54WSEVD53O5', 22),
('J0SHLHEZXM1VROSIT919ECD5J9', 22),
('KH2MZQ7PXL2E0MGFKSN5HN24RZ', 22),
('1U7YZLLQ164RAVIXRCUG45ED0A', 22),
('E172JCEFTZMORUGG7LNEKRKSPH', 22),
('33TWAI72CLPA0HTHIEJJAM5LPZ', 22),
('8WS5J0BIZC8LM1P65KJMAFWMO5', 22),
-- Game 23
('279S0OMU0SH7RQHPU5PS4XEOCI', 23),
('PMN4TISBMU5LS02Y5D0CE0MYLC', 23),
('SX5F3MQWGAG3V4HYKIBRERK2A6', 23),
('2BZ9XWKKSJVLVMVAPPAXTVFXMC', 23),
('YFN6VCF6X0Q1FJ9VGLWGFPPLQR', 23),
('4MURRJP52CL1JV386T825WYBSA', 23),
('A0R83BOATPEOHK5P631J7HN5PL', 23),
('8HOGUQA4O11FEUNR5C7JMVN9WX', 23),
('27WGF5GOQ4BN4MOSOLPCF1Q26H', 23),
('D1VBCAOOQFA5QHJFG53GFHB3I5', 23),
-- Game 24
('2MCJXZF3LZ3EH612LJ4YPPDOHR', 24),
('00R63AB4YMD9550G2H1XBWNGOW', 24),
('6B2U84CXMFBUQYERAE0JR9VZ8P', 24),
('NX8JU06MWOABBXEQNS905DLQHL', 24),
('6D0N0KQ8BS1TALD7RH8KSSF91N', 24),
('RERD98VT2RRU7LS9Q8O8FBEJ81', 24),
('RZA4V5YEB7FGFZZA57ES1HSE4V', 24),
('RTMXX9WMY3XSHOV29SJ9DZLU6A', 24),
('KN5HMAKNXWT6U0X9C64NBO6QOO', 24),
('9LI0VOKTBBZCVLL0P8NTJPOPVW', 24),
-- Game 25
('V2NCX1TNJ2HBBPCH2T1WIAEJ9C', 25),
('0BUWWJPOHMLQJARQJLNKCDWM0J', 25),
('YSGSBZU0BVN1DML4V4AY1PU2EP', 25),
('PMJZVKI77B8YY2UXUY4S8KT36R', 25),
('T9RS0PKYOHREILVZ2FU4JR160M', 25),
('QM194QIB7QHJ9OSQ2O0BMRXTM1', 25),
('KNLPKYSTX5MEA8NTHVYH3VATWI', 25),
('ODX2ENPISWBWBFHBXUUA73YZ51', 25),
('GJJ3RNTBS1B7Y02SEEKLT4QJOL', 25),
('ZEPYCB3ROUVLX8T22NHSY0KWCT', 25),
-- Game 26
('AJYCO2KAWGC0DMTX1RJPIQF3NZ', 26),
('BDIS3KM37PJWYQIT72OCOZ95AG', 26),
('5IW6GD0LCQOYV0XCPQP2O3CGYK', 26),
('7IRXH3Z9QY1Z24GU20C3R6HQFE', 26),
('3CCH63M2FZWJGOXJWRN785BZFE', 26),
('I8OGZ7C6389U76YPQLZ8IN39V5', 26),
('Q9SWQUIR0JBV4VISVT7YAGG7QA', 26),
('N3L6JYY458XQYHLTR57ZRGVN9U', 26),
('W52NM4T1WLH6RD0EUVKOBL2L1P', 26),
('CNB6KBGCHJGAHC92DAL36240PR', 26),
-- Game 27
('URR3P9LXOBSOIX02I8TKDU9HEP', 27),
('MMT0L8MPN00ASPOIRZF9M5QS1N', 27),
('6J1L93IVL64HJEFDNSZ6H4IR8K', 27),
('P7VK49KS20VW5HS5UJXOKH7J8J', 27),
('41KFY4SUMFC15JJN7LWF4EXDB4', 27),
('FSD9WDWCOXJQZWOMJ7TAMGVE8M', 27),
('P5KQHMS6SJFO6H9WGQ8P0RX94X', 27),
('L1O0TPEDF1OKBGSMOBG16COTOW', 27),
('PM2WNVIJBGDVJR5LR5JGLOP19H', 27),
('1ARDVQR52KRWPGZ1N9S2DYOYPG', 27),
-- Game 28
('XCNRTNEZL10MN179ZRPDG4I25L', 28),
('FC078O8D9GR3N1UU0Y06J7CI04', 28),
('VU35A2KEBQ8Z6ELPZ0EV3XC720', 28),
('FXLI87TTOIT8KLXIU0JEZ6WZSA', 28),
('UWBD95Q4C9YQ0073Y1UPL0FYI5', 28),
('WG8ZY5SNWYGME6W5IX4KKFZ5NP', 28),
('Z500RT82X7PETIVX198JXYXA1O', 28),
('V4LTH4GSSX1O5DBYLXCWJOGTVK', 28),
('5AV2PYCH40V0ZNIMM56541JU4H', 28),
('61TIH5DVVULHL5T8VPHH23XBCK', 28),
-- Game 29
('8N7U168RU3JV0396WCG14QLXZD', 29),
('70FM1MBPOKEKKKOWYTEQM889FB', 29),
('5NUXVPUKJPC95HAEEB9YJIN9SG', 29),
('C17FTEC2HG2CDZ9W3TWSSNZS6F', 29),
('EOH95SLDDMPFE20CZCWP7UVVS7', 29),
('4J2UQNX7SH4K0M3N6AHH6ARPG9', 29),
('8UZB2B15XOOL5JZ7U51FNIFUQN', 29),
('OSMPVRGNK3RR09W48F04K4B86A', 29),
('5NX5EVMS19TIUHLYFG0W8VSXTF', 29),
('NSEOLUVUO5XZSNCFB6O8I61XGU', 29),
-- Game 30
('Y0UUX7LUA62QSEQMRU6ZOG397Y', 30),
('ACXIGKPQHKMK18L084B0E8R2KG', 30),
('7TM6SQS7HL1U7Z0B5W93RMOF1Z', 30),
('R5WUERNQQ4V1X0YZ086UPV6TNW', 30),
('A2F9815WPFYU0EGQE5OGWYUCA0', 30),
('3L9LXHWH2Y5GMAT5UU8JK9DDHK', 30),
('09FTIABA3MDI38N1OIQ9FQOTR4', 30),
('T90SGXCWPMH0CH430WUDQ1Q7OQ', 30),
('6OG656CBPZ489ZSNV3CC0Z6LGV', 30),
('R3ZLDZ1QW77ZQ9GEEM2DTB962V', 30),
-- Game 31
('DGIV9INLXMR4QCZO17N6Y2BF4U', 31),
('JKLKLXM66Z4UPH3TZBJZJZ0A4P', 31),
('W7P6HA1RBIS4SNLQKW9F99JLM0', 31),
('S20V4Q5WOUQFFUAOR0BWQIZIZ9', 31),
('EBCXPRQNNTY7BQZGLGAVHIAI68', 31),
('GFZAV7B756FPVSV4NDZL4G8DP2', 31),
('D8ZL0J5MIOC1BBDX6S3RKWOZWF', 31),
('7IAO4FZR6WSXJMTYQVE0479GFM', 31),
('FZ2ONM59H0K4Z5E8ZLN0RZUFS8', 31),
('MYKTEA9CXZ9G9DYW1H83KCGJLR', 31),
-- Game 32
('LG1GOI5VWTANH3GG8ZF8W1Q91P', 32),
('H21UUH450C0LQ8X56GF2QGO8X1', 32),
('D4UL8N0OYROTQXOK5PS2QUVCN9', 32),
('6TNS09FHO0520LBREXB3YL4VDC', 32),
('6GNY7SAS8BQ1V0EDS7MXETQLN1', 32),
('Z8BGIP1G8Y8F98HG0JCM2JVMDM', 32),
('4OIB89FIZ7TZIL11VIO19MZCYH', 32),
('YCZQ06LSFD892RAY2R8E5EIGP8', 32),
('R2GC7XK6NOJA8WR1T6YBJ4KUPM', 32),
('39WBQ0VZ9Y0OZFVIUVNIO6PIZV', 32),
-- Game 33
('0IKZVUYI66KIRS6I3NKJFA2262', 33),
('PE98ZIBUNR056ET4QZY7H6I925', 33),
('DWL7LOS48GZIROC48IRG6ONKOL', 33),
('CGA80QYF66GUQMEM4OAV4AGL6V', 33),
('4AHRMXYRSK6HVMWSRR0KB0CQZM', 33),
('XK9KWQ8J1HOZC2N4OQ0IQ58FLI', 33),
('G3U8GFRBQMOVYPE48YBKM2VNY1', 33),
('YHUOA6ELWQWBQRZ12N67T763VR', 33),
('S6M89RSV2ZJRVOG289RHR1VTVK', 33),
('1GVBD7HH0RJ2DERM3YNNYRV27B', 33),
-- Game 34
('L2O8LHMEK3M73JILA0TL8SPB7K', 34),
('M6V5EQ6GYT68D6SL9WQTIXUGMQ', 34),
('6NL399G64KL95978ILPJPD2EHL', 34),
('AIRLOTHOWKAK21TNLGAULIQCIC', 34),
('EDPQL2JIBSBBW07JRMEN7S642D', 34),
('OV63T4C9ADU3498HMJ0A5YPS71', 34),
('471WF958T5PUOF3TL30EQ640N1', 34),
('H9W4OC1UH1OWKJ76SSE0SEDHRV', 34),
('XL4PRHYM9FDRT9A915UH7SWQ5C', 34),
('8U47WAMV1FEM4FAY5EMBUQA7VE', 34),
-- Game 35
('QPV39D90FTN5DLYYSOEXFIKXRZ', 35),
('99P9XTUKFHT3BYB9LSN3WEM1D8', 35),
('FO5ZC2KJXM6S1VJ9LFOS4WE00J', 35),
('0IEEBY4TA02Q6Q125XCKCP3SDM', 35),
('U2UGIXBWKOPG8T4PNZITFKVLWK', 35),
('I9AWW7H5B9ARKW2KCW1WJDASWN', 35),
('PHZH1ZGRI9SQAMMCNNVAH0ECWU', 35),
('9MF893H2F0L43A3GWTSO3X3B8O', 35),
('RUQTKCKUBK34H8Z1Z1T95NN1HT', 35),
('VYIADN52YNSU4VLPV1L1SI0X8G', 35),
-- Game 36
('96R9DOMG0T446AAPNJWMJAP6H0', 36),
('2C6QBCRS0Q6YDV7784MM56QFAX', 36),
('4U0PO1FEGQIK2C5SXPHF81MG6W', 36),
('J78L33EB2K6SW2UDRL9QS8T8LG', 36),
('58IYDZ45XZ8TQIBK0MM8ICIYU9', 36),
('EN8R23F3C59DLRTRJLRL2JMRDL', 36),
('RX5N9UGB86N4O89D1VNASYFHTK', 36),
('HP439QBJRXZKA71LRA9TYEHCA2', 36),
('YJ2K7R8FX3P1I4X514WSEV89EF', 36),
('LFP6GN2W6SLK8DMDPLYOD4RHH5', 36),
-- Game 37
('Z27QXWLX7WL45LFTSCKDAI34NO', 37),
('IPQ9CSLB60NJJ8FY2PTLKTU746', 37),
('OFKPJQSYSXS9P51F1AA9NQ7LG3', 37),
('XCJF2JMS0A2GMQ0HB90UM7GIUS', 37),
('4ZN8U22BIKPSGQDSIRA7R85BFM', 37),
('SGM6KAPA5O32CE3CNB1V0J2BLA', 37),
('2DPC2PYYX93066YJF0EX6FP3PC', 37),
('BW0FD8DTPLBNXIY6U8K2G81E40', 37),
('H399XQCM1I1IITAN4XU5QK3B5G', 37),
('RLHDYEAGU3JVHZCI77QV6UPEKA', 37),
-- Game 38
('A5D9NYE77LC50IR9VVQTR1MYHG', 38),
('35QVY0U1UU1HEK3ZTR3QP0TLQC', 38),
('RUFMKH0URBVQW0L12M4T4DIFH6', 38),
('4ZIFHDIRJNWN46ZVFM3H77EW1J', 38),
('Q3HCF82QAN27REQSO1ARS7AYI8', 38),
('N3AJD5AA1PYT9V2M9NJCAXZCRJ', 38),
('2V65HMO93TZ2I7VFUOK58ZJZ8J', 38),
('9V167WXZ64J35RETKNOIFMOWYX', 38),
('5J96EEY2V4L0MD6N7O6XVHMLQB', 38),
('ENX0Y3IA6MPAV51F8SG8YPW6ZC', 38),
-- Game 39
('NYSTBF31CZ9HC3JZ21AVU3AP44', 39),
('GQ4S7A9PO5GB0R6LNNXSX2WQCX', 39),
('G4E2FXX92IJQVKCLXXG3UVDPMZ', 39),
('560KZPT4XCT2BFMPIOE3UVZBJF', 39),
('J1V2T19YLIVXQOAVR2R94PNEJU', 39),
('IXZDJ7YRPZZ51LD4EYBGCWWLB9', 39),
('G2LMT5G0SRHWIVYRXM0BSNGQ5Z', 39),
('PRB7FETTIVVV5CQ6I0KP2N1CSD', 39),
('Y2KSQ5CAKUIIOJ81BYLW6KQD0O', 39),
('2QQH8GHBD06ZNBVCS03VRYN1C2', 39),
-- Game 40
('FTJY11IV7LHPDLAFE3EGZ8UEEG', 40),
('IWCROXBB4YKRITZLONN5DHV7DQ', 40),
('WHXW6EHD56DPDH0NY2D2QIRVB5', 40),
('DHN850U7ZX7JN245C1J4E8D5X0', 40),
('MM0LVERPNVQZM4Q45T1RS7RYU1', 40),
('W6QZEQWMD9Z7MH1G9KOCIZBSOZ', 40),
('Z944IDWS6OBSARXNYTL33160MM', 40),
('RC23D58HUWHF6NGN232ISZPWKB', 40),
('ELI6YU9Q8249MCN9FOCBHL2R7A', 40),
('XY46TBTLE30FTMLY48TGGBHX7O', 40),
-- Game 41
('AGM2L5JU0PLRM92VQWOPIIBZXA', 41),
('MLQT1RE9TLA5HB66SVTPT4XPTQ', 41),
('QC0UGBOJA1XFT2SGJW1SHSZDWM', 41),
('0B081OJ9E3KN9YWHCWNBZGDA8J', 41),
('MJRVBKNQGG70ZWXTZQVPYXZJLM', 41),
('8P1CJ7AG95FFX7B6AP7DNHNBVZ', 41),
('YRAIQTZGWISHJAZNA525VFOO87', 41),
('J9NTFPR0H5Y8DZKHGZFZ3BDZ6Z', 41),
('MFQ07B7MWTNXFX5VTQ6L86WON0', 41),
('MUVRQ5D27MJG4Q35HHP8ZVHSHX', 41),
-- Game 42
('6F2WBBZXODG65EN4ZAIHTMP689', 42),
('QBH03IXH2NB6HVZI1LSJMKC38N', 42),
('ARWNUUWGBLAI9K3QBUJ1XYML4F', 42),
('6CUPZZCTY3VWBN5KGAZYJFBAP9', 42),
('1XKA6UX7YIU9MPQVI8NMQXU6NE', 42),
('SJP1RUB5NFSR71PTEJ8VVGEZQ0', 42),
('YEI5FFNVMO1EIJ27JK49V8UJW3', 42),
('FGBNBFH4TXZ01LONEWT1G8PEX4', 42),
('FI4J70NIGXIKUK7WYV18XO88JC', 42),
('5F3LH6HNQRQXR8CN5GQPVF120Z', 42),
-- Game 43
('3BR8PNUWRZYPO7FDJQIEPN7KC6', 43),
('0A3T32M7X6UWNXZ0EDX8QY1BOT', 43),
('5GOVIT8W3ST0BUSM9VKUTC07XI', 43),
('61TV0M3P767H74PLX7BEAPYABC', 43),
('G115B4Y7RK7AWHFMXOW0LINSCR', 43),
('RJ7FCE5UJX9J9IAMJFJCWFHQJR', 43),
('3Y53QUJN995OVOS9S4KXYHS8WN', 43),
('FEIWZDL84P5NH2S0NN3GRBNEIU', 43),
('JRNGH2W7DFADHY26RT3DIREC7K', 43),
('972AEL2XORUG9KHSQWX30FX2HC', 43),
-- Game 44
('88FQHQZ7PDS4G0JCP0NNSRV5ZW', 44),
('2ATYWE54LW7PIWXVFPJNTRL6LB', 44),
('JLBISDO3T3A996I3EGCB6HUEUK', 44),
('Z9897D581WGQHB73F1FXU6DQMC', 44),
('OFALN1GXBYL12AM5YWV7X7JZ0F', 44),
('7TDHTM18KHMM4JMCSF9H746SXV', 44),
('8TZ52OQ4A0J4DNX8K2RI3BVV76', 44),
('4F9IMRWOGHMZR71225UFPR31ED', 44),
('M0H5WQQL8PCMMIUV7F7S6CNVB7', 44),
('14LFZKI7XOXWX2FQ3S0HGG65XK', 44),
-- Game 45
('YN9VVSG7MHH18T4RV48PL47CAZ', 45),
('L7WQKDHSABBY6YSIHNW47T563T', 45),
('W8SW55IXBPARJJE19UG4FVYXPO', 45),
('YE0WNZ6KRI7MBI4L2E9K7TO851', 45),
('VP8UC4JB8G1MCFC9SAEW0P8V2E', 45),
('WY1GV4TIRVUHNIOIBIRGYZKB17', 45),
('3HNZ0142UCT5IU96M671Q0K48D', 45),
('9V4FF0I9LSZ9E1MB647OMIY0H6', 45),
('VFH9NW4CP8BYHTDURNV6MN6YI6', 45),
('NM0PU3I633R4EQKVSTQIPCATWM', 45),
-- Game 46
('SQ7AGOCXIXLYYNZ1ZQSOLQK8N2', 46),
('HPQLOKAOYC0LZX8RDCG9EATQQB', 46),
('CMY8YJ3MX8SNN1QBODX7TW6AAQ', 46),
('U4Q9ABWTCNKUGPKAC7A4ZRRC9Q', 46),
('0LLMILW4WY5AMB0KHR8L3XGP5K', 46),
('7YW8X5HU89LWVMGLYEFNPE4I0F', 46),
('GMZRJUVVTNHVVE8YF3QB5AJGDJ', 46),
('YN2E91ZO2XFTSO5Y3GYS7OD4TS', 46),
('BTFUNRMUNOYW86INWP2NPY5CMI', 46),
('Q3FMTAQ05VRWQELY6WGF2CIO9S', 46),
-- Game 47
('6502G192147P3EY6VFIMQTED2I', 47),
('ZFDL0IADL53B3FZ1GK8VW2XYWD', 47),
('DSO1C22WP79ZWO7EX5ARTBZP99', 47),
('J7MAPZ1H0URW8VTTHK644N007B', 47),
('ZJE9E65KRTZT8MXEBCNIKJPNDC', 47),
('EL3OWMBKZZVBDTS2GSXNFCTYQM', 47),
('S76RDSGO7FPWZN44FQMJQTW110', 47),
('0O6UC2JLDO83TJNTD9ZK0ZZ71E', 47),
('3031XGDQBYA0H64T376IRSCN99', 47),
('LVJ2NS6EJHZXBGO9EWROOJBZEX', 47),
-- Game 48
('9FYQJCZWXNAHZWKUA2L63EYVEK', 48),
('6FFRJ4OT2HLY81SI2K00OY5K6D', 48),
('4MWWNS57NGD085SKLO74WL3W09', 48),
('MWQIFV981FX6LXEOVWTNLU3YAN', 48),
('ZDL0AVJQ49BH1G9PIN116SBIJA', 48),
('1WF1SH7X105G51VUAMDZQ1W6F0', 48),
('0QXKB4K0IU0MFFZHVG6V731S4K', 48),
('TPRUUMWHFBMYWV7XLHYR0J3N63', 48),
('ZJIZGVRJB8M1DSN0093DAI159N', 48),
('T4PXE8IPOWG58483P36PC0K5SC', 48),
-- Game 49
('9YDIEXAIIQ4R8LZ7FMKZHYCYJ9', 49),
('Q07X1NJ79FWCUZ9JQFVO82800B', 49),
('VSOD4A0BFBBZUTWMCR0RXX6YNY', 49),
('DE9WG434XALED7WZP5CWNENAXM', 49),
('B00DCVIZHYIQHY49R47ZJTSA4A', 49),
('VZBQEMCWFZPKYN21FA52BW6E87', 49),
('T4HQV4B49EPLY8WR8UWCJVFAEU', 49),
('FPOZ1K351L8O0RY1QH9NXHXSGI', 49),
('XI3JBAVTKEDD0D4LS4TSOIAPZT', 49),
('G99IM7HKYYH81ZQQHEW3AZJMFP', 49),
-- Game 50
('FQLVH8TJQZWYNXF3RT8SYCGEE2', 50),
('3SZR4R4AGI5GFCYAZN464H0FD5', 50),
('OUPD947V2KBDN4SF31AGP4EXBD', 50),
('O7WNR7VXA5BNK1OT6PWLJB4AZ0', 50),
('0PAEL55GQUNA9EU31QJGN4KMWN', 50),
('V1WPV26BW4REVINHMNA9WD35O7', 50),
('7RVP15ZPIILO10PWZ8N2BYYTMO', 50),
('KM5VZP19MU2IAIMJM8OGG8WO40', 50),
('6TN8IS591YOX08L5TQXP371EC8', 50),
('GJFGBLC5SY367ITK4HQBLJ8MZC', 50),
-- Game 51
('HFUIPRKA60UXOI9BYNEOS8LAHX', 51),
('TAZ0ZSISA654C636UH1O9DHRAT', 51),
('UM00OF6347W4EI47ZKD3B31B1K', 51),
('JXD7ACRVYW3PP01THJ2OJG3MSY', 51),
('TBB40Y3MV56854T7E7PVFVPTK5', 51),
('FL9LY4C7V4X0ZXD48ATDJ86C89', 51),
('VBUMQZ5FPA67M4V3XVKCUEKSBQ', 51),
('G7IPCLF1AWB7JOLCYWO2SI675P', 51),
('7I3BEQQKPJG1NBUU4IKZ315GGJ', 51),
('I4Y02RXOZWAU66W98WCK7U7HYI', 51),
-- Game 52
('PJQZ0PYU47IOII4NHWPNON3Q1E', 52),
('EITD16L02RATWAI1YWY7Q1DFBU', 52),
('FT10SWONGA753ZMZXJTFZLXBF4', 52),
('WS6Z617OXAOJVPN7VBY12TVKFY', 52),
('Q2TEALIITXM67TXFY3I6O4U19Z', 52),
('5241VMRZS2AAKXZS2IU8WT8761', 52),
('B9EJ005C8IAZUWGKY6NZ12Y50D', 52),
('76AUSEVHJIY5ULYZQFO2YC777C', 52),
('3KEC63GYVMMEJ0V71XWY9CD2YH', 52),
('35OXHB0C6YEKLJ2ND9U093RP51', 52),
-- Game 53
('QKTXXTVKQ8FMHRI1CR7M9512JG', 53),
('GIQV4JH7WTJT8E46W18EB3X6X8', 53),
('H1HGT1G1RFAYL05L1ZCMXRBKPJ', 53),
('7NN7WNSRUJWXEEKAQA5ZSG9DOJ', 53),
('YGBWG8KGAWDQO0AIERNCTUJYSH', 53),
('R7SBZI46LWWL3WRE0YM40TQ880', 53),
('FC5R5S26EBYY35LLV9IIIWM6ZH', 53),
('8FTB1469TP74PDCREY5XASZC5D', 53),
('EL7AV0KBP8JC33HWW34W6C973K', 53),
('TCG5QQYHG4BYQPEIFHNHQ1O4U4', 53),
-- Game 54
('BOER39MQ79UIZAN7TI1FLILST5', 54),
('BH9DQ1XNMRKHJR12A8KJB29PJH', 54),
('WNCTLRCGGUBASYQKJCC3M23Z71', 54),
('KKJJ54V2NL9MMC8FJZNQIY1SZ3', 54),
('NF20OEI5K0DI4UXK1TFC7UYNWB', 54),
('0J4XTVA7QM4WAQG7BVISSKXXHK', 54),
('D3F35RYVAY2TLYT9VHMKIL9DMR', 54),
('30DDPU2BSF668WAHAUD65YC2C0', 54),
('5FW5C9O06K3NSQAIPUXHC934TL', 54),
('2X9R03CCFS44W347ONN12Y6M7S', 54),
-- Game 55
('9926XGRJOVS1GODQVFITZN1RWU', 55),
('WPIJS5IT0OCCXEKPULBVZVOT8O', 55),
('5GCEQ4L6EHMFHU13RHUUJ1A7TI', 55),
('99SRE6RIIW4BSKCK5DATZOQ1RT', 55),
('M1EUE5PQ45LU8BTDFLTDYSKZ3S', 55),
('KJBO8SP80Q94AMQEYH3CTDAXYK', 55),
('BGBNXGDKMT64QIYN2OKKN6T2H3', 55),
('NVCYAL6H9J1W53JSCG25T1UP19', 55),
('JPSFJRKMZ85VGB2R3YC2LDKL7N', 55),
('74FUDO3YXLI9XR9FBZAZ5XRRAZ', 55),
-- Game 56
('0456FV3YXKX5V1LQV8HKGDRI4V', 56),
('6CGIHRBAJ73GLVI8709PLAFPDA', 56),
('JXI6QEJHSXV39HWL2IFZRNYFDN', 56),
('P2M0H617MDXBXM7N8MYVTGE3PA', 56),
('186266W37MGZ1WR90GMMFGH0IK', 56),
('UYYM7IRJ0X6NYTRVCGK1AH804Q', 56),
('NEKOFXDITM7RT2AVDR9B6X32W7', 56),
('E58VTHT44WE78FWHARUJR2BTRQ', 56),
('YX8VDIYL765RORGXL79HLBSS13', 56),
('KYGX9P6ZSRBVDT1CVTN0NUS8FN', 56),
-- Game 57
('ARFX5LMNWJ2FR9EDWFK6LAKPCM', 57),
('WL58HBUA6V66BYN1ZBEGQN67VT', 57),
('42EK4R2CN04VWZ9IFEDCTB3Y73', 57),
('CR5OGGM8CSL0PM71BCTI0BOTFS', 57),
('OF5E7GISV9L1OHK7NK5P315OTT', 57),
('22T3N5C7AGN4MBLSMZ0IRKS842', 57),
('I35PF8A3LU0FY69HLA3T2G1AC9', 57),
('1A7I3XYMYHR9SR4XKHWMN8YGF9', 57),
('4YMZLBQ09F9X2X5WHHXTKXNVCI', 57),
('9ZB96D3LKFYQ7VL81I3X9MJTPH', 57),
-- Game 58
('13W851HLQHT0C8WVKBWI7TXBY4', 58),
('1D6HA7VAUJMY3T7BYONFB85FGD', 58),
('8Y16C7SYT7H7N7UTP0XMWV5U3P', 58),
('DBBMRR0RQW0XH6SEZOIBGVDQ6R', 58),
('H8QJGHWWE8C50OZW1HW6VE4I6A', 58),
('X9WQC82K1YMW5HTR5PHQIN9HJA', 58),
('1LT92OJC4QBKKM2LMQOPB361LN', 58),
('0DSBBKBKDN5B3C57WNHTSY74MN', 58),
('4UQGOYCMND1W0X2GWZ4J6D7L0M', 58),
('LBIJDFOB2FONIBR578S1TS6NXX', 58),
-- Game 59
('LS6NEH0F9IP3HC8FPMHQV5I91I', 59),
('NR7XDUYKHH4Q796LQHHUCE839E', 59),
('B9O0ZUN1R4ZSFMGS75HUIYOOY6', 59),
('B0ZFFBIY92UHNOKOWEQOAEE36B', 59),
('C12Q3IDW4GI3ZX547RLJ1AK6SR', 59),
('DK45RVTBRATWZ74UEYP7C2LKQ9', 59),
('PVEOQQY748HSSDVEUGNGAJV2MM', 59),
('RO6S3K17061F8EVIXX525DKCY2', 59),
('85BIUB1NRG3ABNB2S97UMRU1ML', 59),
('ZY2LJ09PC8C9GKM4XHZRWFSRW0', 59),
-- Game 60
('QASQHAUILRW2COFZRVJNAJ7BGY', 60),
('LJAOOO3B0Y4HYLCFT8FA5C65AQ', 60),
('JHEPWOW4A4CGPRTZRLU32YRQX7', 60),
('6P2JOUBOQLYDTUSWITASJA43CE', 60),
('EKNVDQZESODW84BLQTGPYA5608', 60),
('FTZ7SBNZR946JSA85BP7543ZH8', 60),
('FX18UUYIGID5J1AQTC3ZY5I85G', 60),
('JKL41A3Q2VPFT11TA33XLIQGES', 60),
('9O5AFQRUDQLNQSN75QH6J1ARE6', 60),
('H6JLASERPTELO9CQD7E7T9607H', 60);


-- PLATFORM
insert into Platform (name) values ('Steam');
insert into Platform (name) values ('EA');
insert into Platform (name) values ('UbiSoft');
insert into Platform (name) values ('Epic Games');


-- GAME PLAFORM
INSERT INTO GamePlatform (game, platform) VALUES (1, 1);
INSERT INTO GamePlatform (game, platform) VALUES (1, 2);
INSERT INTO GamePlatform (game, platform) VALUES (1, 3);
INSERT INTO GamePlatform (game, platform) VALUES (1, 4);
INSERT INTO GamePlatform (game, platform) VALUES (2, 1);
INSERT INTO GamePlatform (game, platform) VALUES (2, 2);
INSERT INTO GamePlatform (game, platform) VALUES (3, 2);
INSERT INTO GamePlatform (game, platform) VALUES (3, 4);
INSERT INTO GamePlatform (game, platform) VALUES (4, 2);
INSERT INTO GamePlatform (game, platform) VALUES (4, 3);
INSERT INTO GamePlatform (game, platform) VALUES (5, 2);
INSERT INTO GamePlatform (game, platform) VALUES (5, 4);
INSERT INTO GamePlatform (game, platform) VALUES (6, 1);
INSERT INTO GamePlatform (game, platform) VALUES (6, 3);
INSERT INTO GamePlatform (game, platform) VALUES (6, 4);
INSERT INTO GamePlatform (game, platform) VALUES (7, 2);
INSERT INTO GamePlatform (game, platform) VALUES (7, 3);
INSERT INTO GamePlatform (game, platform) VALUES (7, 4);
INSERT INTO GamePlatform (game, platform) VALUES (8, 1);
INSERT INTO GamePlatform (game, platform) VALUES (8, 2);
INSERT INTO GamePlatform (game, platform) VALUES (8, 3);
INSERT INTO GamePlatform (game, platform) VALUES (9, 1);
INSERT INTO GamePlatform (game, platform) VALUES (9, 2);
INSERT INTO GamePlatform (game, platform) VALUES (10, 1);
INSERT INTO GamePlatform (game, platform) VALUES (10, 2);
INSERT INTO GamePlatform (game, platform) VALUES (10, 3);
INSERT INTO GamePlatform (game, platform) VALUES (11, 1);
INSERT INTO GamePlatform (game, platform) VALUES (11, 3);
INSERT INTO GamePlatform (game, platform) VALUES (11, 4);
INSERT INTO GamePlatform (game, platform) VALUES (12, 2);
INSERT INTO GamePlatform (game, platform) VALUES (12, 3);
INSERT INTO GamePlatform (game, platform) VALUES (13, 2);
INSERT INTO GamePlatform (game, platform) VALUES (13, 4);
INSERT INTO GamePlatform (game, platform) VALUES (14, 2);
INSERT INTO GamePlatform (game, platform) VALUES (14, 3);
INSERT INTO GamePlatform (game, platform) VALUES (14, 4);
INSERT INTO GamePlatform (game, platform) VALUES (15, 2);
INSERT INTO GamePlatform (game, platform) VALUES (15, 4);
INSERT INTO GamePlatform (game, platform) VALUES (16, 3);
INSERT INTO GamePlatform (game, platform) VALUES (16, 4);
INSERT INTO GamePlatform (game, platform) VALUES (17, 1);
INSERT INTO GamePlatform (game, platform) VALUES (17, 2);
INSERT INTO GamePlatform (game, platform) VALUES (18, 2);
INSERT INTO GamePlatform (game, platform) VALUES (18, 4);
INSERT INTO GamePlatform (game, platform) VALUES (19, 1);
INSERT INTO GamePlatform (game, platform) VALUES (19, 3);
INSERT INTO GamePlatform (game, platform) VALUES (20, 1);
INSERT INTO GamePlatform (game, platform) VALUES (20, 2);
INSERT INTO GamePlatform (game, platform) VALUES (20, 4);
INSERT INTO GamePlatform (game, platform) VALUES (21, 1);
INSERT INTO GamePlatform (game, platform) VALUES (21, 2);
INSERT INTO GamePlatform (game, platform) VALUES (21, 3);
INSERT INTO GamePlatform (game, platform) VALUES (22, 1);
INSERT INTO GamePlatform (game, platform) VALUES (22, 2);
INSERT INTO GamePlatform (game, platform) VALUES (22, 3);
INSERT INTO GamePlatform (game, platform) VALUES (22, 4);
INSERT INTO GamePlatform (game, platform) VALUES (23, 2);
INSERT INTO GamePlatform (game, platform) VALUES (23, 3);
INSERT INTO GamePlatform (game, platform) VALUES (23, 4);
INSERT INTO GamePlatform (game, platform) VALUES (24, 2);
INSERT INTO GamePlatform (game, platform) VALUES (24, 3);
INSERT INTO GamePlatform (game, platform) VALUES (24, 4);
INSERT INTO GamePlatform (game, platform) VALUES (25, 2);
INSERT INTO GamePlatform (game, platform) VALUES (25, 4);
INSERT INTO GamePlatform (game, platform) VALUES (26, 1);
INSERT INTO GamePlatform (game, platform) VALUES (26, 2);
INSERT INTO GamePlatform (game, platform) VALUES (27, 3);
INSERT INTO GamePlatform (game, platform) VALUES (27, 4);
INSERT INTO GamePlatform (game, platform) VALUES (28, 1);
INSERT INTO GamePlatform (game, platform) VALUES (28, 4);
INSERT INTO GamePlatform (game, platform) VALUES (29, 1);
INSERT INTO GamePlatform (game, platform) VALUES (29, 2);
INSERT INTO GamePlatform (game, platform) VALUES (29, 4);
INSERT INTO GamePlatform (game, platform) VALUES (30, 1);
INSERT INTO GamePlatform (game, platform) VALUES (30, 4);
INSERT INTO GamePlatform (game, platform) VALUES (31, 2);
INSERT INTO GamePlatform (game, platform) VALUES (31, 3);
INSERT INTO GamePlatform (game, platform) VALUES (31, 4);
INSERT INTO GamePlatform (game, platform) VALUES (32, 3);
INSERT INTO GamePlatform (game, platform) VALUES (32, 4);
INSERT INTO GamePlatform (game, platform) VALUES (33, 1);
INSERT INTO GamePlatform (game, platform) VALUES (33, 4);
INSERT INTO GamePlatform (game, platform) VALUES (34, 1);
INSERT INTO GamePlatform (game, platform) VALUES (34, 3);
INSERT INTO GamePlatform (game, platform) VALUES (34, 4);
INSERT INTO GamePlatform (game, platform) VALUES (35, 1);
INSERT INTO GamePlatform (game, platform) VALUES (35, 4);
INSERT INTO GamePlatform (game, platform) VALUES (36, 1);
INSERT INTO GamePlatform (game, platform) VALUES (36, 2);
INSERT INTO GamePlatform (game, platform) VALUES (37, 1);
INSERT INTO GamePlatform (game, platform) VALUES (37, 3);
INSERT INTO GamePlatform (game, platform) VALUES (37, 4);
INSERT INTO GamePlatform (game, platform) VALUES (38, 3);
INSERT INTO GamePlatform (game, platform) VALUES (38, 4);
INSERT INTO GamePlatform (game, platform) VALUES (39, 1);
INSERT INTO GamePlatform (game, platform) VALUES (39, 3);
INSERT INTO GamePlatform (game, platform) VALUES (39, 4);
INSERT INTO GamePlatform (game, platform) VALUES (40, 1);
INSERT INTO GamePlatform (game, platform) VALUES (40, 2);
INSERT INTO GamePlatform (game, platform) VALUES (41, 2);
INSERT INTO GamePlatform (game, platform) VALUES (41, 3);
INSERT INTO GamePlatform (game, platform) VALUES (42, 1);
INSERT INTO GamePlatform (game, platform) VALUES (42, 3);
INSERT INTO GamePlatform (game, platform) VALUES (42, 4);
INSERT INTO GamePlatform (game, platform) VALUES (43, 1);
INSERT INTO GamePlatform (game, platform) VALUES (43, 2);
INSERT INTO GamePlatform (game, platform) VALUES (43, 4);
INSERT INTO GamePlatform (game, platform) VALUES (44, 2);
INSERT INTO GamePlatform (game, platform) VALUES (44, 3);
INSERT INTO GamePlatform (game, platform) VALUES (44, 4);
INSERT INTO GamePlatform (game, platform) VALUES (45, 1);
INSERT INTO GamePlatform (game, platform) VALUES (45, 3);
INSERT INTO GamePlatform (game, platform) VALUES (46, 2);
INSERT INTO GamePlatform (game, platform) VALUES (46, 3);
INSERT INTO GamePlatform (game, platform) VALUES (46, 4);
INSERT INTO GamePlatform (game, platform) VALUES (47, 1);
INSERT INTO GamePlatform (game, platform) VALUES (47, 3);
INSERT INTO GamePlatform (game, platform) VALUES (47, 4);
INSERT INTO GamePlatform (game, platform) VALUES (48, 1);
INSERT INTO GamePlatform (game, platform) VALUES (48, 4);
INSERT INTO GamePlatform (game, platform) VALUES (49, 1);
INSERT INTO GamePlatform (game, platform) VALUES (49, 3);
INSERT INTO GamePlatform (game, platform) VALUES (49, 4);
INSERT INTO GamePlatform (game, platform) VALUES (50, 1);
INSERT INTO GamePlatform (game, platform) VALUES (50, 2);
INSERT INTO GamePlatform (game, platform) VALUES (50, 4);
INSERT INTO GamePlatform (game, platform) VALUES (51, 1);
INSERT INTO GamePlatform (game, platform) VALUES (51, 2);
INSERT INTO GamePlatform (game, platform) VALUES (52, 1);
INSERT INTO GamePlatform (game, platform) VALUES (52, 2);
INSERT INTO GamePlatform (game, platform) VALUES (52, 3);
INSERT INTO GamePlatform (game, platform) VALUES (53, 2);
INSERT INTO GamePlatform (game, platform) VALUES (53, 3);
INSERT INTO GamePlatform (game, platform) VALUES (53, 4);
INSERT INTO GamePlatform (game, platform) VALUES (54, 3);
INSERT INTO GamePlatform (game, platform) VALUES (54, 4);
INSERT INTO GamePlatform (game, platform) VALUES (55, 1);
INSERT INTO GamePlatform (game, platform) VALUES (55, 2);
INSERT INTO GamePlatform (game, platform) VALUES (55, 4);
INSERT INTO GamePlatform (game, platform) VALUES (56, 1);
INSERT INTO GamePlatform (game, platform) VALUES (56, 2);
INSERT INTO GamePlatform (game, platform) VALUES (57, 1);
INSERT INTO GamePlatform (game, platform) VALUES (57, 3);
INSERT INTO GamePlatform (game, platform) VALUES (58, 1);
INSERT INTO GamePlatform (game, platform) VALUES (58, 4);
INSERT INTO GamePlatform (game, platform) VALUES (59, 2);
INSERT INTO GamePlatform (game, platform) VALUES (59, 4);
INSERT INTO GamePlatform (game, platform) VALUES (60, 1);
INSERT INTO GamePlatform (game, platform) VALUES (60, 3);


-- CATEGORY (33)
insert into Category (name) values ('Action');
insert into Category (name) values ('Adventure');
insert into Category (name) values ('RPG');
insert into Category (name) values ('Simulation');
insert into Category (name) values ('Strategy');
insert into Category (name) values ('Sports');
insert into Category (name) values ('Horror');
insert into Category (name) values ('Puzzle');
insert into Category (name) values ('Racing');
insert into Category (name) values ('Fighting');
insert into Category (name) values ('Shooter');
insert into Category (name) values ('Survival');
insert into Category (name) values ('MMORPG');
insert into Category (name) values ('MOBA');
insert into Category (name) values ('Battle Royale');
insert into Category (name) values ('Sandbox');
insert into Category (name) values ('Open World');
insert into Category (name) values ('Stealth');
insert into Category (name) values ('Hack and Slash');
insert into Category (name) values ('Platformer');
insert into Category (name) values ('Metroidvania');
insert into Category (name) values ('Roguelike');
insert into Category (name) values ('Rhythm');
insert into Category (name) values ('Educational');
insert into Category (name) values ('Party');
insert into Category (name) values ('Music');
insert into Category (name) values ('Card');
insert into Category (name) values ('Board');
insert into Category (name) values ('Casual');
insert into Category (name) values ('Arcade');
insert into Category (name) values ('PvP');
insert into Category (name) values ('PvE');
insert into Category (name) values ('Co-op');


-- GAME CATEGORY
INSERT INTO GameCategory (game, category) VALUES (1, 17);
INSERT INTO GameCategory (game, category) VALUES (1, 15);
INSERT INTO GameCategory (game, category) VALUES (1, 27);
INSERT INTO GameCategory (game, category) VALUES (1, 2);
INSERT INTO GameCategory (game, category) VALUES (1, 33);
INSERT INTO GameCategory (game, category) VALUES (1, 14);
INSERT INTO GameCategory (game, category) VALUES (2, 11);
INSERT INTO GameCategory (game, category) VALUES (2, 21);
INSERT INTO GameCategory (game, category) VALUES (2, 32);
INSERT INTO GameCategory (game, category) VALUES (2, 2);
INSERT INTO GameCategory (game, category) VALUES (2, 10);
INSERT INTO GameCategory (game, category) VALUES (2, 28);
INSERT INTO GameCategory (game, category) VALUES (3, 13);
INSERT INTO GameCategory (game, category) VALUES (3, 33);
INSERT INTO GameCategory (game, category) VALUES (3, 30);
INSERT INTO GameCategory (game, category) VALUES (3, 1);
INSERT INTO GameCategory (game, category) VALUES (3, 5);
INSERT INTO GameCategory (game, category) VALUES (3, 4);
INSERT INTO GameCategory (game, category) VALUES (4, 13);
INSERT INTO GameCategory (game, category) VALUES (4, 1);
INSERT INTO GameCategory (game, category) VALUES (4, 24);
INSERT INTO GameCategory (game, category) VALUES (4, 28);
INSERT INTO GameCategory (game, category) VALUES (5, 18);
INSERT INTO GameCategory (game, category) VALUES (5, 25);
INSERT INTO GameCategory (game, category) VALUES (5, 10);
INSERT INTO GameCategory (game, category) VALUES (5, 16);
INSERT INTO GameCategory (game, category) VALUES (5, 17);
INSERT INTO GameCategory (game, category) VALUES (6, 8);
INSERT INTO GameCategory (game, category) VALUES (6, 18);
INSERT INTO GameCategory (game, category) VALUES (6, 21);
INSERT INTO GameCategory (game, category) VALUES (6, 16);
INSERT INTO GameCategory (game, category) VALUES (6, 9);
INSERT INTO GameCategory (game, category) VALUES (6, 13);
INSERT INTO GameCategory (game, category) VALUES (7, 31);
INSERT INTO GameCategory (game, category) VALUES (7, 28);
INSERT INTO GameCategory (game, category) VALUES (7, 3);
INSERT INTO GameCategory (game, category) VALUES (7, 12);
INSERT INTO GameCategory (game, category) VALUES (8, 9);
INSERT INTO GameCategory (game, category) VALUES (8, 22);
INSERT INTO GameCategory (game, category) VALUES (8, 24);
INSERT INTO GameCategory (game, category) VALUES (9, 20);
INSERT INTO GameCategory (game, category) VALUES (9, 30);
INSERT INTO GameCategory (game, category) VALUES (9, 22);
INSERT INTO GameCategory (game, category) VALUES (9, 12);
INSERT INTO GameCategory (game, category) VALUES (9, 17);
INSERT INTO GameCategory (game, category) VALUES (9, 21);
INSERT INTO GameCategory (game, category) VALUES (10, 6);
INSERT INTO GameCategory (game, category) VALUES (10, 7);
INSERT INTO GameCategory (game, category) VALUES (10, 11);
INSERT INTO GameCategory (game, category) VALUES (11, 19);
INSERT INTO GameCategory (game, category) VALUES (11, 28);
INSERT INTO GameCategory (game, category) VALUES (11, 3);
INSERT INTO GameCategory (game, category) VALUES (11, 23);
INSERT INTO GameCategory (game, category) VALUES (11, 30);
INSERT INTO GameCategory (game, category) VALUES (12, 22);
INSERT INTO GameCategory (game, category) VALUES (12, 32);
INSERT INTO GameCategory (game, category) VALUES (13, 9);
INSERT INTO GameCategory (game, category) VALUES (13, 12);
INSERT INTO GameCategory (game, category) VALUES (13, 10);
INSERT INTO GameCategory (game, category) VALUES (13, 18);
INSERT INTO GameCategory (game, category) VALUES (13, 28);
INSERT INTO GameCategory (game, category) VALUES (14, 7);
INSERT INTO GameCategory (game, category) VALUES (14, 19);
INSERT INTO GameCategory (game, category) VALUES (14, 5);
INSERT INTO GameCategory (game, category) VALUES (15, 21);
INSERT INTO GameCategory (game, category) VALUES (15, 24);
INSERT INTO GameCategory (game, category) VALUES (15, 18);
INSERT INTO GameCategory (game, category) VALUES (15, 30);
INSERT INTO GameCategory (game, category) VALUES (15, 19);
INSERT INTO GameCategory (game, category) VALUES (16, 20);
INSERT INTO GameCategory (game, category) VALUES (16, 31);
INSERT INTO GameCategory (game, category) VALUES (16, 26);
INSERT INTO GameCategory (game, category) VALUES (16, 30);
INSERT INTO GameCategory (game, category) VALUES (16, 25);
INSERT INTO GameCategory (game, category) VALUES (17, 17);
INSERT INTO GameCategory (game, category) VALUES (17, 14);
INSERT INTO GameCategory (game, category) VALUES (17, 6);
INSERT INTO GameCategory (game, category) VALUES (17, 3);
INSERT INTO GameCategory (game, category) VALUES (18, 10);
INSERT INTO GameCategory (game, category) VALUES (18, 26);
INSERT INTO GameCategory (game, category) VALUES (18, 2);
INSERT INTO GameCategory (game, category) VALUES (18, 30);
INSERT INTO GameCategory (game, category) VALUES (18, 7);
INSERT INTO GameCategory (game, category) VALUES (18, 9);
INSERT INTO GameCategory (game, category) VALUES (19, 12);
INSERT INTO GameCategory (game, category) VALUES (19, 29);
INSERT INTO GameCategory (game, category) VALUES (19, 9);
INSERT INTO GameCategory (game, category) VALUES (19, 5);
INSERT INTO GameCategory (game, category) VALUES (19, 19);
INSERT INTO GameCategory (game, category) VALUES (19, 11);
INSERT INTO GameCategory (game, category) VALUES (20, 25);
INSERT INTO GameCategory (game, category) VALUES (20, 27);
INSERT INTO GameCategory (game, category) VALUES (21, 31);
INSERT INTO GameCategory (game, category) VALUES (21, 13);
INSERT INTO GameCategory (game, category) VALUES (21, 3);
INSERT INTO GameCategory (game, category) VALUES (21, 26);
INSERT INTO GameCategory (game, category) VALUES (21, 2);
INSERT INTO GameCategory (game, category) VALUES (21, 29);
INSERT INTO GameCategory (game, category) VALUES (22, 17);
INSERT INTO GameCategory (game, category) VALUES (22, 14);
INSERT INTO GameCategory (game, category) VALUES (22, 32);
INSERT INTO GameCategory (game, category) VALUES (22, 12);
INSERT INTO GameCategory (game, category) VALUES (23, 6);
INSERT INTO GameCategory (game, category) VALUES (23, 4);
INSERT INTO GameCategory (game, category) VALUES (23, 29);
INSERT INTO GameCategory (game, category) VALUES (23, 20);
INSERT INTO GameCategory (game, category) VALUES (23, 26);
INSERT INTO GameCategory (game, category) VALUES (24, 29);
INSERT INTO GameCategory (game, category) VALUES (24, 1);
INSERT INTO GameCategory (game, category) VALUES (25, 11);
INSERT INTO GameCategory (game, category) VALUES (25, 24);
INSERT INTO GameCategory (game, category) VALUES (25, 17);
INSERT INTO GameCategory (game, category) VALUES (25, 19);
INSERT INTO GameCategory (game, category) VALUES (25, 14);
INSERT INTO GameCategory (game, category) VALUES (26, 9);
INSERT INTO GameCategory (game, category) VALUES (26, 5);
INSERT INTO GameCategory (game, category) VALUES (26, 30);
INSERT INTO GameCategory (game, category) VALUES (26, 29);
INSERT INTO GameCategory (game, category) VALUES (26, 8);
INSERT INTO GameCategory (game, category) VALUES (26, 13);
INSERT INTO GameCategory (game, category) VALUES (27, 29);
INSERT INTO GameCategory (game, category) VALUES (27, 30);
INSERT INTO GameCategory (game, category) VALUES (27, 20);
INSERT INTO GameCategory (game, category) VALUES (28, 14);
INSERT INTO GameCategory (game, category) VALUES (28, 26);
INSERT INTO GameCategory (game, category) VALUES (28, 32);
INSERT INTO GameCategory (game, category) VALUES (28, 4);
INSERT INTO GameCategory (game, category) VALUES (28, 5);
INSERT INTO GameCategory (game, category) VALUES (29, 32);
INSERT INTO GameCategory (game, category) VALUES (29, 9);
INSERT INTO GameCategory (game, category) VALUES (29, 29);
INSERT INTO GameCategory (game, category) VALUES (30, 8);
INSERT INTO GameCategory (game, category) VALUES (30, 20);
INSERT INTO GameCategory (game, category) VALUES (30, 2);
INSERT INTO GameCategory (game, category) VALUES (31, 28);
INSERT INTO GameCategory (game, category) VALUES (31, 9);
INSERT INTO GameCategory (game, category) VALUES (31, 7);
INSERT INTO GameCategory (game, category) VALUES (31, 6);
INSERT INTO GameCategory (game, category) VALUES (31, 31);
INSERT INTO GameCategory (game, category) VALUES (32, 21);
INSERT INTO GameCategory (game, category) VALUES (32, 33);
INSERT INTO GameCategory (game, category) VALUES (32, 32);
INSERT INTO GameCategory (game, category) VALUES (32, 23);
INSERT INTO GameCategory (game, category) VALUES (32, 29);
INSERT INTO GameCategory (game, category) VALUES (33, 2);
INSERT INTO GameCategory (game, category) VALUES (33, 6);
INSERT INTO GameCategory (game, category) VALUES (33, 25);
INSERT INTO GameCategory (game, category) VALUES (34, 16);
INSERT INTO GameCategory (game, category) VALUES (34, 2);
INSERT INTO GameCategory (game, category) VALUES (34, 13);
INSERT INTO GameCategory (game, category) VALUES (34, 15);
INSERT INTO GameCategory (game, category) VALUES (34, 14);
INSERT INTO GameCategory (game, category) VALUES (34, 4);
INSERT INTO GameCategory (game, category) VALUES (35, 11);
INSERT INTO GameCategory (game, category) VALUES (35, 30);
INSERT INTO GameCategory (game, category) VALUES (35, 25);
INSERT INTO GameCategory (game, category) VALUES (35, 22);
INSERT INTO GameCategory (game, category) VALUES (36, 29);
INSERT INTO GameCategory (game, category) VALUES (36, 22);
INSERT INTO GameCategory (game, category) VALUES (36, 16);
INSERT INTO GameCategory (game, category) VALUES (37, 9);
INSERT INTO GameCategory (game, category) VALUES (37, 32);
INSERT INTO GameCategory (game, category) VALUES (37, 15);
INSERT INTO GameCategory (game, category) VALUES (37, 19);
INSERT INTO GameCategory (game, category) VALUES (37, 3);
INSERT INTO GameCategory (game, category) VALUES (37, 1);
INSERT INTO GameCategory (game, category) VALUES (38, 12);
INSERT INTO GameCategory (game, category) VALUES (38, 16);
INSERT INTO GameCategory (game, category) VALUES (38, 7);
INSERT INTO GameCategory (game, category) VALUES (38, 29);
INSERT INTO GameCategory (game, category) VALUES (39, 11);
INSERT INTO GameCategory (game, category) VALUES (39, 28);
INSERT INTO GameCategory (game, category) VALUES (39, 10);
INSERT INTO GameCategory (game, category) VALUES (40, 26);
INSERT INTO GameCategory (game, category) VALUES (40, 23);
INSERT INTO GameCategory (game, category) VALUES (41, 20);
INSERT INTO GameCategory (game, category) VALUES (41, 4);
INSERT INTO GameCategory (game, category) VALUES (41, 2);
INSERT INTO GameCategory (game, category) VALUES (41, 14);
INSERT INTO GameCategory (game, category) VALUES (41, 16);
INSERT INTO GameCategory (game, category) VALUES (41, 13);
INSERT INTO GameCategory (game, category) VALUES (42, 28);
INSERT INTO GameCategory (game, category) VALUES (42, 12);
INSERT INTO GameCategory (game, category) VALUES (42, 3);
INSERT INTO GameCategory (game, category) VALUES (43, 11);
INSERT INTO GameCategory (game, category) VALUES (43, 1);
INSERT INTO GameCategory (game, category) VALUES (43, 30);
INSERT INTO GameCategory (game, category) VALUES (44, 20);
INSERT INTO GameCategory (game, category) VALUES (44, 19);
INSERT INTO GameCategory (game, category) VALUES (44, 3);
INSERT INTO GameCategory (game, category) VALUES (44, 10);
INSERT INTO GameCategory (game, category) VALUES (44, 30);
INSERT INTO GameCategory (game, category) VALUES (45, 26);
INSERT INTO GameCategory (game, category) VALUES (45, 13);
INSERT INTO GameCategory (game, category) VALUES (45, 23);
INSERT INTO GameCategory (game, category) VALUES (46, 7);
INSERT INTO GameCategory (game, category) VALUES (46, 31);
INSERT INTO GameCategory (game, category) VALUES (46, 2);
INSERT INTO GameCategory (game, category) VALUES (46, 14);
INSERT INTO GameCategory (game, category) VALUES (46, 10);
INSERT INTO GameCategory (game, category) VALUES (46, 25);
INSERT INTO GameCategory (game, category) VALUES (47, 1);
INSERT INTO GameCategory (game, category) VALUES (47, 32);
INSERT INTO GameCategory (game, category) VALUES (48, 26);
INSERT INTO GameCategory (game, category) VALUES (48, 13);
INSERT INTO GameCategory (game, category) VALUES (48, 28);
INSERT INTO GameCategory (game, category) VALUES (48, 16);
INSERT INTO GameCategory (game, category) VALUES (48, 27);
INSERT INTO GameCategory (game, category) VALUES (49, 16);
INSERT INTO GameCategory (game, category) VALUES (49, 26);
INSERT INTO GameCategory (game, category) VALUES (49, 29);
INSERT INTO GameCategory (game, category) VALUES (49, 6);
INSERT INTO GameCategory (game, category) VALUES (49, 30);
INSERT INTO GameCategory (game, category) VALUES (50, 18);
INSERT INTO GameCategory (game, category) VALUES (50, 15);
INSERT INTO GameCategory (game, category) VALUES (50, 6);
INSERT INTO GameCategory (game, category) VALUES (50, 9);
INSERT INTO GameCategory (game, category) VALUES (50, 5);
INSERT INTO GameCategory (game, category) VALUES (51, 32);
INSERT INTO GameCategory (game, category) VALUES (51, 28);
INSERT INTO GameCategory (game, category) VALUES (51, 25);
INSERT INTO GameCategory (game, category) VALUES (51, 17);
INSERT INTO GameCategory (game, category) VALUES (52, 25);
INSERT INTO GameCategory (game, category) VALUES (52, 12);
INSERT INTO GameCategory (game, category) VALUES (52, 6);
INSERT INTO GameCategory (game, category) VALUES (52, 3);
INSERT INTO GameCategory (game, category) VALUES (52, 4);
INSERT INTO GameCategory (game, category) VALUES (52, 27);
INSERT INTO GameCategory (game, category) VALUES (53, 33);
INSERT INTO GameCategory (game, category) VALUES (53, 9);
INSERT INTO GameCategory (game, category) VALUES (53, 4);
INSERT INTO GameCategory (game, category) VALUES (53, 27);
INSERT INTO GameCategory (game, category) VALUES (54, 29);
INSERT INTO GameCategory (game, category) VALUES (54, 13);
INSERT INTO GameCategory (game, category) VALUES (54, 5);
INSERT INTO GameCategory (game, category) VALUES (54, 23);
INSERT INTO GameCategory (game, category) VALUES (54, 16);
INSERT INTO GameCategory (game, category) VALUES (54, 30);
INSERT INTO GameCategory (game, category) VALUES (55, 3);
INSERT INTO GameCategory (game, category) VALUES (55, 13);
INSERT INTO GameCategory (game, category) VALUES (55, 32);
INSERT INTO GameCategory (game, category) VALUES (55, 7);
INSERT INTO GameCategory (game, category) VALUES (55, 25);
INSERT INTO GameCategory (game, category) VALUES (56, 10);
INSERT INTO GameCategory (game, category) VALUES (56, 29);
INSERT INTO GameCategory (game, category) VALUES (56, 22);
INSERT INTO GameCategory (game, category) VALUES (57, 7);
INSERT INTO GameCategory (game, category) VALUES (57, 30);
INSERT INTO GameCategory (game, category) VALUES (57, 10);
INSERT INTO GameCategory (game, category) VALUES (57, 14);
INSERT INTO GameCategory (game, category) VALUES (57, 21);
INSERT INTO GameCategory (game, category) VALUES (57, 16);
INSERT INTO GameCategory (game, category) VALUES (58, 22);
INSERT INTO GameCategory (game, category) VALUES (58, 13);
INSERT INTO GameCategory (game, category) VALUES (58, 10);
INSERT INTO GameCategory (game, category) VALUES (58, 7);
INSERT INTO GameCategory (game, category) VALUES (58, 6);
INSERT INTO GameCategory (game, category) VALUES (59, 16);
INSERT INTO GameCategory (game, category) VALUES (59, 1);
INSERT INTO GameCategory (game, category) VALUES (59, 12);
INSERT INTO GameCategory (game, category) VALUES (60, 1);
INSERT INTO GameCategory (game, category) VALUES (60, 5);


-- LANGUAGE (22)
insert into Language (name) values ('English');
insert into Language (name) values ('Spanish');
insert into Language (name) values ('French');
insert into Language (name) values ('German');
insert into Language (name) values ('Italian');
insert into Language (name) values ('Portuguese');
insert into Language (name) values ('Russian');
insert into Language (name) values ('Japanese');
insert into Language (name) values ('Chinese');
insert into Language (name) values ('Korean');
insert into Language (name) values ('Arabic');
insert into Language (name) values ('Turkish');
insert into Language (name) values ('Dutch');
insert into Language (name) values ('Polish');
insert into Language (name) values ('Swedish');
insert into Language (name) values ('Danish');
insert into Language (name) values ('Norwegian');
insert into Language (name) values ('Finnish');
insert into Language (name) values ('Greek');
insert into Language (name) values ('Czech');
insert into Language (name) values ('Hungarian');
insert into Language (name) values ('Other');


-- GAME LANGUAGE
INSERT INTO GameLanguage (game, language) VALUES (1, 17);
INSERT INTO GameLanguage (game, language) VALUES (2, 14);
INSERT INTO GameLanguage (game, language) VALUES (2, 16);
INSERT INTO GameLanguage (game, language) VALUES (2, 7);
INSERT INTO GameLanguage (game, language) VALUES (2, 12);
INSERT INTO GameLanguage (game, language) VALUES (2, 8);
INSERT INTO GameLanguage (game, language) VALUES (2, 10);
INSERT INTO GameLanguage (game, language) VALUES (3, 7);
INSERT INTO GameLanguage (game, language) VALUES (3, 20);
INSERT INTO GameLanguage (game, language) VALUES (3, 11);
INSERT INTO GameLanguage (game, language) VALUES (3, 16);
INSERT INTO GameLanguage (game, language) VALUES (3, 21);
INSERT INTO GameLanguage (game, language) VALUES (4, 21);
INSERT INTO GameLanguage (game, language) VALUES (4, 5);
INSERT INTO GameLanguage (game, language) VALUES (4, 1);
INSERT INTO GameLanguage (game, language) VALUES (4, 10);
INSERT INTO GameLanguage (game, language) VALUES (4, 2);
INSERT INTO GameLanguage (game, language) VALUES (4, 9);
INSERT INTO GameLanguage (game, language) VALUES (5, 5);
INSERT INTO GameLanguage (game, language) VALUES (5, 22);
INSERT INTO GameLanguage (game, language) VALUES (5, 4);
INSERT INTO GameLanguage (game, language) VALUES (5, 2);
INSERT INTO GameLanguage (game, language) VALUES (5, 3);
INSERT INTO GameLanguage (game, language) VALUES (5, 11);
INSERT INTO GameLanguage (game, language) VALUES (6, 8);
INSERT INTO GameLanguage (game, language) VALUES (6, 14);
INSERT INTO GameLanguage (game, language) VALUES (6, 5);
INSERT INTO GameLanguage (game, language) VALUES (6, 16);
INSERT INTO GameLanguage (game, language) VALUES (6, 21);
INSERT INTO GameLanguage (game, language) VALUES (6, 18);
INSERT INTO GameLanguage (game, language) VALUES (6, 1);
INSERT INTO GameLanguage (game, language) VALUES (6, 3);
INSERT INTO GameLanguage (game, language) VALUES (7, 8);
INSERT INTO GameLanguage (game, language) VALUES (7, 13);
INSERT INTO GameLanguage (game, language) VALUES (7, 6);
INSERT INTO GameLanguage (game, language) VALUES (7, 9);
INSERT INTO GameLanguage (game, language) VALUES (8, 9);
INSERT INTO GameLanguage (game, language) VALUES (8, 14);
INSERT INTO GameLanguage (game, language) VALUES (9, 20);
INSERT INTO GameLanguage (game, language) VALUES (9, 17);
INSERT INTO GameLanguage (game, language) VALUES (9, 6);
INSERT INTO GameLanguage (game, language) VALUES (9, 3);
INSERT INTO GameLanguage (game, language) VALUES (10, 11);
INSERT INTO GameLanguage (game, language) VALUES (10, 18);
INSERT INTO GameLanguage (game, language) VALUES (11, 5);
INSERT INTO GameLanguage (game, language) VALUES (11, 3);
INSERT INTO GameLanguage (game, language) VALUES (11, 7);
INSERT INTO GameLanguage (game, language) VALUES (12, 21);
INSERT INTO GameLanguage (game, language) VALUES (12, 11);
INSERT INTO GameLanguage (game, language) VALUES (13, 18);
INSERT INTO GameLanguage (game, language) VALUES (13, 15);
INSERT INTO GameLanguage (game, language) VALUES (14, 17);
INSERT INTO GameLanguage (game, language) VALUES (14, 12);
INSERT INTO GameLanguage (game, language) VALUES (14, 5);
INSERT INTO GameLanguage (game, language) VALUES (14, 20);
INSERT INTO GameLanguage (game, language) VALUES (15, 15);
INSERT INTO GameLanguage (game, language) VALUES (15, 17);
INSERT INTO GameLanguage (game, language) VALUES (15, 12);
INSERT INTO GameLanguage (game, language) VALUES (15, 1);
INSERT INTO GameLanguage (game, language) VALUES (15, 7);
INSERT INTO GameLanguage (game, language) VALUES (15, 16);
INSERT INTO GameLanguage (game, language) VALUES (15, 5);
INSERT INTO GameLanguage (game, language) VALUES (15, 9);
INSERT INTO GameLanguage (game, language) VALUES (16, 3);
INSERT INTO GameLanguage (game, language) VALUES (16, 5);
INSERT INTO GameLanguage (game, language) VALUES (16, 10);
INSERT INTO GameLanguage (game, language) VALUES (16, 4);
INSERT INTO GameLanguage (game, language) VALUES (16, 11);
INSERT INTO GameLanguage (game, language) VALUES (16, 9);
INSERT INTO GameLanguage (game, language) VALUES (16, 6);
INSERT INTO GameLanguage (game, language) VALUES (16, 18);
INSERT INTO GameLanguage (game, language) VALUES (17, 15);
INSERT INTO GameLanguage (game, language) VALUES (17, 21);
INSERT INTO GameLanguage (game, language) VALUES (17, 6);
INSERT INTO GameLanguage (game, language) VALUES (17, 5);
INSERT INTO GameLanguage (game, language) VALUES (17, 7);
INSERT INTO GameLanguage (game, language) VALUES (18, 15);
INSERT INTO GameLanguage (game, language) VALUES (19, 19);
INSERT INTO GameLanguage (game, language) VALUES (19, 17);
INSERT INTO GameLanguage (game, language) VALUES (19, 21);
INSERT INTO GameLanguage (game, language) VALUES (19, 22);
INSERT INTO GameLanguage (game, language) VALUES (19, 12);
INSERT INTO GameLanguage (game, language) VALUES (19, 9);
INSERT INTO GameLanguage (game, language) VALUES (19, 20);
INSERT INTO GameLanguage (game, language) VALUES (19, 2);
INSERT INTO GameLanguage (game, language) VALUES (20, 15);
INSERT INTO GameLanguage (game, language) VALUES (21, 8);
INSERT INTO GameLanguage (game, language) VALUES (21, 16);
INSERT INTO GameLanguage (game, language) VALUES (21, 2);
INSERT INTO GameLanguage (game, language) VALUES (21, 22);
INSERT INTO GameLanguage (game, language) VALUES (21, 10);
INSERT INTO GameLanguage (game, language) VALUES (21, 13);
INSERT INTO GameLanguage (game, language) VALUES (21, 9);
INSERT INTO GameLanguage (game, language) VALUES (22, 3);
INSERT INTO GameLanguage (game, language) VALUES (22, 10);
INSERT INTO GameLanguage (game, language) VALUES (23, 9);
INSERT INTO GameLanguage (game, language) VALUES (23, 3);
INSERT INTO GameLanguage (game, language) VALUES (23, 1);
INSERT INTO GameLanguage (game, language) VALUES (23, 11);
INSERT INTO GameLanguage (game, language) VALUES (23, 6);
INSERT INTO GameLanguage (game, language) VALUES (24, 17);
INSERT INTO GameLanguage (game, language) VALUES (24, 19);
INSERT INTO GameLanguage (game, language) VALUES (24, 15);
INSERT INTO GameLanguage (game, language) VALUES (25, 20);
INSERT INTO GameLanguage (game, language) VALUES (25, 5);
INSERT INTO GameLanguage (game, language) VALUES (25, 14);
INSERT INTO GameLanguage (game, language) VALUES (26, 5);
INSERT INTO GameLanguage (game, language) VALUES (26, 19);
INSERT INTO GameLanguage (game, language) VALUES (26, 14);
INSERT INTO GameLanguage (game, language) VALUES (26, 13);
INSERT INTO GameLanguage (game, language) VALUES (26, 6);
INSERT INTO GameLanguage (game, language) VALUES (26, 11);
INSERT INTO GameLanguage (game, language) VALUES (27, 20);
INSERT INTO GameLanguage (game, language) VALUES (27, 18);
INSERT INTO GameLanguage (game, language) VALUES (27, 16);
INSERT INTO GameLanguage (game, language) VALUES (27, 6);
INSERT INTO GameLanguage (game, language) VALUES (28, 6);
INSERT INTO GameLanguage (game, language) VALUES (28, 17);
INSERT INTO GameLanguage (game, language) VALUES (28, 18);
INSERT INTO GameLanguage (game, language) VALUES (29, 21);
INSERT INTO GameLanguage (game, language) VALUES (29, 14);
INSERT INTO GameLanguage (game, language) VALUES (30, 12);
INSERT INTO GameLanguage (game, language) VALUES (30, 4);
INSERT INTO GameLanguage (game, language) VALUES (31, 6);
INSERT INTO GameLanguage (game, language) VALUES (31, 17);
INSERT INTO GameLanguage (game, language) VALUES (31, 14);
INSERT INTO GameLanguage (game, language) VALUES (31, 5);
INSERT INTO GameLanguage (game, language) VALUES (31, 16);
INSERT INTO GameLanguage (game, language) VALUES (32, 16);
INSERT INTO GameLanguage (game, language) VALUES (32, 13);
INSERT INTO GameLanguage (game, language) VALUES (32, 10);
INSERT INTO GameLanguage (game, language) VALUES (32, 11);
INSERT INTO GameLanguage (game, language) VALUES (32, 4);
INSERT INTO GameLanguage (game, language) VALUES (32, 21);
INSERT INTO GameLanguage (game, language) VALUES (32, 15);
INSERT INTO GameLanguage (game, language) VALUES (32, 3);
INSERT INTO GameLanguage (game, language) VALUES (33, 16);
INSERT INTO GameLanguage (game, language) VALUES (33, 13);
INSERT INTO GameLanguage (game, language) VALUES (34, 9);
INSERT INTO GameLanguage (game, language) VALUES (34, 17);
INSERT INTO GameLanguage (game, language) VALUES (34, 20);
INSERT INTO GameLanguage (game, language) VALUES (34, 22);
INSERT INTO GameLanguage (game, language) VALUES (35, 11);
INSERT INTO GameLanguage (game, language) VALUES (35, 1);
INSERT INTO GameLanguage (game, language) VALUES (35, 19);
INSERT INTO GameLanguage (game, language) VALUES (35, 6);
INSERT INTO GameLanguage (game, language) VALUES (36, 17);
INSERT INTO GameLanguage (game, language) VALUES (36, 7);
INSERT INTO GameLanguage (game, language) VALUES (37, 10);
INSERT INTO GameLanguage (game, language) VALUES (37, 18);
INSERT INTO GameLanguage (game, language) VALUES (37, 21);
INSERT INTO GameLanguage (game, language) VALUES (37, 8);
INSERT INTO GameLanguage (game, language) VALUES (37, 7);
INSERT INTO GameLanguage (game, language) VALUES (37, 12);
INSERT INTO GameLanguage (game, language) VALUES (38, 21);
INSERT INTO GameLanguage (game, language) VALUES (38, 22);
INSERT INTO GameLanguage (game, language) VALUES (38, 12);
INSERT INTO GameLanguage (game, language) VALUES (38, 2);
INSERT INTO GameLanguage (game, language) VALUES (38, 5);
INSERT INTO GameLanguage (game, language) VALUES (39, 14);
INSERT INTO GameLanguage (game, language) VALUES (39, 12);
INSERT INTO GameLanguage (game, language) VALUES (39, 7);
INSERT INTO GameLanguage (game, language) VALUES (40, 11);
INSERT INTO GameLanguage (game, language) VALUES (41, 11);
INSERT INTO GameLanguage (game, language) VALUES (41, 13);
INSERT INTO GameLanguage (game, language) VALUES (41, 12);
INSERT INTO GameLanguage (game, language) VALUES (41, 19);
INSERT INTO GameLanguage (game, language) VALUES (41, 18);
INSERT INTO GameLanguage (game, language) VALUES (41, 20);
INSERT INTO GameLanguage (game, language) VALUES (41, 7);
INSERT INTO GameLanguage (game, language) VALUES (42, 14);
INSERT INTO GameLanguage (game, language) VALUES (42, 11);
INSERT INTO GameLanguage (game, language) VALUES (42, 21);
INSERT INTO GameLanguage (game, language) VALUES (42, 15);
INSERT INTO GameLanguage (game, language) VALUES (42, 5);
INSERT INTO GameLanguage (game, language) VALUES (42, 17);
INSERT INTO GameLanguage (game, language) VALUES (42, 19);
INSERT INTO GameLanguage (game, language) VALUES (42, 6);
INSERT INTO GameLanguage (game, language) VALUES (43, 18);
INSERT INTO GameLanguage (game, language) VALUES (43, 19);
INSERT INTO GameLanguage (game, language) VALUES (43, 22);
INSERT INTO GameLanguage (game, language) VALUES (43, 17);
INSERT INTO GameLanguage (game, language) VALUES (43, 3);
INSERT INTO GameLanguage (game, language) VALUES (43, 2);
INSERT INTO GameLanguage (game, language) VALUES (44, 9);
INSERT INTO GameLanguage (game, language) VALUES (44, 22);
INSERT INTO GameLanguage (game, language) VALUES (44, 4);
INSERT INTO GameLanguage (game, language) VALUES (44, 14);
INSERT INTO GameLanguage (game, language) VALUES (44, 1);
INSERT INTO GameLanguage (game, language) VALUES (44, 20);
INSERT INTO GameLanguage (game, language) VALUES (44, 7);
INSERT INTO GameLanguage (game, language) VALUES (44, 2);
INSERT INTO GameLanguage (game, language) VALUES (45, 6);
INSERT INTO GameLanguage (game, language) VALUES (45, 11);
INSERT INTO GameLanguage (game, language) VALUES (45, 20);
INSERT INTO GameLanguage (game, language) VALUES (45, 5);
INSERT INTO GameLanguage (game, language) VALUES (45, 4);
INSERT INTO GameLanguage (game, language) VALUES (45, 14);
INSERT INTO GameLanguage (game, language) VALUES (45, 12);
INSERT INTO GameLanguage (game, language) VALUES (45, 10);
INSERT INTO GameLanguage (game, language) VALUES (46, 10);
INSERT INTO GameLanguage (game, language) VALUES (46, 4);
INSERT INTO GameLanguage (game, language) VALUES (46, 15);
INSERT INTO GameLanguage (game, language) VALUES (46, 11);
INSERT INTO GameLanguage (game, language) VALUES (46, 1);
INSERT INTO GameLanguage (game, language) VALUES (46, 3);
INSERT INTO GameLanguage (game, language) VALUES (46, 16);
INSERT INTO GameLanguage (game, language) VALUES (46, 19);
INSERT INTO GameLanguage (game, language) VALUES (47, 10);
INSERT INTO GameLanguage (game, language) VALUES (47, 18);
INSERT INTO GameLanguage (game, language) VALUES (47, 15);
INSERT INTO GameLanguage (game, language) VALUES (47, 11);
INSERT INTO GameLanguage (game, language) VALUES (47, 16);
INSERT INTO GameLanguage (game, language) VALUES (47, 21);
INSERT INTO GameLanguage (game, language) VALUES (48, 1);
INSERT INTO GameLanguage (game, language) VALUES (48, 20);
INSERT INTO GameLanguage (game, language) VALUES (48, 14);
INSERT INTO GameLanguage (game, language) VALUES (48, 12);
INSERT INTO GameLanguage (game, language) VALUES (48, 22);
INSERT INTO GameLanguage (game, language) VALUES (49, 12);
INSERT INTO GameLanguage (game, language) VALUES (50, 19);
INSERT INTO GameLanguage (game, language) VALUES (50, 8);
INSERT INTO GameLanguage (game, language) VALUES (50, 4);
INSERT INTO GameLanguage (game, language) VALUES (50, 16);
INSERT INTO GameLanguage (game, language) VALUES (50, 10);
INSERT INTO GameLanguage (game, language) VALUES (50, 11);
INSERT INTO GameLanguage (game, language) VALUES (51, 1);
INSERT INTO GameLanguage (game, language) VALUES (51, 20);
INSERT INTO GameLanguage (game, language) VALUES (51, 2);
INSERT INTO GameLanguage (game, language) VALUES (51, 10);
INSERT INTO GameLanguage (game, language) VALUES (52, 9);
INSERT INTO GameLanguage (game, language) VALUES (52, 18);
INSERT INTO GameLanguage (game, language) VALUES (52, 17);
INSERT INTO GameLanguage (game, language) VALUES (52, 16);
INSERT INTO GameLanguage (game, language) VALUES (52, 21);
INSERT INTO GameLanguage (game, language) VALUES (52, 10);
INSERT INTO GameLanguage (game, language) VALUES (52, 1);
INSERT INTO GameLanguage (game, language) VALUES (53, 7);
INSERT INTO GameLanguage (game, language) VALUES (53, 20);
INSERT INTO GameLanguage (game, language) VALUES (53, 18);
INSERT INTO GameLanguage (game, language) VALUES (53, 14);
INSERT INTO GameLanguage (game, language) VALUES (54, 17);
INSERT INTO GameLanguage (game, language) VALUES (54, 4);
INSERT INTO GameLanguage (game, language) VALUES (54, 3);
INSERT INTO GameLanguage (game, language) VALUES (54, 15);
INSERT INTO GameLanguage (game, language) VALUES (54, 16);
INSERT INTO GameLanguage (game, language) VALUES (55, 6);
INSERT INTO GameLanguage (game, language) VALUES (55, 17);
INSERT INTO GameLanguage (game, language) VALUES (55, 11);
INSERT INTO GameLanguage (game, language) VALUES (55, 1);
INSERT INTO GameLanguage (game, language) VALUES (55, 4);
INSERT INTO GameLanguage (game, language) VALUES (55, 22);
INSERT INTO GameLanguage (game, language) VALUES (56, 9);
INSERT INTO GameLanguage (game, language) VALUES (56, 21);
INSERT INTO GameLanguage (game, language) VALUES (56, 10);
INSERT INTO GameLanguage (game, language) VALUES (56, 2);
INSERT INTO GameLanguage (game, language) VALUES (56, 17);
INSERT INTO GameLanguage (game, language) VALUES (56, 1);
INSERT INTO GameLanguage (game, language) VALUES (56, 20);
INSERT INTO GameLanguage (game, language) VALUES (57, 7);
INSERT INTO GameLanguage (game, language) VALUES (57, 17);
INSERT INTO GameLanguage (game, language) VALUES (57, 3);
INSERT INTO GameLanguage (game, language) VALUES (57, 10);
INSERT INTO GameLanguage (game, language) VALUES (57, 9);
INSERT INTO GameLanguage (game, language) VALUES (57, 20);
INSERT INTO GameLanguage (game, language) VALUES (57, 1);
INSERT INTO GameLanguage (game, language) VALUES (57, 22);
INSERT INTO GameLanguage (game, language) VALUES (58, 8);
INSERT INTO GameLanguage (game, language) VALUES (58, 9);
INSERT INTO GameLanguage (game, language) VALUES (58, 15);
INSERT INTO GameLanguage (game, language) VALUES (58, 22);
INSERT INTO GameLanguage (game, language) VALUES (58, 7);
INSERT INTO GameLanguage (game, language) VALUES (58, 6);
INSERT INTO GameLanguage (game, language) VALUES (58, 21);
INSERT INTO GameLanguage (game, language) VALUES (58, 5);
INSERT INTO GameLanguage (game, language) VALUES (59, 5);
INSERT INTO GameLanguage (game, language) VALUES (60, 16);


-- PLAYER
insert into Player (name) values ('SinglePlayer');
insert into Player (name) values ('MultiPlayer');


-- GAME PLAYER
INSERT INTO GamePlayer (game, player) VALUES (1, 2);
INSERT INTO GamePlayer (game, player) VALUES (2, 1);
INSERT INTO GamePlayer (game, player) VALUES (2, 2);
INSERT INTO GamePlayer (game, player) VALUES (3, 2);
INSERT INTO GamePlayer (game, player) VALUES (3, 1);
INSERT INTO GamePlayer (game, player) VALUES (4, 1);
INSERT INTO GamePlayer (game, player) VALUES (4, 2);
INSERT INTO GamePlayer (game, player) VALUES (5, 1);
INSERT INTO GamePlayer (game, player) VALUES (5, 2);
INSERT INTO GamePlayer (game, player) VALUES (6, 2);
INSERT INTO GamePlayer (game, player) VALUES (6, 1);
INSERT INTO GamePlayer (game, player) VALUES (7, 2);
INSERT INTO GamePlayer (game, player) VALUES (7, 1);
INSERT INTO GamePlayer (game, player) VALUES (8, 1);
INSERT INTO GamePlayer (game, player) VALUES (9, 1);
INSERT INTO GamePlayer (game, player) VALUES (10, 2);
INSERT INTO GamePlayer (game, player) VALUES (11, 1);
INSERT INTO GamePlayer (game, player) VALUES (11, 2);
INSERT INTO GamePlayer (game, player) VALUES (12, 1);
INSERT INTO GamePlayer (game, player) VALUES (13, 2);
INSERT INTO GamePlayer (game, player) VALUES (14, 2);
INSERT INTO GamePlayer (game, player) VALUES (15, 1);
INSERT INTO GamePlayer (game, player) VALUES (16, 1);
INSERT INTO GamePlayer (game, player) VALUES (17, 2);
INSERT INTO GamePlayer (game, player) VALUES (17, 1);
INSERT INTO GamePlayer (game, player) VALUES (18, 2);
INSERT INTO GamePlayer (game, player) VALUES (19, 2);
INSERT INTO GamePlayer (game, player) VALUES (19, 1);
INSERT INTO GamePlayer (game, player) VALUES (20, 2);
INSERT INTO GamePlayer (game, player) VALUES (21, 1);
INSERT INTO GamePlayer (game, player) VALUES (22, 2);
INSERT INTO GamePlayer (game, player) VALUES (23, 1);
INSERT INTO GamePlayer (game, player) VALUES (24, 2);
INSERT INTO GamePlayer (game, player) VALUES (24, 1);
INSERT INTO GamePlayer (game, player) VALUES (25, 2);
INSERT INTO GamePlayer (game, player) VALUES (25, 1);
INSERT INTO GamePlayer (game, player) VALUES (26, 1);
INSERT INTO GamePlayer (game, player) VALUES (27, 2);
INSERT INTO GamePlayer (game, player) VALUES (27, 1);
INSERT INTO GamePlayer (game, player) VALUES (28, 1);
INSERT INTO GamePlayer (game, player) VALUES (29, 1);
INSERT INTO GamePlayer (game, player) VALUES (30, 1);
INSERT INTO GamePlayer (game, player) VALUES (31, 1);
INSERT INTO GamePlayer (game, player) VALUES (32, 2);
INSERT INTO GamePlayer (game, player) VALUES (33, 1);
INSERT INTO GamePlayer (game, player) VALUES (34, 1);
INSERT INTO GamePlayer (game, player) VALUES (34, 2);
INSERT INTO GamePlayer (game, player) VALUES (35, 1);
INSERT INTO GamePlayer (game, player) VALUES (36, 2);
INSERT INTO GamePlayer (game, player) VALUES (36, 1);
INSERT INTO GamePlayer (game, player) VALUES (37, 1);
INSERT INTO GamePlayer (game, player) VALUES (37, 2);
INSERT INTO GamePlayer (game, player) VALUES (38, 1);
INSERT INTO GamePlayer (game, player) VALUES (38, 2);
INSERT INTO GamePlayer (game, player) VALUES (39, 2);
INSERT INTO GamePlayer (game, player) VALUES (39, 1);
INSERT INTO GamePlayer (game, player) VALUES (40, 2);
INSERT INTO GamePlayer (game, player) VALUES (41, 1);
INSERT INTO GamePlayer (game, player) VALUES (41, 2);
INSERT INTO GamePlayer (game, player) VALUES (42, 1);
INSERT INTO GamePlayer (game, player) VALUES (42, 2);
INSERT INTO GamePlayer (game, player) VALUES (43, 2);
INSERT INTO GamePlayer (game, player) VALUES (44, 2);
INSERT INTO GamePlayer (game, player) VALUES (44, 1);
INSERT INTO GamePlayer (game, player) VALUES (45, 2);
INSERT INTO GamePlayer (game, player) VALUES (46, 1);
INSERT INTO GamePlayer (game, player) VALUES (47, 1);
INSERT INTO GamePlayer (game, player) VALUES (47, 2);
INSERT INTO GamePlayer (game, player) VALUES (48, 1);
INSERT INTO GamePlayer (game, player) VALUES (49, 2);
INSERT INTO GamePlayer (game, player) VALUES (50, 2);
INSERT INTO GamePlayer (game, player) VALUES (51, 1);
INSERT INTO GamePlayer (game, player) VALUES (51, 2);
INSERT INTO GamePlayer (game, player) VALUES (52, 1);
INSERT INTO GamePlayer (game, player) VALUES (53, 2);
INSERT INTO GamePlayer (game, player) VALUES (53, 1);
INSERT INTO GamePlayer (game, player) VALUES (54, 1);
INSERT INTO GamePlayer (game, player) VALUES (55, 1);
INSERT INTO GamePlayer (game, player) VALUES (55, 2);
INSERT INTO GamePlayer (game, player) VALUES (56, 2);
INSERT INTO GamePlayer (game, player) VALUES (56, 1);
INSERT INTO GamePlayer (game, player) VALUES (57, 2);
INSERT INTO GamePlayer (game, player) VALUES (58, 1);
INSERT INTO GamePlayer (game, player) VALUES (59, 2);
INSERT INTO GamePlayer (game, player) VALUES (60, 2);


-- PaymentMethod (9)
insert into PaymentMethod (name, image_path) values ('Alipay', 'images/payment/alipay.svg');
insert into PaymentMethod (name, image_path) values ('American Express', 'images/payment/american_express.svg');
insert into PaymentMethod (name, image_path) values ('Apple Pay', 'images/payment/applepay.svg');
insert into PaymentMethod (name, image_path) values ('Bitcoin', 'images/payment/bitcoin.svg');
insert into PaymentMethod (name, image_path) values ('Google Pay', 'images/payment/googlepay.svg');
insert into PaymentMethod (name, image_path) values ('Mastercard', 'images/payment/mastercard.svg');
insert into PaymentMethod (name, image_path) values ('Paypal', 'images/payment/paypal.svg');
insert into PaymentMethod (name, image_path) values ('Visa', 'images/payment/visa.svg');
insert into PaymentMethod (name, image_path) values ('Multibanco', 'images/payment/mb.svg');


-- Payment
insert into Payment (method, value) values (1, 164.96); -- order 1
insert into Payment (method, value) values (2, 149.97); -- order 2
insert into Payment (method, value) values (3, 74.98); -- order 3
insert into Payment (method, value) values (4, 49.99); -- order 4
insert into Payment (method, value) values (5, 24.99); -- order 5
insert into Payment (method, value) values (6, 49.99); -- order 6
insert into Payment (method, value) values (7, 49.99); -- order 7
insert into Payment (method, value) values (8, 49.99); -- order 8
insert into Payment (method, value) values (9, 49.99); -- order 9
insert into Payment (method, value) values (1, 19.99); -- order 10
insert into Payment (method, value) values (2, 34.99); -- order 11
insert into Payment (method, value) values (3, 39.99); -- order 12
insert into Payment (method, value) values (4, 44.98); -- order 13
insert into Payment (method, value) values (5, 24.99); -- order 14


-- Orders
insert into Orders (buyer, payment, time, coins) values (1, 1, '2024-12-01 01:00:00', 0); -- 1
insert into Orders (buyer, payment, time, coins) values (1, 2, '2024-12-05 02:00:00', 0); -- 2
insert into Orders (buyer, payment, time, coins) values (1, 3, '2024-11-30 03:00:00', 0); -- 3
insert into Orders (buyer, payment, time, coins) values (1, 4, '2024-11-01 04:00:00', 0); -- 4
insert into Orders (buyer, payment, time, coins) values (1, 5, '2024-12-04 05:00:00', 0); -- 5
insert into Orders (buyer, payment, time, coins) values (1, 6, '2024-12-16 06:00:00', 0); -- 6
insert into Orders (buyer, payment, time, coins) values (2, 7, '2024-10-10 07:00:00', 0); -- 7
insert into Orders (buyer, payment, time, coins) values (3, 8, '2024-12-01 08:00:00', 0); -- 8
insert into Orders (buyer, payment, time, coins) values (4, 9, '2024-12-01 09:00:00', 0); -- 9
insert into Orders (buyer, payment, time, coins) values (5, 10, '2024-12-01 10:00:00', 0); -- 10
insert into Orders (buyer, payment, time, coins) values (6, 11, '2024-12-01 11:00:00', 0); -- 11
insert into Orders (buyer, payment, time, coins) values (7, 12, '2024-12-01 12:00:00', 0); -- 12
insert into Orders (buyer, payment, time, coins) values (8, 13, '2024-12-01 13:00:00', 0); -- 13
insert into Orders (buyer, payment, time, coins) values (9, 14, '2024-12-01 14:00:00', 0); -- 14


-- Purchase (20)
insert into Purchase (order_, value) values (1, 49.99); -- 1. game 1
insert into Purchase (order_, value) values (1, 34.99); -- 2. game 2
insert into Purchase (order_, value) values (1, 19.99); -- 3. game 3
insert into Purchase (order_, value) values (1, 59.99); -- 4. game 4
insert into Purchase (order_, value) values (2, 49.99); -- 5. game 1
insert into Purchase (order_, value) values (2, 49.99); -- 6. game 1
insert into Purchase (order_, value) values (2, 49.99); -- 7. game 1
insert into Purchase (order_, value) values (3, 49.99); -- 8. game 1
insert into Purchase (order_, value) values (3, 24.99); -- 9. game 20
insert into Purchase (order_, value) values (4, 49.99); -- 10. game 1
insert into Purchase (order_, value) values (5, 24.99); -- 11. game 20
insert into Purchase (order_, value) values (6, 49.99); -- 12. game 1
insert into Purchase (order_, value) values (7, 49.99); -- 13. game 1
insert into Purchase (order_, value) values (8, 49.99); -- 14. game 1
insert into Purchase (order_, value) values (9, 49.99); -- 15. game 1
insert into Purchase (order_, value) values (10, 19.99); -- 16. game 3
insert into Purchase (order_, value) values (11, 34.99); -- 17. game 2
insert into Purchase (order_, value) values (12, 39.99); -- 18. game 5
insert into Purchase (order_, value) values (13, 19.99); -- 19. game 10
insert into Purchase (order_, value) values (13, 24.99); -- 20. game 20
insert into Purchase (order_, value) values (14, 24.99); -- 21. game 20


-- Delivered Purchase
insert into DeliveredPurchase (id, cdk) values (1, 1);
insert into DeliveredPurchase (id, cdk) values (2, 21);
insert into DeliveredPurchase (id, cdk) values (3, 31);
insert into DeliveredPurchase (id, cdk) values (4, 41);
insert into DeliveredPurchase (id, cdk) values (5, 2);
insert into DeliveredPurchase (id, cdk) values (6, 3);
insert into DeliveredPurchase (id, cdk) values (7, 4);
insert into DeliveredPurchase (id, cdk) values (8, 5);
insert into DeliveredPurchase (id, cdk) values (9, 201);
insert into DeliveredPurchase (id, cdk) values (10, 6);
insert into DeliveredPurchase (id, cdk) values (11, 202);
insert into DeliveredPurchase (id, cdk) values (12, 7);
insert into DeliveredPurchase (id, cdk) values (13, 8);
insert into DeliveredPurchase (id, cdk) values (14, 9);
insert into DeliveredPurchase (id, cdk) values (15, 10);
insert into DeliveredPurchase (id, cdk) values (16, 32);
insert into DeliveredPurchase (id, cdk) values (17, 22);
insert into DeliveredPurchase (id, cdk) values (18, 51);
insert into DeliveredPurchase (id, cdk) values (19, 101);
insert into DeliveredPurchase (id, cdk) values (20, 203);
insert into DeliveredPurchase (id, cdk) values (21, 204);


-- Review
-- Game 1
insert into Review (title, description, positive, author, game) values ('Amazing Gameplay', 'The gameplay is smooth and engaging. Highly recommend!', true, 1, 1);
insert into Review (title, description, positive, author, game) values ('Great Graphics', 'The graphics are stunning and very detailed.', true, 3, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 4, 1);

-- Game 2
insert into Review (title, description, positive, author, game) values ('Boring Storyline', 'The storyline is very predictable and boring.', false, 1, 2);
insert into Review (title, description, positive, author, game) values ('Too Many Bugs', 'The game has too many bugs and crashes often.', false, 6, 2);

-- Game 3
insert into Review (title, description, positive, author, game) values ('Immersive Experience', 'The game provides an immersive experience with its detailed world.', true, 1, 3);
insert into Review (title, description, positive, author, game) values ('Lack of Content', 'The game lacks content and gets repetitive quickly.', false, 5, 3);

-- Game 4
insert into Review (title, description, positive, author, game) values ('Fun and Addictive', 'The game is very fun and addictive. Cannot stop playing!', true, 1, 4);

-- Game 5
insert into Review (title, description, positive, author, game) values ('Poor Controls', 'The controls are not responsive and hard to use.', false, 7, 5);

-- Game 10
insert into Review (title, description, positive, author, game) values ('Great Graphics', 'The graphics are stunning and very detailed.', true, 8, 10);

-- Game 20
insert into Review (title, description, positive, author, game) values ('Amazing Soundtrack', 'The soundtrack is amazing and fits the game perfectly.', true, 1, 20);
insert into Review (title, description, positive, author, game) values ('Excellent Storyline', 'The storyline is captivating and well-written.', true, 8, 20);
insert into Review (title, description, positive, author, game) values ('Too Many Bugs', 'The game has too many bugs and crashes often.', false, 9, 20);

-- Game 1 Extra Fake
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 2, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 5, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 6, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 7, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 8, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 9, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 10, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 23, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 24, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 25, 1);
insert into Review (title, description, positive, author, game) values ('Excellent Multiplayer', 'The multiplayer mode is very fun and competitive.', true, 26, 1);
insert into Review (title, description, positive, author, game) values ('Not my taste', 'The multiplayer mode is very fun and competitive, although, minecraft is better.', false, 27, 1);


-- Review Like
insert into ReviewLike (review, author) values (1, 2);
insert into ReviewLike (review, author) values (1, 10);
insert into ReviewLike (review, author) values (1, 3);
insert into ReviewLike (review, author) values (1, 5);
insert into ReviewLike (review, author) values (2, 3);
insert into ReviewLike (review, author) values (2, 1);
insert into ReviewLike (review, author) values (2, 6);
insert into ReviewLike (review, author) values (3, 4);
insert into ReviewLike (review, author) values (5, 2);
insert into ReviewLike (review, author) values (5, 3);
insert into ReviewLike (review, author) values (5, 4);
insert into ReviewLike (review, author) values (5, 5);
insert into ReviewLike (review, author) values (5, 6);
insert into ReviewLike (review, author) values (5, 7);
insert into ReviewLike (review, author) values (5, 8);
insert into ReviewLike (review, author) values (6, 1);
insert into ReviewLike (review, author) values (7, 8);
insert into ReviewLike (review, author) values (7, 10);
insert into ReviewLike (review, author) values (9, 9);
insert into ReviewLike (review, author) values (10, 9);
insert into ReviewLike (review, author) values (11, 9);
insert into ReviewLike (review, author) values (12, 9);
insert into ReviewLike (review, author) values (13, 9);


-- Reason
insert into Reason (description) values ('Inappropriate content');
insert into Reason (description) values ('Spam or misleading');
insert into Reason (description) values ('Harassment or bullying');
insert into Reason (description) values ('Offensive language');
insert into Reason (description) values ('Impersonation or fake account');
insert into Reason (description) values ('Violation of community guidelines');
insert into Reason (description) values ('Posting illegal content');
insert into Reason (description) values ('False information');


-- FAQ
insert into FAQ (question, answer) values ('How do I redeem a CDK?', 'To redeem a CDK, you must go to the platform where the game is available and enter the code in the corresponding section.');
insert into FAQ (question, answer) values ('What is a CDK?', 'A CDK is a code that allows you to download a game from a digital platform.');
insert into FAQ (question, answer) values ('What is the difference between a CDK and a game key?', 'There is no difference, both terms refer to the same thing.');
insert into FAQ (question, answer) values ('How do I know if a CDK is valid?', 'You can check if a CDK is valid by entering it in the corresponding section of the platform where the game is available.');
insert into FAQ (question, answer) values ('Can I use a CDK more than once?', 'No, a CDK can only be used once.');
insert into FAQ (question, answer) values ('Can I return a CDK?', 'No, CDKs cannot be returned.');


-- ABOUT 
insert into About (content) values ('This website was created as a project for the Database and Web Applications Laboratory (LBAW) course at the University of Porto (FEUP), during the 2024/2025 academic year.');
insert into About (content) values ('Bruno Huang, up202207517@up.pt');
insert into About (content) values ('Daniel Basílio, up201806838@up.pt');
insert into About (content) values ('Francisco Magalhães, up202007945@up.pt');
insert into About (content) values ('Ricardo Yang, up202208465@up.pt');


-- CONTACT
insert into Contacts (contact) values ('contact@steal.com');