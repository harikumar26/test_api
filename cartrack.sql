-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2021 at 04:42 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cartrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesstoken`
--

CREATE TABLE `accesstoken` (
  `accesstoken_id` int(11) NOT NULL,
  `accesstoken` varchar(255) NOT NULL,
  `access_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accesstoken`
--

INSERT INTO `accesstoken` (`accesstoken_id`, `accesstoken`, `access_created_at`) VALUES
(1, '&quot;YTA5ZWJhNGNmNjE1MGMzYQVz5knuRiLNtaMKwuYAJVM=&quot;', '0000-00-00 00:00:00'),
(2, 'NzkxZGRiYWU3ZjNkYjZmZEV6OfudrDpRhtcc39Fvr/8=', '2021-05-19 00:51:17'),
(3, 'ZWNjYjkyMTMxNDczMmE0YVIGBUyz6DlnCClmQj1JcgM=', '2021-05-19 06:52:38'),
(4, 'MGVkNjkzNGJhZmVlZDExMNkRQYIoFQ4/d6LRGIjQCcE=', '2021-05-20 01:52:42'),
(5, 'MzdmZTYwNTkzY2Y4OTg0MIgp0m31snejRr1sn+GID7M=', '2021-05-20 02:12:08'),
(6, 'MzIxM2U1Mjc4OWQ3OTdkM1WKNNHM1Et5y39536uijoM=', '2021-05-20 02:25:23'),
(7, 'NDBmNDlhMzk2ODIzMjBlZROskuIY7bmM2ZTejGb3yYI=', '2021-05-20 04:09:38'),
(8, 'YTUwYWViMjNiYmY4YzljZsjkxGo1VibyZFMWip2iBUg=', '2021-05-20 14:43:22'),
(9, 'YmZmZTVjNzUzM2JkYTc0OIKMbmB/mKA0DQVKJKy5Lwc=', '2021-05-20 15:05:03'),
(10, 'N2IxYzZjMTllN2U4OTY4Y0agmnjJ4n9Yv31PU0w/E/k=', '2021-05-20 15:05:21'),
(11, 'NjMxOTQwZGFlZTlmNjQ0M1IiiIHj6MX8OKbT+j6+GqU=', '2021-05-20 15:35:28'),
(12, 'ZGY1MjhmYzEzYTY1YjM3ZPgmgK8jVlneN4vbYfPXA/4=', '2021-05-21 02:02:52');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created`) VALUES
(1, 'Mobiles', 'All Category of Mobiles.', '2021-05-20 23:30:21'),
(2, 'Mobile Accessories', 'All kind of mobile Gadgets.', '2021-05-20 23:30:21'),
(3, 'Mobile Repair', 'Any kind of mobile repair available.', '2021-05-20 23:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `created`) VALUES
(1, 'Headphone', 'Nice Headphone to use', '50', 2, '2021-05-20 12:11:22'),
(5, 'Oppo', 'Nice Phone to use. Having 2 Years warranty.', '255', 1, '2021-05-21 10:08:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesstoken`
--
ALTER TABLE `accesstoken`
  ADD PRIMARY KEY (`accesstoken_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesstoken`
--
ALTER TABLE `accesstoken`
  MODIFY `accesstoken_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
