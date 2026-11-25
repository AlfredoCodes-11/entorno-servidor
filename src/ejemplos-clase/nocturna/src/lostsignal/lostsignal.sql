CREATE DATABASE IF NOT EXISTS lostsignal
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_general_ci ;

USE lostsignal ;

DROP TABLE IF EXISTS senal ;

CREATE TABLE senal (
	identificador int NOT NULL AUTO_INCREMENT,
	codigo varchar(10) NOT NULL,
	estacion varchar(50) NOT NULL,
	frecuencia decimal(10,3) NOT NULL,
	intensidad tinyint NOT NULL,
	estado char(1) NOT NULL DEFAULT 'P',
	PRIMARY KEY (identificador),
	UNIQUE KEY senal_codigo (codigo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

INSERT INTO senal (codigo, estacion, frecuencia, intensidad, estado) VALUES
	('LS001', 'Orion', 1420.405, 95, 'P'),
	('LS002', 'Vega', 408.250, 62, 'C'),
	('LS003', 'Altair', 327.125, 34, 'D'),
	('LS004', 'Orion', 1612.231, 80, 'P'),
	('LS005', 'Sirius', 1665.402, 79, 'P'),
	('LS006', 'Vega', 1420.410, 91, 'C'),
	('LS007', 'Altair', 610.500, 88, 'D'),
	('LS008', 'Sirius', 115.750, 45, 'P'),
	('LS009', 'Orion', 2300.125, 100, 'P'),
	('LS010', 'Vega', 325.500, 1, 'D') ;
