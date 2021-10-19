-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2021 at 10:51 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_products`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkIsInStock` (IN `PName` TEXT)  NO SQL
SELECT EXISTS(SELECT *
from t_product
WHERE  t_product.ProductName=PName AND t_product.UnitInStock>0 )$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CheckLogIn` (IN `email` TEXT)  NO SQL
SELECT EXISTS(SELECT * FROM users
       WHERE users.Email=email)as user_exist$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CheckPassword` (IN `email` TEXT, IN `psw` VARCHAR(30))  NO SQL
select exists (select  users.HashedPassword from users
where users.Email=email and users.HashedPassword=psw)as validpass$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Creating_db_Tabels_etc` ()  NO SQL
INSERT INTO `t_product` (`ProductName`, `ProductDescription`, `subCategoryID`, `QuantityPerUnit`, `UnitPrice`, `ProductWeight`, `SupplierID`, `active`, `Image`) VALUES ('Black jams boots', 'midi black boots', '7', '2', '159.9', '1.2', '3', '1', 'Images\Products\shoes\bsb.png')$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteproduct` (IN `ID` INT)  NO SQL
DELETE from t_product 
WHERE t_product.ProductID=ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `emailUsersEnterAtDay` (IN `day` DATE)  NO SQL
Select distinct users.Email from users,t_userlog 
Where users.UserID=t_userlog.UserID And DAY(t_userlog.EventDate)=day And t_userlog.EventID=2$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllProducts` ()  NO SQL
SELECT * FROM t_product$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCategories` ()  NO SQL
SELECT * from t_category$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetMissingProducts` ()  NO SQL
SELECT ProductName
FROM t_product
WHERE UnitInStock=0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getNameOfID` (IN `PID` INT)  NO SQL
select t_product.ProductName
from t_product
where t_product.ProductID=PID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductByName` (IN `PN` VARCHAR(30))  NO SQL
select * from t_product
WHERE t_product.ProductName LIKE PN$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductsByShop` (IN `ShopID` INT)  READS SQL DATA
SELECT t_product.ProductName
 FROM t_product ,t_productinshop
 WHERE t_product.ProductID=t_productinshop.ProductID AND t_productinshop.ShopID=ShopID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductsInCategory` (IN `CategoryName` VARCHAR(30))  NO SQL
SELECT * FROM t_product p JOIN t_subcategory s on p.SubCategoryID=s.subCategoryID JOIN t_category c on c.CategoryID=s.CategoryID  WHERE c.CategoryName = CategoryName$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProductsInStock` ()  NO SQL
SELECT ProductName
FROM t_product
WHERE UnitInStock>0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertProduct` (IN `PID` INT, IN `PName` VARCHAR(20), IN `PDesc` TEXT, IN `SubCat` INT, IN `QPU` INT, IN `Price` FLOAT, IN `Weight` FLOAT, IN `UIS` INT, IN `SID` INT, IN `Active` BOOLEAN, IN `Img` TEXT)  NO SQL
INSERT INTO db_products.t_product (ProductID, ProductName, ProductDescription, subCategoryID, QuantityPerUnit, UnitPrice, ProductWeight, UnitInStock, SupplierID, active, Image)
	VALUES (PID ,PName, PDesc, SubCat, QPU, Price, Weight, UIS, SID, Active, Img)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertShop` (IN `ShopID` INT, IN `ShopN` VARCHAR(20))  NO SQL
