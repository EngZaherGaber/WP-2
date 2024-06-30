-- Active: 1719637146144@@127.0.0.1@3306@phpmyadmin
-- Schema
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
INSERT INTO
    products (
        name,
        description,
        price,
        image_url
    )
VALUES (
        'Product 1',
        'Description of Product 1',
        49.99,
        'https://placeimg.com/300/200/tech'
    ),
    (
        'Product 2',
        'Description of Product 2',
        29.99,
        'https://placeimg.com/300/200/nature'
    ),
    (
        'Product 3',
        'Description of Product 3',
        19.99,
        'https://placeimg.com/300/200/people'
    ),
    (
        'Product 4',
        'Description of Product 4',
        39.99,
        'https://placeimg.com/300/200/animals'
    ),
    (
        'Product 5',
        'Description of Product 5',
        59.99,
        'https://placeimg.com/300/200/architecture'
    );

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (user_id),
    FOREIGN KEY (product_id) REFERENCES products (product_id)
)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)