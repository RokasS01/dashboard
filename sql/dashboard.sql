-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 19 jan. 2024 à 21:13
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dashboard`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `etat` varchar(255) DEFAULT NULL,
  `nom_compte` varchar(255) DEFAULT NULL,
  `fonds` float DEFAULT NULL,
  `mois_preced` float DEFAULT NULL,
  `creation` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déclencheurs `user`
--
DROP TRIGGER IF EXISTS `after_insert_user`;
DELIMITER $$
CREATE TRIGGER `after_insert_user` AFTER INSERT ON `user` FOR EACH ROW BEGIN
    -- Compte courant avec 100€
    INSERT INTO `compte` (`user_id`, `etat`, `nom_compte`, `fonds`, `mois_preced`, `creation`) VALUES (NEW.ID, 'Actif', 'Compte Courant', 100.00, 100.00, CURDATE());

    -- Livret A avec 10€
    INSERT INTO `compte` (`user_id`, `etat`, `nom_compte`, `fonds`, `mois_preced`, `creation`) VALUES (NEW.ID, 'Actif', 'Livret A', 10.00, 10.00, CURDATE());

    -- Livret jeune avec 10€
    INSERT INTO `compte` (`user_id`, `etat`, `nom_compte`, `fonds`, `mois_preced`, `creation`) VALUES (NEW.ID, 'Actif', 'Livret Jeune', 10.00, 10.00, CURDATE());
END
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
