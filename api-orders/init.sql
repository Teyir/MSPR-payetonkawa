CREATE TABLE IF NOT EXISTS orders
(
    id           INT          NOT NULL AUTO_INCREMENT,
    amount       FLOAT        NOT NULL,
    price        FLOAT        NOT NULL,
    address      VARCHAR(500) NOT NULL,
    product_id   INT          NOT NULL,
    user_id      INT          NOT NULL,
    date_created TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT orders_pk PRIMARY KEY (id),
    CONSTRAINT product_fk FOREIGN KEY (product_id)
        REFERENCES products.products (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT user_fk FOREIGN KEY (user_id)
        REFERENCES customers.customers (id) ON DELETE CASCADE ON UPDATE CASCADE
)
    COLLATE = utf8mb4_unicode_ci;