-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2022 at 07:43 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tgl`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `car_owner_id` int(11) NOT NULL,
  `car_producer` varchar(255) DEFAULT 'unknown',
  `car_model` varchar(255) DEFAULT 'unknown',
  `car_number_sign` varchar(10) NOT NULL,
  `car_year` int(4) DEFAULT NULL,
  `car_color` varchar(255) DEFAULT 'unknown',
  `car_interior_material` varchar(255) DEFAULT 'unknown',
  `car_details` text DEFAULT 'Not mentioned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_owner_id`, `car_producer`, `car_model`, `car_number_sign`, `car_year`, `car_color`, `car_interior_material`, `car_details`) VALUES
(1, 8, 'BMW', 'model 5', 'AA-1111', 2015, 'yellow', 'leather', 'Not mentioned'),
(2, 8, 'Tesla', 'Model S', 'BB-2222', 2020, 'White', 'Synthetics', 'The rear passenger window on the left side has cracks.'),
(4, 8, 'Volks Wagen', 'Golf 7', 'CC-3333', 2016, 'Grey', 'Synthetics', 'Not mentioned'),
(7, 13, 'asdf', 'asdf', 'LV-1234', 1234, 'asdf', 'asdf', ''),
(8, 14, 'asdf', 'asdf', 'asdf', 123, 'asdf', 'asdf', '');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_topic_id` int(11) NOT NULL,
  `comment_user_id` int(11) NOT NULL,
  `comment_rating` int(1) NOT NULL,
  `comment_content` text DEFAULT NULL,
  `comment_date` date NOT NULL,
  `comment_isanonyme` tinyint(1) NOT NULL DEFAULT 0,
  `comment_status` varchar(255) NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_topic_id`, `comment_user_id`, `comment_rating`, `comment_content`, `comment_date`, `comment_isanonyme`, `comment_status`) VALUES
(2, 1, 1, 5, 'Some content', '2022-02-12', 1, 'approved'),
(3, 1, 3, 4, 'asdfasfd', '2022-02-12', 1, 'approved'),
(5, 3, 3, 5, 'review', '2022-02-12', 0, 'approved'),
(6, 1, 3, 3, 'This is some review', '2022-02-13', 0, 'approved'),
(7, 1, 4, 5, 'Another review', '2022-02-13', 0, 'approved'),
(10, 3, 1, 1, 'aaaaaaaaaaa', '2022-02-13', 0, 'approved'),
(11, 6, 1, 5, 'a', '2022-02-13', 0, 'approved'),
(12, 3, 1, 3, 'aaaaaaaaaaaaaaaaa', '2022-02-14', 1, 'approved'),
(22, 1, 4, 5, 'This is another one review', '2022-02-14', 1, 'approved'),
(23, 3, 8, 5, '11111111111', '2022-03-03', 0, 'approved'),
(24, 1, 8, 5, 'Very satisfied with the job. My car now realy shines like never before!', '2022-03-02', 1, 'approved'),
(25, 1, 8, 5, 'aaa', '2022-03-29', 1, 'draft'),
(27, 1, 8, 2, '', '2022-03-03', 1, 'approved'),
(28, 7, 8, 5, '', '2022-05-05', 0, 'approved'),
(29, 1, 13, 5, 'Nice job and great service', '2022-05-18', 0, 'approved'),
(30, 3, 13, 2, 'sadasdf', '2022-05-18', 0, 'approved'),
(31, 1, 8, 5, 'Mana atsauksme', '2022-05-21', 1, 'draft'),
(45, 1, 8, 4, 'Some review', '2022-05-23', 1, 'draft'),
(54, 1, 8, 5, 'Atsauksme', '2022-05-23', 1, 'draft'),
(55, 3, 8, 5, 'Vēl viena atsauksme', '2022-05-23', 1, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_user_id` int(11) NOT NULL,
  `order_service_id` int(11) NOT NULL,
  `order_car_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_appointment_date` date NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `order_completion_date` date DEFAULT NULL,
  `order_end_price` int(11) NOT NULL DEFAULT 0,
  `order_date_of_payment` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_user_id`, `order_service_id`, `order_car_id`, `order_date`, `order_appointment_date`, `order_status`, `order_completion_date`, `order_end_price`, `order_date_of_payment`) VALUES
