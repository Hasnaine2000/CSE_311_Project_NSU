-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2024 at 10:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `admin_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`admin_id`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE `airline` (
  `airline_id` int(11) NOT NULL,
  `airline_name` varchar(100) DEFAULT NULL,
  `contact_info` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`airline_id`, `airline_name`, `contact_info`) VALUES
(1, 'Biman Bangladesh Airlines', 'info@biman-airlines.com, +880 2 8901600'),
(2, 'US-Bangla Airlines', 'support@us-banglaairlines.com, +880 1313402706'),
(3, 'Novoair', 'info@flynovoair.com, +880 9617441177'),
(4, 'Regent Airways', 'contact@flyregent.com, +880 1730155931'),
(5, 'Air Astra', 'contact@airastra.com, +880 1234567890'),
(6, 'Biman Bangladesh Airlines', 'info@biman-airlines.com, +880 2 8901600'),
(7, 'US-Bangla Airlines', 'support@us-banglaairlines.com, +880 1313402706'),
(8, 'Novoair', 'info@flynovoair.com, +880 9617441177'),
(9, 'Regent Airways', 'contact@flyregent.com, +880 1730155931'),
(10, 'Air Astra', 'contact@airastra.com, +880 1234567890'),
(11, 'Singapore Airlines', 'support@singaporeair.com, +65 62238888'),
(12, 'Qatar Airways', 'info@qatarairways.com, +974 40230000'),
(13, 'Emirates Airlines', 'contact@emirates.com, +971 600555555'),
(14, 'Thai Airways', 'info@thaiairways.com, +66 23561111'),
(15, 'Turkish Airlines', 'support@thy.com, +90 8503330849'),
(16, 'IndiGo Airlines', 'customercare@goindigo.in, +91 1246173838'),
(17, 'SpiceJet', 'customer.care@spicejet.com, +91 9871803333'),
(18, 'Air India', 'contactus@airindia.in, +91 1242641407'),
(19, 'Malaysia Airlines', 'support@malaysiaairlines.com, +60 377877777'),
(20, 'Cathay Pacific', 'info@cathaypacific.com, +852 27473388'),
(21, 'Etihad Airways', 'feedback@etihad.ae, +971 25990000'),
(22, 'Saudi Airlines', 'info@saudia.com, +966 920022222'),
(23, 'British Airways', 'helpdesk@ba.com, +44 3444930787'),
(24, 'Lufthansa', 'support@lufthansa.com, +49 6986787230'),
(25, 'AirAsia', 'customer@airasia.com, +60 378548888'),
(26, 'Garuda Indonesia', 'info@garuda-indonesia.com, +62 8041807807'),
(27, 'Japan Airlines', 'support@jal.com, +81 368921211'),
(28, 'Korean Air', 'service@koreanair.com, +82 233017711'),
(29, 'Scoot', 'contact@flyscoot.com, +65 31385644'),
(30, 'Bangkok Airways', 'support@bangkokair.com, +66 22702200');

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

CREATE TABLE `airport` (
  `a_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airport`
--

INSERT INTO `airport` (`a_id`, `name`, `location`) VALUES
(1, 'Shahjalal International Airport', 'Dhaka'),
(2, 'Shah Amanat International Airport', 'Chittagong'),
(3, 'Osmani International Airport', 'Sylhet'),
(4, 'Cox\'s Bazar Airport', 'Cox\'s Bazar'),
(5, 'Saidpur Airport', 'Saidpur');

-- --------------------------------------------------------

--
-- Table structure for table `a_f`
--

CREATE TABLE `a_f` (
  `a_id` int(11) NOT NULL,
  `flight_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_f`
--

INSERT INTO `a_f` (`a_id`, `flight_no`) VALUES
(1, 'BG101'),
(2, 'US123'),
(3, 'NV456'),
(4, 'RG789'),
(5, 'AA101');

-- --------------------------------------------------------

--
-- Table structure for table `captain`
--

CREATE TABLE `captain` (
  `pilot_id` int(11) NOT NULL,
  `captain_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `captain`