INSERT INTO db_products.t_shops (ShopID ,ShopName)
	VALUES (ShopID, ShopN)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUser` (IN `FNAME` VARCHAR(20), IN `LNAME` VARCHAR(20), IN `EMAIL` TEXT, IN `PHONENUM` VARCHAR(20), IN `CITY` VARCHAR(20), IN `COUNTRY` VARCHAR(20), IN `STREET` VARCHAR(30), IN `HOUSENUM` INT, IN `DEPARTNUM` INT, IN `ZIPCODE` VARCHAR(20), IN `PSW` VARCHAR(30), IN `CREATEDATE` DATETIME, IN `BIRTHDAY` DATE, IN `GROUPID` INT)  NO SQL
INSERT INTO users ( FirstName,LastName,Email,PhonNumber,City,Country,Street,HouseNumber,DepartmentNumber,ZipCode,HashedPassword,CreatedDate,Birthday,GroupID)
	VALUES (FNAME,LNAME,EMAIL,PHONENUM,CITY,COUNTRY,STREET,HOUSENUM,DEPARTNUM,ZIPCODE,PSW,CREATEDATE,BIRTHDAY,GROUPID)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `IsExists` (IN `PName` VARCHAR(30), IN `PDesc` TEXT)  NO SQL
select exists(
    select * 
    FROM t_product 
    WHERE t_product.ProductName=PName AND t_product.ProductDescription=PDesc) as ex$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ItsCategory` (IN `SCID` INT)  NO SQL
select t_category.CategoryName from t_category,t_subcategory

WHERE t_category.CategoryID=t_subcategory.CategoryID AND t_subcategory.subCategoryID=SCID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MAXHourOfUsersLogIn` ()  NO SQL
Select HOUR(t_userlog.EventDate) as hour from t_userlog 
Where t_userlog.EventID=2 
Group by HOUR(t_userlog.EventDate)
Having  count(DISTINCT t_userlog.UserID) LIKE(
select MAX(y.ME) from 
(Select count(DISTINCT t_userlog.UserID) as ME from t_userlog
Where t_userlog.EventID=2 
Group by HOUR(t_userlog.EventDate))as y)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `subCategoriesBycategory` (IN `CN` VARCHAR(30))  NO SQL
SELECT s.subCategoryName
FROM t_subcategory s INNER JOIN t_category c ON s.CategoryID=c.CategoryID
WHERE c.CategoryName=CN$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `theMostCommonCity` ()  NO SQL
SELECT users.City FROM users GROUP BY users.City having count(*) LIKE (SELECT MAX(bb.CC) from(
SELECT users.City ,count(*) AS CC  from users GROUP BY users.City) bb)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `theMostCommonProduct` ()  NO SQL
SELECT p.ProductName
FROM t_product p 
WHERE p.ProductID LIKE (
SELECT giv.pid
FROM 
(
SELECT l.b AS pid,MAX(l.c)
FROM(
SELECT od.ProductID as b,COUNT(*) as c
FROM orderdetails od
WHERE od.OrderID IN(
SELECT o.OrderID
FROM orders o
WHERE MONTH(o.OrderDate) LIKE (MONTH(CURRENT_DATE())-1))
GROUP BY od.ProductID) l)giv)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateGroup` (IN `email` VARCHAR(30))  NO SQL
UPDATE users 
set users.GroupID=2
where users.Email=email$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdatePassword` (IN `UID` INT, IN `PH` VARCHAR(20))  NO SQL
UPDATE db_products.users
SET users.HashedPassword=HP
WHERE users.UserID=UID$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `grouproles`
--

CREATE TABLE `grouproles` (
  `GroupID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grouproles`
--

INSERT INTO `grouproles` (`GroupID`, `RoleID`) VALUES
(1, 1),
(1, 2),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Discount` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderID`, `ProductID`, `Quantity`, `Discount`) VALUES
(1, 4, 1, '20'),
(1, 16, 1, '150'),
(2, 4, 1, '20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `OrderDate` datetime NOT NULL DEFAULT current_timestamp(),
  `TotalPrice` float NOT NULL,
  `OrderStatus` enum('inProcess','transmit','done','aborted') DEFAULT 'inProcess'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `CustomerID`, `OrderDate`, `TotalPrice`, `OrderStatus`) VALUES
(1, 2, '2021-01-14 22:11:49', 90, 'inProcess'),
(2, 4, '2021-01-08 22:10:18', 103.9, 'done');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleID`, `RoleName`) VALUES
(1, 'READ'),
(2, 'WRITE'),
(3, 'FULL_ACCESS');

-- --------------------------------------------------------

--
-- Table structure for table `t_category`
--

