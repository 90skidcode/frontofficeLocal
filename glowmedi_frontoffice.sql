-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 24, 2021 at 04:17 AM
-- Server version: 5.7.35-cll-lve
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `glowmedi_frontoffice`
--

-- --------------------------------------------------------

--
-- Table structure for table `advance_master`
--

CREATE TABLE `advance_master` (
  `advance_master_id` int(11) NOT NULL,
  `advance_no` varchar(30) NOT NULL,
  `advance_type` enum('B','R') NOT NULL,
  `advance_amount` float NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `process_no` varchar(30) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advance_master`
--

INSERT INTO `advance_master` (`advance_master_id`, `advance_no`, `advance_type`, `advance_amount`, `payment_mode`, `process_no`, `customer_id`, `status`, `created_at`, `created_by`, `updated_at`) VALUES
(1, 'ADV100001', 'R', 10000, 1, 'RES1', 1, 1, '2021-09-23 10:55:29', '1000488', '2021-09-23 15:33:15'),
(2, 'ADV100002', 'R', 20000, 1, 'RES2', 1, 1, '2021-09-23 10:58:50', '1000488', '0000-00-00 00:00:00'),
(3, 'ADV100003', 'R', 100, 1, 'RES4', 1, 1, '2021-09-23 15:34:05', '1000488', '2021-09-23 15:35:34'),
(4, 'ADV100004', 'R', 10000, 1, 'RES5', 1, 1, '2021-09-23 15:43:17', '', '0000-00-00 00:00:00'),
(5, 'ADV100005', 'R', 100, 1, 'RES5', 1, 1, '2021-09-23 15:43:44', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `booking_master`
--

CREATE TABLE `booking_master` (
  `booking_id` int(11) NOT NULL,
  `booking_no` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `room_type` text NOT NULL,
  `no_of_nights` text NOT NULL,
  `from_date` text NOT NULL,
  `to_date` text NOT NULL,
  `room_no` text NOT NULL,
  `adults` text NOT NULL,
  `infant` text NOT NULL,
  `no_extra_bed` text NOT NULL,
  `price` text NOT NULL,
  `discount_percentage` text NOT NULL,
  `discount_amount` text NOT NULL,
  `room_total` text NOT NULL,
  `total_Beforetax` float NOT NULL,
  `Tax_percetage` int(11) NOT NULL,
  `total_TaxAmount` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `total_discount` float NOT NULL,
  `booking_type` enum('I','G','A') NOT NULL,
  `booking_status` enum('A','D','C','N') NOT NULL COMMENT 'A-Amend\r\nD-Delete\r\nC-Confirm\r\nB-booked',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking_master_detail`
--

CREATE TABLE `booking_master_detail` (
  `booking_master_detail_id` int(11) NOT NULL,
  `booking_no` varchar(30) NOT NULL,
  `room_no` int(11) NOT NULL,
  `room_category` int(11) NOT NULL,
  `hotel_no_of_night` int(11) NOT NULL,
  `hotel_from_date` datetime NOT NULL,
  `hotel_to_date` datetime NOT NULL,
  `hotel_no_of_adults` int(11) NOT NULL,
  `hotel_no_of_childs` int(11) NOT NULL,
  `hotel_no_of_extra_bed` int(11) NOT NULL,
  `hotel_price` float NOT NULL,
  `room_cgst` varchar(10) NOT NULL,
  `room_sgst` varchar(10) NOT NULL,
  `hotel_discount` int(11) NOT NULL,
  `discount_amount` float NOT NULL,
  `room_total` float NOT NULL,
  `room_status` enum('I','O','S','D') NOT NULL COMMENT 'I - Check IN  , O - CHeck out, S - swap,D- Room Delete',
  `invoice_no` varchar(30) NOT NULL,
  `tracking_id` bigint(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_master_detail`
--

INSERT INTO `booking_master_detail` (`booking_master_detail_id`, `booking_no`, `room_no`, `room_category`, `hotel_no_of_night`, `hotel_from_date`, `hotel_to_date`, `hotel_no_of_adults`, `hotel_no_of_childs`, `hotel_no_of_extra_bed`, `hotel_price`, `room_cgst`, `room_sgst`, `hotel_discount`, `discount_amount`, `room_total`, `room_status`, `invoice_no`, `tracking_id`) VALUES
(1, 'CHK1', 104, 3, 3, '2021-09-23 16:29:00', '2021-09-26 16:30:00', 5, 0, 0, 15000, '6', '6', 5, 750, 47880, 'I', '', 1563022405),
(2, 'CHK1', 103, 2, 3, '2021-09-23 16:29:00', '2021-09-26 16:30:00', 5, 0, 0, 10000, '6', '6', 5, 500, 31920, 'I', '', 1563022405),
(3, 'CHK2', 105, 1, 1, '2021-09-23 16:25:00', '2021-09-23 21:11:01', 2, 0, 0, 3000, '6', '6', 5, 150, 3192, 'O', 'INV100001', 359447630),
(4, 'CHK2', 701, 4, 1, '2021-09-23 16:26:00', '2021-09-23 21:11:01', 2, 0, 0, 5000, '6', '6', 5, 250, 5320, 'O', 'INV100001', 359447630),
(5, 'CHK2', 101, 1, 1, '2021-09-23 16:26:00', '2021-09-23 21:11:01', 4, 0, 0, 3000, '6', '6', 5, 150, 3192, 'O', 'INV100001', 359447630),
(6, 'CHK3', 102, 1, 1, '2021-09-23 17:30:00', '2021-09-25 17:30:00', 2, 0, 0, 3000, '9', '9', 0, 0, 3540, 'I', '', 1038338537),
(7, 'CHK4', 105, 1, 7, '2021-09-23 21:12:00', '2021-09-30 21:12:00', 2, 0, 0, 3000, '9', '9', 5, 150, 23541, 'I', '', 542915675),
(8, 'CHK4', 701, 4, 1, '2021-09-23 22:20:00', '2021-09-24 22:21:00', 2, 0, 0, 2000, '9', '9', 10, 200, 2124, 'D', '', 0);

--
-- Triggers `booking_master_detail`
--
DELIMITER $$
CREATE TRIGGER `add_booking_master_detail` AFTER INSERT ON `booking_master_detail` FOR EACH ROW INSERT INTO booking_master_detail_track
SET booking_master_detail_id = NEW.booking_master_detail_id,
booking_no = NEW.booking_no,
room_category = NEW.room_category,
hotel_no_of_night = NEW.hotel_no_of_night,
hotel_from_date = NEW.hotel_from_date,
hotel_to_date = NEW.hotel_to_date,
room_no = NEW.room_no,
hotel_no_of_adults = NEW.hotel_no_of_adults,
hotel_no_of_childs = NEW.hotel_no_of_childs,
hotel_no_of_extra_bed = NEW.hotel_no_of_extra_bed,
hotel_price = NEW.hotel_price,
hotel_discount = NEW.hotel_discount,
discount_amount = NEW.discount_amount,
room_total = NEW.room_total,
room_status = NEW.room_status,
tracking_id = NEW.tracking_id,
action="insert"
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_booking_master_detail` AFTER UPDATE ON `booking_master_detail` FOR EACH ROW INSERT INTO booking_master_detail_track
SET booking_master_detail_id = NEW.booking_master_detail_id,
booking_no = NEW.booking_no,
room_category = NEW.room_category,
hotel_no_of_night = NEW.hotel_no_of_night,
hotel_from_date = NEW.hotel_from_date,
hotel_to_date = NEW.hotel_to_date,
room_no = NEW.room_no,
hotel_no_of_adults = NEW.hotel_no_of_adults,
hotel_no_of_childs = NEW.hotel_no_of_childs,
hotel_no_of_extra_bed = NEW.hotel_no_of_extra_bed,
hotel_price = NEW.hotel_price,
hotel_discount = NEW.hotel_discount,
discount_amount = NEW.discount_amount,
room_total = NEW.room_total,
room_status = NEW.room_status,
tracking_id=NEW.tracking_id,
action="update"
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `booking_master_detail_track`
--

CREATE TABLE `booking_master_detail_track` (
  `booking_master_detail_track_id` int(11) NOT NULL,
  `booking_master_detail_id` int(11) NOT NULL,
  `booking_no` varchar(30) NOT NULL,
  `room_category` int(11) NOT NULL,
  `hotel_no_of_night` int(11) NOT NULL,
  `hotel_from_date` datetime NOT NULL,
  `hotel_to_date` datetime NOT NULL,
  `room_no` int(11) NOT NULL,
  `hotel_no_of_adults` int(11) NOT NULL,
  `hotel_no_of_childs` int(11) NOT NULL,
  `hotel_no_of_extra_bed` int(11) NOT NULL,
  `hotel_price` float NOT NULL,
  `hotel_discount` int(11) NOT NULL,
  `discount_amount` float NOT NULL,
  `room_total` float NOT NULL,
  `room_status` enum('I','O') NOT NULL COMMENT 'I - Check IN  , O - CHeck out',
  `tracking_id` bigint(25) NOT NULL,
  `action` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_master_detail_track`
--

INSERT INTO `booking_master_detail_track` (`booking_master_detail_track_id`, `booking_master_detail_id`, `booking_no`, `room_category`, `hotel_no_of_night`, `hotel_from_date`, `hotel_to_date`, `room_no`, `hotel_no_of_adults`, `hotel_no_of_childs`, `hotel_no_of_extra_bed`, `hotel_price`, `hotel_discount`, `discount_amount`, `room_total`, `room_status`, `tracking_id`, `action`) VALUES
(1, 1, 'CHK1', 3, 3, '2021-09-23 16:29:00', '2021-09-26 16:30:00', 104, 5, 0, 0, 15000, 5, 750, 47880, 'I', 1563022405, 'insert'),
(2, 2, 'CHK1', 2, 3, '2021-09-23 16:29:00', '2021-09-26 16:30:00', 103, 5, 0, 0, 10000, 5, 500, 31920, 'I', 1563022405, 'insert'),
(3, 3, 'CHK2', 1, 3, '2021-09-23 16:25:00', '2021-09-26 16:26:00', 105, 2, 0, 0, 3000, 5, 150, 9576, 'I', 359447630, 'insert'),
(4, 4, 'CHK2', 4, 3, '2021-09-23 16:26:00', '2021-09-26 16:26:00', 701, 2, 0, 0, 5000, 5, 250, 15960, 'I', 359447630, 'insert'),
(5, 5, 'CHK2', 1, 3, '2021-09-23 16:26:00', '2021-09-26 16:26:00', 101, 4, 0, 0, 3000, 5, 150, 9576, 'I', 359447630, 'insert'),
(6, 6, 'CHK3', 1, 1, '2021-09-23 17:30:00', '2021-09-24 17:30:00', 102, 2, 0, 0, 3000, 0, 0, 3540, 'I', 1038338537, 'insert'),
(7, 3, 'CHK2', 1, 3, '2021-09-23 16:25:00', '2021-09-26 16:26:00', 105, 2, 0, 0, 3000, 5, 150, 9576, 'O', 359447630, 'update'),
(8, 4, 'CHK2', 4, 3, '2021-09-23 16:26:00', '2021-09-26 16:26:00', 701, 2, 0, 0, 5000, 5, 250, 15960, 'O', 359447630, 'update'),
(9, 5, 'CHK2', 1, 3, '2021-09-23 16:26:00', '2021-09-26 16:26:00', 101, 4, 0, 0, 3000, 5, 150, 9576, 'O', 359447630, 'update'),
(10, 5, 'CHK2', 1, 1, '2021-09-23 16:26:00', '2021-09-23 21:11:01', 101, 4, 0, 0, 3000, 5, 150, 3192, 'O', 359447630, 'update'),
(11, 3, 'CHK2', 1, 1, '2021-09-23 16:25:00', '2021-09-23 21:11:01', 105, 2, 0, 0, 3000, 5, 150, 3192, 'O', 359447630, 'update'),
(12, 4, 'CHK2', 4, 1, '2021-09-23 16:26:00', '2021-09-23 21:11:01', 701, 2, 0, 0, 5000, 5, 250, 5320, 'O', 359447630, 'update'),
(13, 7, 'CHK4', 1, 7, '2021-09-23 21:12:00', '2021-09-30 21:12:00', 105, 2, 0, 0, 3000, 5, 150, 23541, 'I', 542915675, 'insert'),
(14, 8, 'CHK4', 4, 1, '2021-09-23 22:20:00', '2021-09-24 22:21:00', 701, 2, 0, 0, 2000, 10, 200, 2124, 'I', 0, 'insert'),
(15, 8, 'CHK4', 4, 1, '2021-09-23 22:20:00', '2021-09-24 22:21:00', 701, 2, 0, 0, 2000, 10, 200, 2124, '', 0, 'update'),
(16, 6, 'CHK3', 1, 1, '2021-09-23 17:30:00', '2021-09-25 17:30:00', 102, 2, 0, 0, 3000, 0, 0, 3540, 'I', 1038338537, 'update');

-- --------------------------------------------------------

--
-- Table structure for table `booking_master_new`
--

CREATE TABLE `booking_master_new` (
  `booking_master_id` int(11) NOT NULL,
  `booking_no` varchar(30) NOT NULL,
  `reservation_no` varchar(30) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_beforetax` float NOT NULL,
  `hotel_charges_for_extra_bed` varchar(20) NOT NULL,
  `tax_cgst_percentage` int(11) NOT NULL,
  `tax_sgst_percentage` int(11) NOT NULL,
  `cgst` float NOT NULL,
  `sgst` float NOT NULL,
  `total_taxamount` float NOT NULL,
  `total_amount` float NOT NULL,
  `total_discount` float NOT NULL,
  `remarks` text NOT NULL,
  `advance` float NOT NULL,
  `travel_agency_id` int(11) NOT NULL,
  `travel_agency_transaction_no` varchar(30) NOT NULL,
  `meal_plan_id` int(11) NOT NULL,
  `meal_price` float NOT NULL,
  `meal_count` int(11) NOT NULL,
  `meal_total` float NOT NULL,
  `booking_documents` text NOT NULL,
  `booking_type` enum('I','G','W') NOT NULL COMMENT 'I- Individula , G - Group ,W- Walkin',
  `booking_status` enum('A','D','P','C','AM') NOT NULL COMMENT 'A- Default, D-Delete, P- Partial, C - Complete , AM - Amend',
  `checkout_payment_mode` int(11) NOT NULL,
  `checkout_payment` float NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tracking_id` bigint(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_master_new`
--

INSERT INTO `booking_master_new` (`booking_master_id`, `booking_no`, `reservation_no`, `customer_id`, `total_beforetax`, `hotel_charges_for_extra_bed`, `tax_cgst_percentage`, `tax_sgst_percentage`, `cgst`, `sgst`, `total_taxamount`, `total_amount`, `total_discount`, `remarks`, `advance`, `travel_agency_id`, `travel_agency_transaction_no`, `meal_plan_id`, `meal_price`, `meal_count`, `meal_total`, `booking_documents`, `booking_type`, `booking_status`, `checkout_payment_mode`, `checkout_payment`, `created_by`, `created_at`, `updated_at`, `tracking_id`) VALUES
(1, 'CHK1', 'RES3', 2, 71250, '', 0, 0, 0, 0, 8550, 79800, 1250, 'Good', 0, 1, '', 1, 10, 10, 100, '', 'I', 'A', 0, 0, 1000488, '2021-09-23 11:13:49', '2021-09-23 11:20:25', 1563022405),
(2, 'CHK2', 'RES2', 1, 31350, '', 0, 0, 0, 0, 3762, 35112, 550, 'Vgood', 20000, 2, '123456789', 0, 0, 0, 0, '1632397322.png', 'I', 'C', 0, 0, 1000488, '2021-09-23 11:26:16', '2021-09-23 15:41:01', 359447630),
(3, 'CHK3', 'RES4', 1, 3000, '', 0, 0, 0, 0, 540, 3540, 0, 'good', 100, 1, '', 0, 0, 0, 0, '', 'I', 'A', 0, 0, 0, '2021-09-23 15:37:27', '2021-09-23 15:37:27', 1038338537),
(4, 'CHK4', 'RES5', 1, 19950, '', 0, 0, 0, 0, 3591, 23541, 150, 'good', 10100, 1, '', 0, 0, 0, 0, '', 'I', 'A', 0, 0, 0, '2021-09-23 15:44:35', '2021-09-23 15:44:35', 542915675);

--
-- Triggers `booking_master_new`
--
DELIMITER $$
CREATE TRIGGER `add_booking_master` AFTER INSERT ON `booking_master_new` FOR EACH ROW INSERT INTO booking_master_new_track
SET booking_master_id = NEW.booking_master_id,
booking_no = NEW.booking_no,
reservation_no = NEW.reservation_no,
customer_id = NEW.customer_id,
total_beforetax = NEW.total_beforetax,
hotel_charges_for_extra_bed = NEW.hotel_charges_for_extra_bed,
tax_cgst_percentage = NEW.tax_cgst_percentage,
tax_sgst_percentage = NEW.tax_sgst_percentage,
total_amount = NEW.total_amount,
total_discount = NEW.total_discount,
travel_agency_id = NEW.travel_agency_id,
travel_agency_transaction_no = NEW.travel_agency_transaction_no,
meal_plan_id = NEW.meal_plan_id,
meal_price = NEW.meal_price,
meal_count = NEW.meal_count,
meal_total = NEW.meal_total,
booking_type = NEW.booking_type,
booking_status = NEW.booking_status,
booking_documents = NEW.booking_documents,
advance = NEW.advance,
remarks = NEW.remarks,
created_by = NEW.created_by,
created_at = NEW.created_at,
updated_at = NEW.updated_at,
tracking_id = NEW.tracking_id,
action="insert"
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_booking_master` AFTER UPDATE ON `booking_master_new` FOR EACH ROW INSERT INTO booking_master_new_track
SET booking_master_id = OLD.booking_master_id,
booking_no = OLD.booking_no,
reservation_no = OLD.reservation_no,
customer_id = OLD.customer_id,
total_beforetax = OLD.total_beforetax,
hotel_charges_for_extra_bed = OLD.hotel_charges_for_extra_bed,
tax_cgst_percentage = OLD.tax_cgst_percentage,
tax_sgst_percentage = OLD.tax_sgst_percentage,
total_amount = OLD.total_amount,
total_discount = OLD.total_discount,
travel_agency_id = OLD.travel_agency_id,
travel_agency_transaction_no = OLD.travel_agency_transaction_no,
meal_plan_id = OLD.meal_plan_id,
meal_price = OLD.meal_price,
meal_count = OLD.meal_count,
meal_total = OLD.meal_total,
booking_type = OLD.booking_type,
booking_status = OLD.booking_status,
booking_documents = OLD.booking_documents,
advance = OLD.advance,
remarks = OLD.remarks,
created_by = OLD.created_by,
created_at = OLD.created_at,
updated_at = OLD.updated_at,
tracking_id = OLD.tracking_id,
action="update"
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `booking_master_new_track`
--

CREATE TABLE `booking_master_new_track` (
  `booking_master_new_track_id` int(11) NOT NULL,
  `booking_master_id` int(11) NOT NULL,
  `booking_no` varchar(30) NOT NULL,
  `reservation_no` varchar(30) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_beforetax` float NOT NULL,
  `hotel_charges_for_extra_bed` varchar(20) NOT NULL,
  `tax_cgst_percentage` int(11) NOT NULL,
  `tax_sgst_percentage` int(11) NOT NULL,
  `cgst` float NOT NULL,
  `sgst` float NOT NULL,
  `total_taxamount` float NOT NULL,
  `total_amount` float NOT NULL,
  `total_discount` float NOT NULL,
  `travel_agency_id` int(11) NOT NULL,
  `travel_agency_transaction_no` varchar(30) NOT NULL,
  `meal_plan_id` int(11) NOT NULL,
  `meal_price` float NOT NULL,
  `meal_count` int(11) NOT NULL,
  `meal_total` float NOT NULL,
  `advance` float NOT NULL,
  `remarks` text NOT NULL,
  `booking_documents` text NOT NULL,
  `booking_type` enum('I','G','W') NOT NULL COMMENT 'I- Individula , G - Group ,W- Walkin',
  `booking_status` enum('A','D','P','C') NOT NULL COMMENT 'A- Default, D-Delete, P- Partial, C - Complete',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tracking_id` bigint(25) NOT NULL,
  `action` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_master_new_track`
--

INSERT INTO `booking_master_new_track` (`booking_master_new_track_id`, `booking_master_id`, `booking_no`, `reservation_no`, `customer_id`, `total_beforetax`, `hotel_charges_for_extra_bed`, `tax_cgst_percentage`, `tax_sgst_percentage`, `cgst`, `sgst`, `total_taxamount`, `total_amount`, `total_discount`, `travel_agency_id`, `travel_agency_transaction_no`, `meal_plan_id`, `meal_price`, `meal_count`, `meal_total`, `advance`, `remarks`, `booking_documents`, `booking_type`, `booking_status`, `created_by`, `created_at`, `updated_at`, `tracking_id`, `action`) VALUES
(1, 1, 'CHK1', 'RES3', 2, 71250, '', 0, 0, 0, 0, 0, 79800, 1250, 1, '', 0, 0, 0, 0, 0, 'Good', '', 'I', 'A', 1000488, '2021-09-23 11:13:49', '2021-09-23 11:13:49', 1563022405, 'insert'),
(2, 1, 'CHK1', 'RES3', 2, 71250, '', 0, 0, 0, 0, 0, 79800, 1250, 1, '', 0, 0, 0, 0, 0, 'Good', '', 'I', 'A', 1000488, '2021-09-23 11:13:49', '2021-09-23 11:13:49', 1563022405, 'update'),
(3, 2, 'CHK2', 'RES2', 1, 31350, '', 0, 0, 0, 0, 0, 35112, 550, 2, '123456789', 0, 0, 0, 0, 20000, 'Vgood', '', 'I', 'A', 1000488, '2021-09-23 11:26:16', '2021-09-23 11:26:16', 359447630, 'insert'),
(4, 2, 'CHK2', 'RES2', 1, 31350, '', 0, 0, 0, 0, 0, 35112, 550, 2, '123456789', 0, 0, 0, 0, 20000, 'Vgood', '', 'I', 'A', 1000488, '2021-09-23 11:26:16', '2021-09-23 11:26:16', 359447630, 'update'),
(5, 3, 'CHK3', 'RES4', 1, 3000, '', 0, 0, 0, 0, 0, 3540, 0, 1, '', 0, 0, 0, 0, 100, 'good', '', 'I', 'A', 0, '2021-09-23 15:37:27', '2021-09-23 15:37:27', 1038338537, 'insert'),
(6, 2, 'CHK2', 'RES2', 1, 31350, '', 0, 0, 0, 0, 0, 35112, 550, 2, '123456789', 0, 0, 0, 0, 20000, 'Vgood', '1632397322.png', 'I', 'A', 1000488, '2021-09-23 11:26:16', '2021-09-23 11:42:06', 359447630, 'update'),
(7, 4, 'CHK4', 'RES5', 1, 19950, '', 0, 0, 0, 0, 0, 23541, 150, 1, '', 0, 0, 0, 0, 10100, 'good', '', 'I', 'A', 0, '2021-09-23 15:44:35', '2021-09-23 15:44:35', 542915675, 'insert');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `city_name` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `country_name` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_ledger`
--

CREATE TABLE `customer_ledger` (
  `customer_ledger_id` int(11) NOT NULL,
  `booking_no` varchar(30) NOT NULL,
  `room_no` varchar(20) NOT NULL,
  `refer_room` varchar(30) NOT NULL,
  `income_type` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `amount` varchar(20) NOT NULL,
  `income_date` date NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `bill_no` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_ledger`
--

INSERT INTO `customer_ledger` (`customer_ledger_id`, `booking_no`, `room_no`, `refer_room`, `income_type`, `description`, `amount`, `income_date`, `payment_type`, `bill_no`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'CHK1', '104', '', 'Booking', '', '15960', '2021-09-23', '', '', 1, '1000488', '2021-09-23 11:13:50', '0000-00-00 00:00:00'),
(2, 'CHK1', '103', '', 'Booking', '', '10640', '2021-09-23', '', '', 1, '1000488', '2021-09-23 11:13:50', '0000-00-00 00:00:00'),
(3, 'CHK2', '105', '', 'Booking', '', '3192', '2021-09-23', '', '', 1, '1000488', '2021-09-23 11:26:21', '0000-00-00 00:00:00'),
(4, 'CHK2', '701', '', 'Booking', '', '5320', '2021-09-23', '', '', 1, '1000488', '2021-09-23 11:26:21', '0000-00-00 00:00:00'),
(5, 'CHK2', '101', '', 'Booking', '', '3192', '2021-09-23', '', '', 1, '1000488', '2021-09-23 11:26:21', '0000-00-00 00:00:00'),
(6, 'CHK2', '105', '', 'Hotel', 'Rer', '3000', '2021-09-23', '1', 'NKT10020', 1, '', '2021-09-23 14:00:36', '0000-00-00 00:00:00'),
(7, 'CHK2', '105', '', 'Miscellaneous', 'Trucking', '580.00', '2021-09-23', '1', '1', 1, '1000488', '2021-09-23 14:00:56', '0000-00-00 00:00:00'),
(8, 'CHK3', '102', '', 'Booking', '', '3540', '2021-09-23', '', '', 1, '', '2021-09-23 15:37:27', '0000-00-00 00:00:00'),
(9, 'CHK3', '102', '', 'Advance', '', '100', '2021-09-23', '1', 'ADV100003', 1, '1000488', '2021-09-23 15:37:27', '0000-00-00 00:00:00'),
(10, 'CHK4', '105', '', 'Booking', '', '3363', '2021-09-23', '', '', 1, '', '2021-09-23 15:44:35', '0000-00-00 00:00:00'),
(11, 'CHK4', '105', '', 'Advance', '', '10000', '2021-09-23', '1', 'ADV100004', 1, '', '2021-09-23 15:43:17', '0000-00-00 00:00:00'),
(12, 'CHK4', '105', '', 'Advance', '', '100', '2021-09-23', '1', 'ADV100005', 1, '', '2021-09-23 15:43:44', '0000-00-00 00:00:00'),
(13, 'CHK4', '701', '', 'Booking', '', '2124', '2021-09-23', '', '', 1, '1000488', '2021-09-23 16:51:05', '0000-00-00 00:00:00'),
(67, 'CHK4', '101', '', '', '', '23541', '2021-09-24', '', '', 1, '1000488', '2021-09-24 08:15:40', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer_master`
--

CREATE TABLE `customer_master` (
  `customer_id` int(11) NOT NULL,
  `customer_title` varchar(50) NOT NULL DEFAULT '0',
  `customer_category` varchar(25) NOT NULL,
  `customer_fname` varchar(100) NOT NULL,
  `customer_lname` varchar(100) NOT NULL,
  `customer_gender` varchar(10) NOT NULL,
  `customer_dob` date NOT NULL,
  `customer_anniversary` date NOT NULL,
  `customer_nationality` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_country` int(11) NOT NULL,
  `customer_state` int(11) NOT NULL,
  `customer_city` int(11) NOT NULL,
  `customer_pincode` varchar(10) NOT NULL,
  `customer_address` varchar(255) NOT NULL DEFAULT '',
  `customer_doc` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_master`
--

INSERT INTO `customer_master` (`customer_id`, `customer_title`, `customer_category`, `customer_fname`, `customer_lname`, `customer_gender`, `customer_dob`, `customer_anniversary`, `customer_nationality`, `customer_phone`, `customer_country`, `customer_state`, `customer_city`, `customer_pincode`, `customer_address`, `customer_doc`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Mr.', '', 'Vijay', 'PS', 'Male', '0000-00-00', '0000-00-00', 'Indian', '9500445881', 101, 35, 4183, '636008', 'Salem', '1632394483.PNG', 1, 1000488, '2021-09-23 10:55:23', '2021-09-23 10:55:23'),
(2, 'Mr.', '', 'Customer', 'F', 'Male', '0000-00-00', '0000-00-00', 'Indian', '9999999999', 217, 3528, 39825, '112255', 'Pattaya', '1632394854.PNG', 1, 1000488, '2021-09-23 11:01:31', '2021-09-23 11:01:31');

-- --------------------------------------------------------

--
-- Table structure for table `employee_master`
--

CREATE TABLE `employee_master` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `employee_dob` date NOT NULL,
  `employee_address` text NOT NULL,
  `employee_phone` varchar(20) NOT NULL,
  `employee_email` varchar(100) NOT NULL,
  `employee_type_id` int(11) NOT NULL,
  `customer_doc` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_master`
--

INSERT INTO `employee_master` (`employee_id`, `employee_name`, `employee_dob`, `employee_address`, `employee_phone`, `employee_email`, `employee_type_id`, `customer_doc`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(10002, 'asdasd', '2020-11-30', 'asdasdad', '2', 'asdasd', 2, '1608297760.jpg', 1, 1000488, '2020-12-18 16:31:06', '2020-12-18 16:31:06'),
(10003, 'Gandhi', '1990-09-29', 'Erode', '987654356', 'gandhi@gmail.com', 2, '1608309936.jpg', 1, 1000488, '2020-12-18 16:45:41', '2020-12-18 16:45:41'),
(10004, 'employee', '1991-02-01', 'yercaud', '9999999999', 'karthick', 1, '', 1, 1, '2021-09-03 05:49:02', '2021-09-03 05:49:02'),
(10005, 'wdasd', '2021-09-07', '158 bhavathootam\r\nR N pudur post,near platinum mahal', '23423', 'fsdf@sdds.dfg', 2, '', 1, 1, '2021-09-06 16:41:23', '2021-09-06 16:41:23'),
(1000488, 'vijay', '2020-10-22', 'salem', '9500445881', 'vj@gmail.com', 1, '', 1, 0, '2020-11-07 12:54:40', '2020-11-22 22:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `employee_type`
--

CREATE TABLE `employee_type` (
  `employee_type_id` int(11) NOT NULL,
  `employee_type` varchar(25) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_type`
--

INSERT INTO `employee_type` (`employee_type_id`, `employee_type`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, 1, '2020-11-22 22:26:38', '0000-00-00 00:00:00'),
(2, 'Frontoffice', 1, 1, '2020-11-22 22:26:38', '2020-12-16 17:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `expenses_master`
--

CREATE TABLE `expenses_master` (
  `expenses_id` int(11) NOT NULL,
  `expenses_date` date NOT NULL,
  `expenses_type` int(11) NOT NULL,
  `expenses_payment_type` int(11) NOT NULL,
  `expenses_amount` float NOT NULL,
  `expenses_description` varchar(255) NOT NULL DEFAULT '',
  `expenses_remarks` varchar(255) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses_master`
--

INSERT INTO `expenses_master` (`expenses_id`, `expenses_date`, `expenses_type`, `expenses_payment_type`, `expenses_amount`, `expenses_description`, `expenses_remarks`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2021-09-23', 2, 3, 100, 'Water', 'Water 1', 1, 1000488, '2021-09-23 12:53:36', '2021-09-23 12:53:36');

-- --------------------------------------------------------

--
-- Table structure for table `expenses_type`
--

CREATE TABLE `expenses_type` (
  `expenses_type_id` int(11) NOT NULL,
  `expenses_type` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses_type`
--

INSERT INTO `expenses_type` (`expenses_type_id`, `expenses_type`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'cctv', 1, 1000488, '2021-04-11 17:32:20', '2021-04-11 17:32:20'),
(2, 'Water', 1, 1, '2021-08-17 04:40:14', '2021-08-17 04:40:14');

-- --------------------------------------------------------

--
-- Table structure for table `floor_master`
--

CREATE TABLE `floor_master` (
  `floor_master_id` int(11) NOT NULL,
  `floor_name` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `floor_master`
--

INSERT INTO `floor_master` (`floor_master_id`, `floor_name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Ground Floor', 1, 1000488, '2020-12-12 18:34:42', '2020-12-12 18:34:42'),
(2, '', 1, 1000488, '2020-12-12 18:35:06', '2020-12-12 18:35:06'),
(3, 'First Floor', 1, 1000488, '2020-12-12 18:35:36', '2020-12-12 18:35:36'),
(4, 'Tree Floor', 1, 1, '2021-09-03 05:58:11', '2021-09-03 05:58:11'),
(5, 'fourth floor', 1, 1, '2021-09-12 08:13:03', '2021-09-12 08:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_master`
--

CREATE TABLE `invoice_master` (
  `invoice_master_id` int(11) NOT NULL,
  `invoice_category` enum('A','B') NOT NULL,
  `invoice_no` varchar(30) NOT NULL,
  `process_no` varchar(30) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_received` varchar(30) NOT NULL,
  `total_amount` varchar(30) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_master`
--

INSERT INTO `invoice_master` (`invoice_master_id`, `invoice_category`, `invoice_no`, `process_no`, `customer_id`, `total_received`, `total_amount`, `payment_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'B', 'INV100001', 'CHK2', 1, '500', '11704', 1, 1, '2021-09-23 15:41:01', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `login_master`
--

CREATE TABLE `login_master` (
  `login_master_id` int(11) NOT NULL,
  `login_name` varchar(25) NOT NULL,
  `login_password` varchar(255) NOT NULL,
  `login_key` varchar(255) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `login_status` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_master`
--

INSERT INTO `login_master` (`login_master_id`, `login_name`, `login_password`, `login_key`, `employee_id`, `login_status`, `status`) VALUES
(1, 'admin', 'admin', 'abcd', 1000488, 1, 1),
(3, 'frontoffice', 'AGMUjg%*pQ7-8QTs', '', 10003, 0, 1),
(4, 'karthik', '123', '', 10004, 0, 1),
(5, 'admin', 'admin', '', 10005, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `meal_plan`
--

CREATE TABLE `meal_plan` (
  `meal_plan_id` int(11) NOT NULL,
  `meal_plan_short` varchar(5) NOT NULL,
  `meal_plan_full` varchar(50) NOT NULL,
  `meal_price` float NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meal_plan`
--

INSERT INTO `meal_plan` (`meal_plan_id`, `meal_plan_short`, `meal_plan_full`, `meal_price`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'BL', 'Breakfast Lunch', 50, 1, 1000488, '2020-12-12 18:45:47', '0000-00-00 00:00:00'),
(2, 'OL', 'Lunch', 150, 1, 1000488, '2020-12-15 18:26:16', '0000-00-00 00:00:00'),
(3, 's', 'sample', 100, 1, 1000488, '2021-04-11 17:33:30', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `miscellaneous_expenses`
--

CREATE TABLE `miscellaneous_expenses` (
  `miscellaneous_expenses_id` int(11) NOT NULL,
  `miscellaneous_expenses` varchar(50) NOT NULL,
  `miscellaneous_amount` varchar(50) NOT NULL,
  `miscellaneous_cgst` varchar(10) NOT NULL,
  `miscellaneous_sgst` varchar(10) NOT NULL,
  `miscellaneous_total` varchar(20) NOT NULL,
  `miscellaneous_payment_type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `miscellaneous_expenses`
--

INSERT INTO `miscellaneous_expenses` (`miscellaneous_expenses_id`, `miscellaneous_expenses`, `miscellaneous_amount`, `miscellaneous_cgst`, `miscellaneous_sgst`, `miscellaneous_total`, `miscellaneous_payment_type`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Trucking', '500', '8', '8', '580.00', 1, 1, '1000488', '2021-09-23 14:00:56', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `night_audit_master`
--

CREATE TABLE `night_audit_master` (
  `night_audit_master_id` int(11) NOT NULL,
  `night_audit_date` date NOT NULL,
  `night_audit_status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `night_audit_master`
--

INSERT INTO `night_audit_master` (`night_audit_master_id`, `night_audit_date`, `night_audit_status`, `created_at`, `created_by`) VALUES
(1, '2021-09-23', 0, '2021-09-02 14:33:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment_master`
--

CREATE TABLE `payment_master` (
  `payment_master_id` int(11) NOT NULL,
  `payment_mode` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_master`
--

INSERT INTO `payment_master` (`payment_master_id`, `payment_mode`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Debit Card', 1, 1000488, '2020-12-12 18:46:09', '2021-09-03 05:55:10'),
(2, 'PayTM', 1, 1000488, '2020-12-12 18:46:11', '2020-12-12 18:46:11'),
(3, 'Cash', 1, 1000488, '2021-04-11 13:51:56', '2021-04-11 13:51:56'),
(4, 'Gpay', 1, 1, '2021-09-03 05:54:18', '2021-09-03 05:54:18'),
(5, 'Phonepe', 1, 1, '2021-09-06 16:56:12', '2021-09-06 16:56:12');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_master`
--

CREATE TABLE `reservation_master` (
  `reservation_id` int(11) NOT NULL,
  `reservation_no` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `room_type` text NOT NULL,
  `no_of_nights` text NOT NULL,
  `from_date` text NOT NULL,
  `to_date` text NOT NULL,
  `no_of_rooms` text NOT NULL,
  `adults` text NOT NULL,
  `infant` text NOT NULL,
  `no_extra_bed` text NOT NULL,
  `price` text NOT NULL,
  `discount_percentage` text NOT NULL,
  `discount_amount` text NOT NULL,
  `room_total` text NOT NULL,
  `total_Beforetax` float NOT NULL,
  `Tax_percetage` int(11) NOT NULL,
  `total_TaxAmount` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `total_discount` float NOT NULL,
  `booking_type` enum('I','G','A') NOT NULL,
  `booking_status` enum('A','D','B','R') NOT NULL COMMENT 'A-Amend\r\n',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_master_detail`
--

CREATE TABLE `reservation_master_detail` (
  `reservation_master_detail_id` int(11) NOT NULL,
  `reservation_no` varchar(30) NOT NULL,
  `room_category` int(11) NOT NULL,
  `hotel_no_of_night` int(11) NOT NULL,
  `hotel_from_date` datetime NOT NULL,
  `hotel_to_date` datetime NOT NULL,
  `hotel_no_of_rooms` int(11) NOT NULL,
  `hotel_no_of_adults` int(11) NOT NULL,
  `hotel_no_of_childs` int(11) NOT NULL,
  `hotel_no_of_extra_bed` int(11) NOT NULL,
  `hotel_price` float NOT NULL,
  `room_cgst` varchar(10) NOT NULL,
  `room_sgst` varchar(10) NOT NULL,
  `hotel_discount` int(11) NOT NULL,
  `discount_amount` float NOT NULL,
  `room_total` float NOT NULL,
  `tracking_id` bigint(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation_master_detail`
--

INSERT INTO `reservation_master_detail` (`reservation_master_detail_id`, `reservation_no`, `room_category`, `hotel_no_of_night`, `hotel_from_date`, `hotel_to_date`, `hotel_no_of_rooms`, `hotel_no_of_adults`, `hotel_no_of_childs`, `hotel_no_of_extra_bed`, `hotel_price`, `room_cgst`, `room_sgst`, `hotel_discount`, `discount_amount`, `room_total`, `tracking_id`) VALUES
(2, 'RES2', 1, 2, '2021-09-24 16:25:00', '2021-09-26 16:26:00', 1, 2, 0, 0, 3000, '6', '6', 5, 300, 6048, 554585206),
(3, 'RES2', 3, 2, '2021-09-24 16:26:00', '2021-09-26 16:26:00', 1, 2, 0, 0, 15000, '6', '6', 5, 1500, 30240, 554585206),
(4, 'RES2', 4, 2, '2021-09-24 16:26:00', '2021-09-26 16:26:00', 1, 4, 0, 0, 5000, '6', '6', 5, 500, 10080, 554585206),
(5, 'RES3', 3, 3, '2021-09-23 16:29:00', '2021-09-26 16:30:00', 2, 5, 0, 0, 15000, '6', '6', 5, 4500, 85680, 1686418730),
(6, 'RES1', 1, 2, '2021-09-24 16:23:00', '2021-09-26 16:24:00', 2, 2, 0, 0, 3000, '6', '6', 5, 600, 12096, 1507597773),
(7, 'RES4', 1, 1, '2021-09-23 17:30:00', '2021-09-24 17:30:00', 1, 2, 0, 0, 3000, '9', '9', 0, 0, 3540, 1722619882),
(8, 'RES4', 2, 1, '2021-09-23 17:30:00', '2021-09-24 17:30:00', 1, 2, 0, 0, 10000, '9', '9', 0, 0, 11800, 1722619882),
(9, 'RES5', 1, 7, '2021-09-23 21:12:00', '2021-09-30 21:12:00', 1, 2, 0, 0, 3000, '9', '9', 5, 1050, 16107, 1225389463);

--
-- Triggers `reservation_master_detail`
--
DELIMITER $$
CREATE TRIGGER `add_reservation_master_details` AFTER INSERT ON `reservation_master_detail` FOR EACH ROW INSERT INTO reservation_master_detail_track
SET  `reservation_master_detail_id` = NEW.reservation_master_detail_id,
`reservation_no` = NEW.reservation_no,
 `room_category`= NEW.room_category,
`hotel_no_of_night` = NEW.hotel_no_of_night,
 `hotel_from_date` = NEW.hotel_from_date,
   `hotel_to_date`= NEW.hotel_to_date,
   `hotel_no_of_rooms` = NEW.hotel_no_of_rooms,
    `hotel_no_of_adults` = NEW.hotel_no_of_adults,
    `hotel_no_of_childs`= NEW.hotel_no_of_childs,
   `hotel_no_of_extra_bed` = NEW.hotel_no_of_extra_bed,
   `hotel_price` = NEW.hotel_price,
   `hotel_discount` = NEW.hotel_discount,
   `discount_amount` = NEW.discount_amount,
   `room_total` = NEW.room_total,
   `tracking_id` = NEW.tracking_id,
	`action`="insert"
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_reservation_master_details` AFTER UPDATE ON `reservation_master_detail` FOR EACH ROW INSERT INTO reservation_master_detail_track
SET  `reservation_master_detail_id` = OLD.reservation_master_detail_id,
`reservation_no` = OLD.reservation_no,
 `room_category`= OLD.room_category,
`hotel_no_of_night` = OLD.hotel_no_of_night,
 `hotel_from_date` = OLD.hotel_from_date,
   `hotel_to_date`= OLD.hotel_to_date,
   `hotel_no_of_rooms` = OLD.hotel_no_of_rooms,
    `hotel_no_of_adults` = OLD.hotel_no_of_adults,
    `hotel_no_of_childs`= OLD.hotel_no_of_childs,
   `hotel_no_of_extra_bed` = OLD.hotel_no_of_extra_bed,
   `hotel_price` = OLD.hotel_price,
   `hotel_discount` = OLD.hotel_discount,
   `discount_amount` = OLD.discount_amount,
   `room_total` = OLD.room_total,
   `tracking_id` = OLD.tracking_id,
	`action`="update"
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_master_detail_track`
--

CREATE TABLE `reservation_master_detail_track` (
  `reservation_master_detail_track_id` int(11) NOT NULL,
  `reservation_master_detail_id` int(11) NOT NULL,
  `reservation_no` varchar(30) NOT NULL,
  `room_category` int(11) NOT NULL,
  `hotel_no_of_night` int(11) NOT NULL,
  `hotel_from_date` datetime NOT NULL,
  `hotel_to_date` datetime NOT NULL,
  `hotel_no_of_rooms` int(11) NOT NULL,
  `hotel_no_of_adults` int(11) NOT NULL,
  `hotel_no_of_childs` int(11) NOT NULL,
  `hotel_no_of_extra_bed` int(11) NOT NULL,
  `hotel_price` float NOT NULL,
  `hotel_discount` int(11) NOT NULL,
  `discount_amount` float NOT NULL,
  `room_total` float NOT NULL,
  `action` varchar(10) NOT NULL,
  `tracking_id` bigint(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation_master_detail_track`
--

INSERT INTO `reservation_master_detail_track` (`reservation_master_detail_track_id`, `reservation_master_detail_id`, `reservation_no`, `room_category`, `hotel_no_of_night`, `hotel_from_date`, `hotel_to_date`, `hotel_no_of_rooms`, `hotel_no_of_adults`, `hotel_no_of_childs`, `hotel_no_of_extra_bed`, `hotel_price`, `hotel_discount`, `discount_amount`, `room_total`, `action`, `tracking_id`) VALUES
(1, 1, 'RES1', 1, 3, '2021-09-23 16:23:00', '2021-09-26 16:24:00', 2, 2, 0, 0, 3000, 5, 900, 17136, 'insert', 957753373),
(2, 2, 'RES2', 1, 2, '2021-09-24 16:25:00', '2021-09-26 16:26:00', 1, 2, 0, 0, 3000, 5, 300, 6048, 'insert', 554585206),
(3, 3, 'RES2', 3, 2, '2021-09-24 16:26:00', '2021-09-26 16:26:00', 1, 2, 0, 0, 15000, 5, 1500, 30240, 'insert', 554585206),
(4, 4, 'RES2', 4, 2, '2021-09-24 16:26:00', '2021-09-26 16:26:00', 1, 4, 0, 0, 5000, 5, 500, 10080, 'insert', 554585206),
(5, 5, 'RES3', 3, 3, '2021-09-23 16:29:00', '2021-09-26 16:30:00', 2, 5, 0, 0, 15000, 5, 4500, 85680, 'insert', 1686418730),
(6, 6, 'RES1', 1, 2, '2021-09-24 16:23:00', '2021-09-26 16:24:00', 2, 2, 0, 0, 3000, 5, 600, 12096, 'insert', 1507597773),
(7, 7, 'RES4', 1, 1, '2021-09-23 17:30:00', '2021-09-24 17:30:00', 1, 2, 0, 0, 3000, 0, 0, 3540, 'insert', 1722619882),
(8, 8, 'RES4', 2, 1, '2021-09-23 17:30:00', '2021-09-24 17:30:00', 1, 2, 0, 0, 10000, 0, 0, 11800, 'insert', 1722619882),
(9, 9, 'RES5', 1, 7, '2021-09-23 21:12:00', '2021-09-30 21:12:00', 1, 2, 0, 0, 3000, 5, 1050, 16107, 'insert', 1225389463);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_master_new`
--

CREATE TABLE `reservation_master_new` (
  `reservation_master_id` int(11) NOT NULL,
  `reservation_no` varchar(30) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_beforetax` float NOT NULL,
  `tax_cgst_percentage` int(11) NOT NULL,
  `tax_sgst_percentage` int(11) NOT NULL,
  `cgst` float NOT NULL,
  `sgst` float NOT NULL,
  `total_taxamount` float NOT NULL,
  `total_amount` float NOT NULL,
  `total_discount` float NOT NULL,
  `travel_agency_id` int(11) NOT NULL,
  `travel_agency_transaction_no` varchar(30) NOT NULL,
  `meal_plan_id` int(11) NOT NULL,
  `meal_price` float NOT NULL,
  `meal_count` int(11) NOT NULL,
  `meal_total` float NOT NULL,
  `reservation_type` enum('I','G','') NOT NULL COMMENT 'I- Individula , G - Group',
  `reservation_status` enum('A','D','B','N','AM') NOT NULL COMMENT 'A- Default, D-Delete, B- Booking, N- NoShow',
  `booking_no` varchar(25) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remarks` text NOT NULL,
  `advance` float NOT NULL,
  `tracking_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation_master_new`
--

INSERT INTO `reservation_master_new` (`reservation_master_id`, `reservation_no`, `customer_id`, `total_beforetax`, `tax_cgst_percentage`, `tax_sgst_percentage`, `cgst`, `sgst`, `total_taxamount`, `total_amount`, `total_discount`, `travel_agency_id`, `travel_agency_transaction_no`, `meal_plan_id`, `meal_price`, `meal_count`, `meal_total`, `reservation_type`, `reservation_status`, `booking_no`, `created_by`, `created_at`, `updated_at`, `remarks`, `advance`, `tracking_id`) VALUES
(1, 'RES1', 1, 10800, 0, 0, 0, 0, 1296, 12096, 600, 1, '', 0, 0, 0, 0, 'I', 'N', '', 0, '2021-09-23 10:55:29', '2021-09-23 18:44:58', 'Good', 10000, 1507597773),
(2, 'RES2', 1, 41400, 0, 0, 0, 0, 4968, 46368, 2300, 2, '123456789', 0, 0, 0, 0, 'G', 'B', 'CHK2', 1000488, '2021-09-23 10:58:50', '2021-09-23 11:26:21', 'Good', 20000, 554585206),
(3, 'RES3', 2, 76500, 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 'I', 'N', 'CHK1', 0, '2021-09-23 11:01:31', '2021-09-23 12:51:16', 'good', 0, 1686418730),
(4, 'RES4', 1, 13000, 0, 0, 0, 0, 2340, 15340, 0, 1, '', 0, 0, 0, 0, 'I', 'B', 'CHK3', 1000488, '2021-09-23 12:01:14', '2021-09-23 15:37:27', 'good', 100, 1722619882),
(5, 'RES5', 1, 13650, 0, 0, 0, 0, 2457, 16107, 1050, 1, '', 0, 0, 0, 0, 'I', 'B', 'CHK4', 0, '2021-09-23 15:43:17', '2021-09-23 15:44:35', 'good', 10100, 1225389463);

--
-- Triggers `reservation_master_new`
--
DELIMITER $$
CREATE TRIGGER `insert_reservation_master` AFTER INSERT ON `reservation_master_new` FOR EACH ROW INSERT INTO reservation_master_new_track
SET  `reservation_master_id` = NEW.reservation_master_id,
`reservation_no` = NEW.reservation_no,
 `customer_id`= NEW.customer_id,
`total_beforetax` = NEW.total_beforetax,
   `tax_cgst_percentage`= NEW.tax_cgst_percentage,
   `tax_sgst_percentage` = NEW.tax_sgst_percentage,
   `sgst` = NEW.sgst,
   `cgst` = NEW.cgst,
   `total_taxamount` = NEW.total_taxamount,
    `total_amount` = NEW.total_amount,
    `total_discount`= NEW.total_discount,
    `travel_agency_id` = NEW.travel_agency_id,
    `travel_agency_transaction_no` = NEW.travel_agency_transaction_no,
    `meal_plan_id` = NEW.meal_plan_id,
    `meal_price` = NEW.meal_price,
    `meal_count` = NEW.meal_count,
    `meal_total` = NEW.meal_total,
   `reservation_type` = NEW.reservation_type,
   `reservation_status` = NEW.reservation_status,
   `booking_no` = NEW.booking_no,
   `advance` = NEW.advance,
   `remarks` = NEW.remarks,
   `created_by` = NEW.created_by,
   `created_at` = NEW.created_at,
   `updated_at` = NEW.updated_at,
   `tracking_id` = NEW.tracking_id,
   `action`="insert"
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_reservation_master` AFTER UPDATE ON `reservation_master_new` FOR EACH ROW INSERT INTO reservation_master_new_track
SET  `reservation_master_id` = OLD.reservation_master_id,
`reservation_no` = OLD.reservation_no,
 `customer_id`= OLD.customer_id,
`total_beforetax` = OLD.total_beforetax,
   `tax_cgst_percentage`= OLD.tax_cgst_percentage,
   `tax_sgst_percentage` = OLD.tax_sgst_percentage,
   `sgst` = OLD.sgst,
   `cgst` = OLD.cgst,
   `total_taxamount` = OLD.total_taxamount,
    `total_amount` = OLD.total_amount,
    `total_discount`= OLD.total_discount,
    `travel_agency_id`=OLD.travel_agency_id,
    `travel_agency_transaction_no`=OLD.travel_agency_transaction_no,
    `meal_plan_id` = OLD.meal_plan_id,
    `meal_price` = OLD.meal_price,
    `meal_count` = OLD.meal_count,
    `meal_total` = OLD.meal_total,
   `reservation_type` = OLD.reservation_type,
   `reservation_status` = OLD.reservation_status,
   `booking_no` = OLD.booking_no,
   `advance` = OLD.advance,
   `remarks` = OLD.remarks,
   `created_by` = OLD.created_by,
   `created_at` = OLD.created_at,
   `updated_at` = OLD.updated_at,
   `tracking_id` = OLD.tracking_id,
   `action`="update"
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_master_new_track`
--

CREATE TABLE `reservation_master_new_track` (
  `reservation_master_new_track` int(11) NOT NULL,
  `reservation_master_id` int(11) NOT NULL,
  `reservation_no` varchar(30) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_beforetax` float NOT NULL,
  `hotel_charges_for_extra_bed` varchar(20) NOT NULL,
  `tax_cgst_percentage` int(11) NOT NULL,
  `tax_sgst_percentage` int(11) NOT NULL,
  `sgst` float NOT NULL,
  `cgst` float NOT NULL,
  `total_taxamount` float NOT NULL,
  `total_amount` float NOT NULL,
  `total_discount` float NOT NULL,
  `travel_agency_id` int(11) NOT NULL,
  `travel_agency_transaction_no` varchar(30) NOT NULL,
  `meal_plan_id` int(11) NOT NULL,
  `meal_price` float NOT NULL,
  `meal_count` int(11) NOT NULL,
  `meal_total` float NOT NULL,
  `advance` float NOT NULL,
  `remarks` text NOT NULL,
  `reservation_type` enum('I','G','') NOT NULL COMMENT 'I- Individula , G - Group',
  `reservation_status` enum('A','D','B','') NOT NULL COMMENT 'A- Default, D-Delete, B- Booking',
  `booking_no` varchar(25) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `action` varchar(10) NOT NULL,
  `tracking_id` bigint(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation_master_new_track`
--

INSERT INTO `reservation_master_new_track` (`reservation_master_new_track`, `reservation_master_id`, `reservation_no`, `customer_id`, `total_beforetax`, `hotel_charges_for_extra_bed`, `tax_cgst_percentage`, `tax_sgst_percentage`, `sgst`, `cgst`, `total_taxamount`, `total_amount`, `total_discount`, `travel_agency_id`, `travel_agency_transaction_no`, `meal_plan_id`, `meal_price`, `meal_count`, `meal_total`, `advance`, `remarks`, `reservation_type`, `reservation_status`, `booking_no`, `created_by`, `created_at`, `updated_at`, `action`, `tracking_id`) VALUES
(1, 1, 'RES1', 1, 15300, '', 0, 0, 0, 0, 1836, 17136, 900, 1, '', 0, 0, 0, 0, 10000, 'Good', 'I', 'A', '', 0, '2021-09-23 10:55:29', '2021-09-23 10:55:29', 'insert', 957753373),
(2, 2, 'RES2', 1, 41400, '', 0, 0, 0, 0, 4968, 46368, 2300, 2, '123456789', 0, 0, 0, 0, 20000, 'Good', 'G', 'A', '', 1000488, '2021-09-23 10:58:50', '2021-09-23 10:58:50', 'insert', 554585206),
(3, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'A', '', 0, '2021-09-23 11:01:31', '2021-09-23 11:01:31', 'insert', 1686418730),
(4, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'A', '', 0, '2021-09-23 11:01:31', '2021-09-23 11:01:31', 'update', 1686418730),
(5, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'B', '', 0, '2021-09-23 11:01:31', '2021-09-23 11:03:19', 'update', 1686418730),
(6, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'B', '', 0, '2021-09-23 11:01:31', '2021-09-23 11:03:19', 'update', 1686418730),
(7, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'A', '', 0, '2021-09-23 11:01:31', '2021-09-23 11:09:17', 'update', 1686418730),
(8, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'B', '', 0, '2021-09-23 11:01:31', '2021-09-23 11:11:47', 'update', 1686418730),
(9, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'B', '', 0, '2021-09-23 11:01:31', '2021-09-23 11:11:47', 'update', 1686418730),
(10, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'A', '', 0, '2021-09-23 11:01:31', '2021-09-23 11:13:08', 'update', 1686418730),
(11, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'B', 'CHK1', 0, '2021-09-23 11:01:31', '2021-09-23 11:13:50', 'update', 1686418730),
(12, 2, 'RES2', 1, 41400, '', 0, 0, 0, 0, 4968, 46368, 2300, 2, '123456789', 0, 0, 0, 0, 20000, 'Good', 'G', 'A', '', 1000488, '2021-09-23 10:58:50', '2021-09-23 10:58:50', 'update', 554585206),
(13, 2, 'RES2', 1, 41400, '', 0, 0, 0, 0, 4968, 46368, 2300, 2, '123456789', 0, 0, 0, 0, 20000, 'Good', 'G', 'B', 'CHK2', 1000488, '2021-09-23 10:58:50', '2021-09-23 11:26:21', 'update', 554585206),
(14, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'B', 'CHK1', 0, '2021-09-23 11:01:31', '2021-09-23 11:13:50', 'update', 1686418730),
(15, 1, 'RES1', 1, 15300, '', 0, 0, 0, 0, 1836, 17136, 900, 1, '', 0, 0, 0, 0, 10000, 'Good', 'I', 'A', '', 0, '2021-09-23 10:55:29', '2021-09-23 10:55:29', 'update', 957753373),
(16, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', '', 'CHK1', 0, '2021-09-23 11:01:31', '2021-09-23 11:32:28', 'update', 1686418730),
(17, 4, 'RES4', 1, 13000, '', 0, 0, 0, 0, 2340, 15340, 0, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'A', '', 1000488, '2021-09-23 12:01:14', '2021-09-23 12:01:14', 'insert', 1722619882),
(18, 3, 'RES3', 2, 76500, '', 0, 0, 0, 0, 9180, 85680, 4500, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'A', 'CHK1', 0, '2021-09-23 11:01:31', '2021-09-23 11:53:37', 'update', 1686418730),
(19, 4, 'RES4', 1, 13000, '', 0, 0, 0, 0, 2340, 15340, 0, 1, '', 0, 0, 0, 0, 0, 'good', 'I', 'A', '', 1000488, '2021-09-23 12:01:14', '2021-09-23 12:01:14', 'update', 1722619882),
(20, 4, 'RES4', 1, 13000, '', 0, 0, 0, 0, 2340, 15340, 0, 1, '', 0, 0, 0, 0, 100, 'good', 'I', 'A', '', 1000488, '2021-09-23 12:01:14', '2021-09-23 15:34:05', 'update', 1722619882),
(21, 4, 'RES4', 1, 13000, '', 0, 0, 0, 0, 2340, 15340, 0, 1, '', 0, 0, 0, 0, 100, 'good', 'I', 'B', 'CHK3', 1000488, '2021-09-23 12:01:14', '2021-09-23 15:37:27', 'update', 1722619882),
(22, 5, 'RES5', 1, 13650, '', 0, 0, 0, 0, 2457, 16107, 1050, 1, '', 0, 0, 0, 0, 10000, 'good', 'I', 'A', '', 0, '2021-09-23 15:43:17', '2021-09-23 15:43:17', 'insert', 1225389463),
(23, 5, 'RES5', 1, 13650, '', 0, 0, 0, 0, 2457, 16107, 1050, 1, '', 0, 0, 0, 0, 10000, 'good', 'I', 'A', '', 0, '2021-09-23 15:43:17', '2021-09-23 15:43:17', 'update', 1225389463),
(24, 5, 'RES5', 1, 13650, '', 0, 0, 0, 0, 2457, 16107, 1050, 1, '', 0, 0, 0, 0, 10100, 'good', 'I', 'A', '', 0, '2021-09-23 15:43:17', '2021-09-23 15:43:41', 'update', 1225389463),
(25, 5, 'RES5', 1, 13650, '', 0, 0, 0, 0, 2457, 16107, 1050, 1, '', 0, 0, 0, 0, 10100, 'good', 'I', 'B', 'CHK4', 0, '2021-09-23 15:43:17', '2021-09-23 15:44:35', 'update', 1225389463),
(26, 1, 'RES1', 1, 10800, '', 0, 0, 0, 0, 1296, 12096, 600, 1, '', 0, 0, 0, 0, 10000, 'Good', 'I', '', '', 0, '2021-09-23 10:55:29', '2021-09-23 11:44:53', 'update', 1507597773);

-- --------------------------------------------------------

--
-- Table structure for table `room_category`
--

CREATE TABLE `room_category` (
  `room_category_id` int(11) NOT NULL,
  `room_beds` smallint(6) NOT NULL,
  `room_price` float NOT NULL,
  `room_extra_bed_price` float NOT NULL,
  `room_category` varchar(50) NOT NULL,
  `room_size` varchar(20) NOT NULL,
  `room_capacity_adults` int(11) NOT NULL,
  `room_capacity_infant` int(11) NOT NULL,
  `room_facilities` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` enum('A','D') NOT NULL COMMENT 'A-Approve,D-Delete',
  `current_status` enum('A','IH','D','OS','OD','R') NOT NULL COMMENT 'A-Available,IH-In House,D-Dirty,OS-Out of service,,OD-Out of order,R-Reserved.',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_category`
--

INSERT INTO `room_category` (`room_category_id`, `room_beds`, `room_price`, `room_extra_bed_price`, `room_category`, `room_size`, `room_capacity_adults`, `room_capacity_infant`, `room_facilities`, `created_by`, `status`, `current_status`, `updated_at`, `created_at`) VALUES
(1, 2, 3000, 500, 'Luxury', '1500Sqft', 2, 3, '', 1000488, 'A', 'A', '2020-12-12 18:34:13', '2020-12-12 18:31:53'),
(2, 2, 10000, 2000, 'Luxury Delux', '2500Sqft', 2, 2, '', 1000488, 'A', 'A', '2020-12-13 06:15:54', '2020-12-13 06:15:44'),
(3, 4, 15000, 5000, 'Villa', '5000Sqft', 4, 4, '', 1000488, 'A', 'A', '2020-12-13 06:22:45', '2020-12-13 06:22:45'),
(4, 1, 5000, 500, 'Tree House', '300*200', 2, 1, '', 1, 'A', 'A', '2021-09-03 05:57:03', '2021-09-03 05:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `room_facilites_master`
--

CREATE TABLE `room_facilites_master` (
  `room_facilites_master_id` int(11) NOT NULL,
  `room_facilites` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `room_master`
--

CREATE TABLE `room_master` (
  `room_master_id` int(11) NOT NULL,
  `room_category_id` int(11) NOT NULL,
  `room_floor_id` int(11) NOT NULL,
  `room_no` int(11) NOT NULL,
  `room_name` varchar(155) NOT NULL,
  `status` enum('A','D') NOT NULL COMMENT 'A-Approve,D-Delete',
  `current_status` enum('A','IH','D','OS','OD','R') NOT NULL COMMENT 'A-Available,IH-In House,D-Dirty,OS-Out of service,,OD-Out of order,R-Reserved.',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_master`
--

INSERT INTO `room_master` (`room_master_id`, `room_category_id`, `room_floor_id`, `room_no`, `room_name`, `status`, `current_status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 105, 'Rose', 'A', 'IH', 1000488, '2020-12-12 18:35:44', '2021-09-23 15:44:35'),
(2, 1, 1, 101, 'Rose', 'A', 'IH', 1000488, '2020-12-13 06:23:51', '2021-09-24 08:15:41'),
(3, 1, 3, 102, 'Rose 2', 'A', 'IH', 1000488, '2020-12-13 06:24:04', '2021-09-23 15:37:27'),
(4, 2, 1, 103, 'Rose 3', 'A', 'IH', 1000488, '2020-12-13 06:24:26', '2021-09-23 11:13:50'),
(5, 3, 1, 104, 'Rose 4', 'A', 'IH', 1000488, '2020-12-13 06:24:43', '2021-09-23 11:13:50'),
(6, 4, 4, 701, 'Tree Top', 'A', 'A', 1000488, '2021-09-03 05:58:17', '2021-09-23 16:51:30');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `state_id` int(11) NOT NULL,
  `state_name` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `travel_agency`
--

CREATE TABLE `travel_agency` (
  `travel_agency_id` int(11) NOT NULL,
  `travel_agency_name` varchar(100) NOT NULL,
  `travel_agency_code` varchar(50) NOT NULL,
  `travel_agency_address` text NOT NULL,
  `travel_agency_country` int(11) NOT NULL,
  `travel_agency_email` varchar(100) NOT NULL,
  `travel_agency_phone` varchar(20) NOT NULL,
  `travel_agency_website` varchar(100) NOT NULL,
  `travel_agency_contact_person` varchar(20) NOT NULL,
  `travel_agency_contact_phone` varchar(20) NOT NULL,
  `travel_agency_contact_email` varchar(100) NOT NULL,
  `travel_agency_contact_address` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_agency`
--

INSERT INTO `travel_agency` (`travel_agency_id`, `travel_agency_name`, `travel_agency_code`, `travel_agency_address`, `travel_agency_country`, `travel_agency_email`, `travel_agency_phone`, `travel_agency_website`, `travel_agency_contact_person`, `travel_agency_contact_phone`, `travel_agency_contact_email`, `travel_agency_contact_address`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Self', '10001', '', 101, '', '', '', '', '', '', '', 1, 1000488, '2020-12-12 18:43:11', '2020-12-12 18:44:16'),
(2, 'Make My Trip', '10002', 'Achampet', 101, 'booking@makemytrip.com', '09876543456', 'makemytrip.com', 'Rahul', '09876541230', 'rahul@makemytrip.com', 'Salem', 1, 1000488, '2020-12-12 18:43:30', '2020-12-12 18:44:41'),
(3, 'booking.com', '002', '', 101, 'booking@g.c', '', '', '', '', '', '', 1, 1000488, '2021-04-11 05:39:09', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advance_master`
--
ALTER TABLE `advance_master`
  ADD PRIMARY KEY (`advance_master_id`),
  ADD KEY `advance_no` (`advance_no`);

--
-- Indexes for table `booking_master`
--
ALTER TABLE `booking_master`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `booking_master_detail`
--
ALTER TABLE `booking_master_detail`
  ADD PRIMARY KEY (`booking_master_detail_id`),
  ADD KEY `room_type` (`room_category`);

--
-- Indexes for table `booking_master_detail_track`
--
ALTER TABLE `booking_master_detail_track`
  ADD PRIMARY KEY (`booking_master_detail_track_id`),
  ADD KEY `room_type` (`room_category`);

--
-- Indexes for table `booking_master_new`
--
ALTER TABLE `booking_master_new`
  ADD PRIMARY KEY (`booking_master_id`),
  ADD KEY `booking_no` (`booking_no`,`reservation_no`);

--
-- Indexes for table `booking_master_new_track`
--
ALTER TABLE `booking_master_new_track`
  ADD PRIMARY KEY (`booking_master_new_track_id`),
  ADD KEY `booking_no` (`booking_no`,`reservation_no`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `customer_ledger`
--
ALTER TABLE `customer_ledger`
  ADD PRIMARY KEY (`customer_ledger_id`);

--
-- Indexes for table `customer_master`
--
ALTER TABLE `customer_master`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employee_master`
--
ALTER TABLE `employee_master`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `employee_type_id` (`employee_type_id`);

--
-- Indexes for table `employee_type`
--
ALTER TABLE `employee_type`
  ADD PRIMARY KEY (`employee_type_id`);

--
-- Indexes for table `expenses_master`
--
ALTER TABLE `expenses_master`
  ADD PRIMARY KEY (`expenses_id`);

--
-- Indexes for table `expenses_type`
--
ALTER TABLE `expenses_type`
  ADD PRIMARY KEY (`expenses_type_id`);

--
-- Indexes for table `floor_master`
--
ALTER TABLE `floor_master`
  ADD PRIMARY KEY (`floor_master_id`);

--
-- Indexes for table `invoice_master`
--
ALTER TABLE `invoice_master`
  ADD PRIMARY KEY (`invoice_master_id`),
  ADD KEY `process_no` (`process_no`);

--
-- Indexes for table `login_master`
--
ALTER TABLE `login_master`
  ADD PRIMARY KEY (`login_master_id`);

--
-- Indexes for table `meal_plan`
--
ALTER TABLE `meal_plan`
  ADD PRIMARY KEY (`meal_plan_id`);

--
-- Indexes for table `miscellaneous_expenses`
--
ALTER TABLE `miscellaneous_expenses`
  ADD PRIMARY KEY (`miscellaneous_expenses_id`);

--
-- Indexes for table `night_audit_master`
--
ALTER TABLE `night_audit_master`
  ADD PRIMARY KEY (`night_audit_master_id`);

--
-- Indexes for table `payment_master`
--
ALTER TABLE `payment_master`
  ADD PRIMARY KEY (`payment_master_id`);

--
-- Indexes for table `reservation_master`
--
ALTER TABLE `reservation_master`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `reservation_master_detail`
--
ALTER TABLE `reservation_master_detail`
  ADD PRIMARY KEY (`reservation_master_detail_id`),
  ADD KEY `room_type` (`room_category`);

--
-- Indexes for table `reservation_master_detail_track`
--
ALTER TABLE `reservation_master_detail_track`
  ADD PRIMARY KEY (`reservation_master_detail_track_id`),
  ADD KEY `room_type` (`room_category`);

--
-- Indexes for table `reservation_master_new`
--
ALTER TABLE `reservation_master_new`
  ADD PRIMARY KEY (`reservation_master_id`);

--
-- Indexes for table `reservation_master_new_track`
--
ALTER TABLE `reservation_master_new_track`
  ADD PRIMARY KEY (`reservation_master_new_track`);

--
-- Indexes for table `room_category`
--
ALTER TABLE `room_category`
  ADD PRIMARY KEY (`room_category_id`) USING BTREE;

--
-- Indexes for table `room_facilites_master`
--
ALTER TABLE `room_facilites_master`
  ADD PRIMARY KEY (`room_facilites_master_id`);

--
-- Indexes for table `room_master`
--
ALTER TABLE `room_master`
  ADD PRIMARY KEY (`room_master_id`) USING BTREE;

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `travel_agency`
--
ALTER TABLE `travel_agency`
  ADD PRIMARY KEY (`travel_agency_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advance_master`
--
ALTER TABLE `advance_master`
  MODIFY `advance_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `booking_master`
--
ALTER TABLE `booking_master`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_master_detail`
--
ALTER TABLE `booking_master_detail`
  MODIFY `booking_master_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `booking_master_detail_track`
--
ALTER TABLE `booking_master_detail_track`
  MODIFY `booking_master_detail_track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `booking_master_new`
--
ALTER TABLE `booking_master_new`
  MODIFY `booking_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `booking_master_new_track`
--
ALTER TABLE `booking_master_new_track`
  MODIFY `booking_master_new_track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_ledger`
--
ALTER TABLE `customer_ledger`
  MODIFY `customer_ledger_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `customer_master`
--
ALTER TABLE `customer_master`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_master`
--
ALTER TABLE `employee_master`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000489;

--
-- AUTO_INCREMENT for table `employee_type`
--
ALTER TABLE `employee_type`
  MODIFY `employee_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expenses_master`
--
ALTER TABLE `expenses_master`
  MODIFY `expenses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses_type`
--
ALTER TABLE `expenses_type`
  MODIFY `expenses_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `floor_master`
--
ALTER TABLE `floor_master`
  MODIFY `floor_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoice_master`
--
ALTER TABLE `invoice_master`
  MODIFY `invoice_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_master`
--
ALTER TABLE `login_master`
  MODIFY `login_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `meal_plan`
--
ALTER TABLE `meal_plan`
  MODIFY `meal_plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `miscellaneous_expenses`
--
ALTER TABLE `miscellaneous_expenses`
  MODIFY `miscellaneous_expenses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `night_audit_master`
--
ALTER TABLE `night_audit_master`
  MODIFY `night_audit_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment_master`
--
ALTER TABLE `payment_master`
  MODIFY `payment_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservation_master`
--
ALTER TABLE `reservation_master`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_master_detail`
--
ALTER TABLE `reservation_master_detail`
  MODIFY `reservation_master_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reservation_master_detail_track`
--
ALTER TABLE `reservation_master_detail_track`
  MODIFY `reservation_master_detail_track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reservation_master_new`
--
ALTER TABLE `reservation_master_new`
  MODIFY `reservation_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservation_master_new_track`
--
ALTER TABLE `reservation_master_new_track`
  MODIFY `reservation_master_new_track` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `room_category`
--
ALTER TABLE `room_category`
  MODIFY `room_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_facilites_master`
--
ALTER TABLE `room_facilites_master`
  MODIFY `room_facilites_master_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_master`
--
ALTER TABLE `room_master`
  MODIFY `room_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `travel_agency`
--
ALTER TABLE `travel_agency`
  MODIFY `travel_agency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
