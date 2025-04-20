-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 04:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `explorebest`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc` ()   SELECT
a.id AS 'acc_id',
c.city_name,
a.type,
a.location,
a.accommodation_image AS 'acc_img',
a.services,
a.phone,
a.status
FROM accommodation a
INNER JOIN cities c ON a.city_id=c.id
WHERE a.status = '1'
ORDER BY a.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc_admin` ()   SELECT
a.id AS 'acc_id',
c.city_name,
a.type,
a.location,
a.accommodation_image,
a.services,
a.status
FROM accommodation a
INNER JOIN cities c ON a.city_id=c.id
ORDER BY a.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc_by_id` (IN `acc_id` INT)   SELECT
a.id AS 'acc_id',
c.id AS 'city_id',
c.city_name,
a.type,
a.location,
a.services
FROM accommodation a
INNER JOIN cities c ON a.city_id=c.id
WHERE a.id=acc_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc_types` ()   SELECT
*
FROM accommodation_types$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc_user` (IN `user_id` INT)   SELECT
a.id AS 'acc_id',
c.city_name,
a.type,
a.location,
a.accommodation_image,
a.services,
a.status
FROM accommodation a
INNER JOIN cities c ON a.city_id=c.id
WHERE a.u_id=user_id
ORDER BY a.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_users` ()   SELECT
*
FROM users
WHERE role!='admin'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_apps` ()   SELECT
app.id AS 'app_id',
app.title,
app.link,
app.image
FROM applications app$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_cities` ()   SELECT
*
FROM cities c 
ORDER BY c.city_name ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_comments_by_place` (IN `place_id` INT)   SELECT
c.id AS 'comment_id',
c.comment,
c.rating,
c.comment_date,
u.username
FROM comments c
INNER JOIN places p ON c.place_id=p.id
INNER JOIN users u ON c.tourist_id=u.id
WHERE c.place_id=place_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_comments_by_user_id` (IN `user_id` INT)   SELECT
c.id AS 'comment_id',
c.comment,
c.rating,
c.comment_date
FROM comments c
WHERE c.tourist_id=user_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_events` ()   SELECT
e.id AS 'event_id',
c.city_name,
e.event_name,
e.date,
e.booking_link,
e.event_img,
e.phone,
e.status
FROM events e
INNER JOIN cities c ON e.city_id=c.id
WHERE e.status = '1'
ORDER BY e.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_events_admin` ()   SELECT
e.id AS 'event_id',
c.city_name,
e.event_name,
e.date,
e.booking_link,
e.event_img,
e.status
FROM events e
INNER JOIN cities c ON e.city_id=c.id
ORDER BY e.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_events_user` (IN `user_id` INT)   SELECT
e.id AS 'event_id',
c.city_name,
e.event_name,
e.date,
e.booking_link,
e.event_img,
e.status
FROM events e
INNER JOIN cities c ON e.city_id=c.id
WHERE e.u_id=user_id
ORDER BY e.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_event_by_id` (IN `event_id` INT)   SELECT
e.id AS 'event_id',
c.id AS 'city_id',
c.city_name,
e.event_name,
e.date,
e.booking_link
FROM events e
INNER JOIN cities c ON e.city_id=c.id
WHERE e.id=event_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_fav_acc_by_user_id` (IN `user_id` INT)   SELECT
fa.id AS 'fav_acc_id',
c.city_name,
a.id AS 'acc_id',
a.type,
a.location,
a.accommodation_image AS 'acc_img',
a.services,
a.phone
FROM fav_accommodation fa
INNER JOIN accommodation a ON fa.acc_id=a.id
INNER JOIN cities c ON a.city_id=c.id
WHERE fa.user_id=user_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_fav_event_by_user_id` (IN `user_id` INT)   SELECT
fe.id 'fe_id',
c.city_name,
e.event_name,
e.event_img,
e.date,
e.booking_link,
e.phone
FROM fav_events fe
INNER JOIN events e ON fe.event_id=e.id
INNER JOIN cities c ON e.city_id=c.id
WHERE fe.user_id=user_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_fav_places_by_user_id` (IN `user_id` INT)   SELECT
fp.id AS 'fp_id',
p.id AS 'place_id',
c.city_name,
p.type,
p.location,
p.place_img,
p.description,
p.phone
FROM fav_places fp
INNER JOIN places p ON fp.place_id=p.id
INNER JOIN cities c ON p.city_id=c.id
WHERE fp.user_id=user_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_places` ()   SELECT
p.id AS 'place_id',
c.city_name,
p.type,
p.location,
p.place_img,
p.description,
p.phone,
p.status
FROM places p
INNER JOIN cities c ON p.city_id=c.id
WHERE p.status = '1'
ORDER BY p.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_places_admin` ()   SELECT
p.id AS 'place_id',
c.city_name,
p.type,
p.location,
p.place_img,
p.description,
p.status
FROM places p
INNER JOIN cities c ON p.city_id=c.id
ORDER BY p.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_places_by_id` (IN `place_id` INT)   SELECT
p.id AS 'place_id',
c.id AS 'city_id',
c.city_name,
p.type,
p.location,
p.description
FROM places p
INNER JOIN cities c ON p.city_id=c.id
WHERE p.id=place_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_places_user` (IN `user_id` INT)   SELECT
p.id AS 'place_id',
c.city_name,
p.type,
p.location,
p.place_img,
p.description,
p.status
FROM places p
INNER JOIN cities c ON p.city_id=c.id
WHERE p.u_id=user_id ORDER BY p.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_place_types` ()   SELECT
*
FROM place_types$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accommodation`
--

CREATE TABLE `accommodation` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'hotel',
  `location` varchar(255) NOT NULL,
  `accommodation_image` text DEFAULT NULL,
  `services` text NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `u_id` int(11) NOT NULL,
  `status` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodation`
