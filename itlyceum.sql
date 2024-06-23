-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 23 jun 2024 om 22:14
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
-- Tabelstructuur voor tabel `docent_klas`
--

CREATE TABLE `docent_klas` (
  `gebruiker_id` int(11) NOT NULL,
  `klas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `docent_klas`
--

INSERT INTO `docent_klas` (`gebruiker_id`, `klas_id`) VALUES
(3, 100001),
(3, 100002);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `gebruiker_id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `rol` enum('manager','roostermaker','docent') NOT NULL,
  `klas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`gebruiker_id`, `naam`, `email`, `password`, `rol`, `klas`) VALUES
(1, 'John Doe', 'john@example.com', '$2y$10$PRuejmF7RM7d9KdIkeA6te701vVdD3IZZneDHL6QdETGn.2tNpXJ2', 'manager', '0'),
(2, 'Jane Smith', 'jane@example.com', '$2y$10$6kQ0nJMOiGHDpPhLtn1V7.E2purhVQ0dWhGyW31GrEF7T5eYa/8uO', 'roostermaker', '0'),
(3, 'Robert brodi', 'robert@example.com', '$2y$10$2x7VwL2kdQJdSOi2ucu2r.eOqAnF7tx41dGfQVEGj.NWazO4fNRN6', 'docent', '4f'),
(6, 'Merlin James', 'Merlin@gmail.nl', '$2y$10$1Rt9MUjy9daiBG9Brz38mO0qHLaTnC6i/sjoGrkx3YTHRMz3BEawu', 'docent', '0'),
(10, 'jef', 'abc@gmail.com', '$2y$10$4RfvZTtS.W0NH0dpdO/voOQDkz8ypJ9N5NKPdQVjXx91KbCQ1gp2e', 'docent', '2ab'),
(15, 'pizza', 'Martino@gmail.com', '$2y$10$VBXTEKlUeZhkTv547psgz.DO3z2EYSJhAzERlcFto2eWr85BmaWii', 'docent', '2ab'),
(19, 'Osman', 'Osman@gmail.com', '$2y$10$8rkojpWZL4HZFWsRVwck6.CggWyM8W4dVqFjlCo.sHRxQlyUAO0mS', 'docent', '2aq');

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

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gesprekken`
--

CREATE TABLE `gesprekken` (
  `gesprek_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `mentor_id` int(11) DEFAULT NULL,
  `datum` date NOT NULL,
  `tijd` time NOT NULL,
  `onderwerp` varchar(255) DEFAULT NULL,
  `beschrijving` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klassen`
--

CREATE TABLE `klassen` (
  `klas_id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `mentor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klassen`
--

INSERT INTO `klassen` (`klas_id`, `naam`, `mentor_id`) VALUES
(100001, 'OITIOSD2A', 3),
(100002, 'OITIOSD2B', 3),
(100003, 'OITIOSD2C', 3);

--
-- Triggers `klassen`
--
DELIMITER $$
CREATE TRIGGER `update_student_mentor` AFTER UPDATE ON `klassen` FOR EACH ROW BEGIN
    -- Update the mentor_id for students in the affected class
    UPDATE studenten
    SET mentor_id = NEW.mentor_id
    WHERE klas_id = NEW.klas_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `roosters`
--

CREATE TABLE `roosters` (
  `rooster_id` int(11) NOT NULL,
  `klas_id` int(11) DEFAULT NULL,
  `weeknummer` int(11) NOT NULL,
  `datum` date NOT NULL,
  `tijd` time NOT NULL,
  `vak_id` int(11) DEFAULT NULL,
  `gebruiker_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `roosters`
--

INSERT INTO `roosters` (`rooster_id`, `klas_id`, `weeknummer`, `datum`, `tijd`, `vak_id`, `gebruiker_id`) VALUES
(2, 100002, 25, '2024-06-18', '09:30:00', 1, 3),
(3, 100002, 25, '2024-06-18', '09:30:00', 1, 3),
(4, 100002, 26, '2024-06-19', '15:22:00', 3, 3),
(5, 100002, 26, '2024-06-27', '14:19:00', 1, 3),
(7, 100001, 26, '2024-06-07', '10:25:00', 2, 3),
(8, 100003, 26, '2024-06-15', '10:28:00', 2, 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `studenten`
--

CREATE TABLE `studenten` (
  `student_id` int(11) NOT NULL,
  `gebruiker_id` int(11) DEFAULT NULL,
  `klas_id` int(11) DEFAULT NULL,
  `naam` varchar(255) NOT NULL,
  `achternaam` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT '@talnet.nl',
  `password_hash` varchar(255) NOT NULL,
  `mentor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `studenten`
--

INSERT INTO `studenten` (`student_id`, `gebruiker_id`, `klas_id`, `naam`, `achternaam`, `email`, `password_hash`, `mentor_id`) VALUES
(12, NULL, 100003, 'Tino', 'LZ', '2165338@talnet.nl', '$2y$10$xdcG66lmBycu6W.no1Sm2ucDPycpaJfNT9GYQK6zwtzPtM5Qsp2UK', NULL),
(21, NULL, 100001, 'Martino', 'simic', '2165338@talnet.nl', '$2y$10$OLyV3MTx01sojJ2XOa0G/uEIGAAGc92mCy/rTPNobJ4PhbQJL3QVa', NULL),
(22, NULL, 100002, 'Tino', 'simic', '2165338@talnet.nl', '$2y$10$jC7FwUKeyQ1xgwOH.5yg9ufZAWMKErpPZJwH3pfqjc7A4qpbLVllq', NULL),
(2165302, NULL, 100001, 'John', 'Doe', '2165302@talnet.nl', 'password123', 3),
(2165303, NULL, 100001, 'Jane', 'Smith', '2165303@talnet.nl', 'password456', 3),
(2165311, NULL, 100003, 'dejah', 'marshall', '2165311@talnet.nl', '$2y$10$qltUPf9rxhHBHZ5mjE7oy.kCrY7jhC7vZHDQ92k3hwJqDSGaWeU0q', 3),
(2165335, NULL, 100003, 'gt', 'tombe', '2165312@talnet.nl', '$2y$10$pOplBm6IXy2ORYIV8bQzn.H/Txt84VHQtIR8T1oDe4HWpetVOvqNK', 3),
(2165336, NULL, 100003, 'Martino', 'Simic', '2165336@talnet.nl', '$2y$10$H1Dn.hJLUxxXCnzBFxSAbe7tfizSgB0x7qeLkgIQQ9x.4oWtehH8y', NULL),
(2165337, NULL, 100003, 'Martino@gmail.com', 'Simic', '2165337@talnet.nl', '$2y$10$7u6xVsPQcShCw.qDosHEb.RN5OfiyUIi6hjG2WJ3uJpOJL4VGvP7S', NULL);

--
-- Triggers `studenten`
--
DELIMITER $$
CREATE TRIGGER `before_studenten_insert` BEFORE INSERT ON `studenten` FOR EACH ROW BEGIN
    DECLARE new_student_id INT;
    DECLARE rand_klas_id INT;
    
    -- Select a random klas_id from the klassen table
    SET @min_klas_id = (SELECT MIN(klas_id) FROM klassen);
    SET @max_klas_id = (SELECT MAX(klas_id) FROM klassen);
    SET rand_klas_id = FLOOR(RAND() * (@max_klas_id - @min_klas_id + 1)) + @min_klas_id;
    
    -- Get the next student_id
    SELECT IFNULL(MAX(student_id), 0) + 1 INTO new_student_id FROM studenten;
    
    -- Set the email with the incremented student_id
    SET NEW.email = CONCAT(new_student_id, '@talnet.nl');
    
    -- Set the klas_id with the randomly selected klas_id
    SET NEW.klas_id = rand_klas_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vakken`
--

CREATE TABLE `vakken` (
  `vak_id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `vakken`
--

INSERT INTO `vakken` (`vak_id`, `naam`) VALUES
(1, 'Mathematics'),
(2, 'Physics'),
(3, 'Chemistry'),
(4, 'Biology'),
(5, 'English'),
(6, 'History'),
(7, 'Computer Science'),
(8, 'Software Engineering'),
(9, 'Database Management'),
(10, 'Web Development');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `docent_klas`
--
ALTER TABLE `docent_klas`
  ADD PRIMARY KEY (`gebruiker_id`,`klas_id`),
  ADD UNIQUE KEY `idx_unique_docent_klas` (`gebruiker_id`,`klas_id`),
  ADD KEY `fk_docent_klas_klas` (`klas_id`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`gebruiker_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexen voor tabel `gesprekken`
--
ALTER TABLE `gesprekken`
  ADD PRIMARY KEY (`gesprek_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `mentor_id` (`mentor_id`);

--
-- Indexen voor tabel `klassen`
--
ALTER TABLE `klassen`
  ADD PRIMARY KEY (`klas_id`),
  ADD KEY `fk_klassen_mentor` (`mentor_id`);

--
-- Indexen voor tabel `roosters`
--
ALTER TABLE `roosters`
  ADD PRIMARY KEY (`rooster_id`),
  ADD KEY `klas_id` (`klas_id`),
  ADD KEY `vak_id` (`vak_id`),
  ADD KEY `roosters_ibfk_3` (`gebruiker_id`);

--
-- Indexen voor tabel `studenten`
--
ALTER TABLE `studenten`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `gebruiker_id` (`gebruiker_id`),
  ADD KEY `fk_studenten_klas_id` (`klas_id`),
  ADD KEY `fk_studenten_mentor` (`mentor_id`);

--
-- Indexen voor tabel `vakken`
--
ALTER TABLE `vakken`
  ADD PRIMARY KEY (`vak_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `gebruiker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT voor een tabel `gesprekken`
--
ALTER TABLE `gesprekken`
  MODIFY `gesprek_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `klassen`
--
ALTER TABLE `klassen`
  MODIFY `klas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100004;

--
-- AUTO_INCREMENT voor een tabel `roosters`
--
ALTER TABLE `roosters`
  MODIFY `rooster_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `studenten`
--
ALTER TABLE `studenten`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2165338;

--
-- AUTO_INCREMENT voor een tabel `vakken`
--
ALTER TABLE `vakken`
  MODIFY `vak_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `docent_klas`
--
ALTER TABLE `docent_klas`
  ADD CONSTRAINT `fk_docent_klas_gebruiker` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`gebruiker_id`),
  ADD CONSTRAINT `fk_docent_klas_klas` FOREIGN KEY (`klas_id`) REFERENCES `klassen` (`klas_id`);

--
-- Beperkingen voor tabel `gesprekken`
--
ALTER TABLE `gesprekken`
  ADD CONSTRAINT `gesprekken_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `studenten` (`student_id`),
  ADD CONSTRAINT `gesprekken_ibfk_2` FOREIGN KEY (`mentor_id`) REFERENCES `gebruikers` (`gebruiker_id`);

--
-- Beperkingen voor tabel `klassen`
--
ALTER TABLE `klassen`
  ADD CONSTRAINT `fk_klassen_mentor` FOREIGN KEY (`mentor_id`) REFERENCES `gebruikers` (`gebruiker_id`);

--
-- Beperkingen voor tabel `roosters`
--
ALTER TABLE `roosters`
  ADD CONSTRAINT `roosters_ibfk_1` FOREIGN KEY (`klas_id`) REFERENCES `klassen` (`klas_id`),
  ADD CONSTRAINT `roosters_ibfk_2` FOREIGN KEY (`vak_id`) REFERENCES `vakken` (`vak_id`),
  ADD CONSTRAINT `roosters_ibfk_3` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`gebruiker_id`);

--
-- Beperkingen voor tabel `studenten`
--
ALTER TABLE `studenten`
  ADD CONSTRAINT `fk_studenten_klas_id` FOREIGN KEY (`klas_id`) REFERENCES `klassen` (`klas_id`),
  ADD CONSTRAINT `fk_studenten_mentor` FOREIGN KEY (`mentor_id`) REFERENCES `gebruikers` (`gebruiker_id`),
  ADD CONSTRAINT `studenten_ibfk_1` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`gebruiker_id`),
  ADD CONSTRAINT `studenten_ibfk_2` FOREIGN KEY (`klas_id`) REFERENCES `klassen` (`klas_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
