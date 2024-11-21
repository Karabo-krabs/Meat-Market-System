create database meatmarket;

use meatmarket;

create table products(
	productID int auto_increment not null primary key,
    productName varchar(50) not null,
    category varchar(50) not null,
    Price decimal(10,2) not null,
    Quantity int not null,
    Image longblob not null
);
create table Customer(
customerpk int not null primary key auto_increment,
name varchar(25) not null,
surname varchar(25),
username varchar(15) not null,
phone varchar(10) not null,
address varchar(100),
password_hint varchar(255) not null,
password varchar(255) not null
);
select * from customer;


create table cart(
	cartid INT AUTO_INCREMENT PRIMARY KEY not null,
    productid INT not null,
    price decimal not null,
    quantity INT DEFAULT 1,
    FOREIGN KEY (productid) REFERENCES products(productid),
    customer_id INT NOT NULL,  -- Add this line
    FOREIGN KEY (customer_id) REFERENCES Customer(customerpk)  -- Add this line
);

select * from cart;

select * from products;



insert into products(productName,category, Price, Quantity, Image) 
values ('Pig Head', 'Pig', 250.00, 50, 'pigHead.jpg'),
		('Pork Jowl', 'Pig', 100.00, 50, 'porkJowl.jpg'),
        ('Pork Ribs', 'Pig', 150.00, 50, 'porkRibs.jpg'),
        ('Pork Sirloin', 'Pig', 140.00, 50, 'porkSirloin.jpg'),
        ('Pork Belly', 'Pig', 100.00, 50, 'porkBellu.jpg'),
        ('Pig Arm', 'Pig', 120.00, 50, 'porkArm.jpg'),
        ('Pork Ham', 'Pig', 70.00, 50, 'porkHam.jpg'),
        
		('Sheep Head', 'Sheep', 200.00, 50, 'sheepHead.jpg'),
		('Sheep Breast', 'Sheep', 139.99, 50, 'lambBreast.png'),
		('Sheep Flank', 'Sheep', 170.00, 50, 'lambShank.jpg'),
		('Sheep Heel', 'Sheep', 69.99, 50, 'lambHeel.jpg'),
		('Sheep Leg', 'Sheep', 120.00, 50, 'lambLeg.jpg'),
		('Sheep Loin', 'Sheep', 149.00, 50, 'lambLoin.jpg'),
		('Sheep Ribs', 'Sheep', 270.00, 50, 'lambRibs.jpg'),
		('Sheep Rump', 'Sheep', 163.00, 50, 'lambRump.jpg'),
		('Sheep Shank', 'Sheep', 349.99, 50, 'lambShank.jpeg'),
		('Sheep Shoulder', 'Sheep', 200.00, 50, 'lambShoulder.jpeg'),
        
		('Goat Breast', 'Goat', 189.00, 50, 'goatBreast.jpg'),
		('Goat Heels', 'Goat', 60.00, 50, 'goatFeet.webp'),
		('Goat Hock', 'Goat', 100.00, 50, 'goatHock.jpg'),
		('Goat Flank', 'Goat', 129.99, 50, 'goatFlank.jpg'),
		('Goat Loin', 'Goat', 70.00, 50, 'goatLoin.jpg'),
		('Goat Rump', 'Goat', 139.99, 50, 'goatRump.jpg'),
		('Goat Shank', 'Goat', 400.00, 50, 'goatShank.jpg'),
		('Goat Shoulder', 'Goat', 200.00, 50, 'goatShoulder.jpg'),
		('Goat Tail', 'Goat', 65.00, 50, 'goatTail.jpg'),
        
        ('Beef Braai Brisket', 'Beef', 150.00, 50, 'cowBrisket.jpg'),
		('Beef Brisket', 'Beef', 144.99, 50, 'cowChuck.jpg'),
		('Beef Heels', 'Beef', 40.00, 50, 'cowfeet.jpg'),
		('Beef Head', 'Beef', 150.00, 50, 'cowHead.jpg'),
		('Beef Leg Roundcut', 'Beef', 60.00, 50, 'cowRouncut.jpg'),
		('Beef Rump', 'Beef', 130.00, 50, 'cowrump.jpg'),
		('Beef Shank', 'Beef', 160.00, 50, 'cowShank.jpg'),
        
        ('Full chicken', 'Chicken', 100.00, 50, 'Whole-Chicken.jpg'),
		('Chicken Feet', 'Chicken', 25.00, 50, 'chickenFeet.jpg'),
		('Chicken Drumsticks', 'Chicken', 100.00, 50, 'chickenDrumsticks.jpg'),
		('Chicken Thighs', 'Chicken', 100.00, 50, 'chickenThighs.jpg'),
		('Chicken Wings', 'Chicken', 100.00, 50, 'chickenWings.jpg'),
		('Chicken Breast', 'Chicken', 100.00, 50, 'chickenbreast.jpg'),
		('Chicken Necks', 'Chicken', 100.00, 50, 'chickenNecks.jpg'),
		('Chicken Drumsticks', 'Chicken', 100.00, 50, 'chickenHead.jpg'),
		('Chicken Hearts', 'Chicken', 100.00, 50, 'chickenHearts.jpg'),
		('Chicken Livers', 'Chicken', 100.00, 50, 'chickenLivers.jpg'),
		('Chicken Drumsticks', 'Chicken', 100.00, 50, 'chickenGizards.jpg'),
        
        ('Calf Cow', 'Livestock', 7000.00, 50, 'product1.jpg'),
		('Kid Goat', 'Livestock', 1000.00, 50, 'putsana.jpg'),
		('Ewe Sheep', 'Livestock', 32000.00, 50, 'FemaleSheep.jpeg'),
		('Buck Goat', 'Livestock', 32000.00, 50, 'goat2.jpg'),
		('Rooster Chicken', 'Livestock', 150.00, 50, 'rooster.jpg'),
		('Hen Chicken', 'Livestock', 120.00, 50, 'hen.jpg'),
		('Chic Chicken', 'Livestock', 50.00, 50, 'chic.jpg'),
		('Bull Cow', 'Livestock', 18000.00, 50, 'bull.jpg'),
		('Cow', 'Livestock', 15000.00, 50, 'cowMother.jpeg'),
		('Nanny Goat', 'Livestock', 3000.00, 50, 'goat.jpg'),
		('Piglet', 'Livestock', 1500.00, 50, 'piglet.jpg'),
		('Sow Pig', 'Livestock', 4000.00, 50, 'femalePig.jpeg'),
		('Ram Sheep', 'Livestock', 3500.00, 50, 'sheepRam.jpg'),
		('Lamb Sheep', 'Livestock', 1200.00, 50, 'BabySheep.jpg'),
        ('Barrow Pig', 'Livestock', 4500.00, 50, 'male-farm-pig.jpg');
        

