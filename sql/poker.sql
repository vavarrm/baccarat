-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-04-12 06:42:54
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
CREATE DATABASE IF NOT EXISTS `poker` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `poker`;

DELIMITER $$
--
-- 存储过程
--
DROP PROCEDURE IF EXISTS `output_rate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `output_rate`()
    NO SQL
BEGIN
DECLARE  total INT;
SET total = (SELECT COUNT(*) FROM  `caribbean_poker_income`);
SELECT * FROM (
SELECT count(*) AS style_count ,total, ROUND(count(*)/total *100,3) AS pr, player_card_type FROM `caribbean_poker_income` GROUP BY `player_card_type`)
a ORDER BY pr ;

SELECT * FROM (
SELECT count(*) AS style_count ,total, ROUND(count(*)/total *100,3) AS pr, banker_card_type FROM `caribbean_poker_income` GROUP BY `banker_card_type`)
a ORDER BY pr ;
END$$

DROP PROCEDURE IF EXISTS `win`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `win`()
    NO SQL
BEGIN
  DECLARE i INT DEFAULT 1;
  DECLARE p INT DEFAULT 0;
  DECLARE winlose_total INT DEFAULT 0;
  DECLARE bet_total INT DEFAULT 0;
  DECLARE double_total INT DEFAULT 0;
  DECLARE bet_lose_rate double ;
  DECLARE total_lose_rate double ;

CREATE TEMPORARY TABLE temp1 (
     winlose INT DEFAULT 0 , 
     bet INT DEFAULT 0  ,
     `double` INT DEFAULT 0 
   ) ENGINE=MEMORY;
   
   CREATE TEMPORARY TABLE temp2 (
     winlose_total INT DEFAULT 0  ,
     bet_total INT DEFAULT 0  ,
     double_total INT DEFAULT 0  ,
     bet_lose_rate double,
     total_lose_rate double
   ) ENGINE=MEMORY;
   
    WHILE i > 0 DO
       /*truncate temp1;
    	INSERT INTO temp1(winlose, bet, `double`)
    	SELECT  winlose ,bet, `double` FROM `caribbean_poker_income`  ;*/
    	SET i = i - 1;
        
    
    SET winlose_total = (SELECT SUM(winlose) FROM `caribbean_poker_income`);
    
    SET bet_total = (SELECT SUM(bet) FROM `caribbean_poker_income`);
    SET double_total = (SELECT SUM(`double`) FROM `caribbean_poker_income`);
    INSERT INTO temp2 (winlose_total, bet_total,  bet_lose_rate, total_lose_rate,  double_total) VALUES(winlose_total, bet_total, winlose_total/bet_total, winlose_total/(bet_total+double_total),   double_total);
    END WHILE;
	SELECT *  FROM temp2 AS t ;
   SELECT sample ;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `caribbean_poker_income`
--

DROP TABLE IF EXISTS `caribbean_poker_income`;
CREATE TABLE IF NOT EXISTS `caribbean_poker_income` (
  `id` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `player_card_type` varchar(20) NOT NULL,
  `banker_card_type` varchar(20) NOT NULL,
  `banker_hand_card` varchar(255) NOT NULL,
  `banker_card_style` varchar(30) NOT NULL,
  `banker_card_point` bigint(21) NOT NULL,
  `player_hand_card` varchar(255) NOT NULL,
  `player_card_style` varchar(30) NOT NULL,
  `player_card_point` bigint(21) NOT NULL,
  `winner` enum('banker','player','tie') NOT NULL,
  `odds` int(11) NOT NULL DEFAULT '1',
  `bet` int(11) NOT NULL,
  `double` int(11) NOT NULL DEFAULT '0',
  `winlose` int(11) NOT NULL,
  `play_point` bigint(21) NOT NULL DEFAULT '1000000',
  `version` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1431398 ;

-- --------------------------------------------------------

--
-- 表的结构 `probability_table`
--

DROP TABLE IF EXISTS `probability_table`;
CREATE TABLE IF NOT EXISTS `probability_table` (
  `card_style` varchar(2) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `card_style` (`card_style`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66665 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
