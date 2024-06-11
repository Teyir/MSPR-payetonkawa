CREATE TABLE IF NOT EXISTS customers
(
    id           INT          NOT NULL AUTO_INCREMENT,
    first_name   VARCHAR(50)  NOT NULL,
    last_name    VARCHAR(50)  NOT NULL,
    email        VARCHAR(500) NOT NULL,
    password     VARCHAR(255) NOT NULL,
    date_created TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT customers_pk PRIMARY KEY (id),
    UNIQUE KEY (email)
)
    COLLATE = utf8mb4_unicode_ci;

