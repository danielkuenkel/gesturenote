-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 19. Okt 2021 um 11:32
-- Server-Version: 5.7.25
-- PHP-Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `usr_web23266739_1`
--
CREATE DATABASE IF NOT EXISTS `usr_web23266739_1` DEFAULT CHARACTER SET latin1 COLLATE latin1_german1_ci;
USE `usr_web23266739_1`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `classification`
--

CREATE TABLE `classification` (
  `id` int(11) NOT NULL,
  `study_id` int(11) NOT NULL,
  `data` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gesture_id` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments_gesture_sets`
--

CREATE TABLE `comments_gesture_sets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `set_id` int(11) NOT NULL,
  `comment` varchar(500) CHARACTER SET utf8 NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gestures`
--

CREATE TABLE `gestures` (
  `id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `source` varchar(20) NOT NULL,
  `scope` varchar(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `title_quality` varchar(10) NOT NULL DEFAULT 'functional',
  `type` varchar(11) DEFAULT NULL,
  `interaction_type` varchar(11) DEFAULT NULL,
  `continuous_value_type` varchar(20) DEFAULT NULL,
  `context` varchar(200) NOT NULL,
  `association` varchar(500) DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  `joints` text NOT NULL,
  `double_sided_use` varchar(5) NOT NULL DEFAULT 'no',
  `preview_image` int(11) NOT NULL,
  `images` text,
  `gif` varchar(200) DEFAULT NULL,
  `sensor_data` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gestures_shared`
--

CREATE TABLE `gestures_shared` (
  `id` int(11) NOT NULL,
  `gesture_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `email` varchar(100) COLLATE latin1_german1_ci NOT NULL,
  `edit` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gesture_ratings`
--

CREATE TABLE `gesture_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gesture_id` int(11) NOT NULL,
  `ratings` text NOT NULL,
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gesture_sets`
--

CREATE TABLE `gesture_sets` (
  `id` int(11) NOT NULL,
  `study_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `scope` varchar(10) COLLATE latin1_german1_ci NOT NULL DEFAULT 'private',
  `title` varchar(512) COLLATE latin1_german1_ci NOT NULL,
  `gestures` text CHARACTER SET utf8,
  `sensor_data` text COLLATE latin1_german1_ci,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gesture_sets_shared`
--

CREATE TABLE `gesture_sets_shared` (
  `id` int(11) NOT NULL,
  `set_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `edit` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gesture_set_simulation`
--

CREATE TABLE `gesture_set_simulation` (
  `id` int(11) NOT NULL,
  `gesture_set_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `data` text COLLATE latin1_german1_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gesture_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `likes_sets`
--

CREATE TABLE `likes_sets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `set_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login_attempts`
--

CREATE TABLE `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `participation_requests`
--

CREATE TABLE `participation_requests` (
  `id` int(11) NOT NULL,
  `study_id` int(11) NOT NULL,
  `tester_id` text COLLATE latin1_german1_ci NOT NULL,
  `moderator_id` int(11) NOT NULL,
  `rtc_token` text COLLATE latin1_german1_ci NOT NULL,
  `name` varchar(100) COLLATE latin1_german1_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `current` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `studies`
--

CREATE TABLE `studies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `general_data` text NOT NULL,
  `url_token` varchar(40) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `studies_shared`
--

CREATE TABLE `studies_shared` (
  `id` int(11) NOT NULL,
  `study_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `email` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `edit` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `study_results_evaluator`
--

CREATE TABLE `study_results_evaluator` (
  `id` int(11) NOT NULL,
  `study_id` int(11) NOT NULL,
  `evaluator_id` int(11) NOT NULL,
  `tester_id` text NOT NULL,
  `data` text,
  `observations` text,
  `notes` text,
  `execution_phase` varchar(10) NOT NULL DEFAULT 'real',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `study_results_observer`
--

CREATE TABLE `study_results_observer` (
  `id` int(11) NOT NULL,
  `study_id` int(11) NOT NULL,
  `evaluator_id` int(11) NOT NULL,
  `tester_id` text COLLATE latin1_german1_ci NOT NULL,
  `data` text COLLATE latin1_german1_ci NOT NULL,
  `execution_phase` varchar(10) COLLATE latin1_german1_ci NOT NULL DEFAULT 'real',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `study_results_tester`
--

CREATE TABLE `study_results_tester` (
  `id` int(11) NOT NULL,
  `study_id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `data` text,
  `execution_phase` varchar(10) NOT NULL DEFAULT 'real',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `study_results_wizard`
--

CREATE TABLE `study_results_wizard` (
  `id` int(11) NOT NULL,
  `study_id` int(11) NOT NULL,
  `evaluator_id` int(11) NOT NULL,
  `tester_id` text COLLATE latin1_german1_ci NOT NULL,
  `data` text COLLATE latin1_german1_ci NOT NULL,
  `execution_phase` varchar(10) COLLATE latin1_german1_ci NOT NULL DEFAULT 'real',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `forename` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(128) NOT NULL,
  `birthday` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `usertype` varchar(9) DEFAULT 'evaluator',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password_reset` varchar(128) DEFAULT NULL,
  `tutorials` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `classification`
--
ALTER TABLE `classification`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `comments_gesture_sets`
--
ALTER TABLE `comments_gesture_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `gestures`
--
ALTER TABLE `gestures`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indizes für die Tabelle `gestures_shared`
--
ALTER TABLE `gestures_shared`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `gesture_ratings`
--
ALTER TABLE `gesture_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `gesture_sets`
--
ALTER TABLE `gesture_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `gesture_sets_shared`
--
ALTER TABLE `gesture_sets_shared`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `gesture_set_simulation`
--
ALTER TABLE `gesture_set_simulation`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `likes_sets`
--
ALTER TABLE `likes_sets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indizes für die Tabelle `participation_requests`
--
ALTER TABLE `participation_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `studies`
--
ALTER TABLE `studies`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `studies_shared`
--
ALTER TABLE `studies_shared`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `study_results_evaluator`
--
ALTER TABLE `study_results_evaluator`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `study_results_observer`
--
ALTER TABLE `study_results_observer`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `study_results_tester`
--
ALTER TABLE `study_results_tester`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `study_results_wizard`
--
ALTER TABLE `study_results_wizard`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `classification`
--
ALTER TABLE `classification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT für Tabelle `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT für Tabelle `comments_gesture_sets`
--
ALTER TABLE `comments_gesture_sets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT für Tabelle `gestures`
--
ALTER TABLE `gestures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=852;
--
-- AUTO_INCREMENT für Tabelle `gestures_shared`
--
ALTER TABLE `gestures_shared`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
--
-- AUTO_INCREMENT für Tabelle `gesture_ratings`
--
ALTER TABLE `gesture_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT für Tabelle `gesture_sets`
--
ALTER TABLE `gesture_sets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;
--
-- AUTO_INCREMENT für Tabelle `gesture_sets_shared`
--
ALTER TABLE `gesture_sets_shared`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT für Tabelle `gesture_set_simulation`
--
ALTER TABLE `gesture_set_simulation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT für Tabelle `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT für Tabelle `likes_sets`
--
ALTER TABLE `likes_sets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT für Tabelle `participation_requests`
--
ALTER TABLE `participation_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;
--
-- AUTO_INCREMENT für Tabelle `studies`
--
ALTER TABLE `studies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;
--
-- AUTO_INCREMENT für Tabelle `studies_shared`
--
ALTER TABLE `studies_shared`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
--
-- AUTO_INCREMENT für Tabelle `study_results_evaluator`
--
ALTER TABLE `study_results_evaluator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=435;
--
-- AUTO_INCREMENT für Tabelle `study_results_observer`
--
ALTER TABLE `study_results_observer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `study_results_tester`
--
ALTER TABLE `study_results_tester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=503;
--
-- AUTO_INCREMENT für Tabelle `study_results_wizard`
--
ALTER TABLE `study_results_wizard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
