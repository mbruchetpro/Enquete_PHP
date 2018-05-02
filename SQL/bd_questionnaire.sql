-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 02 mai 2018 à 11:55
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bd_questionnaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rang` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `type_q` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `texte` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `response1` varchar(31) COLLATE utf8_unicode_ci NOT NULL,
  `response2` varchar(31) COLLATE utf8_unicode_ci DEFAULT NULL,
  `response3` varchar(31) COLLATE utf8_unicode_ci DEFAULT NULL,
  `response4` varchar(31) COLLATE utf8_unicode_ci DEFAULT NULL,
  `response5` varchar(31) COLLATE utf8_unicode_ci DEFAULT NULL,
  `defaut` varchar(31) COLLATE utf8_unicode_ci NOT NULL,
  `questionnaire_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6F7494ECE07E8FF` (`questionnaire_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id`, `rang`, `type_q`, `nom`, `texte`, `response1`, `response2`, `response3`, `response4`, `response5`, `defaut`, `questionnaire_id`) VALUES
(1, '014357', 'list', 'Diplôme', 'Quel est votre plus haut diplôme ?', 'Baccalauréat\r', 'Bac +2 (DUT/BTS)\r', 'Bac +3 (Licence)\r', 'Bac +4 (Master 1)\r', 'Bac +5 (Master 2)', '1', 4),
(2, '014454', 'text', 'Qualité', 'Quelle est votre principale qualité ?', 'Curieux', NULL, NULL, NULL, NULL, '1', 4),
(3, '014557', 'combo', 'Intêret', 'Quels sont vos centres d\'intérêt ?', 'Sport\r', 'Musique\r', 'Cinéma\r', 'Lecture\r', 'Informatique', '1', 4),
(4, '070141', 'text', 'Where is brian ?', 'Where is brian ?', 'In the kitchen', NULL, NULL, NULL, NULL, '1', 5);

-- --------------------------------------------------------

--
-- Structure de la table `questionnaire`
--

DROP TABLE IF EXISTS `questionnaire`;
CREATE TABLE IF NOT EXISTS `questionnaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(124) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `questionnaire`
--

INSERT INTO `questionnaire` (`id`, `name`, `display_name`, `description`) VALUES
(4, 'Recrutement', 'Test 1 pour recrutement salariés', NULL),
(5, 'Anglais', 'Test 1 pour étudiant deuxième année', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_B6F7494ECE07E8FF` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaire` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
