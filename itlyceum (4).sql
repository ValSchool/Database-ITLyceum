-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Gegenereerd op: 24 jun 2024 om 13:32
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
  `rol` enum('manager','roostermaker','docent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`gebruiker_id`, `naam`, `email`, `password`, `rol`) VALUES
(1, 'John Doe', 'john@example.com', '$2y$10$PRuejmF7RM7d9KdIkeA6te701vVdD3IZZneDHL6QdETGn.2tNpXJ2', 'manager'),
(2, 'Jane Smith', 'jane@example.com', '$2y$10$6kQ0nJMOiGHDpPhLtn1V7.E2purhVQ0dWhGyW31GrEF7T5eYa/8uO', 'roostermaker'),
(3, 'Robert brohnsons', 'robert@example.com', '$2y$10$2x7VwL2kdQJdSOi2ucu2r.eOqAnF7tx41dGfQVEGj.NWazO4fNRN6', 'docent'),
(10, 'johnson johnson', 'johnsonjohnson@gmail.com', '$2y$10$.qIz5ta2dq24voAmnIq0cuKbDpvH3jO/Z7j.xyma.Z4vEtC6EACHG', 'docent');

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
(100003, 'OITIOSD2C', 3),
(100006, 'OITIOSD2D12', 10),
(100008, 'OITIOSD2F', 10);

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
(4, 100002, 26, '2024-06-19', '15:22:00', 3, 3),
(9, 100003, 26, '2024-06-01', '23:55:00', 3, 3);

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
(2165302, NULL, 100002, 'John', 'Doer', '2165302@talnet.nl', 'password123', 3),
(2165303, NULL, 100001, 'Jane', 'Smith', '2165303@talnet.nl', 'password456', 3),
(2165311, NULL, 100003, 'dejah', 'marshall', '2165311@talnet.nl', '$2y$10$qltUPf9rxhHBHZ5mjE7oy.kCrY7jhC7vZHDQ92k3hwJqDSGaWeU0q', 3),
(2165335, NULL, 100003, 'gt', 'tombe', '2165312@talnet.nl', '$2y$10$pOplBm6IXy2ORYIV8bQzn.H/Txt84VHQtIR8T1oDe4HWpetVOvqNK', 3);

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
  `naam` varchar(100) NOT NULL,
  `gebruiker_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `vakken`
--

INSERT INTO `vakken` (`vak_id`, `naam`, `gebruiker_id`) VALUES
(3, 'Chemistry', 3),
(4, 'Biology', 10),
(6, 'History', NULL),
(8, 'Software Engineering', NULL),
(14, '12', 10),
(18, '12', 10),
(19, '12', 10),
(20, '12', 10);

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
  ADD PRIMARY KEY (`vak_id`),
  ADD KEY `fk_vakken_gebruiker` (`gebruiker_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `gebruiker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `gesprekken`
--
ALTER TABLE `gesprekken`
  MODIFY `gesprek_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `klassen`
--
ALTER TABLE `klassen`
  MODIFY `klas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100009;

--
-- AUTO_INCREMENT voor een tabel `roosters`
--
ALTER TABLE `roosters`
  MODIFY `rooster_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `studenten`
--
ALTER TABLE `studenten`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2165338;

--
-- AUTO_INCREMENT voor een tabel `vakken`
--
ALTER TABLE `vakken`
  MODIFY `vak_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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

--
-- Beperkingen voor tabel `vakken`
--
ALTER TABLE `vakken`
  ADD CONSTRAINT `fk_vakken_gebruiker` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`gebruiker_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
