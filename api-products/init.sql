CREATE TABLE IF NOT EXISTS products
(
    id           INT          NOT NULL AUTO_INCREMENT,
    title        VARCHAR(50)  NOT NULL,
    description  TEXT         NOT NULL,
    image        VARCHAR(255) NOT NULL,
    price_kg     FLOAT        NOT NULL COMMENT "Base price per kg",
    kg_remaining FLOAT        NOT NULL COMMENT "Products quantities remaining",
    date_created TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT products_pk PRIMARY KEY (id),
    UNIQUE KEY (title)
)
    COLLATE = utf8mb4_unicode_ci;