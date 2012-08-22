-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 22 2012 г., 14:25
-- Версия сервера: 5.5.24
-- Версия PHP: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `local_fundraiser`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ad`
--

CREATE TABLE IF NOT EXISTS `ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `id_fundraiser` int(11) NOT NULL,
  `need_raise` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `still_need_raise` float NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `meaning` text,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `ad`
--

INSERT INTO `ad` (`id`, `user_id`, `id_fundraiser`, `need_raise`, `total_cost`, `still_need_raise`, `date`, `description`, `meaning`, `create_date`) VALUES
(1, 0, 0, 87, 786, 0, '0000-00-00', 'jnllkj', NULL, '0000-00-00 00:00:00'),
(2, 0, 3, 435, 324, 435, '2012-08-17', 'dfg', NULL, '2012-08-20 16:05:25'),
(3, 0, 1, 3, 34, 3, '2012-08-14', 'вап', 'выа', '2012-08-21 08:22:44'),
(4, 0, 1, 3, 34, 3, '2012-08-14', 'вап', 'выа', '2012-08-21 08:23:16'),
(5, 0, 1, 31, 34, 31, '2012-08-23', 'авы', 'ыва', '2012-08-21 08:31:45'),
(6, 0, 1, 3, 43, 3, '2012-08-23', 'sdf', 'fds', '2012-08-21 08:44:54'),
(7, 0, 1, 43, 324, 43, '2012-08-24', 'авп', 'авп', '2012-08-21 08:49:25'),
(8, 0, 1, 43, 767, 43, '2012-08-22', 'sdf', 'sf', '2012-08-21 09:05:12'),
(9, 0, 2, 47, 324, 47, '2012-08-23', 'hh', 'hg', '2012-08-21 10:19:59'),
(10, 0, 2, 324, 3234, 324, '2012-08-22', 'fdgsdf', 'fsddsf', '2012-08-21 11:12:17'),
(11, 2, 1, 32, 44, 32, '2012-08-23', 'sefre', 'erte', '2012-08-21 11:13:29');

-- --------------------------------------------------------

--
-- Структура таблицы `fundraisers`
--

CREATE TABLE IF NOT EXISTS `fundraisers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `fundraisers`
--

INSERT INTO `fundraisers` (`id`, `name`, `description`) VALUES
(1, 'Gift/Donation Request', 'In this case the student is just asking friends and family members to donate/gift money toward their trip. This is the most simple method, and requires only that they share the page with friends and family.'),
(2, 'Service Project', 'Students choosing this option will participate in some kind of community or neighborhood service project, possibly something organized by the school, or another community group, or even something they create themselves. I imagine that some kind of verification of the completion of the project will be needed so that contributors know the project was completed…'),
(3, 'Fundraising Activity', 'This option will be used to promote activities such as a car wash, walk-a-thon, bowl-a-thon, dance-a-thon, etc. These kinds of activities typically involve people pledging money based on the performance of the participant, but the difference in the functionality of the app in this case will be the same as a service project. (This should also have a verification method of some kind.)');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('f6cec40b5413d52df5ac1409f3bb82c9', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:14.0) Gecko/20100101 Firefox/14.0.1', 1345626511, 'a:1:{s:9:"user_data";s:0:"";}');

-- --------------------------------------------------------

--
-- Структура таблицы `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `transaction_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `money` float NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `firstname`, `lastname`, `activation_code`, `active`) VALUES
(1, 'qqq1@qqq.qqq', 'b2ca678b4c936f905fb82f2733f5297f', 'qqq1', 'qqq1', 'f630f7df1b9e0a90d103a7195098f1a8', 0),
(2, 'qqq@qqq.qqq', 'b2ca678b4c936f905fb82f2733f5297f', 'qqq', 'qqq', 'e245c2b65943574c0cfa1fc3029f4478', 0),
(3, 'sdfh@zdfh.sdf', 'a5c9a3b44aaf44217da5dcc997765b1f', 'dfh', 'sdfh', '9a61b383cd6b1ea31a0836ab86f65392', 0),
(4, 'sdfhsdf@zdfhs.sdf', '698d51a19d8a121ce581499d7b701668', 'xdffg', 'sdftgjdfgjd', '3f206ffdae48d0961ba7c1c7974333db', 0),
(5, 'sss@sss.sss', '9f6e6800cfae7749eb6c486619254b9c', 'sss', 'sss', 'e6ae2bb6525fb1bdf5b4fd223f4263a5', 0),
(6, 'test230977@gmail.com', '0cc175b9c0f1b6a831c399e269772661', 'a', 'a', 'c0a2af178d1bb01a8a3464c7669ac128', 0),
(7, 'vvv@vvv.vvv', '4786f3282f04de5b5c7317c490c6d922', 'vvv', 'vvv', '24b3688db1d90b9f5703979dd8c7445e', 0),
(8, 'www@www.www', '4eae35f1b35977a00ebd8086c259d4c9', 'www', 'www', '6a877ed0f114f44130bca7a57b13ae61', 0),
(9, 'zzz@zzz.zzz', 'fbade9e36a3f36d3d676c1b808451dd7', 'z', 'z', '5957b6487c5099c1ddb2434dd0dcbd08', 1),
(10, 'qwerty@qwerty.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'qwerty', 'qwerty', '356d00a7233cb4bf2130045dec920e50', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
