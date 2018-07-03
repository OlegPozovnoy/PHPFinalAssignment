
Create DATABASE book_store;
USE book_store;
CREATE TABLE `book_store`.`books_info` ( `book_id` INT NOT NULL AUTO_INCREMENT , `book_title` VARCHAR(255) NOT NULL , `book_genre` VARCHAR(64) NULL , `book_shortreview` VARCHAR(1024) NULL , `user_name` VARCHAR(32) NOT NULL , `user_email` VARCHAR(32) NULL , `book_url` VARCHAR(256) NULL , `book_image` VARCHAR(256) NULL , PRIMARY KEY (`book_id`));


