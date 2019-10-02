-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 08 mai 2018 à 16:54
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



--
-- Base de données :  `db_project_web`
--

-- --------------------------------------------------------

--
-- Structure de la table `annual_member_fees`
--

DROP TABLE IF EXISTS `annual_member_fees`;
CREATE TABLE IF NOT EXISTS `annual_member_fees` (
  `year` int(11) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `price` double NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `url_photo` varchar(300) DEFAULT NULL,
  `descriptive` varchar(300) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `interested_members`
--

DROP TABLE IF EXISTS `interested_members`;
CREATE TABLE IF NOT EXISTS `interested_members` (
  `login` varchar(30) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`login`,`event_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `login` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `phone` char(10) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `bank_account` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `photo` varchar(60) NOT NULL DEFAULT 'default.png',
  `duty` char(1) NOT NULL,
  `validate` tinyint(1) NOT NULL,
  `role_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `members_training`
--

DROP TABLE IF EXISTS `members_training`;
CREATE TABLE IF NOT EXISTS `members_training` (
  `login` varchar(30) NOT NULL,
  `training_id` int(11) NOT NULL,
  `following_date` datetime NOT NULL,
  PRIMARY KEY (`login`,`training_id`),
  KEY `training_id` (`training_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `member_fees`
--

DROP TABLE IF EXISTS `member_fees`;
CREATE TABLE IF NOT EXISTS `member_fees` (
  `login` varchar(60) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`login`,`year`),
  KEY `year` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `registered_members`
--

DROP TABLE IF EXISTS `registered_members`;
CREATE TABLE IF NOT EXISTS `registered_members` (
  `login` varchar(30) NOT NULL,
  `event_id` int(11) NOT NULL,
  `payed` tinyint(1) NOT NULL,
  PRIMARY KEY (`login`,`event_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `training`
--

DROP TABLE IF EXISTS `training`;
CREATE TABLE IF NOT EXISTS `training` (
  `training_id` int(11) NOT NULL AUTO_INCREMENT,
  `descriptive` varchar(200) NOT NULL,
  PRIMARY KEY (`training_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `training`
--

INSERT INTO `training` (`training_id`, `descriptive`) VALUES
(1, 'Plan d\'entrainement de base');

-- --------------------------------------------------------

--
-- Structure de la table `training_day`
--

DROP TABLE IF EXISTS `training_day`;
CREATE TABLE IF NOT EXISTS `training_day` (
  `training_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `activity` varchar(200) NOT NULL,
  PRIMARY KEY (`training_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `interested_members`
--
ALTER TABLE `interested_members`
  ADD CONSTRAINT `interested_members_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `interested_members_ibfk_2` FOREIGN KEY (`login`) REFERENCES `members` (`login`);

--
-- Contraintes pour la table `members_training`
--
ALTER TABLE `members_training`
  ADD CONSTRAINT `members_training_ibfk_1` FOREIGN KEY (`login`) REFERENCES `members` (`login`),
  ADD CONSTRAINT `members_training_ibfk_2` FOREIGN KEY (`training_id`) REFERENCES `training` (`training_id`);

--
-- Contraintes pour la table `member_fees`
--
ALTER TABLE `member_fees`
  ADD CONSTRAINT `member_fees_ibfk_1` FOREIGN KEY (`login`) REFERENCES `members` (`login`),
  ADD CONSTRAINT `member_fees_ibfk_2` FOREIGN KEY (`year`) REFERENCES `annual_member_fees` (`year`);

--
-- Contraintes pour la table `registered_members`
--
ALTER TABLE `registered_members`
  ADD CONSTRAINT `registered_members_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `registered_members_ibfk_2` FOREIGN KEY (`login`) REFERENCES `members` (`login`);

--
-- Contraintes pour la table `training_day`
--
ALTER TABLE `training_day`
  ADD CONSTRAINT `training_day_ibfk_1` FOREIGN KEY (`training_id`) REFERENCES `training` (`training_id`);
COMMIT;
