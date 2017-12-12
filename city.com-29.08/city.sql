-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u8
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 29 2017 г., 23:25
-- Версия сервера: 5.5.57
-- Версия PHP: 5.4.45-0+deb7u9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `city`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ads`
--

CREATE TABLE IF NOT EXISTS `ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `ptype` int(1) NOT NULL,
  `city` varchar(255) NOT NULL,
  `phone` int(14) NOT NULL,
  `phone2` int(14) NOT NULL,
  `images` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '3' COMMENT '1-published,2-draft,3-temp',
  `author` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `ads`
--

INSERT INTO `ads` (`id`, `uid`, `name`, `slug`, `group`, `desc`, `price`, `ptype`, `city`, `phone`, `phone2`, `images`, `timestamp`, `status`, `author`) VALUES
(2, 'vJbX1KKOItjvfjau', 'Page', 'vJbX1KKOItjvfjau', '1', 'ffdfdfdf', '5000.00', 1, 'Moskva, Rossiya', 765656266, 0, '', '2017-08-24 06:44:30', 1, 'avgDXj7MH1A59SOD'),
(6, 'kEBE0Q9qZeqPy8l3', 'Ak test 1', 'kEBE0Q9qZeqPy8l3', '1', 'asdf asdf asdf', '12500.00', 1, 'Athens, Central Athens, Greece', 2147483647, 0, '', '2017-08-24 15:47:40', 1, 'n53mrULQ7r5kBGGN'),
(11, 'ehXowKNHcsUwaFM4', 'eto novoie obievlenie ot usera test1', 'ehXowKNHcsUwaFM4', '2', 'eto klasni tavar i nam nuzno ivo bistro prodat shtoba vsio bilo kruto', '566600.00', 1, 'Харьков, Харьковская область, Украина', 2147483647, 2147483647, '', '2017-08-28 13:32:35', 1, 'Hbk5L1v5PINt96rU'),
(12, 'oKSxbPAc8s33Na2Z', 'araik', 'oKSxbPAc8s33Na2Z', '1', 'hgdcgfdfgdfdgfdgf', '999999999.99', 1, 'Харьков, Харьковская область, Украина', 968596560, 859656054, '', '2017-08-28 14:46:25', 1, 'avgDXj7MH1A59SOD'),
(13, 'B4zRnUPowu4AX9E3', 'araik', 'B4zRnUPowu4AX9E3', '1', 'okdsofjdkjfkdj ', '90000.00', 1, 'Харьков, Харьковская область, Украина', 968596560, 524545454, '', '2017-08-28 14:48:31', 1, 'Hbk5L1v5PINt96rU');

-- --------------------------------------------------------

--
-- Структура таблицы `ad_groups`
--

CREATE TABLE IF NOT EXISTS `ad_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `ad_groups`
--

INSERT INTO `ad_groups` (`id`, `name`, `slug`, `desc`, `image`) VALUES
(1, 'GPS', 'gps', 'GPS devices', ''),
(2, 'Car Parts', 'carparts', 'Car Parts', ''),
(4, 'araik new', 'akakaj', 'araik news super desc', '');

-- --------------------------------------------------------

--
-- Структура таблицы `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `from` varchar(30) NOT NULL,
  `to` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(1) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=161 ;

--
-- Дамп данных таблицы `chat`
--

