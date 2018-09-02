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
bcryptpass VARCHAR(255),
PRIMARY KEY(username)
);

INSERT INTO users (username, md5pass, bcryptpass) VALUES ('ADMIN', 'e3274be5c857fb42ab72d786e281b4b8', '$2y$10$VGhpcyFzQVN0cmluZ1QwQO85a87OTivyWwtMZBY45idFrNE6BguL.');
INSERT INTO users (username, md5pass, bcryptpass) VALUES ('test', '098f6bcd4621d373cade4e832627b4f6', '$2y$10$VGhpcyFzQVN0cmluZ1QwQOISBc6ojqyBA61b/bIdj4gbMADzuuIsW');

CREATE TABLE itemcomments (
id INT NOT NULL AUTO_INCREMENT,
product_id INT NOT NULL,
comment LONGTEXT NOT NULL,
PRIMARY KEY(id)
);

INSERT INTO itemcomments (product_id, comment) VALUES ('1','good product');