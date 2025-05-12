-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 20 mars 2025 à 08:12
-- Version du serveur : 8.0.41
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `user_form`
--

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

CREATE TABLE `jeux` (
  `id_jeux` int NOT NULL,
  `nom` varchar(60) NOT NULL,
  `genre` varchar(60) NOT NULL,
  `limite_age` varchar(60) NOT NULL,
  `type` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `jeux`
--

INSERT INTO `jeux` (`id_jeux`, `nom`, `genre`, `limite_age`, `type`) VALUES
(11, 'pokemon', 'fantastique', '11', 'solo et multijoueurs'),
(12, 'pokemon', 'fantastique', '20', 'solo et multijoueurs'),
(13, 'ff', 'fantasy', '2', 'hh');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `email`, `role`) VALUES
(1, 'Bongo Mathis Maëlane', '$2y$10$siCJrowSPJPFrYom/zswz.Uo0RAJdQ6cCgoBxbDECBxGrED3/QyAG', 'bongomathismaelane@gmail.com', 'user'),
(2, 'test1', '$2y$10$UlQjx3KIM4OUnerOVX3SxePHM42bQeJfFlz9ckvoFdWdheYq5bv3.', 'test1@gmail.com', 'user'),
(9, 'test2', '$2y$10$uwW4CKPHKFQkvE0kAUFdvugHuRnKV8G1YRZqZfmwsZQS/GOnspDP6', 'test2@gmail.com', 'user'),
(10, 'Bongo Mathis Maëlane', '$2y$10$2mglp82HAibaq3fXFanFxOoaqNEKrqGu9zohC.AcxEDdwGBtSlTrO', 'tes3@gmail.com', 'user'),
(11, 'tes4', '$2y$10$aJLddksIMgqF2KVeAIe/3evc5RDuegcHlHgNliD3FPWbB.KbDtae6', 'tes4@gmail.com', 'user'),
(12, 'tes5', '$2y$10$VG4dM/ZvYa3BSfLcG2FYL.6uN5CoEYVsonXfBVixkvuCAaVl8fNwi', 'test5@gmail.com', 'user'),
(13, 'TEST5', '$2y$10$K5O4S41CLnDuFvu72N6Qb.WY0U2mTMp0rwWR9FvDpBqupSeLzwQi6', 'toto@gmail.com', 'user'),
(14, 'admin', '$2y$10$YN2ULzQ7X5JXMGjDR1S.gugDiurrLnHGURAzFXmLay/OJDPiDeSVi', 'admin@gmail.com', 'user'),
(15, 'ad', '$2y$10$ZHAGQbs5t/fwSSYItfkJOuqvVldSX6RedU69Drcyeux907mYLS6DK', 'ad@gmail.com', 'user'),
(16, 'ad', '$2y$10$stEuApr6/AijPy26axfZGuPdieRs5wbM5mVTPl80PmDkjlmK4JGC2', 'add@gmail.com', 'user'),
(18, 'Bongo Mathis Maëlane', '$2y$10$SWaisQMMQcDe864RbTWdo.qx5y6Sok1gpgw2ZHj2hGU2LZvfbf6Re', 'aa@gmail.com', 'user'),
(19, 'Bongo Mathis Maëlane', '$2y$10$WOK2GeCzDmSA/kdxVraq/.Ifm1un6iwE2UQi4TsebwfDYJ3dC1y2W', 'tata@gmail.com', 'user'),
(20, 'mathis', '$2y$10$5O9URtxwOXB9tIcWjADBY.W5X4fmVjqGTLhtFMXctWWe1tpJDhh/W', 'ad@emple.com', 'user'),
(22, 'test6', '$2y$10$XbSvcxf4zqy4l7xL7isuO.VU.lG7/vEKsiCjfsvlCNvG6ak1Jq8De', 'tototot@gmail.com', 'user'),
(24, 'test10', '$2y$10$YJs5L1/o94E4Tx0fsXzSt..ZU/LW/ZqSEhD/gK0gWDOzGNBdU6H8G', 'test10@gmail.com', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `jeux`
--
ALTER TABLE `jeux`
  ADD PRIMARY KEY (`id_jeux`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `jeux`
--
ALTER TABLE `jeux`
  MODIFY `id_jeux` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