--

INSERT INTO `captain` (`pilot_id`, `captain_id`) VALUES
(1, 101),
(2, 102),
(3, 103);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flight_no` varchar(20) NOT NULL,
  `dep_time` datetime DEFAULT NULL,
  `arr_time` datetime DEFAULT NULL,
  `plane_id` int(11) DEFAULT NULL,
  `airline_id` int(11) DEFAULT NULL,
  `from_` varchar(20) DEFAULT NULL,
  `to_` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_no`, `dep_time`, `arr_time`, `plane_id`, `airline_id`, `from_`, `to_`) VALUES
('AA101', '2024-11-13 15:15:00', '2024-11-13 18:45:00', 5, 5, 'New York', 'Berlin'),
('AA890', '2024-11-15 09:00:00', '2024-11-15 16:00:00', 20, 5, 'New York', 'Berlin'),
('AI678', '2024-11-14 10:15:00', '2024-11-14 13:45:00', 18, 18, 'New York', 'Berlin'),
('BA333', '2024-11-14 14:30:00', '2024-11-14 17:15:00', 22, 16, 'London', 'Rome'),
('BG101', '2024-11-12 10:00:00', '2024-11-12 13:00:00', 1, 1, 'New York', 'Berlin'),
('CX555', '2024-11-14 09:00:00', '2024-11-14 13:15:00', 25, 20, 'Hong Kong', 'San Francisco'),
('EK567', '2024-11-14 22:30:00', '2024-11-15 05:45:00', 13, 8, 'Dubai', 'London'),
('ET555', '2024-11-15 11:00:00', '2024-11-15 20:00:00', 16, 12, 'Abu Dhabi', 'New York'),
('GA123', '2024-11-13 12:00:00', '2024-11-13 18:30:00', 21, 15, 'Jakarta', 'Sydney'),
('LH999', '2024-11-15 06:00:00', '2024-11-15 10:30:00', 23, 17, 'Berlin', 'Paris'),
('MH220', '2024-11-13 20:00:00', '2024-11-14 01:00:00', 24, 19, 'Kuala Lumpur', 'Beijing'),
('NV456', '2024-11-12 18:45:00', '2024-11-12 21:15:00', 3, 3, 'Paris', 'Sydney'),
('NY456', '2024-11-13 17:30:00', '2024-11-14 01:00:00', 15, 10, 'Berlin', 'Cape Town'),
('QR345', '2024-11-14 12:00:00', '2024-11-14 18:00:00', 12, 7, 'Doha', 'New York'),
('RG789', '2024-11-13 09:00:00', '2024-11-13 11:30:00', 4, 4, 'New York', 'Rome'),
('SA999', '2024-11-13 20:45:00', '2024-11-14 05:15:00', 17, 13, 'Riyadh', 'Toronto'),
('SQ890', '2024-11-13 08:15:00', '2024-11-13 16:00:00', 11, 6, 'Singapore', 'Tokyo'),
('TG456', '2024-11-12 16:30:00', '2024-11-12 20:00:00', 14, 9, 'Tokyo', 'Bangkok'),
('TH111', '2024-11-14 06:45:00', '2024-11-14 10:30:00', 19, 14, 'Bangkok', 'Sydney'),
('US123', '2024-11-12 14:30:00', '2024-11-12 17:00:00', 2, 2, 'London3', 'Rome');

-- --------------------------------------------------------

--
-- Table structure for table `has`
--

