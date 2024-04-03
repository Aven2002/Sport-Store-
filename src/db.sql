-- Check if the database exists
CREATE DATABASE IF NOT EXISTS Sport_Store;
-- Use the database
USE Sport_Store;
-- User Account Table
CREATE TABLE IF NOT EXISTS user_account (
    userID INT NOT NULL AUTO_INCREMENT,
    fullName VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    contactNum VARCHAR(15) NOT NULL,
    address VARCHAR(60) NOT NULL,
    username VARCHAR(45) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (userID),
    UNIQUE INDEX username_UNIQUE (username ASC)
);
-- Product Table
CREATE TABLE IF NOT EXISTS product (
    productID INT NOT NULL AUTO_INCREMENT,
    productName VARCHAR(45) NOT NULL,
    productCategory VARCHAR(50) NOT NULL,
    productBrand VARCHAR(45) NOT NULL,
    productType VARCHAR(45) NOT NULL,
    productImagePath VARCHAR(255),
    productPrice DECIMAL(10, 2) NOT NULL,
    productDetails VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (productID),
    UNIQUE INDEX productName_UNIQUE (productName ASC)
);
-- Cart Table
CREATE TABLE IF NOT EXISTS cart (
    cartID INT NOT NULL AUTO_INCREMENT,
    userID INT NOT NULL,
    productID INT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (cartID),
    FOREIGN KEY (userID) REFERENCES user_account(userID),
    FOREIGN KEY (productID) REFERENCES product(productID)
);
-- Feedback Table
CREATE TABLE IF NOT EXISTS feedback (
    feedbackID INT NOT NULL AUTO_INCREMENT,
    category VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    contactNum VARCHAR(15) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (feedbackID)
);