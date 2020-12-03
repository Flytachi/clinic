-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 03 2020 г., 17:44
-- Версия сервера: 10.5.8-MariaDB
-- Версия PHP: 7.4.13

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
  `ward_id` int(11) DEFAULT NULL,
  `bed` int(11) NOT NULL,
  `types` tinyint(1) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `beds`
--

INSERT INTO `beds` (`id`, `ward_id`, `bed`, `types`, `user_id`, `add_date`) VALUES
(11, 1, 1, 1, 18, '2020-11-28 02:25:43'),
(13, 1, 2, 1, 13, '2020-11-28 02:27:22'),
(14, 1, 3, 1, NULL, '2020-11-28 02:27:30'),
(15, 1, 4, 1, NULL, '2020-11-28 02:27:43'),
(17, 4, 1, 2, NULL, '2020-11-28 02:29:20'),
(18, 4, 2, 2, NULL, '2020-11-28 02:29:30'),
(19, 5, 1, 2, 14, '2020-11-28 02:29:39');

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
(1, 'Обычная', '150000'),
(2, 'VIP', '500000');

-- --------------------------------------------------------

--
-- Структура таблицы `bypass`
--

CREATE TABLE `bypass` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `method` tinyint(4) DEFAULT NULL,
  `description` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bypass`
--

INSERT INTO `bypass` (`id`, `user_id`, `parent_id`, `method`, `description`, `update_date`, `add_date`) VALUES
(1, 14, 6, 1, '2 раза в день 1/2 таб', NULL, '2020-12-03 21:39:48');

-- --------------------------------------------------------

--
-- Структура таблицы `bypass_preparat`
--

CREATE TABLE `bypass_preparat` (
  `id` int(11) NOT NULL,
  `bypass_id` int(11) DEFAULT NULL,
  `preparat_id` int(11) DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bypass_preparat`
--

INSERT INTO `bypass_preparat` (`id`, `bypass_id`, `preparat_id`, `add_date`) VALUES
(1, 1, 1, '2020-12-03 16:39:48');

-- --------------------------------------------------------

--
-- Структура таблицы `bypass_time`
--

