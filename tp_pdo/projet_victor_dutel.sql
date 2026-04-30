-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 30 avr. 2026 à 14:35
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_victor_dutel`
--

-- --------------------------------------------------------

--
-- Structure de la table `calendrier`
--

DROP TABLE IF EXISTS `calendrier`;
CREATE TABLE IF NOT EXISTS `calendrier` (
  `id_calendrier` int NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` text COLLATE utf8mb4_bin NOT NULL,
  `campus_varchar` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `id_formation` int NOT NULL,
  PRIMARY KEY (`id_calendrier`),
  KEY `contrainte 10` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `calendrier`
--

INSERT INTO `calendrier` (`id_calendrier`, `date_debut`, `date_fin`, `campus_varchar`, `id_formation`) VALUES
(1, '2022-09-01', 'ZA02I29292', 'Reims', 5);

-- --------------------------------------------------------

--
-- Structure de la table `campus`
--

DROP TABLE IF EXISTS `campus`;
CREATE TABLE IF NOT EXISTS `campus` (
  `id_campus` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `telephone` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `numero_rue` int NOT NULL,
  `rue` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `code_postal` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `ville` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_campus`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `campus`
--

INSERT INTO `campus` (`id_campus`, `nom`, `telephone`, `numero_rue`, `rue`, `code_postal`, `ville`) VALUES
(1, 'IRIS_Reims', '0473840282', 19, 'rue du cadran saint Pierre', '51100', 'Reims'),
(2, 'IRIS_Paris', '0473840282', 8, 'rue dlzkzppsk', '75100', 'Paris'),
(3, 'IRIS_Strasbourg', '0473840282', 63, 'rue Anatole France', '68294', 'Strasbourg');

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

DROP TABLE IF EXISTS `candidature`;
CREATE TABLE IF NOT EXISTS `candidature` (
  `id_candidature` int NOT NULL AUTO_INCREMENT,
  `etat` varchar(25) COLLATE utf8mb4_bin NOT NULL,
  `date_candidature` date DEFAULT NULL,
  `id_eleve` int DEFAULT NULL,
  `id_offre` int NOT NULL,
  PRIMARY KEY (`id_candidature`),
  KEY `id_eleve` (`id_eleve`),
  KEY `id_eleve_2` (`id_eleve`),
  KEY `id_offre` (`id_offre`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `candidature`
--

INSERT INTO `candidature` (`id_candidature`, `etat`, `date_candidature`, `id_eleve`, `id_offre`) VALUES
(1, 'En attente', '2025-11-14', 3, 2),
(2, 'Acceptée', '2025-11-14', 1, 1),
(21, 'Acceptée', '2025-12-06', 1, 2),
(22, 'Refusée', '2025-12-06', 3, 5),
(23, 'En attente', '2025-12-06', 3, 1),
(24, 'Refusée', '2025-12-06', 1, 6),
(25, 'Acceptée', '2025-12-06', 1, 4),
(26, 'Acceptée', '2025-11-14', 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `creation_calendrier`
--

DROP TABLE IF EXISTS `creation_calendrier`;
CREATE TABLE IF NOT EXISTS `creation_calendrier` (
  `id_creation` int NOT NULL AUTO_INCREMENT,
  `id_personnel` int NOT NULL,
  `id_formation` int NOT NULL,
  PRIMARY KEY (`id_creation`),
  KEY `contrainte 7` (`id_personnel`),
  KEY `contrainte 8` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `creation_calendrier`
--

INSERT INTO `creation_calendrier` (`id_creation`, `id_personnel`, `id_formation`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `id_eleve` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `telephone` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `mdp` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `civilite` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `numero_rue` int NOT NULL,
  `rue` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `code_postal` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `ville` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `diplome` varchar(25) COLLATE utf8mb4_bin NOT NULL,
  `cv` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `lettre_motivation` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_eleve`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `eleve`
--

INSERT INTO `eleve` (`id_eleve`, `nom`, `prenom`, `email`, `telephone`, `mdp`, `civilite`, `date_naissance`, `numero_rue`, `rue`, `code_postal`, `ville`, `diplome`, `cv`, `lettre_motivation`) VALUES
(1, 'DUTEL', 'Victor', 'victor.dutel@mediaschool.me', '0628038204', 'b92e3496457bb50df1d0fc0aa11fe33b', 'M', '2006-10-01', 6, 'rue de ntm', '51476', 'Villers-Marmery', 'Bac', 'CV', 'Lettre'),
(3, 'Poupart', 'Kylian', 'kylian.poupart@gmail.net', '0374852945', 'c903c654c97ff8ac53a77ced570d1aaf', 'M', '2025-11-14', 93, 'alfred pennyworth', '25387', 'Reims', 'Bac', 'CV de Kylian', 'OSEF');

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE IF NOT EXISTS `entreprise` (
  `id_entreprise` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `siret` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `telephone` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `mdp` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `secteur_activite` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `numero_rue` int NOT NULL,
  `rue` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `code_postal` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `ville` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_entreprise`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`id_entreprise`, `nom`, `siret`, `email`, `telephone`, `mdp`, `secteur_activite`, `numero_rue`, `rue`, `code_postal`, `ville`) VALUES
(1, 'Google', '187327889', 'google@gmail.com', '0938402482', 'b92e3496457bb50df1d0fc0aa11fe33b', 'web', 8, 'izjeffeklz', '63782', 'Paris'),
(2, 'Amazon', '74126843', 'amazon@gmail.com', '0637299488', 'b92e3496457bb50df1d0fc0aa11fe33b', 'vente en ligne', 84, 'ojEZCOEZcznno', '51100', 'Paris'),
(3, 'Tesla', '84628828', 'tesla@musk.com', '0835823764', 'b92e3496457bb50df1d0fc0aa11fe33b', 'money, money, money', 8000000, 'Rue je suis riche et pas toi', '35209', 'Je possède des thunes');

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `id_formation` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `niveau` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `duree` int NOT NULL,
  `prix` decimal(6,2) NOT NULL,
  `programme_pdf` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `id_campus` int NOT NULL,
  PRIMARY KEY (`id_formation`),
  KEY `contrainte 11` (`id_campus`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`id_formation`, `nom`, `niveau`, `duree`, `prix`, `programme_pdf`, `id_campus`) VALUES
(5, 'BTS SIO', 'Bac +2', 2, 5590.00, 'CEKNZCIEZienciei', 1),
(6, 'Bachelor', 'Bac +3', 1, 7000.00, 'programme_bachelor.pdf', 2);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id_inscription` int NOT NULL AUTO_INCREMENT,
  `date_inscription` date NOT NULL,
  `etat` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `id_eleve` int DEFAULT NULL,
  `id_formation` int NOT NULL,
  `id_personnel` int NOT NULL,
  PRIMARY KEY (`id_inscription`),
  KEY `contrainte 4` (`id_eleve`),
  KEY `contrainte 5` (`id_personnel`),
  KEY `contrainte 9` (`id_formation`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id_inscription`, `date_inscription`, `etat`, `id_eleve`, `id_formation`, `id_personnel`) VALUES
(1, '2025-11-15', 'Acceptée', 1, 5, 1),
(2, '2025-11-15', 'En attente', 3, 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `offre`
--

DROP TABLE IF EXISTS `offre`;
CREATE TABLE IF NOT EXISTS `offre` (
  `id_offre` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `duree` int NOT NULL,
  `unite_duree` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `salaire` decimal(6,2) NOT NULL,
  `id_entreprise` int NOT NULL,
  PRIMARY KEY (`id_offre`),
  KEY `id_entreprise` (`id_entreprise`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `offre`
--

INSERT INTO `offre` (`id_offre`, `nom`, `type`, `duree`, `unite_duree`, `date_creation`, `description`, `salaire`, `id_entreprise`) VALUES
(1, 'Développeur', 'Stage', 6, 'M', '2025-11-14 16:39:45', 'venez développer', 2050.00, 1),
(2, 'Livreur', 'CDI', 0, '0', '2025-11-14 16:39:45', 'jvezivnezcnezioni', 1450.00, 2),
(4, 'Manager', 'CDD', 3, 'M', '2026-02-18 14:50:21', 'Meneur d\'équipe', 3750.00, 1),
(5, 'Livreur', 'CDD', 1, 'A', '2026-02-18 14:50:21', '', 0.00, 2),
(6, 'CEO', 'CDI', 10, 'A', '2026-02-18 14:50:21', 'Génie du business', 9999.99, 1),
(7, 'UI/UX Designer', 'CDD', 2, 'A', '2026-02-19 14:22:26', 'Recherchons UI/UX Designer', 2340.00, 1),
(11, 'UI/UX Designer', 'CDD', 2, 'A', '2026-02-19 14:22:26', 'Recherchons UI/UX Designer', 2340.00, 1),
(12, 'UI/UX Designer', 'CDD', 2, 'A', '2026-02-19 14:22:26', 'Recherchons UI/UX Designer', 2340.00, 1),
(13, 'UI/UX Designer', 'CDD', 2, 'A', '2026-02-19 14:22:26', 'Recherchons UI/UX Designer', 2340.00, 1);

-- --------------------------------------------------------

--
-- Structure de la table `personnel_mediaschool`
--

DROP TABLE IF EXISTS `personnel_mediaschool`;
CREATE TABLE IF NOT EXISTS `personnel_mediaschool` (
  `id_personnel` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `telephone` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `mdp` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `civilite` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `date_naissance` date NOT NULL,
  `numero_rue` int NOT NULL,
  `rue` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `code_postal` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `ville` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `id_poste` int NOT NULL,
  PRIMARY KEY (`id_personnel`),
  KEY `contrainte 6` (`id_poste`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `personnel_mediaschool`
--

INSERT INTO `personnel_mediaschool` (`id_personnel`, `nom`, `prenom`, `email`, `telephone`, `mdp`, `civilite`, `date_naissance`, `numero_rue`, `rue`, `code_postal`, `ville`, `id_poste`) VALUES
(1, 'Broussard', 'Victor', 'victor.broussard@mediaschool.me', '0938402482', 'b92e3496457bb50df1d0fc0aa11fe33b', 'M', '2025-11-12', 9, 'dziesbefenzifneis', '51100', 'Reims', 3),
(2, 'Fagnière', 'Mickael', 'Micke.fa@mediaschool.me', '0637299488', 'b1376f922a0be205002498095c62e69bdd413c36', 'M', '2025-04-14', 26, 'ciezjeznidznin', '51100', 'Reims', 1);

-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

DROP TABLE IF EXISTS `poste`;
CREATE TABLE IF NOT EXISTS `poste` (
  `id_poste` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_poste`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `poste`
--

INSERT INTO `poste` (`id_poste`, `nom`) VALUES
(1, 'Directeur'),
(2, 'Secrétaire'),
(3, 'CPE');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `calendrier`
--
ALTER TABLE `calendrier`
  ADD CONSTRAINT `contrainte 10` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `candidature`
--
ALTER TABLE `candidature`
  ADD CONSTRAINT `contrainte 2` FOREIGN KEY (`id_offre`) REFERENCES `offre` (`id_offre`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `contrainte 3` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `creation_calendrier`
--
ALTER TABLE `creation_calendrier`
  ADD CONSTRAINT `contrainte 7` FOREIGN KEY (`id_personnel`) REFERENCES `personnel_mediaschool` (`id_personnel`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `contrainte 8` FOREIGN KEY (`id_formation`) REFERENCES `calendrier` (`id_calendrier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `contrainte 11` FOREIGN KEY (`id_campus`) REFERENCES `campus` (`id_campus`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `contrainte 4` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `contrainte 5` FOREIGN KEY (`id_personnel`) REFERENCES `personnel_mediaschool` (`id_personnel`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `contrainte 9` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `offre`
--
ALTER TABLE `offre`
  ADD CONSTRAINT `contrainte 1` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id_entreprise`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `personnel_mediaschool`
--
ALTER TABLE `personnel_mediaschool`
  ADD CONSTRAINT `contrainte 6` FOREIGN KEY (`id_poste`) REFERENCES `poste` (`id_poste`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
