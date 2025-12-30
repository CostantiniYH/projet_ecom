-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 27 juil. 2025 à 23:37
-- Version du serveur : 9.1.0
-- Version de PHP : 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `yhc`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_categories`
--

DROP TABLE IF EXISTS `t_categories`;
CREATE TABLE IF NOT EXISTS `t_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_categories`
--

INSERT INTO `t_categories` (`id`, `nom`, `image`) VALUES
(1, 'Immobilier', '../uploads/Immobilier/immobilier.jpg'),
(2, 'Electronique', '../uploads/Electronique/electronique.jpg'),
(3, 'Vêtement', '../uploads/Vêtement/vetement.jpg'),
(4, 'Automobile', '../uploads/Automobile/automobile.jpg'),
(5, 'Electroménager', '../uploads/Electroménager/electromenager.jpg'),
(6, 'Vaisselle', '../uploads/Vaisselle/vaisselle.jpg'),
(7, 'Pierres', '../uploads/Pierres/pierres.jpg'),
(8, 'Cosmétique', '../uploads/Cosmétique/cosmetique.jpg'),
(9, 'Culture', '../uploads/Culture/culture.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `t_images`
--

DROP TABLE IF EXISTS `t_images`;
CREATE TABLE IF NOT EXISTS `t_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_categorie` (`id_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_images`
--

INSERT INTO `t_images` (`id`, `nom`, `image`, `id_categorie`) VALUES
(1, 'Villa piscine', 'uploads/Immobilier/villa_5.jpg', 1),
(2, 'Samsung Galaxie s25+', 'uploads/Electronique/galaxie_s22.jpg', 2),
(3, 'Villa verte', 'uploads/Immobilier/villa_3.jpg', 1),
(4, 'Pierres précieuses bleues', 'uploads/Pierres/pierres_bleues.jpg', 7),
(5, 'Pierres précieuses bleues', 'uploads/Pierres/pierres_bleues.jpg', 7);

-- --------------------------------------------------------

--
-- Structure de la table `t_produits`
--

DROP TABLE IF EXISTS `t_produits`;
CREATE TABLE IF NOT EXISTS `t_produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prix` int NOT NULL,
  `devise` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantite` int NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `id_categorie` int DEFAULT NULL,
  `image` longtext,
  `status` int NOT NULL DEFAULT '1',
  `id_user` int NOT NULL DEFAULT '1',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_categorie` (`id_categorie`),
  KEY `fk_id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_produits`
--

INSERT INTO `t_produits` (`id`, `nom`, `prix`, `devise`, `quantite`, `description`, `id_categorie`, `image`, `status`, `id_user`, `deleted_at`) VALUES
(1, 'Splendide', 20000000, '€', 1, 'Super villa magnifique, weee de ouf et tout.. Et maintenant, la description reste, encore mieux !!', 1, 'uploads/Immobilier/villa_1.jpg', 1, 1, NULL),
(2, 'Samsung Galaxie s25+', 1250, '€', 10, 'Smartphone à la point de la technologie, avec des matériaux de qualité et durable. Smartphone à la point de la technologie, avec des matériaux de qualité et durable.Smartphone à la point de la technologie, avec des matériaux de qualité et durable.Smartpho', 2, 'uploads/Electronique/galaxie_s22.jpg', 1, 1, NULL),
(3, 'BMW serie 1 (next-gen)', 41000, '€', 10, 'Comme d\'habitude bmw ne déçoit pas avec ses voitures de qualité et son design robuste.\r\n', 4, 'uploads/automobile/bmw_serie1.jpg', 1, 1, NULL),
(4, 'DS3(new)', 39000, '€', 6, '4', 4, 'uploads/automobile/ds_3.jpg', 1, 1, NULL),
(5, 'Bugatti : La Voiture noire', 12000000, '€', 5, 'Automobile', 4, 'uploads/automobile/bugatti_la_voiture_noire.jpg', 1, 1, NULL),
(6, 'Bugatti : Mistral', 1000000, '€', 15, 'Super voiture puissante etc. Super voiture puissante etc. Super voiture puissante etc. Super voiture puissante etc. ', 4, 'uploads/automobile/bugatti_mistral.jpg', 1, 1, NULL),
(7, 'Bugatti : Centodieci', 1200000, '€', 13, 'Bugatti hybride une première la marque française. Bugatti hybride une première la marque française. Bugatti hybride une première la marque française. ', 4, 'uploads/automobile/bugatti_centodieci.jpg', 1, 1, NULL),
(8, 'Bugatti : Chiron', 3000000, '€', 7, 'Nouvelle Bugatti chiron sport re dragon. Magnifique bijoux de technologie. ', 4, 'uploads/automobile/bugatti_chiron_red_dragon.jpg', 1, 1, NULL),
(9, 'Bugatti : Divo', 1500000, '€', 20, 'Cousine de la Bugatti Chiron. Tôle en carbone et titane, très solide.', 4, 'uploads/automobile/bugatti_divo.jpg', 1, 1, NULL),
(10, 'Bugatti : Tourbillon', 3000000, '€', 6, 'Ressemble à la Mistral, mais fondamentalement différentes.', 4, 'uploads/automobile/bugatti_tourbillon.jpg', 1, 1, NULL),
(11, 'Bugatti : Veyron GSport', 2200000, '€', 4, 'Première Bugatti moderne revisitée et améliorée. Model sport, cette Bugatti Veyron GrandSport devient nostalgique.', 4, 'uploads/automobile/bugatti_veyron_grandsport.jpg', 1, 1, NULL),
(12, 'Bugatti : Vision GT(Cpt)', 8000000, '€', 2, 'Concept car Bugatti qui n&#039;est finalement point sorti à cause divers problèmes liés à la production d&#039;une telle innovation que nous ne citerons pas ici. Cependant, le concept lui-même est parfait répondrait assurément aux attentes des amateurs de', 4, 'uploads/automobile/bugatti_visionGT.jpg', 1, 1, NULL),
(13, 'Bugatti : Bolide', 15000000, '€', 5, 'Ce bolide signé Bugatti est l\'un des meilleurs au monde. Il a prouvé à maintes reprises ses performances incroyables, et prévoit de devenir le roi de la course hypersport.', 4, 'uploads/automobile/bugatti_bolide.jpg', 1, 1, NULL),
(14, 'Bugatti : Atlantic', 6000000, '€', 8, 'Cette Bugatti offre le privilège de se déplacer en adéquation avec une apparence vestimentaire habillée. Elle donc idéale pour les soirées de prestige, ainsi que les fêtes et bals distingués. On pourrait la surnommée le Smoking en titane.', 4, 'uploads/automobile/bugatti_atlantic.jpg', 1, 1, NULL),
(15, 'Bugatti : 16c Galibier', 4000000, '€', 9, 'Enfin une Bugatti pour la famille. Depuis le temps que nous l\'attendions. Malheureusement, elle n\'est pas en production et reste au statut de concept ou d\'édition limité, mais c\'est la voiture la plus adéquate pour une famille. Spacieuse et extrêmement co', 4, 'uploads/automobile/bugatti_16c_galibier.jpg', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_users`
--

