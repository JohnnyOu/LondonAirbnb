-- Team members: Charles Fruitman, Junyan Ou
-- Final project

DROP DATABASE IF EXISTS Airbnb;
CREATE DATABASE IF NOT EXISTS Airbnb; 

SET SQL_SAFE_UPDATES = 0;


USE Airbnb;

-- Create and load listings mega-table
DROP TABLE IF EXISTS listings;
CREATE TABLE listings (
	id INT UNSIGNED,
    listing_url VARCHAR(40),
    scrape_id BIGINT(14) UNSIGNED,
    last_scraped DATE,
    name VARCHAR(150),
    summary TEXT,
    space TEXT,
    description TEXT,
    experiences_offered VARCHAR(10) CHECK(experiences_offered IN ('family', 'social', 'business', 'romantic', 'none')),
    neighborhood_overview TEXT,
    notes TEXT,
    transit TEXT,
    access TEXT,
    interaction TEXT,
    house_rules TEXT,
    thumbnail_url VARCHAR(250),
    medium_url VARCHAR(250),
    picture_url VARCHAR(250),
    xl_picture_url VARCHAR(250),
    host_id INT UNSIGNED,
    host_url VARCHAR(50),
    host_name VARCHAR(50),
    host_since DATE,
    host_location VARCHAR(100),
    host_about TEXT,
    host_response_time VARCHAR(25),
    host_response_rate TINYINT UNSIGNED CHECK(host_response_rate <= 100),
    host_acceptance_rate TINYINT UNSIGNED CHECK(host_acceptance_rate <= 100),
    host_is_superhost CHAR(1) CHECK(host_is_superhost IN ('t', 'f')),
    host_thumbnail_url VARCHAR(250),
    host_picture_url VARCHAR(250),
    host_neighbourhood VARCHAR(25),
    host_listings_count SMALLINT UNSIGNED,
    host_total_listings_count SMALLINT UNSIGNED,
    host_verifications VARCHAR(250),
    host_has_profile_pic CHAR(1) CHECK(host_has_profile_pic IN ('t', 'f')),
    host_identity_verified CHAR(1) CHECK (host_identity_verified IN ('t', 'f')),
    street VARCHAR(50),
    neighbourhood VARCHAR(50),
    neighbourhood_cleansed VARCHAR(50),
    neighbourhood_group_cleansed CHAR(0) NULL,
    city VARCHAR(100),
    state VARCHAR(100),
    zipcode VARCHAR(10),
    market VARCHAR(50),
    smart_location VARCHAR(200),
    country_code CHAR(2),
    country VARCHAR(25),
    latitude DECIMAL(7, 5),
    longitude DECIMAL(8, 5),
    is_location_exact CHAR(1) CHECK(is_location_exact IN ('t', 'f')),
    property_type VARCHAR(25),
	room_type VARCHAR(15) CHECK(room_type IN ('Entire home/apt', 'Private room')),
	accommodates TINYINT UNSIGNED,
	bathrooms DECIMAL (3,1),
	bedrooms TINYINT UNSIGNED,
	beds TINYINT UNSIGNED,
    bed_type VARCHAR(20),
	amenities TEXT,
	square_feet SMALLINT UNSIGNED,
	price SMALLINT UNSIGNED,
	weekly_price SMALLINT UNSIGNED,
	monthly_price SMALLINT UNSIGNED,
	security_deposit SMALLINT UNSIGNED,
	cleaning_fee SMALLINT UNSIGNED,
	guests_included TINYINT UNSIGNED,
	extra_people TINYINT UNSIGNED,
	minimum_nights TINYINT UNSIGNED,
	maximum_nights SMALLINT UNSIGNED,
	minimum_minimum_nights TINYINT UNSIGNED,
	maximum_minimum_nights SMALLINT UNSIGNED,
	minimum_maximum_nights SMALLINT UNSIGNED,
	maximum_maximum_nights SMALLINT UNSIGNED,
	minimum_nights_avg_ntm DECIMAL (4,1) UNSIGNED,
	maximum_nights_avg_ntm DECIMAL (5,1) UNSIGNED,
	calendar_updated VARCHAR(20),
	has_availability CHAR(1) CHECK(has_availability IN ('t', 'f')),
	availability_30 TINYINT UNSIGNED CHECK(availability_30 <= 30),
	availability_60 TINYINT UNSIGNED CHECK(availability_60 <= 60),
	availability_90 TINYINT UNSIGNED CHECK(availability_90 <= 90),
	availability_365 SMALLINT UNSIGNED CHECK(availability_365 <= 365),
	calendar_last_scraped SMALLINT UNSIGNED,
	number_of_reviews SMALLINT UNSIGNED,
	number_of_reviews_ltm TINYINT UNSIGNED,
	first_review SMALLINT UNSIGNED,
	last_review SMALLINT UNSIGNED,
	review_scores_rating TINYINT UNSIGNED CHECK(review_scores_rating <= 100),
	review_scores_accuracy TINYINT UNSIGNED CHECK(review_scores_accuracy <= 10),
	review_scores_cleanliness TINYINT UNSIGNED CHECK(review_scores_cleanliness <= 10),
	review_scores_checkin TINYINT UNSIGNED CHECK(review_scores_checkin <= 10),
	review_scores_communication TINYINT UNSIGNED CHECK(review_scores_communication <= 10),
	review_scores_location TINYINT UNSIGNED CHECK(review_scores_location <= 10),
	review_scores_value TINYINT UNSIGNED CHECK(review_scores_value <= 10),
	requires_license CHAR(1) CHECK(requires_license IN ('t', 'f')),
	license VARCHAR(30),
	jurisdiction_names VARCHAR(30),
	instant_bookable CHAR(1) CHECK(instant_bookable IN ('t', 'f')),
	is_business_travel_ready CHAR(1) CHECK(is_business_travel_ready IN ('t', 'f')),
	cancellation_policy VARCHAR(27) CHECK(cancellation_policy IN('strict_14_with_grace_period',
										'super_strict_30', 'flexible', 'moderate')),
	require_guest_profile_picture CHAR(1) CHECK(require_guest_profile_picture IN ('t', 'f')),
	require_guest_phone_verification CHAR(1) CHECK(require_guest_phone_verification IN ('t', 'f')),
	calculated_host_listings_count TINYINT UNSIGNED,
	calculated_host_listings_count_entire_homes TINYINT UNSIGNED,
	calculated_host_listings_count_private_rooms TINYINT UNSIGNED,
	calculated_host_listings_count_shared_rooms TINYINT UNSIGNED,
	reviews_per_month DECIMAL(4,2) UNSIGNED, 
	PRIMARY KEY (id)
) ENGINE = InnoDB;





