CREATE TABLE IF NOT EXISTS `users`
(
    `id`        INT     NOT NULL AUTO_INCREMENT,
    `name`      VARCHAR(255) NOT NULL,
    `email`     VARCHAR(255) NOT NULL,
    `password`  VARCHAR(255) NOT NULL,
    `validated` TINYINT NOT NULL DEFAULT 0,
    `admin`     TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
);
