-- ADMINS TABLE
CREATE TABLE tbl_admins(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT 1,
    is_superadmin BOOLEAN DEFAULT 0
);

-- PITCH TYPES TABLE
CREATE TABLE tbl_pitch_types(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    is_published BOOLEAN DEFAULT 1,
    publish_by INT NOT NULL,
    FOREIGN KEY(publish_by) REFERENCES tbl_admins(id)
);

-- PITCH TYPE IMAGES
CREATE TABLE tbl_pitch_type_images(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    url MEDIUMTEXT NOT NULL,
    pitch_type_id INT NOT NULL,
    FOREIGN KEY(pitch_type_id) REFERENCES tbl_pitch_types(id)
);

-- PITCHES TABLE
CREATE TABLE tbl_pitches(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    maximum_guest_count INT NOT NULL,
    price INT NOT NULL,
    location VARCHAR(255) NOT NULL,
    number_of_sites INT NOT NULL,
    number_of_tents INT NOT NULL,
    number_of_rvs INT NOT NULL,
    width INT NOT NULL,
    view_count INT NOT NULL,
    is_published BOOLEAN DEFAULT 1,
    allow_campfires BOOLEAN DEFAULT 0,
    allow_pets BOOLEAN DEFAULT 0,
    available_wifi BOOLEAN DEFAULT 0,
    available_electricity BOOLEAN DEFAULT 0,
    has_cooking_equipments BOOLEAN DEFAULT 0,
    can_bike BOOLEAN DEFAULT 0,
    can_fish BOOLEAN DEFAULT 0,
    can_sail BOOLEAN DEFAULT 0,
    can_hike BOOLEAN DEFAULT 0,
    can_ride_horse BOOLEAN DEFAULT 0,
    publish_by INT NOT NULL,
    pitch_type_id INT NOT NULL,
    FOREIGN KEY(publish_by) REFERENCES tbl_admins(id),
    FOREIGN KEY(pitch_type_id) REFERENCES tbl_pitch_types(id)
);

-- PITCH IMAGES TABLE
CREATE TABLE tbl_pitch_images(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(255) NOT NULL,
    url MEDIUMTEXT NOT NULL, 
    pitch_id INT NOT NULL, 
    FOREIGN KEY(pitch_id) REFERENCES tbl_pitches(id)
);

-- SWIMMING SITES TABLE
CREATE TABLE tbl_swimming_sites(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    maximum_guest_count INT NOT NULL,
    price INT NOT NULL,
    location VARCHAR(255) NOT NULL,
    number_of_tents INT NOT NULL,
    width INT NOT NULL,
    view_count INT NOT NULL,
    is_published BOOLEAN DEFAULT 1,
    allow_campfires BOOLEAN DEFAULT 0,
    allow_pets BOOLEAN DEFAULT 0,
    available_wifi BOOLEAN DEFAULT 0,
    available_electricity BOOLEAN DEFAULT 0,
    has_cooking_equipments BOOLEAN DEFAULT 0,
    can_bike BOOLEAN DEFAULT 0,
    can_fish BOOLEAN DEFAULT 0,
    can_sail BOOLEAN DEFAULT 0,
    can_hike BOOLEAN DEFAULT 0,
    can_ride_horse BOOLEAN DEFAULT 0,
    publish_by INT NOT NULL,
    FOREIGN KEY(publish_by) REFERENCES tbl_admins(id)
);

-- SWIMMING SITE IMAGES
CREATE TABLE tbl_swimming_site_images(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(255) NOT NULL,
    url MEDIUMTEXT NOT NULL, 
    swimming_site_id INT NOT NULL, 
    FOREIGN KEY(swimming_site_id) REFERENCES tbl_swimming_sites(id)
);

-- CUSTOMERS TABLE
CREATE TABLE tbl_customers(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    location VARCHAR(100) NOT NULL,
    avatar_url VARCHAR(255) NOT NULL,
    avatar_name VARCHAR(255) NOT NULL,
);

-- PITCH BOOKINGS
CREATE TABLE tbl_pitch_bookings(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    guest_count INT NOT NULL,
    start_date DATE,
    end_date DATE,
    status VARCHAR(100) DEFAULT "pending",
    pitch_id INT NOT NULL,
    customer_id INT NOT NULL,
    FOREIGN KEY(pitch_id) REFERENCES tbl_pitches(id),
    FOREIGN KEY(customer_id) REFERENCES tbl_customers(id)
);

-- SWIMMING SITE BOOKINGS
CREATE TABLE tbl_swimming_site_bookings(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    guest_count INT NOT NULL,
    start_date DATE,
    end_date DATE,
    status VARCHAR(100) DEFAULT "pending",
    swimming_site_id INT NOT NULL,
    customer_id INT NOT NULL,
    FOREIGN KEY(swimming_site_id) REFERENCES tbl_swimming_sites(id),
    FOREIGN KEY(customer_id) REFERENCES tbl_customers(id)
);

-- PITCH REVIEWS TABLE
CREATE TABLE tbl_pitch_reviews(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(255) NOT NULL,
    rating INT DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    pitch_id INT NOT NULL,
    publish_by INT NOT NULL,
    FOREIGN KEY(pitch_id) REFERENCES tbl_pitches(id),
    FOREIGN KEY(publish_by) REFERENCES tbl_customers(id)
);

-- SWIMMING SITE REVIEWS TABLE
CREATE TABLE tbl_swimming_site_reviews(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(255) NOT NULL,
    rating INT DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    swimming_site_id INT NOT NULL,
    publish_by INT NOT NULL,
    FOREIGN KEY(swimming_site_id) REFERENCES tbl_swimming_sites(id),
    FOREIGN KEY(publish_by) REFERENCES tbl_customers(id)
);

-- FEEDBACKS TABLE
CREATE TABLE tbl_feedbacks(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    message VARCHAR(255) NOT NULL,
    customer_id INT NOT NULL,
    FOREIGN KEY(customer_id) REFERENCES tbl_customers(id)
);

-- LOGIN LOGS TABLE
CREATE TABLE tbl_login_logs(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ip_address VARCHAR(255) NOT NULL,
    login_time INT NOT NULL
);

-- RSS FEEDS TABLE
CREATE TABLE tbl_rss_feeds (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(100) NOT NULL,
  description VARCHAR(255) NOT NULL,
  url VARCHAR(255) NOT NULL
)