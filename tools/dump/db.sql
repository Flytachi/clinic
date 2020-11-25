-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 24 2020 г., 12:41
-- Версия сервера: 10.5.8-MariaDB
-- Версия PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `clinic`
--

-- --------------------------------------------------------

--
-- Структура таблицы `beds`
--

CREATE TABLE `beds` (
  `id` int(11) NOT NULL,
  `floor` tinyint(4) NOT NULL,
  `ward` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `types` tinyint(1) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `beds`
--

INSERT INTO `beds` (`id`, `floor`, `ward`, `num`, `types`, `user_id`) VALUES
(1, 1, 1, 1, 1, NULL),
(2, 1, 1, 2, 1, NULL),
(3, 1, 1, 3, 1, 18),
(4, 1, 1, 4, 1, NULL),
(5, 1, 2, 1, 2, NULL),
(6, 1, 2, 2, 2, NULL),
(7, 1, 3, 1, 1, NULL),
(8, 1, 3, 2, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `bed_type`
--

CREATE TABLE `bed_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `price` decimal(35,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bed_type`
--

INSERT INTO `bed_type` (`id`, `name`, `price`) VALUES
(1, 'Обычная', '100'),
(2, 'VIP', '500');

-- --------------------------------------------------------

--
-- Структура таблицы `bypass`
--

CREATE TABLE `bypass` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `preparat_id` int(11) DEFAULT NULL,
  `count` smallint(6) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bypass`
--

INSERT INTO `bypass` (`id`, `user_id`, `parent_id`, `preparat_id`, `count`, `description`, `status`, `add_date`) VALUES
(1, 14, 6, 1, 13, '№ раза в день', 1, '2020-11-24 12:20:02'),
(3, 14, 26, NULL, NULL, 'qwqws', NULL, '2020-11-24 12:25:24');

-- --------------------------------------------------------

--
-- Структура таблицы `chat`
--

CREATE TABLE `chat` (
  `id` int NOT NULL,
  `id_push` varchar(255) DEFAULT NULL,
  `id_pull` varchar(255) DEFAULT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_bin,
  `date` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `activity` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `chat`
--

INSERT INTO `chat` (`id`, `id_push`, `id_pull`, `message`, `date`, `time`, `activity`) VALUES
(1, '6', '5', 'ewwwwwwwwwwwwwwwwww', '2020.11.23', '22:44', 1),
(2, '6', '5', 'afdasdfsd', '2020.11.23', '22:44', 1),
(3, '5', '6', 'trtwertwertrwet', '2020.11.23', '22:44', 1),
(4, '5', '6', 'gsdfgsdgsdfgsdf', '2020.11.23', '22:44', 1),
(5, '5', '7', 'fasfsdf', '2020.11.23', '22:45', 1),
(6, '5', '7', 'fasfsdfaertwetwer', '2020.11.23', '22:45', 1),
(7, '5', '7', 'gsdfgsdfgtwet', '2020.11.23', '22:45', 1),
(8, '5', '6', 'fasdfasdf', '2020.11.23', '22:47', 1),
(9, '5', '6', 'fadfsdfasdf', '2020.11.23', '22:47', 1),
(10, '5', '6', '\nafdsfasdf', '2020.11.23', '22:48', 1),
(11, '7', '5', 'fasdfasdfasdf', '2020.11.24', '00:40', 1),
(12, '7', '5', '\nadfasdfasdf', '2020.11.24', '00:40', 1),
(13, '7', '5', '\nhfghfghhjfh', '2020.11.24', '00:40', 1),
(14, '7', '5', 'afsdasdfd', '2020.11.24', '00:49', 1),
(15, '7', '5', '\nyteyeryertyer', '2020.11.24', '00:49', 1),
(16, '7', '5', 'oooooooooooooo', '2020.11.24', '00:49', 1),
(17, '7', '5', 'iiiiiiiiiiiiiiiiiiiiiiiiiii', '2020.11.24', '00:50', 1),
(18, '7', '5', 'jhhhhhhhhhg', '2020.11.24', '00:51', 1),
(19, '7', '5', '\nljkkkkkkkkkkk', '2020.11.24', '00:51', 1),
(20, '7', '5', '\ntttttttttttttttttttttttttt', '2020.11.24', '00:52', 1),
(21, '7', '5', 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee', '2020.11.24', '00:52', 1),
(22, '7', '5', '\nkhjljklhjkloiljhiklhmn,kn', '2020.11.24', '00:53', 1),
(23, '7', '5', 'wretwertwert', '2020.11.24', '01:04', 1),
(24, '7', '5', 'афыфаыаывафыва', '2020.11.24', '01:34', 1),
(25, '7', '5', '\nафывафывафывафыва', '2020.11.24', '01:34', 1),
(26, '7', '5', 'yuryuryt', '2020.11.24', '14:45', 1),
(27, '7', '5', 'hdfghdfghdfgh', '2020.11.24', '14:46', 1),
(28, '7', '5', '\nyereter', '2020.11.24', '14:46', 1),
(29, '7', '5', 'hdfghdgh', '2020.11.24', '14:46', 1),
(30, '7', '5', 'yteyteyetr', '2020.11.24', '14:49', 1),
(31, '7', '5', '\nyt', '2020.11.24', '14:49', 1),
(32, '7', '5', '\nyer', '2020.11.24', '14:49', 1),
(33, '7', '5', '\nerty', '2020.11.24', '14:49', 1),
(34, '7', '5', '\neryt', '2020.11.24', '14:49', 1),
(35, '7', '5', '\nerty', '2020.11.24', '14:49', 1),
(36, '7', '5', '\nerty', '2020.11.24', '14:49', 1),
(37, '7', '5', '\nrt', '2020.11.24', '14:49', 1),
(38, '7', '5', '\n', '2020.11.24', '14:49', 1),
(39, '7', '5', '\ner', '2020.11.24', '14:49', 1),
(40, '7', '5', '\nt', '2020.11.24', '14:49', 1),
(41, '7', '5', '\ntwertwertertwertwertw', '2020.11.24', '14:49', 1),
(42, '7', '5', '\nert', '2020.11.24', '14:49', 1),
(43, '7', '5', '\nwtertwe', '2020.11.24', '14:49', 1),
(44, '7', '5', '\nrt', '2020.11.24', '14:49', 1),
(45, '7', '5', '\nwert', '2020.11.24', '14:49', 1),
(46, '7', '5', '\nwertwert', '2020.11.24', '14:49', 1),
(47, '7', '5', '\nwertwert', '2020.11.24', '14:49', 1),
(48, '7', '5', '\nwertwe', '2020.11.24', '14:49', 1),
(49, '7', '5', '\nrtwe', '2020.11.24', '14:49', 1),
(50, '7', '5', '\ntr', '2020.11.24', '14:49', 1),
(51, '7', '5', '\nwertw', '2020.11.24', '14:49', 1),
(52, '7', '5', '\nert', '2020.11.24', '14:49', 1),
(53, '7', '5', '\nwret', '2020.11.24', '14:49', 1),
(54, '7', '5', '\nwert', '2020.11.24', '14:49', 1),
(55, '7', '5', '\nwert', '2020.11.24', '14:49', 1),
(56, '7', '5', '\nwerwert', '2020.11.24', '14:49', 1),
(57, '7', '5', '\nwertwertw', '2020.11.24', '14:49', 1),
(58, '7', '5', '\nert', '2020.11.24', '14:49', 1),
(59, '7', '5', '\nwertwe', '2020.11.24', '14:49', 1),
(60, '7', '5', '\nrt', '2020.11.24', '14:49', 1),
(61, '7', '5', '\nwertw', '2020.11.24', '14:49', 1),
(62, '7', '5', 'tyttryete', '2020.11.24', '14:50', 1),
(63, '7', '5', '\ntry', '2020.11.24', '14:50', 1),
(64, '7', '5', '\nertye', '2020.11.24', '14:50', 1),
(65, '7', '5', '\nrty', '2020.11.24', '14:50', 1),
(66, '7', '5', '\nertyer', '2020.11.24', '14:50', 1),
(67, '7', '5', '\nty', '2020.11.24', '14:50', 1),
(68, '7', '5', '\netrye', '2020.11.24', '14:50', 1),
(69, '7', '5', '\nrty', '2020.11.24', '14:50', 1),
(70, '7', '5', '\nerty', '2020.11.24', '14:50', 1),
(71, '7', '5', '\nery', '2020.11.24', '14:50', 1),
(72, '7', '5', '\nery', '2020.11.24', '14:50', 1),
(73, '7', '5', '\nerty', '2020.11.24', '14:50', 1),
(74, '7', '5', '\nerert', '2020.11.24', '14:50', 1),
(75, '7', '5', '\nert', '2020.11.24', '14:50', 1),
(76, '7', '5', 'gfdsgdfgsdfg', '2020.11.24', '14:56', 1),
(77, '7', '5', 'gsdfgsdfgdf', '2020.11.24', '14:56', 1),
(78, '7', '5', 'yetrertyertyetr', '2020.11.24', '14:57', 1),
(79, '7', '5', 'getghdshdfghdfghdfghhdgf', '2020.11.24', '14:58', 1),
(80, '7', '5', '\n5234545234523', '2020.11.24', '14:58', 1),
(81, '7', '5', '\n45', '2020.11.24', '14:58', 1),
(82, '7', '5', '\n2345', '2020.11.24', '14:58', 1),
(83, '7', '5', '\n23', '2020.11.24', '14:58', 1),
(84, '7', '5', '\n45', '2020.11.24', '14:58', 1),
(85, '7', '5', '\n2345', '2020.11.24', '14:58', 1),
(86, '7', '5', '\n2345', '2020.11.24', '14:58', 1),
(87, '7', '5', '\n2345', '2020.11.24', '14:58', 1),
(88, '7', '5', '\n2345', '2020.11.24', '14:58', 1),
(89, '7', '5', '\n2345', '2020.11.24', '14:58', 1),
(90, '7', '5', '\n2345234523', '2020.11.24', '14:58', 1),
(91, '7', '5', '\n4523', '2020.11.24', '14:58', 1),
(92, '7', '5', '\n4523', '2020.11.24', '14:58', 1),
(93, '7', '5', '\n45', '2020.11.24', '14:58', 1),
(94, '7', '5', '5674674764576456', '2020.11.24', '14:59', 1),
(95, '7', '5', '\n756476756745674567', '2020.11.24', '14:59', 1),
(96, '7', '5', '\nuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuu', '2020.11.24', '14:59', 1),
(97, '7', '5', 'twertertwretwertwer', '2020.11.24', '15:00', 1),
(98, '7', '5', 'tgertwertwer', '2020.11.24', '15:00', 1),
(99, '7', '5', '\ngsdfgsdfgsdfgsd', '2020.11.24', '15:00', 1),
(100, '7', '5', '\ntwetwertwertwer', '2020.11.24', '15:00', 1),
(101, '7', '5', '\nfasdfdasfasdfasd', '2020.11.24', '15:01', 1),
(102, '7', '5', '\ngargewgergfgsdfgsdfg', '2020.11.24', '15:01', 1),
(103, '7', '5', '\ngafdgsdfgsdfgdf', '2020.11.24', '15:01', 1),
(104, '7', '5', '\ntrwetwertwerttrwetwe', '2020.11.24', '15:01', 1),
(105, '7', '5', '\ntwertwertwer', '2020.11.24', '15:01', 1),
(106, '7', '5', '\ntwertwertwertwertertwer', '2020.11.24', '15:01', 1),
(107, '7', '5', 'twertwertwert', '2020.11.24', '15:02', 1),
(108, '7', '5', 'twertwertwert', '2020.11.24', '15:02', 1),
(109, '7', '5', 'twertwertwertfdgsrgwrtwertw', '2020.11.24', '15:02', 1),
(110, '7', '5', 'sgdfsgfgggthryjryhntyr', '2020.11.24', '15:02', 1),
(111, '7', '5', 't', '2020.11.24', '15:02', 1),
(112, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(113, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(114, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(115, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(116, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(117, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(118, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(119, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(120, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(121, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(122, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(123, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(124, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(125, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(126, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(127, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(128, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(129, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(130, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(131, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(132, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(133, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(134, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(135, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(136, '7', '5', '\nt', '2020.11.24', '15:02', 1),
(137, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(138, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(139, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(140, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(141, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(142, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(143, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(144, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(145, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(146, '7', '5', '\ntt', '2020.11.24', '15:03', 1),
(147, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(148, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(149, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(150, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(151, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(152, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(153, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(154, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(155, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(156, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(157, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(158, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(159, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(160, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(161, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(162, '7', '5', '\ntt', '2020.11.24', '15:03', 1),
(163, '7', '5', '\ntt', '2020.11.24', '15:03', 1),
(164, '7', '5', '\n', '2020.11.24', '15:03', 1),
(165, '7', '5', '\ntt', '2020.11.24', '15:03', 1),
(166, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(167, '7', '5', '\ntt', '2020.11.24', '15:03', 1),
(168, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(169, '7', '5', '\ntt', '2020.11.24', '15:03', 1),
(170, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(171, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(172, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(173, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(174, '7', '5', '\nt', '2020.11.24', '15:03', 1),
(175, '7', '5', '\ntyyertyertyretyery', '2020.11.24', '15:03', 1),
(176, '7', '5', '\nhgd', '2020.11.24', '15:03', 1),
(177, '7', '5', '\nty', '2020.11.24', '15:03', 1),
(178, '7', '5', '\nerth', '2020.11.24', '15:03', 1),
(179, '7', '5', '\ndfgh', '2020.11.24', '15:03', 1),
(180, '7', '5', '\ntry', '2020.11.24', '15:03', 1),
(181, '7', '5', '\neru', '2020.11.24', '15:03', 1),
(182, '7', '5', '\nhd', '2020.11.24', '15:03', 1),
(183, '7', '5', '\ntyu', '2020.11.24', '15:03', 1),
(184, '7', '5', '\ntry', '2020.11.24', '15:03', 1),
(185, '7', '5', '\nhd', '2020.11.24', '15:03', 1),
(186, '7', '5', 'hf', '2020.11.24', '15:07', 1),
(187, '7', '5', 'ttt', '2020.11.24', '15:10', 1),
(188, '7', '5', 'tt', '2020.11.24', '15:11', 1),
(189, '7', '5', 'tttttttttggggggggggggggggg', '2020.11.24', '15:16', 1),
(190, '5', '7', 'gsdfgfdgsdfgsdf', '2020.11.24', '16:18', 1),
(191, '5', '7', 'yyyyyyyy', '2020.11.24', '16:18', 1),
(192, '5', '7', 'uytrutyurtyyjhjfhjfghnjf', '2020.11.24', '16:34', 1),
(193, '5', '7', 'czxczxv', '2020.11.24', '16:37', 1),
(194, '5', '7', '\nyruryuryurty', '2020.11.24', '16:37', 1),
(195, '5', '7', '\nuyturtyurturturturty', '2020.11.24', '16:37', 1),
(196, '5', '7', 'fgdsdgsdfgsdfg\n', '2020.11.24', '16:39', 1),
(197, '5', '7', 'twertwertwert\n', '2020.11.24', '16:39', 1),
(198, '5', '7', '\ntwertretretwertwertwertwr', '2020.11.24', '16:39', 1),
(199, '7', '5', 'ffffffffff', '2020.11.24', '16:51', 1),
(200, '6', '7', 'i78iyuiyui', '2020.11.24', '16:52', 1),
(201, '7', '6', 'ha', '2020.11.24', '16:52', 1),
(202, '6', '7', '7567', '2020.11.24', '16:52', 1),
(203, '6', '7', 'ooupopuiop', '2020.11.24', '16:56', 1),
(204, '7', '6', 'гкннгкенопаое', '2020.11.24', '17:03', 1),
(205, '7', '5', 'рар', '2020.11.24', '17:05', 1),
(206, '7', '5', '6543634', '2020.11.24', '17:06', 1),
(207, '7', '5', 'лорлпшглншлнш', '2020.11.24', '17:07', 1),
(208, '7', '6', '9999999999999999999', '2020.11.24', '17:11', 1),
(209, '7', '5', 'wwwwwwwwwwwwwwwwwwwwwwwwwwwww', '2020.11.24', '17:19', 1),
(210, '7', '6', 'fasdfsdfsdfsdf', '2020.11.24', '17:19', 1),
(211, '6', '7', 'bvxcbxcvbxcvb', '2020.11.24', '17:20', 1),
(212, '7', '6', 'tttttttttttttttt', '2020.11.24', '17:21', 1),
(213, '7', '6', 'twetwertwer\n', '2020.11.24', '17:21', 1),
(214, '7', '6', '\ntyweytryeryhtghrytujhytwer', '2020.11.24', '17:21', 1),
(215, '7', '6', '\ntwer', '2020.11.24', '17:21', 1),
(216, '7', '6', '\ntwertwe', '2020.11.24', '17:21', 1),
(217, '7', '6', '\nrtwertwertwertwrwertwer', '2020.11.24', '17:21', 1),
(218, '7', '6', '\ntwertwertwer', '2020.11.24', '17:21', 1),
(219, '6', '7', 'ddd', '2020.11.24', '18:02', 1),
(220, '5', '7', 'pouioupuioupiop', '2020.11.24', '19:05', 0),
(221, '5', '7', 'ppppppppppp', '2020.11.24', '19:05', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `division`
--

CREATE TABLE `division` (
  `id` int(11) NOT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `division`
--

INSERT INTO `division` (`id`, `level`, `title`, `name`) VALUES
(1, 5, 'Травматалогия', 'Травматолог'),
(2, 5, 'Хирургия', 'Хирург'),
(3, 5, 'Стоматология', 'Стоматолог'),
(6, 5, 'Радиология', 'Радиолог'),
(7, 6, 'Лаборатория', 'Лаборант');

-- --------------------------------------------------------

--
-- Структура таблицы `laboratory_analyze`
--

CREATE TABLE `laboratory_analyze` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `analyze_id` int(11) DEFAULT NULL,
  `result` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `laboratory_analyze`
--

INSERT INTO `laboratory_analyze` (`id`, `user_id`, `visit_id`, `analyze_id`, `result`, `description`) VALUES
(1, 14, 24, 3, '2', 'ewq'),
(2, 14, 24, 4, '12', 'wqeq'),
(3, 14, 26, 1, '10', 'w'),
(4, 14, 26, 2, '7', '3');

-- --------------------------------------------------------

--
-- Структура таблицы `laboratory_analyze_type`
--

CREATE TABLE `laboratory_analyze_type` (
  `id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `standart` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `laboratory_analyze_type`
--

INSERT INTO `laboratory_analyze_type` (`id`, `service_id`, `name`, `code`, `standart`, `status`) VALUES
(1, 10, '1 Анализ', '01', '10', 1),
(2, 10, '2 Анализ', '02', '7', 1),
(3, 11, '1Анализ', '13', '12', 1),
(4, 11, '2 Анализ', '5543', '34', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_text` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `notes`
--

INSERT INTO `notes` (`id`, `parent_id`, `user_id`, `date_text`, `description`) VALUES
(1, 6, NULL, 'June 4th 08:47', 'qewqe');

-- --------------------------------------------------------

--
-- Структура таблицы `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `user_level` tinyint(4) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `price` decimal(65,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `service`
--

INSERT INTO `service` (`id`, `user_level`, `division_id`, `name`, `price`) VALUES
(1, 1, NULL, 'Стационарный Осмотр', NULL),
(2, 5, 3, 'Вырвать зуб', '23434.0'),
(4, 5, 6, 'MRT', '1000.0'),
(5, 5, 2, 'Грыжа диска', '100000.0'),
(6, 5, 2, 'Апендицид', '200.0'),
(7, 5, 6, 'Ренген', '2000.0'),
(8, 5, 6, 'Узи', '3000.0'),
(9, 5, 2, 'Операция на сердце', '40000.0'),
(10, 6, 7, 'Antitela', '20000.0'),
(11, 6, 7, 'covid 19', '10000.0');

-- --------------------------------------------------------

--
-- Структура таблицы `storage_type`
--

CREATE TABLE `storage_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `storage_type`
--

INSERT INTO `storage_type` (`id`, `name`) VALUES
(1, 'Аптечный склад');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(70) DEFAULT NULL,
  `first_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `father_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `dateBith` date DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `passport` varchar(255) DEFAULT NULL,
  `placeWork` varchar(1000) DEFAULT NULL,
  `position` varchar(1000) DEFAULT NULL,
  `numberPhone` varchar(255) DEFAULT NULL,
  `residenceAddress` varchar(1000) DEFAULT NULL,
  `registrationAddress` varchar(1000) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `user_level` tinyint(4) NOT NULL,
  `division_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `share` float DEFAULT 0,
  `allergy` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `parent_id`, `username`, `password`, `first_name`, `last_name`, `father_name`, `dateBith`, `region`, `passport`, `placeWork`, `position`, `numberPhone`, `residenceAddress`, `registrationAddress`, `gender`, `user_level`, `division_id`, `status`, `share`, `allergy`, `add_date`) VALUES
(1, NULL, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Jasur', 'Rakhmatov', 'Ilhomovich', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 99.1, NULL, '2020-10-31 17:48:15'),
(2, NULL, 'legion', 'bd53add93b49c4dff72730e05f11f1ee31074fe4', 'legion', 'legion', 'legion', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 1, 20, NULL, '2020-11-08 14:03:49'),
(3, NULL, 'kassa', '913c8fd5abbf64f58c66b63dd31f6c310c757702', 'kassa', 'kassa', 'kassa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 1, 10, NULL, '2020-11-18 15:55:30'),
(4, NULL, 'laboratory', '80240dcecd105d50195cce7a318413dc013733e3', 'laboratory', 'laboratory', 'laboratory', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 7, 1, 10, NULL, '2020-11-18 15:56:33'),
(5, NULL, 'doc_1', '4d5204a88e9f6e4e6d34292df53464549d51e86c', 'Jayson', 'Brody', 'Faker', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 6, 1, 7, NULL, '2020-11-18 15:57:39'),
(6, NULL, 'doc_2', 'fe0c9097da6e3b417d97100d40c38561c295aeff', 'Фарход', 'Якубов', 'Хврвргврйцгв', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 2, 1, 7, NULL, '2020-11-18 15:58:42'),
(7, NULL, 'doc_3', '878897f3f6d05d5081aba73f2b5af61177f52066', 'Вадим', 'Дивцов', 'Личинка', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 2, 1, 8, NULL, '2020-11-18 15:59:50'),
(8, NULL, 'doc_4', 'af22b5cc0aab091cf471c5bcd20616fc7db79426', 'woker', 'Sky', 'Seer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 3, 1, 7, NULL, '2020-11-18 16:01:25'),
(9, NULL, 'legion2', 'fab178bbfc69f1fe963a490726f028ebfb581740', 'legion2', 'legion2', 'legion2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 1, 10, NULL, '2020-11-18 16:02:06'),
(10, NULL, 'legion3', 'd6002ab2c6623db78330613043a7febec0e04fb2', 'legion3', 'legion3', 'legion3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 1, 10, NULL, '2020-11-18 16:02:37'),
(11, NULL, 'kassa2', 'ba87a038ef7c583ecb89e3f026403903a7f365b8', 'kassa2', 'kassa2', 'kassa2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 1, 12, NULL, '2020-11-18 16:04:18'),
(12, 10, NULL, NULL, 'pasient 1', 'pasient 1', 'pasient 1', '2000-12-12', 'Олмазор', 'kjhjkhjkhk', 'nmm,nj,n,n', ',kn,knm,nm,n', '9998989899', 'ajkshdjkashd', 'jhjkh', 1, 15, NULL, 1, 0, 'm,nm,nm,nm,n', '2020-11-18 16:05:52'),
(13, 10, NULL, NULL, 'pasient 2', 'pasient 2', 'pasient 2', '2000-12-12', 'Миробод', 'kjklj', 'kn,knm,n', ',mn,mn,m', '98989898', 'iljiljklj', 'kjkljkl', NULL, 15, NULL, 1, 0, 'm,nm,n', '2020-11-18 16:06:24'),
(14, 2, NULL, NULL, 'Жасур', 'Рахматов', 'Илхомович', '2003-05-08', 'Ромитан', 'AC6453482', 'Хокимиат', 'Глава отдела', '+998934568052', 'Алпомыш', 'Алпомыш', 1, 15, NULL, NULL, 0, NULL, '2020-11-18 16:06:53'),
(15, 10, NULL, NULL, 'pasient 3', 'pasient 3', 'pasient 3', '2000-12-12', 'Олмазор', 'jjjkhjk', 'm,nnm,nmbnm', 'nm,m,nm,n', '98098098098', ',jhknjj', 'jjnjjk', NULL, 15, NULL, NULL, 0, 'm,nm,nm,nm,n', '2020-11-18 16:07:03'),
(16, 9, NULL, NULL, 'Адольф', 'Гитлер', 'Нету', '1899-04-20', 'Ромитан', 'WE2312313', 'Германия, Мюнхен', 'Политик, глава 3 рейха', '998909090899', 'Австрия', 'могила №3', 1, 15, NULL, NULL, 0, 'евреи', '2020-11-18 16:07:03'),
(17, 10, NULL, NULL, 'pasient 4', 'pasient 4', 'pasient 4', '1212-02-11', 'Олмазор', 'kljkljklj', 'kljkljklj', 'ljkljklj', '8909809809', 'iljljklj', 'lkjkljklj', NULL, 15, NULL, NULL, 0, 'lkjlkjkljkl', '2020-11-18 16:07:48'),
(18, 10, NULL, NULL, 'pasient 5', 'pasient 5', 'pasient 5', '2122-03-12', 'Олмазор', 'jkhjkhjk', 'mnm,nm,nm,', 'm,nm,nm,n', '89098098098', 'kjhkljk', 'jkhjkhkjh', NULL, 15, NULL, 1, 0, ',mn,mn,mn', '2020-11-18 16:08:21'),
(19, 9, NULL, NULL, 'Иосиф', 'Сталин', 'Виссарионович', '1924-01-21', 'Ромитан', 'WE3424234234', 'Россия', 'Император Росси', '+998909990099', 'Россия', 'Москва кремоль', 1, 15, NULL, NULL, 0, 'Гитлер', '2020-11-18 16:10:05'),
(20, 9, NULL, NULL, 'Владимир', 'Ленин', 'Ильич', '1870-04-22', 'Ромитан', 'QW452345234532', 'CCCP', 'Вождь', '+998909445465', 'Россия', 'Мавзолей', 1, 15, NULL, NULL, 0, 'Капитализм', '2020-11-18 16:12:51'),
(21, 2, NULL, NULL, 'Pasient 6', 'Pasient 6', 'Pasient 6', '2019-11-06', 'Чилонзор', 'цуй321112312312', 'Pasient 6', 'Pasient 6', '2132132112312231', 'Pasient 6', 'Pasient 6', NULL, 15, NULL, NULL, 0, 'Pasient 6', '2020-11-18 16:13:53'),
(22, 9, NULL, NULL, 'Алексей', 'Шевцов', 'Владимирович', '1999-11-24', 'Юнусобод', 'WE324234234', 'Ютуб', 'Блогер', '+998990989078', 'Украина Одесса', 'Украина Одесса', 1, 15, NULL, NULL, 0, 'Глупые люди', '2020-11-18 16:15:37'),
(23, 9, NULL, NULL, 'Кира', 'Хошигаке', 'НЕТ', '1995-01-20', 'Юнусобод', 'CV 333222', 'Япония Токио', 'Коммисар', '+99899900098', 'Япония Токио', 'Япония Токио', 1, 15, NULL, NULL, 0, 'L', '2020-11-18 16:17:36'),
(24, 9, NULL, NULL, 'Умархан', 'Убунту', 'Вадимович', '2000-11-14', 'Юнусобод', 'AZ', 'Мексика', 'Укратитель змей', '+998999088998', 'Бухара', 'Бухара', 1, 15, NULL, NULL, 0, 'любовь', '2020-11-18 16:20:14'),
(25, 9, NULL, NULL, 'Гвидо', 'Мисто', 'Олегович', '1982-02-18', 'Ромитан', 'EWR2345345345', 'Аргентиа', 'Нарко барон', '+998994232', 'Швеция', 'Аргентина', 1, 15, NULL, NULL, 0, 'женщины', '2020-11-18 16:22:17'),
(26, NULL, 'nurce_1', 'c000e8b0a3f6e91f586867365618581675fa20d7', 'nurce', 'nurce', 'nurce', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, 1, 1, NULL, '2020-11-20 19:11:11'),
(27, NULL, 'coock', 'baa9797d705eebdf66f75d623c3cc1756c78d2ff', 'coock', 'coock', 'coock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, 1, 1, NULL, '2020-11-23 10:50:15'),
(28, NULL, 'doc_h', '8171857a4e3fbc786dd873feb372a6189166f891', 'doc_h', 'doc_h', 'doc_h', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, 1, 99, NULL, '2020-11-23 11:03:05');

-- --------------------------------------------------------

--
-- Структура таблицы `user_stats`
--

CREATE TABLE `user_stats` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `stat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pressure` int(11) DEFAULT NULL,
  `pulse` int(11) DEFAULT NULL,
  `temperature` int(11) DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_stats`
--

INSERT INTO `user_stats` (`id`, `parent_id`, `visit_id`, `stat`, `pressure`, `pulse`, `temperature`, `add_date`) VALUES
(1, 26, 27, 'Хорошее', 12, 2121, 22, '2020-11-24 12:32:28');

-- --------------------------------------------------------

--
-- Структура таблицы `visit`
--

CREATE TABLE `visit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `grant_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `direction` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `laboratory` tinyint(1) DEFAULT NULL,
  `complaint` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `failure` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `report_title` varchar(200) DEFAULT NULL,
  `report_description` text DEFAULT NULL,
  `report_conclusion` text DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp(),
  `accept_date` datetime DEFAULT NULL,
  `priced_date` datetime DEFAULT NULL,
  `discharge_date` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `visit`
--

INSERT INTO `visit` (`id`, `user_id`, `grant_id`, `parent_id`, `route_id`, `service_id`, `direction`, `status`, `laboratory`, `complaint`, `failure`, `report_title`, `report_description`, `report_conclusion`, `add_date`, `accept_date`, `priced_date`, `discharge_date`, `completed`) VALUES
(1, 12, 6, 6, 2, 5, NULL, NULL, NULL, '1', NULL, 'eqweqwe', 'qwqweqweqwe da dasdas dadqwq dqweeee dadad', 'wqeasadsa sadasdas dasd asasdasdas', '2020-11-24 00:06:27', '2020-11-24 02:40:47', '2020-11-24 02:09:05', NULL, '2020-11-24 14:44:58'),
(9, 13, 7, 7, 2, 5, NULL, 1, NULL, 'e', NULL, NULL, NULL, NULL, '2020-11-24 01:16:27', NULL, '2020-11-24 02:08:51', NULL, NULL),
(10, 13, 7, 7, 2, 6, NULL, 1, NULL, 'e', NULL, NULL, NULL, NULL, '2020-11-24 01:16:27', NULL, '2020-11-24 02:08:51', NULL, NULL),
(11, 14, 6, 6, 2, 9, NULL, NULL, NULL, 'was', NULL, 'Тестовы Осмотр', 'зйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы выв зйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы выв зйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы вывзйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы выв1', 'зйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы выв зйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы выв', '2020-11-24 02:10:20', '2020-11-24 03:00:58', '2020-11-24 02:10:31', NULL, '2020-11-24 17:37:51'),
(12, 15, 8, 8, 2, 2, NULL, NULL, NULL, 'd', NULL, NULL, NULL, NULL, '2020-11-24 02:14:06', NULL, '2020-11-24 02:57:36', NULL, '2020-11-24 14:27:50'),
(13, 17, 6, 6, 2, 1, 1, NULL, NULL, 'ge', NULL, '31221321', '3221 weqqw weqwqqwe', 'weqqqwwqex asdw', '2020-11-24 02:33:12', '2020-11-24 02:40:55', NULL, NULL, '2020-11-24 15:12:17'),
(14, 16, 6, 6, 2, 5, NULL, NULL, NULL, 'qwewq', NULL, 'wewqewq', 'ewqewqe', 'qweqweqwe', '2020-11-24 02:57:09', '2020-11-24 03:01:21', '2020-11-24 02:57:42', NULL, '2020-11-24 15:16:07'),
(15, 18, 6, 6, 2, 1, 1, 2, NULL, 'qwewqe', NULL, NULL, NULL, NULL, '2020-11-24 02:57:22', '2020-11-24 03:01:18', NULL, NULL, NULL),
(16, 12, 6, 5, 6, 4, NULL, NULL, NULL, '1', NULL, 'MRT', 'wwewq qdwqwdqw xasd asdasd asd as', 'dqwdasd sdsad asd asdas dasdas', '2020-11-24 13:54:39', '2020-11-24 14:11:56', '2020-11-24 14:10:00', NULL, '2020-11-24 14:53:44'),
(17, 12, 6, 5, 6, 7, NULL, NULL, NULL, '1', NULL, 'Ренген', 'ssadsad asdsadas', 'dasdsad sasadadasda', '2020-11-24 14:18:23', '2020-11-24 14:20:12', '2020-11-24 14:18:38', NULL, '2020-11-24 14:53:44'),
(18, 12, 6, 7, 6, 6, NULL, NULL, NULL, '1', NULL, 'das', 'wqeqweqwe', 'qweqweqeq', '2020-11-24 14:33:18', '2020-11-24 14:36:30', '2020-11-24 14:36:20', NULL, '2020-11-24 14:43:58'),
(19, 12, 5, 5, 2, 8, NULL, NULL, NULL, 'qwe', NULL, 'УЗИ', 'фвфывфы', 'в сййцвйц', '2020-11-24 14:45:36', '2020-11-24 14:45:55', '2020-11-24 14:45:47', NULL, '2020-11-24 14:53:44'),
(20, 12, 6, 6, 2, 9, NULL, 2, NULL, 'ewq', NULL, NULL, NULL, NULL, '2020-11-24 14:54:17', '2020-11-24 14:54:40', '2020-11-24 14:54:29', NULL, NULL),
(21, 17, 6, 5, 6, 4, 1, NULL, NULL, 'ge', NULL, 'МРТ', 'qweqweqweqw', 'eqeqw', '2020-11-24 15:03:17', '2020-11-24 15:06:37', NULL, NULL, '2020-11-24 15:09:32'),
(22, 17, 6, 5, 6, 7, 1, NULL, NULL, 'ge', NULL, 'Ренген', 'цуйуйц', 'уцйувфывйц', '2020-11-24 15:06:28', '2020-11-24 15:06:40', NULL, NULL, '2020-11-24 15:09:32'),
(23, 17, 6, 5, 6, 8, 1, NULL, NULL, 'ge', NULL, 'Узи', 'цуййцуцйвв', 'фывйцувйуйц', '2020-11-24 15:07:13', '2020-11-24 15:08:29', NULL, NULL, '2020-11-24 15:09:32'),
(24, 14, 6, 4, 6, 11, NULL, NULL, 1, 'was', NULL, NULL, NULL, NULL, '2020-11-24 15:21:24', '2020-11-24 16:45:49', '2020-11-24 15:32:47', NULL, '2020-11-24 16:49:45'),
(25, 14, 6, 8, 6, 2, NULL, NULL, NULL, 'was', NULL, '213321321', '3asd', 'wqeqeqweqweqwd', '2020-11-24 15:31:35', '2020-11-24 17:07:53', '2020-11-24 15:32:47', NULL, '2020-11-24 17:08:38'),
(26, 14, 6, 4, 6, 10, NULL, NULL, 1, 'was', NULL, NULL, NULL, NULL, '2020-11-24 16:53:08', '2020-11-24 16:53:43', '2020-11-24 16:53:29', NULL, '2020-11-24 16:57:58'),
(27, 14, 6, 6, 2, 1, 1, NULL, NULL, 'qweqweq', NULL, '2131221213', '1221йцйуйцуцй йуцйцйцу', 'йцуйцувс  сйвцуук3йц43', '2020-11-24 17:11:53', '2020-11-24 17:12:09', NULL, NULL, '2020-11-24 17:37:51'),
(28, 14, 6, 5, 6, 4, 1, NULL, NULL, 'qweqweq', NULL, 'МРТ Головнного мозга', 'eqweqwqwd asdqwdqwdq ddadas', 'eeqweqw', '2020-11-24 17:15:52', '2020-11-24 17:16:11', NULL, NULL, '2020-11-24 17:17:25'),
(29, 14, 6, 5, 6, 7, 1, NULL, NULL, 'qweqweq', NULL, 'Ренген', 'dawd asdasd asd', 'dasdasdas', '2020-11-24 17:16:00', '2020-11-24 17:16:13', NULL, NULL, '2020-11-24 17:17:25');

-- --------------------------------------------------------

--
-- Структура таблицы `visit_price`
--

CREATE TABLE `visit_price` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `pricer_id` int(11) DEFAULT NULL,
  `price_cash` decimal(65,1) DEFAULT NULL,
  `price_card` decimal(65,1) DEFAULT NULL,
  `price_transfer` decimal(65,1) DEFAULT NULL,
  `sale` tinyint(4) DEFAULT NULL,
  `price_payment` decimal(65,1) DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `visit_price`
--

INSERT INTO `visit_price` (`id`, `visit_id`, `pricer_id`, `price_cash`, `price_card`, `price_transfer`, `sale`, `price_payment`, `add_date`) VALUES
(5, 9, 3, '100000.0', NULL, NULL, NULL, NULL, '2020-11-23 21:08:51'),
(6, 10, 3, '200.0', NULL, NULL, NULL, NULL, '2020-11-23 21:08:51'),
(7, 1, 3, '100000.0', NULL, NULL, NULL, NULL, '2020-11-23 21:09:05'),
(8, 11, 3, '40000.0', NULL, NULL, NULL, NULL, '2020-11-23 21:10:31'),
(9, 12, 3, '23434.0', NULL, NULL, NULL, NULL, '2020-11-23 21:57:36'),
(10, 14, 3, '100000.0', NULL, NULL, NULL, NULL, '2020-11-23 21:57:42'),
(11, 16, 3, '1000.0', NULL, NULL, NULL, NULL, '2020-11-24 09:10:00'),
(12, 17, 3, '2000.0', NULL, NULL, NULL, NULL, '2020-11-24 09:18:38'),
(13, 18, 3, '200.0', NULL, NULL, NULL, NULL, '2020-11-24 09:36:20'),
(14, 19, 3, '3000.0', NULL, NULL, NULL, NULL, '2020-11-24 09:45:47'),
(15, 20, 3, '40000.0', NULL, NULL, NULL, NULL, '2020-11-24 09:54:29'),
(16, 24, 3, '10000.0', NULL, NULL, NULL, NULL, '2020-11-24 10:32:47'),
(17, 25, 3, '23434.0', NULL, NULL, NULL, NULL, '2020-11-24 10:32:47'),
(18, 26, 3, '20000.0', NULL, NULL, NULL, NULL, '2020-11-24 11:53:29');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bed_type`
--
ALTER TABLE `bed_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bypass`
--
ALTER TABLE `bypass`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `laboratory_analyze`
--
ALTER TABLE `laboratory_analyze`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `laboratory_analyze_type`
--
ALTER TABLE `laboratory_analyze_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `storage_type`
--
ALTER TABLE `storage_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `user_stats`
--
ALTER TABLE `user_stats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `visit_price`
--
ALTER TABLE `visit_price`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `beds`
--
ALTER TABLE `beds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `bed_type`
--
ALTER TABLE `bed_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `bypass`
--
ALTER TABLE `bypass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze`
--
ALTER TABLE `laboratory_analyze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze_type`
--
ALTER TABLE `laboratory_analyze_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `storage_type`
--
ALTER TABLE `storage_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `user_stats`
--
ALTER TABLE `user_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `visit_price`
--
ALTER TABLE `visit_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