DROP TABLE IF EXISTS `t_users`;
CREATE TABLE IF NOT EXISTS `t_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `societe` varchar(255) DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_users`
--

INSERT INTO `t_users` (`id`, `nom`, `prenom`, `email`, `password`, `telephone`, `societe`, `photo`, `role`) VALUES
(1, 'Costantini', 'Yaacov-hai', 'costantiniyaacov@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$eHJXL28zSVRVc21JZ21PUg$+ynawJjR4cG+4zx+OvPmlQ4BXjvj+lai7uYYt5ypEN0', '0783993291', '|| YHC ||', '../uploads/Immobilier/villa_1.jpg', 'admin'),
(2, 'Costantini', 'Chantal', 'chantal.costantini@free.fr', '$argon2id$v=19$m=65536,t=4,p=1$Lzlza1FvY3pKNG80V0NaYw$wNTSZ0Ip15dj2ec1umy+mzxw5k7iMeq8XjFWugrJefE', '0619925099', 'CC Société', '../uploads/pierres_bleues.jpg', 'user'),
(3, 'Dupont', 'Alexandre', 'dupont.alexandre@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$bXYwVXovUy9LcTFOakRtVg$pdt6x/5bSBYIccfqt+YkrC7HUPJLVQog0Y0aigUuEps', '0134433443', 'Dupont.com', '../uploads/bugatti_divo.jpg', 'user');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
