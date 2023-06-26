-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2023 at 09:44 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cars`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `travel_date` date NOT NULL,
  `return_date` date NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `destination_province` varchar(255) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `status_rental` varchar(30) NOT NULL,
  `car_brand` varchar(255) DEFAULT NULL,
  `car_model` varchar(255) DEFAULT NULL,
  `passenger_count` int(5) NOT NULL,
  `num_days` int(5) NOT NULL,
  `line_id` varchar(100) NOT NULL,
  `return_location` varchar(255) NOT NULL,
  `travel_time` time NOT NULL,
  `b_status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_name`, `phone_number`, `travel_date`, `return_date`, `pickup_location`, `destination_province`, `car_id`, `status_rental`, `car_brand`, `car_model`, `passenger_count`, `num_days`, `line_id`, `return_location`, `travel_time`, `b_status`) VALUES
(114, 'จิตตินันท์ ศรีพราว', '+666989956843', '2023-06-09', '2023-06-24', 'อ่างทอง', 'อ่างทอง', 36, '3', 'HONDA', 'CITY', 0, 15, '', 'อ่างทอง', '00:00:00', 'เช่าขับเอง'),
(115, 'จาติมา อมีขา', '0900956843', '2023-06-10', '2023-06-23', 'ปราจีน', 'พระนครศรีอยุธยา', 35, '5', 'MG', 'Zs', 0, 13, 'edwdqwd', 'อ่างทอง', '00:00:00', 'เช่าขับเอง'),
(116, 'พนันตา ทองม้า', '0634542694', '2023-06-25', '0000-00-00', 'ปราจีน', 'พระนครศรีอยุธยา', 37, '', 'Chevrolet', 'cruze', 4, 4, 'fffff', '', '05:02:00', 'เช่าพร้อมคนขับ'),
(117, 'จิตตินันท์ ศรีพราว', '+666989956843', '2023-06-17', '2023-06-18', 'ปราจีน', 'อ่างทอง', 37, '', 'Chevrolet', 'cruze', 0, 1, '', 'อ่างทอง', '00:00:00', 'เช่าขับเอง');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `car_brand` varchar(50) NOT NULL,
  `car_model` varchar(50) NOT NULL,
  `car_description` varchar(255) DEFAULT NULL,
  `engine_size` varchar(20) DEFAULT NULL,
  `manufacturing_year` int(11) DEFAULT NULL,
  `fuel_type` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `door_count` int(11) DEFAULT NULL,
  `seating_capacity` int(11) DEFAULT NULL,
  `transmission` varchar(50) DEFAULT NULL,
  `price` int(10) NOT NULL,
  `car_type` varchar(200) NOT NULL,
  `status_car` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_brand`, `car_model`, `car_description`, `engine_size`, `manufacturing_year`, `fuel_type`, `color`, `door_count`, `seating_capacity`, `transmission`, `price`, `car_type`, `status_car`) VALUES
(35, 'MG', 'Zs', '1.5 CVT', '1500 ซีซี', 2022, 'เบนซิน95', 'สีดำ', 5, 5, 'อัตโนมัติAT', 1800, 'sedan', 'Ready'),
(36, 'HONDA', 'CITY', '1.5 i-VTEC', '1500 ซีซี', 2013, 'เบนซิน91', 'สีดำ', 4, 5, 'อัตโนมัติAT', 1000, 'sedan', 'Ready'),
(37, 'Chevrolet', 'cruze', '1.8 LTZ', '1800 ซีซี', 2012, 'เบนซิน95', 'สีเทา', 4, 5, 'อัตโนมัติAT', 1200, 'sedan', 'Ready');

-- --------------------------------------------------------

--
-- Table structure for table `car_rental`
--

CREATE TABLE `car_rental` (
  `rental_id` int(11) NOT NULL,
  `bookings_id` int(11) DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `note` varchar(500) NOT NULL,
  `rental_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_rental`
--

INSERT INTO `car_rental` (`rental_id`, `bookings_id`, `customer_name`, `car_id`, `status`, `note`, `rental_date`) VALUES
(1, 114, 'จิตตินันท์ ศรีพราว', 36, '1', '', '2023-06-15'),
(2, 115, 'จาติมา อมีขา', 35, '1', '', '2023-06-15'),
(3, 115, 'จาติมา อมีขา', 35, '2', '', '2023-06-15'),
(4, 115, 'จาติมา อมีขา', 35, '3', 'ลูกค้ามาเอารถไปแล้ว', '2023-06-15'),
(5, 115, 'จาติมา อมีขา', 35, '4', '', '2023-06-15'),
(6, 115, 'จาติมา อมีขา', 35, '5', '', '2023-06-15'),
(7, 114, 'จิตตินันท์ ศรีพราว', 36, '3', '', '2023-06-15'),
(8, 116, 'พนันตา ทองม้า', 37, '1', '', '2023-06-15'),
(9, 117, 'จิตตินันท์ ศรีพราว', 37, '1', '', '2023-06-15');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `car_id`, `image_name`, `image_path`) VALUES
(1, 35, '6489beced3d3a_353810272_164314636489685_7039970301406550820_n.jpg', 'C:/xampp/htdocs/test/image/6489beced3d3a_353810272_164314636489685_7039970301406550820_n.jpg'),
(2, 36, '6489bf2a3e1a1_354083433_125775967199238_8878833192638157505_n.jpg', 'C:/xampp/htdocs/test/image/6489bf2a3e1a1_354083433_125775967199238_8878833192638157505_n.jpg'),
(3, 37, '6489bfbeeb7d7_353141040_279609054447615_586619140182709322_n.jpg', 'C:/xampp/htdocs/test/image/6489bfbeeb7d7_353141040_279609054447615_586619140182709322_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`) VALUES
(21, 'Jittinun Sriporw', 'jan@gmail.com', '$2y$10$1f40WW3hg0A0bQYJqRh59.Lcps3xXDI9XcnaiSLv4qzVRyRQb9Rgi'),
(23, 'อารยา บุญรักษา', 'admin@gmail.com', '$2y$10$IcYIbTGc0qYWGqQvSXsSh.TP4fkwmeU1H8RvIonmFKV.8APJnkrNi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `car_rental`
--
ALTER TABLE `car_rental`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `bookings_id` (`bookings_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `car_rental`
--
ALTER TABLE `car_rental`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `car_rental`
--
ALTER TABLE `car_rental`
  ADD CONSTRAINT `car_rental_ibfk_1` FOREIGN KEY (`bookings_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `car_rental_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
