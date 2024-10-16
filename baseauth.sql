-- Active: 1721379789391@@127.0.0.1@3306@dataauth
CREATE  DATABASE IF NOT EXISTS dataauth;

USE dataauth;
DROP TABLE IF EXISTS annonce;
DROP TABLE IF EXISTS user;

CREATE TABLE IF NOT EXISTS user (
userId INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
email VARCHAR (255) NOT NULL UNIQUE,
password VARCHAR (255) NOT NULL,
role VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS annonce (
    annonceId INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(255),
    description TEXT,
    price FLOAT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(userId) ON DELETE CASCADE
);