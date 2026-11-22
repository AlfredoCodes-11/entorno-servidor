-- Esquema y datos iniciales del hotel Nocturna.
-- @author Antonio José Sánchez Bujaldón

CREATE DATABASE IF NOT EXISTS nocturna
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_general_ci ;

USE nocturna ;

DROP TABLE IF EXISTS reserva ;
DROP TABLE IF EXISTS habitacion ;
DROP TABLE IF EXISTS cliente ;

CREATE TABLE cliente (
	idCliente int NOT NULL AUTO_INCREMENT,
	dni char(9) NOT NULL,
	nombre varchar(100) NOT NULL,
	apellidos varchar(100) DEFAULT NULL,
	email varchar(100) NOT NULL,
	PRIMARY KEY (idCliente),
	UNIQUE KEY cliente_dni (dni),
	UNIQUE KEY cliente_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

CREATE TABLE habitacion (
	idHabitacion int NOT NULL AUTO_INCREMENT,
	nombre varchar(100) NOT NULL,
	numero int NOT NULL,
	precio double DEFAULT NULL,
	capacidad tinyint DEFAULT 1,
	estado tinyint(1) DEFAULT 1,
	PRIMARY KEY (idHabitacion),
	UNIQUE KEY habitacion_numero (numero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

CREATE TABLE reserva (
	idReserva int NOT NULL AUTO_INCREMENT,
	idCliente int NOT NULL,
	idHabitacion int NOT NULL,
	fecha date NOT NULL,
	noches tinyint DEFAULT 1,
	PRIMARY KEY (idReserva),
	KEY fk_reserva_habitacion (idHabitacion),
	CONSTRAINT fk_reserva_habitacion FOREIGN KEY (idHabitacion) REFERENCES habitacion (idHabitacion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

INSERT INTO habitacion (idHabitacion, nombre, numero, precio, capacidad, estado) VALUES
	(1, 'CriptaReal', 13, 120, 2, 1),
	(2, 'Laboratorio de Frankenstein', 66, 95, 3, 0),
	(3, 'Sarcófago Imperial', 99, 150, 2, 1),
	(4, 'Suite Fantasmal', 404, 80, 1, 1) ;