LOAD DATA LOCAL INFILE '/Users/oujunyan/Desktop/At Vanderbilt/2_Sophomore/2020_Summer/7_CS_3265/project/listings.csv' 
INTO TABLE listings
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
ESCAPED BY '\\'
IGNORE 1 ROWS;

UPDATE listings
SET host_since = NULL
WHERE host_since = 0;





DROP TABLE IF EXISTS listings_host;
CREATE TABLE listings_host (
	host_id INT UNSIGNED,
    host_url VARCHAR(50),
    host_name VARCHAR(50),
    host_since DATE,
    host_location VARCHAR(100),
    host_about TEXT,
    host_response_time VARCHAR(25),
    host_response_rate TINYINT UNSIGNED CHECK(host_response_rate <= 100), 
    host_acceptance_rate TINYINT UNSIGNED CHECK(host_acceptance_rate <= 100),
    host_is_superhost CHAR(1) CHECK(host_is_superhost IN ('t', 'f')),
    host_thumbnail_url VARCHAR(250),
    host_picture_url VARCHAR(250),
    host_neighbourhood VARCHAR(25),
    host_listings_count SMALLINT UNSIGNED,
    host_total_listings_count SMALLINT UNSIGNED,
    host_verifications VARCHAR(250),
    host_has_profile_pic CHAR(1) CHECK(host_has_profile_pic IN ('t', 'f')),
    host_identity_verified CHAR(1) CHECK (host_identity_verified IN ('t', 'f')), 
	calculated_host_listings_count TINYINT UNSIGNED,
	calculated_host_listings_count_entire_homes TINYINT UNSIGNED,
	calculated_host_listings_count_private_rooms TINYINT UNSIGNED,
	calculated_host_listings_count_shared_rooms TINYINT UNSIGNED,
    PRIMARY KEY (host_id)
) ENGINE = InnoDB;

