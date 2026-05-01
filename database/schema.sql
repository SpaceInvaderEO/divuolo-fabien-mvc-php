-- Création de la base de données
CREATE DATABASE IF NOT EXISTS `covoiturage_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `covoiturage_db`;

-- Suppression des tables existantes pour éviter les conflits lors des tests
DROP TABLE IF EXISTS `ride`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `agency`;

-- Table AGENCY (Les agences / villes)
CREATE TABLE `agency` (
    `id_agency` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table USER (Les employés et administrateurs)
CREATE TABLE `user` (
    `id_user` INT AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `phone` VARCHAR(20) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `is_admin` BOOLEAN NOT NULL DEFAULT FALSE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table RIDE (Les trajets de covoiturage)
CREATE TABLE `ride` (
    `id_ride` INT AUTO_INCREMENT PRIMARY KEY,
    `departure_time` DATETIME NOT NULL,
    `arrival_time` DATETIME NOT NULL,
    `total_seats` INT NOT NULL,
    `available_seats` INT NOT NULL,
    `id_departure_agency` INT NOT NULL,
    `id_arrival_agency` INT NOT NULL,
    `id_user` INT NOT NULL,
    CONSTRAINT `fk_departure_agency` FOREIGN KEY (`id_departure_agency`) REFERENCES `agency` (`id_agency`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_arrival_agency` FOREIGN KEY (`id_arrival_agency`) REFERENCES `agency` (`id_agency`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_user_ride` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
