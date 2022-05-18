-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2020 at 06:30 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `water_production_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `CustomerName`, `Email`, `Password`, `Phone`, `Address`, `Image`) VALUES
(1, 'john', 'john@gmail.com', 'john', '0973667373', '132st, tamwe township.', '../CustomerImages/_a.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customerfeedback`
--

CREATE TABLE `customerfeedback` (
  `FeedbackID` int(11) NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customerfeedback`
--

INSERT INTO `customerfeedback` (`FeedbackID`, `CustomerName`, `Email`, `Description`) VALUES
(1, 'Nay Thu Naing', 'naythunng@gmail.com', 'Nice'),
(2, 'Nay Thu Naing', 'naythunng@gmail.com', 'very good.'),
(3, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderID` varchar(15) NOT NULL,
  `ProductID` varchar(15) NOT NULL,
  `Price` varchar(200) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderID`, `ProductID`, `Price`, `Quantity`) VALUES
('ORD-000001', 'PUR-000001', '800', 10),
('ORD-000001', 'PUR-000002', '500', 1),
('ORD-000002', 'PUR-000002', '30', 41),
('ORD-000002', 'PUR-000003', '500', 4),
('ORD-000003', 'PUR-000003', '500', 1),
('ORD-000004', 'PUR-000003', '500', 1),
('ORD-000005', 'PUR-000001', '300', 1),
('ORD-000005', 'PUR-000002', '500', 1),
('ORD-000005', 'PUR-000003', '800', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` varchar(15) NOT NULL,
  `OrderDate` date NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `DeliveryAddress` varchar(255) NOT NULL,
  `DeliveryPhone` varchar(50) NOT NULL,
  `TotalQuantity` int(11) NOT NULL,
  `TotalAmount` int(11) NOT NULL,
  `VAT` int(11) NOT NULL,
  `DeliveryCost` int(11) NOT NULL,
  `GrandTotal` int(11) NOT NULL,
  `PaymentType` varchar(50) NOT NULL,
  `CardNo` varchar(50) NOT NULL,
  `Status` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `OrderDate`, `CustomerID`, `DeliveryAddress`, `DeliveryPhone`, `TotalQuantity`, `TotalAmount`, `VAT`, `DeliveryCost`, `GrandTotal`, `PaymentType`, `CardNo`, `Status`) VALUES
('ORD-000001', '2020-04-24', 1, '', '', 12, 8300, 415, 0, 0, 'COD', '', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(20) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `ProductSize` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `BrandName` varchar(100) NOT NULL,
  `Description` varchar(150) NOT NULL,
  `Image1` varchar(255) NOT NULL,
  `SideImage` varchar(255) NOT NULL,
  `Dozen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductSize`, `Quantity`, `Price`, `BrandName`, `Description`, `Image1`, `SideImage`, `Dozen`) VALUES
