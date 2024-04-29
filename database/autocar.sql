-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 29 avr. 2024 à 09:43
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30


DROP DATABASE IF EXISTS autocar_correct_types;
CREATE DATABASE autocar_correct_types ;
USE autocar_correct_types ;
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
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
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
  `product_id` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL,
  `qty` varchar(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
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
(1, '0', 'Paul', 'paul.roux@gmail.com', 'shop', 'good', '+123456789'),
(2, 'UAVjN46f0bvXSKquej8S', 'Paul', 'paul.roux@gmail.com', 'maths,science', 'kk', '+987654321');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `address_type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL,
  `qty` varchar(2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'in progress',
  `payment_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `product_id`, `price`, `qty`, `date`, `status`, `payment_status`) VALUES
('EYZ94PhWrzea0s9Tdd2J', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'BLTtlhOgq1cuz7plh4Ia', '123', '1', '2023-02-28', 'annulee', 'en attente'),
('DStPLCBmD0m0OjAFYlhg', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'jo35YMmBWpvbCMB65UdA', '160', '1', '2023-02-28', 'annulee', 'en attente'),
('XyoWmad14f2YOWbi11XF', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'aSBHDzG26iXurm6cfoNv', '50', '1', '2023-02-28', 'annulee', 'en attente'),
('OGTzld6EmHmNHeXZQkB6', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'uOarNNg0n3KD9OvPtItP', '80', '1', '2023-02-28', 'annulee', 'en attente'),
('UUFMa328sIAdb3znDXce', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '10 avenue Montaigne, 75008 Paris', 'home', 'credit or debit card', 'kun96OpQed6Eww6M1URo', '120', '1', '2023-02-28', 'annulee', 'completee'),
('Bsatz7miuWWgXMEx5qzW', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'kun96OpQed6Eww6M1URo', '120', '1', '2023-02-28', 'en cours', 'completee'),
('4SJfc2GJY4ekJN45CKbP', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'BLTtlhOgq1cuz7plh4Ia', '123', '1', '2023-02-28', 'en cours', 'en attente'),
('Jd0yGYljvlchrTLd5KGQ', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '18 rue Oberkampf, 75011 Paris', 'office', 'credit or debit card', 'BLTtlhOgq1cuz7plh4Ia', '123', '1', '2023-02-28', 'en cours', 'completee'),
('wtyNDfBfSwShC9FXFnbC', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '18 rue Oberkampf, 75011 Paris', 'office', 'credit or debit card', 'aSBHDzG26iXurm6cfoNv', '50', '1', '2023-02-28', 'en cours', 'en attente'),
('KRbSyH7ZgbVzWyyZQoiv', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '18 rue Oberkampf, 75011 Paris', 'office', 'credit or debit card', 'uOarNNg0n3KD9OvPtItP', '80', '1', '2023-02-28', 'en cours', 'en attente'),
('9vucKr2sSPqcIUidPedP', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'office', 'cash on delivery', 'kun96OpQed6Eww6M1URo', '120', '1', '2023-02-28', 'en cours', 'en attente'),
('gq2RDUuhaPe7TDcxiGCy', 'UAVjN46f0bvXSKquej8S', 'Paul', '0675001234', 'paul.roux@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'home', 'cash on delivery', 'g5DLcNHmtHvq3DtJYsCb', '80', '1', '2023-02-28', 'en cours', 'en attente'),
('JqyfHoT9UzR4qcvp3LNJ', 'd5URvsP8VusCXQoCdMBG', 'Camille', '0675001234', 'camille.blanchard@gmail.com', '20 rue Montorgueil, 75001 Paris', 'home', 'credit or debit card', 'BLTtlhOgq1cuz7plh4Ia', '123', '1', '2023-02-28', 'en cours', 'completee'),
('yyD4B276Pg9lfGpRjcr9', 'd5URvsP8VusCXQoCdMBG', 'Camille', '0675045678', 'camille.blanchard@gmail.com', '20 rue Montorgueil, 75001 Paris', 'office', 'credit or debit card', 'jo35YMmBWpvbCMB65UdA', '160', '2', '2023-02-28', 'annulee', 'en attente');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `product_detail` varchar(500) NOT NULL,
  `status` varchar(100) NOT NULL,
  `Modèle` varchar(255) NOT NULL,
  `Année` varchar(255) NOT NULL,
  `moteur` varchar(255) NOT NULL,
  `kilométrage` varchar(255) NOT NULL,
  `equipements` varchar(255) NOT NULL,
  `etat` varchar(255) NOT NULL,
  `pointsforts` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `image3`, `image2`, `product_detail`, `status`, `Modèle`, `Année`, `moteur`, `kilométrage`, `equipements`, `etat`, `pointsforts`) VALUES