CREATE TABLE `t_category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(20) NOT NULL,
  `Description` text NOT NULL,
  `Image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_category`
--

INSERT INTO `t_category` (`CategoryID`, `CategoryName`, `Description`, `Image`) VALUES
(1, 'Home', 'Kitchen, Bad room', 'Images\\Categories\\home.jpg'),
(2, 'Man Clothes', 'Man Clothes ', 'Images\\Categories\\men.jpg'),
(3, 'Women Clothes', 'Women Clothes ', 'Images\\Categories\\women.png'),
(4, 'Shoes', 'Shoes man and woman', 'Images\\Categories\\shoes.jpg'),
(5, 'Beauty', 'Makeup and Hair', 'Images\\Categories\\beauty.jpg'),
(6, 'Music', 'Gitars Organs...', 'Images\\Categories\\music.jpg'),
(7, 'Baby', 'clothes and products of baby', 'Images\\Categories\\baby.jpg'),
(8, 'Games', 'Gemas for all family', 'Images\\Categories\\games.png'),
(9, 'Electronic', 'Computers Drivers', 'Images\\Categories\\elctronic.png');

-- --------------------------------------------------------

--
-- Table structure for table `t_events`
--

CREATE TABLE `t_events` (
  `EventID` int(11) NOT NULL,
  `EventName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_events`
--

INSERT INTO `t_events` (`EventID`, `EventName`) VALUES
(1, 'CHANGE_PASSWORD'),
(2, 'LOGIN'),
(3, 'LOGOUT');

-- --------------------------------------------------------

--
-- Table structure for table `t_groups`
--

CREATE TABLE `t_groups` (
  `GroupID` int(11) NOT NULL,
  `GroupName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_groups`
--

INSERT INTO `t_groups` (`GroupID`, `GroupName`) VALUES
(1, 'OPERATION'),
(2, 'ADMINISTRATOR');

-- --------------------------------------------------------

--
-- Table structure for table `t_product`
--

CREATE TABLE `t_product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(20) NOT NULL,
  `ProductDescription` text NOT NULL,
  `SubCategoryID` int(11) NOT NULL,
  `QuantityPerUnit` int(11) NOT NULL,
  `UnitPrice` float NOT NULL,
  `ProductWeight` float NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  `Image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_product`
--

