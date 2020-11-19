-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 19 2020 г., 16:24
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
(1, 1, 1, 1, 1, 15),
(2, 1, 1, 2, 1, 17),
(3, 1, 1, 3, 1, 23),
(4, 1, 1, 4, 1, 24),
(5, 1, 2, 1, 2, 18),
(6, 1, 2, 2, 2, 21);

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
  `visit_id` int(11) DEFAULT NULL,
  `analyze_id` int(11) DEFAULT NULL,
  `result` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `laboratory_analyze`
--

INSERT INTO `laboratory_analyze` (`id`, `visit_id`, `analyze_id`, `result`, `description`) VALUES
(1, 16, 1, '10', 'qwe'),
(2, 16, 2, '7', 'qwe');

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
  `date` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `notes`
--

INSERT INTO `notes` (`id`, `date`, `description`) VALUES
(1, '21 ноября', 'посетить пациента 00032'),
(2, '30 ноября', 'поитграть ');

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
(19, 9, NULL, NULL, 'Иосиф', 'Сталин', 'Виссарионович', '1924-01-21', 'Ромитан', 'WE3424234234', 'Россия', 'Император Росси', '+998909990099', 'Россия', 'Москва кремоль', 1, 15, NULL, NULL, 0, 'Гитлер', '2020-11-18 16:10:05'),
(20, 9, NULL, NULL, 'Владимир', 'Ленин', 'Ильич', '1870-04-22', 'Ромитан', 'QW452345234532', 'CCCP', 'Вождь', '+998909445465', 'Россия', 'Мавзолей', 1, 15, NULL, 1, 0, 'Капитализм', '2020-11-18 16:12:51'),
(21, 2, NULL, NULL, 'Pasient 6', 'Pasient 6', 'Pasient 6', '2019-11-06', 'Чилонзор', 'цуй321112312312', 'Pasient 6', 'Pasient 6', '2132132112312231', 'Pasient 6', 'Pasient 6', NULL, 15, NULL, 1, 0, 'Pasient 6', '2020-11-18 16:13:53'),
(22, 9, NULL, NULL, 'Алексей', 'Шевцов', 'Владимирович', '1999-11-24', 'Юнусобод', 'WE324234234', 'Ютуб', 'Блогер', '+998990989078', 'Украина Одесса', 'Украина Одесса', 1, 15, NULL, 1, 0, 'Глупые люди', '2020-11-18 16:15:37'),
(23, 9, NULL, NULL, 'Кира', 'Хошигаке', 'НЕТ', '1995-01-20', 'Юнусобод', 'CV 333222', 'Япония Токио', 'Коммисар', '+99899900098', 'Япония Токио', 'Япония Токио', 1, 15, NULL, 1, 0, 'L', '2020-11-18 16:17:36'),
(24, 9, NULL, NULL, 'Умархан', 'Убунту', 'Вадимович', '2000-11-14', 'Юнусобод', 'AZ', 'Мексика', 'Укратитель змей', '+998999088998', 'Бухара', 'Бухара', 1, 15, NULL, 1, 0, 'любовь', '2020-11-18 16:20:14'),
(25, 9, NULL, NULL, 'Гвидо', 'Мисто', 'Олегович', '1982-02-18', 'Ромитан', 'EWR2345345345', 'Аргентиа', 'Нарко барон', '+998994232', 'Швеция', 'Аргентина', 1, 15, NULL, NULL, 0, 'женщины', '2020-11-18 16:22:17');

-- --------------------------------------------------------

--
-- Структура таблицы `visit`
--

