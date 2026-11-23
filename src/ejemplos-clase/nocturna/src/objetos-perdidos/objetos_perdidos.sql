CREATE DATABASE IF NOT EXISTS objetos_perdidos
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_general_ci ;

USE objetos_perdidos ;

DROP TABLE IF EXISTS objeto ;

CREATE TABLE objeto (
	idObjeto int NOT NULL AUTO_INCREMENT,
	nombre varchar(100) NOT NULL,
	descripcion varchar(255) DEFAULT NULL,
	lugar varchar(150) NOT NULL,
	fecha date NOT NULL,
	PRIMARY KEY (idObjeto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

INSERT INTO objeto (nombre, descripcion, lugar, fecha) VALUES
	('Paraguas', 'Paraguas negro plegable con mango de madera', 'Estación de autobuses', '2026-09-03'),
	('Cartera', 'Cartera marrón de piel, sin documentación', 'Parque Municipal', '2026-09-10'),
	('Llaves', 'Llavero con tres llaves y un mosquetón azul', 'Biblioteca Municipal', '2026-09-15'),
	('Teléfono móvil', 'Smartphone con funda roja y la pantalla rota', 'Polideportivo', '2026-09-22'),
	('Gafas de sol', 'Gafas de sol con montura de pasta negra', 'Playa del Centro', '2026-10-01'),
	('Mochila', 'Mochila escolar verde con libros de texto', 'Plaza Mayor', '2026-10-05'),
	('Reloj', 'Reloj de pulsera plateado con correa metálica', 'Ayuntamiento', '2026-10-12'),
	('Bufanda', 'Bufanda de lana a rayas grises y blancas', 'Teatro Municipal', '2026-10-20'),
	('Auriculares', 'Auriculares inalámbricos blancos en su estuche', 'Estación de tren', '2026-11-02'),
	('Bicicleta', 'Bicicleta de montaña azul sin candado', 'Mercado de Abastos', '2026-11-10'),
	('Anillo', 'Anillo dorado con una piedra pequeña', 'Centro de Salud', '2026-11-14') ;
