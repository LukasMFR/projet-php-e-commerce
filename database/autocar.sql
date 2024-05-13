-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 13 mai 2024 à 11:07
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30


DROP DATABASE IF EXISTS autocar;
CREATE DATABASE autocar ;
USE autocar ;
DROP TABLE IF EXISTS admin ;
DROP TABLE IF EXISTS cart ;
DROP TABLE IF EXISTS message ;
DROP TABLE IF EXISTS orders ;
DROP TABLE IF EXISTS products ;
DROP TABLE IF EXISTS puff ;
DROP TABLE IF EXISTS users ;
DROP TABLE IF EXISTS wishlist ;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `autocar`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `profile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `profile`) VALUES
(1, 'admin', 'admin@roadluxury.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'admin.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `item_id` varchar(20) NOT NULL,
  `item_type` varchar(50) NOT NULL CHECK (`item_type` in ('product','puff')),
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `phone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`, `phone`) VALUES
(1, 'UAVjN46f0bvXSKquej8S', 'Paul', 'paul.roux@gmail.com', 'shop', 'good', '+123456789'),
(2, 'UAVjN46f0bvXSKquej8S', 'Paul', 'paul.roux@gmail.com', 'maths,science', 'kk', '+987654321'),
(3, 'UAVjN46f0bvXSKquej8S', 'hillel ohayon', 'ohayonhillel173@gmail.com', 'cscscs', 'scqccqc', '0667524150'),
(4, NULL, 'hillel ohayon', 'ohayonhillel173@gmail.com', 'eapiraoizeh', 'aozirhapozrihzhpriao', '0667524150');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `address_type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `item_id` varchar(36) NOT NULL,
  `item_type` varchar(50) NOT NULL CHECK (`item_type` in ('product','puff')),
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'en cours',
  `payment_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `item_id`, `item_type`, `price`, `qty`, `date`, `status`, `payment_status`) VALUES
('4SJfc2GJY4ekJN45CKbP', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'BLTtlhOgq1cuz7plh4Ia', 'product', 375000.00, 1, '2023-02-28 15:45:00', 'en cours', 'en attente'),
('9vucKr2sSPqcIUidPedP', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'office', 'cash on delivery', 'kun96OpQed6Eww6M1URo', 'product', 220000.00, 1, '2023-02-28 15:45:00', 'en cours', 'en attente'),
('AwQFryy0R7pOuan4iTLa', 'UAVjN46f0bvXSKquej8S', 'hillel ohayon', '0667524150', 'ohayonhillel173@gmail.com', '12 Rue Scandicci, 12, PANTIN, France, 93500', 'home', 'cash on delivery', 'pWY5Mf0987NUdbPoxuBu', 'puff', 12.00, 1, '2024-05-13 08:54:20', 'en cours', 'en attente'),
('Bsatz7miuWWgXMEx5qzW', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'kun96OpQed6Eww6M1URo', 'product', 220000.00, 1, '2023-02-28 15:45:00', 'en cours', 'completee'),
('DStPLCBmD0m0OjAFYlhg', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'jo35YMmBWpvbCMB65UdA', 'product', 10000000.00, 1, '2023-02-28 15:45:00', 'annulee', 'en attente'),
('EYZ94PhWrzea0s9Tdd2J', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'BLTtlhOgq1cuz7plh4Ia', 'product', 375000.00, 1, '2023-02-28 15:45:00', 'annulee', 'en attente'),
('gq2RDUuhaPe7TDcxiGCy', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'g5DLcNHmtHvq3DtJYsCb', 'product', 111997.00, 1, '2023-02-28 15:45:00', 'en cours', 'en attente'),
('Jd0yGYljvlchrTLd5KGQ', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '18 rue Oberkampf, 75011 Paris', 'office', 'credit or debit card', 'BLTtlhOgq1cuz7plh4Ia', 'product', 375000.00, 1, '2023-02-28 15:45:00', 'en cours', 'completee'),
('JqyfHoT9UzR4qcvp3LNJ', 'd5URvsP8VusCXQoCdMBG', 'Camille', '0675001234', 'camille.blanchard@gmail.com', '20 rue Montorgueil, 75001 Paris', 'home', 'credit or debit card', 'BLTtlhOgq1cuz7plh4Ia', 'product', 375000.00, 1, '2023-02-28 15:45:00', 'en cours', 'completee'),
('KRbSyH7ZgbVzWyyZQoiv', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '18 rue Oberkampf, 75011 Paris', 'office', 'credit or debit card', 'uOarNNg0n3KD9OvPtItP', 'product', 10000000.00, 1, '2023-02-28 15:45:00', 'en cours', 'en attente'),
('m69cKTTvnkmSZcodWx0d', 'UAVjN46f0bvXSKquej8S', 'hillel ohayon', '0667524150', 'ohayonhillel173@gmail.com', '12 Rue Scandicci, 12, PANTIN, France, 93500', 'home', 'cash on delivery', 'Wd3or2BwCtKebztba6aV', 'puff', 12.00, 5, '2024-05-13 08:56:01', 'en cours', 'en attente'),
('OGTzld6EmHmNHeXZQkB6', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'uOarNNg0n3KD9OvPtItP', 'product', 10000000.00, 1, '2023-02-28 15:45:00', 'annulee', 'en attente'),
('PnpCGSbod65IEAOxjrFh', 'UAVjN46f0bvXSKquej8S', 'hillel ohayon', '0667524150', 'ohayonhillel173@gmail.com', '12 Rue Scandicci, 12, PANTIN, France, 93500', 'home', 'cash on delivery', '0lKHBlsFPaTpTFlnHUXf', 'puff', 12.00, 1, '2024-05-13 08:54:20', 'en cours', 'en attente'),
('SbriDgXJhvltFEuQxPZQ', 'UAVjN46f0bvXSKquej8S', 'hillel ohayon', '0667524150', 'ohayonhillel173@gmail.com', '12 Rue Scandicci, 12, PANTIN, France, 93500', 'home', 'cash on delivery', 'ugVkMKuH66eqSJFRyhAU', 'puff', 12.00, 2, '2024-05-13 08:56:01', 'en cours', 'en attente'),
('ssJkOanMHQcl3VGW9IfR', 'UAVjN46f0bvXSKquej8S', 'hillel ohayon', '0667524150', 'ohayonhillel173@gmail.com', '12 Rue Scandicci, 12, PANTIN, France, 93500', 'home', 'cash on delivery', 'pWY5Mf0987NUdbPoxuBu', 'puff', 12.00, 3, '2024-05-13 08:55:09', 'en cours', 'en attente'),
('UUFMa328sIAdb3znDXce', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '10 avenue Montaigne, 75008 Paris', 'home', 'credit or debit card', 'kun96OpQed6Eww6M1URo', 'product', 220000.00, 1, '2023-02-28 15:45:00', 'annulee', 'completee'),
('wtyNDfBfSwShC9FXFnbC', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '18 rue Oberkampf, 75011 Paris', 'office', 'credit or debit card', 'aSBHDzG26iXurm6cfoNv', 'product', 699000.00, 1, '2023-02-28 15:45:00', 'en cours', 'en attente'),
('XyoWmad14f2YOWbi11XF', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'aSBHDzG26iXurm6cfoNv', 'product', 699000.00, 1, '2023-02-28 15:45:00', 'annulee', 'en attente'),
('yyD4B276Pg9lfGpRjcr9', 'd5URvsP8VusCXQoCdMBG', 'Camille', '0675045678', 'camille.blanchard@gmail.com', '20 rue Montorgueil, 75001 Paris', 'office', 'credit or debit card', 'jo35YMmBWpvbCMB65UdA', 'product', 10000000.00, 2, '2023-02-28 15:45:00', 'annulee', 'en attente');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `product_detail` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `Modèle` varchar(255) NOT NULL,
  `Année` int(11) NOT NULL,
  `moteur` varchar(255) NOT NULL,
  `kilométrage` int(11) NOT NULL,
  `equipements` text NOT NULL,
  `etat` varchar(255) NOT NULL,
  `pointsforts` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `image3`, `image2`, `product_detail`, `status`, `Modèle`, `Année`, `moteur`, `kilométrage`, `equipements`, `etat`, `pointsforts`) VALUES
('0I8ZbLUgrxn7qWNMzxPE', 'McLaren 720s GT3 X', 330000.00, 'MC3.jpg', 'MC5.jpg', 'MC4.jpg', 'Version extrême du 720s, conçue exclusivement pour une utilisation sur circuit avec des améliorations significatives en termes de performance.', 'inactif', 'McLaren 720s GT3 X', 2021, 'V8 de 4,0 L turbo', 40, 'Cockpit de course, système de télémétrie avancé, freins en carbone-céramique.', 'Neuf', 'Performance de circuit dominante, très limitée en production.'),
('26lPPTjXh9EkNc7WocS5', 'Porsche 911 GT3 R', 253454.00, 'porche.png', 'porche3.jpg', 'porche2.png', 'Conçue pour la compétition, cette Porsche offre des performances de pointe sur piste et sur route.', 'actif', 'Porsche 911 GT3 R', 2022, '4,0 L Flat-6', 80, 'Système de suspension adaptative, freins haute performance, cockpit orienté course.', 'Neuf', 'Excellente dynamique de conduite, puissance impressionnante.'),
('aSBHDzG26iXurm6cfoNv', 'Lamborghini Revuelto', 699000.00, 'lambo4.jpg', 'lambo6.jpg', 'lambo5.jpg', 'Un supercar électrifiant qui combine performance extrême et style audacieux.', 'actif', 'Lamborghini Revuelto', 2023, 'V12 hybride', 75, 'Système infotainment avec écran tactile, intégration smartphone, régulateur de vitesse adaptatif.', 'Neuf', 'Une accélération de 0 à 100 km/h en seulement 2,8 secondes.'),
('bEvIK2PvwOqY4l8nuPTZ', 'Mercedes-AMG GT3 Edition 55', 625000.00, 'mercedes.jpg', 'mercedes5.jpg', 'mercedes4.jpg', 'Une édition spéciale marquant le 55e anniversaire d’AMG, avec des améliorations axées sur la performance et l’exclusivité.', 'inactif', 'Mercedes-AMG GT3 Edition 55', 2022, 'V8 de 4,0 L turbo', 100, 'Cockpit de course, système de sécurité intégré, châssis et suspension sport.', 'Neuf', 'Édition limitée, optimisée pour la compétition et la conduite haute performance.'),
('BLTtlhOgq1cuz7plh4Ia', 'McLaren 720s', 375000.00, 'mc1.jpg', 'mc3.png', 'mc2.jpg', 'Véhicule sportif haute performance alliant design aérodynamique et technologie de pointe.', 'actif', 'McLaren 720s', 2022, 'V8 de 4,0 L', 1000, 'Climatisation automatique bizone, Régulateur de vitesse, Système multimédia avec écran tactile de 8 pouces, Bluetooth, Prises USB, Navigateur GPS, Capteurs de pluie et de lumière', 'Neuf', 'Le 0 à 100 km/h est parcouru en seulement 2,8 secondes'),
('eBbtkVNYiJJKT9mCgYbk', 'Maserati Granturismo', 180000.00, 'maserati1.jpg', 'maserati3.jpg', 'maserati2.jpg', 'Un coupé élégant qui allie confort de luxe à des performances sportives, idéal pour le grand tourisme.', 'actif', 'Maserati Granturismo', 2017, 'V6 de 3,0 L turbo', 85, 'Intérieur cuir, système multimédia avec écran tactile, régulateur de vitesse adaptatif, toit ouvrant.', 'Neuf', 'Confort supérieur, design intemporel.'),
('g5DLcNHmtHvq3DtJYsCb', 'Alpine A110 R', 111997.00, 'alpine.jpg', 'alpine3.jpg', 'alpine2.jpg', 'Voiture sportive légère et agile, optimisée pour les performances de piste.', 'actif', 'Alpine A110 R', 2020, '4 cylindres en ligne de 1,8 L', 1000, 'KIT AERO MP-R', 'Occasion', '0 à 100 km/h en 3,9 sec pour une vitesse de pointe de 285 km/h'),
('jo35YMmBWpvbCMB65UdA', 'Bugatti La Voiture Noire', 10000000.00, 'bugatienoir.jpg', 'bugati3.jpg', 'bugati2.jpg', 'Un chef-d’œuvre moderne rendant hommage au patrimoine de Bugatti, limité à quelques unités.', 'actif', 'Bugatti La Voiture Noire', 2029, '16-cylindres en W quadri-turbo de 8 litres', 10, 'Climatisation automatique bizone, système multimédia avancé, sièges en cuir premium, capteurs de stationnement.', 'Neuf', '0 à 100 km/h en 2,4s'),
('kun96OpQed6Eww6M1URo', 'Lamborghini Urus', 220000.00, 'urus1.jpg', 'urus3.jpg', 'urus2.jpg', 'Un SUV de luxe qui combine la performance d’une supercar avec la praticité d’un véhicule familial.', 'actif', 'Lamborghini Urus', 2018, 'V8 biturbo de 4,0 L', 50, 'Interface multimédia avancée, sièges en cuir avec réglages électriques, caméras de stationnement, système audio premium.', 'Neuf', 'Polyvalence impressionnante, performances hors normes pour un SUV.'),
('rfA9q4uWC2JvzLCRmawT', 'Aston Martin Vantage GT3', 400000.00, 'aston.jpg', 'aston3.jpg', 'aston2.jpg', 'Une voiture de course homologuée pour la route, offrant des performances extrêmes et un design agressif.', 'inactif', 'Aston Martin Vantage GT3', 2023, 'V8 de 4,0 L turbo', 70, 'Système de navigation avancé, sièges sport en cuir, suspension sportive, aérodynamique optimisée.', 'Neuf', 'Capacités de piste exceptionnelles, accélération rapide.'),
('uOarNNg0n3KD9OvPtItP', 'Ferrari SP51', 10000000.00, 'ferariesp51.png', 'ferarie3.jpg', 'ferarie2.png', 'Un roadster exclusif au design saisissant et aux performances époustouflantes, basé sur la 812 GTS.', 'actif', 'Ferrari SP51', 2022, 'V12', 0, 'Intérieur luxueux en cuir, système de navigation avancé, caméra de recul.', 'Neuf', '0 à 100 km/h en moins de 3 secondes'),
('wrJTrzoHsuEwr7hGi3R6', 'Mercedes AMG GT2', 300000.00, 'mercedes1.jpg', 'mercedes3.png', 'mercedes2.jpg', 'Voiture de sport axée sur la performance avec un design élégant et une ingénierie de précision.', 'actif', 'Mercedes AMG GT2', 2023, 'V8 de 4,0 L turbo', 55, 'Sièges sport AMG, système multimédia haut de gamme, aide à la conduite active.', 'Neuf', 'Équilibre parfait entre performance et confort, design agressif.');

-- --------------------------------------------------------

--
-- Structure de la table `puff`
--

CREATE TABLE `puff` (
  `id` char(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_detail` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `goût` varchar(255) NOT NULL,
  `taffe` int(11) NOT NULL,
  `nicotine` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `puff`