INSERT INTO `chat` (`id`, `parent`, `from`, `to`, `message`, `date`, `status`, `city`) VALUES
(1, 0, 'n53mrULQ7r5kBGGN', '', 'avradrfv', '0000-00-00 00:00:00', NULL, 'Athens, Central Athens, Greece'),
(2, 0, 'n53mrULQ7r5kBGGN', '', 'aerbear', '0000-00-00 00:00:00', NULL, 'Athens, Central Athens, Greece'),
(3, 0, 'n53mrULQ7r5kBGGN', '', 'aerbgvesag', '0000-00-00 00:00:00', NULL, 'Athens, Central Athens, Greece'),
(4, 0, 'n53mrULQ7r5kBGGN', '', 'aervbgse', '0000-00-00 00:00:00', NULL, 'Athens, Central Athens, Greece'),
(5, 0, 'n53mrULQ7r5kBGGN', '', 'abra', '2017-08-18 12:54:29', NULL, 'Athens, Central Athens, Greece'),
(6, 0, 'n53mrULQ7r5kBGGN', '', 'abrfvse', '2017-08-18 12:56:02', NULL, 'Athens, Central Athens, Greece'),
(7, 0, 'n53mrULQ7r5kBGGN', '', 'aasbfa', '2017-08-18 12:56:24', NULL, 'Athens, Central Athens, Greece'),
(8, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-18 12:56:29', NULL, 'Athens, Central Athens, Greece'),
(9, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-18 13:03:02', NULL, 'Athens, Central Athens, Greece'),
(10, 7, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-18 13:03:55', NULL, 'Athens, Central Athens, Greece'),
(11, 0, 'n53mrULQ7r5kBGGN', '', 'test2', '2017-08-18 13:44:12', NULL, 'Athens, Central Athens, Greece'),
(12, 0, 'avgDXj7MH1A59SOD', '', 'fgfgfg', '2017-08-18 14:00:31', NULL, 'Харьков, Харьковская область, Украина'),
(13, 0, 'avgDXj7MH1A59SOD', '', 'dfdfdf', '2017-08-18 14:00:34', NULL, 'Харьков, Харьковская область, Украина'),
(14, 0, 'avgDXj7MH1A59SOD', '', 'fdfdfdf', '2017-08-18 14:00:37', NULL, 'Харьков, Харьковская область, Украина'),
(15, 13, 'avgDXj7MH1A59SOD', '', '45454545455', '2017-08-18 14:00:52', NULL, 'Харьков, Харьковская область, Украина'),
(16, 11, 'n53mrULQ7r5kBGGN', '', 'reply to test2', '2017-08-18 14:06:45', NULL, 'Athens, Central Athens, Greece'),
(17, 6, 'n53mrULQ7r5kBGGN', '', 'arhgwsthn', '2017-08-18 14:09:00', NULL, 'Athens, Central Athens, Greece'),
(18, 0, 'avgDXj7MH1A59SOD', '', 'njbhhjbvhjvghvhgvkghv', '2017-08-18 16:06:43', NULL, 'Харьков, Харьковская область, Украина'),
(19, 0, 'avgDXj7MH1A59SOD', '', 'ccc', '2017-08-19 07:52:10', NULL, 'Madrid, Іспанія'),
(20, 0, 'avgDXj7MH1A59SOD', '', 'dsdsd', '2017-08-19 08:03:52', NULL, 'Madrid, Іспанія'),
(21, 19, 'avgDXj7MH1A59SOD', '', 'dsdsdsfsf\r\n', '2017-08-19 08:20:43', NULL, 'Madrid, Іспанія'),
(22, 21, 'avgDXj7MH1A59SOD', '', 'cxcxcx', '2017-08-19 08:22:48', NULL, 'Madrid, Іспанія'),
(23, 22, 'avgDXj7MH1A59SOD', '', 'cxcxcxc', '2017-08-19 08:23:07', NULL, 'Madrid, Іспанія'),
(24, 21, 'avgDXj7MH1A59SOD', '', 'fkf\r\n', '2017-08-19 08:23:46', NULL, 'Madrid, Іспанія'),
(25, 21, 'avgDXj7MH1A59SOD', '', 'cxcxc', '2017-08-19 08:24:36', NULL, 'Madrid, Іспанія'),
(26, 21, 'avgDXj7MH1A59SOD', '', 'dfdfdf', '2017-08-19 08:27:27', NULL, 'Madrid, Іспанія'),
(27, 19, 'avgDXj7MH1A59SOD', '', 'sdsf\r\n', '2017-08-19 08:29:05', NULL, 'Madrid, Іспанія'),
(28, 26, 'avgDXj7MH1A59SOD', '', 'fgfgfgfgfg', '2017-08-19 08:30:33', NULL, 'Madrid, Іспанія'),
(29, 20, 'avgDXj7MH1A59SOD', '', 'dfdfdfdf', '2017-08-19 08:31:00', NULL, 'Madrid, Іспанія'),
(30, 20, 'avgDXj7MH1A59SOD', '', 'dfdfdf', '2017-08-19 08:31:17', NULL, 'Madrid, Іспанія'),
(31, 0, 'n53mrULQ7r5kBGGN', '', 'asdg', '2017-08-19 10:37:16', NULL, 'Athens, Central Athens, Greece'),
(32, 0, 'n53mrULQ7r5kBGGN', '', 'arbvgethb', '2017-08-19 10:37:20', NULL, 'Athens, Central Athens, Greece'),
(33, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-19 10:37:25', NULL, 'Athens, Central Athens, Greece'),
(34, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-20 15:20:03', NULL, 'Athens, Central Athens, Greece'),
(35, 34, 'n53mrULQ7r5kBGGN', '', 'reply to test', '2017-08-20 15:20:27', NULL, 'Athens, Central Athens, Greece'),
(36, 34, 'n53mrULQ7r5kBGGN', '', '2 reply to test', '2017-08-20 15:21:13', NULL, 'Athens, Central Athens, Greece'),
(37, 33, 'n53mrULQ7r5kBGGN', '', 'reply to asd', '2017-08-20 15:21:34', NULL, 'Athens, Central Athens, Greece'),
(38, 0, 'avgDXj7MH1A59SOD', '', 'апвпапа', '2017-08-20 15:40:30', NULL, 'Madrid, Іспанія'),
(39, 0, 'avgDXj7MH1A59SOD', '', 'апапапапа', '2017-08-20 15:40:59', NULL, 'Madrid, Іспанія'),
(40, 0, 'avgDXj7MH1A59SOD', '', 'araik privet', '2017-08-20 15:52:23', NULL, 'Madrid, Іспанія'),
(41, 0, 'avgDXj7MH1A59SOD', '', 'dnbfdnfb', '2017-08-20 15:52:34', NULL, 'Madrid, Іспанія'),
(42, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-20 15:54:23', NULL, 'Athens, Central Athens, Greece'),
(43, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-20 15:54:42', NULL, 'Athens, Central Athens, Greece'),
(44, 0, 'n53mrULQ7r5kBGGN', '', 'masdf', '2017-08-20 15:54:47', NULL, 'Athens, Central Athens, Greece'),
(45, 0, 'n53mrULQ7r5kBGGN', '', 'mosc asdf', '2017-08-20 16:25:19', NULL, 'Moscow, Russia'),
(46, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-20 16:35:11', NULL, 'Moscow, Russia'),
(47, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-20 16:49:16', NULL, 'Ashdod, Israel'),
(48, 0, 'n53mrULQ7r5kBGGN', '', 'athens test', '2017-08-21 12:42:24', NULL, 'Athens, Central Athens, Greece'),
(49, 0, 'n53mrULQ7r5kBGGN', '', 'moscow test', '2017-08-21 12:42:43', NULL, 'Moscow, Russia'),
(50, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-21 12:43:05', NULL, 'Athens, Central Athens, Greece'),
(51, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-21 12:43:24', NULL, 'Athens, Central Athens, Greece'),
(52, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-21 12:45:40', NULL, 'Athens, Central Athens, Greece'),
(53, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-21 12:45:44', NULL, 'Athens, Central Athens, Greece'),
(54, 0, 'n53mrULQ7r5kBGGN', '', 'qeherthb', '2017-08-21 12:45:49', NULL, 'Athens, Central Athens, Greece'),
(55, 0, 'n53mrULQ7r5kBGGN', '', 'aerbhethwrth', '2017-08-21 12:45:53', NULL, 'Athens, Central Athens, Greece'),
(56, 0, 'n53mrULQ7r5kBGGN', '', 'argbvesrtbh', '2017-08-21 12:46:00', NULL, 'Athens, Central Athens, Greece'),
(57, 0, 'n53mrULQ7r5kBGGN', '', 'test1', '2017-08-21 12:46:06', NULL, 'Athens, Central Athens, Greece'),
(58, 0, 'n53mrULQ7r5kBGGN', '', 'er', '2017-08-21 12:46:27', NULL, 'Athens, Central Athens, Greece'),
(59, 0, 'avgDXj7MH1A59SOD', '', 'erfdfdfdfdfdf', '2017-08-21 12:53:56', NULL, 'Madrid, Іспанія'),
(60, 0, 'avgDXj7MH1A59SOD', '', 'dfdfdfdf', '2017-08-21 13:27:34', NULL, 'Moskva, Москва, Россия'),
(61, 0, 'avgDXj7MH1A59SOD', '', 'dsfdsfdf', '2017-08-21 13:27:42', NULL, 'Moskva, Москва, Россия'),
(62, 0, 'avgDXj7MH1A59SOD', '', ':a:', '2017-08-21 13:28:01', NULL, 'Moskva, Москва, Россия'),
(63, 0, 'avgDXj7MH1A59SOD', '', 'ghghghgh', '2017-08-21 13:29:00', NULL, 'Moskva, Москва, Россия'),
(64, 0, 'avgDXj7MH1A59SOD', '', ':kaixin::kaixin:', '2017-08-21 14:56:48', NULL, 'Moskva, Москва, Россия'),
(65, 0, 'n53mrULQ7r5kBGGN', '', ':tushe:', '2017-08-21 15:06:23', NULL, 'Athens, Central Athens, Greece'),
(66, 0, 'n53mrULQ7r5kBGGN', '', ':lu:', '2017-08-21 15:06:53', NULL, 'Athens, Central Athens, Greece'),
(67, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-21 15:06:56', NULL, 'Athens, Central Athens, Greece'),
(68, 0, 'n53mrULQ7r5kBGGN', '', ':tu:', '2017-08-21 15:12:14', NULL, 'Athens, Central Athens, Greece'),
(69, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-21 15:12:17', NULL, 'Athens, Central Athens, Greece'),
(70, 0, 'n53mrULQ7r5kBGGN', '', ':bugaoxing:', '2017-08-21 15:24:25', NULL, 'Athens, Central Athens, Greece'),
(71, 0, 'n53mrULQ7r5kBGGN', '', ':guai:', '2017-08-21 15:24:28', NULL, 'Athens, Central Athens, Greece'),
(72, 0, 'avgDXj7MH1A59SOD', '', ' nb b', '2017-08-22 07:51:22', NULL, 'Madrid, Іспанія'),
(73, 0, 'avgDXj7MH1A59SOD', '', 'hjvghvh', '2017-08-22 07:51:50', NULL, 'Madrid, Іспанія'),
(74, 0, 'avgDXj7MH1A59SOD', '', 'hvhv', '2017-08-22 07:51:57', NULL, 'Madrid, Іспанія'),
(75, 0, 'avgDXj7MH1A59SOD', '', 'nbhb', '2017-08-22 07:52:04', NULL, 'Madrid, Іспанія'),
(76, 0, 'avgDXj7MH1A59SOD', '', 'm n ', '2017-08-22 07:52:09', NULL, 'Madrid, Іспанія'),
(77, 0, 'n53mrULQ7r5kBGGN', '', 'aarber', '2017-08-22 09:07:53', NULL, 'Athens, Central Athens, Greece'),
(78, 0, 'n53mrULQ7r5kBGGN', '', 'argvbesrgv', '2017-08-22 09:07:56', NULL, 'Athens, Central Athens, Greece'),
(79, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-22 09:13:50', NULL, 'Athens, Central Athens, Greece'),
(80, 0, 'n53mrULQ7r5kBGGN', '', 'test2', '2017-08-22 09:13:53', NULL, 'Athens, Central Athens, Greece'),
(81, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-22 09:14:28', NULL, 'Athens, Central Athens, Greece'),
(82, 0, 'n53mrULQ7r5kBGGN', '', 'test2', '2017-08-22 09:14:38', NULL, 'Athens, Central Athens, Greece'),
(83, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-22 09:16:23', NULL, 'Athens, Central Athens, Greece'),
(84, 0, 'n53mrULQ7r5kBGGN', '', 'test2', '2017-08-22 09:16:26', NULL, 'Athens, Central Athens, Greece'),
(85, 0, 'n53mrULQ7r5kBGGN', '', ':bishi:', '2017-08-22 11:47:31', NULL, 'Athens, Central Athens, Greece'),
(86, 0, 'avgDXj7MH1A59SOD', '', ':caihong:', '2017-08-22 12:17:47', NULL, 'Madrid, Іспанія'),
(87, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-22 14:23:04', NULL, 'Madrid, Іспанія'),
(88, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-22 14:24:37', NULL, 'Madrid, Іспанія'),
(89, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-22 14:25:00', NULL, 'Madrid, Іспанія'),
(90, 0, 'avgDXj7MH1A59SOD', '', ':tushe:', '2017-08-22 14:30:19', NULL, 'Madrid, Іспанія'),
(91, 0, 'avgDXj7MH1A59SOD', '', ':tushe:', '2017-08-22 15:01:11', NULL, 'Madrid, Іспанія'),
(92, 0, 'avgDXj7MH1A59SOD', '', ':han:', '2017-08-22 15:01:21', NULL, 'Madrid, Іспанія'),
(93, 0, 'avgDXj7MH1A59SOD', '', ':meigui:', '2017-08-22 15:01:37', NULL, 'Madrid, Іспанія'),
(94, 0, 'avgDXj7MH1A59SOD', '', ':tushe::qian:', '2017-08-22 15:03:42', NULL, 'Madrid, Іспанія'),
(95, 0, 'n53mrULQ7r5kBGGN', '', ':hehe:', '2017-08-22 15:26:39', NULL, 'Athens, Central Athens, Greece'),
(96, 0, 'n53mrULQ7r5kBGGN', '', ':hehe:', '2017-08-22 23:51:27', NULL, 'Athens, Central Athens, Greece'),
(97, 0, 'avgDXj7MH1A59SOD', '', 'gfgffgg', '2017-08-23 05:57:55', NULL, 'Madrid, Іспанія'),
(98, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-23 05:57:59', NULL, 'Madrid, Іспанія'),
(99, 0, 'avgDXj7MH1A59SOD', '', ':zhenbang:', '2017-08-23 05:58:07', NULL, 'Madrid, Іспанія'),
(100, 0, 'avgDXj7MH1A59SOD', '', ':zhenbang:', '2017-08-23 05:58:10', NULL, 'Madrid, Іспанія'),
(101, 0, 'avgDXj7MH1A59SOD', '', ':qian:', '2017-08-23 05:58:13', NULL, 'Madrid, Іспанія'),
(102, 0, 'avgDXj7MH1A59SOD', '', ':a:', '2017-08-23 05:59:18', NULL, 'Москва, Россия'),
(103, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-23 05:59:18', NULL, 'Москва, Россия'),
(104, 0, 'avgDXj7MH1A59SOD', '', ':a:', '2017-08-23 05:59:28', NULL, 'Москва, Россия'),
(105, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-23 05:59:37', NULL, 'Москва, Россия'),
(106, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-23 05:59:44', NULL, 'Москва, Россия'),
(107, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-23 05:59:46', NULL, 'Москва, Россия'),
(108, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-23 05:59:47', NULL, 'Москва, Россия'),
(109, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-23 05:59:48', NULL, 'Москва, Россия'),
(110, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-23 06:10:15', NULL, 'Athens, Central Athens, Greece'),
(111, 0, 'n53mrULQ7r5kBGGN', '', ':bishi:', '2017-08-23 06:10:25', NULL, 'Athens, Central Athens, Greece'),
(112, 0, 'avgDXj7MH1A59SOD', '', ':tushe:', '2017-08-23 06:15:24', NULL, 'Madrid, Іспанія'),
(113, 0, 'avgDXj7MH1A59SOD', '', ':xxyl:\r\n', '2017-08-23 06:16:20', NULL, 'Madrid, Іспанія'),
(114, 0, 'avgDXj7MH1A59SOD', '', ':liwu:', '2017-08-23 06:16:45', NULL, 'Madrid, Іспанія'),
(115, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-23 06:17:23', NULL, 'Madrid, Іспанія'),
(116, 0, 'avgDXj7MH1A59SOD', '', ':xiaonian:', '2017-08-23 06:21:14', NULL, 'Madrid, Іспанія'),
(117, 0, 'avgDXj7MH1A59SOD', '', ':bugaoxing:', '2017-08-23 06:21:57', NULL, 'Madrid, Іспанія'),
(118, 0, 'avgDXj7MH1A59SOD', '', ':tushe:', '2017-08-23 08:00:31', NULL, 'Madrid, Іспанія'),
(119, 0, 'avgDXj7MH1A59SOD', '', ':tushe:', '2017-08-23 08:02:02', NULL, 'Madrid, Іспанія'),
(120, 0, 'avgDXj7MH1A59SOD', '', ':aixin:', '2017-08-23 08:02:34', NULL, 'Madrid, Іспанія'),
(121, 0, 'avgDXj7MH1A59SOD', '', ':tushe:', '2017-08-23 08:13:26', NULL, 'Madrid, Іспанія'),
(122, 0, 'avgDXj7MH1A59SOD', '', ':bugaoxing:', '2017-08-23 08:14:10', NULL, 'Madrid, Іспанія'),
(123, 0, 'avgDXj7MH1A59SOD', '', ':tushe:', '2017-08-23 08:15:38', NULL, 'Madrid, Іспанія'),
(124, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-23 08:18:16', NULL, 'Madrid, Іспанія'),
(125, 0, 'avgDXj7MH1A59SOD', '', ':tushe:', '2017-08-23 08:18:18', NULL, 'Madrid, Іспанія'),
(126, 0, 'avgDXj7MH1A59SOD', '', ':tu:', '2017-08-23 08:18:28', NULL, 'Madrid, Іспанія'),
(127, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-23 08:22:38', NULL, 'Madrid, Іспанія'),
(128, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-23 08:24:17', NULL, 'Madrid, Іспанія'),
(129, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-23 08:54:46', NULL, 'Madrid, Іспанія'),
(130, 0, 'avgDXj7MH1A59SOD', '', ':caihong:', '2017-08-23 08:56:13', NULL, 'Madrid, Іспанія'),
(131, 0, 'n53mrULQ7r5kBGGN', '', ':bishi:', '2017-08-23 12:23:58', NULL, 'Athens, Central Athens, Greece'),
(132, 0, 'avgDXj7MH1A59SOD', '', ':tushe:', '2017-08-24 06:13:01', NULL, 'Madrid, Іспанія'),
(133, 0, 'avgDXj7MH1A59SOD', '', ':taikaixin:', '2017-08-24 13:24:06', NULL, 'Madrid, Іспанія'),
(134, 0, 'avgDXj7MH1A59SOD', '', ':neng:', '2017-08-24 13:24:12', NULL, 'Madrid, Іспанія'),
(135, 0, 'avgDXj7MH1A59SOD', '', ':xiaonian:', '2017-08-24 13:24:19', NULL, 'Madrid, Іспанія'),
(136, 0, 'avgDXj7MH1A59SOD', '', 'njmbvhjvhjv', '2017-08-24 13:51:19', NULL, 'Madrid, Іспанія'),
(137, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-24 13:51:30', NULL, 'Madrid, Іспанія'),
(138, 0, 'n53mrULQ7r5kBGGN', '', ':qianbi:', '2017-08-24 15:09:51', NULL, 'Athens, Central Athens, Greece'),
(139, 0, 'avgDXj7MH1A59SOD', '', 'ghghgh', '2017-08-25 06:13:41', NULL, 'Madrid, Іспанія'),
(140, 0, 'n53mrULQ7r5kBGGN', '', ':qianbi:', '2017-08-25 14:23:53', NULL, 'Athens, Central Athens, Greece'),
(141, 136, 'avgDXj7MH1A59SOD', '', 'рджржрл', '2017-08-28 08:10:15', NULL, 'Madrid, Іспанія'),
(142, 140, 'n53mrULQ7r5kBGGN', '', 'agvaervg', '2017-08-28 08:58:55', NULL, 'Athens, Central Athens, Greece'),
(143, 14, 'avgDXj7MH1A59SOD', '', 'fddgfg', '2017-08-28 10:14:59', NULL, 'Харьков, Харьковская область, Украина'),
(144, 18, 'avgDXj7MH1A59SOD', '', 'dfdfdf', '2017-08-28 10:15:22', NULL, 'Харьков, Харьковская область, Украина'),
(145, 18, 'avgDXj7MH1A59SOD', '', 'dfdfdf', '2017-08-28 10:15:26', NULL, 'Харьков, Харьковская область, Украина'),
(146, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-28 10:17:57', NULL, 'Athens, Central Athens, Greece'),
(147, 146, 'n53mrULQ7r5kBGGN', '', 'asdfg', '2017-08-28 10:18:01', NULL, 'Athens, Central Athens, Greece'),
(148, 146, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-28 10:18:04', NULL, 'Athens, Central Athens, Greece'),
(149, 146, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-28 10:18:36', NULL, 'Athens, Central Athens, Greece'),
(150, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-28 10:18:48', NULL, 'Athens, Central Athens, Greece'),
(151, 150, 'n53mrULQ7r5kBGGN', '', 'asdfarewg', '2017-08-28 10:18:55', NULL, 'Athens, Central Athens, Greece'),
(152, 0, 'n53mrULQ7r5kBGGN', '', 'asdv', '2017-08-28 10:18:59', NULL, 'Athens, Central Athens, Greece'),
(153, 152, 'n53mrULQ7r5kBGGN', '', 'argverg', '2017-08-28 10:19:03', NULL, 'Athens, Central Athens, Greece'),
(154, 0, 'avgDXj7MH1A59SOD', '', 'jbhjbhb', '2017-08-28 11:27:51', NULL, 'Харьков, Харьковская область, Украина'),
(155, 154, 'avgDXj7MH1A59SOD', '', 'fgfgfg', '2017-08-28 11:27:58', NULL, 'Харьков, Харьковская область, Украина'),
(156, 0, 'avgDXj7MH1A59SOD', '', ':tushe:', '2017-08-28 12:12:58', NULL, 'Moskva, Москва, Россия'),
(157, 0, 'avgDXj7MH1A59SOD', '', ':ku:', '2017-08-28 12:33:29', NULL, 'Харьков, Харьковская область, Украина'),
(158, 0, 'avgDXj7MH1A59SOD', '', ':yiwen:', '2017-08-28 13:04:46', NULL, 'Moskva, Москва, Россия'),
(159, 0, 'Hbk5L1v5PINt96rU', '', 'апапапапап :haha:', '2017-08-28 13:16:17', NULL, 'Пермь, Пермский край, Россия'),
(160, 0, 'vSRjzcRtwSOUlLYR', '', ':caihong:', '2017-08-28 13:47:45', NULL, '');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `from` varchar(255) NOT NULL,
  `unit` varchar(32) NOT NULL,
  `entity` varchar(32) NOT NULL,
  `entid` varchar(64) NOT NULL,
  `description` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `parent`, `from`, `unit`, `entity`, `entid`, `description`, `timestamp`, `uid`, `city`) VALUES
(1, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '68', 'test', '2017-08-18 15:13:06', '', 'Athens, Central Athens, Greece'),
(3, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '68', 'aerbaergbv', '2017-08-18 15:15:53', '', 'Athens, Central Athens, Greece'),
(4, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '68', 'aregvqaeeras', '2017-08-18 15:16:57', '', 'Athens, Central Athens, Greece'),
(5, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '68', 'arbgvaserg', '2017-08-18 15:18:30', '', 'Athens, Central Athens, Greece'),
(6, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '68', 'test2', '2017-08-18 15:18:41', '', 'Athens, Central Athens, Greece'),
(7, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '68', 'test3', '2017-08-18 15:18:45', '', 'Athens, Central Athens, Greece'),
(8, 0, 'avgDXj7MH1A59SOD', 'maps', '', '3', 'gffgfgfg', '2017-08-18 15:19:53', '', 'Харьков, Харьковская область, Украина'),
(9, 0, 'avgDXj7MH1A59SOD', 'maps', '', '3', 'fgfgfgfgfg', '2017-08-18 15:19:59', '', 'Харьков, Харьковская область, Украина'),
(10, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '3', 'argvarewg', '2017-08-18 15:20:11', '', 'Athens, Central Athens, Greece'),
(11, 0, 'avgDXj7MH1A59SOD', 'maps', '', '3', 'dfdfdf', '2017-08-18 15:20:35', '', 'Харьков, Харьковская область, Украина'),
(12, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '78', 'asdf', '2017-08-18 15:52:53', '', 'Athens, Central Athens, Greece'),
(13, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '78', 'areeagr', '2017-08-18 15:53:59', '', 'Athens, Central Athens, Greece'),
(14, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '78', 'aasdf', '2017-08-18 15:56:43', '', 'Athens, Central Athens, Greece'),
(15, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '78', 'asdf', '2017-08-18 15:57:01', '', 'Athens, Central Athens, Greece'),
(16, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '78', 'testa', '2017-08-18 15:57:32', '', 'Athens, Central Athens, Greece'),
(17, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '78', 'asdf', '2017-08-18 15:58:58', '', 'Athens, Central Athens, Greece'),
(18, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '78', 'asdf', '2017-08-18 15:59:08', '', 'Athens, Central Athens, Greece'),
(19, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '78', 'asdf', '2017-08-18 15:59:48', '', 'Athens, Central Athens, Greece'),
(20, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '81', 'asdf', '2017-08-18 16:01:51', '', 'Athens, Central Athens, Greece'),
(21, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '81', 'asdfvg', '2017-08-18 16:02:40', '', 'Athens, Central Athens, Greece'),
(22, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '1', 'aabrvesarvg', '2017-08-18 16:06:36', '', 'Athens, Central Athens, Greece'),
(23, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '1', 'asdf', '2017-08-18 16:09:12', '', 'Athens, Central Athens, Greece'),
(24, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '1', 'arewvb', '2017-08-18 17:11:37', '', 'Athens, Central Athens, Greece'),
(25, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '2', 'asdfgasfg', '2017-08-19 11:15:15', '', 'Athens, Central Athens, Greece'),
(26, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '2', 'asdgbvaerb', '2017-08-19 11:16:36', '', 'Athens, Central Athens, Greece'),
(27, 0, 'n53mrULQ7r5kBGGN', 'maps', '', '2', 'asdf', '2017-08-19 11:19:11', '', 'Athens, Central Athens, Greece'),
(28, 10, 'avgDXj7MH1A59SOD', 'maps', '', '3', 'рудлдщ фддфд', '2017-08-20 15:48:37', '', 'Madrid, Іспанія'),
(29, 10, 'avgDXj7MH1A59SOD', 'maps', '', '3', '', '2017-08-20 15:48:37', '', 'Madrid, Іспанія'),
(30, 0, 'n53mrULQ7r5kBGGN', 'maps', '', 'iSDSClgnmV8G9OIu', 'asdf', '2017-08-21 09:11:21', '', 'Athens, Central Athens, Greece'),
(31, 0, 'n53mrULQ7r5kBGGN', 'maps', '', 'iSDSClgnmV8G9OIu', 'asdfgabr', '2017-08-21 09:12:40', '', 'Athens, Central Athens, Greece'),
(32, 0, 'n53mrULQ7r5kBGGN', 'maps', '', 'mCHx0J4XqZaab9Fs', 'awergf', '2017-08-21 10:11:36', '', 'Athens, Central Athens, Greece'),
(33, 0, 'avgDXj7MH1A59SOD', 'maps', '', 'mCHx0J4XqZaab9Fs', 'jkhjhj', '2017-08-21 15:50:05', '', 'Madrid, Іспанія'),
(34, 0, 'n53mrULQ7r5kBGGN', 'maps', '', 'mCHx0J4XqZaab9Fs', 'asdf', '2017-08-23 12:22:25', '', 'Athens, Central Athens, Greece'),
(35, 0, 'Hbk5L1v5PINt96rU', 'maps', '', '80gSBG5sJLlWsGJ8', 'bgnhnhnhn', '2017-08-28 13:24:56', '', 'Москва, Россия'),
(36, 0, 'Hbk5L1v5PINt96rU', 'maps', '', '80gSBG5sJLlWsGJ8', 'hnhnhnhnhnh', '2017-08-28 13:25:00', '', 'Москва, Россия'),
(37, 0, 'Hbk5L1v5PINt96rU', 'maps', '', '80gSBG5sJLlWsGJ8', 'yhnhnhnhnhnh', '2017-08-28 13:28:13', '', 'Москва, Россия'),
(38, 0, 'Hbk5L1v5PINt96rU', 'maps', '', '80gSBG5sJLlWsGJ8', 'hnhnhn', '2017-08-28 13:28:15', '', 'Москва, Россия');

-- --------------------------------------------------------

--
-- Структура таблицы `complain`
--

CREATE TABLE IF NOT EXISTS `complain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ops` varchar(255) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `option` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `complain`
--

INSERT INTO `complain` (`id`, `ops`, `uid`, `from`, `to`, `option`, `text`, `timestamp`) VALUES
(1, 'ads', 'M82aXEhOQVuG41Cu', 'n53mrULQ7r5kBGGN', 'n53mrULQ7r5kBGGN', '1', '			asgbsedgh	\r\n			', '2017-08-23 13:53:04'),
(2, 'users2', 'n53mrULQ7r5kBGGN', 'n53mrULQ7r5kBGGN', '', '1', '				\r\n			aewrgerg', '2017-08-23 13:53:19'),
(3, 'users2', 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', '', '2', '				\r\n			ll', '2017-08-23 14:14:12'),
(4, 'ads', 'vJbX1KKOItjvfjau', 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', '1', 'hjbjbhb', '2017-08-24 14:58:46'),
(5, 'ads', 'vJbX1KKOItjvfjau', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', '1', '							\r\n						asdf', '2017-08-24 15:13:41'),
(6, 'ads', 'vJbX1KKOItjvfjau', '3IxI1oYV5IPf945y', 'avgDXj7MH1A59SOD', '2', 'sdrasti vot znachti chilavek sibia ploxa vidiot i nuzno snim shtota sdelat', '2017-08-28 13:52:42'),
(7, 'ads', 'vJbX1KKOItjvfjau', '3IxI1oYV5IPf945y', 'avgDXj7MH1A59SOD', '1', 'tghghgh', '2017-08-28 13:52:51'),
(8, 'ads', 'vJbX1KKOItjvfjau', '3IxI1oYV5IPf945y', 'avgDXj7MH1A59SOD', '1', 'tytytyt', '2017-08-28 13:53:12'),
(9, 'ads', 'kEBE0Q9qZeqPy8l3', 'vSRjzcRtwSOUlLYR', 'n53mrULQ7r5kBGGN', '2', 'xzdxzx', '2017-08-28 13:54:02'),
(10, 'ads', 'kEBE0Q9qZeqPy8l3', '3IxI1oYV5IPf945y', 'n53mrULQ7r5kBGGN', '2', 'fgfgfgfgfgfg', '2017-08-28 13:54:27'),
(11, 'ads', 'kEBE0Q9qZeqPy8l3', 'vSRjzcRtwSOUlLYR', 'n53mrULQ7r5kBGGN', '2', 'mj;ljl', '2017-08-28 13:57:43'),
(12, 'ads', 'kEBE0Q9qZeqPy8l3', 'vSRjzcRtwSOUlLYR', 'n53mrULQ7r5kBGGN', '1', '', '2017-08-28 13:57:50'),
(13, 'ads', 'kEBE0Q9qZeqPy8l3', 'vSRjzcRtwSOUlLYR', 'n53mrULQ7r5kBGGN', '2', 'ddd', '2017-08-28 13:57:55'),
(14, 'ads', 'kEBE0Q9qZeqPy8l3', 'vSRjzcRtwSOUlLYR', 'n53mrULQ7r5kBGGN', '1', 'xxx', '2017-08-28 14:01:01'),
(15, 'ads', 'kEBE0Q9qZeqPy8l3', 'vSRjzcRtwSOUlLYR', 'n53mrULQ7r5kBGGN', '2', 'дрдлит', '2017-08-28 14:02:23'),
(16, 'users2', '6VatEDhkt55i0EKI', '6VatEDhkt55i0EKI', '', '2', 'n bb b b', '2017-08-28 15:27:16');

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Дамп данных таблицы `feedback`
--

INSERT INTO `feedback` (`id`, `uid`, `text`, `date`) VALUES
(1, 'avgDXj7MH1A59SOD', '			\r\n		sdsd', '0000-00-00 00:00:00'),
(2, 'avgDXj7MH1A59SOD', 'new', '2017-08-22 12:50:53'),
(3, 'avgDXj7MH1A59SOD', ':haha:', '2017-08-22 14:42:55'),
(4, 'avgDXj7MH1A59SOD', 'fggvcvcv', '2017-08-22 15:08:17'),
(5, 'avgDXj7MH1A59SOD', 'hjklhjklhjkl', '2017-08-23 07:35:01'),
(6, 'avgDXj7MH1A59SOD', 'hjklhjklhjkl', '2017-08-23 07:35:32'),
(7, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:34'),
(8, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:36'),
(9, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:37'),
(10, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:37'),
(11, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:38'),
(12, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:40'),
(13, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:41'),
(14, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:43'),
(15, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:44'),
(16, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:46'),
(17, 'avgDXj7MH1A59SOD', '', '2017-08-23 09:12:48'),
(18, 'avgDXj7MH1A59SOD', 'l;', '2017-08-23 09:14:38'),
(19, 'avgDXj7MH1A59SOD', 'dddsd', '2017-08-23 09:15:28'),
(20, 'avgDXj7MH1A59SOD', 'вывывыв', '2017-08-23 09:16:19'),
(21, 'avgDXj7MH1A59SOD', 'ошибка', '2017-08-23 09:17:48'),
(22, 'avgDXj7MH1A59SOD', 'ыыыы', '2017-08-23 09:18:29'),
(23, 'avgDXj7MH1A59SOD', 'fgfgfgfg', '2017-08-23 09:20:06'),
(24, 'avgDXj7MH1A59SOD', 'fgfgfgfg', '2017-08-23 09:20:16'),
(25, 'avgDXj7MH1A59SOD', 'dsdd', '2017-08-23 12:29:32'),
(26, 'avgDXj7MH1A59SOD', 'New', '2017-08-23 12:30:30'),
(27, 'avgDXj7MH1A59SOD', 'Ошибка', '2017-08-23 14:09:45'),
(28, 'avgDXj7MH1A59SOD', '[[[[[[[[[[', '2017-08-23 14:11:58'),
(29, 'avgDXj7MH1A59SOD', 'vbvbvb', '2017-08-24 13:27:26');

-- --------------------------------------------------------

--
-- Структура таблицы `googlemaplabels`
--

CREATE TABLE IF NOT EXISTS `googlemaplabels` (
  `id` tinyint(15) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL,
  `user` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lat` varchar(30) NOT NULL,
  `long` varchar(30) NOT NULL,
  `desc` text NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `googlemaplabels`
--

INSERT INTO `googlemaplabels` (`id`, `uid`, `user`, `username`, `date`, `lat`, `long`, `desc`, `type`, `title`) VALUES
(1, 'CEnW8sg9IIhKKAUq', 'n53mrULQ7r5kBGGN', 'ak', '2017-08-21 10:08:52', '38.0418496', '23.68836090000002', 'asdaebtb', 1, 'Ak test 1'),
(2, 'mCHx0J4XqZaab9Fs', 'n53mrULQ7r5kBGGN', 'ak', '2017-08-21 10:09:45', '49.9848273', '36.18878399999994', 'aregvbes', 3, 'ak test 2'),
(3, '4ljGFk10L88ph1IA', 'n53mrULQ7r5kBGGN', 'ak', '2017-08-23 15:30:42', '38.0418496', '23.68836090000002', 'rewtuigrf kjhgqjrewh kljqhglkewr', 3, 'Ak Test 3'),
(4, '80gSBG5sJLlWsGJ8', 'Hbk5L1v5PINt96rU', 'test1', '2017-08-28 13:23:16', '49.9757402', '36.18373550000001', 'eto unas dtp pozalusta pomogiti kto mozit i kto riadom', 1, 'eto test metka');

-- --------------------------------------------------------

--
-- Структура таблицы `helpchat`
--

CREATE TABLE IF NOT EXISTS `helpchat` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `from` varchar(30) NOT NULL,
  `to` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(1) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

--
-- Дамп данных таблицы `helpchat`
--

INSERT INTO `helpchat` (`id`, `parent`, `from`, `to`, `message`, `date`, `status`, `city`) VALUES
(1, 0, 'n53mrULQ7r5kBGGN', '', 'asgvawerg', '2017-08-19 12:01:46', NULL, 'Athens, Central Athens, Greece'),
(2, 0, 'avgDXj7MH1A59SOD', '', 'kjbhvhj', '2017-08-19 12:02:30', NULL, 'Madrid, Іспанія'),
(3, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-19 12:02:30', NULL, 'Madrid, Іспанія'),
(4, 0, 'avgDXj7MH1A59SOD', '', 'njbhjbhjb', '2017-08-19 12:02:36', NULL, 'Madrid, Іспанія'),
(5, 0, 'n53mrULQ7r5kBGGN', '', 'asdfavwa', '2017-08-19 12:15:58', NULL, 'Athens, Central Athens, Greece'),
(6, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-21 07:04:46', NULL, 'Madrid, Іспанія'),
(7, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-21 07:05:48', NULL, 'Madrid, Іспанія'),
(8, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-21 07:14:30', NULL, 'Madrid, Іспанія'),
(9, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-21 07:14:33', NULL, 'Madrid, Іспанія'),
(10, 0, 'avgDXj7MH1A59SOD', '', 'пдлпдлг', '2017-08-21 07:14:37', NULL, 'Madrid, Іспанія'),
(11, 0, 'avgDXj7MH1A59SOD', '', 'ощощд', '2017-08-21 07:15:03', NULL, 'Madrid, Іспанія'),
(12, 0, 'avgDXj7MH1A59SOD', '', 'тор.дл', '2017-08-21 07:15:29', NULL, 'Madrid, Іспанія'),
(13, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-21 07:15:38', NULL, 'Madrid, Іспанія'),
(14, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-21 07:19:10', NULL, 'Madrid, Іспанія'),
(15, 0, 'avgDXj7MH1A59SOD', '', 'ввввв', '2017-08-21 07:19:35', NULL, 'Madrid, Іспанія'),
(16, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-21 08:01:27', NULL, 'Madrid, Іспанія'),
(17, 0, 'n53mrULQ7r5kBGGN', '', '', '2017-08-21 08:01:52', NULL, 'Athens, Central Athens, Greece'),
(18, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-21 08:01:56', NULL, 'Madrid, Іспанія'),
(19, 0, 'avgDXj7MH1A59SOD', '', ' :) 						\r\n					\r\n						\r\n						\r\n					 :(  :( ', '2017-08-21 08:57:33', NULL, 'Madrid, Іспанія'),
(20, 0, 'avgDXj7MH1A59SOD', '', ':mellow: <_< ', '2017-08-21 09:10:40', NULL, 'Madrid, Іспанія'),
(21, 0, 'avgDXj7MH1A59SOD', '', ' :) ', '2017-08-21 09:29:00', NULL, 'Madrid, Іспанія'),
(22, 0, 'avgDXj7MH1A59SOD', '', '		\r\n			:hehe:		', '2017-08-21 10:06:37', NULL, 'Madrid, Іспанія'),
(23, 0, 'avgDXj7MH1A59SOD', '', ':haha:		\r\n					', '2017-08-21 10:10:36', NULL, 'Madrid, Іспанія'),
(24, 0, 'avgDXj7MH1A59SOD', '', ':hehe::yinxian:		\r\n					', '2017-08-21 10:11:50', NULL, 'Madrid, Іспанія'),
(25, 0, 'avgDXj7MH1A59SOD', '', ':hehe:		\r\n					', '2017-08-21 10:17:37', NULL, 'Madrid, Іспанія'),
(26, 0, 'avgDXj7MH1A59SOD', '', ':huaji:', '2017-08-21 10:17:46', NULL, 'Madrid, Іспанія'),
(27, 0, 'avgDXj7MH1A59SOD', '', ':hehe:						\r\n						\r\n						\r\n					', '2017-08-21 10:26:54', NULL, 'Madrid, Іспанія'),
(28, 0, 'avgDXj7MH1A59SOD', '', ':tushe:						\r\n						\r\n						\r\n					', '2017-08-21 10:32:17', NULL, 'Madrid, Іспанія'),
(29, 0, 'avgDXj7MH1A59SOD', '', ':haha: :heixian:						\r\n						\r\n					', '2017-08-21 10:42:24', NULL, 'Madrid, Іспанія'),
(30, 0, 'avgDXj7MH1A59SOD', '', ':hehe:						\r\n						\r\n					', '2017-08-21 10:49:32', NULL, 'Madrid, Іспанія'),
(31, 0, 'avgDXj7MH1A59SOD', '', '', '2017-08-21 10:49:44', NULL, 'Madrid, Іспанія'),
(32, 0, 'avgDXj7MH1A59SOD', '', ':zhenbang:						\r\n						\r\n					', '2017-08-21 12:32:56', NULL, 'Madrid, Іспанія'),
(33, 0, 'avgDXj7MH1A59SOD', '', ':dangao::bugaoxing::yinxian::araik:						\r\n						\r\n					', '2017-08-21 12:50:48', NULL, 'Madrid, Іспанія'),
(34, 0, 'avgDXj7MH1A59SOD', '', '						\r\n				:kuanghan:	', '2017-08-21 13:08:25', NULL, 'Madrid, Іспанія'),
(35, 0, 'avgDXj7MH1A59SOD', '', ':hehe:', '2017-08-21 13:11:00', NULL, 'Madrid, Іспанія'),
(36, 34, 'avgDXj7MH1A59SOD', '', ':kaixin:						\r\n					', '2017-08-21 13:12:01', NULL, 'Madrid, Іспанія'),
(37, 0, 'avgDXj7MH1A59SOD', '', ':qian:						\r\n					', '2017-08-21 13:17:41', NULL, 'Madrid, Іспанія'),
(38, 0, 'n53mrULQ7r5kBGGN', '', ':hehe:						\r\n					', '2017-08-21 13:18:27', NULL, 'Athens, Central Athens, Greece'),
(39, 0, 'avgDXj7MH1A59SOD', '', ':lei::lei::zhenbang: :kuanghan:', '2017-08-21 13:18:49', NULL, 'Madrid, Іспанія'),
(40, 0, 'avgDXj7MH1A59SOD', '', '						\r\n					', '2017-08-21 14:50:53', NULL, 'Madrid, Іспанія'),
(41, 0, 'avgDXj7MH1A59SOD', '', '						\r\n					', '2017-08-21 14:52:21', NULL, 'Madrid, Іспанія'),
(42, 0, 'avgDXj7MH1A59SOD', '', ':lu:						\r\n					', '2017-08-21 14:53:47', NULL, 'Madrid, Іспанія'),
(43, 0, 'n53mrULQ7r5kBGGN', '', ':haha:						\r\n					', '2017-08-21 15:03:24', NULL, 'Athens, Central Athens, Greece'),
(44, 0, 'n53mrULQ7r5kBGGN', '', ':yiwen:						\r\n					', '2017-08-21 15:04:10', NULL, 'Athens, Central Athens, Greece'),
(45, 0, 'n53mrULQ7r5kBGGN', '', ':lei:', '2017-08-21 15:04:27', NULL, 'Athens, Central Athens, Greece'),
(46, 0, 'n53mrULQ7r5kBGGN', '', '						\r\n					test', '2017-08-22 09:16:35', NULL, 'Athens, Central Athens, Greece'),
(47, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-22 09:16:39', NULL, 'Athens, Central Athens, Greece'),
(48, 0, 'n53mrULQ7r5kBGGN', '', '						\r\n					asdf', '2017-08-23 06:09:17', NULL, 'Athens, Central Athens, Greece'),
(49, 0, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-23 06:09:22', NULL, 'Athens, Central Athens, Greece'),
(50, 0, 'avgDXj7MH1A59SOD', '', ':hehe:						\r\n					', '2017-08-23 07:55:26', NULL, 'Madrid, Іспанія'),
(51, 0, 'avgDXj7MH1A59SOD', '', ':jinku:', '2017-08-23 07:55:35', NULL, 'Madrid, Іспанія'),
(52, 0, 'avgDXj7MH1A59SOD', '', ':bishi:', '2017-08-23 07:55:47', NULL, 'Madrid, Іспанія'),
(53, 0, 'avgDXj7MH1A59SOD', '', ':hehe:						\r\n					', '2017-08-23 08:03:12', NULL, 'Madrid, Іспанія'),
(54, 0, 'avgDXj7MH1A59SOD', '', ':haha:', '2017-08-23 08:03:18', NULL, 'Madrid, Іспанія'),
(55, 0, 'avgDXj7MH1A59SOD', '', ':hehe:						\r\n					', '2017-08-23 08:03:52', NULL, 'Madrid, Іспанія'),
(56, 0, 'avgDXj7MH1A59SOD', '', ':tushe::lu:						\r\n					', '2017-08-23 08:55:03', NULL, 'Madrid, Іспанія'),
(57, 0, 'avgDXj7MH1A59SOD', '', ':caihong:						\r\n					', '2017-08-23 08:55:31', NULL, 'Madrid, Іспанія'),
(58, 0, 'avgDXj7MH1A59SOD', '', 'jjjjj\r\n					', '2017-08-23 08:57:01', NULL, 'Madrid, Іспанія'),
(59, 0, 'avgDXj7MH1A59SOD', '', '						\r\n					ghghghg', '2017-08-23 09:21:57', NULL, 'Москва, Россия'),
(60, 0, 'avgDXj7MH1A59SOD', '', '						ghgh\r\n					', '2017-08-23 09:22:07', NULL, 'Москва, Россия'),
(61, 0, 'avgDXj7MH1A59SOD', '', 'Araik privet', '2017-08-28 11:29:15', NULL, 'Харьков, Харьковская область, Украина'),
(62, 0, 'avgDXj7MH1A59SOD', '', '						ddddd\r\n					', '2017-08-28 11:29:32', NULL, 'Харьков, Харьковская область, Украина'),
(63, 0, 'avgDXj7MH1A59SOD', '', 'bn vb b \r\n					', '2017-08-28 12:03:05', NULL, 'Харьков, Харьковская область, Украина'),
(64, 0, 'n53mrULQ7r5kBGGN', '', 'asdfgasdfg', '2017-08-28 12:03:38', NULL, 'Athens, Central Athens, Greece'),
(65, 0, 'n53mrULQ7r5kBGGN', '', 'aarbv', '2017-08-28 12:04:39', NULL, 'Athens, Central Athens, Greece'),
(66, 0, 'n53mrULQ7r5kBGGN', '', 'test', '2017-08-28 12:04:45', NULL, 'Athens, Central Athens, Greece'),
(67, 0, 'n53mrULQ7r5kBGGN', '', 'test1', '2017-08-28 12:07:39', NULL, 'Athens, Central Athens, Greece'),
(68, 0, 'n53mrULQ7r5kBGGN', '', 'test2', '2017-08-28 12:07:45', NULL, 'Athens, Central Athens, Greece'),
(69, 68, 'n53mrULQ7r5kBGGN', '', 'test22', '2017-08-28 12:07:52', NULL, 'Athens, Central Athens, Greece'),
(70, 0, 'n53mrULQ7r5kBGGN', '', 'test3', '2017-08-28 12:07:55', NULL, 'Athens, Central Athens, Greece'),
(71, 0, 'avgDXj7MH1A59SOD', '', 'hjvghvghv', '2017-08-28 12:09:26', NULL, 'Харьков, Харьковская область, Украина'),
(72, 0, 'avgDXj7MH1A59SOD', '', 'm n nm', '2017-08-28 12:09:55', NULL, 'Moskva, Москва, Россия'),
(73, 0, 'avgDXj7MH1A59SOD', '', ' ,,mbknbkj', '2017-08-28 12:10:01', NULL, 'Moskva, Москва, Россия'),
(74, 0, 'avgDXj7MH1A59SOD', '', ':qian:', '2017-08-28 12:13:05', NULL, 'Moskva, Москва, Россия'),
(75, 0, 'Hbk5L1v5PINt96rU', '', 'апапап  ап ап', '2017-08-28 13:16:29', NULL, 'Пермь, Пермский край, Россия');

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `unit` varchar(32) NOT NULL,
  `entity` varchar(32) NOT NULL,
  `entid` varchar(64) NOT NULL,
  `filename` varchar(256) NOT NULL,
  `title` varchar(256) NOT NULL,
  `alt` varchar(256) NOT NULL,
  `path` varchar(256) NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` varchar(11) NOT NULL,
  `temp` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=158 ;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `unit`, `entity`, `entid`, `filename`, `title`, `alt`, `path`, `description`, `type`, `temp`, `timestamp`) VALUES
(2, 'user', 'avatar', 'XZyhTGckzaZ3cdY2', 'solo.gif', '', '', 'temp/ops/users/img', '', '', '', '0000-00-00 00:00:00'),
(3, 'user', 'avatar', 'iqZWdJJHGTTLkrS4', 'bezvih.gif', '', '', 'temp/ops/users/img', '', '', '', '0000-00-00 00:00:00'),
(4, 'user', 'avatar', '4K5bXBYyWHwAiy2X', 'vihodnie.gif', '', '', 'temp/ops/users/img', '', '', '', '0000-00-00 00:00:00'),
(5, 'user', 'avatar', 'Su4XdY9zS5qJJYtu', 'B_LOS.GIF', '', '', 'temp/ops/users/img', '', '', '', '0000-00-00 00:00:00'),
(6, 'maps', 'marker', '', 'map-marker.png', '', '', 'temp/ops/maps/img', '', '1', '0', '0000-00-00 00:00:00'),
(7, 'maps', 'marker', '', 'map-marker-2.png', '', '', 'temp/ops/maps/img', '', '2', '0', '0000-00-00 00:00:00'),
(8, 'maps', 'marker', '', 'map-marker-3.png', '', '', 'temp/ops/maps/img', '', '3', '0', '0000-00-00 00:00:00'),
(9, 'maps', 'marker', '', 'map.png', '', '', 'temp/ops/maps/img', '', '4', '0', '0000-00-00 00:00:00'),
(11, 'ads', 'upload', 't5rD9v4aukA', '1451473337607.jpg', '', '', 'uploads/t5rD9v4aukA', '', '', '1', '2017-07-28 01:05:26'),
(12, 'ads', 'upload', 't5rD9v4aukA', '1451473314291.jpg', '', '', 'uploads/t5rD9v4aukA', '', '', '1', '2017-07-28 01:05:26'),
(13, 'ads', 'upload', 't5rD9v4aukA', '1562662.jpg', '', '', 'uploads/t5rD9v4aukA', '', '', '1', '2017-07-28 01:05:34'),
(14, 'user', 'avatar', 'n53mrULQ7r5kBGGN', 'AC_Syndicate-wallpaper-10891312.jpg', '', '', 'uploads/t5rD9v4aukA', '', '', '1', '2017-07-28 01:05:38'),
(15, 'ads', 'upload', 't5rD9v4aukA', 'Alley-wallpaper-10238915.jpg', '', '', 'uploads/t5rD9v4aukA', '', '', '1', '2017-07-28 01:05:38'),
(16, 'ads', 'upload', 't5rD9v4aukA', 'Alien_Connection-wallpaper-10499578.jpg', '', '', 'uploads/t5rD9v4aukA', '', '', '1', '2017-07-28 01:05:38'),
(17, 'ads', 'upload', 'Z1hH7GJcexq', '4.JPG', '', '', 'uploads/Z1hH7GJcexq', '', '', '1', '2017-07-28 07:38:03'),
(18, 'ads', 'upload', 'Z1hH7GJcexq', '13-500x431.JPG', '', '', 'uploads/Z1hH7GJcexq', '', '', '1', '2017-07-28 07:38:03'),
(19, 'ads', 'upload', 'Z1hH7GJcexq', '6-500x381.JPG', '', '', 'uploads/Z1hH7GJcexq', '', '', '1', '2017-07-28 07:38:03'),
(20, 'ads', 'upload', 'Z1hH7GJcexq', '87730-18071.jpg', '', '', 'uploads/Z1hH7GJcexq', '', '', '1', '2017-07-28 07:39:06'),
(21, 'ads', 'upload', 'Z1hH7GJcexq', '63172561.jpg', '', '', 'uploads/Z1hH7GJcexq', '', '', '1', '2017-07-28 07:39:19'),
(22, 'ads', 'upload', 'Z1hH7GJcexq', '63172561.jpg', '', '', 'uploads/Z1hH7GJcexq', '', '', '1', '2017-07-28 07:39:57'),
(23, 'ads', 'upload', 'Z1hH7GJcexq', '87730-18071.jpg', '', '', 'uploads/Z1hH7GJcexq', '', '', '1', '2017-07-28 07:40:21'),
(24, 'ads', 'upload', 'Z1hH7GJcexq', '63172561.jpg', '', '', 'uploads/Z1hH7GJcexq', '', '', '1', '2017-07-28 07:41:00'),
(25, 'ads', 'upload', 'X8Su51xQWhX', '4.JPG', '', '', 'uploads/X8Su51xQWhX', '', '', '1', '2017-08-01 11:27:09'),
(26, 'ads', 'upload', 'X8Su51xQWhX', '6-500x381.JPG', '', '', 'uploads/X8Su51xQWhX', '', '', '1', '2017-08-01 11:27:09'),
(27, 'ads', 'upload', 'X8Su51xQWhX', '13-500x431.JPG', '', '', 'uploads/X8Su51xQWhX', '', '', '1', '2017-08-01 11:27:09'),
(28, 'ads', 'upload', 'X8Su51xQWhX', '63172561.jpg', '', '', 'uploads/X8Su51xQWhX', '', '', '1', '2017-08-01 11:27:09'),
(29, 'ads', 'upload', 'X8Su51xQWhX', '87730-18071.jpg', '', '', 'uploads/X8Su51xQWhX', '', '', '1', '2017-08-01 11:27:16'),
(30, 'maps', 'upload', 'ALnbEANnpLP', 'anonim.png', '', '', 'uploads/ALnbEANnpLP', '', '', '1', '2017-08-02 08:50:47'),
(31, 'maps', 'upload', 'ALnbEANnpLP', 'accident.png', '', '', 'uploads/ALnbEANnpLP', '', '', '1', '2017-08-02 08:51:38'),
(32, 'maps', 'upload', 'sRe8NhYIv2P', 'hqdefault.jpg', '', '', 'uploads/sRe8NhYIv2P', '', '', '1', '2017-08-02 08:57:34'),
(33, 'maps', 'upload', 'F8FLJrODvCa', 'car5.jpg', '', '', 'uploads/F8FLJrODvCa', '', '', '1', '2017-08-02 09:00:03'),
(34, 'maps', 'upload', 'UjmeHfLktVG', '6-500x381.JPG', '', '', 'uploads/UjmeHfLktVG', '', '', '1', '2017-08-04 06:31:32'),
(35, 'maps', 'upload', 'UjmeHfLktVG', '4.JPG', '', '', 'uploads/UjmeHfLktVG', '', '', '1', '2017-08-04 06:31:32'),
(36, 'maps', 'upload', 'UjmeHfLktVG', '63172561.jpg', '', '', 'uploads/UjmeHfLktVG', '', '', '1', '2017-08-04 06:31:32'),
(37, 'maps', 'upload', 'UjmeHfLktVG', '87730-18071.jpg', '', '', 'uploads/UjmeHfLktVG', '', '', '1', '2017-08-04 06:31:33'),
(38, 'ads', 'upload', '0EIaSjD64mU', '361.jpg', '', '', 'uploads/0EIaSjD64mU', '', '', '1', '2017-08-05 11:13:32'),
(39, 'ads', 'upload', 'DGjpPSsCVgK', 'Aventador-wallpaper-10888137.jpg', '', '', 'uploads/DGjpPSsCVgK', '', '', '1', '2017-08-07 10:12:45'),
(40, 'ads', 'upload', 'DGjpPSsCVgK', 'Beach_Hd-wallpaper-10916168.jpg', '', '', 'uploads/DGjpPSsCVgK', '', '', '1', '2017-08-07 10:12:46'),
(41, 'ads', 'upload', 'DGjpPSsCVgK', 'Beautiful__Landscape-wallpaper-10909292.jpg', '', '', 'uploads/DGjpPSsCVgK', '', '', '1', '2017-08-07 10:12:46'),
(42, 'ads', 'upload', 'DGjpPSsCVgK', 'Beautiful__Landscape-wallpaper-10917214.jpg', '', '', 'uploads/DGjpPSsCVgK', '', '', '1', '2017-08-07 10:12:50'),
(43, 'ads', 'upload', 'aYLT7dxGOBz', '21245.jpg', '', '', 'uploads/aYLT7dxGOBz', '', '', '1', '2017-08-07 10:13:57'),
(44, 'ads', 'upload', 'aYLT7dxGOBz', '16499.jpg', '', '', 'uploads/aYLT7dxGOBz', '', '', '1', '2017-08-07 10:13:59'),
(45, 'ads', 'upload', 'aYLT7dxGOBz', '10090.jpg', '', '', 'uploads/aYLT7dxGOBz', '', '', '1', '2017-08-07 10:14:00'),
(46, 'ads', 'upload', 'OKi0LCfziyo', '21245.jpg', '', '', 'uploads/OKi0LCfziyo', '', '', '0', '2017-08-07 10:31:17'),
(47, 'ads', 'upload', 'OKi0LCfziyo', '10090.jpg', '', '', 'uploads/OKi0LCfziyo', '', '', '0', '2017-08-07 10:31:19'),
(48, 'ads', 'upload', 'OKi0LCfziyo', '16499.jpg', '', '', 'uploads/OKi0LCfziyo', '', '', '0', '2017-08-07 10:31:20'),
(49, 'ads', 'upload', 'KqvxLK2fgMM', '10090.jpg', '', '', 'uploads/KqvxLK2fgMM', '', '', '0', '2017-08-07 11:00:39'),
(51, 'maps', 'upload', 'JXG01p81zVJ', '0_68286_416c313d_XXXL.jpg', '', '', 'uploads/JXG01p81zVJ', '', '', '1', '2017-08-08 07:59:34'),
(52, 'maps', 'upload', 'JXG01p81zVJ', '87730-18071.jpg', '', '', 'uploads/JXG01p81zVJ', '', '', '1', '2017-08-08 08:00:00'),
(53, 'ads', 'upload', 'QeRELFqTKtf', 'Angry_Wolves_Art-wallpaper-10895390.jpg', '', '', 'uploads/QeRELFqTKtf', '', '', '0', '2017-08-09 11:21:54'),
(66, 'maps', 'upload', 'YUcz4gTeJri', 'banner.png', '', '', 'uploads/YUcz4gTeJri', '', '', '1', '2017-08-10 13:15:43'),
(67, 'maps', 'upload', 'whIwjNgENTR', 'accident.png', '', '', 'uploads/whIwjNgENTR', '', '', '1', '2017-08-10 13:17:16'),
(68, 'maps', 'upload', 'MioE1n47ufg', 'anonim.png', '', '', 'uploads/MioE1n47ufg', '', '', '0', '2017-08-10 13:28:11'),
(69, 'maps', 'upload', 'MioE1n47ufg', 'accident.png', '', '', 'uploads/MioE1n47ufg', '', '', '0', '2017-08-10 13:28:15'),
(70, 'maps', 'upload', 'xDfw7n9DRyo', 'banner.png', '', '', 'uploads/xDfw7n9DRyo', '', '', '0', '2017-08-10 13:29:54'),
(71, 'maps', 'upload', 'xDfw7n9DRyo', 'accident.png', '', '', 'uploads/xDfw7n9DRyo', '', '', '0', '2017-08-10 13:29:59'),
(72, 'maps', 'upload', 'nWFjIF0K7EI', 'banner.png', '', '', 'uploads/nWFjIF0K7EI', '', '', '0', '2017-08-10 13:32:54'),
(73, 'maps', 'upload', 'Bbik0IIvZsR', 'arrows.png', '', '', 'uploads/Bbik0IIvZsR', '', '', '0', '2017-08-10 13:37:47'),
(74, 'maps', 'upload', 'HMJ3ECrNXPZ', 'accident.png', '', '', 'uploads/HMJ3ECrNXPZ', '', '', '0', '2017-08-10 13:54:24'),
(75, 'maps', 'upload', 'WXC8Rzpi41A', '1305203058_1.jpg', '', '', 'uploads/WXC8Rzpi41A', '', '', '0', '2017-08-10 13:59:45'),
(76, 'maps', 'upload', 'PIgA0IesjtU', '13-500x431.JPG', '', '', 'uploads/PIgA0IesjtU', '', '', '0', '2017-08-10 14:05:13'),
(77, 'maps', 'upload', 'rYe2xplLTGP', '63172561.jpg', '', '', 'uploads/rYe2xplLTGP', '', '', '0', '2017-08-10 14:13:32'),
(78, 'maps', 'upload', 'oYE6bMoMNvM', '87730-18071.jpg', '', '', 'uploads/oYE6bMoMNvM', '', '', '0', '2017-08-10 14:15:45'),
(79, 'maps', 'upload', 'AGuCB9FqkhF', '02e-aa-17 (1).jpg', '', '', 'uploads/AGuCB9FqkhF', '', '', '0', '2017-08-10 14:18:32'),
(80, 'maps', 'upload', 'xh7QZUex0TG', '87730-18071.jpg', '', '', 'uploads/xh7QZUex0TG', '', '', '1', '2017-08-10 14:21:03'),
(81, 'maps', 'upload', 'apJ34PxcFuR', '1451473314291.jpg', '', '', 'uploads/apJ34PxcFuR', '', '', '1', '2017-08-10 14:22:51'),
(82, 'maps', 'upload', 'OgBERfvJHQw', '4.JPG', '', '', 'uploads/OgBERfvJHQw', '', '', '0', '2017-08-10 14:32:04'),
(83, 'ads', 'upload', '1eZNZK7urrG', 'Angry_Wolves_Art-wallpaper-10895390.jpg', '', '', 'uploads/1eZNZK7urrG', '', '', '0', '2017-08-10 15:55:36'),
(84, 'ads', 'upload', '1eZNZK7urrG', 'Angry_Kitty-wallpaper-10566593.jpg', '', '', 'uploads/1eZNZK7urrG', '', '', '0', '2017-08-10 15:55:37'),
(85, 'ads', 'upload', '1eZNZK7urrG', 'Aqua_Flower-wallpaper-10252032.jpg', '', '', 'uploads/1eZNZK7urrG', '', '', '0', '2017-08-10 15:55:38'),
(86, 'ads', 'upload', 'MSfd5hVbt3g', '21245.jpg', '', '', 'uploads/MSfd5hVbt3g', '', '', '0', '2017-08-10 15:57:22'),
(87, 'ads', 'upload', 'MSfd5hVbt3g', '16499.jpg', '', '', 'uploads/MSfd5hVbt3g', '', '', '0', '2017-08-10 15:57:23'),
(88, 'ads', 'upload', 'MSfd5hVbt3g', '10090.jpg', '', '', 'uploads/MSfd5hVbt3g', '', '', '0', '2017-08-10 15:57:24'),
(89, 'user', 'avatar', 'ihd86UPMBCozVnsD', 'bezvih.gif', '', '', 'temp/ops/users/img', '', '', '', '2017-08-14 11:37:22'),
(90, 'maps', 'upload', 'x5lT4EOxv2sSk2bh', '1451473337607.jpg', '', '', 'uploads/x5lT4EOxv2sSk2bh', '', '', '0', '2017-08-14 12:54:31'),
(91, 'maps', 'avatar', 'cKfKW5XMfYrFKVg7', 'bezvih.gif', '', '', 'temp/ops/users/img', '', '', '', '2017-08-14 14:10:27'),
(92, 'user', 'avatar', 'cKfKW5XMfYrFKVg7', 'bezvih.gif	', '', '', 'temp/ops/users/img', '', '', '', '2017-08-16 06:13:41'),
(93, 'maps', 'upload', 'a9MmVD7pi7WV6pjo', '1451473314291.jpg', '', '', 'uploads/a9MmVD7pi7WV6pjo', '', '', '0', '2017-08-16 12:19:47'),
(94, 'users2', 'upload', '', '361.jpg', '', '', 'uploads/', '', '', '1', '2017-08-16 15:25:58'),
(95, 'users', 'upload', 'n53mrULQ7r5kBGGN', '1562662.jpg', '', '', 'uploads/n53mrULQ7r5kBGGN', '', '', '1', '2017-08-16 15:31:34'),
(96, 'users', 'upload', 'n53mrULQ7r5kBGGN', '1562662.jpg', '', '', 'uploads/n53mrULQ7r5kBGGN', '', '', '1', '2017-08-16 15:40:12'),
(97, 'users', 'upload', 'avgDXj7MH1A59SOD', '4.JPG', '', '', 'uploads/avgDXj7MH1A59SOD', '', '', '1', '2017-08-16 16:18:22'),
(98, 'ads', 'upload', '1eZNZK7urrG', '0b76136566fdee465e8ac45eeffe8460.png', '', '', 'uploads/1eZNZK7urrG', '', '', '1', '2017-08-18 10:02:09'),
(99, 'ads', 'upload', '1eZNZK7urrG', 'heartstone.jpg', '', '', 'uploads/1eZNZK7urrG', '', '', '1', '2017-08-18 10:15:27'),
(100, 'ads', 'upload', '1eZNZK7urrG', 'import.JPG', '', '', 'uploads/1eZNZK7urrG', '', '', '1', '2017-08-18 10:15:34'),
(105, 'maps', 'upload', 'iqZwULqOcwJLQPvp', '1432551084_tropical-palms-17.png', '', '', 'uploads/iqZwULqOcwJLQPvp', '', '', '1', '2017-08-18 11:10:34'),
(106, 'maps', 'upload', 'MhgimIIAyufFUPSQ', '1432551084_tropical-palms-17.png', '', '', 'uploads/MhgimIIAyufFUPSQ', '', '', '1', '2017-08-18 11:16:30'),
(107, 'maps', 'upload', 'VOxL2evG8jy819uU', '361.jpg', '', '', 'uploads/VOxL2evG8jy819uU', '', '', '0', '2017-08-18 16:00:51'),
(108, 'maps', 'upload', 'ImYzWAeYPZCA7BRf', '361.jpg', '', '', 'uploads/ImYzWAeYPZCA7BRf', '', '', '0', '2017-08-18 16:05:39'),
(109, 'maps', 'upload', 'AwsfdxXOVaeVXIaa', '4.JPG', '', '', 'uploads/AwsfdxXOVaeVXIaa', '', '', '0', '2017-08-19 11:14:41'),
(110, 'maps', 'upload', 'PHpaeLddn96yF1l4', 'heartstone.jpg', '', '', 'uploads/PHpaeLddn96yF1l4', '', '', '0', '2017-08-20 15:30:50'),
(111, 'maps', 'upload', 'cuWfvZmDFo0XNyS4', 'search copy.jpg', '', '', 'uploads/cuWfvZmDFo0XNyS4', '', '', '0', '2017-08-20 15:33:20'),
(112, 'maps', 'upload', '82fcQpGF3liE6h0P', 'getImage (6).jpg', '', '', 'uploads/82fcQpGF3liE6h0P', '', '', '0', '2017-08-20 15:35:39'),
(113, 'maps', 'upload', 'oSuYsJMUQQMqw3qI', '1920x1080-tiger_art_digital_translucent_tiger-11592.jpg', '', '', 'uploads/oSuYsJMUQQMqw3qI', '', '', '0', '2017-08-20 15:39:33'),
(114, 'maps', 'upload', 'oSuYsJMUQQMqw3qI', '2011 Yamaha YZF-R6 Wallpaper.jpg', '', '', 'uploads/oSuYsJMUQQMqw3qI', '', '', '0', '2017-08-20 15:39:33'),
(115, 'maps', 'upload', 'oSuYsJMUQQMqw3qI', '361.jpg', '', '', 'uploads/oSuYsJMUQQMqw3qI', '', '', '0', '2017-08-20 15:39:33'),
(116, 'maps', 'upload', 'lieE8LmWHU2ByY9y', '87730-18071.jpg', '', '', 'uploads/lieE8LmWHU2ByY9y', '', '', '1', '2017-08-20 15:44:26'),
(117, 'maps', 'upload', 'MirJlo7lZpSJ1Rmz', '1920x1080-tiger_art_digital_translucent_tiger-11592.jpg', '', '', 'uploads/MirJlo7lZpSJ1Rmz', '', '', '0', '2017-08-20 15:45:22'),
(118, 'maps', 'upload', 'MirJlo7lZpSJ1Rmz', '361.jpg', '', '', 'uploads/MirJlo7lZpSJ1Rmz', '', '', '0', '2017-08-20 15:45:22'),
(119, 'maps', 'upload', 'MirJlo7lZpSJ1Rmz', '2011 Yamaha YZF-R6 Wallpaper.jpg', '', '', 'uploads/MirJlo7lZpSJ1Rmz', '', '', '0', '2017-08-20 15:45:23'),
(120, 'maps', 'upload', 'JNh4j0ettMkY0CfD', '02e-aa-17.jpg', '', '', 'uploads/JNh4j0ettMkY0CfD', '', '', '0', '2017-08-20 15:45:36'),
(121, 'maps', 'upload', 'q81RG2mzz0xq9rUv', '4.JPG', '', '', 'uploads/q81RG2mzz0xq9rUv', '', '', '0', '2017-08-20 15:46:27'),
(122, 'maps', 'upload', 'h0c1Lkb9k5HSO8ZZ', '63172561.jpg', '', '', 'uploads/h0c1Lkb9k5HSO8ZZ', '', '', '0', '2017-08-20 15:47:30'),
(123, 'maps', 'upload', 'tDPDxxCjUoT7eWgB', '87730-18071.jpg', '', '', 'uploads/tDPDxxCjUoT7eWgB', '', '', '0', '2017-08-20 15:51:38'),
(124, 'maps', 'upload', 'iSDSClgnmV8G9OIu', '1451473314291.jpg', '', '', 'uploads/iSDSClgnmV8G9OIu', '', '', '0', '2017-08-21 09:09:37'),
(125, 'maps', 'upload', 'GmoSNzj2IIERnAGU', '1451473337607.jpg', '', '', 'uploads/GmoSNzj2IIERnAGU', '', '', '0', '2017-08-21 09:10:07'),
(126, 'maps', 'upload', '02WEVT0lkwSWq0eL', '13-500x431.JPG', '', '', 'uploads/02WEVT0lkwSWq0eL', '', '', '0', '2017-08-21 09:56:15'),
(127, 'maps', 'upload', 'CEnW8sg9IIhKKAUq', '1451473314291.jpg', '', '', 'uploads/CEnW8sg9IIhKKAUq', '', '', '0', '2017-08-21 10:08:51'),
(128, 'maps', 'upload', 'mCHx0J4XqZaab9Fs', '1451473337607.jpg', '', '', 'uploads/mCHx0J4XqZaab9Fs', '', '', '0', '2017-08-21 10:09:43'),
(129, 'maps', 'upload', '4ljGFk10L88ph1IA', '1451473314291.jpg', '', '', 'uploads/4ljGFk10L88ph1IA', '', '', '0', '2017-08-23 15:30:40'),
(130, 'ads', 'upload', 'vJbX1KKOItjvfjau', 'pl1.jpg', '', '', 'uploads/vJbX1KKOItjvfjau', '', '', '0', '2017-08-24 06:46:51'),
(131, 'ads', 'upload', 'vJbX1KKOItjvfjau', 'bg1.jpg', '', '', 'uploads/vJbX1KKOItjvfjau', '', '', '0', '2017-08-24 06:47:04'),
(132, 'ads', 'upload', 'vJbX1KKOItjvfjau', 'kokos.png', '', '', 'uploads/vJbX1KKOItjvfjau', '', '', '0', '2017-08-24 06:47:27'),
(136, 'ads', 'upload', 'kEBE0Q9qZeqPy8l3', '1451473314291.jpg', '', '', 'uploads/kEBE0Q9qZeqPy8l3', '', '', '0', '2017-08-24 15:47:20'),
(139, 'ads', 'upload', 'kEBE0Q9qZeqPy8l3', 'Angry_Wolves_Art-wallpaper-10895390.jpg', '', '', 'uploads/kEBE0Q9qZeqPy8l3', '', '', '1', '2017-08-28 08:56:22'),
(140, 'ads', 'upload', 'kEBE0Q9qZeqPy8l3', 'Angry_Kitty-wallpaper-10566593.jpg', '', '', 'uploads/kEBE0Q9qZeqPy8l3', '', '', '1', '2017-08-28 08:56:23'),
(142, 'ads', 'upload', 'kEBE0Q9qZeqPy8l3', 'Aqua_Yin_Yang-wallpaper-9983464.jpg', '', '', 'uploads/kEBE0Q9qZeqPy8l3', '', '', '1', '2017-08-28 08:56:26'),
(147, 'users', 'upload', 'avgDXj7MH1A59SOD', 'getImage (3).jpg', '', '', 'uploads/avgDXj7MH1A59SOD', '', '', '1', '2017-08-28 09:24:31'),
(148, 'users', 'upload', 'avgDXj7MH1A59SOD', 'getImage (39).jpg', '', '', 'uploads/avgDXj7MH1A59SOD', '', '', '1', '2017-08-28 10:48:14'),
(149, 'users', 'upload', 'Hbk5L1v5PINt96rU', '13-500x431.JPG', '', '', 'uploads/Hbk5L1v5PINt96rU', '', '', '1', '2017-08-28 13:17:50'),
(150, 'users', 'upload', 'Hbk5L1v5PINt96rU', '02e-aa-17.jpg', '', '', 'uploads/Hbk5L1v5PINt96rU', '', '', '1', '2017-08-28 13:19:27'),
(151, 'maps', 'upload', '80gSBG5sJLlWsGJ8', '1343277.jpg', '', '', 'uploads/80gSBG5sJLlWsGJ8', '', '', '0', '2017-08-28 13:22:55'),
(152, 'maps', 'upload', '80gSBG5sJLlWsGJ8', '1322925.jpg', '', '', 'uploads/80gSBG5sJLlWsGJ8', '', '', '0', '2017-08-28 13:22:59'),
(153, 'maps', 'upload', '80gSBG5sJLlWsGJ8', '1350312.jpg', '', '', 'uploads/80gSBG5sJLlWsGJ8', '', '', '0', '2017-08-28 13:23:11'),
(154, 'users', 'upload', '3IxI1oYV5IPf945y', '404 copy.jpg', '', '', 'uploads/3IxI1oYV5IPf945y', '', '', '1', '2017-08-28 13:43:35'),
(155, 'users', 'upload', 'vSRjzcRtwSOUlLYR', 'girl.png', '', '', 'uploads/vSRjzcRtwSOUlLYR', '', '', '1', '2017-08-28 13:46:46'),
(156, 'users', 'upload', 'vSRjzcRtwSOUlLYR', 'parot1.jpg', '', '', 'uploads/vSRjzcRtwSOUlLYR', '', '', '1', '2017-08-28 13:47:18'),
(157, 'users', 'upload', 'ujNQJoPeKz3t7Whh', 'case.png', '', '', 'uploads/ujNQJoPeKz3t7Whh', '', '', '1', '2017-08-28 14:54:44');

-- --------------------------------------------------------

--
-- Структура таблицы `marker_types`
--

CREATE TABLE IF NOT EXISTS `marker_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typename` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `marker_types`
--

INSERT INTO `marker_types` (`id`, `typename`) VALUES
(1, 'ДТП'),
(2, 'ДПС'),
(3, 'SOS'),
(4, 'Другое');

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  `from` varchar(20) NOT NULL,
  `to` varchar(20) NOT NULL,
  `status` int(1) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `from` (`from`,`to`),
  KEY `to` (`to`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=170 ;

--
-- Дамп данных таблицы `notifications`
--

INSERT INTO `notifications` (`id`, `unit`, `type`, `date`, `message`, `from`, `to`, `status`, `url`) VALUES
(1, 'user', 'message', '2017-08-17 17:21:52', 'arebvera', 'n53mrULQ7r5kBGGN', ' avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(2, 'user', 'message', '2017-08-17 17:30:44', 'vbvbvb', 'avgDXj7MH1A59SOD', ' n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(3, 'user', 'message', '2017-08-17 17:30:44', 'vbvbvbvb', 'avgDXj7MH1A59SOD', ' n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(4, 'user', 'message', '2017-08-17 17:30:07', 'aerbaesrtg', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(5, 'user', 'message', '2017-08-17 17:30:44', 'fvfgfb', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(6, 'user', 'message', '2017-08-17 17:30:54', 'aerb', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(7, 'user', 'message', '2017-08-17 17:36:51', 'fvfvfbvfv', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(8, 'user', 'message', '2017-08-17 17:36:51', 'edfdf', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(9, 'user', 'message', '2017-08-17 17:34:47', 'aeber', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(10, 'user', 'message', '2017-08-17 17:34:47', 'nyfukyfuy', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(11, 'user', 'message', '2017-08-17 17:34:54', 'qertbhwerb', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(12, 'user', 'message', '2017-08-17 17:35:22', 'qaerbert', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(13, 'user', 'message', '2017-08-17 17:36:49', 'aber', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(14, 'user', 'message', '2017-08-17 17:36:49', 'aberg', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(15, 'user', 'message', '2017-08-17 17:36:49', 'etoimo to ergaleio', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(16, 'user', 'message', '2017-08-17 17:36:49', 'fetes paei!', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(17, 'user', 'message', '2017-08-17 17:40:38', 'grapse kati', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(18, 'user', 'message', '2017-08-17 17:43:50', 'ghghghgh', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(19, 'user', 'message', '2017-08-17 17:43:50', 'vbvbvb', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(20, 'user', 'message', '2017-08-17 17:43:50', 'vbvbvb', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(21, 'user', 'message', '2017-08-17 17:43:50', 'vbvbvbvb', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(22, 'user', 'message', '2017-08-17 17:42:10', 'ole', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(23, 'user', 'message', '2017-08-17 17:42:10', 'abrw', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(24, 'user', 'message', '2017-08-17 17:43:50', 'fgfgfg', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(25, 'user', 'message', '2017-08-17 17:43:50', 'klmkkm', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(26, 'user', 'message', '2017-08-18 10:16:03', 'fgffg', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(27, 'user', 'message', '2017-08-18 10:36:23', 'yhghgth', '', 'KqvxLK2fgMM', 1, 'index.php?ops=users2&type=cabinet'),
(28, 'user', 'message', '2017-08-18 10:30:56', 'fggfgfg', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(29, 'chat', 'message', '2017-08-18 14:05:41', 'abrvera', 'n53mrULQ7r5kBGGN', '', 1, ''),
(30, 'chat', 'message', '2017-08-18 14:05:41', 'abrvera', 'n53mrULQ7r5kBGGN', '', 1, ''),
(31, 'chat', 'message', '2017-08-18 14:05:41', 'avradrfv', 'n53mrULQ7r5kBGGN', '', 1, ''),
(32, 'chat', 'message', '2017-08-18 14:05:41', 'aerbear', 'n53mrULQ7r5kBGGN', '', 1, ''),
(33, 'chat', 'message', '2017-08-18 14:05:41', 'aerbgvesag', 'n53mrULQ7r5kBGGN', '', 1, ''),
(34, 'chat', 'message', '2017-08-18 14:05:41', 'aervbgse', 'n53mrULQ7r5kBGGN', '', 1, ''),
(35, 'user', 'message', '2017-08-18 14:05:41', 'ddd', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(36, 'chat', 'message', '2017-08-18 14:05:41', 'test', 'n53mrULQ7r5kBGGN', '', 1, ''),
(37, 'chat', 'message', '2017-08-18 14:05:41', '45454545455', 'avgDXj7MH1A59SOD', '', 1, ''),
(38, 'user', 'message', '2017-08-20 23:19:41', 'dfdfdfdf', '', '', 1, 'index.php?ops=users2&type=cabinet'),
(39, 'user', 'message', '2017-08-20 23:19:41', 'dfdfdfdf', '', '', 1, 'index.php?ops=users2&type=cabinet'),
(40, 'user', 'message', '2017-08-20 23:19:41', 'dfdfdfdf', '', '', 1, 'index.php?ops=users2&type=cabinet'),
(41, 'user', 'message', '2017-08-20 23:19:41', 'dfdfdfdfdf', '', '', 1, 'index.php?ops=users2&type=cabinet'),
(42, 'user', 'message', '2017-08-20 23:19:41', 'dfdfdfdf', '', '', 1, 'index.php?ops=users2&type=cabinet'),
(43, 'chat', 'message', '2017-08-20 23:19:41', 'reply to test2', 'n53mrULQ7r5kBGGN', '', 1, ''),
(44, 'chat', 'message', '2017-08-20 23:19:41', 'arhgwsthn', 'n53mrULQ7r5kBGGN', '', 1, ''),
(45, 'user', 'message', '2017-08-20 23:19:41', 'rtrtrtrt', '', '', 1, 'index.php?ops=users2&type=cabinet'),
(46, 'user', 'message', '2017-08-20 23:19:41', '', '', '', 1, 'index.php?ops=users2&type=cabinet'),
(47, 'user', 'message', '2017-08-20 23:19:41', 'rtrtrt', '', '', 1, 'index.php?ops=users2&type=cabinet'),
(48, 'user', 'message', '2017-08-20 23:19:41', '', '', '', 1, 'index.php?ops=users2&type=cabinet'),
(49, 'user', 'message', '2017-08-20 23:19:41', 'fgfgfgfg', 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 1, 'index.php?ops=users2&type=cabinet'),
(50, 'user', 'message', '2017-08-20 23:19:41', 'dfdf', 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 1, 'index.php?ops=users2&type=cabinet'),
(51, 'user', 'message', '2017-08-20 23:19:41', 'test', 'n53mrULQ7r5kBGGN', 'cKfKW5XMfYrFKVg7', 1, 'index.php?ops=users2&type=cabinet'),
(52, 'maps', 'comment', '2017-08-20 23:19:41', 'testa', 'n53mrULQ7r5kBGGN', '', 1, 'index.php?ops=maps&type=archive&item=78'),
(53, 'maps', 'comment', '2017-08-20 23:19:41', 'testa', 'n53mrULQ7r5kBGGN', '', 1, 'index.php?ops=maps&type=archive&item=78'),
(54, 'maps', 'comment', '2017-08-20 23:19:41', 'asdfvg', 'n53mrULQ7r5kBGGN', 'ak', 1, 'index.php?ops=maps&type=archive&item=81'),
(55, 'maps', 'comment', '2017-08-18 17:10:34', 'aabrvesarvg', 'n53mrULQ7r5kBGGN', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=maps&type=archive&item=1'),
(56, 'maps', 'comment', '2017-08-18 17:10:34', 'asdf', 'n53mrULQ7r5kBGGN', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=maps&type=archive&item=1'),
(57, 'maps', 'comment', '2017-08-18 17:11:47', 'arewvb', 'n53mrULQ7r5kBGGN', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=maps&type=archive&item=1'),
(58, 'chat', 'message', '2017-08-20 23:19:41', 'dsdsdsfsf\r\n', 'avgDXj7MH1A59SOD', '', 1, ''),
(59, 'chat', 'message', '2017-08-20 23:19:41', 'cxcxcx', 'avgDXj7MH1A59SOD', '', 1, ''),
(60, 'chat', 'message', '2017-08-20 23:19:41', 'cxcxcxc', 'avgDXj7MH1A59SOD', '', 1, ''),
(61, 'chat', 'message', '2017-08-20 23:19:41', 'fkf\r\n', 'avgDXj7MH1A59SOD', '', 1, ''),
(62, 'chat', 'message', '2017-08-20 23:19:41', 'cxcxc', 'avgDXj7MH1A59SOD', '', 1, ''),
(63, 'chat', 'message', '2017-08-20 23:19:41', 'dfdfdf', 'avgDXj7MH1A59SOD', '', 1, ''),
(64, 'chat', 'message', '2017-08-20 23:19:41', 'sdsf\r\n', 'avgDXj7MH1A59SOD', '', 1, ''),
(65, 'chat', 'message', '2017-08-20 23:19:41', 'fgfgfgfgfg', 'avgDXj7MH1A59SOD', '', 1, ''),
(66, 'chat', 'message', '2017-08-20 23:19:41', 'dfdfdfdf', 'avgDXj7MH1A59SOD', '', 1, ''),
(67, 'chat', 'message', '2017-08-20 23:19:41', 'dfdfdf', 'avgDXj7MH1A59SOD', '', 1, ''),
(68, 'user', 'message', '2017-08-19 10:36:52', 'qwewe', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(69, 'user', 'message', '2017-08-20 23:19:41', 'gfg', 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 1, 'index.php?ops=users2&type=cabinet'),
(70, 'user', 'message', '2017-08-20 23:19:41', 'dcdcv\r\n', 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 1, 'index.php?ops=users2&type=cabinet'),
(71, 'user', 'message', '2017-08-20 23:19:41', 't7ftf', 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 1, 'index.php?ops=users2&type=cabinet'),
(72, 'user', 'message', '2017-08-20 23:19:41', 'asdgfasdg', 'n53mrULQ7r5kBGGN', '', 1, 'index.php?ops=users2&type=cabinet'),
(73, 'maps', 'comment', '2017-08-19 11:18:30', 'asdfgasfg', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=maps&type=archive&item=2'),
(74, 'maps', 'comment', '2017-08-19 11:18:30', 'asdgbvaerb', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=maps&type=archive&item=2'),
(75, 'maps', 'comment', '2017-08-19 11:19:56', 'asdf', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=maps&type=archive&item=2'),
(76, 'chat', 'message', '2017-08-20 23:19:41', 'reply to test', 'n53mrULQ7r5kBGGN', '', 1, ''),
(77, 'chat', 'message', '2017-08-20 23:19:41', '2 reply to test', 'n53mrULQ7r5kBGGN', '', 1, ''),
(78, 'chat', 'message', '2017-08-20 23:19:41', 'reply to asd', 'n53mrULQ7r5kBGGN', '', 1, ''),
(79, 'maps', 'comment', '2017-08-20 15:49:57', 'рудлдщ фддфд', 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=maps&type=archive&item=3'),
(80, 'maps', 'comment', '2017-08-20 15:49:57', '', 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=maps&type=archive&item=3'),
(81, 'user', 'message', '2017-08-20 23:19:41', 'njbjbnj', 'avgDXj7MH1A59SOD', '', 1, 'index.php?ops=users2&type=cabinet'),
(82, 'maps', 'comment', '2017-08-22 12:17:18', 'asdf', 'n53mrULQ7r5kBGGN', '', 1, 'index.php?ops=maps&type=archive&item=iSDSClgnmV8G9OIu'),
(83, 'maps', 'comment', '2017-08-21 09:17:53', 'asdfgabr', 'n53mrULQ7r5kBGGN', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=maps&type=archive&item=iSDSClgnmV8G9OIu'),
(84, 'maps', 'comment', '2017-08-21 10:13:18', 'awergf', 'n53mrULQ7r5kBGGN', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=maps&type=archive&item=mCHx0J4XqZaab9Fs'),
(85, 'help', 'message', '2017-08-22 12:17:18', ':kaixin:						\r\n					', 'avgDXj7MH1A59SOD', '', 1, ''),
(86, 'user', 'message', '2017-08-22 12:17:18', ':weiqu:', 'n53mrULQ7r5kBGGN', 'M82aXEhOQVuG41Cu', 1, 'index.php?ops=users2&type=cabinet'),
(87, 'user', 'message', '2017-08-22 12:17:18', ':lei:', 'n53mrULQ7r5kBGGN', 'M82aXEhOQVuG41Cu', 1, 'index.php?ops=users2&type=cabinet'),
(88, 'user', 'message', '2017-08-22 12:17:18', ':han::yi::kuanghan::shuijiao::caihong:', 'n53mrULQ7r5kBGGN', 'M82aXEhOQVuG41Cu', 1, 'index.php?ops=users2&type=cabinet'),
(89, 'user', 'message', '2017-08-22 12:17:18', ':yiwen:', 'n53mrULQ7r5kBGGN', 'M82aXEhOQVuG41Cu', 1, 'index.php?ops=users2&type=cabinet'),
(90, 'maps', 'comment', '2017-08-22 06:27:57', 'jkhjhj', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=maps&type=archive&item=mCHx0J4XqZaab9Fs'),
(91, 'user', 'message', '2017-08-22 12:17:18', ':yi:', 'n53mrULQ7r5kBGGN', '', 1, 'index.php?ops=users2&type=cabinet'),
(92, 'user', 'message', '2017-08-22 14:20:24', ':a:', 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', 0, 'index.php?ops=users2&type=cabinet'),
(93, 'user', 'message', '2017-08-22 14:20:34', ':zhenbang:', 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', 0, 'index.php?ops=users2&type=cabinet'),
(94, 'user', 'message', '2017-08-22 15:23:57', ':han:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(95, 'user', 'message', '2017-08-22 15:23:57', ':caihong:\r\n', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(96, 'user', 'message', '2017-08-22 15:23:57', ':heixian::guai::damuzhi:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(97, 'user', 'message', '2017-08-23 06:32:32', ':weiqu:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(98, 'user', 'message', '2017-08-23 06:32:32', ':weiqu:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(99, 'user', 'message', '2017-08-23 06:32:32', ':lei:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(100, 'user', 'message', '2017-08-23 12:18:57', ':zhenbang:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(101, 'user', 'message', '2017-08-23 12:18:57', ':lu:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(102, 'user', 'message', '2017-08-23 08:05:22', ':heixian:', 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(103, 'user', 'message', '2017-08-23 08:05:22', ':guai:', 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(104, 'user', 'message', '2017-08-23 08:02:21', ':caihong:', 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', 0, 'index.php?ops=users2&type=cabinet'),
(105, 'user', 'message', '2017-08-23 08:02:29', ':OK:', 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', 0, 'index.php?ops=users2&type=cabinet'),
(106, 'user', 'message', '2017-08-23 08:06:31', ':han:', 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', 0, 'index.php?ops=users2&type=cabinet'),
(107, 'user', 'message', '2017-08-23 08:13:55', ':yinxian:', 'avgDXj7MH1A59SOD', '', 0, 'index.php?ops=users2&type=cabinet'),
(108, 'user', 'message', '2017-08-23 08:14:03', ':jinku:', 'avgDXj7MH1A59SOD', '', 0, 'index.php?ops=users2&type=cabinet'),
(109, 'user', 'message', '2017-08-23 12:18:57', ':guai:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(110, 'user', 'message', '2017-08-23 12:18:57', ':caihong:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(111, 'user', 'message', '2017-08-23 12:18:57', ':damuzhi:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(112, 'user', 'message', '2017-08-23 08:24:07', ':damuzhi:', 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', 0, 'index.php?ops=users2&type=cabinet'),
(113, 'user', 'message', '2017-08-23 08:24:14', ':bishi:', 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', 0, 'index.php?ops=users2&type=cabinet'),
(114, 'user', 'message', '2017-08-23 08:24:58', ':caihong:', 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', 0, 'index.php?ops=users2&type=cabinet'),
(115, 'user', 'message', '2017-08-23 09:47:21', ':yiwen:', 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 0, 'index.php?ops=users2&type=cabinet'),
(116, 'maps', 'comment', '2017-08-23 12:22:30', 'asdf', 'n53mrULQ7r5kBGGN', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=maps&type=archive&item=mCHx0J4XqZaab9Fs'),
(117, 'user', 'message', '2017-08-23 14:29:24', ':damuzhi:', 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(118, 'user', 'message', '2017-08-24 06:40:44', ':ruo:', 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(119, 'user', 'message', '2017-08-24 13:42:17', ':caihong:', 'avgDXj7MH1A59SOD', 'vJbX1KKOItjvfjau', 0, 'index.php?ops=users2&type=cabinet'),
(120, 'user', 'message', '2017-08-24 14:59:57', ':lu:', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(121, 'user', 'message', '2017-08-24 14:59:40', 'b b ', 'avgDXj7MH1A59SOD', 'vJbX1KKOItjvfjau', 0, 'index.php?ops=users2&type=cabinet'),
(122, 'user', 'message', '2017-08-24 14:59:43', 'b b ', 'avgDXj7MH1A59SOD', 'vJbX1KKOItjvfjau', 0, 'index.php?ops=users2&type=cabinet'),
(123, 'user', 'message', '2017-08-24 14:59:50', 'b b ', 'avgDXj7MH1A59SOD', 'vJbX1KKOItjvfjau', 0, 'index.php?ops=users2&type=cabinet'),
(124, 'user', 'message', '2017-08-24 15:11:28', 'dfedfdfdf', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(125, 'user', 'message', '2017-08-24 15:11:28', 'dfdfdfdfdf', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(126, 'user', 'message', '2017-08-24 15:11:28', 'dfdfdfdfdf', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(127, 'chat', 'message', '2017-08-28 08:10:15', 'рджржрл', 'avgDXj7MH1A59SOD', '', 0, ''),
(128, 'chat', 'message', '2017-08-28 08:58:55', 'agvaervg', 'n53mrULQ7r5kBGGN', '', 0, ''),
(129, 'user', 'message', '2017-08-28 09:08:28', 'asgvberagv', 'n53mrULQ7r5kBGGN', 'kEBE0Q9qZeqPy8l3', 0, 'index.php?ops=users2&type=cabinet'),
(130, 'user', 'message', '2017-08-28 09:08:36', ':hehe:', 'n53mrULQ7r5kBGGN', 'kEBE0Q9qZeqPy8l3', 0, 'index.php?ops=users2&type=cabinet'),
(131, 'user', 'message', '2017-08-28 09:09:25', 'asdf', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(132, 'user', 'message', '2017-08-28 09:33:14', 'asdf', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(133, 'chat', 'message', '2017-08-28 10:14:59', 'fddgfg', 'avgDXj7MH1A59SOD', '', 0, ''),
(134, 'user', 'message', '2017-08-28 10:23:48', 'asdf', 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(135, 'chat', 'message', '2017-08-28 10:15:22', 'dfdfdf', 'avgDXj7MH1A59SOD', '', 0, ''),
(136, 'chat', 'message', '2017-08-28 10:15:26', 'dfdfdf', 'avgDXj7MH1A59SOD', '', 0, ''),
(137, 'chat', 'message', '2017-08-28 10:18:01', 'asdfg', 'n53mrULQ7r5kBGGN', '', 0, ''),
(138, 'chat', 'message', '2017-08-28 10:18:04', 'asdf', 'n53mrULQ7r5kBGGN', '', 0, ''),
(139, 'chat', 'message', '2017-08-28 10:18:36', 'asdf', 'n53mrULQ7r5kBGGN', '', 0, ''),
(140, 'chat', 'message', '2017-08-28 10:18:55', 'asdfarewg', 'n53mrULQ7r5kBGGN', '', 0, ''),
(141, 'chat', 'message', '2017-08-28 10:19:03', 'argverg', 'n53mrULQ7r5kBGGN', '', 0, ''),
(142, 'chat', 'message', '2017-08-28 11:27:58', 'fgfgfg', 'avgDXj7MH1A59SOD', '', 0, ''),
(143, 'user', 'message', '2017-08-28 12:10:50', 'vgcfvcgfvc', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(144, 'helpchat', 'message', '2017-08-28 12:07:52', 'test22', 'n53mrULQ7r5kBGGN', '', 0, ''),
(145, 'user', 'message', '2017-08-28 12:10:50', ':mianqiang:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(146, 'user', 'message', '2017-08-28 12:15:05', ':xinsui:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(147, 'user', 'message', '2017-08-28 12:15:05', ':kuanghan:', 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(148, 'maps', 'comment', '2017-08-28 13:26:58', 'bgnhnhnhn', 'Hbk5L1v5PINt96rU', 'Hbk5L1v5PINt96rU', 1, 'index.php?ops=maps&type=archive&item=80gSBG5sJLlWsGJ8'),
(149, 'maps', 'comment', '2017-08-28 13:26:58', 'hnhnhnhnhnh', 'Hbk5L1v5PINt96rU', 'Hbk5L1v5PINt96rU', 1, 'index.php?ops=maps&type=archive&item=80gSBG5sJLlWsGJ8'),
(150, 'maps', 'comment', '2017-08-28 13:28:35', 'yhnhnhnhnhnh', 'Hbk5L1v5PINt96rU', 'Hbk5L1v5PINt96rU', 1, 'index.php?ops=maps&type=archive&item=80gSBG5sJLlWsGJ8'),
(151, 'maps', 'comment', '2017-08-28 13:28:35', 'hnhnhn', 'Hbk5L1v5PINt96rU', 'Hbk5L1v5PINt96rU', 1, 'index.php?ops=maps&type=archive&item=80gSBG5sJLlWsGJ8'),
(152, 'user', 'message', '2017-08-28 13:40:36', 'privet eto praverka chata test 2', 'Hbk5L1v5PINt96rU', '', 0, 'index.php?ops=users2&type=cabinet'),
(153, 'user', 'message', '2017-08-28 13:45:50', 'privet test2 eto test1 pochemu ne rabotaiet', 'Hbk5L1v5PINt96rU', '3IxI1oYV5IPf945y', 1, 'index.php?ops=users2&type=cabinet'),
(154, 'user', 'message', '2017-08-28 15:09:08', 'jbhejhjhjdfhdf', '3IxI1oYV5IPf945y', '', 0, 'index.php?ops=users2&type=cabinet'),
(155, 'user', 'message', '2017-08-28 15:09:51', 'njbvvbnbvvbbv', 'Hbk5L1v5PINt96rU', '', 0, 'index.php?ops=users2&type=cabinet'),
(156, 'user', 'message', '2017-08-28 15:10:02', 'kjbhhbhbh', 'Hbk5L1v5PINt96rU', '', 0, 'index.php?ops=users2&type=cabinet'),
(157, 'user', 'message', '2017-08-28 15:11:14', 'bvbcvcvcvc', 'Hbk5L1v5PINt96rU', '3IxI1oYV5IPf945y', 0, 'index.php?ops=users2&type=cabinet'),
(158, 'user', 'message', '2017-08-28 15:23:51', 'hgvgvcgcg', '6VatEDhkt55i0EKI', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(159, 'user', 'message', '2017-08-28 15:23:51', 'bvcgvcvcvc', '6VatEDhkt55i0EKI', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(160, 'user', 'message', '2017-08-28 15:15:56', 'asdf', 'n53mrULQ7r5kBGGN', '', 0, 'index.php?ops=users2&type=cabinet'),
(161, 'user', 'message', '2017-08-28 15:16:05', 'asdf', 'n53mrULQ7r5kBGGN', '', 0, 'index.php?ops=users2&type=cabinet'),
(162, 'user', 'message', '2017-08-28 15:17:28', 'asdf', 'n53mrULQ7r5kBGGN', '6VatEDhkt55i0EKI', 1, 'index.php?ops=users2&type=cabinet'),
(163, 'user', 'message', '2017-08-28 15:23:51', 'vhcvcvcv', '6VatEDhkt55i0EKI', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(164, 'user', 'message', '2017-08-28 15:23:51', 'bhvgv', '6VatEDhkt55i0EKI', 'n53mrULQ7r5kBGGN', 1, 'index.php?ops=users2&type=cabinet'),
(165, 'user', 'message', '2017-08-28 15:28:37', 'asdf', 'n53mrULQ7r5kBGGN', '6VatEDhkt55i0EKI', 1, 'index.php?ops=users2&type=cabinet'),
(166, 'user', 'message', '2017-08-28 15:27:05', 'asdf', 'n53mrULQ7r5kBGGN', '3IxI1oYV5IPf945y', 0, 'index.php?ops=users2&type=cabinet'),
(167, 'user', 'message', '2017-08-29 14:28:46', '', 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(168, 'user', 'message', '2017-08-29 14:28:46', ':liwu:', 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', 1, 'index.php?ops=users2&type=cabinet'),
(169, 'user', 'message', '2017-08-29 14:28:33', ':haha2::shenli:', 'avgDXj7MH1A59SOD', '3IxI1oYV5IPf945y', 0, 'index.php?ops=users2&type=cabinet');

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_access_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `access_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`access_token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_authorization_codes`
--

CREATE TABLE IF NOT EXISTS `oauth_authorization_codes` (
  `authorization_code` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`authorization_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `client_id` varchar(80) NOT NULL,
  `client_secret` varchar(80) DEFAULT NULL,
  `redirect_uri` varchar(2000) NOT NULL,
  `grant_types` varchar(80) DEFAULT NULL,
  `scope` varchar(100) DEFAULT NULL,
  `user_id` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oauth_clients`
--

INSERT INTO `oauth_clients` (`client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scope`, `user_id`) VALUES
('chat', 'qwerty', 'http://city.com/temp/index.php?ops=chat', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_jwt`
--

CREATE TABLE IF NOT EXISTS `oauth_jwt` (
  `client_id` varchar(80) NOT NULL,
  `subject` varchar(80) DEFAULT NULL,
  `public_key` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_refresh_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`refresh_token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`refresh_token`, `client_id`, `user_id`, `expires`, `scope`) VALUES
('20050240c0958bb9f19d9e15e74cf5efd7d8f2ac', 'chat', 'mas', '2017-08-25 12:34:33', NULL),
('bddcfd7b50f72c947b810525cfd40ce659dfc8e4', 'chat', 'mas', '2017-08-25 12:10:40', NULL),
('63a3af3fdf7384042182e3765b01f902a8f7395f', 'chat', 'mas', '2017-08-25 11:46:50', NULL),
('13344b86ecce6213704ca9731078d9d2cdd0c10d', 'chat', 'mas', '2017-08-25 11:44:50', NULL),
('b67e6e55bccc3eff62b7b6d20f2f15f8859696db', 'chat', 'mas', '2017-08-25 11:39:19', NULL),
('9dd860d8c9ab6d3201800d6825a01d72b739c705', 'chat', 'mas', '2017-08-25 11:28:19', NULL),
('d95455425a9a61dde6af1846cfafc216c743e1f1', 'chat', 'mas', '2017-08-25 09:53:53', NULL),
('9ebd5b2242180fa1624665ebc3cf7a20019129d7', 'chat', 'admin2', '2017-08-25 08:50:05', NULL),
('d06923ed337e99c795ec8fa2b55b5e54b682604e', 'chat', 'mas', '2017-08-24 13:17:43', NULL),
('31ae9a98a7ce86fef98a4972d2a2557642a6a0dc', 'chat', 'mas', '2017-08-24 13:15:54', NULL),
('8d1b97fe4ef71aabea6a71a78721a75418533215', 'chat', 'mas', '2017-08-24 12:52:51', NULL),
('a771af0dd8235f8c1f50fd7e43b037c8ee80fe81', 'chat', 'mas', '2017-08-24 12:47:55', NULL),
('a1c4315408c52b5997a5da1584cae7f4acafd87c', 'chat', 'thisisaris@gmail.com', '2017-08-22 07:57:29', NULL),
('cdc41813a316c6ddf658316a56bdd33a063a78cd', 'chat', 'admin2', '2017-08-22 13:01:00', NULL),
('88a225b70e5daae0e178d4871b3b9f45e784b3e6', 'chat', 'mas', '2017-08-24 12:44:47', NULL),
('34de028382d89924aaaff4dfc58d5525f288a332', 'chat', 'mas', '2017-08-24 11:14:01', NULL),
('e396cf05c0d9192adc48ab92e0f0aa56a32dcbee', 'chat', 'admin2', '2017-08-23 13:06:30', NULL),
('3f90441e6dc662842ef5f71a6453f8e10b68f31b', 'chat', 'mas', '2017-08-24 07:59:49', NULL),
('34b32a08640ba83468b5e591840d2cc3160363b7', 'chat', 'mas', '2017-08-24 07:46:30', NULL),
('a05402fbc48baab9b528a6b56422c7ccaf976c15', 'chat', 'mas', '2017-08-24 07:41:30', NULL),
('7d125d40aeb83e92409f260944e5c2a6a0a62a29', 'chat', 'mas', '2017-08-24 07:26:16', NULL),
('25ee2164ef789947cf6c23c6de6043a507d937ef', 'chat', 'mas', '2017-08-25 12:37:56', NULL),
('04c9b053427490492462091670969ccd2b70002b', 'chat', 'strannik', '2017-08-25 12:38:22', NULL),
('6682cb9663e290039839a28bc8bff7cd2e7935ca', 'chat', 'mas', '2017-08-28 08:25:20', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_scopes` (
  `scope` text,
  `is_default` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_users`
--

CREATE TABLE IF NOT EXISTS `oauth_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(2000) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `oauth_users`
--

INSERT INTO `oauth_users` (`id`, `username`, `password`, `first_name`, `last_name`) VALUES
(1, 'thisisaris@gmail.com', 'gevorkyan', '', ''),
(2, 'mas', 'pwd', NULL, NULL),
(3, 'wdsgrtablet@gmail.com', '', 'alex', 'kakkos'),
(4, 'strannik', 'qwerty', NULL, NULL),
(6, 'admin2', 'admin2', NULL, NULL),
(7, 's211211@ukr.net', 'qwerty', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `privatechat`
--

CREATE TABLE IF NOT EXISTS `privatechat` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `from` varchar(30) NOT NULL,
  `to` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=114 ;

--
-- Дамп данных таблицы `privatechat`
--

INSERT INTO `privatechat` (`id`, `from`, `to`, `message`, `date`, `status`) VALUES
(1, 'n53mrULQ7r5kBGGN', ' avgDXj7MH1A59SOD', 'arebvera', '2017-08-17 17:30:33', 1),
(2, 'avgDXj7MH1A59SOD', ' n53mrULQ7r5kBGGN', 'vbvbvb', '2017-08-17 17:30:29', 1),
(3, 'avgDXj7MH1A59SOD', ' n53mrULQ7r5kBGGN', 'vbvbvbvb', '2017-08-17 17:30:29', 1),
(4, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'aerbaesrtg', '2017-08-17 17:30:03', 1),
(5, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'fvfgfb', '2017-08-17 17:30:29', 1),
(6, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'aerb', '2017-08-17 17:30:41', 1),
(7, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'fvfvfbvfv', '2017-08-17 17:33:34', 1),
(8, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'edfdf', '2017-08-17 17:33:34', 1),
(9, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'aeber', '2017-08-17 17:35:05', 1),
(10, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'nyfukyfuy', '2017-08-17 17:35:05', 1),
(11, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'qertbhwerb', '2017-08-17 17:35:05', 1),
(12, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'qaerbert', '2017-08-17 17:35:27', 1),
(13, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'aber', '2017-08-17 17:36:52', 1),
(14, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'aberg', '2017-08-17 17:36:52', 1),
(15, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'etoimo to ergaleio', '2017-08-17 17:36:52', 1),
(16, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'fetes paei!', '2017-08-17 17:36:52', 1),
(17, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'grapse kati', '2017-08-17 17:40:23', 1),
(18, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'ghghghgh', '2017-08-17 17:40:58', 1),
(19, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'vbvbvb', '2017-08-17 17:40:58', 1),
(20, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'vbvbvb', '2017-08-17 17:40:58', 1),
(21, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'vbvbvbvb', '2017-08-17 17:40:58', 1),
(22, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'ole', '2017-08-17 17:41:03', 1),
(23, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'abrw', '2017-08-17 17:41:44', 1),
(24, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'fgfgfg', '2017-08-17 17:43:56', 1),
(25, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'klmkkm', '2017-08-17 17:43:56', 1),
(26, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'fgffg', '2017-08-18 10:16:19', 1),
(27, '', 'KqvxLK2fgMM', 'yhghgth', '2017-08-18 10:16:35', 1),
(28, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'fggfgfg', '2017-08-18 10:30:50', 1),
(29, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'ddd', '2017-08-18 14:08:15', 1),
(30, '', '', 'dfdfdfdf', '2017-08-18 14:06:19', 1),
(31, '', '', 'dfdfdfdf', '2017-08-18 14:06:23', 1),
(32, '', '', 'dfdfdfdf', '2017-08-18 14:06:26', 1),
(33, '', '', 'dfdfdfdfdf', '2017-08-18 14:06:28', 1),
(34, '', '', 'dfdfdfdf', '2017-08-18 14:06:32', 1),
(35, '', '', 'rtrtrtrt', '2017-08-18 14:50:39', 1),
(36, '', '', '', '2017-08-18 14:50:43', 1),
(37, '', '', 'rtrtrt', '2017-08-18 14:50:45', 1),
(38, '', '', '', '2017-08-18 14:50:49', 1),
(39, 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 'fgfgfgfg', '2017-08-18 15:20:05', 0),
(40, 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 'dfdf', '2017-08-18 15:20:19', 0),
(41, 'n53mrULQ7r5kBGGN', 'cKfKW5XMfYrFKVg7', 'test', '2017-08-18 15:43:23', 0),
(42, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'qwewe', '2017-08-19 11:12:39', 1),
(43, 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 'gfg', '2017-08-19 08:37:11', 0),
(44, 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 'dcdcv\r\n', '2017-08-19 08:58:34', 0),
(45, 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', 't7ftf', '2017-08-19 09:02:14', 0),
(46, 'n53mrULQ7r5kBGGN', '', 'asdgfasdg', '2017-08-20 12:30:49', 1),
(47, 'avgDXj7MH1A59SOD', '', 'njbjbnj', '2017-08-20 15:55:41', 0),
(48, 'n53mrULQ7r5kBGGN', 'M82aXEhOQVuG41Cu', ':weiqu:', '2017-08-21 15:27:52', 0),
(49, 'n53mrULQ7r5kBGGN', 'M82aXEhOQVuG41Cu', ':lei:', '2017-08-21 15:28:44', 0),
(50, 'n53mrULQ7r5kBGGN', 'M82aXEhOQVuG41Cu', ':han::yi::kuanghan::shuijiao::caihong:', '2017-08-21 15:33:35', 0),
(51, 'n53mrULQ7r5kBGGN', 'M82aXEhOQVuG41Cu', ':yiwen:', '2017-08-21 15:33:55', 0),
(52, 'n53mrULQ7r5kBGGN', '', ':yi:', '2017-08-22 08:29:39', 0),
(53, 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', ':a:', '2017-08-22 14:20:24', 0),
(54, 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', ':zhenbang:', '2017-08-22 14:20:34', 0),
(55, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':han:', '2017-08-22 15:24:09', 1),
(56, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':caihong:\r\n', '2017-08-22 15:24:09', 1),
(57, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':heixian::guai::damuzhi:', '2017-08-22 15:24:09', 1),
(58, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':weiqu:', '2017-08-23 06:45:21', 1),
(59, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':weiqu:', '2017-08-23 06:45:21', 1),
(60, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':lei:', '2017-08-23 06:45:21', 1),
(61, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':zhenbang:', '2017-08-23 12:24:04', 1),
(62, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':lu:', '2017-08-23 12:24:04', 1),
(63, 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', ':heixian:', '2017-08-23 08:01:05', 1),
(64, 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', ':guai:', '2017-08-23 08:01:15', 1),
(65, 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', ':caihong:', '2017-08-23 08:02:21', 0),
(66, 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', ':OK:', '2017-08-23 08:02:29', 0),
(67, 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', ':han:', '2017-08-23 08:06:31', 0),
(68, 'avgDXj7MH1A59SOD', '', ':yinxian:', '2017-08-23 08:13:55', 0),
(69, 'avgDXj7MH1A59SOD', '', ':jinku:', '2017-08-23 08:14:03', 0),
(70, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':guai:', '2017-08-23 12:24:04', 1),
(71, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':caihong:', '2017-08-23 12:24:04', 1),
(72, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':damuzhi:', '2017-08-23 12:24:04', 1),
(73, 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', ':damuzhi:', '2017-08-23 08:24:07', 0),
(74, 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', ':bishi:', '2017-08-23 08:24:14', 0),
(75, 'avgDXj7MH1A59SOD', 'cKfKW5XMfYrFKVg7', ':caihong:', '2017-08-23 08:24:58', 0),
(76, 'avgDXj7MH1A59SOD', 'M82aXEhOQVuG41Cu', ':yiwen:', '2017-08-23 09:47:21', 0),
(77, 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', ':damuzhi:', '2017-08-23 14:26:16', 1),
(78, 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', ':ruo:', '2017-08-24 06:36:28', 1),
(79, 'avgDXj7MH1A59SOD', 'vJbX1KKOItjvfjau', ':caihong:', '2017-08-24 13:42:17', 0),
(80, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', ':lu:', '2017-08-24 14:59:23', 1),
(81, 'avgDXj7MH1A59SOD', 'vJbX1KKOItjvfjau', 'b b ', '2017-08-24 14:59:40', 0),
(82, 'avgDXj7MH1A59SOD', 'vJbX1KKOItjvfjau', 'b b ', '2017-08-24 14:59:43', 0),
(83, 'avgDXj7MH1A59SOD', 'vJbX1KKOItjvfjau', 'b b ', '2017-08-24 14:59:50', 0),
(84, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'dfedfdfdf', '2017-08-24 15:01:11', 1),
(85, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'dfdfdfdfdf', '2017-08-24 15:01:11', 1),
(86, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'dfdfdfdfdf', '2017-08-24 15:01:11', 1),
(87, 'n53mrULQ7r5kBGGN', 'kEBE0Q9qZeqPy8l3', 'asgvberagv', '2017-08-28 09:08:28', 0),
(88, 'n53mrULQ7r5kBGGN', 'kEBE0Q9qZeqPy8l3', ':hehe:', '2017-08-28 09:08:36', 0),
(89, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'asdf', '2017-08-28 09:09:51', 1),
(90, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'asdf', '2017-08-28 09:45:22', 1),
(91, 'n53mrULQ7r5kBGGN', 'avgDXj7MH1A59SOD', 'asdf', '2017-08-28 12:01:12', 1),
(92, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', 'vgcfvcgfvc', '2017-08-28 12:12:30', 1),
(93, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':mianqiang:', '2017-08-28 12:12:30', 1),
(94, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':xinsui:', '2017-08-28 15:15:53', 1),
(95, 'avgDXj7MH1A59SOD', 'n53mrULQ7r5kBGGN', ':kuanghan:', '2017-08-28 15:15:53', 1),
(96, 'Hbk5L1v5PINt96rU', '', 'privet eto praverka chata test 2', '2017-08-28 13:40:36', 0),
(97, 'Hbk5L1v5PINt96rU', '3IxI1oYV5IPf945y', 'privet test2 eto test1 pochemu ne rabotaiet', '2017-08-28 13:45:13', 1),
(98, '3IxI1oYV5IPf945y', '', 'jbhejhjhjdfhdf', '2017-08-28 15:09:08', 0),
(99, 'Hbk5L1v5PINt96rU', '', 'njbvvbnbvvbbv', '2017-08-28 15:09:51', 0),
(100, 'Hbk5L1v5PINt96rU', '', 'kjbhhbhbh', '2017-08-28 15:10:02', 0),
(101, 'Hbk5L1v5PINt96rU', '3IxI1oYV5IPf945y', 'bvbcvcvcvc', '2017-08-28 15:11:14', 0),
(102, '6VatEDhkt55i0EKI', 'n53mrULQ7r5kBGGN', 'hgvgvcgcg', '2017-08-28 15:15:53', 1),
(103, '6VatEDhkt55i0EKI', 'n53mrULQ7r5kBGGN', 'bvcgvcvcvc', '2017-08-28 15:15:53', 1),
(104, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-28 15:15:56', 0),
(105, 'n53mrULQ7r5kBGGN', '', 'asdf', '2017-08-28 15:16:05', 0),
(106, 'n53mrULQ7r5kBGGN', '6VatEDhkt55i0EKI', 'asdf', '2017-08-28 15:17:18', 1),
(107, '6VatEDhkt55i0EKI', 'n53mrULQ7r5kBGGN', 'vhcvcvcv', '2017-08-28 15:19:49', 1),
(108, '6VatEDhkt55i0EKI', 'n53mrULQ7r5kBGGN', 'bhvgv', '2017-08-28 15:19:49', 1),
(109, 'n53mrULQ7r5kBGGN', '6VatEDhkt55i0EKI', 'asdf', '2017-08-28 15:40:50', 1),
(110, 'n53mrULQ7r5kBGGN', '3IxI1oYV5IPf945y', 'asdf', '2017-08-28 15:27:05', 0),
(111, 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', '', '2017-08-29 14:28:11', 1),
(112, 'avgDXj7MH1A59SOD', 'avgDXj7MH1A59SOD', ':liwu:', '2017-08-29 14:28:14', 1),
(113, 'avgDXj7MH1A59SOD', '3IxI1oYV5IPf945y', ':haha2::shenli:', '2017-08-29 14:28:33', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `sess_id` text,
  `user_id` varchar(255) DEFAULT NULL,
  `last_request` decimal(10,0) DEFAULT NULL,
  UNIQUE KEY `session_id` (`sess_id`(255)),
  KEY `session_user` (`user_id`),
  KEY `session_lr` (`last_request`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `static`
--

CREATE TABLE IF NOT EXISTS `static` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL,
  `html` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `static`
--

INSERT INTO `static` (`id`, `uid`, `html`, `timestamp`) VALUES
(1, 'aggreement', 'aggreement', '2017-08-29 11:35:29'),
(3, 'help', 'help', '2017-08-29 11:44:07'),
(4, 'banner1', '<div class="banner"><img alt="banner" class="img-responsive" src="ops/chat/img/banner.png" /></div>\r\n', '2017-08-29 11:47:31'),
(5, 'buttons1', '<div class="info">\r\n						<div class="info-inner">\r\n							<a href="#"> <span> <i> <img src="img/info-1.png" alt="logo"> </i> </span> <strong>Нужна помощь на дороге?</strong> </a>\r\n						</div>\r\n						<div class="info-inner">\r\n							<a href="#"> <span> <i> <img src="img/info-2.png" alt="logo"> </i> </span> <strong>Где сейчас наряды ДПС?</strong> </a>\r\n						</div>\r\n						<div class="info-inner">\r\n							<a href="#"> <span> <i> <img src="img/info-3.png" alt="logo"> </i> </span> <strong>Где произошли аварии?</strong> </a>\r\n						</div>\r\n					</div>', '2017-08-29 11:47:31');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `pass` varchar(1024) DEFAULT NULL,
  `register` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `accesslevel` int(3) NOT NULL DEFAULT '1',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0',
  `city` varchar(255) NOT NULL,
  `messages` int(11) NOT NULL,
  `ads` int(11) NOT NULL,
  `labels` int(11) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `uid`, `username`, `firstname`, `lastname`, `pass`, `register`, `email`, `age`, `accesslevel`, `timestamp`, `status`, `city`, `messages`, `ads`, `labels`, `desc`) VALUES
(49, 'n53mrULQ7r5kBGGN', 'ak', 'Alex', 'Kakkos', 'YJNO7Elx8ybFeT8JfYETgAbRdEFbs1E6q/OG5CWwwlyfnXREWVtssjro5ihTFEvtmm3IIFElXFHHCga8asrGUv', NULL, 'asdf@wdsgr.com', NULL, 10, '2017-08-10 10:17:37', 1, 'Athens, Central Athens, Greece', 68, 1, 11, 'some text'),
(56, 'avgDXj7MH1A59SOD', 'Araik', 'araik', 'Gevorkyan', '8WacdXmq3Ldcx44gLEndhgpinflsMpq7ai1slNwYz15RI37KUZF9HcQ8qc8U7oAcWO4TCdEeU2KYyOYwIRnbth', NULL, 'arisgev84@gmail.com', NULL, 10, '2017-08-16 16:16:53', 1, 'Харьков, Харьковская область, Украина', 89, 0, 9, 'eimai poli kalo paidi para poli kalo super paidi'),
(57, 'avg5Xj6MH8A59SOD', 'Superman', 'vangelis', 'papadopoulos', '', NULL, NULL, NULL, 1, '2017-08-28 09:15:38', 0, '', 0, 0, 0, ''),
(58, 'WSK1PxXPXHv65PEO', 'mas', 'Alexander', '', '91t6NE+C0gYO2skTvZhicwTLf630UOf1TvU4LNXsfhWxzg/7AO/nacrf79RahLJAvwD33GBk+wz6Z3TAOBIFEi', NULL, 'mas', NULL, 1, '2017-08-28 12:31:26', 1, 'Новый Свет, Крым', 0, 0, 0, ''),
(59, 'Hbk5L1v5PINt96rU', 'test1', 'vasia', 'vasiok', 'FO8hrkpNt1js0G3CF6zNWQUd85s5lTQK+sFNEoEOyIp8cFZm+rXuLYm7QB4JMTX46x7kh5608pMD8GxzF0R4jK', NULL, 'test1@mail.ru', NULL, 1, '2017-08-28 13:10:26', 0, 'Москва, Россия', 1, 0, 1, 'eto matya stranitsa i tut ia pishu o sibe'),
(60, '3IxI1oYV5IPf945y', 'test2', 'araik', 'tyytytyty', '209Cc80Gr1XPHG6+a2YPqw2WmBajvToXjuexK0TzcylBtT6GcmOM1QZCLQ/Ot4ZyFjnF1L+NBHnLYgkmJ8Dr61', NULL, 'arisgev84@gmail.com', NULL, 1, '2017-08-28 13:11:53', 0, '', 0, 0, 0, ''),
(72, '6VatEDhkt55i0EKI', 'blogger', '', '', 'DjTG2pcbFfbSrkmlsdBMRAaOEjpQYKEjtB0TJ2xSeb9jG9jrIyBK099/uMghwpHb7cQscOnO7tX640JjwnkYaP', NULL, 'blogger@mail.ru', NULL, 1, '2017-08-28 15:13:49', 0, '', 0, 0, 0, '');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `googlemaplabels`
--
ALTER TABLE `googlemaplabels`
  ADD CONSTRAINT `googlemaplabels_ibfk_1` FOREIGN KEY (`type`) REFERENCES `marker_types` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