CREATE TABLE `bypass_time` (
  `id` int(11) NOT NULL,
  `bypass_id` int(11) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bypass_time`
--

INSERT INTO `bypass_time` (`id`, `bypass_id`, `time`, `add_date`) VALUES
(1, 1, '01:00:00', '2020-12-03 16:39:48'),
(2, 1, '07:00:00', '2020-12-03 16:39:48');

-- --------------------------------------------------------

--
-- Структура таблицы `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `id_push` varchar(255) DEFAULT NULL,
  `id_pull` varchar(255) DEFAULT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `activity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `division`
--

CREATE TABLE `division` (
  `id` int(11) NOT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `assist` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `division`
--

INSERT INTO `division` (`id`, `level`, `title`, `name`, `assist`) VALUES
(1, 5, 'Травматалогия', 'Травматолог', NULL),
(2, 5, 'Хирургия', 'Хирург', NULL),
(3, 5, 'Стоматология', 'Стоматолог', NULL),
(7, 6, 'Лаборатория', 'Лаборант', NULL),
(8, 5, 'Невропатолог', 'Неропатолог', NULL),
(9, 5, 'Нейрохирург', 'Нейрохирург', NULL),
(10, 10, 'Радиология', 'Радиолог', 2),
(11, 10, 'УЗИ', 'УЗИ', NULL),
(12, 10, 'МРТ', 'МРТ', 1),
(13, 10, 'Ренгенография', 'Ренгенолог', 1),
(14, 10, 'Маммография', 'Маммограф', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `investment`
--

CREATE TABLE `investment` (
  `id` int(11) NOT NULL,
  `pricer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `price` decimal(65,1) DEFAULT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `investment`
--

INSERT INTO `investment` (`id`, `pricer_id`, `user_id`, `price`, `add_date`) VALUES
(1, 3, 14, '25000.0', '2020-12-03 16:15:20'),
(2, 3, 13, '6000.0', '2020-12-03 16:16:29');

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
  `deviation` tinyint(1) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `laboratory_analyze`
--

INSERT INTO `laboratory_analyze` (`id`, `user_id`, `visit_id`, `analyze_id`, `result`, `deviation`, `description`) VALUES
(1, 13, 6, 1, '10', NULL, 'wqe'),
(2, 13, 6, 2, '7', NULL, 'qwe'),
(3, 14, 7, 1, '10', NULL, 'отличео'),
(4, 14, 7, 2, '7', NULL, 'отличео'),
(5, 22, 8, 1, '10', NULL, 'w'),
(6, 22, 8, 2, '4', 1, 'w'),
(7, 15, 9, 1, '21', 1, ''),
(8, 15, 9, 2, '2', 1, ''),
(9, 17, 10, 1, '9', NULL, ''),
(10, 17, 10, 2, '8', NULL, ''),
(11, 12, 12, 1, '', NULL, ''),
(12, 12, 12, 2, '', NULL, ''),
(13, 15, 13, 1, '21', NULL, '11'),
(14, 15, 13, 2, '21', NULL, '11'),
(15, 35, 25, 5, '123213', NULL, ''),
(16, 35, 25, 6, '32132', NULL, ''),
(17, 35, 25, 7, '232', NULL, 'we'),
(18, 35, 25, 8, '123', NULL, 'we'),
(19, 35, 25, 9, '21', NULL, 'e'),
(20, 35, 25, 10, '1', NULL, 'e'),
(21, 35, 25, 11, '1', NULL, 'ee'),
(22, 35, 25, 12, '21', 1, ''),
(23, 35, 25, 13, '21', NULL, 'e'),
(24, 35, 25, 14, '12', NULL, ''),
(25, 35, 25, 15, '12', NULL, ''),
(26, 35, 25, 16, '12', NULL, ''),
(27, 35, 25, 17, '12', 1, ''),
(28, 35, 25, 18, '21', 1, ''),
(29, 35, 25, 19, '12', 1, ''),
(30, 35, 25, 20, '12', 1, '');

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
(5, 11, 'WBC', 'lab-01', '4-10', 1),
(6, 11, 'RBC', 'lab-02', '3.8-5.2', 1),
(7, 11, 'HGB', 'lab-03', '120-160g/L', 1),
(8, 11, 'HCT', 'lab-04', '36-48 %', 1),
(9, 11, 'MCV', 'lab-05', '80.0-94.0 fl', 1),
(10, 11, 'MCH', 'lab-06', '27.0-31.0', 1),
(11, 11, 'MCHC', 'lab-07', '330-370', 1),
(12, 11, 'RDW-CV', 'lab-08', '11.0-19.0', 1),
(13, 11, 'PLT', 'lab-09', '150.0-450.0', 1),
(14, 11, 'MPV', 'lab-10', '9.4-12.4 um3', 1),
(15, 11, 'Neu%', 'lab-11', '50.0-75.0 %', 1),
(16, 11, 'Lym%', 'lab-12', '20.0-44.0%', 1),
(17, 11, 'Mon%', 'lab-13', '2.0-9.0%', 1),
(18, 11, 'Eos%', 'lab-13', '0-5.0%', 1),
(19, 11, 'Bas%', 'lab-14', '0-1.0%', 1),
(20, 11, 'ESR', 'lab-15', '0-20 mm/hr', 1);

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
(4, 10, 12, 'MRT Головного мозга', '1000.0'),
(5, 5, 2, 'Грыжа диска', '100000.0'),
(6, 5, 2, 'Пункция брюшной полости', '200000.0'),
(7, 10, 13, 'Рентгенография Весь Позвоночника (Задне-передняя/Боковая проекции)', '2000.0'),
(8, 10, 11, 'УЗИ Допплерография каротид', '3000.0'),
(9, 5, 2, 'Первичная хирургическая обработка ран (больше 2 см)', '40000.0'),
(10, 6, 7, 'Антитела на Covid 19', '20000.0'),
(11, 6, 7, 'Общий анализ крови', '10000.0'),
(12, 5, 9, 'Шейный блок, секция 1 (паравертеравральная) - местный врач', '200000.0');

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
(5, NULL, 'doc_1', '4d5204a88e9f6e4e6d34292df53464549d51e86c', 'Jayson', 'Brody', 'Faker', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 10, 1, 7, NULL, '2020-11-18 15:57:39'),
(6, NULL, 'doc_2', 'fe0c9097da6e3b417d97100d40c38561c295aeff', 'Фарход', 'Якубов', 'Хврвргврйцгв', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 2, 1, 7, NULL, '2020-11-18 15:58:42'),
(12, 10, NULL, NULL, 'pasient 1', 'pasient 1', 'pasient 1', '2000-12-12', 'Олмазор', 'kjhjkhjkhk', 'nmm,nj,n,n', ',kn,knm,nm,n', '9998989899', 'ajkshdjkashd', 'jhjkh', 1, 15, NULL, 1, 0, 'm,nm,nm,nm,n', '2020-11-18 16:05:52'),
(13, 10, NULL, NULL, 'pasient 2', 'pasient 2', 'pasient 2', '2000-12-12', 'Миробод', 'kjklj', 'kn,knm,n', ',mn,mn,m', '98989898', 'iljiljklj', 'kjkljkl', NULL, 15, NULL, 1, 0, 'm,nm,n', '2020-11-18 16:06:24'),
(14, 2, NULL, NULL, 'Жасур', 'Рахматов', 'Илхомович', '2003-05-08', 'Ромитан', 'AC6453482', 'Хокимиат', 'Глава отдела', '+998934568052', 'Алпомыш', 'Алпомыш', 1, 15, NULL, 1, 0, NULL, '2020-11-18 16:06:53'),
(15, 10, NULL, NULL, 'pasient 3', 'pasient 3', 'pasient 3', '2000-12-12', 'Олмазор', 'jjjkhjk', 'm,nnm,nmbnm', 'nm,m,nm,n', '98098098098', ',jhknjj', 'jjnjjk', NULL, 15, NULL, NULL, 0, 'm,nm,nm,nm,n', '2020-11-18 16:07:03'),
(17, 10, NULL, NULL, 'pasient 4', 'pasient 4', 'pasient 4', '1212-02-11', 'Олмазор', 'kljkljklj', 'kljkljklj', 'ljkljklj', '8909809809', 'iljljklj', 'lkjkljklj', NULL, 15, NULL, 1, 0, 'lkjlkjkljkl', '2020-11-18 16:07:48'),
(18, 10, NULL, NULL, 'pasient 5', 'pasient 5', 'pasient 5', '2122-03-12', 'Олмазор', 'jkhjkhjk', 'mnm,nm,nm,', 'm,nm,nm,n', '89098098098', 'kjhkljk', 'jkhjkhkjh', NULL, 15, NULL, 1, 0, ',mn,mn,mn', '2020-11-18 16:08:21'),
(21, 2, NULL, NULL, 'Pasient 6', 'Pasient 6', 'Pasient 6', '2019-11-06', 'Чилонзор', 'цуй321112312312', 'Pasient 6', 'Pasient 6', '2132132112312231', 'Pasient 6', 'Pasient 6', NULL, 15, NULL, NULL, 0, 'Pasient 6', '2020-11-18 16:13:53'),
(22, 9, NULL, NULL, 'Алексей', 'Шевцов', 'Владимирович', '1999-11-24', 'Юнусобод', 'WE324234234', 'Ютуб', 'Блогер', '+998990989078', 'Украина Одесса', 'Украина Одесса', 1, 15, NULL, NULL, 0, 'Глупые люди', '2020-11-18 16:15:37'),
(29, NULL, 'doc_h', '8171857a4e3fbc786dd873feb372a6189166f891', 'doc_h', 'doc_h', 'doc_h', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, 1, 10, NULL, '2020-11-27 17:12:42'),
(30, NULL, 'nurce_1', 'c000e8b0a3f6e91f586867365618581675fa20d7', 'nurce', 'nurce', 'nurce', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, 1, 1, NULL, '2020-11-28 08:23:45'),
(31, NULL, 'uzi', 'f2b545bd0099b1c89c3ef7acd0e4e1e50874bf74', 'uzi', 'uzi', 'uzi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 11, 1, 1, NULL, '2020-12-01 13:48:07'),
(32, NULL, 'mrt', 'f2b83e490eacf0abfbda89413282a3744dc9a2b8', 'mrt', 'mrt', 'mrt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 12, 1, 1, NULL, '2020-12-01 16:27:21'),
(33, NULL, 'rengen', 'd6caae7396ed1519d78e3af94ff092f3f9213796', 'rengen', 'rengen', 'rengen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 13, 1, 1, NULL, '2020-12-02 11:12:18'),
(34, NULL, 'doc_3', '878897f3f6d05d5081aba73f2b5af61177f52066', 'doc_3', 'doc_3', 'doc_3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 10, 1, 12, NULL, '2020-12-02 11:27:21'),
(35, 2, NULL, NULL, 'Tester 1', 'Tester 1', 'Tester 1', '2020-12-08', 'Ромитан', '1232132112', 'Tester 1', 'Tester 1', '123123123312', 'Tester 1', 'Tester 1', 1, 15, NULL, 1, 0, NULL, '2020-12-02 14:42:47'),
(36, 2, NULL, NULL, '12321321', '12321321', '12321321', '2020-12-03', 'Миробод', '12321321', '12321321', 'w', '12321321', '12321321', '12321321', NULL, 15, NULL, NULL, 0, NULL, '2020-12-02 18:32:04'),
(37, 2, NULL, NULL, 'eser 1', 'eser 1', 'eser 1', '2020-12-09', 'Ромитан', 'eser 1', 'eser 1', 'eser 1', '12321213', 'eser 1', 'eser 1', 1, 15, NULL, 1, 0, NULL, '2020-12-02 18:34:26'),
(38, 2, NULL, NULL, 'eser 1', 'eser 1', 'eser 1', '2020-12-09', 'Ромитан', 'eser 1', 'eser 1', 'eser 1', '12321213', 'eser 1', 'eser 1', 1, 15, NULL, NULL, 0, NULL, '2020-12-02 18:34:31'),
(39, 2, NULL, NULL, 'lu', 'lu', 'lu', '2020-12-03', 'Ромитан', '2321232', 'e1231232eqw', 'e13123212', '3123123213', 'lu', 'lu', NULL, 15, NULL, NULL, 0, NULL, '2020-12-02 18:35:44');

-- --------------------------------------------------------

--
-- Структура таблицы `user_stats`
--

CREATE TABLE `user_stats` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `pressure` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pulse` int(11) DEFAULT NULL,
  `temperature` decimal(3,1) DEFAULT NULL,
  `saturation` tinyint(4) DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_stats`
--

INSERT INTO `user_stats` (`id`, `parent_id`, `visit_id`, `stat`, `pressure`, `pulse`, `temperature`, `saturation`, `add_date`) VALUES
(1, 30, 2, 2, '120/4 мм.рт.ст.', 88, '37.2', 34, '2020-12-03 16:30:47');

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
  `assist_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `bed_id` int(11) DEFAULT NULL,
  `direction` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `laboratory` tinyint(1) DEFAULT NULL,
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

INSERT INTO `visit` (`id`, `user_id`, `grant_id`, `parent_id`, `route_id`, `assist_id`, `division_id`, `service_id`, `bed_id`, `direction`, `status`, `laboratory`, `failure`, `report_title`, `report_description`, `report_conclusion`, `add_date`, `accept_date`, `priced_date`, `discharge_date`, `completed`) VALUES
(1, 12, 6, 6, 2, NULL, 2, 9, NULL, NULL, NULL, NULL, NULL, 'Первичная хирургическая обработка ран (больше 2 см)', 'Ликвидация свища брюшной полости\r\nЛапароскопическая холецистэктомия с наружным дренированием холедоха (НДХ)\r\nЛапаротомическая холецистэктомия с наружным дренированием холедоха (НДХ)\r\nДиагностическая лапаротомия\r\nЛапаротомия. Вскрытие гнойника. Некросеквестроэктомия. Санация и дренирование полости гнойника. Санация и дренирование брюшной полости.\r\nРезекция дивертикула Меккеля\r\nРезекция тонкой кишки с анастомозом конец в конец\r\nРелапаротомия\r\nЛХЭК при Хроническом калькулёзном холецистите\r\nЛХЭК при остром флегмонозном калькулёзном холецистите\r\nЛапаротомия. Холецистэктомия при остром флегмонозном холецистите\r\nЛХЭК при остром гангренозном калькулёзном холецистите с инфильтратом\r\nЛапаротомия. Холецистэктомия при остром гангренозном холецистите с инфильтратом\r\nЭРХПГ + ПСТ\r\nЛапароскопическая холецистэктомия при', 'Эхинококкоз печени 1 — киста до 10см\r\nЭхинококкоз печени 1 — киста больше 10см\r\nЭхинококкоз печени 2 — кисты\r\nЭхинококкоз печени 3 — кисты\r\nГастроэнтероанастомоз с отключением ДПК\r\nГастрэктомия\r\nЛапароскопическая фундопликация+холецистэктомия\r\nЛапаротомия, гепатикоеюноанастамоз\r\nЛапаротомия. Ликвидация гнойного свища печени\r\nПередняя резекция прямой кишки с десцендоректоанастамозом конец в конец\r\nРезекция тонкой кишки с анастомозом конец в конец\r\nАтипичная резекция печени печени 2,3,4 сегментов', '2020-11-30 22:04:06', '2020-11-30 22:08:47', '2020-11-30 22:08:25', NULL, '2020-11-30 22:19:46'),
(2, 14, 6, 6, 2, NULL, 2, 1, 19, 1, 2, NULL, NULL, NULL, NULL, NULL, '2020-11-30 22:05:56', '2020-11-30 22:08:49', NULL, NULL, NULL),
(3, 18, 6, 6, 2, NULL, 2, 1, 11, 1, 2, NULL, NULL, NULL, NULL, NULL, '2020-11-30 22:06:25', '2020-11-30 22:08:51', NULL, NULL, NULL),
(4, 14, 6, 5, 6, NULL, 6, 4, NULL, 1, NULL, NULL, NULL, 'МРТ головного мозга', 'МРТ головного мозга — это неинвазивное исследование, которое подразумевает использование мощных магнитных полей, высокочастотных импульсов, компьютерной системы и программного обеспечения, позволяющих получить детальное изображение мозга. Рентгеновское излучение при МРТ не используется. Именно поэтому на сегодняшний день МРТ — одно из наиболее безопасных и притом очень точных исследований. Качество визуализации при МРТ намного лучше, чем при рентгенологическом или ультразвуковом исследовании, компьютерной томографии. Магнитно-резонансная томография дает возможность обнаружить опухоли, аневризму и другие патологии сосудов, а также некоторые проблемы нервной системы. Словом, возможности метода очень широки. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', 'Несмотря на то, что для разных методов диагностики (рентгеновской, радионуклидной, магнитно-резонансной, ультразвуковой) используются различные физические принципы и источники излучения, их объединяет применение правил математического моделирования при создании изображений. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', '2020-11-30 22:10:59', '2020-11-30 22:11:11', NULL, NULL, '2020-12-02 17:20:00'),
(5, 12, 5, 5, 2, NULL, 6, 4, NULL, NULL, NULL, NULL, NULL, 'MRT Головного мозга', 'Маммография vМам мо графияМ аммограф  ияМ аммогр афияМаммо графия Мамм ографи яМаммогр  афияМам  мография', 'Маммография vМам мо графияМ аммограф  ияМ аммогр афияМаммо графия Мамм ографи яМаммогр  афияМам  мография', '2020-11-30 22:23:11', '2020-11-30 22:24:52', '2020-11-30 22:24:30', NULL, '2020-12-02 19:20:32'),
(6, 13, 4, 4, 2, NULL, 7, 10, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2020-11-30 22:24:03', '2020-11-30 22:42:54', '2020-11-30 22:41:45', NULL, '2020-12-01 00:34:25'),
(7, 14, 6, 4, 6, NULL, 7, 10, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2020-11-30 22:44:33', '2020-11-30 22:44:56', NULL, NULL, '2020-12-01 00:05:21'),
(8, 22, 4, 4, 2, NULL, 7, 10, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2020-12-01 00:21:55', '2020-12-01 00:23:51', '2020-12-01 00:22:22', NULL, '2020-12-01 00:34:16'),
(9, 15, 4, 4, 2, NULL, 7, 10, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2020-12-01 00:28:19', '2020-12-01 00:30:31', '2020-12-01 00:30:18', NULL, '2020-12-01 00:34:54'),
(10, 17, 4, 4, 2, NULL, 7, 10, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2020-12-01 00:29:58', '2020-12-01 00:30:33', '2020-12-01 00:30:22', NULL, '2020-12-01 00:35:02'),
(11, 13, 6, 6, 2, NULL, 2, 1, 13, 1, 2, NULL, NULL, NULL, NULL, NULL, '2020-12-01 00:36:27', '2020-12-01 18:41:53', NULL, NULL, NULL),
(12, 12, 5, 4, 5, NULL, 7, 10, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, '2020-12-01 17:15:37', '2020-12-01 17:16:09', '2020-12-01 17:16:00', NULL, NULL),
(13, 15, 4, 4, 2, NULL, 7, 10, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2020-12-01 17:19:35', '2020-12-01 17:19:54', '2020-12-01 17:19:46', NULL, '2020-12-02 17:21:27'),
(14, 14, 6, 31, 6, NULL, 11, 8, NULL, 1, NULL, NULL, NULL, 'TEST', 'TEST', 'TEST', '2020-12-01 19:06:09', '2020-12-01 19:20:34', NULL, NULL, '2020-12-01 19:55:29'),
(15, 13, 6, 31, 6, NULL, 11, 8, NULL, 1, NULL, NULL, NULL, '213', '123', '213', '2020-12-01 21:28:40', '2020-12-02 15:25:59', NULL, NULL, '2020-12-02 19:23:03'),
(16, 13, 6, 5, 6, 32, 12, 4, NULL, 1, NULL, NULL, NULL, 'qwe', 'qwe', 'qwe', '2020-12-01 21:28:49', '2020-12-02 15:36:55', NULL, NULL, '2020-12-02 17:48:38'),
(17, 13, 6, 34, 6, 33, 13, 7, NULL, 1, NULL, NULL, NULL, 'Рентгенография Весь Позвоночника (Задне-передняя/Боковая проекции)', 'Рентген позвоночника – это диагностический метод, позволяющий оценить структуру, состояние позвоночника и в некоторой степени его функцию.\r\nПозвоночник состоит из отдельных позвонков (24), крестца и копчика. Выделяют шейный, грудной, пояснично-крестцовый отделы позвоночного столба, которые имеют свои особенности. Метод рентгенологической диагностики позволяет оценить как весь позвоночный столб, так и определенные отделы и отдельные позвонки.', 'Рентгенография позвоночника позволяет оценить особенности структуры костной ткани позвонков, толщину и плотность ее коркового слоя, выявить признаки остеопороза, опухолевых изменений, поражения суставных поверхностей, деструктивно-дистрофические и метаболические изменения.', '2020-12-02 16:12:53', '2020-12-02 16:13:22', NULL, NULL, '2020-12-02 16:29:19'),
(18, 22, 5, 5, 2, 32, 12, 4, NULL, NULL, NULL, NULL, NULL, 'MRT Головного мозга', 'MRT Головного мозга', 'MRT Головного мозга', '2020-12-02 16:44:41', '2020-12-02 16:45:32', '2020-12-02 16:44:51', NULL, '2020-12-02 17:34:57'),
(19, 14, 6, 5, 6, 32, 12, 4, NULL, 1, NULL, NULL, NULL, 'tetst', 'tetst', 'tetst', '2020-12-02 17:17:06', '2020-12-02 17:17:27', NULL, NULL, '2020-12-02 17:20:00'),
(20, 22, 5, 5, 2, 32, 12, 4, NULL, NULL, NULL, NULL, NULL, 'MRT Головного мозга', 'MRT Головного мозга asdasdad', '11', '2020-12-02 17:29:14', '2020-12-02 17:30:05', '2020-12-02 17:29:24', NULL, '2020-12-02 17:34:57'),
(21, 21, 32, 5, 2, 32, 12, 4, NULL, NULL, NULL, NULL, NULL, '1wqeqweq', '1wqeqwe', '1ewqeqw', '2020-12-02 17:45:25', '2020-12-02 17:45:47', '2020-12-02 17:45:36', NULL, '2020-12-02 17:46:09'),
(22, 12, 5, 5, 2, 32, 12, 4, NULL, NULL, NULL, NULL, NULL, '21', '12', '21', '2020-12-02 18:39:48', '2020-12-02 19:18:06', '2020-12-02 19:03:47', NULL, '2020-12-02 19:20:32'),
(23, 15, 31, 31, 2, NULL, 11, 8, NULL, NULL, NULL, NULL, NULL, '12', '2121', '212121  1212323', '2020-12-02 19:01:49', '2020-12-02 19:04:19', '2020-12-02 19:03:50', NULL, '2020-12-02 19:22:52'),
(24, 17, 32, 32, 2, 32, 12, 4, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2020-12-02 19:17:46', '2020-12-03 17:17:40', '2020-12-02 19:19:58', NULL, NULL),
(25, 35, 4, 4, 2, NULL, 7, 11, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2020-12-02 19:43:29', '2020-12-02 19:47:06', '2020-12-02 19:46:24', NULL, '2020-12-02 19:47:54'),
(26, 12, 31, 31, 2, NULL, 11, 8, NULL, NULL, NULL, NULL, NULL, 'узи', 'вуйццуйу', 'йцуйу', '2020-12-02 20:26:28', '2020-12-02 20:27:50', '2020-12-02 20:26:50', NULL, '2020-12-02 20:28:41'),
(31, 35, 6, 6, 2, NULL, 2, 5, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2020-12-03 15:46:17', '2020-12-03 17:17:02', '2020-12-03 16:08:57', NULL, NULL),
(32, 37, 31, 31, 2, NULL, 11, 8, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2020-12-03 17:21:52', '2020-12-03 17:22:29', '2020-12-03 17:22:18', NULL, NULL);

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
  `add_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `visit_price`
--

INSERT INTO `visit_price` (`id`, `visit_id`, `pricer_id`, `price_cash`, `price_card`, `price_transfer`, `sale`, `add_date`) VALUES
(1, 1, 3, '40000.0', NULL, NULL, NULL, '2020-11-30 17:08:25'),
(2, 5, 3, '1000.0', NULL, NULL, NULL, '2020-11-30 17:24:30'),
(3, 6, 3, '20000.0', NULL, NULL, NULL, '2020-11-30 17:41:45'),
(4, 8, 3, '20000.0', NULL, NULL, NULL, '2020-11-30 19:22:22'),
(5, 9, 3, '20000.0', NULL, NULL, NULL, '2020-11-30 19:30:18'),
(6, 10, 3, '20000.0', NULL, NULL, NULL, '2020-11-30 19:30:22'),
(7, 12, 3, '20000.0', NULL, NULL, NULL, '2020-12-01 12:16:00'),
(8, 13, 3, '20000.0', NULL, NULL, NULL, '2020-12-01 12:19:46'),
(9, 18, 3, '1000.0', NULL, NULL, NULL, '2020-12-02 11:44:51'),
(10, 20, 3, NULL, '1000.0', NULL, NULL, '2020-12-02 12:29:24'),
(11, 21, 3, NULL, '1000.0', NULL, NULL, '2020-12-02 12:45:36'),
(12, 22, 3, '1000.0', NULL, NULL, NULL, '2020-12-02 14:03:47'),
(13, 23, 3, NULL, NULL, '3000.0', NULL, '2020-12-02 14:03:50'),
(14, 24, 3, '1000.0', NULL, NULL, NULL, '2020-12-02 14:19:58'),
(15, 25, 3, '10000.0', NULL, NULL, NULL, '2020-12-02 14:46:24'),
(16, 26, 3, '3000.0', NULL, NULL, NULL, '2020-12-02 15:26:50'),
(17, 31, 3, '100000.0', NULL, NULL, NULL, '2020-12-03 11:08:57'),
(18, 32, 3, '3000.0', NULL, NULL, NULL, '2020-12-03 12:22:18');

-- --------------------------------------------------------

--
-- Структура таблицы `wards`
--

CREATE TABLE `wards` (
  `id` int(11) NOT NULL,
  `floor` tinyint(4) DEFAULT NULL,
  `ward` smallint(6) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `wards`
--

INSERT INTO `wards` (`id`, `floor`, `ward`, `add_date`) VALUES
(1, 1, 1, '2020-11-28 02:12:45'),
(2, 1, 2, '2020-11-28 02:13:16'),
(3, 1, 3, '2020-11-28 02:13:21'),
(4, 2, 1, '2020-11-28 02:13:43'),
(5, 3, 1, '2020-11-28 02:13:49');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bed` (`ward_id`,`bed`) USING BTREE;

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
-- Индексы таблицы `bypass_preparat`
--
ALTER TABLE `bypass_preparat`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bypass_time`
--
ALTER TABLE `bypass_time`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `investment`
--
ALTER TABLE `investment`
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
-- Индексы таблицы `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `floor` (`floor`,`ward`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `beds`
--
ALTER TABLE `beds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `bed_type`
--
ALTER TABLE `bed_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `bypass`
--
ALTER TABLE `bypass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `bypass_preparat`
--
ALTER TABLE `bypass_preparat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `bypass_time`
--
ALTER TABLE `bypass_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `investment`
--
ALTER TABLE `investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze`
--
ALTER TABLE `laboratory_analyze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze_type`
--
ALTER TABLE `laboratory_analyze_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `storage_type`
--
ALTER TABLE `storage_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `user_stats`
--
ALTER TABLE `user_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `visit_price`
--
ALTER TABLE `visit_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `wards`
--
ALTER TABLE `wards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