('PUR-000001', 'Desinger Water', '40 Liters', 100, 800, 'Desinger water', 'Good quantity.', '../ProductImages/_dd.jpg', '../ProductImages/_aa.jpg', '../ProductImages/_d.jpg'),
('PUR-000002', 'Desinger Water', '330 mliters', 200, 150, 'Desinger water', 'Good Quantity.', '../ProductImages/_1.jfif', '../ProductImages/_2.2.jfif', '../ProductImages/_bbb.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `ProductionID` varchar(15) NOT NULL,
  `ProductionDate` date NOT NULL,
  `ProductID` varchar(15) NOT NULL,
  `Qty` varchar(200) NOT NULL,
  `TotalRawPrice` varchar(200) NOT NULL,
  `TotalRawQty` varchar(200) NOT NULL,
  `ProductSize` varchar(50) NOT NULL,
  `StaffID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `production`
--

INSERT INTO `production` (`ProductionID`, `ProductionDate`, `ProductID`, `Qty`, `TotalRawPrice`, `TotalRawQty`, `ProductSize`, `StaffID`) VALUES
('PRO-000001', '2020-04-22', 'PUR-000003', '100', '144000', '480', '5 Liters', 8);

-- --------------------------------------------------------

--
-- Table structure for table `productiondetail`
--

CREATE TABLE `productiondetail` (
  `ProductionID` varchar(30) NOT NULL,
  `RawMaterialsID` int(11) NOT NULL,
  `RawQuantity` int(11) NOT NULL,
  `RawPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productiondetail`
--

INSERT INTO `productiondetail` (`ProductionID`, `RawMaterialsID`, `RawQuantity`, `RawPrice`) VALUES
('PRO-000001', 1, 120, 300),
('PRO-000001', 2, 120, 300),
('PRO-000001', 3, 120, 300),
('PRO-000001', 4, 120, 300);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `PurchaseOrderID` varchar(20) NOT NULL,
  `PurchaseOrderDate` date NOT NULL,
  `TotalAmount` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `TaxAmount` int(11) NOT NULL,
  `GrandTotal` decimal(16,2) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `TotalQuantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorder`
--

INSERT INTO `purchaseorder` (`PurchaseOrderID`, `PurchaseOrderDate`, `TotalAmount`, `SupplierID`, `Status`, `TaxAmount`, `GrandTotal`, `StaffID`, `TotalQuantity`) VALUES
('PUR-000001', '2020-03-13', 2300, 1, 'Pending', 115, '2415.00', 8, 70),
('PUR-000002', '2020-03-14', 600, 1, 'Pending', 30, '630.00', 8, 30);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorderdetail`
--

CREATE TABLE `purchaseorderdetail` (
  `PurchaseOrderID` varchar(20) NOT NULL,
  `RawMaterialsID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `PurchasePrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorderdetail`
--

INSERT INTO `purchaseorderdetail` (`PurchaseOrderID`, `RawMaterialsID`, `Quantity`, `PurchasePrice`) VALUES
('PUR-000001', 0, 20, 40),
('PUR-000001', 9, 40, 30),
('PUR-000001', 10, 50, 3000),
('PUR-000001', 11, 20, 300),
('PUR-000001', 12, 0, 0),
('PUR-000001', 13, 200, 40000),
('PUR-000002', 9, 2, 20),
('PUR-000002', 10, 30, 20),
('PUR-000003', 9, 20, 30);

-- --------------------------------------------------------

--
-- Table structure for table `rawmaterials`
--

CREATE TABLE `rawmaterials` (
  `RawMaterialsID` int(11) NOT NULL,
  `RawMaterialsName` varchar(30) NOT NULL,
  `RegisterDate` date NOT NULL,
  `Price` int(11) NOT NULL,
  `Quantity` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rawmaterials`
--

INSERT INTO `rawmaterials` (`RawMaterialsID`, `RawMaterialsName`, `RegisterDate`, `Price`, `Quantity`) VALUES
(1, 'Sand Filter', '2019-10-16', 30000, '50kg'),
(2, 'Carbon Filter', '2019-10-16', 5000, '60kg'),
(3, 'Ultrafiltration (UF)', '2019-10-16', 30000, '40kg'),
(4, 'Nonofiltration', '2019-10-16', 40000, '30kg'),
(5, 'Ultraviolet (UV)', '2019-10-16', 60000, '20'),
(6, 'Carbon', '2020-03-11', 2000, '12');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `StaffName` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(10) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `StaffTypeID` int(11) NOT NULL,
  `Salary` int(11) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `StaffImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `StaffName`, `Email`, `Password`, `Phone`, `StaffTypeID`, `Salary`, `Address`, `StaffImage`) VALUES
(8, 'hary', 'hary@gmail.com', 'hary', '0937282782833', 1, 500000, 'Ygn', '../StaffImages/_images (1).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stafftype`
--

CREATE TABLE `stafftype` (
  `StaffTypeID` int(11) NOT NULL,
  `StaffType` varchar(30) NOT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stafftype`
--

INSERT INTO `stafftype` (`StaffTypeID`, `StaffType`, `Status`) VALUES
(1, 'Production Manager', 'Active'),
(2, 'Sale Manager', 'Active'),
(3, 'Sale Staff', 'Active'),
(4, 'Production Staff', 'Active'),
(5, 'Delivery Staff', 'Active'),
(6, 'Driver', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `RegisterDate` date NOT NULL,
  `Role` varchar(30) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `Email`, `Password`, `Phone`, `RegisterDate`, `Role`, `Image`, `Address`) VALUES
(1, 'smith', 'smith@gmail.com', 'smith', '0962726278', '2020-03-06', 'Sale', '../SupplierImages/_2.jpg', 'Ygn');

-- --------------------------------------------------------

--
-- Table structure for table `township`
--

CREATE TABLE `township` (
  `TownshipID` int(11) NOT NULL,
  `TownshipName` varchar(200) NOT NULL,
  `DeliveryCost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `township`
--

INSERT INTO `township` (`TownshipID`, `TownshipName`, `DeliveryCost`) VALUES
(1, 'Tamwe', 3000),
(2, 'Bahan', 3500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `customerfeedback`
--
ALTER TABLE `customerfeedback`
  ADD PRIMARY KEY (`FeedbackID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderID`,`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`ProductionID`);

--
-- Indexes for table `productiondetail`
--
ALTER TABLE `productiondetail`
  ADD PRIMARY KEY (`ProductionID`,`RawMaterialsID`);

--
-- Indexes for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  ADD PRIMARY KEY (`PurchaseOrderID`);

--
-- Indexes for table `purchaseorderdetail`
--
ALTER TABLE `purchaseorderdetail`
  ADD PRIMARY KEY (`PurchaseOrderID`,`RawMaterialsID`);

--
-- Indexes for table `rawmaterials`
--
ALTER TABLE `rawmaterials`
  ADD PRIMARY KEY (`RawMaterialsID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `stafftype`
--
ALTER TABLE `stafftype`
  ADD PRIMARY KEY (`StaffTypeID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Indexes for table `township`
--
ALTER TABLE `township`
  ADD PRIMARY KEY (`TownshipID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customerfeedback`
--
ALTER TABLE `customerfeedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rawmaterials`
--
ALTER TABLE `rawmaterials`
  MODIFY `RawMaterialsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `stafftype`
--
ALTER TABLE `stafftype`
  MODIFY `StaffTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `township`
--
ALTER TABLE `township`
  MODIFY `TownshipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
