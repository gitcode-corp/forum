-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2014 at 07:49 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `content` text,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_posts_topics1_idx` (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `topic_id`, `username`, `content`, `created_on`) VALUES
(1, 1, 'johnny', 'Jak w temacie.', '2014-12-23 16:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_topic_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` tinytext,
  `amount_topics` smallint(6) DEFAULT NULL,
  `is_closed` tinyint(4) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_sections_topics1_idx` (`last_topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `last_topic_id`, `name`, `description`, `amount_topics`, `is_closed`, `created_on`) VALUES
(1, NULL, 'Przedszkole', 'Raczkujesz w tematyce WWW (PHP, SQL, (X)HTML, CSS, JS)? Tutaj możesz stanąć na nogi.', 0, 0, '2014-12-23 16:05:55'),
(2, 1, 'PHP', 'Zagadnienia dotyczące programowania w PHP.', 1, 0, '2014-12-23 16:27:42'),
(3, NULL, 'Gotowe rozwiązania ', 'Wyszukiwanie, instalacja i konfiguracja a także przydatne opinie na temat gotowych skryptów i bibliotek PHP', 2, 0, '2014-12-23 16:10:37'),
(4, NULL, 'Bazy danych ', 'Serwery baz danych i język SQL.', 0, 0, '2014-12-23 16:07:25');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `last_post_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` tinytext,
  `amount_posts` smallint(6) DEFAULT NULL,
  `is_closed` tinyint(4) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_topics_sections_idx` (`section_id`),
  KEY `fk_topics_posts1_idx` (`last_post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `section_id`, `last_post_id`, `name`, `description`, `amount_posts`, `is_closed`, `created_on`) VALUES
(1, 2, NULL, 'Dziedziczenie w PHP', 'Jak to dziala?', 1, 0, '2014-12-23 16:09:12');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_topics1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `fk_sections_topics1` FOREIGN KEY (`last_topic_id`) REFERENCES `topics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `fk_topics_sections` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_topics_posts1` FOREIGN KEY (`last_post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
