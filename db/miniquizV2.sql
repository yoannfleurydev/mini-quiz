-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 05 Décembre 2015 à 16:20
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

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
`access_id` int(11) NOT NULL,
  `access_key` varchar(10) NOT NULL,
  `access_name` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mq_answer`
--

INSERT INTO `mq_answer` (`answer_id`, `answer_content`) VALUES
(1, 'test'),
(2, 'ets'),
(3, 'set'),
(4, 'est'),
(5, 'zet'),
(6, 'test2'),
(7, 'zae'),
(8, 'rzet');

-- --------------------------------------------------------

--
-- Structure de la table `mq_question`
--

CREATE TABLE IF NOT EXISTS `mq_question` (
`question_id` int(11) NOT NULL,
  `question_text` varchar(255) NOT NULL,
  `question_good_answer` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mq_question`
--

INSERT INTO `mq_question` (`question_id`, `question_text`, `question_good_answer`) VALUES
(1, 'test', 1),
(2, 'test2', 2);

-- --------------------------------------------------------

--
-- Structure de la table `mq_quiz`
--

CREATE TABLE IF NOT EXISTS `mq_quiz` (
`quiz_id` int(11) NOT NULL,
  `quiz_title` varchar(60) NOT NULL,
  `quiz_description` varchar(255) DEFAULT NULL,
  `quiz_user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mq_quiz`
--

INSERT INTO `mq_quiz` (`quiz_id`, `quiz_title`, `quiz_description`, `quiz_user_id`) VALUES
(1, 'quiz 1', 'quiz 1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `mq_quizsave`
--

CREATE TABLE IF NOT EXISTS `mq_quizsave` (
`quiz_save_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `quiz_save_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mq_user`
--

CREATE TABLE IF NOT EXISTS `mq_user` (
`user_id` int(11) NOT NULL,
  `user_login` varchar(40) NOT NULL,
  `user_password` varchar(80) NOT NULL,
  `user_access_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mq_user`
--

INSERT INTO `mq_user` (`user_id`, `user_login`, `user_password`, `user_access_id`) VALUES
(1, 'nephi', '$2y$11$s8TKJtlmTTZCE9rn5iApDeE0.YZg6JZ.B4hU3KrVip/Z4e/Kd7Xzm', 2);

-- --------------------------------------------------------

--
-- Structure de la table `question_answer`
--

CREATE TABLE IF NOT EXISTS `question_answer` (
`question_answer_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `question_answer`
--

INSERT INTO `question_answer` (`question_answer_id`, `answer_id`, `question_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 2),
(6, 6, 2),
(7, 7, 2),
(8, 8, 2);

-- --------------------------------------------------------

--
-- Structure de la table `quiz_question`
--

CREATE TABLE IF NOT EXISTS `quiz_question` (
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
`quiz_question_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `quiz_question`
--

INSERT INTO `quiz_question` (`quiz_id`, `question_id`, `quiz_question_id`) VALUES
(1, 1, 1),
(1, 2, 2);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `mq_access`
--
ALTER TABLE `mq_access`
 ADD PRIMARY KEY (`access_id`);

--
-- Index pour la table `mq_answer`
--
ALTER TABLE `mq_answer`
 ADD PRIMARY KEY (`answer_id`);

--
-- Index pour la table `mq_question`
--
ALTER TABLE `mq_question`
 ADD PRIMARY KEY (`question_id`);

--
-- Index pour la table `mq_quiz`
--
ALTER TABLE `mq_quiz`
 ADD PRIMARY KEY (`quiz_id`);

--
-- Index pour la table `mq_quizsave`
--
ALTER TABLE `mq_quizsave`
 ADD PRIMARY KEY (`quiz_save_id`);

--
-- Index pour la table `mq_user`
--
ALTER TABLE `mq_user`
 ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `question_answer`
--
ALTER TABLE `question_answer`
 ADD PRIMARY KEY (`question_answer_id`);

--
-- Index pour la table `quiz_question`
--
ALTER TABLE `quiz_question`
 ADD PRIMARY KEY (`quiz_question_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `mq_access`
--
ALTER TABLE `mq_access`
MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `mq_answer`
--
ALTER TABLE `mq_answer`
MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `mq_question`
--
ALTER TABLE `mq_question`
MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `mq_quiz`
--
ALTER TABLE `mq_quiz`
MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `mq_quizsave`
--
ALTER TABLE `mq_quizsave`
MODIFY `quiz_save_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `mq_user`
--
ALTER TABLE `mq_user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `question_answer`
--
ALTER TABLE `question_answer`
MODIFY `question_answer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `quiz_question`
--
ALTER TABLE `quiz_question`
MODIFY `quiz_question_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