select * from products;


CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL
);

INSERT INTO product (name, price, image) VALUES
('Product 1', 10.00, 'images/product1.jpg'),
('Product 2', 15.50, 'images/product2.jpg'),
('Product 3', 20.00, 'images/product3.jpg');

select * from cart;

UPDATE `meatmarket`.`products` SET `productName` = 'Lamb Head', `category` = 'Lamb' WHERE (`productID` = '8');
UPDATE `meatmarket`.`products` SET `productName` = 'Lamb Breast', `category` = 'Lamb' WHERE (`productID` = '9');
UPDATE `meatmarket`.`products` SET `productName` = 'Lamb Flank', `category` = 'Lamb' WHERE (`productID` = '10');
UPDATE `meatmarket`.`products` SET `productName` = 'Lamb Heel', `category` = 'Lamb' WHERE (`productID` = '11');
UPDATE `meatmarket`.`products` SET `productName` = 'Lamb Leg', `category` = 'Lamb' WHERE (`productID` = '12');
UPDATE `meatmarket`.`products` SET `productName` = 'Lamb Loin', `category` = 'Lamb' WHERE (`productID` = '13');
UPDATE `meatmarket`.`products` SET `productName` = 'Lamb Ribs', `category` = 'Lamb' WHERE (`productID` = '14');
UPDATE `meatmarket`.`products` SET `productName` = 'Lamb Rump', `category` = 'Lamb' WHERE (`productID` = '15');
UPDATE `meatmarket`.`products` SET `productName` = 'Lamb Shank', `category` = 'Lamb' WHERE (`productID` = '16');
UPDATE `meatmarket`.`products` SET `productName` = 'LambShoulder', `category` = 'Lamb' WHERE (`productID` = '17');