CREATE TABLE `has` (
  `plane_id` int(11) NOT NULL,
  `flight_no` varchar(20) NOT NULL,
  `pilot_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `has`
--

INSERT INTO `has` (`plane_id`, `flight_no`, `pilot_id`) VALUES
(1, 'BG101', 1),
(2, 'US123', 2),
(3, 'NV456', 3);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `serial_no` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`serial_no`, `user_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `lounge`
--

CREATE TABLE `lounge` (
  `a_id` int(11) NOT NULL,
  `l_id` int(11) NOT NULL,
  `l_name` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lounge`
--

INSERT INTO `lounge` (`a_id`, `l_id`, `l_name`, `capacity`) VALUES
(1, 101, 'VIP Lounge Dhaka', 50),
(1, 102, 'Business Lounge Dhaka', 70),
(2, 201, 'VIP Lounge Chittagong', 40),
(3, 301, 'VIP Lounge Sylhet', 35),
(4, 401, 'VIP Lounge Cox\'s Bazar', 30);

-- --------------------------------------------------------

--
-- Table structure for table `lounge_facilities`
--

CREATE TABLE `lounge_facilities` (
  `a_id` int(11) NOT NULL,
  `facilities` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lounge_facilities`
--

INSERT INTO `lounge_facilities` (`a_id`, `facilities`) VALUES
(1, 'Buffet Service'),
(1, 'Free Wi-Fi'),
(2, 'Prayer Room'),
(3, 'Business Center'),
(4, 'Kids Zone'),
(4, 'Relaxation Area');

-- --------------------------------------------------------

--
-- Table structure for table `luggage`
--

CREATE TABLE `luggage` (
  `luggage_id` int(11) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `size` varchar(50) NOT NULL,
  `ticket_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `luggage`
--

INSERT INTO `luggage` (`luggage_id`, `weight`, `size`, `ticket_no`) VALUES
(1, 23.50, 'Large', 1),
(2, 15.00, 'Medium', 2),
(3, 7.80, 'Small', 3),
(4, 12.30, 'Medium', 4),
(5, 25.00, 'Large', 5);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `p_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `ticket_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`p_id`, `amount`, `method`, `status`, `ticket_no`) VALUES
(1, 6000.00, 'Bank Transfer', 'Completed', 1),
(2, 5500.00, 'Mobile Payment', 'Pending', 2),
(3, 6200.00, 'Bank Transfer', 'Completed', 3),
(4, 5700.00, 'Mobile Payment', 'Failed', 4),
(5, 7000.00, 'Bank Transfer', 'Completed', 5),
(26, 6000.00, 'Mobile Banking', 'Completed', 138),
(27, 6000.00, 'Mobile Banking', 'Completed', 139),
(28, 6000.00, 'Bank Transfer', 'Completed', 140),
(29, 6000.00, 'Mobile Banking', 'Pending', 141),
(30, 12000.00, 'Mobile Banking', 'Completed', 144);

-- --------------------------------------------------------

--
-- Table structure for table `pilot`
--

CREATE TABLE `pilot` (
  `pilot_id` int(11) NOT NULL,
  `DOB` date NOT NULL,
  `pi_f_name` varchar(50) NOT NULL,
  `pi_m_name` varchar(50) DEFAULT NULL,
  `pi_l_name` varchar(50) NOT NULL,
  `licence_no` varchar(100) NOT NULL,
  `flight_hr` int(11) NOT NULL,
  `salary` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pilot`
--

INSERT INTO `pilot` (`pilot_id`, `DOB`, `pi_f_name`, `pi_m_name`, `pi_l_name`, `licence_no`, `flight_hr`, `salary`) VALUES
(1, '1985-03-15', 'Rafiqul', 'Ahmed', 'Chowdhury', 'LN123456', 3500, 150000.00),
(2, '1978-06-21', 'Sadia', 'Tul', 'Rahman', 'LN789012', 4500, 200000.00),
(3, '1990-12-05', 'Arif', 'Hossain', 'Khan', 'LN345678', 2500, 120000.00);

-- --------------------------------------------------------

--
-- Table structure for table `plane`
--

CREATE TABLE `plane` (
  `plane_id` int(11) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `airline_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plane`
--

INSERT INTO `plane` (`plane_id`, `model`, `capacity`, `airline_id`) VALUES
(1, 'Boeing 787', 270, 1),
(2, 'Dash 8-Q400', 78, 2),
(3, 'ATR 72-500', 74, 3),
(4, 'Boeing 737', 160, 4),
(5, 'Embraer E190', 98, 5),
(6, 'Boeing 787', 270, 1),
(7, 'Dash 8-Q400', 78, 2),
(8, 'ATR 72-500', 74, 3),
(9, 'Boeing 737', 160, 4),
(10, 'Embraer E190', 98, 5),
(11, 'Airbus A350', 300, 6),
(12, 'Boeing 777', 396, 7),
(13, 'Airbus A380', 853, 8),
(14, 'Boeing 747', 416, 9),
(15, 'Airbus A321', 236, 10),
(16, 'Airbus A320', 180, 11),
(17, 'Boeing 737 MAX 8', 189, 12),
(18, 'Boeing 787 Dreamliner', 256, 13),
(19, 'Boeing 737-800', 160, 14),
(20, 'Airbus A330', 277, 15),
(21, 'Boeing 787-10', 318, 16),
(22, 'Boeing 777-300ER', 396, 17),
(23, 'Airbus A320neo', 174, 18),
(24, 'Airbus A340', 440, 19),
(25, 'Airbus A330-300', 277, 20),
(26, 'Boeing 737-800', 162, 21),
(27, 'Boeing 767', 269, 22),
(28, 'Boeing 777-200', 312, 23),
(29, 'Airbus A321XLR', 244, 24),
(30, 'ATR 72-600', 70, 25);

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `query_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `query_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`query_id`, `email`, `query_text`) VALUES
(4, 'tushar@akij.com', 'i cant log in'),
(5, 'abir@jaq.com', 'how to get latest update'),
(6, 'sadia@brac.com', 'cheapest flights kivabe katbo?'),
(11, 'pial@gmail.com', 'kire ki obostha?'),
(12, 'sadia@gmail.com', 'ki foiehf');

-- --------------------------------------------------------

--
-- Table structure for table `reschedule`
--

CREATE TABLE `reschedule` (
  `r_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `r_status` varchar(20) NOT NULL,
  `ticket_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reschedule`
--

INSERT INTO `reschedule` (`r_id`, `date`, `time`, `r_status`, `ticket_no`) VALUES
(1, '2024-11-15', '14:30:00', 'Pending', 1),
(2, '2024-11-16', '09:00:00', 'Approved', 2),
(3, '2024-11-17', '18:45:00', 'Cancelled', 3),
(4, '2024-11-18', '12:00:00', 'Pending', 4),
(5, '2024-11-19', '07:15:00', 'Approved', 5),
(47, '2024-12-01', '18:16:51', 'Pending', 139),
(48, '2024-12-01', '19:28:22', 'Pending', 138),
(49, '2024-12-01', '19:28:22', 'Pending', 138),
(50, '2024-12-01', '19:28:22', 'Pending', 138),
(51, '2024-12-01', '19:28:22', 'Pending', 138),
(52, '2024-12-02', '04:11:08', 'Pending', 138),
(53, '2024-12-02', '04:11:08', 'Pending', 138),
(54, '2024-12-02', '04:11:08', 'Pending', 138),
(55, '2024-12-02', '04:11:08', 'Pending', 138),
(56, '2024-12-02', '04:12:19', 'Pending', 138),
(57, '2024-12-02', '04:12:19', 'Pending', 138),
(58, '2024-12-02', '04:12:19', 'Pending', 138),
(59, '2024-12-02', '04:12:19', 'Pending', 138),
(60, '2024-12-02', '04:31:52', 'Pending', 144),
(61, '2024-12-02', '04:31:52', 'Pending', 144),
(62, '2024-12-02', '04:31:52', 'Pending', 144),
(63, '2024-12-02', '04:31:52', 'Pending', 144),
(64, '2024-12-02', '04:32:04', 'Pending', 144),
(65, '2024-12-02', '04:32:04', 'Pending', 144),
(66, '2024-12-02', '04:32:04', 'Pending', 144),
(67, '2024-12-02', '04:32:04', 'Pending', 144);

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `s_id` int(11) NOT NULL,
  `s_no` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `flight_no` varchar(10) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `ticket_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`s_id`, `s_no`, `status`, `flight_no`, `price`, `ticket_no`) VALUES
(7, '1A', 'booked', 'AA101', 6600.00, 143),
(10, '5B', 'booked', 'AA101', 5000.00, 138),
(13, '2A', 'booked', 'AA101', 6500.00, 144),
(14, '2B', 'booked', 'AA101', 6000.00, 140),
(15, '3A', 'booked', 'AA101', 5500.00, 144),
(16, '3B', 'booked', 'AA890', 6000.00, 142),
(17, '4A', 'available', 'AA101', 4500.00, NULL),
(18, '4B', 'available', 'AA101', 6500.00, NULL),
(19, '5A', 'booked', 'AA890', 6000.00, 141),
(20, '5B', 'available', 'AA890', 6000.00, NULL),
(23, '2A', 'booked', 'AI678', 6000.00, NULL),
(24, '2B', 'available', 'AI678', 6000.00, NULL),
(25, '3A', 'available', 'AI678', 6000.00, NULL),
(26, '3B', 'available', 'AI678', 6000.00, NULL),
(27, '4A', 'available', 'AI678', 6000.00, NULL),
(28, '4B', 'available', 'AI678', 6000.00, NULL),
(29, '5A', 'available', 'AI678', 6000.00, NULL),
(30, '5B', 'available', 'AI678', 6000.00, NULL),
(31, '1A', 'available', 'BA333', 6000.00, NULL),
(32, '1B', 'available', 'BA333', 6000.00, NULL),
(33, '2A', 'available', 'BA333', 6000.00, NULL),
(34, '2B', 'available', 'BA333', 6000.00, NULL),
(35, '3A', 'available', 'BA333', 6000.00, NULL),
(36, '3B', 'available', 'BA333', 6000.00, NULL),
(37, '4A', 'available', 'BA333', 6000.00, NULL),
(38, '4B', 'available', 'BA333', 6000.00, NULL),
(39, '5A', 'available', 'BA333', 6000.00, NULL),
(40, '5B', 'available', 'BA333', 6000.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `terminal`
--

CREATE TABLE `terminal` (
  `terminal_id` int(11) NOT NULL,
  `terminal_no` varchar(10) DEFAULT NULL,
  `a_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminal`
--

INSERT INTO `terminal` (`terminal_id`, `terminal_no`, `a_id`) VALUES
(1, 'T1', 1),
(2, 'T2', 1),
(3, 'T1', 2),
(4, 'T1', 3),
(5, 'T1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_no` int(11) NOT NULL,
  `from_location` varchar(100) NOT NULL,
  `to_location` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `t_status` varchar(20) NOT NULL,
  `flight_no` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_no`, `from_location`, `to_location`, `date`, `price`, `t_status`, `flight_no`, `user_id`) VALUES
(1, 'Dhaka', 'Chittagong', '2024-11-12', 5500.00, 'Booked', 'BG101', 1),
(2, 'Dhaka', 'Sylhet', '2024-11-12', 4000.00, 'Booked', 'US123', 2),
(3, 'Dhaka', 'Rajshahi', '2024-11-13', 6000.00, 'Booked', 'NV456', 3),
(4, 'Barisal', 'Dhaka', '2024-11-13', 4500.00, 'Booked', 'RG789', 1),
(5, 'Chittagong', 'Dhaka', '2024-11-12', 5500.00, 'Cancelled', 'AA101', 2),
(138, 'New York', 'Berlin', '2024-11-30', 6000.00, 'Booked', 'AA101', 7),
(139, 'New York', 'Los Angeles', '2024-12-01', 6000.00, 'Rescheduled', 'AA890', 7),
(140, 'New York', 'Los Angeles', '2024-12-01', 6000.00, 'Booked', 'AA890', 7),
(141, 'New York', 'Los Angeles', '2024-12-01', 6000.00, 'Pending', 'AA890', 7),
(142, 'New York', 'Los Angeles', '2024-12-01', 6000.00, 'Pending', 'AA890', 7),
(143, 'New York', 'Berlin', '2024-12-02', 6600.00, 'Pending', 'AA101', 7),
(144, 'New York', 'Berlin', '2024-12-02', 12000.00, 'Booked', 'AA101', 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `us_f_name` varchar(50) NOT NULL,
  `us_m_name` varchar(50) DEFAULT NULL,
  `us_l_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `us_f_name`, `us_m_name`, `us_l_name`, `email`, `DOB`, `phone_no`, `password`) VALUES
(1, 'Rafiq', 'Uddin', 'Ahmed', 'rafiq.ahmed@example.com', '1980-01-01', '01711111111', '1234'),
(2, 'Sumiya', 'Alam', 'Khan', 'sumiya.khan@example.com', '1992-04-15', '01722222222', '1234'),
(3, 'Hasnat', 'Al', 'Karim', 'hasnat.karim@example.com', '1985-06-10', '01733333333', '1234'),
(7, 'Md ', 'Arafat', 'Amin', 'arafat@gmail.com', '2001-01-08', '01990867183', '1234'),
(10, 'Arafat', 'Amin', 'Bhai', 'dghdh@gmail.com', '2017-05-25', '4353636', 'trtr'),
(14, 'Asad', 'Amin', 'sunny', 'asad@gmail.com', '2024-12-19', '018464272442', '1234'),
(15, 'md', 'sefi', 'khan', 'sefi@gmail.com', '2024-12-26', '018434872', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`airline_id`);

--
-- Indexes for table `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `a_f`
--
ALTER TABLE `a_f`
  ADD PRIMARY KEY (`a_id`,`flight_no`),
  ADD KEY `flight_no` (`flight_no`);

--
-- Indexes for table `captain`
--
ALTER TABLE `captain`
  ADD PRIMARY KEY (`pilot_id`,`captain_id`),
  ADD UNIQUE KEY `pilot_id` (`pilot_id`),
  ADD UNIQUE KEY `captain_id` (`captain_id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_no`),
  ADD KEY `plane_id` (`plane_id`),
  ADD KEY `airline_id` (`airline_id`);

--
-- Indexes for table `has`
--
ALTER TABLE `has`
  ADD PRIMARY KEY (`plane_id`,`flight_no`,`pilot_id`),
  ADD KEY `flight_no` (`flight_no`),
  ADD KEY `pilot_id` (`pilot_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`serial_no`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lounge`
--
ALTER TABLE `lounge`
  ADD PRIMARY KEY (`a_id`,`l_id`);

--
-- Indexes for table `lounge_facilities`
--
ALTER TABLE `lounge_facilities`
  ADD PRIMARY KEY (`a_id`,`facilities`);

--
-- Indexes for table `luggage`
--
ALTER TABLE `luggage`
  ADD PRIMARY KEY (`luggage_id`),
  ADD KEY `ticket_no` (`ticket_no`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `ticket_no` (`ticket_no`);

--
-- Indexes for table `pilot`
--
ALTER TABLE `pilot`
  ADD PRIMARY KEY (`pilot_id`),
  ADD UNIQUE KEY `licence_no` (`licence_no`);

--
-- Indexes for table `plane`
--
ALTER TABLE `plane`
  ADD PRIMARY KEY (`plane_id`),
  ADD KEY `airline_id` (`airline_id`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`query_id`);

--
-- Indexes for table `reschedule`
--
ALTER TABLE `reschedule`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `ticket_no` (`ticket_no`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `fk_flight_no` (`flight_no`),
  ADD KEY `fk_seat` (`ticket_no`);

--
-- Indexes for table `terminal`
--
ALTER TABLE `terminal`
  ADD PRIMARY KEY (`terminal_id`),
  ADD KEY `a_id` (`a_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_no`),
  ADD KEY `flight_no` (`flight_no`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_no` (`phone_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airline`
--
ALTER TABLE `airline`
  MODIFY `airline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `airport`
--
ALTER TABLE `airport`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `captain`
--
ALTER TABLE `captain`
  MODIFY `captain_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `luggage`
--
ALTER TABLE `luggage`
  MODIFY `luggage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pilot`
--
ALTER TABLE `pilot`
  MODIFY `pilot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `plane`
--
ALTER TABLE `plane`
  MODIFY `plane_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reschedule`
--
ALTER TABLE `reschedule`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `terminal`
--
ALTER TABLE `terminal`
  MODIFY `terminal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `a_f`
--
ALTER TABLE `a_f`
  ADD CONSTRAINT `a_f_ibfk_1` FOREIGN KEY (`a_id`) REFERENCES `airport` (`a_id`),
  ADD CONSTRAINT `a_f_ibfk_2` FOREIGN KEY (`flight_no`) REFERENCES `flight` (`flight_no`);

--
-- Constraints for table `captain`
--
ALTER TABLE `captain`
  ADD CONSTRAINT `captain_ibfk_1` FOREIGN KEY (`pilot_id`) REFERENCES `pilot` (`pilot_id`);

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`plane_id`) REFERENCES `plane` (`plane_id`),
  ADD CONSTRAINT `flight_ibfk_2` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`airline_id`);

--
-- Constraints for table `has`
--
ALTER TABLE `has`
  ADD CONSTRAINT `has_ibfk_1` FOREIGN KEY (`plane_id`) REFERENCES `plane` (`plane_id`),
  ADD CONSTRAINT `has_ibfk_2` FOREIGN KEY (`flight_no`) REFERENCES `flight` (`flight_no`),
  ADD CONSTRAINT `has_ibfk_3` FOREIGN KEY (`pilot_id`) REFERENCES `pilot` (`pilot_id`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `lounge`
--
ALTER TABLE `lounge`
  ADD CONSTRAINT `lounge_ibfk_1` FOREIGN KEY (`a_id`) REFERENCES `airport` (`a_id`);

--
-- Constraints for table `lounge_facilities`
--
ALTER TABLE `lounge_facilities`
  ADD CONSTRAINT `lounge_facilities_ibfk_1` FOREIGN KEY (`a_id`) REFERENCES `airport` (`a_id`);

--
-- Constraints for table `luggage`
--
ALTER TABLE `luggage`
  ADD CONSTRAINT `luggage_ibfk_1` FOREIGN KEY (`ticket_no`) REFERENCES `ticket` (`ticket_no`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`ticket_no`) REFERENCES `ticket` (`ticket_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `plane`
--
ALTER TABLE `plane`
  ADD CONSTRAINT `plane_ibfk_1` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`airline_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reschedule`
--
ALTER TABLE `reschedule`
  ADD CONSTRAINT `reschedule_ibfk_1` FOREIGN KEY (`ticket_no`) REFERENCES `ticket` (`ticket_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `fk_flight_no` FOREIGN KEY (`flight_no`) REFERENCES `flight` (`flight_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seat` FOREIGN KEY (`ticket_no`) REFERENCES `ticket` (`ticket_no`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `terminal`
--
ALTER TABLE `terminal`
  ADD CONSTRAINT `terminal_ibfk_1` FOREIGN KEY (`a_id`) REFERENCES `airport` (`a_id`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`flight_no`) REFERENCES `flight` (`flight_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
