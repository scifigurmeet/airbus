-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2019 at 10:46 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airbus`
--

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `origin` text,
  `destination` text,
  `departure_date` text,
  `departure_time` text,
  `arrival_date` text,
  `arrival_time` text,
  `economy_fare` text,
  `premium_economy_fare` int(11) NOT NULL,
  `business_fare` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `origin`, `destination`, `departure_date`, `departure_time`, `arrival_date`, `arrival_time`, `economy_fare`, `premium_economy_fare`, `business_fare`) VALUES
(2, 'Ludhiana (LUH)', 'Chandigarh (IXC)', '2019-12-08', '15:15', '2019-12-08', '16:00', '1000', 1500, 2200),
(3, 'Chandigarh (IXC)', 'Delhi (DEL)', '2019-12-08', '17:35', '2019-12-08', '18:35', '1235', 1750, 2500),
(4, 'Ludhiana (LUH)', 'Chandigarh (IXC)', '2019-12-09', '15:15', '2019-12-08', '16:00', '3000', 1500, 4000),
(5, 'Ludhiana (LUH)', 'Delhi (DEL)', '2019-12-14', '15:00', '2019-12-14', '16:15', '', 1200, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `passengers` text NOT NULL,
  `price` int(11) NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `flight_id`, `passengers`, `price`, `email`, `phone`) VALUES
(3, 3, 'Mr. Gurmeet Singh', 1235, 'scifigurmeet@gmail.com', '8568970199'),
(4, 2, 'Mr. Gurmeet Singh', 1000, 'scifigurmeet@gmail.com', '8568970199'),
(5, 3, 'Mr. Gurmeet Singh', 617, 'flymyblog@gmail.com', '8568970199');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
