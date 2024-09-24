-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 25 juil. 2024 à 16:14
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `todo_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `due_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('complétée','non_complétée','','') NOT NULL DEFAULT 'non_complétée',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `due_date`, `created_at`, `status`, `user_id`) VALUES
(5, 'FFFFFF', 'SDDDD', '2024-07-25', '2024-07-23 09:18:37', 'non_complétée', 3),
(9, 'ggggge', 'dddddd', '2024-07-27', '2024-07-24 05:16:55', 'complétée', 4),
(10, 'ETUDES', 'Dev web', '2024-08-13', '2024-07-24 11:32:34', 'non_complétée', 4),
(12, 'coucou', 'dcvdhcvzv', '2024-08-13', '2024-07-24 11:38:11', 'complétée', 10),
(15, 'Audience', 'cassation', '2024-08-03', '2024-07-25 11:26:14', 'complétée', 19),
(16, 'Ecole', 'Scolarité', '2024-08-02', '2024-07-25 11:53:05', 'non_complétée', 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'manou6', 'djekinnoup@gmail.com', '$2y$10$ipRCOqawE3Jxt5ZcqHvi4.kV9bKdiBgraU6zPLFF7AJ4rgB057TcO', '2024-07-22 20:13:43', 'user'),
(2, 'DJEKINN', 'dibango@gmail.com', '$2y$10$Rwf9Es9XjSRKjwPl8DhYmuBQZoXz7CjoBhFvXHFUNtHr3atLCLhxm', '2024-07-22 21:46:31', 'user'),
(3, 'PAUL', 'ertyu@gmail.com', '$2y$10$hiV/.qVgsQZYKSFddr9C9edNEpJd1H/92qSpOhSouhRPAIWP6aWrO', '2024-07-23 09:01:12', 'user'),
(4, 'GLORIA', 'gloria@gmail.com', '$2y$10$QjsCUFYOgO4IUKmNjUUfe.D3ZpvqmsQoCKUwlQuxm3N2rn1mY3MJW', '2024-07-23 09:32:13', 'user'),
(9, 'Auréane', 'aureane@gmail.com', '$2y$10$pIaJIBzcL3QwW8B8iJX4uOAVvSbnFdlHI9nw55Hencm7G3dGCe2B.', '2024-07-24 11:35:38', 'user'),
(10, 'Justine', 'justine@gmail.com', '$2y$10$tt0L3RsTmcr8oBNrgGym5evNRvGCpS/lcDZrLQ4yVNlPNwfRYYp0W', '2024-07-24 11:36:22', 'user'),
(11, 'papa', 'papa@gmail.com', '$2y$10$FZ6xI87COp8din3h8QU1CuP.tFmhQzxP/Rjj/IDiz94McQ2STGaVm', '2024-07-24 11:45:44', 'user'),
(12, 'admin', 'admin@gmail.com', '$2y$10$4gRXyNPsjGnCR8jHonjW5epl2Mq94DaDAu2.jLIdjIB0tL4PKuf.W', '2024-07-24 22:24:51', 'admin'),
(13, 'josé', 'jose@gmail.com', '$2y$10$bu2kVAHQBVJoUklkvHN4VeCiDdvV/oBlAQTnZu/jLCxmtrkxKrxzq', '2024-07-25 05:13:11', 'user'),
(14, 'bossa', 'bossa@gmail.com', '$2y$10$YoTWtG9igmTDjzTsH20XxOwE6SGrQDfD7wT.LdiwaXNE6OOCMRY1G', '2024-07-25 05:22:05', 'user'),
(15, 'neri', 'neri@gmail.com', '$2y$10$sB6k60Xzy9JezEPsSlCLL.iV1nvExbBQZcsjtLKMXWwOc3GiSOiqS', '2024-07-25 06:13:14', 'user'),
(16, 'dona', 'dona@gmail.com', '$2y$10$Zh01FMk0g/32q6Rqri6WLO95Hdl05U0THgDnWI4mJvLZzOqCpExou', '2024-07-25 06:47:16', 'user'),
(17, 'jesus', 'jesus@gmail.com', '$2y$10$uNOFU6plAuakuuJ0JvsRNOkursFniVmAFWQfla1F8fgjt/oCm2Q/y', '2024-07-25 06:54:55', 'user'),
(19, 'auditeur', 'auditeur@gmail.com', '$2y$10$cCuJm0FDrdl09LdhjC5HHOLKeeYV1QmKt7k9YFitTuIC6vgek0d32', '2024-07-25 11:25:22', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
