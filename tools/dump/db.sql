-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 30 2020 г., 18:05
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
(13, 1, 2, 1, NULL, '2020-11-28 02:27:22'),
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
  `preparat_id` int(11) DEFAULT NULL,
  `count` smallint(6) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(7, 6, 'Лаборатория', 'Лаборант'),
(8, 5, 'Невропатолог', 'Неропатолог'),
(9, 5, 'Нейрохирург', 'Нейрохирург');

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
(1, 13, 6, 1, NULL, NULL, NULL),
(2, 13, 6, 2, NULL, NULL, NULL),
(3, 14, 7, 1, NULL, NULL, NULL),
(4, 14, 7, 2, NULL, NULL, NULL);

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
(4, 5, 6, 'MRT Головного мозга', '1000.0'),
(5, 5, 2, 'Грыжа диска', '100000.0'),
(6, 5, 2, 'Пункция брюшной полости', '200000.0'),
(7, 5, 6, 'Рентгенография Весь Позвоночника (Задне-передняя/Боковая проекции)', '2000.0'),
(8, 5, 6, 'УЗИ Допплерография каротид', '3000.0'),
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
(5, NULL, 'doc_1', '4d5204a88e9f6e4e6d34292df53464549d51e86c', 'Jayson', 'Brody', 'Faker', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 6, 1, 7, NULL, '2020-11-18 15:57:39'),
(6, NULL, 'doc_2', 'fe0c9097da6e3b417d97100d40c38561c295aeff', 'Фарход', 'Якубов', 'Хврвргврйцгв', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 2, 1, 7, NULL, '2020-11-18 15:58:42'),
(12, 10, NULL, NULL, 'pasient 1', 'pasient 1', 'pasient 1', '2000-12-12', 'Олмазор', 'kjhjkhjkhk', 'nmm,nj,n,n', ',kn,knm,nm,n', '9998989899', 'ajkshdjkashd', 'jhjkh', 1, 15, NULL, 1, 0, 'm,nm,nm,nm,n', '2020-11-18 16:05:52'),
(13, 10, NULL, NULL, 'pasient 2', 'pasient 2', 'pasient 2', '2000-12-12', 'Миробод', 'kjklj', 'kn,knm,n', ',mn,mn,m', '98989898', 'iljiljklj', 'kjkljkl', NULL, 15, NULL, 1, 0, 'm,nm,n', '2020-11-18 16:06:24'),
(14, 2, NULL, NULL, 'Жасур', 'Рахматов', 'Илхомович', '2003-05-08', 'Ромитан', 'AC6453482', 'Хокимиат', 'Глава отдела', '+998934568052', 'Алпомыш', 'Алпомыш', 1, 15, NULL, 1, 0, NULL, '2020-11-18 16:06:53'),
(15, 10, NULL, NULL, 'pasient 3', 'pasient 3', 'pasient 3', '2000-12-12', 'Олмазор', 'jjjkhjk', 'm,nnm,nmbnm', 'nm,m,nm,n', '98098098098', ',jhknjj', 'jjnjjk', NULL, 15, NULL, NULL, 0, 'm,nm,nm,nm,n', '2020-11-18 16:07:03'),
(17, 10, NULL, NULL, 'pasient 4', 'pasient 4', 'pasient 4', '1212-02-11', 'Олмазор', 'kljkljklj', 'kljkljklj', 'ljkljklj', '8909809809', 'iljljklj', 'lkjkljklj', NULL, 15, NULL, NULL, 0, 'lkjlkjkljkl', '2020-11-18 16:07:48'),
(18, 10, NULL, NULL, 'pasient 5', 'pasient 5', 'pasient 5', '2122-03-12', 'Олмазор', 'jkhjkhjk', 'mnm,nm,nm,', 'm,nm,nm,n', '89098098098', 'kjhkljk', 'jkhjkhkjh', NULL, 15, NULL, 1, 0, ',mn,mn,mn', '2020-11-18 16:08:21'),
(21, 2, NULL, NULL, 'Pasient 6', 'Pasient 6', 'Pasient 6', '2019-11-06', 'Чилонзор', 'цуй321112312312', 'Pasient 6', 'Pasient 6', '2132132112312231', 'Pasient 6', 'Pasient 6', NULL, 15, NULL, NULL, 0, 'Pasient 6', '2020-11-18 16:13:53'),
(22, 9, NULL, NULL, 'Алексей', 'Шевцов', 'Владимирович', '1999-11-24', 'Юнусобод', 'WE324234234', 'Ютуб', 'Блогер', '+998990989078', 'Украина Одесса', 'Украина Одесса', 1, 15, NULL, NULL, 0, 'Глупые люди', '2020-11-18 16:15:37'),
(29, NULL, 'doc_h', '8171857a4e3fbc786dd873feb372a6189166f891', 'doc_h', 'doc_h', 'doc_h', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, 1, 10, NULL, '2020-11-27 17:12:42'),
(30, NULL, 'nurce_1', 'c000e8b0a3f6e91f586867365618581675fa20d7', 'nurce', 'nurce', 'nurce', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, 1, 1, NULL, '2020-11-28 08:23:45');

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
  `division_id` int(11) DEFAULT NULL,
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

