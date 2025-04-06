-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 06. Apr 2025 um 19:09
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

-- Setzt SQL-Optionen, damit Auto-Inkrement-Werte auch bei 0 starten können
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- Startet eine Transaktion
START TRANSACTION;

-- Setzt die Zeitzone auf UTC
SET time_zone = "+00:00";

-- Speichert alte Zeichensatz-Einstellungen und setzt auf UTF-8
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
 /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 /*!40101 SET NAMES utf8mb4 */;

-- Datenbank: `podcast`

-- --------------------------------------------------------

-- Tabellenstruktur für `abonnement` (Verknüpfung von Nutzer und Podcast)
CREATE TABLE `abonnement` (
  `id` int(11) NOT NULL,                          -- Eindeutige ID für das Abonnement
  `abonnent_id` int(11) NOT NULL,                 -- Fremdschlüssel zur Abonnent-ID
  `podcast_id` int(11) NOT NULL,                  -- Fremdschlüssel zur Podcast-ID
  `abonniert_am` timestamp NOT NULL DEFAULT current_timestamp(), -- Zeitpunkt des Abonnierens
  `bewertung` tinyint(4) DEFAULT NULL             -- Bewertung (1–5 Sterne)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Beispiel-Daten für Tabelle `abonnement`
INSERT INTO `abonnement` (`id`, `abonnent_id`, `podcast_id`, `abonniert_am`, `bewertung`) VALUES
(1, 2, 1, '2025-03-17 14:09:21', 1),
(2, 1, 3, '2025-03-28 14:09:21', 4),
(3, 2, 2, '2025-03-24 14:07:21', 5),
(4, 2, 2, '2025-03-19 03:09:00', 4);

-- --------------------------------------------------------

-- Tabellenstruktur für `abonnent` (Nutzer, die Podcasts abonnieren können)
CREATE TABLE `abonnent` (
  `id` int(11) NOT NULL,                          -- Eindeutige ID für den Abonnenten
  `name` varchar(255) NOT NULL,                   -- Name des Abonnenten
  `email` varchar(255) NOT NULL,                  -- E-Mail-Adresse
  `registriert_am` timestamp NOT NULL DEFAULT current_timestamp() -- Registrierdatum
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Beispiel-Daten für Tabelle `abonnent`
INSERT INTO `abonnent` (`id`, `name`, `email`, `registriert_am`) VALUES
(1, 'Bedirhan Kocak', 'bk21@gmail.com', '2025-03-24 14:07:21'),
(2, 'Berke Atak', 'berke.atak@hak-reutte.ac.at', '2025-03-24 14:07:21'),
(3, 'Martin Zauner', 'mzauner@tsn.at', '2025-03-24 14:07:21');

-- --------------------------------------------------------

-- Tabellenstruktur für `podcast` (Podcast-Angebote)
CREATE TABLE `podcast` (
  `id` int(11) NOT NULL,                          -- Eindeutige ID für den Podcast
  `titel` varchar(255) NOT NULL,                  -- Titel des Podcasts
  `beschreibung` text DEFAULT NULL,               -- Beschreibung des Podcasts
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp() -- Erstellungsdatum
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Beispiel-Daten für Tabelle `podcast`
INSERT INTO `podcast` (`id`, `titel`, `beschreibung`, `erstellt_am`) VALUES
(1, 'Social Media Talk', 'Ein Podcast für die Zukunft der sozialen Medien', '2025-03-24 14:07:21'),
(2, 'Fitness & Mentality', 'Für die Diszplin eines Kriegers gibt es keine Abkürzungen!', '2025-03-24 14:07:21'),
(3, 'Verloren in der Vergangenheit', 'Die mächtigsten Ereignisse aus der Vergangenheit diskutieren.', '2025-03-24 14:07:21');

-- --------------------------------------------------------

-- Indizes für schnellere Abfragen

-- Primärschlüssel und Fremdschlüssel-Verweise für `abonnement`
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`id`),                         -- Primärschlüssel: ID des Abonnements
  ADD KEY `abonnent_id` (`abonnent_id`),          -- Index auf Abonnent
  ADD KEY `podcast_id` (`podcast_id`);            -- Index auf Podcast

-- Primärschlüssel für `abonnent`
ALTER TABLE `abonnent`
  ADD PRIMARY KEY (`id`);

-- Primärschlüssel für `podcast`
ALTER TABLE `podcast`
  ADD PRIMARY KEY (`id`);

-- --------------------------------------------------------

-- Auto-Inkrement-Funktionalität definieren

-- AUTO_INCREMENT für `abonnement`, startet bei 100
ALTER TABLE `abonnement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

-- AUTO_INCREMENT für `abonnent`, startet bei 4
ALTER TABLE `abonnent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT für `podcast`, startet bei 4
ALTER TABLE `podcast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- --------------------------------------------------------

-- Fremdschlüssel-Constraints für referentielle Integrität

ALTER TABLE `abonnement`
  ADD CONSTRAINT `abonnement_ibfk_1` FOREIGN KEY (`abonnent_id`) REFERENCES `abonnent` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `abonnement_ibfk_2` FOREIGN KEY (`podcast_id`) REFERENCES `podcast` (`id`) ON DELETE CASCADE;

-- Schließt die Transaktion ab
COMMIT;

-- Setzt die ursprünglichen Zeichensatz-Einstellungen zurück
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

