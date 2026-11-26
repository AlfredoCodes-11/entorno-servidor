CREATE DATABASE IF NOT EXISTS ghostkey CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ghostkey;

CREATE TABLE usuario (
    idUsuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL
);

CREATE TABLE credencial (
    idCredencial INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT UNSIGNED NOT NULL,
    servicio VARCHAR(100) NOT NULL,
    url VARCHAR(255) NOT NULL,
    login VARCHAR(100) NOT NULL,
    clave VARCHAR(255) NOT NULL,
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

-- Usuarios de prueba: alex, morgan, robin, taylor. Contraseña: ghostkey
INSERT INTO usuario (idUsuario, nombre, login, contrasena) VALUES
    (1, 'Alex', 'alex', '$2y$12$oq4CH6iloL3346/7yINa8On3HYXyyvdNxkJFk.3BcuYrc39BJkpFC'),
    (2, 'Morgan', 'morgan', '$2y$12$Vcmd5isSXji6RH68nuTkWePlbc7RzrpQwoZ8RiEJZQfX4XCCMDZtG'),
    (3, 'Robin', 'robin', '$2y$12$cub9I3Mb0BCnsFgFEAkEveVkCcbAKCXJ4yyZ5YN15WZhnPaPLjBT2'),
    (4, 'Taylor', 'taylor', '$2y$12$9UgR/ghVxVaddoCiU98v7OmZSqhNp13BPRJYZtN3t5bbaPU2leXS2');

-- Credenciales ficticias: 32, 15, 3 y 0 por usuario.
INSERT INTO credencial (idUsuario, servicio, url, login, clave) VALUES
    (1, 'Adobe', 'https://adobe.com', 'alex_demo', 'Demo#101!'),
    (1, 'Amazon', 'https://amazon.es', 'alex_demo', 'Demo#102!'),
    (1, 'Apple', 'https://apple.com', 'alex_demo', 'Demo#103!'),
    (1, 'Canva', 'https://canva.com', 'alex_demo', 'Demo#104!'),
    (1, 'Discord', 'https://discord.com', 'alex_demo', 'Demo#105!'),
    (1, 'Disney+', 'https://disneyplus.com', 'alex_demo', 'Demo#106!'),
    (1, 'Dropbox', 'https://dropbox.com', 'alex_demo', 'Demo#107!'),
    (1, 'Epic Games', 'https://epicgames.com', 'alex_demo', 'Demo#108!'),
    (1, 'Facebook', 'https://facebook.com', 'alex_demo', 'Demo#109!'),
    (1, 'Figma', 'https://figma.com', 'alex_demo', 'Demo#110!'),
    (1, 'GitHub', 'https://github.com', 'alex_demo', 'Demo#111!'),
    (1, 'GitLab', 'https://gitlab.com', 'alex_demo', 'Demo#112!'),
    (1, 'Google', 'https://google.com', 'alex_demo', 'Demo#113!'),
    (1, 'HBO Max', 'https://hbomax.com', 'alex_demo', 'Demo#114!'),
    (1, 'Instagram', 'https://instagram.com', 'alex_demo', 'Demo#115!'),
    (1, 'LinkedIn', 'https://linkedin.com', 'alex_demo', 'Demo#116!'),
    (1, 'Microsoft', 'https://microsoft.com', 'alex_demo', 'Demo#117!'),
    (1, 'Netflix', 'https://netflix.com', 'alex_demo', 'Demo#118!'),
    (1, 'Notion', 'https://notion.so', 'alex_demo', 'Demo#119!'),
    (1, 'Pinterest', 'https://pinterest.com', 'alex_demo', 'Demo#120!'),
    (1, 'PlayStation', 'https://playstation.com', 'alex_demo', 'Demo#121!'),
    (1, 'Reddit', 'https://reddit.com', 'alex_demo', 'Demo#122!'),
    (1, 'Slack', 'https://slack.com', 'alex_demo', 'Demo#123!'),
    (1, 'Spotify', 'https://spotify.com', 'alex_demo', 'Demo#124!'),
    (1, 'Steam', 'https://steampowered.com', 'alex_demo', 'Demo#125!'),
    (1, 'Trello', 'https://trello.com', 'alex_demo', 'Demo#126!'),
    (1, 'Twitch', 'https://twitch.tv', 'alex_demo', 'Demo#127!'),
    (1, 'Ubisoft', 'https://ubisoft.com', 'alex_demo', 'Demo#128!'),
    (1, 'Vimeo', 'https://vimeo.com', 'alex_demo', 'Demo#129!'),
    (1, 'WordPress', 'https://wordpress.com', 'alex_demo', 'Demo#130!'),
    (1, 'Xbox', 'https://xbox.com', 'alex_demo', 'Demo#131!'),
    (1, 'YouTube', 'https://youtube.com', 'alex_demo', 'Demo#132!'),
    (2, 'Adobe', 'https://adobe.com', 'morgan_demo', 'Demo#201!'),
    (2, 'Apple', 'https://apple.com', 'morgan_demo', 'Demo#203!'),
    (2, 'Discord', 'https://discord.com', 'morgan_demo', 'Demo#205!'),
    (2, 'Dropbox', 'https://dropbox.com', 'morgan_demo', 'Demo#207!'),
    (2, 'Facebook', 'https://facebook.com', 'morgan_demo', 'Demo#209!'),
    (2, 'GitHub', 'https://github.com', 'morgan_demo', 'Demo#211!'),
    (2, 'Google', 'https://google.com', 'morgan_demo', 'Demo#213!'),
    (2, 'Instagram', 'https://instagram.com', 'morgan_demo', 'Demo#215!'),
    (2, 'Microsoft', 'https://microsoft.com', 'morgan_demo', 'Demo#217!'),
    (2, 'Notion', 'https://notion.so', 'morgan_demo', 'Demo#219!'),
    (2, 'PlayStation', 'https://playstation.com', 'morgan_demo', 'Demo#221!'),
    (2, 'Slack', 'https://slack.com', 'morgan_demo', 'Demo#223!'),
    (2, 'Steam', 'https://steampowered.com', 'morgan_demo', 'Demo#225!'),
    (2, 'Twitch', 'https://twitch.tv', 'morgan_demo', 'Demo#227!'),
    (2, 'Vimeo', 'https://vimeo.com', 'morgan_demo', 'Demo#229!'),
    (3, 'Discord', 'https://discord.com', 'robin_demo', 'Demo#305!'),
    (3, 'GitHub', 'https://github.com', 'robin_demo', 'Demo#311!'),
    (3, 'Spotify', 'https://spotify.com', 'robin_demo', 'Demo#324!');
