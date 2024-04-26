-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 26 avr. 2024 à 15:51
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

DROP DATABASE IF EXISTS autocar;
CREATE DATABASE autocar ;
USE autocar ;
DROP TABLE IF EXISTS admin ;
DROP TABLE IF EXISTS cart ;
DROP TABLE IF EXISTS message ;
DROP TABLE IF EXISTS orders ;
DROP TABLE IF EXISTS products ;
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

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `qty`) VALUES
('UzH7ynJfxmARltq6q5Sx', 'UAVjN46f0bvXSKquej8S', 'aSBHDzG26iXurm6cfoNv', '50', '1');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`) VALUES
('0', '0', 'mahi', 'mahinazir@gmail.com', 'shop', 'good'),
('Lm7uFQVcX3czwG0yX5p0', 'UAVjN46f0bvXSKquej8S', 'mahi', 'mahinazir@gmail.com', 'maths,science', 'kk');

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
  `Moteur` varchar(255) NOT NULL,
  `Kilométrage` varchar(255) NOT NULL,
  `Equipements` varchar(255) NOT NULL,
  `Etat` varchar(255) NOT NULL,
  `Pointsforts` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `image3`, `image2`, `product_detail`, `status`, `Modèle`, `Année`, `Moteur`, `Kilométrage`, `Equipements`, `Etat`, `Pointsforts`) VALUES
('jo35YMmBWpvbCMB65UdA', 'Bugatti la voiture noir', '14999998', 'bugatienoir.jpg', 'bugati3.jpg', 'bugati2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\n					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\n					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\n					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit am', 'actif', 'Bugatti la voiture noir', '2021', '16-cylindres en W quadri-turbo de 8 litres', '0 Km', '/', 'Neuf', '0 à 100 km/h en 2,4s'),
('aSBHDzG26iXurm6cfoNv', 'Lamborghini Revuelto', '699000', 'lambo4.jpg', 'lambo6.jpg', 'lambo5.jpg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\n					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\n					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\n					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit am', 'actif', 'Lamborghini Revuelto', '2023', 'V12 de 6,5 L', '5000 Km', 'ÉQUIPEMENT DE CHARGE, PROTECTION EXTÉRIEURE, FILM DE PROTECTION, PROTECTION INTÉRIEURE', 'Occasion', '0 à 100 km/h en 2,5 s'),
('g5DLcNHmtHvq3DtJYsCb', 'Alpine A110 R', '111997', 'alpine.jpg', 'alpine3.jpg', 'alpine2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\n					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\n					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\n					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit am', 'actif', 'Alpine A110 R', '2020', '4 cylindres en ligne de 1,8 L', '1000 Km', 'KIT AERO MP-R', 'Occasion', '0 à 100 km/h en 3,9 sec pour une vitesse de pointe de 285 km/h'),
('uOarNNg0n3KD9OvPtItP', 'Ferrari SP51', '10000000', 'ferariesp51.png', 'ferarie3.jpg', 'ferarie2.png', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\n					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\n					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\n					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit am', 'actif', 'Ferrari SP51', '2022', 'V12', '0 Km', '/', 'Neuf', '0 à 100 km/h en moins de 3 secondes'),
('26lPPTjXh9EkNc7WocS5', 'Porsche 911 GT3 R', '247996', 'porche.png', 'porche3.jpg', 'porche2.png', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\n					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\n					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\n					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit am', 'actif', 'Porsche 911 GT3 R', '2020', 'V8 de 4 L', '9547 Km', 'Série de sièges baquets, Carbone apparent, inserts en carbone, Pack Chrono, Assistant de passage des vitesses', 'Occasion', '0 à 100 km/h en 3,2 s'),
('kun96OpQed6Eww6M1URo', 'LAMBORGHINI URUS', '214999', 'urus1.jpg', 'urus3.jpg', 'urus2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\n					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\n					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\n					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit am', 'actif', 'LAMBORGHINI URUS', ' 2023', 'V8 de 4,0 L', '0 Km', 'VOYAGE, PET CARE, ÉCHAPPEMENT EN TITANE, COMPOSANTS EN FIBRE DE CARBONE, ACCESSOIRES D’HIVER', 'Neuve', '0 à 100 km/h en 3,6 s'),
('wrJTrzoHsuEwr7hGi3R6', 'Mercedes-AMG GT3 Edition 55', '625000', 'mercedes1.jpg', 'mercedes3.png', 'mercedes2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\n					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\n					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\n					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit am', 'actif', 'Mercedes-AMG GT3 Edition 55', '2022', 'V8 de 6,3 L', '1000 Km', 'Le pack AMG Line', 'Occasion', '0 à 100 km/h en 3,2 s'),
('eBbtkVNYiJJKT9mCgYbk', 'Maserati Granturismo', '181395', 'maserati1.jpg', 'maserati3.jpg', 'maserati2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\n	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\n	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\n	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adip', 'actif', 'Maserati Granturismo', '2019', 'v6 de 3,0 L', '12 000 Km', 'Entretien et protection, Roues équilibrées, Accessoires d’entretien et de protection,', 'Occasion', '0 à 100 km/h en 3,5 s'),
('Hs4tKXIJkieL1I0tmN9H', 'maclaren 720s', '374998', 'mc1.jpg', 'mc3.png', 'mc2.jpg', 'DSDSDSD', 'actif', 'maclaren 720s', '2022', 'V8 de 4,0 L', '0 Km', 'Deux airbags, Climatisation automatique bizone, Régulateur de vitesse, Système multimédia avec écran tactile de 8 pouces, Capteurs de pluie et de lumière', 'Neuve', '0 à 100 km/h en 2,9 s');

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
  `price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
('FngaVJmk3vBeq3KUmt03', 'UAVjN46f0bvXSKquej8S', 'jo35YMmBWpvbCMB65UdA', '160');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
