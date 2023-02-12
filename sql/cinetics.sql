-- -----------------------------------------------------
DROP DATABASE IF EXISTS `cinetics`;
CREATE DATABASE IF NOT EXISTS `cinetics` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE `cinetics`;
-- -----------------------------------------------------

CREATE TABLE `users` (
  `iduser` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mail` VARCHAR(40) NOT NULL UNIQUE,
  `username` VARCHAR(16) NOT NULL UNIQUE,
  `passHash` VARCHAR(60),
  `userFirstName` VARCHAR(60),
  `userLastName` VARCHAR(120),
  `creationDate` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `lastSignin` DATETIME,
  `removeDate` DATETIME,
  `active` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`iduser`)
);
