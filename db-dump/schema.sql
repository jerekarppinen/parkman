CREATE USER 'devuser'@'localhost' IDENTIFIED BY 'devpass';
GRANT ALL PRIVILEGES ON *.* TO 'devuser'@'localhost';

CREATE DATABASE IF NOT EXISTS world_of_garages;

USE world_of_garages;

CREATE TABLE IF NOT EXISTS garages (
    garage_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    -- garage names seem to be 7 characters long in this data
    garage_name VARCHAR(7) NOT NULL,
    -- this was the longest owner (13 characters) in example data (Parkkitalo OY)
    owner_id INT,
    -- allow big numbers with two decimal places
    hourly_price DECIMAL(17,2),
    -- all currencies have a 3-character long abbreviation, so it makes sense to use that
    currency VARCHAR(3),
    contact_email VARCHAR(255),
    country VARCHAR(200),
    -- if I had more time, I'd look into https://dev.mysql.com/doc/refman/8.0/en/spatial-types.html
    latitude DECIMAL(17,15),
    longitude DECIMAL(17,15)
);

CREATE TABLE IF NOT EXISTS owners (
    owner_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    owner_name VARCHAR(13) NOT NULL
);

INSERT INTO owners (owner_name) VALUES('AutoPark');
INSERT INTO owners (owner_name) VALUES('Parkkitalo OY');

INSERT INTO
    garages (garage_name, owner_id, hourly_price, currency, contact_email, country, latitude, longitude)
VALUES
    (
        'Garage1',
        1,
        2,
        'EUR',
        'testemail@testautopark.fi',
        'Finland',
        60.168607847624095,
        24.932371066131623
    );

INSERT INTO
    garages (garage_name, owner_id, hourly_price, currency, contact_email, country, latitude, longitude)
VALUES
    (
        'Garage2',
        1,
        1.5,
        'EUR',
        'testemail@testautopark.fi',
        'Finland',
        60.162562,
        24.939453
    );

INSERT INTO
    garages (garage_name, owner_id, hourly_price, currency, contact_email, country, latitude, longitude)
VALUES
    (
        'Garage3',
        1,
        3,
        'EUR',
        'testemail@testautopark.fi',
        'Finland',
        60.16444996645511,
        24.938178168200714
    );

INSERT INTO
    garages (garage_name, owner_id, hourly_price, currency, contact_email, country, latitude, longitude)
VALUES
    (
        'Garage4',
        1,
        3,
        'EUR',
        'testemail@testautopark.fi',
        'Finland',
        60.165219358852795,
        24.93537425994873
    );

INSERT INTO
    garages (garage_name, owner_id, hourly_price, currency, contact_email, country, latitude, longitude)
VALUES
    (
        'Garage5',
        1,
        3,
        'EUR',
        'testemail@testautopark.fi',
        'Finland',
        60.17167429490068,
        24.921585662024363
    );

INSERT INTO
    garages (garage_name, owner_id, hourly_price, currency, contact_email, country, latitude, longitude)
VALUES
    (
        'Garage6',
        2,
        2,
        'EUR',
        'testemail@testgarage.fi',
        'Ukraine',
        60.16867390148751,
        24.930162952045407
    );