-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 23 2020 г., 16:12
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
(1, 1, 1, 1, 1, 16),
(2, 1, 1, 2, 1, 24),
(3, 1, 1, 3, 1, NULL),
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
(1, 16, 7, 1, 2, '3 раза в день', 1, '2020-11-23 10:30:37'),
(2, 16, 7, 2, 10, '1 hfp d ltn', 1, '2020-11-23 12:22:03'),
(3, 16, 26, NULL, NULL, 'сделано', NULL, '2020-11-23 12:41:43');

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
  `time` varchar(255) DEFAULT NULL
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
(1, NULL, 16, 1, '10', 'qwe'),
(2, NULL, 16, 2, '7', 'qwe'),
(3, 16, 17, 1, '7', 'Норма'),
(4, 16, 17, 2, '8', 'переизбыток'),
(11, 19, 19, 1, '9', 'Норма'),
(12, 19, 19, 2, '7', 'Норма'),
(13, 19, 21, 3, '0', 'Ура'),
(14, 19, 21, 4, '0', 'Ура'),
(15, 18, 23, 3, '11', 'нормально'),
(16, 18, 23, 4, '10', 'JОчень плохо'),
(17, 15, 26, 1, '10', ''),
(18, 15, 26, 2, '7', ''),
(19, 18, 30, 3, '12', 'плохо'),
(20, 18, 30, 4, '34', 'норм'),
(21, 25, 32, 1, '10', 'хорошо'),
(22, 25, 32, 2, '7', 'хорошо'),
(23, 14, 35, 3, '12', '1'),
(24, 14, 35, 4, '34', '1'),
(25, 14, 41, 1, '10', 'Отлично'),
(26, 14, 41, 2, '7', 'Отлично'),
(27, 14, 43, 1, '9', 'Хорошо'),
(28, 14, 43, 2, '7', 'Отлично'),
(29, 24, 51, 1, '10', 'Отлично'),
(30, 24, 51, 2, '7', 'Отлично'),
(31, 16, 52, 1, '10', 'Отлично'),
(32, 16, 52, 2, '3', 'Плохой результат'),
(33, 16, 54, 1, '8', 'Нормально'),
(34, 16, 54, 2, '7', 'Отлично'),
(35, 16, 55, 3, '10', 'w'),
(36, 16, 55, 4, '34', 'w'),
(37, 24, 58, 3, '12', 'wqewq'),
(38, 24, 58, 4, '34', 'eq');

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
(1, NULL, NULL, '21 ноября', 'посетить пациента 00032'),
(2, NULL, NULL, '30 ноября', 'поитграть '),
(4, 7, 16, 'June 4th 08:47', '12');

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
(13, 10, NULL, NULL, 'pasient 2', 'pasient 2', 'pasient 2', '2000-12-12', 'Миробод', 'kjklj', 'kn,knm,n', ',mn,mn,m', '98989898', 'iljiljklj', 'kjkljkl', NULL, 15, NULL, NULL, 0, 'm,nm,n', '2020-11-18 16:06:24'),
(14, 2, NULL, NULL, 'Жасур', 'Рахматов', 'Илхомович', '2003-05-08', 'Ромитан', 'AC6453482', 'Хокимиат', 'Глава отдела', '+998934568052', 'Алпомыш', 'Алпомыш', 1, 15, NULL, 1, 0, NULL, '2020-11-18 16:06:53'),
(15, 10, NULL, NULL, 'pasient 3', 'pasient 3', 'pasient 3', '2000-12-12', 'Олмазор', 'jjjkhjk', 'm,nnm,nmbnm', 'nm,m,nm,n', '98098098098', ',jhknjj', 'jjnjjk', NULL, 15, NULL, NULL, 0, 'm,nm,nm,nm,n', '2020-11-18 16:07:03'),
(16, 9, NULL, NULL, 'Адольф', 'Гитлер', 'Нету', '1899-04-20', 'Ромитан', 'WE2312313', 'Германия, Мюнхен', 'Политик, глава 3 рейха', '998909090899', 'Австрия', 'могила №3', 1, 15, NULL, 1, 0, 'евреи', '2020-11-18 16:07:03'),
(17, 10, NULL, NULL, 'pasient 4', 'pasient 4', 'pasient 4', '1212-02-11', 'Олмазор', 'kljkljklj', 'kljkljklj', 'ljkljklj', '8909809809', 'iljljklj', 'lkjkljklj', NULL, 15, NULL, NULL, 0, 'lkjlkjkljkl', '2020-11-18 16:07:48'),
(18, 10, NULL, NULL, 'pasient 5', 'pasient 5', 'pasient 5', '2122-03-12', 'Олмазор', 'jkhjkhjk', 'mnm,nm,nm,', 'm,nm,nm,n', '89098098098', 'kjhkljk', 'jkhjkhkjh', NULL, 15, NULL, NULL, 0, ',mn,mn,mn', '2020-11-18 16:08:21'),
(19, 9, NULL, NULL, 'Иосиф', 'Сталин', 'Виссарионович', '1924-01-21', 'Ромитан', 'WE3424234234', 'Россия', 'Император Росси', '+998909990099', 'Россия', 'Москва кремоль', 1, 15, NULL, NULL, 0, 'Гитлер', '2020-11-18 16:10:05'),
(20, 9, NULL, NULL, 'Владимир', 'Ленин', 'Ильич', '1870-04-22', 'Ромитан', 'QW452345234532', 'CCCP', 'Вождь', '+998909445465', 'Россия', 'Мавзолей', 1, 15, NULL, NULL, 0, 'Капитализм', '2020-11-18 16:12:51'),
(21, 2, NULL, NULL, 'Pasient 6', 'Pasient 6', 'Pasient 6', '2019-11-06', 'Чилонзор', 'цуй321112312312', 'Pasient 6', 'Pasient 6', '2132132112312231', 'Pasient 6', 'Pasient 6', NULL, 15, NULL, NULL, 0, 'Pasient 6', '2020-11-18 16:13:53'),
(22, 9, NULL, NULL, 'Алексей', 'Шевцов', 'Владимирович', '1999-11-24', 'Юнусобод', 'WE324234234', 'Ютуб', 'Блогер', '+998990989078', 'Украина Одесса', 'Украина Одесса', 1, 15, NULL, NULL, 0, 'Глупые люди', '2020-11-18 16:15:37'),
(23, 9, NULL, NULL, 'Кира', 'Хошигаке', 'НЕТ', '1995-01-20', 'Юнусобод', 'CV 333222', 'Япония Токио', 'Коммисар', '+99899900098', 'Япония Токио', 'Япония Токио', 1, 15, NULL, NULL, 0, 'L', '2020-11-18 16:17:36'),
(24, 9, NULL, NULL, 'Умархан', 'Убунту', 'Вадимович', '2000-11-14', 'Юнусобод', 'AZ', 'Мексика', 'Укратитель змей', '+998999088998', 'Бухара', 'Бухара', 1, 15, NULL, 1, 0, 'любовь', '2020-11-18 16:20:14'),
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
(1, 26, 48, 'Хорошо', 12, 70, 36, '2020-11-22 16:22:26'),
(2, 26, 48, 'Плохо', 1, 1, 1, '2020-11-22 16:28:31');

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
  `direction` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `laboratory` tinyint(1) DEFAULT NULL,
  `complaint` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `failure` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp(),
  `accept_date` datetime DEFAULT NULL,
  `discharge_date` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `visit`
