-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 22 2012 г., 14:45
-- Версия сервера: 5.5.24
-- Версия PHP: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `fundraiser`
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
(2, 0, 3, 435, 324, 435, '2012-08-17', 'dfg', NULL, '2012-08-20 13:05:25'),
(3, 0, 1, 3, 34, 3, '2012-08-14', 'вап', 'выа', '2012-08-21 05:22:44'),
(4, 0, 1, 3, 34, 3, '2012-08-14', 'вап', 'выа', '2012-08-21 05:23:16'),
(5, 0, 1, 31, 34, 31, '2012-08-23', 'авы', 'ыва', '2012-08-21 05:31:45'),
(6, 0, 1, 3, 43, 3, '2012-08-23', 'sdf', 'fds', '2012-08-21 05:44:54'),
(7, 0, 1, 43, 324, 43, '2012-08-24', 'авп', 'авп', '2012-08-21 05:49:25'),
(8, 0, 1, 43, 767, 43, '2012-08-22', 'sdf', 'sf', '2012-08-21 06:05:12'),
(9, 0, 2, 47, 324, 47, '2012-08-23', 'hh', 'hg', '2012-08-21 07:19:59'),
(10, 0, 2, 324, 3234, 324, '2012-08-22', 'fdgsdf', 'fsddsf', '2012-08-21 08:12:17'),
(11, 2, 1, 32, 44, 32, '2012-08-23', 'sefre', 'erte', '2012-08-21 08:13:29');

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
('280c1815b0e7e5bbc9dce1c8ac882492', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345630706, 'a:2:{s:9:"user_data";s:0:"";s:4:"user";b:0;}'),
('3669213205fd30c8b4c20898a77c4bab', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345632755, 'a:1:{s:9:"user_data";s:0:"";}'),
('43241bad49bc98ea8788155697be8f59', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345633707, 'a:2:{s:9:"user_data";s:0:"";s:4:"user";a:8:{s:8:"password";b:1;s:5:"email";s:20:"test230977@gmail.com";s:9:"firstname";s:4:"Ivan";s:8:"lastname";s:6:"Ivanov";s:6:"avatar";s:186:"https://graph.facebook.com/100003261707271/picture?type=small&access_token=AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD";s:21:"facebook_access_token";s:111:"AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD";s:15:"activation_code";s:32:"f5b342e7146e07089acb1d39f54619cb";s:6:"active";s:1:"1";}}'),
('693c8616735bca9cc7cdd8d80d7f0a72', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345630137, 'a:2:{s:9:"user_data";s:0:"";s:4:"user";b:0;}'),
('693d96ae0017f0507c7e8b8492f89827', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345631593, 'a:1:{s:9:"user_data";s:0:"";}'),
('787c63a93a49355056e2a114bbc9c463', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345632440, 'a:2:{s:9:"user_data";s:0:"";s:4:"user";a:8:{s:5:"email";s:20:"test230977@gmail.com";s:8:"password";b:1;s:9:"firstname";s:4:"Ivan";s:8:"lastname";s:6:"Ivanov";s:21:"facebook_access_token";s:111:"AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD";s:6:"avatar";s:186:"https://graph.facebook.com/100003261707271/picture?type=small&access_token=AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD";s:15:"activation_code";s:32:"f5b342e7146e07089acb1d39f54619cb";s:6:"active";s:1:"0";}}'),
('8bd1051419734fdd16e2d5a56fbe9224', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345631546, 'a:2:{s:9:"user_data";s:0:"";s:4:"user";a:10:{s:8:"password";b:0;s:5:"email";s:20:"test230977@gmail.com";s:9:"firstname";s:4:"Ivan";s:8:"lastname";s:6:"Ivanov";s:6:"avatar";s:186:"https://graph.facebook.com/100003261707271/picture?type=small&access_token=AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD";s:21:"facebook_access_token";s:111:"AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD";s:15:"activation_code";s:32:"f5b342e7146e07089acb1d39f54619cb";s:6:"active";s:1:"0";s:5:"error";b:0;s:6:"action";s:5:"login";}}'),
('ac4a2637b8e51e4e435a86afb50295d4', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345630314, 'a:2:{s:9:"user_data";s:0:"";s:4:"user";b:0;}'),
('aff8c5d119a08a0262a46b932224ac61', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345631455, 'a:2:{s:9:"user_data";s:0:"";s:4:"user";a:10:{s:8:"password";b:0;s:5:"email";s:20:"test230977@gmail.com";s:9:"firstname";s:4:"Ivan";s:8:"lastname";s:6:"Ivanov";s:6:"avatar";s:186:"https://graph.facebook.com/100003261707271/picture?type=small&access_token=AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD";s:21:"facebook_access_token";s:111:"AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD";s:15:"activation_code";s:32:"f5b342e7146e07089acb1d39f54619cb";s:6:"active";s:1:"0";s:5:"error";b:0;s:6:"action";s:5:"login";}}'),
('d0c483920753a9d4df1887f3c1063d3a', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345631000, 'a:1:{s:9:"user_data";s:0:"";}'),
('d33e9b1327ea89d15d6b2d2edbbbf5b8', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (KHTML, like Gecko) Ubuntu/12.04 Chromium/18.0.1025.168 Chrome/18.0.102', 1345633010, 'a:2:{s:9:"user_data";s:0:"";s:4:"user";a:8:{s:8:"password";b:1;s:5:"email";s:20:"test230977@gmail.com";s:9:"firstname";s:4:"Ivan";s:8:"lastname";s:6:"Ivanov";s:6:"avatar";s:186:"https://graph.facebook.com/100003261707271/picture?type=small&access_token=AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD";s:21:"facebook_access_token";s:111:"AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD";s:15:"activation_code";s:32:"f5b342e7146e07089acb1d39f54619cb";s:6:"active";s:1:"1";}}');

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
  `facebook_access_token` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `firstname`, `lastname`, `facebook_access_token`, `avatar`, `activation_code`, `active`) VALUES
(1, 'aaa@aaa.aaa', '47bce5c74f589f4867dbd57e9ca9f808', 'aaa', 'aaa', '', '', 'c91bde8451ec367189baa1c64723781f', 1),
(2, 'test230977@gmail.com', '36347412c7d30ae6fde3742bbc4f21b9', 'Ivan', 'Ivanov', 'AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD', 'https://graph.facebook.com/100003261707271/picture?type=small&access_token=AAAG0FICHRPcBALI2HDg9tXRKQ8krKpMcUVQki5OY3hdK8ZC10IuXBDa4fNXcpe9LZCi4iGJ2GfOK0yvyTd4EC1U9G2DpeZCAEBZALKLGhgZDZD', 'f5b342e7146e07089acb1d39f54619cb', 1),
(3, 'xxx@xxx.xxx', 'f561aaf6ef0bf14d4208bb46a4ccb3ad', 'xxx', 'xxx', '', '', 'abb0353ad49b769700105120d7e28254', 0),
(4, 'qwerty@qwerty.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'qwerty', 'qwerty', '', '', '356d00a7233cb4bf2130045dec920e50', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
