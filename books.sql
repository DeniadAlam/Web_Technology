-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 07:03 PM
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
-- Database: `library_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `fees` decimal(10,2) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `book_name`, `category`, `fees`, `author_name`, `image`) VALUES
(2, 'Alchemist', 'story', 300.00, 'Paulo Coelho', 'bookimages/Alchemist.jpg'),
(3, 'Blindsight', 'science', 255.00, 'Peter Watts', 'bookimages/Blindsight.jpg'),
(4, 'Let Us C++', 'science', 365.00, 'New Delhi : BPB Publications', 'bookimages/C++.jpg'),
(5, 'The Little Prince', 'story', 265.00, 'Antoine de Saint-Exupéry', 'bookimages/Little Prince.jpg'),
(6, 'Project Hail Mary', 'science', 300.00, 'Andy Weir', 'bookimages/ProjectHailMary.jpg'),
(7, 'Jonathan Livingston Seagull', 'science', 556.00, 'Richard Bach', 'bookimages/Seagull.jpg'),
(8, 'Children of Time', 'story', 345.00, 'Adrian Tchaikovsky', 'bookimages/Children of Time.jpg'),
(9, 'Dune', 'science', 225.00, 'Frank Herbert', 'bookimages/Dune.jpg'),
(10, 'Leviathan Wakes', 'science', 495.00, 'James S.A. Corey', 'bookimages/Leviathan_Wakes.jpg'),
(11, 'Life of Pi', 'story', 335.00, 'Yann Martel', 'bookimages/LifeOfPi.jpg'),
(12, 'Neuromancer', 'science', 455.00, 'William Gibson', 'bookimages/Neuromancer.jpg'),
(13, 'Way of the Peaceful Warrior', 'story', 435.00, 'Dan Millman', 'bookimages/Peaceful Warrior.jpg'),
(14, 'Stranger in a Strange Land', 'story', 555.00, 'Robert A. Heinlein', 'bookimages/Stranger in a Strange Land.jpg'),
(15, 'The Three-Body Problem', 'science', 445.00, 'Liu Cixin', 'bookimages/The Three-Body Problem.jpg'),
(16, 'The Left Hand of Darkness', 'science', 125.00, 'Ursula K. Le Guin', 'bookimages/TheLeftHandOfDarkness.jpg'),
(17, 'The Road', 'story', 335.00, 'Cormac McCarthy', 'bookimages/The-road.jpg'),
(19, 'Brida', 'story', 195.00, 'Paulo Coelho', 'bookimages/Brida.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
