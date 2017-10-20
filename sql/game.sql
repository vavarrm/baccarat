-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-04-14 12:08:36
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `poker`
--

-- --------------------------------------------------------

--
-- 表的结构 `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `winner` enum('player','banker','tip') NOT NULL,
  `winlose` int(11) NOT NULL,
  `bet` int(11) NOT NULL,
  `bet_double` int(11) NOT NULL,
  `player_point` bigint(20) NOT NULL,
  `banker_point` bigint(20) NOT NULL,
  `player_hand_card` varchar(40) NOT NULL,
  `player_hand_card_name` enum('Royal Straight Flush','Straight Flush','Four of a Kind','Full house','Flush','straight','set','Two Pairs','Pairs','High card') NOT NULL,
  `banker_hand_card` varchar(40) NOT NULL,
  `banker_hand_card_name` enum('Royal Straight Flush','Straight Flush','Four of a Kind','Full house','Flush','straight','set','Two Pairs','Pairs','High card') NOT NULL,
  `odds` int(3) NOT NULL,
  `player` varchar(12) NOT NULL,
  `add_time` datetime NOT NULL,
  `game_type` int(2) NOT NULL,
  `play_error` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `banker_hand_card_name` (`banker_hand_card_name`),
  KEY `player_hand_card_name` (`player_hand_card_name`),
  KEY `winner` (`winner`),
  KEY `game_type` (`game_type`),
  KEY `error` (`play_error`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=378 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