INSERT INTO listings_host
	SELECT DISTINCT host_id, host_url, host_name, host_since, host_location, host_about,
    host_response_time,
    host_response_rate,
    host_acceptance_rate,
    host_is_superhost,
    host_thumbnail_url,
    host_picture_url,
    host_neighbourhood,
    host_listings_count,
    host_total_listings_count,
    host_verifications,
    host_has_profile_pic,
    host_identity_verified,
	calculated_host_listings_count,
	calculated_host_listings_count_entire_homes,
	calculated_host_listings_count_private_rooms,
	calculated_host_listings_count_shared_rooms
    FROM listings;

DROP TABLE IF EXISTS listings_location;
CREATE TABLE listings_location (
	id INT UNSIGNED,
    latitude DECIMAL(7, 5),
    longitude DECIMAL(8, 5),
	neighbourhood VARCHAR(50),
    neighbourhood_cleansed VARCHAR(50),
    neighbourhood_group_cleansed CHAR(0) NULL,
    city VARCHAR(100),
    state VARCHAR(100),
    zipcode VARCHAR(10),
    market VARCHAR(50),
    smart_location VARCHAR(200),
    country_code CHAR(2),
    country VARCHAR(25),
	is_location_exact CHAR(1) CHECK(is_location_exact IN ('t', 'f')),
    PRIMARY KEY (id)
) ENGINE = InnoDB;

INSERT INTO listings_location
	SELECT DISTINCT id, latitude,
    longitude,
	neighbourhood,
    neighbourhood_cleansed,
    neighbourhood_group_cleansed,
    city,
    state,
    zipcode,
    market,
    smart_location,
    country_code,
    country,
	is_location_exact
    FROM listings;

