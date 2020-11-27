-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 27 2020 г., 16:43
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
(5, 1, 2, 1, 2, 19),
(6, 1, 2, 2, 2, NULL),
(7, 1, 3, 1, 1, NULL),
(8, 1, 3, 2, 1, NULL),
(9, 2, 1, 1, 2, NULL),
(10, 3, 1, 1, 2, NULL);

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
(1, 'Обычная', '1000'),
(2, 'VIP', '50000');

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
(1, 3, 18, '30000.0', '2020-11-25 00:34:42'),
(2, 3, 14, '40000.0', '2020-11-25 15:42:34');

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
(4, 14, 26, 2, '7', '3'),
(5, 19, 35, 3, '12', 'wqqweq'),
(6, 19, 35, 4, '34', 'weqwew'),
(7, 12, 44, 3, NULL, NULL),
(8, 12, 44, 4, NULL, NULL),
(9, 14, 45, 3, NULL, NULL),
(10, 14, 45, 4, NULL, NULL),
(11, 18, 46, 1, '10', 'Хорошо'),
(12, 18, 46, 2, '6', 'Нормально'),
(13, 18, 47, 3, '12', 'Хорошо'),
(14, 18, 47, 4, '22', 'Плохо'),
(15, 14, 51, 1, '10', '12321'),
(16, 14, 51, 2, '7', '2132131'),
(25, 18, 56, 1, '10', 'Отлично'),
(26, 18, 56, 2, '7', 'Отлично'),
(27, 18, 57, 3, '10', 'Хорошо'),
(28, 18, 57, 4, '34', 'Отлично');

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
(14, 2, NULL, NULL, 'Жасур', 'Рахматов', 'Илхомович', '2003-05-08', 'Ромитан', 'AC6453482', 'Хокимиат', 'Глава отдела', '+998934568052', 'Алпомыш', 'Алпомыш', 1, 15, NULL, 1, 0, NULL, '2020-11-18 16:06:53'),
(15, 10, NULL, NULL, 'pasient 3', 'pasient 3', 'pasient 3', '2000-12-12', 'Олмазор', 'jjjkhjk', 'm,nnm,nmbnm', 'nm,m,nm,n', '98098098098', ',jhknjj', 'jjnjjk', NULL, 15, NULL, 1, 0, 'm,nm,nm,nm,n', '2020-11-18 16:07:03'),
(16, 9, NULL, NULL, 'Адольф', 'Гитлер', 'Нету', '1899-04-20', 'Ромитан', 'WE2312313', 'Германия, Мюнхен', 'Политик, глава 3 рейха', '998909090899', 'Австрия', 'могила №3', 1, 15, NULL, NULL, 0, 'евреи', '2020-11-18 16:07:03'),
(17, 10, NULL, NULL, 'pasient 4', 'pasient 4', 'pasient 4', '1212-02-11', 'Олмазор', 'kljkljklj', 'kljkljklj', 'ljkljklj', '8909809809', 'iljljklj', 'lkjkljklj', NULL, 15, NULL, 1, 0, 'lkjlkjkljkl', '2020-11-18 16:07:48'),
(18, 10, NULL, NULL, 'pasient 5', 'pasient 5', 'pasient 5', '2122-03-12', 'Олмазор', 'jkhjkhjk', 'mnm,nm,nm,', 'm,nm,nm,n', '89098098098', 'kjhkljk', 'jkhjkhkjh', NULL, 15, NULL, 1, 0, ',mn,mn,mn', '2020-11-18 16:08:21'),
(19, 9, NULL, NULL, 'Иосиф', 'Сталин', 'Виссарионович', '1924-01-21', 'Ромитан', 'WE3424234234', 'Россия', 'Император Росси', '+998909990099', 'Россия', 'Москва кремоль', 1, 15, NULL, 1, 0, 'Гитлер', '2020-11-18 16:10:05'),
(20, 9, NULL, NULL, 'Владимир', 'Ленин', 'Ильич', '1870-04-22', 'Ромитан', 'QW452345234532', 'CCCP', 'Вождь', '+998909445465', 'Россия', 'Мавзолей', 1, 15, NULL, NULL, 0, 'Капитализм', '2020-11-18 16:12:51'),
(21, 2, NULL, NULL, 'Pasient 6', 'Pasient 6', 'Pasient 6', '2019-11-06', 'Чилонзор', 'цуй321112312312', 'Pasient 6', 'Pasient 6', '2132132112312231', 'Pasient 6', 'Pasient 6', NULL, 15, NULL, NULL, 0, 'Pasient 6', '2020-11-18 16:13:53'),
(22, 9, NULL, NULL, 'Алексей', 'Шевцов', 'Владимирович', '1999-11-24', 'Юнусобод', 'WE324234234', 'Ютуб', 'Блогер', '+998990989078', 'Украина Одесса', 'Украина Одесса', 1, 15, NULL, NULL, 0, 'Глупые люди', '2020-11-18 16:15:37'),
(23, 9, NULL, NULL, 'Кира', 'Хошигаке', 'НЕТ', '1995-01-20', 'Юнусобод', 'CV 333222', 'Япония Токио', 'Коммисар', '+99899900098', 'Япония Токио', 'Япония Токио', 1, 15, NULL, 1, 0, 'L', '2020-11-18 16:17:36'),
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
(1, 26, 27, 2, '21/2', 2121, '37.3', 100, '2020-11-24 12:32:28'),
(2, 26, 31, 1, '123', 12, '40.9', 45, '2020-11-25 11:38:16'),
(3, 26, 31, NULL, '312', 121, '36.3', 25, '2020-11-25 11:39:31'),
(4, 26, 31, 2, '32423/100', 200, '45.0', 25, '2020-11-25 12:23:21'),
(5, 26, 31, 1, '110/80', 70, '36.8', 95, '2020-11-25 18:23:18');

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
  `bed_id` int(11) DEFAULT NULL,
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