--

INSERT INTO `visit` (`id`, `user_id`, `grant_id`, `parent_id`, `route_id`, `direction`, `status`, `laboratory`, `complaint`, `failure`, `add_date`, `accept_date`, `discharge_date`, `completed`) VALUES
(1, 14, NULL, 5, 2, NULL, NULL, NULL, '111', NULL, '2020-11-18 21:07:51', '2020-11-18 21:20:21', NULL, '2020-11-18 21:26:55'),
(2, 16, NULL, 7, 2, NULL, NULL, NULL, 'Боль в животе', NULL, '2020-11-18 21:08:32', '2020-11-18 21:18:13', NULL, '2020-11-18 21:32:59'),
(3, 12, NULL, 7, 10, NULL, NULL, NULL, 'sdcsdf', NULL, '2020-11-18 21:08:55', '2020-11-18 21:24:12', NULL, '2020-11-21 00:59:24'),
(4, 13, NULL, 8, 10, NULL, NULL, NULL, 'kjkj,kjk,', NULL, '2020-11-18 21:09:38', '2020-11-21 00:56:37', NULL, '2020-11-21 00:59:33'),
(5, 17, 8, 8, 10, 1, NULL, NULL, '.kjmk.k.j', NULL, '2020-11-18 21:10:13', '2020-11-18 21:28:50', NULL, '2020-11-21 00:56:12'),
(6, 15, 6, 6, 2, 1, NULL, NULL, 'Боль в сердце', NULL, '2020-11-18 21:10:16', '2020-11-20 01:02:35', NULL, '2020-11-20 01:18:06'),
(7, 18, 5, 5, 10, 1, NULL, NULL, ',,kjkljklj', NULL, '2020-11-18 21:12:34', '2020-11-18 21:20:25', NULL, '2020-11-21 00:00:24'),
(8, 19, NULL, 8, 2, NULL, NULL, NULL, 'Боль в зубах', NULL, '2020-11-18 21:12:35', '2020-11-18 21:28:54', NULL, '2020-11-18 21:33:14'),
(9, 21, 5, 5, 10, 1, NULL, NULL, 'jklkljkljkl', NULL, '2020-11-18 21:14:31', '2020-11-18 21:20:28', NULL, '2020-11-21 00:57:15'),
(10, 20, NULL, 6, 2, NULL, NULL, NULL, 'Боль в спине', NULL, '2020-11-18 21:14:40', '2020-11-20 01:23:04', NULL, '2020-11-21 00:59:11'),
(11, 23, 8, 8, 10, 1, NULL, NULL, 'j,hkhj,kjklj', NULL, '2020-11-18 21:20:13', '2020-11-18 21:28:56', NULL, '2020-11-21 00:56:21'),
(12, 22, NULL, 5, 10, NULL, NULL, NULL, ',.m.,m,.m,.m', NULL, '2020-11-18 21:20:30', '2020-11-18 21:31:00', NULL, '2020-11-21 00:59:00'),
(13, 14, NULL, 7, 5, NULL, NULL, NULL, '111', NULL, '2020-11-18 21:24:21', '2020-11-18 21:25:05', NULL, '2020-11-18 21:26:16'),
(14, 24, 8, 8, 10, 1, NULL, NULL, 'jkljkljklj', NULL, '2020-11-18 21:28:12', '2020-11-18 21:28:58', NULL, '2020-11-21 00:56:27'),
(15, 19, NULL, 5, 8, NULL, NULL, NULL, 'Боль в зубах', NULL, '2020-11-18 21:30:12', '2020-11-18 21:30:52', NULL, '2020-11-18 21:32:24'),
(16, 14, NULL, 4, 2, NULL, NULL, NULL, 'test', NULL, '2020-11-18 21:57:27', '2020-11-19 21:01:37', NULL, '2020-11-19 21:58:13'),
(17, 16, NULL, 4, 2, NULL, 2, 1, 'sxasxasx', NULL, '2020-11-19 21:32:50', '2020-11-19 21:33:34', NULL, '2020-11-19 21:58:13'),
(18, 14, NULL, 5, 2, NULL, NULL, NULL, 'qweqw', NULL, '2020-11-19 22:04:14', '2020-11-19 22:04:40', NULL, '2020-11-21 00:16:43'),
(19, 19, NULL, 4, 2, NULL, NULL, 1, 'qwewqewqewq', NULL, '2020-11-19 22:27:25', '2020-11-19 23:34:10', NULL, '2020-11-19 23:38:24'),
(20, 19, NULL, 5, 2, NULL, NULL, NULL, 'wqe', NULL, '2020-11-19 23:38:59', '2020-11-19 23:39:40', NULL, '2020-11-21 00:59:46'),
(21, 19, NULL, 4, 5, NULL, NULL, NULL, 'wqe', NULL, '2020-11-19 23:43:16', '2020-11-19 23:43:46', NULL, '2020-11-19 23:44:46'),
(23, 18, NULL, 4, 5, 1, NULL, 1, ',,kjkljklj', NULL, '2020-11-20 00:25:20', '2020-11-20 00:25:47', NULL, '2020-11-20 00:26:39'),
(24, 18, NULL, 6, 5, 1, NULL, NULL, ',,kjkljklj', NULL, '2020-11-20 00:46:00', '2020-11-20 00:46:14', NULL, '2020-11-20 01:01:46'),
(25, 19, 6, 6, 2, 1, NULL, NULL, 'qwe', NULL, '2020-11-20 00:54:15', '2020-11-20 01:23:07', NULL, '2020-11-21 00:56:56'),
(26, 15, 6, 4, 6, 1, NULL, 1, 'Боль в сердце', NULL, '2020-11-20 01:14:35', '2020-11-20 01:14:53', NULL, '2020-11-20 01:15:18'),
(27, 15, NULL, 6, 2, NULL, NULL, NULL, 'q', NULL, '2020-11-20 01:20:17', '2020-11-21 01:00:16', NULL, '2020-11-21 01:00:20'),
(28, 25, 6, 6, 2, 1, NULL, NULL, 'q', NULL, '2020-11-20 01:21:00', '2020-11-20 01:21:33', NULL, '2020-11-20 01:22:59'),
(29, 25, 6, 5, 6, 1, NULL, NULL, 'q', NULL, '2020-11-20 01:21:48', '2020-11-20 01:22:13', NULL, '2020-11-20 01:22:22'),
(30, 18, 5, 4, 5, 1, NULL, 1, ',,kjkljklj', NULL, '2020-11-20 01:27:38', '2020-11-20 01:28:46', NULL, '2020-11-20 01:29:07'),
(31, 25, 6, 6, 2, 1, NULL, NULL, 'wqee', NULL, '2020-11-21 00:01:09', '2020-11-21 00:01:25', NULL, '2020-11-21 00:57:01'),
(32, 25, 6, 4, 6, 1, NULL, 1, 'wqee', NULL, '2020-11-21 00:01:42', '2020-11-21 00:01:53', NULL, '2020-11-21 00:02:26'),
(33, 25, 6, 5, 6, 1, NULL, NULL, 'wqee', NULL, '2020-11-21 00:08:35', '2020-11-21 00:08:46', NULL, '2020-11-21 00:09:08'),
(34, 14, 7, 7, 2, NULL, NULL, NULL, 'asqas', NULL, '2020-11-21 00:19:07', '2020-11-21 00:20:32', NULL, '2020-11-21 00:31:06'),
(35, 14, 7, 4, 7, NULL, NULL, 1, 'asqas', NULL, '2020-11-21 00:23:56', '2020-11-21 00:24:27', NULL, '2020-11-21 00:24:51'),
(36, 14, 7, 5, 7, NULL, NULL, NULL, 'asqas', NULL, '2020-11-21 00:25:40', '2020-11-21 00:26:06', NULL, '2020-11-21 00:27:00'),
(37, 14, 5, 5, 2, NULL, NULL, NULL, 'qwqw', NULL, '2020-11-21 00:34:50', '2020-11-21 00:35:07', NULL, '2020-11-21 00:35:14'),
(38, 14, 8, 8, 10, NULL, NULL, NULL, 'sadasd', NULL, '2020-11-21 00:37:52', '2020-11-21 00:38:15', NULL, '2020-11-21 00:38:35'),
(39, 14, 6, 6, 2, 1, NULL, NULL, 'qwqw', NULL, '2020-11-21 00:50:50', '2020-11-21 00:51:35', NULL, '2020-11-21 00:55:20'),
(40, 14, 6, 5, 6, 1, NULL, NULL, 'qwqw', NULL, '2020-11-21 00:52:04', '2020-11-21 00:52:18', NULL, '2020-11-21 00:52:48'),
(41, 14, 6, 4, 6, 1, NULL, 1, 'qwqw', NULL, '2020-11-21 00:53:22', '2020-11-21 00:53:49', NULL, '2020-11-21 00:54:23'),
(42, 14, 6, 6, 2, 1, NULL, NULL, 'ывцй', NULL, '2020-11-21 15:53:46', '2020-11-21 15:53:55', NULL, '2020-11-21 22:01:57'),
(43, 14, 6, 4, 6, 1, NULL, 1, 'ывцй', NULL, '2020-11-21 15:59:53', '2020-11-21 16:03:32', NULL, '2020-11-21 16:04:07'),
(44, 14, 6, 5, 6, 1, NULL, NULL, 'ывцй', NULL, '2020-11-21 16:00:01', '2020-11-21 16:03:08', NULL, '2020-11-21 16:06:58'),
(45, 14, 6, 5, 6, 1, NULL, NULL, 'ывцй', NULL, '2020-11-21 16:33:37', '2020-11-21 16:33:44', NULL, '2020-11-21 16:50:52'),
(46, 14, 6, 5, 6, 1, NULL, NULL, 'ывцй', NULL, '2020-11-21 16:45:29', '2020-11-21 16:46:50', NULL, '2020-11-21 17:00:38'),
(47, 14, 6, 5, 6, 1, NULL, NULL, 'ывцй', NULL, '2020-11-21 16:51:37', '2020-11-21 16:51:48', NULL, '2020-11-21 22:02:47'),
(48, 16, 7, 7, 9, 1, 2, NULL, 'Боль в жопе', NULL, '2020-11-21 22:05:04', '2020-11-21 22:05:08', NULL, NULL),
(50, 24, 7, 7, 9, NULL, NULL, NULL, 'Совесть болит', NULL, '2020-11-21 22:08:49', '2020-11-21 22:16:28', NULL, '2020-11-22 00:10:27'),
(51, 24, 7, 4, 7, NULL, NULL, 1, 'Совесть болит', NULL, '2020-11-21 23:35:46', '2020-11-21 23:36:52', NULL, '2020-11-22 00:05:38'),
(52, 16, 7, 4, 7, 1, NULL, 1, 'Боль в жопе', NULL, '2020-11-21 23:36:21', '2020-11-21 23:36:55', NULL, '2020-11-22 00:06:30'),
(53, 16, 7, 5, 7, 1, NULL, NULL, 'Боль в жопе', NULL, '2020-11-22 00:11:22', '2020-11-22 00:11:34', NULL, '2020-11-22 00:18:27'),
(54, 16, 7, 4, 7, 1, NULL, 1, 'Боль в жопе', NULL, '2020-11-22 00:32:43', '2020-11-22 00:33:17', NULL, '2020-11-22 00:33:55'),
(55, 16, 7, 4, 7, 1, NULL, 1, 'Боль в жопе', NULL, '2020-11-22 01:23:25', '2020-11-22 01:23:49', NULL, '2020-11-23 11:57:23'),
(56, 14, 7, 7, 2, NULL, 2, NULL, 'q', NULL, '2020-11-22 02:12:35', '2020-11-22 02:15:29', NULL, NULL),
(57, 24, 7, 7, 2, 1, 2, NULL, 'a', NULL, '2020-11-22 02:14:22', '2020-11-22 02:15:32', NULL, NULL),
(58, 24, 7, 4, 7, 1, 2, 1, 'a', NULL, '2020-11-23 18:27:55', '2020-11-23 18:28:05', NULL, NULL);

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
(1, 1, NULL, '2000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:16:28'),
(2, 10, NULL, '100000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:16:41'),
(3, 2, NULL, '200.0', NULL, NULL, NULL, NULL, '2020-11-18 16:16:47'),
(4, 8, NULL, '23434.0', NULL, NULL, NULL, NULL, '2020-11-18 16:16:56'),
(5, 12, NULL, '2000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:20:56'),
(6, 3, NULL, '200.0', NULL, NULL, NULL, NULL, '2020-11-18 16:21:04'),
(7, 13, NULL, '40000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:24:55'),
(8, 15, NULL, '2000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:30:43'),
(9, 16, NULL, '20000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:57:51'),
(10, 17, NULL, '20000.0', NULL, NULL, NULL, NULL, '2020-11-19 16:33:14'),
(11, 18, NULL, '3000.0', NULL, NULL, NULL, NULL, '2020-11-19 17:04:35'),
(12, 19, NULL, '20000.0', NULL, NULL, NULL, NULL, '2020-11-19 17:27:39'),
(13, 20, NULL, '1000.0', NULL, NULL, NULL, NULL, '2020-11-19 18:39:09'),
(14, 21, NULL, '10000.0', NULL, NULL, NULL, NULL, '2020-11-19 18:43:30'),
(15, 34, NULL, '40000.0', NULL, NULL, NULL, NULL, '2020-11-20 19:20:25'),
(16, 35, NULL, '10000.0', NULL, NULL, NULL, NULL, '2020-11-20 19:24:20'),
(17, 36, NULL, '1000.0', NULL, NULL, NULL, NULL, '2020-11-20 19:25:53'),
(18, 37, NULL, '3000.0', NULL, NULL, NULL, NULL, '2020-11-20 19:35:00'),
(19, 38, NULL, '23434.0', NULL, NULL, NULL, NULL, '2020-11-20 19:38:08'),
(20, 4, 11, '23434.0', NULL, NULL, NULL, NULL, '2020-11-20 19:44:08'),
(21, 27, 3, '100000.0', NULL, NULL, NULL, NULL, '2020-11-20 19:59:57'),
(22, 50, 3, '40000.0', NULL, NULL, NULL, NULL, '2020-11-21 17:15:39'),
(23, 51, 3, '20000.0', NULL, NULL, NULL, NULL, '2020-11-21 18:36:38'),
(24, 56, 3, '40000.0', NULL, NULL, NULL, NULL, '2020-11-21 21:12:43');

