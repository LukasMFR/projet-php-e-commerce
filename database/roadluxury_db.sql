-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Server version: 10.4.25-MariaDB


DROP DATABASE IF EXISTS roadluxury;
CREATE DATABASE roadluxury ;
USE roadluxury ;
DROP TABLE IF EXISTS admin ;
DROP TABLE IF EXISTS panier ;
DROP TABLE IF EXISTS message ;
DROP TABLE IF EXISTS commande ;
DROP TABLE IF EXISTS vehicule ;
DROP TABLE IF EXISTS Puff ;
DROP TABLE IF EXISTS utilisateur ;
DROP TABLE IF EXISTS Favoris ;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




-- Table structure for table `admin`

CREATE TABLE `admin` (
  `idAdmin` int(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `mot de passe` varchar(50) NOT NULL,
  `profile` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dumping data for table `admin`

INSERT INTO `admin` (`idAdmin`, `nom`, `mail`, `mot de passe`, `profile`) VALUES
(1, 'admin', 'admin@roadluxury.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'admin.jpg');



-- Table structure for table `panier`

CREATE TABLE `panier` (
  `idpanier` varchar(20) NOT NULL,
  `idUser` varchar(20) NOT NULL,
  `IDVech` varchar(20) NOT NULL,
  `IDPuff` varchar(20) NOT NULL,
  `Prix` decimal, NOT NULL,
  `Quantité` int, NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dumping data for table `panier`

INSERT INTO `cart` (`idpanier`, `idUser`, `IDVech`, `IDPuff`, `Prix`, 'Quantité') VALUES
('UzH7ynJfxmARltq6q5Sx', 'UAVjN46f0bvXSKquej8S', 'aSBHDzG26iXurm6cfoNv', 'aSBHDzG26iXurm6cfoNv' '50', '1');



-- Table structure for table `message`

--CREATE TABLE `message` (
 -- `id` varchar(255) NOT NULL,
  --`user_id` varchar(255) NOT NULL,
 -- `name` varchar(255) NOT NULL,
  --`email` varchar(100) NOT NULL,
 -- `subject` varchar(255) NOT NULL,
 -- `message` varchar(255) NOT NULL
--) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dumping data for table `message`

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`) VALUES
('0', '0', 'Paul', 'paul.depont@gmail.com', 'shop', 'good'),
('Lm7uFQVcX3czwG0yX5p0', 'UAVjN46f0bvXSKquej8S', 'Paul', 'paul.depont@gmail.com', 'maths,science', 'kk');



-- Table structure for table `commande`

CREATE TABLE `commande` (
  `idCommande` varchar(50) NOT NULL,
  `IDUser` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `Num` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `Adresse` varchar(100) NOT NULL
  `MethodeAchat` varchar(50) NOT NULL,
  `IDVech` varchar(50) NOT NULL,
  `IDPuff` varchar(50) NOT NULL,
  `Prix` decimal, NOT NULL,
  `Quantité` int, NOT NULL,
  `DateAchat` date, NOT NULL DEFAULT,current_timestamp(),
  `statuPayement` varchar(50) NOT NULL DEFAULT 'en cours',
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dumping data for table `commande`

INSERT INTO `orders` (`idcommande`, `IDUser`, `nom`, `Prenom`, `Num`, `mail`, `Adresse`, `MethodAchat`, `IDVech`, `IDPuff`, `Prix`, `Quantite`, `DateAchat`, `StatuPayement`) VALUES
('EYZ94PhWrzea0s9Tdd2J', 'UAVjN46f0bvXSKquej8S', 'Paul', 'dupont', '0675001234', 'paul.depont@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'cash on delivery', 'aSBHDzG26iXurm6cfoNv', 'aSBHDzG26iXurm6cfoNv', '123', '1', '2023-02-28',  'en attente'),
('DStPLCBmD0m0OjAFYlhg', 'UAVjN46f0bvXSKquej8S', 'Paul', 'dupont', '0675001234', 'paul.depont@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'cash on delivery', 'aSBHDzG26iXurm6cfoNv', 'aSBHDzG26iXurm6cfoNv', '160', '1', '2023-02-28', 'en attente'),
('UUFMa328sIAdb3znDXce', 'UAVjN46f0bvXSKquej8S', 'Paul', 'dupont', '0675001234', 'paul.depont@gmail.com', '10 avenue Montaigne,  75008 Paris', 'credit or debit card', 'aSBHDzG26iXurm6cfoNv', 'aSBHDzG26iXurm6cfoNv', '120', '1', '2023-02-28', 'completee'),
('9vucKr2sSPqcIUidPedP', 'UAVjN46f0bvXSKquej8S', 'Paul', 'dupont', '0675001234', 'paul.depont@gmail.com', '5 avenue Victor Hugo, 75016 Paris','cash on delivery', 'aSBHDzG26iXurm6cfoNv', 'aSBHDzG26iXurm6cfoNv','120', '1', '2023-02-28', 'en attente'),
('gq2RDUuhaPe7TDcxiGCy', 'UAVjN46f0bvXSKquej8S', 'Paul', 'dupont', '0675001234', 'paul.depont@gmail.com', '5 avenue Victor Hugo, 75016 Paris', 'cash on delivery', 'aSBHDzG26iXurm6cfoNv', 'aSBHDzG26iXurm6cfoNv', '80', '1', '2023-02-28', 'en attente'),
('JqyfHoT9UzR4qcvp3LNJ', 'd5URvsP8VusCXQoCdMBG', 'Camille', 'dupont', '0675001234', 'camille.lelouche@gmail.com', '507A, 24 back side, mumbai, India, 110019', 'credit or debit card', 'aSBHDzG26iXurm6cfoNv', 'aSBHDzG26iXurm6cfoNv', '123', '1', '2023-02-28', 'completee'),
('yyD4B276Pg9lfGpRjcr9', 'd5URvsP8VusCXQoCdMBG', 'Camille', 'dupont', '0675045678', 'camille.lelouche@gmail.com', '507A, 24 back side, mumbai, india, 112233', 'credit or debit card', 'aSBHDzG26iXurm6cfoNv', 'aSBHDzG26iXurm6cfoNv', '160', '2', '2023-02-28', 'en attente');



-- Table structure for table `vehicule`

CREATE TABLE `vehicule` (
  `idvech` varchar(50) NOT NULL,
  `marque` varchar(255) NOT NULL,
  `modele` varchar(255) NOT NULL,
  `anneeFab` varchar(255) NOT NULL,
  `prix` decimal, NOT NULL,
  'image' varchar(255) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dumping data for table `vehicule`

INSERT INTO `products` (`idvech`, `marque`, `modele`, `anneFab`, `prix`, `image`) VALUES
('BLTtlhOgq1cuz7plh4Ia', 'Ferari', 'SP51', '2022', '10000', 'ferariesp51.jpg'),
('jo35YMmBWpvbCMB65UdA', 'Bugatti', 'voiture noir', '2021', '10000', 'bugatienoir.webp'),
('aSBHDzG26iXurm6cfoNv', 'Aston Martin', 'Vantage GT3', '2018/2019', '10000', 'astonmartine.jpg');




-- Table structure for table `puff`

CREATE TABLE `Puff` (
  `idPuff` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `saveur` Text(50) NOT NULL,
  `prix` decimal, NOT NULL,
  `stock` int, NOT NULL,
  'image' varchar(255) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dumping data for table `puff`

INSERT INTO `products` (`idPuff`, `nom`, `saveur`, `prix`, `stock`, `image`) VALUES
('BLTtlhOgq1cuz7plh4Ia', 'Car Vape', '12', 'fraise/gasoile', '12', '2000', 'puffFraiseGasoile.jpg');



-- Table structure for table `utilisateur`

CREATE TABLE `utilisateur` (
  `idUser` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `motDePasse` varchar(255) NOT NULL DEFAULT 
  `typeUser` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dumping data for table `utilisateur`

INSERT INTO `users` (`idUser`, `nom`, `prenom`, `mail`, `motDePasse`, 'TypeUser' ) VALUES
('UAVjN46f0bvXSKquej8S', 'Paul', 'dupont', 'paul.depont@gmail.com', 'paul786', 'user'),
('d5URvsP8VusCXQoCdMBG', 'Camille', 'lelouche', 'camille.lelouche@gmail.com', '12345', 'user');



-- Table structure for table `favoris`

CREATE TABLE `favoris` (
  `idFavoris` varchar(255) NOT NULL,
  `idUser` varchar(255) NOT NULL,
  `IDVech` varchar(255) NOT NULL,
  `IDPuff` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dumping data for table `favoris`

INSERT INTO `Favoris` (`idFavoris`, `IDUser`, `IDVech`, `IDPuff`) VALUES
();
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
