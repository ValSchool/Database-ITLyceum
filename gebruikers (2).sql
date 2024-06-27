-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Gegenereerd op: 27 jun 2024 om 09:13
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itlyceum`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `gebruiker_id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `rol` enum('manager','roostermaker','docent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`gebruiker_id`, `naam`, `email`, `password`, `rol`) VALUES
(1, 'John Doe', 'john@example.com', '$2y$10$PRuejmF7RM7d9KdIkeA6te701vVdD3IZZneDHL6QdETGn.2tNpXJ2', 'manager'),
(2, 'Jane Smith', 'jane@example.com', '$2y$10$6kQ0nJMOiGHDpPhLtn1V7.E2purhVQ0dWhGyW31GrEF7T5eYa/8uO', 'roostermaker'),
(3, 'Robert brohnsons', 'robert@example.com', '$2y$10$2x7VwL2kdQJdSOi2ucu2r.eOqAnF7tx41dGfQVEGj.NWazO4fNRN6', 'docent'),
(10, 'johnson johnson', 'johnsonjohnson@gmail.com', '$2y$10$.qIz5ta2dq24voAmnIq0cuKbDpvH3jO/Z7j.xyma.Z4vEtC6EACHG', 'docent'),
(13, '123', 'admin@1', '$2y$10$aGmbgWFVFr4Smbn8/qpAueKB7Pwgca/b49Ge2OCJGY/sbsbDp16G2', 'docent'),
(14, 'john', '123@gmail.com', '$2y$10$VvPLszZGmi65NbyORD/Q6OOUMrv7TGXIAvLraIsj.PlgWTi5ynX5i', 'roostermaker');

--
-- Triggers `gebruikers`
--
DELIMITER $$
CREATE TRIGGER `after_update_gebruikers` AFTER UPDATE ON `gebruikers` FOR EACH ROW BEGIN
    IF OLD.rol = 'docent' AND NEW.rol != 'docent' THEN
        -- Update docent_klas table to remove connections associated with the docent
        DELETE FROM docent_klas WHERE gebruiker_id = OLD.gebruiker_id;

        -- Update studenten table to remove mentor connections associated with the docent
        UPDATE studenten SET mentor_id = NULL WHERE mentor_id = OLD.gebruiker_id;
    END IF;
END
$$
DELIMITER ;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`gebruiker_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `gebruiker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
