-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 21, 2026 at 12:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fleet_flow`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `aadhar_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `license_number` varchar(50) NOT NULL,
  `license_expiry` date NOT NULL,
  `driver_type` enum('2W','3W','4W','HMV') NOT NULL,
  `joining_date` date NOT NULL,
  `status` enum('active','inactive','on_leave') DEFAULT 'active',
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_number` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `name`, `mobile`, `email`, `birth_date`, `aadhar_number`, `address`, `photo`, `license_number`, `license_expiry`, `driver_type`, `joining_date`, `status`, `emergency_contact_name`, `emergency_contact_number`, `created_at`, `updated_at`) VALUES
(1, 'chadva meet ', '9979430260', 'chavdamayur422005@gmail.com', '2003-02-13', '9756545535634', 'krushna nagar , surendra nagar ', '1771655142_WIN_20251217_15_53_43_Pro.jpg', '4354646get44346', '2026-03-14', 'HMV', '2026-02-01', 'active', 'chavd rajnikantbhai', '9727630260', '2026-02-21 06:25:42', '2026-02-21 06:25:42'),
(2, 'Ramesh Patel', '9904901001', 'ramesh.patel@example.com', '1985-02-15', '123456789012', 'Ahmedabad', 'alex-suprun-ZHvM3XIOHoE-unsplash.jpg', 'DL12345', '2026-12-31', '4W', '2023-01-10', 'active', 'Suresh Patel', '9904902001', '2026-02-21 10:49:42', '2026-02-21 11:48:07'),
(3, 'Mahesh Kumar', '9904901002', 'mahesh.kumar@example.com', '1986-03-20', '123456789013', 'Surat', 'christopher-campbell-rDEOVtE7vOs-unsplash.jpg', 'DL12346', '2026-11-30', '4W', '2023-02-12', 'inactive', 'Ramesh Kumar', '9904902002', '2026-02-21 10:49:42', '2026-02-21 10:53:20'),
(4, 'Suresh Shah', '9904901003', 'suresh.shah@example.com', '1987-04-05', '123456789014', 'Vadodara', NULL, 'DL12347', '2026-10-31', '4W', '2023-03-15', 'inactive', 'Mahesh Shah', '9904902003', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(5, 'Ravi Desai', '9904901004', 'ravi.desai@example.com', '1988-05-12', '123456789015', 'Rajkot', NULL, 'DL12348', '2026-12-15', '4W', '2023-04-18', 'active', 'Hitesh Desai', '9904902004', '2026-02-21 10:49:42', '2026-02-21 11:13:59'),
(6, 'Hitesh Mehta', '9904901005', 'hitesh.mehta@example.com', '1989-06-20', '123456789016', 'Bhavnagar', NULL, 'DL12349', '2026-09-30', '4W', '2023-05-20', 'inactive', 'Rakesh Mehta', '9904902005', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(7, 'Paresh Joshi', '9904901006', 'paresh.joshi@example.com', '1990-07-08', '123456789017', 'Surendranagar', NULL, 'DL12350', '2026-12-31', '4W', '2023-06-22', 'inactive', 'Rajesh Joshi', '9904902006', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(8, 'Jignesh Vyas', '9904901007', 'jignesh.vyas@example.com', '1984-08-15', '123456789018', 'Gandhinagar', NULL, 'DL12351', '2026-11-30', '4W', '2023-07-25', 'inactive', 'Mahesh Vyas', '9904902007', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(9, 'Tejas Patel', '9904901008', 'tejas.patel@example.com', '1985-09-10', '123456789019', 'Anand', NULL, 'DL12352', '2026-10-31', '4W', '2023-08-28', 'inactive', 'Ramesh Patel', '9904902008', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(10, 'Ketan Sharma', '9904901009', 'ketan.sharma@example.com', '1986-10-05', '123456789020', 'Vadodara', NULL, 'DL12353', '2026-12-15', '4W', '2023-09-30', 'inactive', 'Suresh Sharma', '9904902009', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(11, 'Nilesh Chavda', '9904901010', 'nilesh.chavda@example.com', '1987-11-12', '123456789021', 'Ahmedabad', NULL, 'DL12354', '2026-09-30', '4W', '2023-10-05', 'inactive', 'Hitesh Chavda', '9904902010', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(12, 'Harsh Trivedi', '9904901011', 'harsh.trivedi@example.com', '1988-12-20', '123456789022', 'Rajkot', NULL, 'DL12355', '2026-12-31', '4W', '2023-11-08', 'inactive', 'Ravi Trivedi', '9904902011', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(13, 'Vikas Raval', '9904901012', 'vikas.raval@example.com', '1989-01-15', '123456789023', 'Bhavnagar', NULL, 'DL12356', '2026-11-30', '4W', '2023-12-10', 'inactive', 'Paresh Raval', '9904902012', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(14, 'Manish Desai', '9904901013', 'manish.desai@example.com', '1990-02-10', '123456789024', 'Surat', NULL, 'DL12357', '2026-10-31', '4W', '2024-01-12', 'inactive', 'Hitesh Desai', '9904902013', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(15, 'Rohit Pandya', '9904901014', 'rohit.pandya@example.com', '1984-03-08', '123456789025', 'Gandhinagar', NULL, 'DL12358', '2026-12-15', '4W', '2024-02-15', 'inactive', 'Tejas Pandya', '9904902014', '2026-02-21 10:49:42', '2026-02-21 10:49:42'),
(16, 'Chirag Patel', '9904901015', 'chirag.patel@example.com', '1985-04-12', '123456789026', 'Anand', 'WIN_20260121_23_10_38_Pro.jpg', 'DL12359', '2026-09-30', '4W', '2024-03-18', 'inactive', 'Ketan Patel', '9904902015', '2026-02-21 10:49:42', '2026-02-21 10:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `trip_id` int(11) NOT NULL,
  `start_point` varchar(100) NOT NULL,
  `end_point` varchar(100) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `total_items` varchar(255) NOT NULL,
  `total_kg` int(11) NOT NULL,
  `send_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_km` int(11) NOT NULL,
  `status` enum('active','completed','future') NOT NULL DEFAULT 'future',
  `fuel_expense` int(11) NOT NULL DEFAULT 0,
  `other_cost` int(11) NOT NULL DEFAULT 0,
  `description_other_cost` text DEFAULT NULL,
  `total_expense` int(11) NOT NULL DEFAULT 0,
  `total_distance` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`trip_id`, `start_point`, `end_point`, `driver_id`, `vehicle_id`, `total_items`, `total_kg`, `send_date`, `end_date`, `total_km`, `status`, `fuel_expense`, `other_cost`, `description_other_cost`, `total_expense`, `total_distance`) VALUES
(8, 'ahmedabad', 'junagadh', 1, 10, 'led light', 2300, '2026-02-22', '2026-02-23', 300, 'completed', 22000, 3000, '0', 25000, 240),
(9, 'ahmedabad', 'kuchha', 3, 15, 'oniun', 1000, '2026-02-21', '2026-02-22', 230, 'future', 0, 0, NULL, 0, 0),
(10, 'ahmedabad', 'mumbai', 5, 12, 'sadis...', 2999, '2026-02-22', '2026-02-24', 670, 'completed', 23000, 4500, '0', 27500, 240),
(11, 'ahmedabad', 'kuchha', 2, 12, 'led light', 2999, '2026-02-21', '2026-02-22', 220, 'future', 0, 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dispatcher') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'System Admin', 'admin@fleetflow.com', '$2y$10$RYd5C6JNotadKKZhjFcnuOZh6kgQWsbIbP22Sznwl5V89OCu7zdZS', 'admin', '2026-02-21 04:20:27'),
(3, 'Ravi Patel', 'ravi.dispatcher@gmail.com', '$2y$10$examplehashedpasswordhere', 'dispatcher', '2026-02-21 07:28:33'),
(4, 'Chavda mayur', 'meet@123', '$2y$10$agLH5IvLv8brmRuJDBOf2ORbXu.M/jlM2pFEaA1Bgz9WSsl3bec96', 'dispatcher', '2026-02-21 07:34:53'),
(7, 'chavda meet', 'meet@1234', 'meet@1234', 'admin', '2026-02-21 11:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `number_plate` varchar(20) NOT NULL,
  `vehicle_model` varchar(100) NOT NULL,
  `fuel_type` enum('Petrol','Diesel','CNG','Electric') NOT NULL,
  `capacity` int(11) NOT NULL COMMENT 'Seating or Load Capacity',
  `purchase_date` date NOT NULL,
  `insurance_expiry` date NOT NULL,
  `status` enum('Active','Inactive','On Trip','Maintenance') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `number_plate`, `vehicle_model`, `fuel_type`, `capacity`, `purchase_date`, `insurance_expiry`, `status`, `created_at`, `updated_at`) VALUES
(10, 'GJ12AB3034', 'chhota hathi ', 'Petrol', 2500, '2025-01-23', '2026-02-20', 'Active', '2026-02-21 08:44:14', '2026-02-21 09:39:53'),
(11, 'GJ01AB1001', 'Tata 407', 'Diesel', 2500, '2023-01-10', '2024-12-31', 'Active', '2026-02-21 10:46:24', '2026-02-21 10:46:24'),
(12, 'GJ01AB1002', 'Eicher Pro', 'Diesel', 3000, '2023-02-15', '2024-11-30', '', '2026-02-21 10:46:24', '2026-02-21 11:48:07'),
(13, 'GJ01AB1003', 'Mahindra Pickup', 'Diesel', 1800, '2023-03-05', '2024-10-31', 'Active', '2026-02-21 10:46:24', '2026-02-21 10:46:24'),
(14, 'GJ01AB1004', 'Maruti Van', 'Petrol', 1200, '2023-04-12', '2024-12-15', 'Active', '2026-02-21 10:46:24', '2026-02-21 10:46:24'),
(15, 'GJ01AB1005', 'Tata Ace', 'Diesel', 1500, '2023-05-20', '2024-09-30', 'On Trip', '2026-02-21 10:46:24', '2026-02-21 11:15:38'),
(16, 'GJ01AB1006', 'Ashok Leyland Dost', 'Diesel', 2000, '2023-06-25', '2024-12-31', 'Active', '2026-02-21 10:46:24', '2026-02-21 10:46:24'),
(17, 'GJ01AB1007', 'Mahindra Bolero Pickup', 'Diesel', 1700, '2023-07-18', '2024-11-30', 'Active', '2026-02-21 10:46:24', '2026-02-21 10:46:24'),
(18, 'GJ01AB1008', 'Eicher Cargo', 'Diesel', 2200, '2023-08-10', '2024-10-31', 'Active', '2026-02-21 10:46:24', '2026-02-21 10:46:24'),
(19, 'GJ01AB1009', 'Tata Super Ace', 'Diesel', 1600, '2023-09-05', '2024-12-15', 'Active', '2026-02-21 10:46:24', '2026-02-21 10:46:24'),
(20, 'GJ01AB1010', 'Maruti Eeco', 'Petrol', 1200, '2023-10-12', '2024-09-30', 'Active', '2026-02-21 10:46:24', '2026-02-21 10:46:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `aadhar_number` (`aadhar_number`),
  ADD UNIQUE KEY `license_number` (`license_number`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`trip_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number_plate` (`number_plate`),
  ADD UNIQUE KEY `number_plate_2` (`number_plate`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `fk_driver` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
