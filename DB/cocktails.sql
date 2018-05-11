SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cocktails`
--
DROP DATABASE `cocktails`;
CREATE DATABASE `cocktails` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cocktails`;

-- --------------------------------------------------------

--
-- Struttura della tabella `bottle_inventory`
--

DROP TABLE IF EXISTS `bottle_inventory`;
CREATE TABLE IF NOT EXISTS `bottle_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bottle_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bottle_id` (`bottle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `bottle_inventory`:
--   `bottle_id`
--       `bottles` -> `id`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `bottles`
--

DROP TABLE IF EXISTS `bottles`;
CREATE TABLE IF NOT EXISTS `bottles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `ml` int(11) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `bottles`:
--   `user_id`
--       `users` -> `id`
--

--
-- Triggers `bottles`
--
DROP TRIGGER IF EXISTS `cocktail_delete`;
DELIMITER //
CREATE TRIGGER `cocktail_delete` BEFORE DELETE ON `bottles`
 FOR EACH ROW BEGIN
  delete from cocktails where cocktails.id in (select recipes.cocktail_id from recipes where recipes.bottle_id = old.id); 
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `cocktails`
--

DROP TABLE IF EXISTS `cocktails`;
CREATE TABLE IF NOT EXISTS `cocktails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `cocktails`:
--   `user_id`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `recipes`
--

DROP TABLE IF EXISTS `recipes`;
CREATE TABLE IF NOT EXISTS `recipes` (
  `cocktail_id` int(11) NOT NULL DEFAULT '0',
  `bottle_id` int(11) NOT NULL DEFAULT '0',
  `ml` int(11) DEFAULT NULL,
  PRIMARY KEY (`cocktail_id`,`bottle_id`),
  KEY `bottle_id` (`bottle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `recipes`:
--   `cocktail_id`
--       `cocktails` -> `id`
--   `bottle_id`
--       `bottles` -> `id`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `auth` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `bottle_inventory`
--
ALTER TABLE `bottle_inventory`
  ADD CONSTRAINT `bottle_inventory_ibfk_1` FOREIGN KEY (`bottle_id`) REFERENCES `bottles` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `bottles`
--
ALTER TABLE `bottles`
  ADD CONSTRAINT `bottles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `cocktails`
--
ALTER TABLE `cocktails`
  ADD CONSTRAINT `cocktails_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`cocktail_id`) REFERENCES `cocktails` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipes_ibfk_2` FOREIGN KEY (`bottle_id`) REFERENCES `bottles` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
