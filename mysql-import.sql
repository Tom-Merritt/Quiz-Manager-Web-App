-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2021 at 09:12 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz-manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answer_ID` int(11) NOT NULL,
  `answer_order` int(11) NOT NULL,
  `question_FK` int(11) NOT NULL,
  `answer` char(30) NOT NULL,
  `correct` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_ID`, `answer_order`, `question_FK`, `answer`, `correct`) VALUES
(98, 2, 190, 'Example Answer 3', 0),
(97, 1, 191, 'Example Answer', 0),
(96, 3, 190, 'Example Answer 3', 0),
(95, 2, 190, 'Example Answer 2', 0),
(94, 1, 190, 'Example Answer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `questions_ID` int(11) NOT NULL,
  `question_order` int(11) NOT NULL,
  `quiz_FK` int(11) NOT NULL,
  `question` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`questions_ID`, `question_order`, `quiz_FK`, `question`) VALUES
(191, 2, 30, 'Example Question 1'),
(190, 1, 30, 'Example Question');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_ID` int(11) NOT NULL,
  `quiz_name` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_ID`, `quiz_name`) VALUES
(32, 'English'),
(31, 'Science'),
(30, 'Maths');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(11) NOT NULL,
  `user_name` char(30) NOT NULL,
  `password` varchar(250) NOT NULL,
  `permission_level` char(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `user_name`, `password`, `permission_level`) VALUES
(1, 'Tom', '$2y$10$VqHc2eJbNpK6d3heXVT1X.7KZDuiQmUaMj2s8RQGcwKA7UfnaDFCi', 'Edit'),
(2, 'Dan', '$2y$10$VqHc2eJbNpK6d3heXVT1X.7KZDuiQmUaMj2s8RQGcwKA7UfnaDFCi', 'View'),
(3, 'Simon', '$2y$10$VqHc2eJbNpK6d3heXVT1X.7KZDuiQmUaMj2s8RQGcwKA7UfnaDFCi', 'Restricted');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_ID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`questions_ID`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `questions_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
