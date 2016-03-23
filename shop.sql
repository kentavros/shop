-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 23 2015 г., 15:32
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Bosch'),
(2, 'Intertool'),
(3, 'Makita'),
(4, 'Maktec'),
(5, 'Metabo'),
(6, 'Stanley'),
(7, 'DeWalt'),
(8, 'STIHL'),
(11, 'Husqvarna Group'),
(12, 'china_tools'),
(14, 'xepRRss11пп'),
(17, 'dfg1'),
(19, '22223'),
(21, 'test'),
(22, 'Jopa'),
(25, 'joopa2'),
(31, 'sadsadw44');

-- --------------------------------------------------------

--
-- Структура таблицы `tools`
--

CREATE TABLE IF NOT EXISTS `tools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

--
-- Дамп данных таблицы `tools`
--

INSERT INTO `tools` (`id`, `name`, `price`, `category_id`) VALUES
(1, 'Uneo1', '228888.00', 1),
(2, 'PBH 2100 RE', '1885.00', 1),
(3, 'PBH 2900', '2300.00', 1),
(4, 'Bosch PSB 500 RE', '1220.00', 1),
(5, 'PSB 650 RE', '1205.00', 1),
(6, 'Intertool Storm WT-0153', '2099.00', 2),
(7, 'Intertool Storm WT-0151', '1769.00', 2),
(8, 'Intertool Storm WT-0152', '1945.00', 2),
(9, 'Intertool SDS-plus DT-0181', '1149.00', 2),
(10, 'Intertool SDS-max DT-0195', '3099.00', 2),
(11, 'Makita HR2470', '2119.00', 3),
(12, 'Makita HR2230', '1269.00', 3),
(13, 'Makita HR2811FT', '4793.00', 3),
(14, 'Makita HR2470T', '2743.00', 3),
(15, 'Makita HR4002', '5937.00', 3),
(16, 'Maktec MT870', '1570.00', 4),
(17, 'Maktec MT815K', '1253.00', 4),
(18, 'Maktec MT814', '1500.00', 4),
(19, 'Maktec MT607', '821.00', 4),
(20, 'MT064SK2', '931.00', 4),
(21, 'Metabo BHE 2244', '2290.00', 5),
(22, 'Metabo KHE 2644', '2550.00', 5),
(23, 'Metabo SBE 601', '1595.00', 5),
(24, 'Metabo SBE 6013', '2150.00', 5),
(25, 'Metabo PowerMaxx BS', '2763.00', 5),
(26, 'STIHL MS 250', '9690.00', 8),
(27, 'STIHL MS 291', '9120.00', 8),
(28, 'STIHL MS 211', '6123.00', 8),
(29, 'Husqvarna9666399-06', '5144.00', 11),
(30, '435 E II ', '8302.00', 11),
(31, 'Husqvarna 440 E II ', '10548.00', 11),
(32, 'Husqvarna 4401 E II ', '10000.00', 11),
(33, 'DeWalt D25413K', '13033.00', 7),
(34, 'DeWalt D25103K SDS PLUS ', '6275.00', 7),
(35, 'DeWalt D25601K SDS-MAX ', '18785.00', 7),
(36, 'DeWalt D25124K', '7746.00', 7),
(37, 'DeWalt SDS-Max', '22027.00', 7),
(41, '222 bb', '78.00', 19),
(43, '222 OPAAAA', '1000.00', 19),
(44, 'red', '123.00', 19),
(46, 'rrrrrrr', '66777.00', 19),
(47, 'ttttttt111', '222.00', 19),
(53, 'rt', '45.00', 1),
(54, 'ed-67KL', '12300.00', 1),
(59, 'fro3', '890000.00', 28),
(60, 'SDfr-897654r', '4567.00', 8),
(61, 'teeeeeessssttt', '3333.00', 29),
(62, 'eeee', '444444.00', 1),
(63, 'AAA', '1000.00', 1),
(65, 'ty777', '77777.00', 3),
(66, 'eeee123', '4567.00', 4),
(67, 'test', '99999999.99', 21),
(71, 'qqq', '3456.00', 1),
(73, 'qwerty5678', '99999999.99', 4),
(74, 'werty', '12345.00', 4),
(75, 'RRRRo', '999.00', 4),
(78, 'rty', '56.00', 5),
(79, 'qwe', '678.00', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `pass`) VALUES
(3, 'admin2', '315f166c5aca63a157f7d41007675cb44a948b33');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