-- --------------------------------------------------------

--
-- Структура таблицы `visit_service`
--

CREATE TABLE `visit_service` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `priced` datetime DEFAULT NULL,
  `report` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `report_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_conclusion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `visit_service`
--

INSERT INTO `visit_service` (`id`, `visit_id`, `service_id`, `priced`, `report`, `report_title`, `report_description`, `report_conclusion`, `completed`) VALUES
(1, 1, 7, '2020-11-18 21:16:28', '<p>Все нормально</p>\r\n', NULL, NULL, NULL, 1),
(2, 2, 6, '2020-11-18 21:16:47', '<p>Отреза ногу ему она больше не нужна, Теперь в место неё палка которую я отобрал у собаки на улицы.</p>\r\n\r\n<p>Вызжал на лбу немецкую зигу, он очень просил.</p>\r\n', NULL, NULL, NULL, 1),
(3, 3, 6, '2020-11-18 21:21:04', NULL, NULL, NULL, NULL, NULL),
(4, 4, 2, '2020-11-21 00:44:08', NULL, NULL, NULL, NULL, NULL),
(5, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, 2, '2020-11-18 21:16:56', '<p>состояние нормальное</p>\r\n\r\n<p>зуб вырван</p>\r\n', NULL, NULL, NULL, 1),
(9, 9, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 10, 5, '2020-11-18 21:16:41', NULL, NULL, NULL, NULL, NULL),
(11, 11, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 12, 7, '2020-11-18 21:20:56', NULL, NULL, NULL, NULL, NULL),
(13, 13, 9, '2020-11-18 21:24:55', '<p>Орезал не нужные детали, и пришил что надо</p>\r\n', NULL, NULL, NULL, 1),
(14, 14, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 15, 7, '2020-11-18 21:30:43', '<p>Ренген проведён успешно</p>\r\n\r\n<p>бракованый зуб</p>\r\n', NULL, NULL, NULL, 1),
(16, 16, 10, '2020-11-18 21:57:51', NULL, NULL, NULL, NULL, NULL),
(17, 17, 10, '2020-11-19 21:33:14', NULL, NULL, NULL, NULL, NULL),
(18, 18, 8, '2020-11-19 22:04:35', NULL, 'qe', 'qweqweqwd', 'asdadadas', 1),
(19, 19, 10, '2020-11-19 22:27:39', NULL, NULL, NULL, NULL, NULL),
(20, 20, 4, '2020-11-19 23:39:09', NULL, NULL, NULL, NULL, NULL),
(21, 21, 11, '2020-11-19 23:43:30', NULL, NULL, NULL, NULL, NULL),
(22, 22, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 23, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 24, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 25, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 26, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 27, 5, '2020-11-21 00:59:57', NULL, NULL, NULL, NULL, NULL),
(28, 28, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 29, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 30, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 31, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 32, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 33, 4, NULL, NULL, 'qweqweqwe', '21eqweqweqw', 'eqweqweqwqwasdsadcadw', 1),
(34, 34, 9, '2020-11-21 00:20:25', NULL, 'qwdsadsa', 'ORDER BY accept_date ORDER BY accept_date DESCORDER BY accept_date DESCORDER BY accept_date DESCORDER BY accept_date DESCORDER BY accept_date DESCORDER BY accept_date DESC', 'ORDER BY accept_date DESC', 1),
(35, 35, 11, '2020-11-21 00:24:20', NULL, NULL, NULL, NULL, NULL),
(36, 36, 4, '2020-11-21 00:25:53', NULL, 'qwe', 'qwewqeqwdasw qedadvqwewq eqwdasw qedadqwe wqeqwdaswq edadq wewqe qwdasw qedadqw ewqeqwda swqeda dqwewqeqwdaswq edadqwe  wqeqwdas wqedadqwew qeqwdaswqedad qwewqeqwdaswqe dadqwe wqeqwda swqed adqwewqeqwdaswqedadqw ewqeqw daswqe dadqwewqeqwdasw qedadqwewqe qwdaswqedad', 'dasdascdasbthnrthwree', 1),
(37, 37, 8, '2020-11-21 00:35:00', NULL, 'qwewq', 'qwe', 'qweqq', 1),
(38, 38, 2, '2020-11-21 00:38:08', NULL, 'wqe21', '321321wq', 'wqewqe', 1),
(39, 39, 1, NULL, NULL, '221321', 'ййцуцйуцй', 'уцйуччясячсячсяч', 1),
(40, 40, 7, NULL, NULL, '2132132', '3213213213', '2321312', 1),
(41, 41, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 42, 1, NULL, NULL, '12323221', '21321321', 'wewqewqeqweqweqwe', 1),
(43, 43, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 44, 4, NULL, NULL, 'qewqeqwe', 'qwewqewqewqew', 'eqwddassadcxzczxczx', 1),
(45, 45, 4, NULL, NULL, 'МРТ Головнного мозга', 'МРТ головного мозга — это неинвазивное исследование, которое подразумевает использование мощных магнитных полей, высокочастотных импульсов, компьютерной системы и программного обеспечения, позволяющих получить детальное изображение мозга. Рентгеновское излучение при МРТ не используется. Именно поэтому на сегодняшний день МРТ — одно из наиболее безопасных и притом очень точных исследований. Качество визуализации при МРТ намного лучше, чем при рентгенологическом или ультразвуковом исследовании, компьютерной томографии. Магнитно-резонансная томография дает возможность обнаружить опухоли, аневризму и другие патологии сосудов, а также некоторые проблемы нервной системы. Словом, возможности метода очень широки. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', 'Несмотря на то, что для разных методов диагностики (рентгеновской, радионуклидной, магнитно-резонансной, ультразвуковой) используются различные физические принципы и источники излучения, их объединяет применение правил математического моделирования при создании изображений. Поэтому данные методы относят к методам лучевой диагностики, и обследование проводится в специальном отделении с аналогичным названием. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', 1),
(46, 46, 7, NULL, NULL, '2313', 'wewqeqw', 'ewqeqweqwe', 1),
(47, 47, 4, NULL, NULL, 'wqewqewqewq', 'wewqq', 'ewqewqewqeqwqqeq', 1),
(48, 48, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 50, 9, '2020-11-21 22:15:39', NULL, 'qweqwewqeewwq', 'dasdasd d asdas das djmaikdn a najn jandja   dasdjasdjasdkashdoihoudhqwuid dqwdqwnhjdijdwaion adwqaudhwqudhadad adadsadas dasdasd d asdas das djmaikdn a najn jandja   dasdjasdjasdkashdoihoudhqwuid dqwdqwnhjdijdwaion adwqaudhwqudhadad adadsadasdasdasd d asdas das djmaikdn a najn jandja   dasdjasdjasdkashdoihoudhqwuid dqwdqwnhjdijdwaion adwqaudhwqudhadad adadsadasdasdasd d asdas das djmaikdn a najn jandja   dasdjasdjasdkashdoihoudhqwuid dqwdqwnhjdijdwaion adwqaudhwqudhadad adadsadasdasdasd d asdas das djmaikdn a najn jandja   dasdjasdjasdkashdoihoudhqwuid dqwdqwnhjdijdwaion adwqaudhwqudhadad adadsadasdasdasd d asdas das djmaikdn a najn jandja   dasdjasdjasdkashdoihoudhqwuid dqwdqwnhjdijdwaion adwqaudhwqudhadad adadsadas', 'dasdasd d asdas das djmaikdn a najn jandja   dasdjasdjasdkashdoihoudhqwuid dqwdqwnhjdijdwaion adwqaudhwqudhadad adadsadasdasdasd d asdas das djmaikdn a najn jandja   dasdjasdjasdkashdoihoudhqwuid dqwdqwnhjdijdwaion adwqaudhwqudhadad adadsadasdasdasd d asdas das djmaikdn a najn jandja   dasdjasdjasdkashdoihoudhqwuid dqwdqwnhjdijdwaion adwqaudhwqudhadad adadsadasdasdasd d asdas das djmaikdn a najn jandja   dasdjasdjasdkashdoihoudhqwuid dqwdqwnhjdijdwaion adwqaudhwqudhadad adadsadas', 1),
(51, 51, 10, '2020-11-21 23:36:38', NULL, NULL, NULL, NULL, NULL),
(52, 52, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 53, 4, NULL, NULL, 'МРТ Головнного мозга', 'МРТ головного мозга — это неинвазивное исследование, которое подразумевает использование мощных магнитных полей, высокочастотных импульсов, компьютерной системы и программного обеспечения, позволяющих получить детальное изображение мозга. Рентгеновское излучение при МРТ не используется. Именно поэтому на сегодняшний день МРТ — одно из наиболее безопасных и притом очень точных исследований. Качество визуализации при МРТ намного лучше, чем при рентгенологическом или ультразвуковом исследовании, компьютерной томографии. Магнитно-резонансная томография дает возможность обнаружить опухоли, аневризму и другие патологии сосудов, а также некоторые проблемы нервной системы. Словом, возможности метода очень широки. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', 'Несмотря на то, что для разных методов диагностики (рентгеновской, радионуклидной, магнитно-резонансной, ультразвуковой) используются различные физические принципы и источники излучения, их объединяет применение правил математического моделирования при создании изображений. Поэтому данные методы относят к методам лучевой диагностики, и обследование проводится в специальном отделении с аналогичным названием. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', 1),
(54, 54, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 55, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 56, 9, '2020-11-22 02:12:43', NULL, NULL, NULL, NULL, NULL),
(57, 57, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 58, 11, NULL, NULL, NULL, NULL, NULL, NULL);

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
-- Индексы таблицы `visit_service`
--
ALTER TABLE `visit_service`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze_type`
--
ALTER TABLE `laboratory_analyze_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `visit_price`
--
ALTER TABLE `visit_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `visit_service`
--
ALTER TABLE `visit_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