('BLTtlhOgq1cuz7plh4Ia', 'McLaren 720s', '375 000', 'mc1.jpg', 'mc3.png', 'mc2.jpg', 'Véhicule sportif haute performance alliant design aérodynamique et technologie de pointe.', 'actif', 'McLaren 720s', '2022', 'V8 de 4,0 L', '1000 Km', 'Climatisation automatique bizone, Régulateur de vitesse, Système multimédia avec écran tactile de 8 pouces, Bluetooth, Prises USB, Navigateur GPS, Capteurs de pluie et de lumière', 'Neuf', 'Le 0 à 100 km/h est parcouru en seulement 2,8 secondes'),
('jo35YMmBWpvbCMB65UdA', 'Bugatti La Voiture Noire', '10 000 000', 'bugatienoir.jpg', 'bugati3.jpg', 'bugati2.jpg', 'Un chef-d’œuvre moderne rendant hommage au patrimoine de Bugatti, limité à quelques unités.', 'actif', 'Bugatti La Voiture Noire', '2029', '16-cylindres en W quadri-turbo de 8 litres', '10 Km', 'Climatisation automatique bizone, système multimédia avancé, sièges en cuir premium, capteurs de stationnement.', 'Neuf', '0 à 100 km/h en 2,4s'),
('aSBHDzG26iXurm6cfoNv', 'Lamborghini Revuelto', '699 000', 'lambo4.jpg', 'lambo6.jpg', 'lambo5.jpg', 'Un supercar électrifiant qui combine performance extrême et style audacieux.', 'actif', 'Lamborghini Revuelto', '2023', 'V12 hybride', '75 km', 'Système infotainment avec écran tactile, intégration smartphone, régulateur de vitesse adaptatif.', 'Neuf', 'Une accélération de 0 à 100 km/h en seulement 2,8 secondes.'),
('g5DLcNHmtHvq3DtJYsCb', 'Alpine A110 R', '111 997', 'alpine.jpg', 'alpine3.jpg', 'alpine2.jpg', 'Voiture sportive légère et agile, optimisée pour les performances de piste.', 'actif', 'Alpine A110 R', '2020', '4 cylindres en ligne de 1,8 L', '1000 Km', 'KIT AERO MP-R', 'Occasion', '0 à 100 km/h en 3,9 sec pour une vitesse de pointe de 285 km/h'),
('uOarNNg0n3KD9OvPtItP', 'Ferrari SP51', '10 000 000', 'ferariesp51.png', 'ferarie3.jpg', 'ferarie2.png', 'Un roadster exclusif au design saisissant et aux performances époustouflantes, basé sur la 812 GTS.', 'actif', 'Ferrari SP51', '2022', 'V12', '0 Km', 'Intérieur luxueux en cuir, système de navigation avancé, caméra de recul.', 'Neuf', '0 à 100 km/h en moins de 3 secondes'),
('26lPPTjXh9EkNc7WocS5', 'Porsche 911 GT3 R', '253 454', 'porche.png', 'porche3.jpg', 'porche2.png', 'Conçue pour la compétition, cette Porsche offre des performances de pointe sur piste et sur route.', 'actif', 'Porsche 911 GT3 R', '2022', '4,0 L Flat-6', '80 km', 'Système de suspension adaptative, freins haute performance, cockpit orienté course.', 'Neuf', 'Excellente dynamique de conduite, puissance impressionnante.'),
('kun96OpQed6Eww6M1URo', 'Lamborghini Urus', '220 000', 'urus1.jpg', 'urus3.jpg', 'urus2.jpg', 'Un SUV de luxe qui combine la performance d’une supercar avec la praticité d’un véhicule familial.', 'actif', 'Lamborghini Urus', '2018', 'V8 biturbo de 4,0 L', '50 km', 'Interface multimédia avancée, sièges en cuir avec réglages électriques, caméras de stationnement, système audio premium.', 'Neuf', 'Polyvalence impressionnante, performances hors normes pour un SUV.'),
('bEvIK2PvwOqY4l8nuPTZ', 'Mercedes-AMG GT3 Edition 55', '625 000', 'mercedes.jpg', 'mercedes5.jpg', 'mercedes4.jpg', 'Une édition spéciale marquant le 55e anniversaire d’AMG, avec des améliorations axées sur la performance et l’exclusivité.', 'inactif', 'Mercedes-AMG GT3 Edition 55', '2022', 'V8 de 4,0 L turbo', '100 km', 'Cockpit de course, système de sécurité intégré, châssis et suspension sport.', 'Neuf', 'Édition limitée, optimisée pour la compétition et la conduite haute performance.'),
('eBbtkVNYiJJKT9mCgYbk', 'Maserati Granturismo', '180 000', 'maserati1.jpg', 'maserati3.jpg', 'maserati2.jpg', 'Un coupé élégant qui allie confort de luxe à des performances sportives, idéal pour le grand tourisme.', 'actif', 'Maserati Granturismo', '2017', 'V6 de 3,0 L turbo', '85 km', 'Intérieur cuir, système multimédia avec écran tactile, régulateur de vitesse adaptatif, toit ouvrant.', 'Neuf', 'Confort supérieur, design intemporel.'),
('rfA9q4uWC2JvzLCRmawT', 'Aston Martin Vantage GT3', '400 000', 'aston.jpg', 'aston3.jpg', 'aston2.jpg', 'Une voiture de course homologuée pour la route, offrant des performances extrêmes et un design agressif.', 'inactif', 'Aston Martin Vantage GT3', '2023', 'V8 de 4,0 L turbo', '70 km', 'Système de navigation avancé, sièges sport en cuir, suspension sportive, aérodynamique optimisée.', 'Neuf', 'Capacités de piste exceptionnelles, accélération rapide.'),
('0I8ZbLUgrxn7qWNMzxPE', 'McLaren 720s GT3 X', '330 000', 'MC3.jpg', 'MC5.jpg', 'MC4.jpg', 'Version extrême du 720s, conçue exclusivement pour une utilisation sur circuit avec des améliorations significatives en termes de performance.', 'inactif', 'McLaren 720s GT3 X', '2021', 'V8 de 4,0 L turbo', '40 km', 'Cockpit de course, système de télémétrie avancé, freins en carbone-céramique.', 'Neuf', 'Performance de circuit dominante, très limitée en production.'),
('wrJTrzoHsuEwr7hGi3R6', 'Mercedes AMG GT2', '300 000', 'mercedes1.jpg', 'mercedes3.png', 'mercedes2.jpg', 'Voiture de sport axée sur la performance avec un design élégant et une ingénierie de précision.', 'actif', 'Mercedes AMG GT2', '2023', 'V8 de 4,0 L turbo', '55 km', 'Sièges sport AMG, système multimédia haut de gamme, aide à la conduite active.', 'Neuf', 'Équilibre parfait entre performance et confort, design agressif.');

