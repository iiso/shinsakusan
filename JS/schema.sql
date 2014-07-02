CREATE DATABASE IF NOT EXISTS `song_requests`;
USE `song_requests`;

CREATE TABLE IF NOT EXISTS `artists` (
`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
`mbid` VARCHAR(255),
`name` VARCHAR(255),
`url` VARCHAR(255),
`created` DATETIME,
`modified` DATETIME
);

CREATE TABLE IF NOT EXISTS `tracks` (
`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
`artist_id` INT,
`mbid` VARCHAR(255),
`name` VARCHAR(255),
`url` VARCHAR(255),
`created` DATETIME,
`modified` DATETIME
);
ALTER TABLE `tracks` ADD INDEX `artist_id` (`artist_id`);
ALTER TABLE tracks ADD youtube_video_id VARCHAR(255) AFTER url;

CREATE TABLE IF NOT EXISTS `requests` (
`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
`track_id` INT,
`ip` VARCHAR(255),
`session_id` VARCHAR(255),
`created` DATETIME,
`modified` DATETIME
);
ALTER TABLE `requests` ADD INDEX `track_id` (`track_id`);

CREATE TABLE `artist_images` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`artist_id` INT,
`type` VARCHAR(255),
`url` VARCHAR(255),
`created` DATETIME,
`modified` DATETIME
);
ALTER TABLE `artist_images` ADD INDEX `artist_id` (`artist_id`);