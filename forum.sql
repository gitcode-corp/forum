-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2014 at 03:36 PM
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
-- Table structure for table `groups_roles`
--

CREATE TABLE IF NOT EXISTS `groups_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `security_group_id` int(11) NOT NULL,
  `security_role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_roles` (`security_group_id`,`security_role_id`),
  KEY `fk_groups_roles_security_groups1_idx` (`security_group_id`),
  KEY `fk_groups_roles_security_roles1_idx` (`security_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `groups_roles`
--

INSERT INTO `groups_roles` (`id`, `security_group_id`, `security_role_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_posts_topics1_idx` (`topic_id`),
  KEY `fk_posts_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `topic_id`, `user_id`, `content`, `created_on`) VALUES
(1, 1, 0, 'Jak w temacie.', '2014-12-23 16:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_topic_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` tinytext,
  `amount_topics` smallint(6) DEFAULT '0',
  `is_closed` tinyint(4) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_sections_topics1_idx` (`last_topic_id`),
  KEY `fk_sections_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `last_topic_id`, `user_id`, `name`, `description`, `amount_topics`, `is_closed`, `created_on`) VALUES
(1, NULL, 1, 'Przedszkole', 'Raczkujesz w tematyce WWW (PHP, SQL, (X)HTML, CSS, JS)? Tutaj możesz stanąć na nogi.', 1, 0, '2014-12-31 12:51:37'),
(2, NULL, 1, 'PHP', 'Zagadnienia dotyczące programowania w PHP.', 1, 0, '2014-12-31 11:03:33'),
(3, NULL, 1, 'Gotowe rozwiązania ', 'Wyszukiwanie, instalacja i konfiguracja a także przydatne opinie na temat gotowych skryptów i bibliotek PHP', 2, 0, '2014-12-31 11:03:29'),
(4, NULL, 1, 'Bazy danych ', 'Serwery baz danych i język SQL.', 0, 0, '2014-12-31 11:03:25'),
(5, NULL, 1, 'testt', '', 0, 0, '2014-12-31 12:43:01'),
(6, NULL, 1, 'testt', '', 0, 0, '2014-12-31 12:43:03'),
(7, NULL, 1, 'testt', '', 0, 0, '2014-12-31 12:43:12'),
(8, NULL, 1, 'testt', '', 0, 0, '2014-12-31 12:43:09'),
(9, NULL, 1, 'testt', '', 0, 0, '2014-12-31 12:43:06');

-- --------------------------------------------------------

--
-- Table structure for table `security_groups`
--

CREATE TABLE IF NOT EXISTS `security_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `security_groups`
--

INSERT INTO `security_groups` (`id`, `name`) VALUES
(1, 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `security_roles`
--

CREATE TABLE IF NOT EXISTS `security_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `security_roles`
--

INSERT INTO `security_roles` (`id`, `name`) VALUES
(3, 'ROLE_ADD_POST'),
(9, 'ROLE_ADD_SECTION'),
(4, 'ROLE_ADD_TOPIC'),
(14, 'ROLE_CHANGE_PASSWORD'),
(15, 'ROLE_CHANGE_TOPIC_STATUS'),
(7, 'ROLE_CLOSE_TOPIC'),
(2, 'ROLE_DELETE_POST'),
(11, 'ROLE_DELETE_SECTION'),
(6, 'ROLE_DELETE_TOPIC'),
(12, 'ROLE_DELETE_USER'),
(16, 'ROLE_EDIT_ALL_TOPICS'),
(1, 'ROLE_EDIT_POST'),
(10, 'ROLE_EDIT_SECTION'),
(5, 'ROLE_EDIT_TOPIC'),
(13, 'ROLE_EDIT_USER'),
(8, 'ROLE_OPEN_TOPIC');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `last_post_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` tinytext,
  `amount_posts` smallint(6) DEFAULT NULL,
  `is_closed` tinyint(4) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_topics_sections_idx` (`section_id`),
  KEY `fk_topics_posts1_idx` (`last_post_id`),
  KEY `fk_topics_users1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `section_id`, `last_post_id`, `user_id`, `name`, `description`, `amount_posts`, `is_closed`, `created_on`) VALUES
(1, 2, NULL, 0, 'Dziedziczenie w PHP', 'Jak to dziala?', 1, 0, '2014-12-23 16:09:12'),
(2, 1, NULL, 1, 'temat!!', 'pod!!', NULL, 1, '2014-12-31 12:49:49'),
(3, 1, NULL, 1, 'temat', 'pod!!', NULL, 0, '2014-12-31 12:50:30'),
(4, 1, NULL, 1, 'temat', 'pod!!', NULL, 0, '2014-12-31 12:51:10'),
(5, 1, NULL, 1, 'temat', 'pod!!', NULL, 0, '2014-12-31 12:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(12) NOT NULL,
  `amount_posts` smallint(6) DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `salt`, `amount_posts`, `created_on`) VALUES
(1, 'admin', 'admin@email.com', '39c8a79fd1dc520d9e36d6c4edf2a55453fb16c0', '621fd2214074', 0, '2014-12-29 17:04:14');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `security_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_groups` (`user_id`,`security_group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_security_groups1_idx` (`security_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `security_group_id`) VALUES
(1, 1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups_roles`
--
ALTER TABLE `groups_roles`
  ADD CONSTRAINT `fk_groups_roles_security_groups1` FOREIGN KEY (`security_group_id`) REFERENCES `security_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_groups_roles_security_roles1` FOREIGN KEY (`security_role_id`) REFERENCES `security_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_topics1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_posts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `fk_sections_topics1` FOREIGN KEY (`last_topic_id`) REFERENCES `topics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sections_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `fk_topics_posts1` FOREIGN KEY (`last_post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_topics_sections` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_topics_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_security_groups1` FOREIGN KEY (`security_group_id`) REFERENCES `security_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