(1, 1, 3, 1, '2022-02-21', '2022-02-22', 'recieved', '0000-00-00', 0, '0000-00-00'),
(2, 3, 3, 4, '2022-02-21', '2022-02-23', 'completed', '2022-02-22', 500, '2022-03-30'),
(3, 4, 3, 4, '2022-02-22', '2022-02-23', 'completed', '2022-03-24', 543, '2022-02-24'),
(4, 8, 3, 4, '2022-02-23', '2022-02-23', 'in progress', '0000-00-00', 0, '0000-00-00'),
(5, 8, 3, 4, '2022-02-24', '2022-02-24', 'completed', '2022-02-24', 550, '2022-03-30'),
(6, 8, 4, 1, '2022-02-25', '2022-02-26', 'completed', '2022-03-01', 550, '2022-03-15'),
(7, 8, 3, 5, '2022-03-01', '2022-03-02', 'Recieved', '0000-00-00', 0, '0000-00-00'),
(8, 8, 14, 4, '2022-03-02', '2022-03-03', 'completed', '2022-05-21', 324, '2022-05-21'),
(9, 8, 3, 1, '2022-03-21', '2022-03-22', 'canceled', '0000-00-00', 0, '0000-00-00'),
(10, 8, 11, 2, '2022-03-24', '2022-03-24', 'completed', '2022-02-23', 1023, '2021-03-01'),
(11, 8, 3, 4, '2022-03-02', '2022-03-03', 'completed', '2022-03-22', 324, '2021-01-01'),
(12, 8, 3, 4, '2022-03-02', '2022-03-03', 'completed', '2022-03-22', 324, '2021-11-01'),
(13, 8, 3, 4, '2022-03-02', '2022-03-03', 'completed', '2022-03-22', 324, '2021-10-01'),
(14, 8, 3, 4, '2022-03-02', '2022-03-03', 'completed', '2022-03-22', 324, '2021-09-01'),
(15, 8, 3, 2, '2022-03-29', '2022-03-30', 'Recieved', '0000-00-00', 0, '0000-00-00'),
(16, 8, 3, 0, '2022-04-21', '0000-00-00', 'Recieved', NULL, 0, NULL),
(17, 8, 3, 0, '2022-04-21', '0000-00-00', 'Recieved', NULL, 0, NULL),
(18, 8, 3, 0, '2022-04-21', '0000-00-00', 'Recieved', NULL, 0, NULL),
(19, 8, 3, 1, '2022-04-21', '0000-00-00', 'Recieved', NULL, 0, NULL),
(20, 8, 3, 1, '2022-04-22', '2022-04-22', 'completed', '2022-05-21', 500, '2022-05-21'),
(21, 8, 13, 1, '2022-04-22', '2022-04-22', 'completed', '2022-05-21', 2000, '2022-05-21'),
(22, 8, 3, 1, '2022-04-22', '2022-04-22', 'Recieved', NULL, 0, NULL),
(23, 8, 3, 1, '2022-04-22', '2022-04-22', 'Recieved', NULL, 0, NULL),
(24, 8, 11, 4, '2022-05-19', '2022-05-27', 'completed', '2022-05-21', 1100, '2022-05-21'),
(25, 8, 3, 2, '2022-05-21', '2022-05-27', 'completed', '2022-05-20', 500, '2022-05-21'),
(26, 8, 3, 4, '2022-05-23', '2022-05-23', 'completed', '2022-05-23', 450, '2022-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `order_report`
--

CREATE TABLE `order_report` (
  `report_id` int(11) NOT NULL,
  `report_order_id` int(11) NOT NULL,
  `report_text` text NOT NULL,
  `report_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_report`
--

INSERT INTO `order_report` (`report_id`, `report_order_id`, `report_text`, `report_date`) VALUES
(3, 6, 'Car was repaired.', '2022-02-28'),
(6, 8, 'report', '2022-03-04'),
(7, 25, 'The car was fully restored, but deeper scratches and bumps still remain.', '2022-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_title` varchar(255) NOT NULL,
  `service_price` float NOT NULL,
  `service_hours` int(11) NOT NULL,
  `service_description` text NOT NULL,
  `service_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_title`, `service_price`, `service_hours`, `service_description`, `service_image`) VALUES
(1, 'General', 0, 0, 'null', 'null'),
(3, 'Basic Glow', 399.99, 30, '<p>This is basic and essential car care with up to 90 days of paint protection. </p><p><br></p><p>The package includes:</p><p><br></p><ul><li>Alloy safe clean</li><li>Premium snow foam & rinse</li><li>Safe wash with sheep mitts (2 buckets)</li><li>Rinse & dry with water magnet towels & air compressor</li><li>Decontamination with chemicals (silicon, tar, iron, fat removal)</li><li>One more safe wash & dry</li><li>Clay bar with premium clay that is suitable for your car pain</li><li>One More safe wash & dry</li><li>Paintwork check</li><li>Masking with premium masking tape to protect exterior elements from damages</li><li>Single-stage machine polishing process with 90 days of protective polymer sealant</li><li>Full valet (if you are a lucky pet owner, please chose our \"Basic Glow Pet\" package instead as we will need more time to clean your car from the inside)</li><li>Tyre dressing</li><li>Rain repellent application</li><li>Interior antibacterial clean</li></ul><p><br></p><p>To learn more about our packages please visit the <a href=\"aboutus.php\" class=\"description-link\">About Us</a> page.</p><p><br></p><hr><p><em style=\"outline: none; box-sizing: inherit; color: rgb(91, 91, 91); font-family: Roboto;\">Please note that all “BASIC GLOW” packages are designed for cars with a clear coat that has minimum visible defects on it and only single stage machine polishing will be used. If defects are medium or even worse then you should choose the “ADVANCED GLOW” packages as they are designed to cure light, medium and hard scratches. “ADVANCED GLOW” is identical to “BASIC GLOW” except 3 stage machine polishing will be used. You can add any protective coating to BASIC GLOW or ADVANCED GLOW PACKAGE.</em></p><p><em style=\"outline: none; box-sizing: inherit; color: rgb(91, 91, 91); font-family: Roboto;\"><br></em></p><p><em style=\"outline: none; box-sizing: inherit; color: rgb(91, 91, 91); font-family: Roboto;\">*Terms and conditions apply.<br></em><br></p><p></p><p></p><p><br></p><p></p>', 'Basic-Glow.jpeg'),
(4, 'Basic Glow Liquid Glass', 599.99, 30, '<p>This is basic and essential car care with up to 1 year of liquid glass protective coating.&nbsp;</p><p><br></p><p>The package includes:</p><p><br></p><ul><li>Alloy safe clean</li><li>Premium snow foam &amp; rinse</li><li>Safe wash with sheep mitts (2 buckets)</li><li>Rinse &amp; dry with water magnet towels &amp; air compressor</li><li>Decontamination with chemicals (silicon, tar, iron, fat removal)</li><li>One more safe wash &amp; dry</li><li>Clay bar with premium clay that is suitable for your car pain</li><li>One More safe wash &amp; dry</li><li>Paintwork check</li><li>Masking with premium masking tape to protect exterior elements from damages</li><li>Single-stage machine polishing process with 90 days of protective polymer sealant</li><li>Full valet (if you are a lucky pet owner, please choose our \"Basic Glow Pet\" package instead as we will need more time to clean your car from the inside)</li><li>Tyre dressing</li><li>Rain repellent application</li><li>Interior antibacterial clean</li></ul><p><br></p><p>To learn more about our packages please visit the&nbsp;&nbsp;<a href=\"aboutus.php\" class=\"description-link\" style=\"background-color: rgb(255, 255, 255);\">About Us</a>&nbsp;page.</p><p><br></p><hr><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">Please note that all “BASIC GLOW” packages are designed for cars with a clear coat that has minimum visible defects on it and only single stage machine polishing will be used. If defects are medium or even worse then you should choose the “ADVANCED GLOW” packages as they are designed to cure light, medium and hard scratches. “ADVANCED GLOW” is identical to “BASIC GLOW” except 3 stage machine polishing will be used. You can add any protective coating to BASIC GLOW or ADVANCED GLOW PACKAGE.</em></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\"><br></em></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">*Terms and conditions apply.<br></em></p>', 'Basic-Glow.jpeg'),
(7, 'Basic Glow Nano-Ceramic', 699.99, 30, '<p>This is basic and essential car care with up to 1 year of nano-ceramic paint protection.&nbsp;</p><p><br></p><p>The package includes:</p><p><br></p><ul><li>Alloy safe clean</li><li>Premium snow foam &amp; rinse</li><li>Safe wash with sheep mitts (2 buckets)</li><li>Rinse &amp; dry with water magnet towels &amp; air compressor</li><li>Decontamination with chemicals (silicon, tar, iron, fat removal)</li><li>One more safe wash &amp; dry</li><li>Clay bar with premium clay that is suitable for your car pain</li><li>One More safe wash &amp; dry</li><li>Paintwork check</li><li>Masking with premium masking tape to protect exterior elements from damages</li><li>Single-stage machine polishing process with 90 days of protective polymer sealant</li><li>Full valet (if you are a lucky pet owner, please chose our \"Basic Glow Pet\" package instead as we will need more time to clean your car from the inside)</li><li>Tyre dressing</li><li>Rain repellent application</li><li>Interior antibacterial clean</li></ul><p><br></p><p>To learn more about our packages please visit the&nbsp;<a href=\"aboutus.php\" class=\"description-link\">About Us</a>&nbsp;page.</p><p><br></p><hr><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">Please note that all “BASIC GLOW” packages are designed for cars with a clearcoat that has minimum visible defects on it and only single stage machine polishing will be used. If defects are medium or even worse then you should choose the “ADVANCED GLOW” packages as they are designed to cure light, medium and hard scratches. “ADVANCED GLOW” is identical to “BASIC GLOW” except 3 stage machine polishing will be used. You can add any protective coating to BASIC GLOW or ADVANCED GLOW PACKAGE.</em></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\"><br></em></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">*Terms and conditions apply.<br></em></p>', 'Basic-Glow.jpeg'),
(10, 'Basic Glow PTFE', 799.99, 30, '<p>This is basic and essential car care with up to 1 year of PTFE paint protection.&nbsp;</p><p><br></p><p>The package includes:</p><p><br></p><ul><li>Alloy safe clean</li><li>Premium snow foam &amp; rinse</li><li>Safe wash with sheep mitts (2 buckets)</li><li>Rinse &amp; dry with water magnet towels &amp; air compressor</li><li>Decontamination with chemicals (silicon, tar, iron, fat removal)</li><li>One more safe wash &amp; dry</li><li>Clay bar with premium clay that is suitable for your car pain</li><li>One More safe wash &amp; dry</li><li>Paintwork check</li><li>Masking with premium masking tape to protect exterior elements from damages</li><li>Single-stage machine polishing process with 90 days of protective polymer sealant</li><li>Full valet (if you are a lucky pet owner, please chose our \"Basic Glow Pet\" package instead as we will need more time to clean your car from the inside)</li><li>Tyre dressing</li><li>Rain repellent application</li><li>Interior antibacterial clean</li></ul><p><br></p><p>To learn more about our packages please visit the&nbsp;<a href=\"aboutus.php\" class=\"description-link\">About Us</a>&nbsp;page.</p><p><br></p><hr><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">Please note that all “BASIC GLOW” packages are designed for cars with a clear coat that has minimum visible defects on it and only single stage machine polishing will be used. If defects are medium or even worse then you should choose the “ADVANCED GLOW” packages as they are designed to cure light, medium and hard scratches. “ADVANCED GLOW” is identical to “BASIC GLOW” except 3 stage machine polishing will be used. You can add any protective coating to BASIC GLOW or ADVANCED GLOW PACKAGE.</em></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\"><br></em></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">*Terms and conditions apply.</em></p>', 'Basic-Glow.jpeg'),
(11, 'Basic Glow Graphene', 899.99, 30, '<p>This is basic and essential car care with up to 1 year of graphene paint protection.&nbsp;</p><p><br></p><p>The package includes:</p><p><br></p><ul><li>Alloy safe clean</li><li>Premium snow foam &amp; rinse</li><li>Safe wash with sheep mitts (2 buckets)</li><li>Rinse &amp; dry with water magnet towels &amp; air compressor</li><li>Decontamination with chemicals (silicon, tar, iron, fat removal)</li><li>One more safe wash &amp; dry</li><li>Clay bar with premium clay that is suitable for your car pain</li><li>One More safe wash &amp; dry</li><li>Paintwork check</li><li>Masking with premium masking tape to protect exterior elements from damages</li><li>Single-stage machine polishing process with 90 days of protective polymer sealant</li><li>Full valet (if you are a lucky pet owner, please chose our \"Basic Glow Pet\" package instead as we will need more time to clean your car from the inside)</li><li>Tyre dressing</li><li>Rain repellent application</li><li>Interior antibacterial clean</li></ul><p><br></p><p>To learn more about our packages please visit the&nbsp;<a href=\"aboutus.php\" class=\"description-link\">About Us</a>&nbsp;page.</p><p><br></p><hr><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">Please note that all “BASIC GLOW” packages are designed for cars with a clear coat that has minimum visible defects on it and only single stage machine polishing will be used. If defects are medium or even worse then you should choose the “ADVANCED GLOW” packages as they are designed to cure light, medium and hard scratches. “ADVANCED GLOW” is identical to “BASIC GLOW” except 3 stage machine polishing will be used. You can add any protective coating to BASIC GLOW or ADVANCED GLOW PACKAGE.</em></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\"><br></em></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">*Terms and conditions apply.</em></p>', 'Basic-Glow.jpeg'),
(12, 'Advanced Package', 899.99, 45, '<p>This package contains full care for the car.&nbsp;</p><p><br></p><p>The package includes:</p><p><br></p><ul><li>Alloy safe clean</li><li>Premium snow foam &amp; rinse</li><li>Safe wash with sheep mitts (3 buckets)</li><li>Rinse</li><li>Drying with air and drying towels</li><li>Decontamination with chemicals (Silicon, glue, tar removal)</li><li>Decontamination with chemical (Iron removal)</li><li>Clay bar with premium clay that is suitable for your car paint</li><li>One more safe wash with sheep mitts (2 buckets)</li><li>Drying with air and drying towels</li><li>Masking with premium masking tape to protect exterior elements from damages</li><li>Chrome polishing</li><li>Car paint thickness 80 point check&nbsp;</li><li>Full valet (If you are a lucky pet owner please choose our “Basic Glow Pet” package instead as we will need more time to clean your car from the inside)</li><li>Tyre dressing</li><li>Rain repellent application</li><li>Aircon and interior disinfection</li></ul><p><br></p><p>To learn more about our packages please visit the&nbsp;<a href=\"aboutus.php\" class=\"description-link\">About Us</a>&nbsp;page.</p><p><br></p><hr><p><br></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">*Terms and conditions apply.</em></p>      ', 'Advanced-Glow.jpeg'),
(13, 'Signature Package', 1899.99, 100, '<p>This package contains premium care for the car.&nbsp;</p><p><br></p><p>The package includes:</p><p><br></p><ul><li>Alloy safe clean</li><li>Premium snow foam &amp; rinse.</li><li>Safe wash with sheep mitts (2 buckets)</li><li>Rinse</li><li>Drying with air and drying towels</li><li>Decontamination with chemicals (Silicon, glue, tar removal)</li><li>Decontamination with chemicals (Iron removal)</li><li>Clay bar with premium clay that is suitable for your car paint</li><li>One more safe wash with sheep mitts (2 buckets)</li><li>Drying with air and drying towels</li><li>Masking with premium masking tape to protect exterior elements from damages</li><li>Chrome polishing</li><li>Car paint thickness 80 point check</li><li>Single-stage machine polishing process with 90 days of protective polymer sealant</li><li>Car paint thickness 80 point check</li><li>Full valet</li><li>Tyre dressing</li><li>Rain repellent application</li><li>Interior antibacterial clean</li></ul><p><br></p><p>To learn more about our packages please visit the&nbsp;<a href=\"aboutus.php\" class=\"description-link\">About Us</a>&nbsp;page.</p><p><br></p><hr><p><br></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">*Terms and conditions apply.</em></p>    ', 'Signature-Glow.jpeg'),
(14, 'Interior Package', 499.99, 40, '<p>This package contains full care for the car interior and basic care for the car.&nbsp;</p><p><br></p><p>The package includes:</p><p><br></p><ul><li>Prewash</li><li>Snow foam</li><li>Alloy chem clean</li><li>2 Buckets alloy clean</li><li>2 Buckets paint clean</li><li>Carnauba wax for paint</li><li>Drying with water</li><li>Magnet &amp; Air</li><li>Tyre dressing</li><li>Interior vacuuming</li><li>Interior steam clean</li><li>Interior parts chem clean</li><li>Glass clean</li><li>Carpets chem clean/dry</li><li>Floor chem clean</li><li>Fabric chem clean &amp; protect</li><li>Leather chem clean &amp; protect</li><li>Glossy panel 3 stage polish process</li></ul><p>*(Our mechanic will safely remove/install part if local polishing is not available)</p><ul><li>SiO2 and TiO2 protection coating for interior parts</li><li>Plastic restorer application</li><li>Rubber sealant silicone application</li><li>Interior antibacterial clean</li></ul><p><br></p><p>The package prices apply to a medium-size sedan and can be higher if you want us to use exclusive materials that have been designed specifically for your interior or also if you are a lucky pet owner then prices could be higher since it will demand more time and attention for the car. Also, it could be lower if you owe a small car.</p><p><br></p><p>To learn more about our packages please visit the&nbsp;<a href=\"aboutus.php\" class=\"description-link\">About Us</a>&nbsp;page.</p><p><br></p><hr><p><br></p><p><em style=\"box-sizing: inherit; outline: none; color: rgb(91, 91, 91); font-family: Roboto;\">*Terms and conditions apply.</em></p>    ', 'Interior-Glow-600x383.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_first` varchar(255) NOT NULL,
  `user_last` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` int(9) NOT NULL,
  `user_phone_code` int(5) NOT NULL,
  `user_role` varchar(255) NOT NULL DEFAULT 'user',
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_first`, `user_last`, `user_email`, `user_phone`, `user_phone_code`, `user_role`, `user_password`) VALUES
(1, 'Lorem', 'Ipsum', 'ipsum@mail.com', 23323232, 371, 'user', '1'),
(3, 'Mary', 'Loe', 'loe@mail.com', 23984539, 373, 'admin', 'password'),
(4, 'Garry', 'Goe', 'garry@mail.com', 12345678, 123, 'user', '11111111111111111111'),
(8, 'Joe', 'Man', 'j@mail.com', 111111, 1, 'admin', '1'),
(9, 'Lo', 'Loen', 'l@mail.com', 12345678, 123, 'user', '1'),
(12, 'asdf', 'asdf', 'asdf@s.com', 12, 2323423, 'user', '123456'),
(13, 'Ilona', 'asdf', '123@a.com', 123456789, 123, 'user', '123456'),
(14, 'asdfasddf', 'asdfasdf', 'asdf@asdf.com', 123, 123, 'user', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `car_owner_id` (`car_owner_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_topic_id` (`comment_topic_id`),
  ADD KEY `comment_user_id` (`comment_user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_user_id` (`order_user_id`),
  ADD KEY `order_service_id` (`order_service_id`),
  ADD KEY `order_car_id` (`order_car_id`);

--
-- Indexes for table `order_report`
--
ALTER TABLE `order_report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `report_order_id` (`report_order_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_report`
--
ALTER TABLE `order_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`car_owner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comment_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`order_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`order_service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `order_report`
--
ALTER TABLE `order_report`
  ADD CONSTRAINT `order_report_ibfk_1` FOREIGN KEY (`report_order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