INSERT INTO `t_product` (`ProductID`, `ProductName`, `ProductDescription`, `SubCategoryID`, `QuantityPerUnit`, `UnitPrice`, `ProductWeight`, `SupplierID`, `Active`, `Image`) VALUES
(0, 'Ankle boots', 'Blue Ankle boots', 7, 2, 70, 15, 3, 1, 'C:\\'),
(1, 'Boots broun', 'midi bronn boots', 7, 2, 159.9, 13, 3, 1, 'Images\\Products\\shoes\\bs.jpg'),
(2, 'Sock boots', 'black Sock boots', 7, 2, 139.9, 16.5, 3, 1, 'Images\\Products\\shoes\\bsb.jpg'),
(4, 'Sleevless dress', 'Blue Sleevless dress \r\nPink dots', 5, 1, 139.9, 1, 2, 1, 'C:\\'),
(5, 'Pot', 'Silver Pot \r\n20X25X9', 1, 1, 199, 9, 1, 1, 'Images\\Products\\Home\\pot.png'),
(6, 'Tooth brush', 'children Tooth brush', 2, 2, 34.9, 0.6, 4, 1, 'Images\\Products\\Home\\toothbrush.jpg'),
(7, 'basic T-shirt', 'strech basic T-shirt\r\nblue red pink', 6, 1, 19.9, 0.1, 8, 1, 'Images\\Products\\ManClothes\\tshirt.png'),
(8, 'Soft sleepers', 'soft sleepers \r\npink white', 8, 2, 39.9, 0.6, 2, 1, 'Images\\Products\\Shoes\\sleepers.png'),
(9, 'Kitchen chair', 'Kitchen chair', 1, 1, 25, 1, 7, 1, 'Images\\Products\\Home\\kitchc.jpg'),
(10, 'Wind coat', 'Wind coat -Yaellow', 13, 1, 23.9, 0.5, 11, 1, 'Images\\Products\\ManClothes\\windcoat.png'),
(11, 'Jeans pants', 'Jeans pants', 12, 1, 5.6, 1, 12, 1, 'Images\\Products\\ManClothes\\tshirt.png'),
(12, 'Black Suit', 'חליפה שחורה', 11, 27, 14.9, 0.13, 12, 1, 'Images\\Products\\ManClothes\\tshirt.png'),
(13, 'T-Shirt ', 'Blue T-Shirt Cotena', 10, 10, 22, 1.3, 11, 0, 'Images\\Products\\ManClothes\\T-Shirt .png'),
(14, 'Pot', 'Pot\r\n22x20x13', 1, 1, 170.9, 0.46, 5, 1, 'Images\\Products\\Home\\pot.png'),
(15, 'white shirt', 'white shirt\r\n', 6, 1, 213.9, 0.12, 6, 1, 'C:\\'),
(16, 'Gitar', 'Elctronic gitar', 19, 1, 796, 0.9, 10, 1, 'Images\\Products\\Music\\gitar.png'),
(18, 'סדין', '', 3, 1, 79.9, 13.3, 1, 1, 'C:\\'),
(19, 'T-Shirt', '', 6, 13, 134.9, 0.21, 6, 1, 'C:\\'),
(20, 'Shirt ', 'חולצת כותנה', 6, 1, 129.9, 0.12, 6, 1, 'C:\\'),
(21, 'Titul', 'new born', 18, 50, 49.9, 1, 4, 1, 'Images\\Products\\Baby\\titul.png'),
(22, 'Titul', '2', 18, 50, 49.9, 1, 4, 1, 'Images\\Products\\Baby\\titul.png'),
(23, 'Titul', '3', 18, 50, 49.9, 1, 4, 1, 'Images\\Products\\Baby\\titul.png'),
(24, 'Titul', '4', 18, 50, 49.9, 1.3, 4, 1, 'Images\\Products\\Baby\\titul.png'),
(25, 'Titul', '5', 18, 50, 49.9, 1.3, 4, 1, 'Images\\Products\\Baby\\titul.png'),
(28, 'מוצץ', 'soething you put in the mouth', 18, 3, 20, 3, 4, 1, 'Images\\Products\\Baby\\mot.png'),
(29, 'Spoon', 'Silver spoon', 1, 12, 174.9, 13, 1, 1, 'Images\\Products\\Home\\Spoon.png'),
(30, 'computer lenovo', 'something electronic', 23, 1, 5999, 20, 12, 1, 'Images\\Products\\Electronic\\computers.png'),
(31, 'computer 17x14', 'coputer with screen 17x14', 23, 1, 2500.9, 18.2, 12, 1, 'Images\\Products\\Electronic\\computers.png'),
(32, 'shirt', 'shirt', 6, 1, 59, 0.03, 6, 1, 'Images\\Products\\WomenClothes\\shirt.png'),
(33, 'Black jams boots', 'midi black boots', 7, 2, 159.9, 15, 3, 1, 'Images\\Products\\shoes\\bsb'),
(34, 'Black jams boots', 'midi black boots', 7, 2, 159.9, 15, 3, 1, 'Images\\Products\\shoes\\bsb'),
(35, 'Black jams boots', 'midi black boots', 7, 2, 159.9, 1.2, 3, 1, 'Images\\Products\\shoes\\bs.png'),
(36, 'Black jams boots', 'midi black boots', 7, 2, 159.9, 1.2, 3, 1, 'ImagesProductsshoes\\bs.png'),
(40, 'pot', 'מחבת פסים', 4, 3, 70.9, 12.5, 1, 1, 'Images\\Products\\Home\\pot.png'),
(41, 'Pelephon', 'SAFE10 Pelephon', 24, 1, 199, 1.2, 9, 1, 'Images\\Products\\Electronic\\Pelephon.png'),
(42, 'Bottle', 'Hot Bottle', 18, 4, 65.9, 1.2, 4, 1, 'Images\\Products\\Baby\\Bottle.png'),
(43, 'Pelephon UPTEC', 'UPTEC Pelephon', 3, 1, 5, 1.2, 9, 1, 'Images\\Products\\Home\\Pelephon UPTEC.png'),
(44, 'Pelephon UPTEC5', 'UPTEC Pelephon', 3, 1, 5, 1.2, 9, 1, 'Images\\Products\\Home\\Pelephon UPTEC5.png'),
(45, 'Pelephon UPTEC7', 'UPTEC Pelephon', 3, 1, 5, 1.2, 9, 1, 'Images\\Products\\Home\\Pelephon UPTEC7.png'),
(46, 'SUMSONGS10', 'SUMSONG S10 Pelephon', 3, 1, 5, 1.2, 9, 1, 'Images\\Products\\Home\\SUMSONGS10.png'),
(47, 'SUMSONGS120', 'SUMSONG S120 Pelephon', 3, 1, 5, 1.2, 9, 1, 'Images\\Products\\Home\\SUMSONGS120.png'),
(48, 'SUMSONGS1', 'SUMSONG S1 Pelephon', 3, 1, 5, 1.2, 9, 1, 'Images\\Products\\Home\\SUMSONGS1.png');

