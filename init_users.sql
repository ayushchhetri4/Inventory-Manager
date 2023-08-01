CREATE DATABASE CP476;
CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userFN VARCHAR(50),
    userLN VARCHAR(50),
    userE VARCHAR(100),
    userU VARCHAR(50),
    userP VARCHAR(255)
);
INSERT INTO users (id, userFN, userLN, userE, userU, userP)
VALUES (1, 'John', 'Doe', 'john.doe@example.com', 'johndoe', 'password123');