--

INSERT INTO `accommodation` (`id`, `city_id`, `type`, `location`, `accommodation_image`, `services`, `phone`, `u_id`, `status`) VALUES
(4, 3, 'apartment', 'Beautiful Place', './img/accommodation/1745159559_9019.jpg', 'Private parking,Free WiFi', '057696787899', 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `accommodation_types`
--

CREATE TABLE `accommodation_types` (
  `id` int(11) NOT NULL,
  `types` varchar(255) NOT NULL DEFAULT 'hotel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodation_types`
--

INSERT INTO `accommodation_types` (`id`, `types`) VALUES
(1, 'apartment'),
(2, 'chalet'),
(3, 'hotel');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varbinary(255) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `title`, `link`, `image`) VALUES
(6, 'test_app', 0x68747470733a2f2f676f6f676c652e636f6d, './img/app/explore_bg.webp');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`) VALUES
(2, 'Riyadh'),
(3, 'Madina');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `tourist_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `comment_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `booking_link` varchar(255) DEFAULT NULL,
  `event_img` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `u_id` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `city_id`, `event_name`, `date`, `booking_link`, `event_img`, `phone`, `u_id`, `status`) VALUES
(3, 2, 'Nora Santos', '2025-04-22', 'https://google.com', './img/event_/1745159491_4422.jpg', '12312345', 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `fav_accommodation`
--

CREATE TABLE `fav_accommodation` (
  `id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fav_events`
--

CREATE TABLE `fav_events` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fav_places`
--

CREATE TABLE `fav_places` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT 'restaurant',
  `location` varchar(255) NOT NULL,
  `place_img` text DEFAULT NULL,
  `description` text NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `u_id` int(11) NOT NULL,
  `status` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `city_id`, `type`, `location`, `place_img`, `description`, `phone`, `u_id`, `status`) VALUES
(24, 2, 'cafe', 'https://g.co/kgs/39vddFX', './img/place/1745159413_9817.jpeg,./img/place/1745159413_6119.webp,./img/place/1745159413_2697.jpg,./img/place/1745159413_7117.jpg', 'good coffee that is perfect for work :D', '12312345', 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `place_types`
--

CREATE TABLE `place_types` (
  `id` int(11) NOT NULL,
  `types` varchar(255) NOT NULL DEFAULT 'restaurant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `place_types`
--

INSERT INTO `place_types` (`id`, `types`) VALUES
(1, 'restaurant'),
(2, 'cafe');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` enum('admin','tourist','local') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci NOT NULL DEFAULT 'tourist',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', '4297f44b13955235245b2497399d7a93', 'admin', '1'),
(2, 'tourist', 'tourist@gmail.com', '4297f44b13955235245b2497399d7a93', 'tourist', '1'),
(3, 'local', 'local@gmail.com', '4297f44b13955235245b2497399d7a93', 'local', '1'),
(4, 'James', 'tourist1@gmail.com', '4297f44b13955235245b2497399d7a93', 'tourist', '1'),
(6, 'local1', 'local1@gmail.com', '4297f44b13955235245b2497399d7a93', 'local', '1'),
(7, 'tourist2', 'tourist2@gmail.com', '4297f44b13955235245b2497399d7a93', 'tourist', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `accommodation_types`
--
ALTER TABLE `accommodation_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tourist_id` (`tourist_id`),
  ADD KEY `comments_ibfk_1` (`place_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `fav_accommodation`
--
ALTER TABLE `fav_accommodation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fav_accommodation_ibfk_1` (`acc_id`);

--
-- Indexes for table `fav_events`
--
ALTER TABLE `fav_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fav_events_ibfk_1` (`event_id`);

--
-- Indexes for table `fav_places`
--
ALTER TABLE `fav_places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fav_places_ibfk_1` (`place_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `place_types`
--
ALTER TABLE `place_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodation`
--
ALTER TABLE `accommodation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `accommodation_types`
--
ALTER TABLE `accommodation_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fav_accommodation`
--
ALTER TABLE `fav_accommodation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fav_events`
--
ALTER TABLE `fav_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fav_places`
--
ALTER TABLE `fav_places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `place_types`
--
ALTER TABLE `place_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD CONSTRAINT `accommodation_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `accommodation_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`tourist_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `fav_accommodation`
--
ALTER TABLE `fav_accommodation`
  ADD CONSTRAINT `fav_accommodation_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `accommodation` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fav_accommodation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `fav_events`
--
ALTER TABLE `fav_events`
  ADD CONSTRAINT `fav_events_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fav_events_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `fav_places`
--
ALTER TABLE `fav_places`
  ADD CONSTRAINT `fav_places_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fav_places_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `places_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
