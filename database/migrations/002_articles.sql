CREATE TABLE IF NOT EXISTS articles
(
    `id`         INT AUTO_INCREMENT,
    `title`      VARCHAR(255) NOT NULL,
    `slug`       VARCHAR(255) NULL,
    `chapo`      TINYTEXT     NOT NULL,
    `content`    TEXT         NOT NULL,
    `author_id`  INT          NULL,
    `created_at` DATETIME     NOT NULL,
    `updated_at` DATETIME     NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT articles_authors_fk
        FOREIGN KEY (`author_id`) REFERENCES users (`id`)
            ON DELETE CASCADE
);

ALTER TABLE articles
    ADD UNIQUE INDEX (`title`);

