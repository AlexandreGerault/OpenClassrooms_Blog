CREATE TABLE IF NOT EXISTS comments
(
    `id`         INT AUTO_INCREMENT,
    `article_id` INT                   NOT NULL,
    `email`      VARCHAR(255)          NOT NULL,
    `name`       VARCHAR(255)          NULL,
    `content`    TEXT                  NULL,
    `validated`  BOOLEAN DEFAULT FALSE NOT NULL,
    `created_at` DATETIME              NOT NULL,
    CONSTRAINT `comments_pk`
        PRIMARY KEY (`id`),
    CONSTRAINT comments_articles_id_fk
        FOREIGN KEY (`article_id`) REFERENCES articles (`id`) ON DELETE CASCADE
);