DROP TABLE IF EXISTS listings_details;
CREATE TABLE listings_details (
	id INT UNSIGNED, 
	host_id INT UNSIGNED,
    name VARCHAR(150),
    summary TEXT,
    space TEXT,
    description TEXT,
    experiences_offered VARCHAR(10) CHECK(experiences_offered IN ('family', 'social', 'business', 'romantic', 'none')),
    neighborhood_overview TEXT,
    notes TEXT,
    transit TEXT,
    access TEXT,
    interaction TEXT,
    house_rules TEXT, 
	property_type VARCHAR(25),
	room_type VARCHAR(15) CHECK(room_type IN ('Entire home/apt', 'Private room')),
	accommodates TINYINT UNSIGNED,
	bathrooms DECIMAL (3,1),
	bedrooms TINYINT UNSIGNED,
	beds TINYINT UNSIGNED,
    bed_type VARCHAR(20),
	amenities TEXT,
	square_feet SMALLINT UNSIGNED,
    PRIMARY KEY (id), 
    CONSTRAINT fk_id_details FOREIGN KEY (id) 
		REFERENCES listings_location (id) 
        ON UPDATE CASCADE
        ON DELETE CASCADE, 
	CONSTRAINT fk_host_id_details FOREIGN KEY (host_id)
		REFERENCES listings_host (host_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB;

INSERT INTO listings_details
	SELECT id,
    host_id,
    name,
    summary,
    space,
    description,
    experiences_offered,
    neighborhood_overview,
    notes,
    transit,
    access,
    interaction,
    house_rules,
	property_type,
	room_type,
	accommodates,
	bathrooms,
	bedrooms,
	beds,
    bed_type,
	amenities,
	square_feet
    FROM listings;

DROP TABLE IF EXISTS listings_url;
CREATE TABLE listings_url (
	id INT UNSIGNED, 
	listing_url VARCHAR(40),
	thumbnail_url VARCHAR(250),
    medium_url VARCHAR(250),
    picture_url VARCHAR(250),
    xl_picture_url VARCHAR(250),
    PRIMARY KEY (id), 
    CONSTRAINT fk_id_url FOREIGN KEY (id) 
		REFERENCES listings_location (id) 
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB;

INSERT INTO listings_url
	SELECT id,
	listing_url,
	thumbnail_url,
    medium_url,
    picture_url,
    xl_picture_url 
    FROM listings;

DROP TABLE IF EXISTS listings_review;
CREATE TABLE listings_review (
	id INT UNSIGNED,
	number_of_reviews SMALLINT UNSIGNED,
	number_of_reviews_ltm TINYINT UNSIGNED,
	first_review SMALLINT UNSIGNED,
	last_review SMALLINT UNSIGNED,
	review_scores_rating TINYINT UNSIGNED CHECK(review_scores_rating <= 100),
	review_scores_accuracy TINYINT UNSIGNED CHECK(review_scores_accuracy <= 10),
	review_scores_cleanliness TINYINT UNSIGNED CHECK(review_scores_cleanliness <= 10),
	review_scores_checkin TINYINT UNSIGNED CHECK(review_scores_checkin <= 10),
	review_scores_communication TINYINT UNSIGNED CHECK(review_scores_communication <= 10),
	review_scores_location TINYINT UNSIGNED CHECK(review_scores_location <= 10),
	review_scores_value TINYINT UNSIGNED CHECK(review_scores_value <= 10),
	reviews_per_month DECIMAL(4,2) UNSIGNED, 
    PRIMARY KEY (id), 
    CONSTRAINT fk_id_review FOREIGN KEY (id) 
		REFERENCES listings_location (id) 
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB;

INSERT INTO listings_review
	SELECT id,
	number_of_reviews,
	number_of_reviews_ltm,
	first_review,
	last_review,
	review_scores_rating,
	review_scores_accuracy,
	review_scores_cleanliness,
	review_scores_checkin,
	review_scores_communication,
	review_scores_location,
	review_scores_value,
	reviews_per_month
    FROM listings;

DROP TABLE IF EXISTS listings_policies;
CREATE TABLE listings_policies (
	id INT UNSIGNED, 
	guests_included TINYINT UNSIGNED,
	extra_people TINYINT UNSIGNED,
	minimum_nights TINYINT UNSIGNED,
	maximum_nights SMALLINT UNSIGNED,
	minimum_minimum_nights TINYINT UNSIGNED,
	maximum_minimum_nights SMALLINT UNSIGNED,
	minimum_maximum_nights SMALLINT UNSIGNED,
	maximum_maximum_nights SMALLINT UNSIGNED,
	minimum_nights_avg_ntm DECIMAL (4,1) UNSIGNED,
	maximum_nights_avg_ntm DECIMAL (5,1) UNSIGNED,
	requires_license CHAR(1) CHECK(requires_license IN ('t', 'f')),
	instant_bookable CHAR(1) CHECK(instant_bookable IN ('t', 'f')),
	is_business_travel_ready CHAR(1) CHECK(is_business_travel_ready IN ('t', 'f')),
	cancellation_policy VARCHAR(27) CHECK(cancellation_policy IN('strict_14_with_grace_period',
										'super_strict_30', 'flexible', 'moderate')),
	require_guest_profile_picture CHAR(1) CHECK(require_guest_profile_picture IN ('t', 'f')),
	require_guest_phone_verification CHAR(1) CHECK(require_guest_phone_verification IN ('t', 'f')), 
    PRIMARY KEY (id), 
    CONSTRAINT fk_id_policies FOREIGN KEY (id) 
		REFERENCES listings_location (id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB;

INSERT INTO listings_policies
	SELECT id,
	guests_included,
	extra_people,
	minimum_nights,
	maximum_nights,
	minimum_minimum_nights,
	maximum_minimum_nights,
	minimum_maximum_nights,
	maximum_maximum_nights,
	minimum_nights_avg_ntm,
	maximum_nights_avg_ntm,
	requires_license,
	instant_bookable,
	is_business_travel_ready,
	cancellation_policy,
	require_guest_profile_picture,
	require_guest_phone_verification
    FROM listings;

DROP TABLE IF EXISTS listings_availability;
CREATE TABLE listings_availability (
	id INT UNSIGNED,
	calendar_updated VARCHAR(20),
	has_availability CHAR(1) CHECK(has_availability IN ('t', 'f')),
	availability_30 TINYINT UNSIGNED CHECK(availability_30 <= 30),
	availability_60 TINYINT UNSIGNED CHECK(availability_60 <= 60),
	availability_90 TINYINT UNSIGNED CHECK(availability_90 <= 90),
	availability_365 SMALLINT UNSIGNED CHECK(availability_365 <= 365),
	PRIMARY KEY (id), 
    CONSTRAINT fk_id_availability FOREIGN KEY (id) 
		REFERENCES listings_location (id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB;

INSERT INTO listings_availability
	SELECT id,
	calendar_updated,
	has_availability,
	availability_30,
	availability_60,
	availability_90,
	availability_365
    FROM listings;

DROP TABLE IF EXISTS listings_expenses;
CREATE TABLE listings_expenses (
	id INT UNSIGNED,
	price SMALLINT UNSIGNED,
	weekly_price SMALLINT UNSIGNED,
	monthly_price SMALLINT UNSIGNED,
	security_deposit SMALLINT UNSIGNED,
	cleaning_fee SMALLINT UNSIGNED,
	PRIMARY KEY (id), 
    CONSTRAINT fk_id_expenses FOREIGN KEY (id) 
		REFERENCES listings_location (id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB;

INSERT INTO listings_expenses
	SELECT id,
	price,
	weekly_price,
	monthly_price,
	security_deposit,
	cleaning_fee
    FROM listings;





-- Views
CREATE OR REPLACE VIEW results AS
	SELECT id, name, description, host_name, host_is_superhost, calculated_host_listings_count, neighbourhood_cleansed, 
    availability_365, price, review_scores_rating, number_of_reviews, cancellation_policy
	FROM listings_location JOIN listings_details USING (id) JOIN listings_host USING (host_id) 
		JOIN listings_availability USING (id) JOIN listings_expenses USING (id) 
        JOIN listings_policies USING (id) JOIN listings_review USING (id)
        JOIN listings_url USING (id);


-- Stored procedure for guest search
-- IN keyword - a string that 'name' and 'description' must contain; default = '%'
-- IN nbhd - matches neighbourhood_cleansed; default = '%'
-- IN min_price - minimum price; default = 0
-- IN max_price - maximum price; default = 65535
DROP PROCEDURE IF EXISTS search;
DELIMITER //
CREATE PROCEDURE search(IN keyword VARCHAR(30), IN nbhd VARCHAR(50), 
	IN min_price SMALLINT UNSIGNED, IN max_price SMALLINT UNSIGNED)
BEGIN
SELECT *
FROM results
WHERE price >= min_price AND price <= max_price AND neighbourhood_cleansed LIKE nbhd 
	AND (name LIKE CONCAT('%', keyword, '%') OR description LIKE CONCAT('%', keyword, '%'));
END //
DELIMITER ;


DROP TABLE IF EXISTS deleted_listings;
CREATE TABLE deleted_listings
	(id INT UNSIGNED,
    latitude DECIMAL(7, 5),
    longitude DECIMAL(8, 5),
    neighbourhood_cleansed VARCHAR(50),
    delete_time DATETIME
) ENGINE = InnoDB;

-- Trigger for host (delete)
DROP TRIGGER IF EXISTS delete_listing;
DELIMITER //
CREATE TRIGGER delete_listing
AFTER DELETE
ON listings_location
FOR EACH ROW
BEGIN
	INSERT INTO deleted_listings
		VALUES (OLD.id, OLD.latitude, OLD.longitude, OLD.neighbourhood_cleansed, NOW());
END //

DELIMITER ;


-- Keep a copy of old records
DROP TABLE IF EXISTS old_listings;
CREATE TABLE old_listings (
	id INT UNSIGNED,
    name VARCHAR(150),
    summary TEXT,
    space TEXT,
    description TEXT,
    house_rules TEXT, 
    price SMALLINT UNSIGNED, 
    security_deposit SMALLINT UNSIGNED,
	cleaning_fee SMALLINT UNSIGNED,
    update_time DATETIME
) ENGINE = InnoDB;

-- Trigger for host (update details)
DROP TRIGGER IF EXISTS update_listings_details;
DELIMITER //
CREATE TRIGGER update_listings_details
AFTER UPDATE
ON listings_details
FOR EACH ROW
BEGIN 
	INSERT INTO old_listings
    VALUES (OLD.id, OLD.name, OLD.summary, OLD.space, OLD.description, OLD.house_rules, 
		(SELECT price
        FROM listings_expenses 
        WHERE OLD.id = listings_expenses.id), 
        (SELECT security_deposit
        FROM listings_expenses 
        WHERE OLD.id = listings_expenses.id), 
        (SELECT cleaning_fee 
        FROM listings_expenses 
        WHERE OLD.id = listings_expenses.id), 
        NOW());
END //
DELIMITER ;

-- Trigger for host (update expenses)
DROP TRIGGER IF EXISTS update_listings_expenses;
DELIMITER //
CREATE TRIGGER update_listings_expenses
AFTER UPDATE
ON listings_expenses
FOR EACH ROW
BEGIN 
	INSERT INTO old_listings
    VALUES (
		(SELECT id
        FROM listings_details
        WHERE OLD.id = listings_details.id), 
        (SELECT name
        FROM listings_details
        WHERE OLD.id = listings_details.id), 
        (SELECT summary
        FROM listings_details
        WHERE OLD.id = listings_details.id), 
        (SELECT space
        FROM listings_details
        WHERE OLD.id = listings_details.id), 
        (SELECT description
        FROM listings_details
        WHERE OLD.id = listings_details.id), 
        (SELECT house_rules
        FROM listings_details
        WHERE OLD.id = listings_details.id), 
        OLD.price, OLD.security_deposit, OLD.cleaning_fee, NOW());
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS check_id;
DELIMITER //
CREATE PROCEDURE check_id(IN in_host_id INT UNSIGNED, IN in_id INT UNSIGNED, OUT answer BOOLEAN)
BEGIN
    SET answer = (in_host_id = 
		(SELECT host_id 
		FROM listings_details 
		WHERE id = in_id));
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS update_listings;
DELIMITER //
CREATE PROCEDURE update_listings(IN in_id INT UNSIGNED, IN in_name VARCHAR(150), IN in_summary TEXT, 
	IN in_space TEXT, IN in_description TEXT, IN in_house_rules TEXT, IN in_price SMALLINT UNSIGNED, 
    IN in_security_deposit SMALLINT UNSIGNED, IN in_cleaning_fee SMALLINT UNSIGNED)
BEGIN
	UPDATE listings_details 
    SET name = in_name,  summary = in_summary, space = in_space, description = in_description, 
		house_rules = in_house_rules
    WHERE id = in_id;
    UPDATE listings_expenses 
    SET price = in_price, security_deposit = in_security_deposit, cleaning_fee = in_cleaning_fee
    WHERE id = in_id;
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS insert_listings;
DELIMITER //
CREATE PROCEDURE insert_listings(IN in_id INT UNSIGNED, IN in_name VARCHAR(150), IN in_summary TEXT,
	IN in_space TEXT, IN in_description TEXT, IN in_house_rules TEXT, IN in_host_id INT UNSIGNED, 
    IN in_neighbourhood_cleansed VARCHAR(50), IN in_availability_365 SMALLINT UNSIGNED, 
    IN in_price SMALLINT UNSIGNED, IN in_security_deposit SMALLINT UNSIGNED, 
    IN in_cleaning_fee SMALLINT UNSIGNED, IN in_cancellation_policy VARCHAR(27), OUT result CHAR(1))
BEGIN 
	DECLARE sql_error INT DEFAULT FALSE;
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;
    
    START TRANSACTION;
		INSERT INTO listings_location (id, neighbourhood_cleansed)
        VALUES (in_id, in_neighbourhood_cleansed);
        
        INSERT INTO listings_availability (id, availability_365)
        VALUES (in_id, in_availability_365);
        
        INSERT INTO listings_details (id, host_id, name, summary, space, description, house_rules)
        VALUES (in_id, in_host_id, in_name, in_summary, in_space, in_description, in_house_rules);
        
        INSERT INTO listings_expenses (id, price, security_deposit, cleaning_fee)
        VALUES (in_id, in_price, in_security_deposit, in_cleaning_fee);
        
        INSERT INTO listings_policies (id, cancellation_policy)
        VALUES (in_id, in_cancellation_policy);
        
        INSERT INTO listings_review (id)
        VALUES (in_id);
        
        INSERT INTO listings_url (id)
        VALUES (in_id);
        
        UPDATE listings_host
        SET host_listings_count = host_listings_count + 1, host_total_listings_count = host_total_listings_count + 1
        WHERE host_id = in_host_id;
		
        IF sql_error = FALSE THEN
			COMMIT;
            SET result = 'C';
		ELSE 
			ROLLBACK;
            SET result = 'R';
		END IF;
END //
DELIMITER ;
