CREATE DATABASE IF NOT EXISTS world_of_garages;
USE world_of_garages;

CREATE TABLE IF NOT EXISTS garages (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
--garage names seem to be 7 characters long in this data
garage_name VARCHAR(7) NOT NULL,
--this was the longest owner (13 characters) in example data (Parkkitalo OY)
owner_name VARCHAR(13) NOT NULL,
--example data only showed two digit values with one decimal place
hourly_price DECIMAL(2.1),
-- all currencies have a 3-character long abbreviation, so it makes sense to use that
currency VARCHAR(3),
email VARCHAR(255),
country VARCHAR(200),
--if I had more time, I'd look into https://dev.mysql.com/doc/refman/8.0/en/spatial-types.html
latitude DECIMAL(17,15),
longitude DECIMAL(17,15),
) ENGINE=innodb;

INSERT INTO
    garages (garage_name, owner_name, hourly_price, currency, email, country, latitude, longitude)
VALUES
    (
        'Garage1',
        'AutoPark',
        2,
        'EUR',
        'testemail@testautopark.fi',
        'Finland',
        60.168607847624095,
        24.932371066131623
    );

INSERT INTO
    garages (garage_name, owner_name, hourly_price, currency, email, country, latitude, longitude)
VALUES
    (
        'Garage2',
        'AutoPark',
        1.5,
        'EUR',
        'testemail@testautopark.fi',
        'Finland',
        60.162562,
        24.939453
    );

INSERT INTO
    garages (garage_name, owner_name, hourly_price, currency, email, country, latitude, longitude)
VALUES
    (
        'Garage3',
        'AutoPark',
        3,
        'EUR',
        'testemail@testautopark.fi',
        'Finland',
        60.16444996645511,
        24.938178168200714
    );

INSERT INTO
    garages (garage_name, owner_name, hourly_price, currency, email, country, latitude, longitude)
VALUES
    (
        'Garage4',
        'AutoPark',
        3,
        'EUR',
        'testemail@testautopark.fi',
        'Finland',
        60.165219358852795,
        24.93537425994873
    );

INSERT INTO
    garages (garage_name, owner_name, hourly_price, currency, email, country, latitude, longitude)
VALUES
    (
        'Garage5',
        'AutoPark',
        3,
        'EUR',
        'testemail@testautopark.fi',
        'Finland',
        60.17167429490068,
        24.921585662024363
    );

INSERT INTO
    garages (garage_name, owner_name, hourly_price, currency, email, country, latitude, longitude)
VALUES
    (
        'Garage6',
        'Parkkitalo OY',
        2,
        'EUR',
        'testemail@testgarage.fi',
        'Finland',
        60.16867390148751,
        24.930162952045407
    );