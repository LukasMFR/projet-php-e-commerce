-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 29 avr. 2024 à 11:15
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

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
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `puff_id` varchar(255) NOT NULL,
  `price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `puff_id`, `price`) VALUES
('bXpS0Vb2T7chEAa28SGQ', 'UAVjN46f0bvXSKquej8S', 'aSBHDzG26iXurm6cfoNv', '0', 699),
('9vEdPoV58gfvFSab0glR', 'UAVjN46f0bvXSKquej8S', '', '0', 12),
('rgOdtejKScFP1LIhEsrL', 'UAVjN46f0bvXSKquej8S', '', '0', 300),
('BsrWUeLicnDeAabpTamD', 'UAVjN46f0bvXSKquej8S', 'BLTtlhOgq1cuz7plh4Ia', '0', 375),
('bEc7kdPA9Xts9PHY322T', 'UAVjN46f0bvXSKquej8S', 'uOarNNg0n3KD9OvPtItP', '0', 10),
('7h1o2X2zlloVyeSVWS43', 'UAVjN46f0bvXSKquej8S', '', '0', 12),
('X0N1DFP3fm7cUv1j1oYN', 'saXAlrnp3YHOBTxClO0A', '', '0', 12);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