INSERT INTO `visit` (`id`, `user_id`, `grant_id`, `parent_id`, `route_id`, `division_id`, `service_id`, `bed_id`, `direction`, `status`, `laboratory`, `complaint`, `failure`, `report_title`, `report_description`, `report_conclusion`, `add_date`, `accept_date`, `priced_date`, `discharge_date`, `completed`) VALUES
(1, 12, 6, 6, 2, 2, 9, NULL, NULL, NULL, NULL, 'qw', NULL, 'Первичная хирургическая обработка ран (больше 2 см)', 'Ликвидация свища брюшной полости\r\nЛапароскопическая холецистэктомия с наружным дренированием холедоха (НДХ)\r\nЛапаротомическая холецистэктомия с наружным дренированием холедоха (НДХ)\r\nДиагностическая лапаротомия\r\nЛапаротомия. Вскрытие гнойника. Некросеквестроэктомия. Санация и дренирование полости гнойника. Санация и дренирование брюшной полости.\r\nРезекция дивертикула Меккеля\r\nРезекция тонкой кишки с анастомозом конец в конец\r\nРелапаротомия\r\nЛХЭК при Хроническом калькулёзном холецистите\r\nЛХЭК при остром флегмонозном калькулёзном холецистите\r\nЛапаротомия. Холецистэктомия при остром флегмонозном холецистите\r\nЛХЭК при остром гангренозном калькулёзном холецистите с инфильтратом\r\nЛапаротомия. Холецистэктомия при остром гангренозном холецистите с инфильтратом\r\nЭРХПГ + ПСТ\r\nЛапароскопическая холецистэктомия при', 'Эхинококкоз печени 1 — киста до 10см\r\nЭхинококкоз печени 1 — киста больше 10см\r\nЭхинококкоз печени 2 — кисты\r\nЭхинококкоз печени 3 — кисты\r\nГастроэнтероанастомоз с отключением ДПК\r\nГастрэктомия\r\nЛапароскопическая фундопликация+холецистэктомия\r\nЛапаротомия, гепатикоеюноанастамоз\r\nЛапаротомия. Ликвидация гнойного свища печени\r\nПередняя резекция прямой кишки с десцендоректоанастамозом конец в конец\r\nРезекция тонкой кишки с анастомозом конец в конец\r\nАтипичная резекция печени печени 2,3,4 сегментов', '2020-11-30 22:04:06', '2020-11-30 22:08:47', '2020-11-30 22:08:25', NULL, '2020-11-30 22:19:46'),
(2, 14, 6, 6, 2, 2, 1, 19, 1, 2, NULL, 'w', NULL, NULL, NULL, NULL, '2020-11-30 22:05:56', '2020-11-30 22:08:49', NULL, NULL, NULL),
(3, 18, 6, 6, 2, 2, 1, 11, 1, 2, NULL, 'w', NULL, NULL, NULL, NULL, '2020-11-30 22:06:25', '2020-11-30 22:08:51', NULL, NULL, NULL),
(4, 14, 6, 5, 6, 6, 4, NULL, 1, NULL, NULL, 'w', NULL, 'МРТ головного мозга', 'МРТ головного мозга — это неинвазивное исследование, которое подразумевает использование мощных магнитных полей, высокочастотных импульсов, компьютерной системы и программного обеспечения, позволяющих получить детальное изображение мозга. Рентгеновское излучение при МРТ не используется. Именно поэтому на сегодняшний день МРТ — одно из наиболее безопасных и притом очень точных исследований. Качество визуализации при МРТ намного лучше, чем при рентгенологическом или ультразвуковом исследовании, компьютерной томографии. Магнитно-резонансная томография дает возможность обнаружить опухоли, аневризму и другие патологии сосудов, а также некоторые проблемы нервной системы. Словом, возможности метода очень широки. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', 'Несмотря на то, что для разных методов диагностики (рентгеновской, радионуклидной, магнитно-резонансной, ультразвуковой) используются различные физические принципы и источники излучения, их объединяет применение правил математического моделирования при создании изображений. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', '2020-11-30 22:10:59', '2020-11-30 22:11:11', NULL, NULL, '2020-11-30 22:12:27'),
(5, 12, 5, 5, 2, 6, 4, NULL, NULL, 2, NULL, 'qw', NULL, NULL, NULL, NULL, '2020-11-30 22:23:11', '2020-11-30 22:24:52', '2020-11-30 22:24:30', NULL, NULL),
(6, 13, 4, 4, 2, 7, 10, NULL, NULL, 2, NULL, 'qw', NULL, NULL, NULL, NULL, '2020-11-30 22:24:03', '2020-11-30 22:42:54', '2020-11-30 22:41:45', NULL, NULL),
(7, 14, 6, 4, 6, 7, 10, NULL, 1, 2, 1, 'w', NULL, NULL, NULL, NULL, '2020-11-30 22:44:33', '2020-11-30 22:44:56', NULL, NULL, NULL);

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
(3, 6, 3, '20000.0', NULL, NULL, NULL, '2020-11-30 17:41:45');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `investment`
--
ALTER TABLE `investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze`
--
ALTER TABLE `laboratory_analyze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `user_stats`
--
ALTER TABLE `user_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `visit_price`
--
ALTER TABLE `visit_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `wards`
--
ALTER TABLE `wards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
