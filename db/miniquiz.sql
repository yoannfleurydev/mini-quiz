-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 23, 2015 at 04:05 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miniquiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `mq_access`
--

CREATE TABLE `mq_access` (
  `access_id` int(11) NOT NULL,
  `access_key` varchar(10) NOT NULL,
  `access_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mq_answer`
--

CREATE TABLE `mq_answer` (
  `answer_id` int(11) NOT NULL,
  `answer_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mq_question`
--

CREATE TABLE `mq_question` (
  `question_id` int(11) NOT NULL,
  `question_text` varchar(255) NOT NULL,
  `question_good_answer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mq_quiz`
--

CREATE TABLE `mq_quiz` (
  `quiz_id` int(11) NOT NULL,
  `quiz_title` varchar(60) NOT NULL,
  `quiz_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mq_user`
--

CREATE TABLE `mq_user` (
  `user_id` int(11) NOT NULL,
  `user_login` varchar(40) NOT NULL,
  `user_password` varchar(80) NOT NULL,
  `user_access_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mq_user`
--

INSERT INTO `mq_user` (`user_id`, `user_login`, `user_password`, `user_access_id`) VALUES
(6, 'nephi', '$2y$11$8gFfKap9sODlrFTyWUU.COjpcnez8ek0.zAtM8Y0NQH6DYDiUF4AS', 0);

-- --------------------------------------------------------

--
-- Table structure for table `question_answer`
--

CREATE TABLE `question_answer` (
  `question_answer_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

CREATE TABLE `quiz_question` (
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mq_access`
--
ALTER TABLE `mq_access`
  ADD PRIMARY KEY (`access_id`);

--
-- Indexes for table `mq_question`
--
ALTER TABLE `mq_question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `mq_quiz`
--
ALTER TABLE `mq_quiz`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `mq_user`
--
ALTER TABLE `mq_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD PRIMARY KEY (`quiz_question_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mq_access`
--
ALTER TABLE `mq_access`
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mq_question`
--
ALTER TABLE `mq_question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mq_quiz`
--
ALTER TABLE `mq_quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mq_user`
--
ALTER TABLE `mq_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `quiz_question_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
