-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 07 Lip 2016, 09:18
-- Wersja serwera: 5.5.49
-- Wersja PHP: 5.4.45-0+deb7u4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `doorAccessControl`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `time`
--

CREATE TABLE IF NOT EXISTS `time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pin` int(4) NOT NULL COMMENT 'foreig key from User table',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'time of insert',
  `coming` tinyint(1) NOT NULL COMMENT 'if user come to work is save TRUE, if go out save FALSE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=170 ;

--
-- Zrzut danych tabeli `time`
--

INSERT INTO `time` (`id`, `pin`, `time`, `coming`) VALUES
(147, 1234, '2016-07-05 08:00:00', 1),
(149, 8115, '2016-07-05 08:30:00', 1),
(150, 8115, '2016-07-05 16:15:00', 0),
(163, 1234, '2016-07-06 17:00:00', 0),
(164, 1234, '2016-07-07 07:07:41', 1),
(165, 1234, '2016-07-07 07:07:46', 0),
(166, 1234, '2016-07-07 08:03:12', 1),
(167, 1234, '2016-07-07 08:03:16', 0),
(168, 9755, '2016-07-07 08:03:36', 1),
(169, 9755, '2016-07-07 08:03:41', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id number of system user',
  `name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'name of system user',
  `surname` varchar(100) COLLATE utf8_bin NOT NULL,
  `pin` int(4) NOT NULL,
  `create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pin` (`pin`),
  KEY `pin_2` (`pin`),
  KEY `pin_3` (`pin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1018 ;

--
-- Zrzut danych tabeli `User`
--

INSERT INTO `User` (`id`, `name`, `surname`, `pin`, `create`) VALUES
(1, 'Krystian', 'Mikolaczyk', 1234, '2016-07-05 19:16:39'),
(1014, 'Marta', 'Antczak', 8115, '2016-07-06 17:08:45'),
(1015, 'Radoslaw', 'Urbaniak', 1378, '2016-07-06 17:09:13'),
(1016, 'Jan', 'Nowak', 3598, '2016-07-06 17:09:24'),
(1017, 'test', 'test', 9755, '2016-07-07 08:03:28');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
