
Create DATABASE book_store;
USE book_store;

CREATE TABLE `book_store`.`users` ( `user_name` VARCHAR(64) NOT NULL , `password` VARCHAR(128) NOT NULL , `email` VARCHAR(64) NOT NULL ,  `registratoinDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `userId` INT UNSIGNED NOT NULL AUTO_INCREMENT , PRIMARY KEY (`userId`)) ENGINE = InnoDB;

