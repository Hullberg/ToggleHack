# All SQL Commands necessary to construct the database
# Should be constructed in a database named 'ToggleHack'


CREATE TABLE items (
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(255) NOT NULL,
price DECIMAL(5,2) NOT NULL,
description LONGTEXT NOT NULL,
PRIMARY KEY(id)
);

INSERT INTO items (name, price, description) VALUES ('item0', 800.00, 'Imagine a black t-shirt');
INSERT INTO items (name, price, description) VALUES ('item1', 400.00, 'Imagine a nice golden watch');
INSERT INTO items (name, price, description) VALUES ('item2', 200.00, 'Imagine a smartphone');
INSERT INTO items (name, price, description) VALUES ('item3', 100.00, 'Imagine a laptop');
INSERT INTO items (name, price, description) VALUES ('item4', 50.00, 'Imagine some kitchen utensil');
INSERT INTO items (name, price, description) VALUES ('item5', 25.00, 'Imagine some weight-lifting equipment');


CREATE TABLE users (
username VARCHAR(255) NOT NULL,
md5pass VARCHAR(255),
sha512pass VARCHAR(255),
PRIMARY KEY(username)
);

INSERT INTO users (username, md5pass, sha512pass) VALUES ('ADMIN', '83926d05c82cc4b77fa3d4cde227461d', 'B1BBD962FDAEE576261A2F58B0337480256489A11B4E0C7FD09846F18869CF4B3C844B04F7AF2E8681403F11C9D695C9185DE6DA06E5C627FB42CDE2A5097920');
INSERT INTO users (username, md5pass, sha512pass) VALUES ('test', '098f6bcd4621d373cade4e832627b4f6', 'EE26B0DD4AF7E749AA1A8EE3C10AE9923F618980772E473F8819A5D4940E0DB27AC185F8A0E1D5F84F88BC887FD67B143732C304CC5FA9AD8E6F57F50028A8FF');

CREATE TABLE itemcomments (
id INT NOT NULL AUTO_INCREMENT,
product_id INT NOT NULL,
comment LONGTEXT NOT NULL,
PRIMARY KEY(id)
);

INSERT INTO itemcomments (product_id, comment) VALUES ('1','good product');