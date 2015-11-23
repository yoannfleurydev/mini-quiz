-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 23 Novembre 2015 à 16:55
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `miniquiz`
--

-- --------------------------------------------------------

--
-- Structure de la table `mq_access`
--

CREATE TABLE IF NOT EXISTS `mq_access` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_key` varchar(10) NOT NULL,
  `access_name` varchar(40) NOT NULL,
  PRIMARY KEY (`access_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;

--
-- Contenu de la table `mq_access`
--

INSERT INTO `mq_access` (`access_id`, `access_key`, `access_name`) VALUES
(1, 'ADMIN', 'Administrateur'),
(2, 'USER', 'Utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `mq_answer`
--

CREATE TABLE IF NOT EXISTS `mq_answer` (
  `answer_id` int(11) NOT NULL,
  `answer_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mq_question`
--

CREATE TABLE IF NOT EXISTS `mq_question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` varchar(255) NOT NULL,
  `question_good_answer` int(11) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `mq_quiz`
--

CREATE TABLE IF NOT EXISTS `mq_quiz` (
  `quiz_id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_title` varchar(60) NOT NULL,
  `quiz_user_id` int(11) NOT NULL,
  PRIMARY KEY (`quiz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `mq_user`
--

CREATE TABLE IF NOT EXISTS `mq_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(40) NOT NULL,
  `user_password` varchar(80) NOT NULL,
  `user_access_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `question_answer`
--

CREATE TABLE IF NOT EXISTS `question_answer` (
  `question_answer_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_question`
--

CREATE TABLE IF NOT EXISTS `quiz_question` (
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`quiz_question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
