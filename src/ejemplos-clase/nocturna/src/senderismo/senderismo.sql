CREATE DATABASE IF NOT EXISTS senderismo
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_general_ci ;

USE senderismo ;

DROP TABLE IF EXISTS ruta ;

CREATE TABLE ruta (
	idRuta int NOT NULL AUTO_INCREMENT,
	nombre varchar(100) NOT NULL,
	localidad varchar(100) NOT NULL,
	distancia double NOT NULL,
	desnivel int NOT NULL,
	dificultad enum('baja', 'media', 'alta') NOT NULL,
	PRIMARY KEY (idRuta)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

INSERT INTO ruta (nombre, localidad, distancia, desnivel, dificultad) VALUES
	('Sendero del Río Borosa', 'Santiago-Pontones', 21.5, 650, 'media'),
	('Cerrada de Utrero', 'Cazorla', 2.8, 90, 'baja'),
	('Nacimiento del Guadalquivir', 'Quesada', 4.2, 120, 'baja'),
	('Ascenso al Pico Cabañas', 'Cazorla', 16.3, 1050, 'alta'),
	('Mirador de Rústico', 'La Iruela', 6.5, 280, 'baja'),
	('Castillo de la Yedra', 'Cazorla', 3.1, 150, 'baja'),
	('Cascada de Linarejos', 'Cazorla', 9.4, 420, 'media'),
	('Puente de las Herrerías', 'La Iruela', 12.0, 510, 'media'),
	('Cuerda de Segura', 'Segura de la Sierra', 18.7, 980, 'alta'),
	('Embalse de la Bolera', 'Pozo Alcón', 8.6, 210, 'baja'),
	('Collado del Almendral', 'Hornos', 14.2, 760, 'media'),
	('Travesía del Gilillo', 'Cazorla', 24.8, 1320, 'alta') ;