-- --------------------------------------------------------

--
-- Table structure for table `t_productinshop`
--

CREATE TABLE `t_productinshop` (
  `ProductID` int(11) NOT NULL,
  `ShopID` int(11) NOT NULL,
  `UnitInStock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_productinshop`
--

INSERT INTO `t_productinshop` (`ProductID`, `ShopID`, `UnitInStock`) VALUES
(0, 3, 10),
(0, 6, 20),
(1, 3, 50),
(2, 6, 20),
(4, 3, 0),
(5, 7, 23),
(6, 5, 4),
(7, 2, 3),
(8, 2, 1),
(9, 1, 80),
(10, 1, 80),
(11, 1, 80),
(12, 1, 80),
(13, 1, 80),
(14, 1, 10),
(15, 3, 5),
(16, 9, 6),
(18, 1, 10),
(19, 8, 20),
(20, 6, 13),
(20, 8, 13),
(21, 4, 15),
(22, 4, 2),
(23, 4, 1),
(24, 4, 3),
(25, 4, 40),
(28, 1, 80),
(29, 1, 80),
(30, 1, 80),
(31, 1, 80),
(32, 1, 80),
(33, 1, 80),
(34, 1, 80),
(35, 1, 80),
(36, 1, 80),
(40, 1, 80),
(41, 1, 80),
(42, 1, 80),
(43, 1, 80),
(44, 1, 80),
(45, 1, 80),
(46, 1, 80),
(47, 1, 80),
(48, 1, 80),
(48, 9, 80);

-- --------------------------------------------------------

--
-- Table structure for table `t_shops`
--

CREATE TABLE `t_shops` (
  `ShopID` int(11) NOT NULL,
  `ShopName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_shops`
--

INSERT INTO `t_shops` (`ShopID`, `ShopName`) VALUES
(1, 'FOX HOME'),
(2, 'FOX'),
(3, 'ZARA'),
(4, 'Supper Pharm'),
(5, 'SHILAV'),
(6, 'MANGO'),
(7, 'SHUFER-SAL'),
(8, 'H&M'),
(9, 'Pelephon'),
(10, 'MEGA'),
(11, 'Rolex'),
(12, 'Adidas'),
(13, 'NAUTICA');

-- --------------------------------------------------------

--
-- Table structure for table `t_subcategory`
--

CREATE TABLE `t_subcategory` (
  `subCategoryID` int(11) NOT NULL,
  `subCategoryName` text NOT NULL,
  `CategoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_subcategory`
--

INSERT INTO `t_subcategory` (`subCategoryID`, `subCategoryName`, `CategoryID`) VALUES
(1, 'Kitchen', 1),
(2, 'Bathroom', 1),
(3, 'Bedroom', 1),
(4, 'Skirt', 3),
(5, 'Dress', 3),
(6, 'Shirt', 3),
(7, 'Boots', 4),
(8, 'Slippers', 4),
(9, 'High Heels Shoes', 4),
(10, 'Shirt', 2),
(11, 'Suit', 2),
(12, 'Pants', 2),
(13, 'Coat', 2),
(14, 'Perfumes', 5),
(15, 'Makeup', 5),
(16, 'Wind Instruments', 6),
(17, 'Clothes', 7),
(18, 'Baby accessories', 7),
(19, 'Gitars', 6),
(20, 'Baby games', 8),
(21, 'Children game', 8),
(22, 'Compuyers game', 8),
(23, 'Computers', 9),
(24, 'Pelephon', 9);

-- --------------------------------------------------------

--
-- Table structure for table `t_suppliers`
--

CREATE TABLE `t_suppliers` (
  `SuppliersID` int(11) NOT NULL,
  `SuppliersName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_suppliers`
--

INSERT INTO `t_suppliers` (`SuppliersID`, `SuppliersName`) VALUES
(1, 'FOX HOME'),
(2, 'FOX'),
(3, 'ZARA'),
(4, 'HUGGIES'),
(5, 'Soltam'),
(6, 'Tommy'),
(7, 'Keter'),
(8, 'Basic'),
(9, 'Pelephon'),
(10, 'YAMAHA'),
(11, 'GUCCI'),
(12, 'Lenovo');

-- --------------------------------------------------------

--
-- Table structure for table `t_userlog`
--

CREATE TABLE `t_userlog` (
  `UserLogID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `EventDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_userlog`
--

INSERT INTO `t_userlog` (`UserLogID`, `EventID`, `UserID`, `EventDate`) VALUES
(2, 1, 5, '2020-12-12 00:40:12'),
(1013, 2, 2, '2021-02-07 02:26:14'),
(1014, 2, 2, '2021-02-07 02:29:36'),
(1015, 2, 2, '2021-02-07 02:30:17'),
(1, 2, 5, '2021-01-06 00:40:12'),
(1007, 2, 5, '2021-02-04 20:13:44'),
(1008, 2, 5, '2021-02-04 20:27:44'),
(1009, 2, 5, '2021-02-05 02:41:24'),
(1010, 2, 5, '2021-02-05 02:42:31'),
(1011, 2, 5, '2021-02-07 02:23:41'),
(1012, 2, 5, '2021-02-07 02:24:06'),
(1016, 2, 5, '2021-02-24 20:07:53'),
(1017, 2, 5, '2021-02-24 20:30:02'),
(1018, 2, 5, '2021-02-24 20:46:44'),
(1019, 2, 5, '2021-02-24 20:47:43'),
(1020, 2, 5, '2021-02-24 20:50:06'),
(1021, 2, 5, '2021-02-24 20:50:56'),
(1022, 2, 5, '2021-02-24 20:51:21');

-- --------------------------------------------------------

--
-- Table structure for table `t_userpasswordshistory`
--

CREATE TABLE `t_userpasswordshistory` (
  `UserID` int(11) NOT NULL,
  `PasswordHash` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_userpasswordshistory`
--

INSERT INTO `t_userpasswordshistory` (`UserID`, `PasswordHash`) VALUES
(1, 'AVC'),
(4, 'AAA-123'),
(4, 'BBB'),
(4, 'CCC-123');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `PhonNumber` varchar(20) NOT NULL,
  `City` varchar(20) NOT NULL,
  `Country` varchar(20) NOT NULL,
  `Street` varchar(20) NOT NULL,
  `HouseNumber` int(11) NOT NULL,
  `DepartmentNumber` int(11) DEFAULT NULL,
  `ZipCode` int(11) DEFAULT NULL,
  `HashedPassword` varchar(50) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `Birthday` date NOT NULL,
  `GroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `LastName`, `Email`, `PhonNumber`, `City`, `Country`, `Street`, `HouseNumber`, `DepartmentNumber`, `ZipCode`, `HashedPassword`, `CreatedDate`, `Birthday`, `GroupID`) VALUES
(1, 'Admin', 'Administrator', 'Admin@gmail.com', '12345678', 'admin', 'admin', 'admin', 0, 0, 0, 'PSWRDADMN-321', '2021-02-02 17:44:13', '2016-05-25', 2),
(2, 'Miriam', 'Strauss', 'miriamy733@gmail.com', '0583292733', 'Jerusalem', 'Israel', 'Eben David ', 7, 2, NULL, 'AAA-432', '2021-01-11 00:14:30', '1998-01-07', 2),
(3, 'Bina ', 'Cohen', 'binac123@gmail.com', '05444444444', 'modiin', 'Israel', 'Narkis', 19, NULL, NULL, 'bina', '2021-01-22 00:14:30', '2016-05-25', 1),
(4, 'RUTH', 'ASHUAL', 'ruti3822gmail.com', '0548523822', 'modiin', 'Israel', 'Rakefet', 4, 2, NULL, 'AAA-1234', '2021-01-14 00:14:30', '2016-05-25', 1),
(5, 'Yael', 'Cohen', 'yaelc9977@gmail.com', '0548489977', 'Zichron Yaakov', 'Israel', 'Hacovshim', 93, 1, 3094374, 'ZZZ123', '2021-02-03 00:10:41', '1998-06-12', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grouproles`
--
ALTER TABLE `grouproles`
  ADD PRIMARY KEY (`GroupID`,`RoleID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderID`,`ProductID`),
  ADD KEY `Foreign Key` (`OrderID`,`ProductID`) USING BTREE,
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `t_category`
--
ALTER TABLE `t_category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `t_events`
--
ALTER TABLE `t_events`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `t_groups`
--
ALTER TABLE `t_groups`
  ADD PRIMARY KEY (`GroupID`);

--
-- Indexes for table `t_product`
--
ALTER TABLE `t_product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `Foreign Key` (`SubCategoryID`,`SupplierID`) USING BTREE,
  ADD KEY `SupplierID` (`SupplierID`);

--
-- Indexes for table `t_productinshop`
--
ALTER TABLE `t_productinshop`
  ADD PRIMARY KEY (`ProductID`,`ShopID`) USING BTREE,
  ADD KEY `ShopID` (`ShopID`);

--
-- Indexes for table `t_shops`
--
ALTER TABLE `t_shops`
  ADD PRIMARY KEY (`ShopID`);

--
-- Indexes for table `t_subcategory`
--
ALTER TABLE `t_subcategory`
  ADD PRIMARY KEY (`subCategoryID`) USING BTREE,
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `t_suppliers`
--
ALTER TABLE `t_suppliers`
  ADD PRIMARY KEY (`SuppliersID`);

--
-- Indexes for table `t_userlog`
--
ALTER TABLE `t_userlog`
  ADD PRIMARY KEY (`UserLogID`),
  ADD KEY `EventID` (`EventID`,`UserID`,`EventDate`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `t_userpasswordshistory`
--
ALTER TABLE `t_userpasswordshistory`
  ADD PRIMARY KEY (`UserID`,`PasswordHash`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_category`
--
ALTER TABLE `t_category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `t_groups`
--
ALTER TABLE `t_groups`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_product`
--
ALTER TABLE `t_product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `t_shops`
--
ALTER TABLE `t_shops`
  MODIFY `ShopID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `t_subcategory`
--
ALTER TABLE `t_subcategory`
  MODIFY `subCategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `t_suppliers`
--
ALTER TABLE `t_suppliers`
  MODIFY `SuppliersID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `t_userlog`
--
ALTER TABLE `t_userlog`
  MODIFY `UserLogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1023;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `t_product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_product`
--
ALTER TABLE `t_product`
  ADD CONSTRAINT `t_product_ibfk_1` FOREIGN KEY (`SupplierID`) REFERENCES `t_suppliers` (`SuppliersID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_product_ibfk_2` FOREIGN KEY (`subCategoryID`) REFERENCES `t_subcategory` (`subCategoryID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_productinshop`
--
ALTER TABLE `t_productinshop`
  ADD CONSTRAINT `t_productinshop_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `t_product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_productinshop_ibfk_2` FOREIGN KEY (`ShopID`) REFERENCES `t_shops` (`ShopID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_subcategory`
--
ALTER TABLE `t_subcategory`
  ADD CONSTRAINT `t_subcategory_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `t_category` (`CategoryID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_userlog`
--
ALTER TABLE `t_userlog`
  ADD CONSTRAINT `UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