INSERT INTO `visit` (`id`, `user_id`, `grant_id`, `parent_id`, `route_id`, `service_id`, `bed_id`, `direction`, `status`, `laboratory`, `complaint`, `failure`, `report_title`, `report_description`, `report_conclusion`, `add_date`, `accept_date`, `priced_date`, `discharge_date`, `completed`) VALUES
(1, 12, 6, 6, 2, 5, NULL, NULL, NULL, NULL, '1', NULL, 'eqweqwe', 'qwqweqweqwe da dasdas dadqwq dqweeee dadad', 'wqeasadsa sadasdas dasd asasdasdas', '2020-11-24 00:06:27', '2020-11-24 02:40:47', '2020-11-24 02:09:05', NULL, '2020-11-26 23:40:48'),
(9, 13, 7, 7, 2, 5, NULL, NULL, 2, NULL, 'e', NULL, NULL, NULL, NULL, '2020-11-24 01:16:27', '2020-11-24 21:18:22', '2020-11-24 02:08:51', NULL, NULL),
(10, 13, 7, 7, 2, 6, NULL, NULL, 2, NULL, 'e', NULL, NULL, NULL, NULL, '2020-11-24 01:16:27', '2020-11-24 21:18:20', '2020-11-24 02:08:51', NULL, NULL),
(11, 14, 6, 6, 2, 9, NULL, NULL, NULL, NULL, 'was', NULL, 'Тестовы Осмотр', 'зйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы выв зйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы выв зйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы вывзйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы выв1', 'зйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы выв зйлвцйщвлщ йвьйш тйв штавстыомсвгама  аырвыашра ывав ыав ыа выа  в ывы вы вы вывывы  ывыв ывы выв', '2020-11-24 02:10:20', '2020-11-24 03:00:58', '2020-11-24 02:10:31', NULL, '2020-11-27 14:50:47'),
(12, 15, 8, 8, 2, 2, NULL, NULL, NULL, NULL, 'd', NULL, NULL, NULL, NULL, '2020-11-24 02:14:06', NULL, '2020-11-24 02:57:36', NULL, '2020-11-24 14:27:50'),
(14, 16, 6, 6, 2, 5, NULL, NULL, NULL, NULL, 'qwewq', NULL, 'wewqewq', 'ewqewqe', 'qweqweqwe', '2020-11-24 02:57:09', '2020-11-24 03:01:21', '2020-11-24 02:57:42', NULL, '2020-11-24 15:16:07'),
(15, 18, 6, 6, 2, 1, NULL, 1, 2, NULL, 'qwewqe', NULL, NULL, NULL, NULL, '2020-11-24 02:57:22', '2020-11-24 03:01:18', NULL, NULL, NULL),
(16, 12, 6, 5, 6, 4, NULL, NULL, NULL, NULL, '1', NULL, 'MRT', 'wwewq qdwqwdqw xasd asdasd asd as', 'dqwdasd sdsad asd asdas dasdas', '2020-11-24 13:54:39', '2020-11-24 14:11:56', '2020-11-24 14:10:00', NULL, '2020-11-24 14:53:44'),
(17, 12, 6, 5, 6, 7, NULL, NULL, NULL, NULL, '1', NULL, 'Ренген', 'ssadsad asdsadas', 'dasdsad sasadadasda', '2020-11-24 14:18:23', '2020-11-24 14:20:12', '2020-11-24 14:18:38', NULL, '2020-11-24 14:53:44'),
(18, 12, 6, 7, 6, 6, NULL, NULL, NULL, NULL, '1', NULL, 'das', 'wqeqweqwe', 'qweqweqeq', '2020-11-24 14:33:18', '2020-11-24 14:36:30', '2020-11-24 14:36:20', NULL, '2020-11-25 19:30:40'),
(19, 12, 5, 5, 2, 8, NULL, NULL, NULL, NULL, 'qwe', NULL, 'УЗИ', 'фвфывфы', 'в сййцвйц', '2020-11-24 14:45:36', '2020-11-24 14:45:55', '2020-11-24 14:45:47', NULL, '2020-11-24 14:53:44'),
(20, 12, 6, 6, 2, 9, NULL, NULL, NULL, NULL, 'ewq', NULL, 'qe12', 'qe3213213', '21312qweqweq', '2020-11-24 14:54:17', '2020-11-24 14:54:40', '2020-11-24 14:54:29', NULL, '2020-11-26 23:40:48'),
(24, 14, 6, 4, 6, 11, NULL, NULL, NULL, 1, 'was', NULL, NULL, NULL, NULL, '2020-11-24 15:21:24', '2020-11-24 16:45:49', '2020-11-24 15:32:47', NULL, '2020-11-24 16:49:45'),
(25, 14, 6, 8, 6, 2, NULL, NULL, NULL, NULL, 'was', NULL, '213321321', '3asd', 'wqeqeqweqweqwd', '2020-11-24 15:31:35', '2020-11-24 17:07:53', '2020-11-24 15:32:47', NULL, '2020-11-24 17:08:38'),
(26, 14, 6, 4, 6, 10, NULL, NULL, NULL, 1, 'was', NULL, NULL, NULL, NULL, '2020-11-24 16:53:08', '2020-11-24 16:53:43', '2020-11-24 16:53:29', NULL, '2020-11-24 16:57:58'),
(27, 14, 6, 6, 2, 1, 1, 1, 1, NULL, 'qweqweq', NULL, '2131221213', '1221йцйуйцуцй йуцйцйцу', 'йцуйцувс  сйвцуук3йц43', '2020-11-24 17:11:53', '2020-11-24 17:12:09', '2020-11-27 20:39:55', NULL, '2020-11-27 14:50:47'),
(28, 14, 6, 5, 6, 4, NULL, 1, 1, NULL, 'qweqweq', NULL, 'МРТ Головнного мозга', 'eqweqwqwd asdqwdqwdq ddadas', 'eeqweqw', '2020-11-24 17:15:52', '2020-11-24 17:16:11', '2020-11-27 20:39:55', NULL, '2020-11-24 17:17:25'),
(29, 14, 6, 5, 6, 7, NULL, 1, 1, NULL, 'qweqweq', NULL, 'Ренген', 'dawd asdasd asd', 'dasdasdas', '2020-11-24 17:16:00', '2020-11-24 17:16:13', '2020-11-27 20:39:55', NULL, '2020-11-24 17:17:25'),
(31, 14, 6, 6, 2, 1, 6, 1, 1, NULL, '45995494', NULL, 'ewqweqw', 'wewqewe', 'wewqewqewqe', '2020-11-24 20:22:19', '2020-11-24 20:38:16', '2020-11-27 20:39:55', NULL, '2020-11-27 14:50:47'),
(32, 15, 6, 6, 2, 9, NULL, NULL, NULL, NULL, 'wqeqewq', NULL, 'цйуцйц ууйцу', 'фвфвв йцвйвйв йцйцйц', 'цйуйуцйв в вйвцй', '2020-11-24 20:22:39', '2020-11-24 20:38:14', NULL, NULL, '2020-11-27 01:47:45'),
(33, 19, 7, 7, 2, 1, NULL, 1, 2, NULL, 'qweqeq', NULL, NULL, NULL, NULL, '2020-11-24 20:49:31', '2020-11-24 20:49:41', NULL, NULL, NULL),
(34, 19, 7, 6, 7, 6, NULL, 1, NULL, NULL, 'qweqeq', NULL, 'eqwe21321321312', 'qw3122fjij 121dwddq dqeqqweqx [d dwadkaj9f eqfafafca', 'dd asd dwdqddsuihf9fgb asudhuwqdqd  321 312312 312 3 12', '2020-11-24 20:49:56', '2020-11-24 20:50:11', NULL, NULL, '2020-11-24 21:17:12'),
(35, 19, 7, 4, 6, 11, NULL, 1, NULL, 1, 'qweqeq', NULL, NULL, NULL, NULL, '2020-11-24 21:06:20', '2020-11-24 21:07:03', NULL, NULL, '2020-11-24 21:15:59'),
(36, 16, 5, 5, 2, 4, NULL, NULL, NULL, NULL, 'ewrwere', NULL, 'MRT', 'MRT', 'MRT', '2020-11-24 21:31:58', '2020-11-26 23:41:34', '2020-11-26 23:38:30', NULL, '2020-11-26 23:41:46'),
(37, 22, 8, 8, 2, 2, NULL, NULL, NULL, NULL, 'qwe', NULL, '1212', '212', '121', '2020-11-24 21:32:07', '2020-11-26 23:43:13', '2020-11-26 23:39:03', NULL, '2020-11-26 23:43:24'),
(38, 20, 6, 6, 2, 5, NULL, NULL, NULL, NULL, '2132121312', NULL, 'eqwe', 'qw eweqwe qw', 'weq we qweqw', '2020-11-24 21:32:26', '2020-11-26 23:40:53', '2020-11-26 23:39:13', NULL, '2020-11-26 23:41:11'),
(39, 14, 6, 7, 6, 9, NULL, 1, 1, NULL, '45995494', NULL, '2313', '2qweqwe21qwe', 'qweqweqweqweq', '2020-11-24 23:59:20', '2020-11-24 23:59:32', '2020-11-27 20:39:56', NULL, '2020-11-26 23:42:21'),
(40, 18, 6, 7, 6, 9, NULL, 1, NULL, NULL, 'qwewqe', NULL, 'СЕРДце', 'выфцвйцв йцывфвйц вйц чйвйц вйцвйцв фы вцвйвйц', 'цвйцвцй йвйц йцвйц  ййцуйц й', '2020-11-25 00:12:14', '2020-11-25 20:47:05', NULL, NULL, '2020-11-26 23:42:41'),
(41, 17, 6, 6, 2, 5, NULL, NULL, NULL, NULL, 'sxasx', NULL, 'qweq', 'eqeqeq', 'eqweqeqwqweqw', '2020-11-25 15:44:59', '2020-11-25 15:59:38', '2020-11-25 15:58:52', NULL, '2020-11-26 23:40:28'),
(42, 17, 6, 5, 6, 4, NULL, NULL, NULL, NULL, 'sxasx', NULL, 'MRT', 'MRT M RT MRTMR TMRT MRT', 'MR TMR TM RTM RTMRT', '2020-11-25 16:00:39', '2020-11-25 16:01:25', '2020-11-25 16:01:08', NULL, '2020-11-26 23:34:40'),
(43, 17, 6, 5, 6, 8, NULL, NULL, NULL, NULL, 'sxasx', NULL, '23', '3231232132', '1321321321321321', '2020-11-25 16:00:48', '2020-11-25 16:02:03', '2020-11-25 16:01:08', NULL, '2020-11-26 23:34:40'),
(44, 12, 6, 4, 6, 11, NULL, NULL, NULL, 1, 'ewq', NULL, NULL, NULL, NULL, '2020-11-25 18:50:49', '2020-11-25 18:52:37', '2020-11-25 18:51:41', NULL, '2020-11-25 23:40:02'),
(46, 18, 6, 4, 6, 10, NULL, 1, NULL, 1, 'qwewqe', NULL, NULL, NULL, NULL, '2020-11-25 18:54:47', '2020-11-25 18:58:23', NULL, NULL, '2020-11-25 19:48:46'),
(47, 18, 6, 4, 6, 11, NULL, 1, NULL, 1, 'qwewqe', NULL, NULL, NULL, NULL, '2020-11-25 18:56:00', '2020-11-25 18:58:37', NULL, NULL, '2020-11-25 19:48:46'),
(48, 18, 6, 5, 6, 4, NULL, 1, NULL, NULL, 'qwewqe', NULL, 'MRT', 'wqeqwewqeqwe', 'qweqweqweqweqeqw', '2020-11-25 20:27:50', '2020-11-25 20:28:10', NULL, NULL, '2020-11-27 15:07:35'),
(50, 18, 6, 7, 6, 5, NULL, 1, NULL, NULL, 'qwewqe', NULL, 'qwewq', 'wqedad  dwdqwd qwdaa sdqwq', 'ewqdwqdq', '2020-11-25 20:46:46', '2020-11-25 21:04:31', NULL, NULL, '2020-11-26 23:42:41'),
(51, 14, 6, 4, 7, 10, NULL, 1, 1, 1, '45995494', NULL, NULL, NULL, NULL, '2020-11-25 21:07:52', '2020-11-25 21:13:47', '2020-11-27 20:39:56', NULL, '2020-11-25 21:23:03'),
(56, 18, 6, 4, 6, 10, NULL, 1, NULL, 1, 'qwewqe', NULL, NULL, NULL, NULL, '2020-11-26 00:34:12', '2020-11-26 00:35:15', NULL, NULL, '2020-11-26 02:20:47'),
(57, 18, 6, 4, 6, 11, NULL, 1, NULL, 1, 'qwewqe', NULL, NULL, NULL, NULL, '2020-11-26 00:34:20', '2020-11-26 00:35:22', NULL, NULL, '2020-11-26 02:20:47'),
(58, 12, 6, 6, 2, 5, NULL, NULL, 2, NULL, 'q', NULL, NULL, NULL, NULL, '2020-11-27 14:26:50', '2020-11-27 17:10:18', '2020-11-27 14:27:24', NULL, NULL),
(59, 15, 6, 6, 2, 6, NULL, NULL, 2, NULL, 'qq', NULL, NULL, NULL, NULL, '2020-11-27 14:27:03', '2020-11-27 14:27:47', '2020-11-27 14:27:29', NULL, NULL),
(60, 17, 6, 6, 2, 5, NULL, NULL, 1, NULL, 'qq', NULL, NULL, NULL, NULL, '2020-11-27 14:27:14', NULL, '2020-11-27 19:21:54', NULL, NULL),
(61, 18, 6, 5, 6, 4, NULL, 1, NULL, NULL, 'qwewqe', NULL, 'wqewewqewq', 'ewqeas dasdwqe', 'eqwewqeqwwq', '2020-11-27 15:06:56', '2020-11-27 15:07:18', NULL, NULL, '2020-11-27 15:07:35'),
(62, 23, 7, 7, 2, 6, NULL, NULL, 0, NULL, 'w', NULL, NULL, NULL, NULL, '2020-11-27 17:01:34', NULL, NULL, NULL, NULL),
(63, 14, 8, 8, 2, 2, NULL, NULL, 1, NULL, 'weqe', NULL, NULL, NULL, NULL, '2020-11-27 18:01:13', NULL, '2020-11-27 20:39:56', NULL, NULL);

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
(5, 9, 3, '100000.0', NULL, NULL, NULL, '2020-11-23 21:08:51'),
(6, 10, 3, '200.0', NULL, NULL, NULL, '2020-11-23 21:08:51'),
(7, 1, 3, '100000.0', NULL, NULL, NULL, '2020-11-23 21:09:05'),
(8, 11, 3, '40000.0', NULL, NULL, NULL, '2020-11-23 21:10:31'),
(9, 12, 3, '23434.0', NULL, NULL, NULL, '2020-11-23 21:57:36'),
(10, 14, 3, '100000.0', NULL, NULL, NULL, '2020-11-23 21:57:42'),
(11, 16, 3, '1000.0', NULL, NULL, NULL, '2020-11-24 09:10:00'),
(12, 17, 3, '2000.0', NULL, NULL, NULL, '2020-11-24 09:18:38'),
(13, 18, 3, '200.0', NULL, NULL, NULL, '2020-11-24 09:36:20'),
(14, 19, 3, '3000.0', NULL, NULL, NULL, '2020-11-24 09:45:47'),
(15, 20, 3, '40000.0', NULL, NULL, NULL, '2020-11-24 09:54:29'),
(16, 24, 3, '10000.0', NULL, NULL, NULL, '2020-11-24 10:32:47'),
(17, 25, 3, '23434.0', NULL, NULL, NULL, '2020-11-24 10:32:47'),
(18, 26, 3, '20000.0', NULL, NULL, NULL, '2020-11-24 11:53:29'),
(19, 32, 3, '40000.0', NULL, NULL, NULL, '2020-11-24 15:25:03'),
(22, 41, 3, '100000.0', NULL, NULL, NULL, '2020-11-25 10:58:52'),
(23, 42, 3, '4000.0', NULL, NULL, NULL, '2020-11-25 11:01:08'),
(24, 43, 3, '4000.0', NULL, NULL, NULL, '2020-11-25 11:01:08'),
(25, 44, 3, '10000.0', NULL, NULL, NULL, '2020-11-25 13:51:41'),
(26, 36, 3, NULL, '1000.0', NULL, NULL, '2020-11-26 18:38:30'),
(27, 37, 3, '23434.0', NULL, NULL, NULL, '2020-11-26 18:39:03'),
(28, 38, 3, '100000.0', NULL, NULL, NULL, '2020-11-26 18:39:13'),
(29, 58, 3, '100000.0', NULL, NULL, NULL, '2020-11-27 09:27:24'),
(30, 59, 3, '200.0', NULL, NULL, NULL, '2020-11-27 09:27:29'),
(38, 60, 3, '50000.0', '50000.0', NULL, NULL, '2020-11-27 14:21:54'),
(39, 27, 3, NULL, NULL, NULL, NULL, '2020-11-27 15:39:55'),
(40, 28, 3, '1000.0', NULL, NULL, NULL, '2020-11-27 15:39:55'),
(41, 29, 3, '2000.0', NULL, NULL, NULL, '2020-11-27 15:39:55'),
(42, 31, 3, NULL, NULL, NULL, NULL, '2020-11-27 15:39:56'),
(43, 39, 3, '40000.0', NULL, NULL, NULL, '2020-11-27 15:39:56'),
(44, 51, 3, NULL, '20000.0', NULL, NULL, '2020-11-27 15:39:56'),
(45, 63, 3, NULL, '23434.0', NULL, NULL, '2020-11-27 15:39:56');

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
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `beds`
--
ALTER TABLE `beds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- AUTO_INCREMENT для таблицы `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `investment`
--
ALTER TABLE `investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze`
--
ALTER TABLE `laboratory_analyze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT для таблицы `visit_price`
--
ALTER TABLE `visit_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
