-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 06:17 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Database: `task`
--

-- --------------------------------------------------------
--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `content`, `created_at`)
VALUES (
    1,
    1,
    'I feel kinda bored right now ',
    '2024-11-07 12:19:53'
  ),
  (
    2,
    3,
    'Hello this website is awesome ',
    '2024-11-07 12:22:58'
  ),
  (
    3,
    3,
    'PHP is so powerful !!',
    '2024-11-07 13:21:31'
  ),
  (
    4,
    2,
    'Here is my first comment :D',
    '2024-11-07 13:24:09'
  ),
  (
    9,
    3,
    'Hello from zena account ',
    '2024-11-07 21:57:27'
  ),
  (
    10,
    4,
    'this is hassan\r\n',
    '2024-11-08 20:26:22'
  ),
  (
    13,
    2,
    'Hello i feel bored today ',
    '2024-11-22 05:10:56'
  ),
  (
    15,
    5,
    'hello from admin panel',
    '2024-11-24 15:39:28'
  ),
  (
    16,
    6,
    'Hello this is my first post right now on this website !!',
    '2024-11-24 16:56:53'
  );
-- --------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL,
  `profile_description` text DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (
    `id`,
    `user_id`,
    `user_name`,
    `password`,
    `date`,
    `profile_picture`,
    `profile_description`,
    `role`
  )
VALUES (
    1,
    24522977869058,
    'john_doe',
    '123456789',
    '2024-11-07 02:29:28',
    '9203764.png',
    'this is the first profile in the web site !!',
    'user'
  ),
  (
    2,
    197835425684246368,
    'karim',
    '12345',
    '2024-11-19 16:46:37',
    '1730985861.png',
    NULL,
    'user'
  ),
  (
    3,
    771625485254,
    'zena101',
    'zena123',
    '2024-11-07 13:20:08',
    '1730985404.png',
    NULL,
    'user'
  ),
  (
    4,
    9792865,
    'hassan101',
    'hassan',
    '2024-11-08 20:26:45',
    NULL,
    NULL,
    'user'
  ),
  (
    5,
    69157808262787,
    'admin',
    'admin',
    '2024-11-24 15:37:59',
    '1732462679.jpg',
    NULL,
    'admin'
  ),
  (
    6,
    85062,
    'eyad',
    'eyad',
    '2024-11-24 16:57:56',
    '1732467476.png',
    NULL,
    'user'
  );
--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);
--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `date` (`date`),
  ADD KEY `user_name` (`user_name`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 17;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;