--

INSERT INTO `puff` (`id`, `name`, `price`, `image`, `product_detail`, `status`, `goût`, `taffe`, `nicotine`) VALUES
('0lKHBlsFPaTpTFlnHUXf', 'Puff Superéthanol E85', 12.00, 'puff3.jpg', 'A la recherche d’une saveur d\'essences et originale pour votre vapotage ? Découvrez la TurboVape Superéthanol E85 by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Superéthanol E85', 1000, 7.50),
('ICg3StZandimDp1BU1m2', 'Puff Sans Plomb 95', 14.00, 'puff2.jpg', 'A la recherche d’une saveur d\'essences et originale pour votre vapotage ? Découvrez la TurboVape Sans Plomb 95 by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Sans Plomb 95', 1000, 5.00),
('pWY5Mf0987NUdbPoxuBu', 'Puff Gazole', 12.00, 'puff1.jpg', 'A la recherche d’une saveur d\'essences et originale pour votre vapotage ? Découvrez la TurboVape Gazole by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Gazole', 1000, 5.00),
('ugVkMKuH66eqSJFRyhAU', 'Puff électrique', 12.00, 'puff5.jpg', 'A la recherche d’une saveur d\'essences et originale pour votre vapotage ? Découvrez la TurboVape Carburant Electrique by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Electrique', 1000, 1.00),
('Wd3or2BwCtKebztba6aV', 'Puff Supercarburants SP95', 12.00, 'puff4.jpg', 'A la recherche d’une saveur d\'essences et originale pour votre vapotage ? Découvrez la TurboVape Supercarburants SP95 by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Supercarburants SP95', 1000, 10.00),
('wrJTrzoHsuEwr7hGi3R6', 'Puff naturel', 300.00, 'puff6.jpg', 'A la recherche d’une saveur d\'essences et originale pour votre vapotage ?\r\nDécouvrez la TurboVape Gaz Naturelle by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande !', 'actif', 'Gaz Naturelle', 1000, 0.00);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'user',
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `profile_pic`) VALUES
('d5URvsP8VusCXQoCdMBG', 'Camille', 'camille.blanchard@gmail.com', '12345', 'user', NULL),
('GE2LLAWjKATiQRLHaa6O', 'Maxime', 'maxime.petit@gmail.com', '12345', 'user', NULL),
('ir7qjxTxaQm9PM5drpEn', 'Sophie', 'sophie.moreau@gmail.com', 'sophie786', 'user', NULL),
('UAVjN46f0bvXSKquej8S', 'Paul', 'paul.roux@gmail.com', 'paul786', 'user', 'user_profile_images/UAVjN46f0bvXSKquej8S_1714837016.png');

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `item_type` varchar(50) NOT NULL CHECK (`item_type` in ('product','puff')),
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `item_id`, `item_type`, `price`) VALUES
('dSashoVo9Tnp9OJWtR55', '', '26lPPTjXh9EkNc7WocS5', 'product', 253454.00),
('P6AGaMx62hQV36qDvCd1', 'UAVjN46f0bvXSKquej8S', 'Wd3or2BwCtKebztba6aV', 'puff', 12.00);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `puff`
--
ALTER TABLE `puff`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