CREATE TABLE `visit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `direction` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
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

INSERT INTO `visit` (`id`, `user_id`, `parent_id`, `route_id`, `direction`, `status`, `complaint`, `failure`, `add_date`, `accept_date`, `discharge_date`, `completed`) VALUES
(1, 14, 5, 2, NULL, NULL, '111', NULL, '2020-11-18 21:07:51', '2020-11-18 21:20:21', NULL, '2020-11-18 21:26:55'),
(2, 16, 7, 2, NULL, NULL, 'Боль в животе', NULL, '2020-11-18 21:08:32', '2020-11-18 21:18:13', NULL, '2020-11-18 21:32:59'),
(3, 12, 7, 10, NULL, 2, 'sdcsdf', NULL, '2020-11-18 21:08:55', '2020-11-18 21:24:12', NULL, NULL),
(4, 13, 8, 10, NULL, 0, 'kjkj,kjk,', NULL, '2020-11-18 21:09:38', NULL, NULL, NULL),
(5, 17, 8, 10, 1, 2, '.kjmk.k.j', NULL, '2020-11-18 21:10:13', '2020-11-18 21:28:50', NULL, NULL),
(6, 15, 6, 2, 1, 1, 'Боль в сердце', NULL, '2020-11-18 21:10:16', NULL, NULL, NULL),
(7, 18, 5, 10, 1, 2, ',,kjkljklj', NULL, '2020-11-18 21:12:34', '2020-11-18 21:20:25', NULL, NULL),
(8, 19, 8, 2, NULL, NULL, 'Боль в зубах', NULL, '2020-11-18 21:12:35', '2020-11-18 21:28:54', NULL, '2020-11-18 21:33:14'),
(9, 21, 5, 10, 1, 2, 'jklkljkljkl', NULL, '2020-11-18 21:14:31', '2020-11-18 21:20:28', NULL, NULL),
(10, 20, 6, 2, NULL, 1, 'Боль в спине', NULL, '2020-11-18 21:14:40', NULL, NULL, NULL),
(11, 23, 8, 10, 1, 2, 'j,hkhj,kjklj', NULL, '2020-11-18 21:20:13', '2020-11-18 21:28:56', NULL, NULL),
(12, 22, 5, 10, NULL, 2, ',.m.,m,.m,.m', NULL, '2020-11-18 21:20:30', '2020-11-18 21:31:00', NULL, NULL),
(13, 14, 7, 5, NULL, NULL, '111', NULL, '2020-11-18 21:24:21', '2020-11-18 21:25:05', NULL, '2020-11-18 21:26:16'),
(14, 24, 8, 10, 1, 2, 'jkljkljklj', NULL, '2020-11-18 21:28:12', '2020-11-18 21:28:58', NULL, NULL),
(15, 19, 5, 8, NULL, NULL, 'Боль в зубах', NULL, '2020-11-18 21:30:12', '2020-11-18 21:30:52', NULL, '2020-11-18 21:32:24'),
(16, 14, 4, 2, NULL, 2, 'test', NULL, '2020-11-18 21:57:27', '2020-11-19 21:01:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `visit_price`
--

CREATE TABLE `visit_price` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
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

INSERT INTO `visit_price` (`id`, `visit_id`, `price_cash`, `price_card`, `price_transfer`, `sale`, `price_payment`, `add_date`) VALUES
(1, 1, '2000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:16:28'),
(2, 10, '100000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:16:41'),
(3, 2, '200.0', NULL, NULL, NULL, NULL, '2020-11-18 16:16:47'),
(4, 8, '23434.0', NULL, NULL, NULL, NULL, '2020-11-18 16:16:56'),
(5, 12, '2000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:20:56'),
(6, 3, '200.0', NULL, NULL, NULL, NULL, '2020-11-18 16:21:04'),
(7, 13, '40000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:24:55'),
(8, 15, '2000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:30:43'),
(9, 16, '20000.0', NULL, NULL, NULL, NULL, '2020-11-18 16:57:51');

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
  `completed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `visit_service`
--

INSERT INTO `visit_service` (`id`, `visit_id`, `service_id`, `priced`, `report`, `completed`) VALUES
(1, 1, 7, '2020-11-18 21:16:28', '<p>Все нормально</p>\r\n', 1),
(2, 2, 6, '2020-11-18 21:16:47', '<p>Отреза ногу ему она больше не нужна, Теперь в место неё палка которую я отобрал у собаки на улицы.</p>\r\n\r\n<p>Вызжал на лбу немецкую зигу, он очень просил.</p>\r\n', 1),
(3, 3, 6, '2020-11-18 21:21:04', NULL, NULL),
(4, 4, 2, NULL, NULL, NULL),
(5, 5, 1, NULL, NULL, NULL),
(6, 6, 1, NULL, NULL, NULL),
(7, 7, 1, NULL, NULL, NULL),
(8, 8, 2, '2020-11-18 21:16:56', '<p>состояние нормальное</p>\r\n\r\n<p>зуб вырван</p>\r\n', 1),
(9, 9, 1, NULL, NULL, NULL),
(10, 10, 5, '2020-11-18 21:16:41', NULL, NULL),
(11, 11, 1, NULL, NULL, NULL),
(12, 12, 7, '2020-11-18 21:20:56', NULL, NULL),
(13, 13, 9, '2020-11-18 21:24:55', '<p>Орезал не нужные детали, и пришил что надо</p>\r\n', 1),
(14, 14, 1, NULL, NULL, NULL),
(15, 15, 7, '2020-11-18 21:30:43', '<p>Ренген проведён успешно</p>\r\n\r\n<p>бракованый зуб</p>\r\n', 1),
(16, 16, 10, '2020-11-18 21:57:51', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `bed_type`
--
ALTER TABLE `bed_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze_type`
--
ALTER TABLE `laboratory_analyze_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `visit_price`
--
ALTER TABLE `visit_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `visit_service`
--
ALTER TABLE `visit_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
