CREATE DATABASE PwsAeroporto;
USE PwsAeroporto;

Create table if not exists users(
	users_id INT UNSIGNED AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    birthdate Date NOT NULL,
	email VARCHAR(100) NOT NULL,
	phonenumber VARCHAR(20) NOT NULL,
    username VARCHAR(100) NOT NULL,
    userpassword VARCHAR(100) NOT NULL,
    userprofile VARCHAR(100) NOT NULL,
	CONSTRAINT pk_users_users_id PRIMARY KEY(users_id)
)ENGINE=InnoDB;

Create table if not exists airports(
	airports_id INT UNSIGNED AUTO_INCREMENT,
    airportname varchar(100) not null,
    country varchar(100) not null,
    city varchar(100) not null,
	CONSTRAINT pk_airports_airports_id PRIMARY KEY(airports_id)
)ENGINE=InnoDB;

Create table if not exists airplanes(
	airplanes_id INT UNSIGNED AUTO_INCREMENT,
    airplanename varchar(100) not null,
    shippingcompany varchar(100) not null,
	CONSTRAINT pk_airplane_airplanes_id PRIMARY KEY(airplanes_id)
)ENGINE=InnoDB;

Create table if not exists flights(
	flights_id INT UNSIGNED AUTO_INCREMENT,
    flightname varchar(100) not null,
    datehourdeparture datetime not null,
    datehourarrival datetime not null,
    origin_airport_id int UNSIGNED not null,
	destination_airport_id int UNSIGNED not null,
    airplane_id int UNSIGNED not null,
    price int UNSIGNED not null,
	CONSTRAINT pk_flights_flights_id PRIMARY KEY(flights_id),
	CONSTRAINT fk_flights_originairport_id FOREIGN KEY(origin_airport_id) REFERENCES airports(airports_id),
	CONSTRAINT fk_flights_destinationairport_id FOREIGN KEY(destination_airport_id) REFERENCES airports(airports_id),
    CONSTRAINT fk_flights_airplane_id FOREIGN KEY(airplane_id) REFERENCES airplanes(airplanes_id)
)ENGINE=InnoDB;


Create table if not exists scales(
	scales_id INT UNSIGNED AUTO_INCREMENT,
	flightname varchar(100) not null,
    datehourdeparture datetime not null,
    datehourarrival datetime not null,
	airport_id int UNSIGNED not null,
    airplane_id int UNSIGNED not null,
    flight_id int UNSIGNED not null,
	CONSTRAINT pk_scales_scales_id PRIMARY KEY(scales_id),
	CONSTRAINT fk_scales_airport_id FOREIGN KEY(airport_id) REFERENCES airports(airports_id),
    CONSTRAINT fk_scales_airplane_id FOREIGN KEY(airplane_id) REFERENCES airplanes(airplanes_id),
    CONSTRAINT fk_scales_flight_id FOREIGN KEY(flight_id) REFERENCES flights(flights_id)
)ENGINE=InnoDB;


Create table if not exists users_flights(
users_flights_id INT UNSIGNED AUTO_INCREMENT,
client_id int UNSIGNED not null,
flight_id int UNSIGNED not null,
flight_back_id int UNSIGNED,
price int not null,
purchasedate datetime not null,
planeplace varchar(100) not null,
checkin bool default false,
CONSTRAINT pk_users_flights_users_flights_id_id PRIMARY KEY(users_flights_id),
CONSTRAINT fk_users_flights_client_id FOREIGN KEY(client_id) REFERENCES users(users_id),
CONSTRAINT fk_users_flights_flight_id FOREIGN KEY(flight_id) REFERENCES flights(flights_id),
CONSTRAINT fk_users_flights_flight_back_id FOREIGN KEY(flight_back_id) REFERENCES flights(flights_id)
)ENGINE=InnoDB;

INSERT INTO users
VALUES (null, 'Admin Master', '2000-01-01', 'adminmaster@localhost.com', '912345678', 'adminmaster', 'adminmaster', 'administrador');