-- --------------------------------------------------------

--
-- Structure de la table `puff`
--

CREATE TABLE `puff` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_detail` varchar(500) NOT NULL,
  `status` varchar(100) NOT NULL,
  `goût` varchar(255) NOT NULL,
  `taffe` varchar(255) NOT NULL,
  `nicotine` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `puff`
--

INSERT INTO `puff` (`id`, `name`, `price`, `image`, `product_detail`, `status`, `goût`, `taffe`, `nicotine`) VALUES
('wrJTrzoHsuEwr7hGi3R6', 'Puff naturel', '300 ', 'puff6.jpg', 'A la recherche d’une saveur d&#39;essences et originale pour votre vapotage ? \r\nDécouvrez la TurboVape Gaz Naturelle by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Gaz Naturelle', '1000', '0%'),
('pWY5Mf0987NUdbPoxuBu', 'Puff Gazole', '12', 'puff1.jpg', 'A la recherche d’une saveur d&#39;essences et originale pour votre vapotage ? Découvrez la TurboVape Gazole by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Gazole', '1000', '5%'),
('ICg3StZandimDp1BU1m2', 'Puff Sans Plomb 95', '14', 'puff2.jpg', 'A la recherche d’une saveur d&#39;essences et originale pour votre vapotage ? Découvrez la TurboVape Sans Plomb 95 by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Sans Plomb 95', '1000', '5%'),
('0lKHBlsFPaTpTFlnHUXf', 'Puff Superéthanol E85', '12', 'puff3.jpg', 'A la recherche d’une saveur d&#39;essences et originale pour votre vapotage ? Découvrez la TurboVape Superéthanol E85 by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Superéthanol E85', '1000', '7,5%'),
('Wd3or2BwCtKebztba6aV', 'Puff Supercarburants SP95', '12', 'puff4.jpg', 'A la recherche d’une saveur d&#39;essences et originale pour votre vapotage ? Découvrez la TurboVape Supercarburants SP95 by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Supercarburants SP95', '1000', '10%'),
('ugVkMKuH66eqSJFRyhAU', 'Puff électrique', '12', 'puff5.jpg', 'A la recherche d’une saveur d&#39;essences et originale pour votre vapotage ? Découvrez la TurboVape Carburant Electrique by Road Luxury, aux arômes exclusifs pour une vape fun et gourmande ! ', 'actif', 'Electrique', '1000', '1%');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
('UAVjN46f0bvXSKquej8S', 'Paul', 'paul.roux@gmail.com', 'paul786', 'user'),
('ir7qjxTxaQm9PM5drpEn', 'Sophie', 'sophie.moreau@gmail.com', 'sophie786', 'user'),
('GE2LLAWjKATiQRLHaa6O', 'Maxime', 'maxime.petit@gmail.com', '12345', 'user'),
('d5URvsP8VusCXQoCdMBG', 'Camille', 'camille.blanchard@gmail.com', '12345', 'user');

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `puff_id` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `puff_id`, `price`) VALUES
('72JgjmZfvweETLotqnje', 'UAVjN46f0bvXSKquej8S', 'BLTtlhOgq1cuz7plh4Ia', '', '375 000'),
('7wnrZsxk8fWg2MRh4CTA', 'UAVjN46f0bvXSKquej8S', 'jo35YMmBWpvbCMB65UdA', '', '10 000 000'),
('98zmjXGhj1SXV7WYaxnn', 'UAVjN46f0bvXSKquej8S', 'aSBHDzG26iXurm6cfoNv', '', '699 000');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
