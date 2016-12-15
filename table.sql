-- changing id to UNSIGNED
-- adding UNIQUE index to username
-- adding backticks to the identifiers to avoid conflicts
-- password, for example, is a reserved word
CREATE TABLE IF NOT EXISTS `users` (
    `id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL
) ENGINE = InnoDB CHARSET=utf8;