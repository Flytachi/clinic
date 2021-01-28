-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Янв 28 2021 г., 17:55
-- Версия сервера: 10.5.8-MariaDB
-- Версия PHP: 7.4.14

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
-- Структура таблицы `barcode`
--

CREATE TABLE `barcode` (
  `id` int(11) NOT NULL,
  `barcode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `barcode`
--

INSERT INTO `barcode` (`id`, `barcode`, `status`) VALUES
(1, '123456', 'Invalid'),
(2, '654321', 'Invalid');

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
  `visit_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `method` tinyint(4) DEFAULT NULL,
  `description` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `bypass_date`
--

CREATE TABLE `bypass_date` (
  `id` int(11) NOT NULL,
  `bypass_id` int(11) DEFAULT NULL,
  `bypass_time_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `custom_time` time DEFAULT NULL,
  `date` date NOT NULL,
  `comment` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `completed` tinyint(1) DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `activity` int(11) DEFAULT 0,
  `type_message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `collection`
--

CREATE TABLE `collection` (
  `transaction_id` int(11) NOT NULL,
  `date` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `collection`
--

INSERT INTO `collection` (`transaction_id`, `date`, `name`, `invoice`, `amount`, `remarks`, `balance`) VALUES
(1, '04/05/2017', '', 'IN-3263302', '25', '25', -25),
(2, '04/05/2017', '', 'IN-3304053', '', '', -25);

-- --------------------------------------------------------

--
-- Структура таблицы `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `membership_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prod_name` varchar(550) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expected_date` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 10, 'Радиология', 'Радиолог', 2),
(2, 10, 'МРТ', 'МРТ', 1),
(3, 10, 'Рентген', 'Рентгенолог', 1),
(4, 10, 'МСКТ', 'МСКТ', 1),
(5, 10, 'Маммография', 'Маммограф', 1),
(6, 10, 'УЗИ', 'УЗИ', NULL),
(7, 10, 'ЭКГ', 'ЭКГ', NULL),
(8, 6, 'Лаборатория', 'Лаборант', NULL),
(9, 5, 'Терапия', 'Терапевт', NULL),
(10, 5, 'Хирургия', 'Хирург', NULL),
(11, 5, 'Кардиология', 'Кардиолог', NULL),
(12, 5, 'Инфекционный', 'Инфекционист', NULL),
(13, 5, 'Гинекология', 'Гинеколог', NULL),
(14, 5, 'Неврология', 'Невролог', NULL),
(144, 5, 'Урололгия', 'Уролог', NULL),
(145, 12, 'Физиотерапия', 'Фмзитеропевт', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(9) NOT NULL,
  `goodname` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `shcode` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `goodname`, `shcode`) VALUES
(1, 'Шприц 2 мг 1 шт', NULL),
(2, 'Волшебные таблетки', NULL),
(3, 'Бисопролол 2,5 мг, 5 мг, 10 мг таб. №30\r', NULL),
(4, 'Бисопролол 2,5 мг\r', NULL),
(5, 'Бисопролол 5 мг\r', NULL),
(6, 'Бисопролол 10 мг\r', NULL),
(7, 'Атенолол таблетки 50 мг №30\r', NULL),
(8, 'Нифедипин таблетки 20 мг №30\r', NULL),
(9, 'Магния сульфат р-р д/и 25 % 5 мл №10\r', NULL),
(10, 'Эналаприла малеат табл. 2,5 мг, 5 мг, 10 мг № 20\r', NULL),
(11, 'Бисопролол 2,5 мг\r', NULL),
(12, 'Бисопролол 5 мг\r', NULL),
(13, 'Бисопролол 10 мг\r', NULL),
(14, 'Калия и магния аспарагинат раствор для инфузий 250 мг №1\r', NULL),
(15, 'Амиодарон таблетки 200 мг №30\r', NULL),
(16, 'Дротаверин таблетки 40 мг №50\r', NULL),
(17, 'Клопидогрель таблетки 75 мг №28\r', NULL),
(18, 'Карведилол таблетки 12,5 мг №30\r', NULL),
(19, 'Амлодипин таблетки 5 мг №30\r', NULL),
(20, 'Лозартан таблетки 50 мг №14\r', NULL),
(21, 'Симвастатин таблетки 20 мг №28\r', NULL),
(22, 'Лизиноприл таблетки 10 мг №20\r', NULL),
(23, 'Индапамид таблетки 2,5 мг №10\r', NULL),
(24, 'Аллапинин таблетки 0,025 г №30\r', NULL),
(25, 'Периндоприл капсулы 4 мг №30\r', NULL),
(26, 'Аторвастатин табетки 20 мг №30\r', NULL),
(27, 'Розувастатин таблекти 20 мг №30\r', NULL),
(28, 'Глибенкламид таблетки 1,75 мг, 3,5 мг №50\r', NULL),
(29, 'Бисопролол 1,75 мг\r', NULL),
(30, 'Бисопролол 3,5 мг\r', NULL),
(31, 'Глимепирид таблетки 1 мг, 2 мг, 3 мг, 4 мг №30\r', NULL),
(32, 'Глимепирид таблетки 1 мг\r', NULL),
(33, 'Глимепирид таблетки 2 мг\r', NULL),
(34, 'Глимепирид таблетки 3 мг\r', NULL),
(35, 'Глимепирид таблетки 4 мг\r', NULL),
(36, 'Калий йодид таблетки 100 мкг №100\r', NULL),
(37, 'Метформин таблетки 500 мг, 850 мг, 1000 мг №50\r', NULL),
(38, 'Метформин таблетки 500мг\r', NULL),
(39, 'Пирацетам раствор для инъекций 20% 5 мл №5\r', NULL),
(40, 'Пирацетам капсулы 200 мг №10\r', NULL),
(41, 'Депротеинизированный гемодериват крови телят раствор 40мг/5мл №5\r', NULL),
(42, 'Сульфаметаксазол/триметоприм таблетки 480 мг №10\r', NULL),
(43, 'Доксициклин капсулы 100 мг, 200 мг таблетки №10\r', NULL),
(44, 'таблетки 30 мг №20\r', NULL),
(45, 'сироп Змг/мл;15мг/5мл; 30мг/5мл\r', NULL),
(46, 'раствор для инъекций 7,5мг/мл; 15мг/2мл\r', NULL),
(47, 'Аминофиллин табл. 150 мг №30, раствор для инъекций 2,4% №10\r', NULL),
(48, 'таблетки 150мг №30\r', NULL),
(49, 'раствор для инъекций 2,4% №10\r', NULL),
(50, 'Цетиризин таблетки 5 мг; 10 мг №10\r', NULL),
(51, '﻿Нитроглицерин таблетки 0,5 мг №50\r', NULL),
(52, 'Кислота ацетилсалициловая таб. 500 мг №10\r', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `guides`
--

CREATE TABLE `guides` (
  `id` int(11) NOT NULL,
  `name` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(65,1) NOT NULL DEFAULT 0.0,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `investment`
--

CREATE TABLE `investment` (
  `id` int(11) NOT NULL,
  `pricer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `balance_cash` decimal(65,1) NOT NULL DEFAULT 0.0,
  `balance_card` decimal(65,1) NOT NULL DEFAULT 0.0,
  `balance_transfer` decimal(65,1) NOT NULL DEFAULT 0.0,
  `status` tinyint(1) DEFAULT 1,
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
  `service_id` int(11) DEFAULT NULL,
  `analyze_id` int(11) DEFAULT NULL,
  `result` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `deviation` tinyint(1) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `laboratory_analyze_type`
--

CREATE TABLE `laboratory_analyze_type` (
  `id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `standart_min` float NOT NULL,
  `standart_max` float NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `laboratory_analyze_type`
--

INSERT INTO `laboratory_analyze_type` (`id`, `service_id`, `name`, `code`, `standart_min`, `standart_max`, `unit`, `status`) VALUES
(2, 3, 'АЛаТ', 'ALT', 0, 42, 'U/L', 1),
(3, 3, 'АСаТ', 'AST', 0, 37, 'U/L', 1),
(4, 3, 'Билирубин (общий)', 'TBIL', 0, 21, 'µmol/L', 1),
(6, 3, 'Билирубин (прямой)', 'DBIL', 0, 5.42, 'µmol/L', 1),
(7, 3, 'Билирубин (непрямой)', 'DBIL', 0, 14.4, 'µmol/L', 1),
(8, 3, 'Глюкоза', 'GLU', 4.2, 6.4, 'µmol/L', 1),
(9, 3, 'Холестерин  (общий)', 'CHOL', 0, 5.7, 'µmol/L', 1),
(10, 3, 'Холестерин  ЛПВП', 'HDL', 0.9, 1.42, 'µmol/L', 1),
(11, 3, 'Холестерин  ЛПНП', 'LDL', 2.25, 4.82, 'µmol/L', 1),
(12, 3, 'Триглицериды', 'Trig', 0, 1.71, 'µmol/L', 1),
(13, 3, 'Общ белок', 'TP', 66, 87, 'g/l', 1),
(14, 3, 'Альбумин', 'ALB', 38, 51, 'g/l', 1),
(15, 3, 'Альфа амилаза', 'AMYL', 0, 220, 'U/L', 1),
(16, 3, 'Гликизированный гемоглобин', 'HbA1c', 0, 5.7, '%', 1),
(17, 3, 'Лактатдегидрогеназа', 'LDH', 225, 450, 'U/L', 1),
(18, 3, 'Мочевина', 'UREA UV', 1.7, 8.3, 'µmol/L', 1),
(19, 3, 'Креатинин (муж)', 'CREA', 53, 97, 'µmol/L', 1),
(20, 3, 'Креатинин (жен)', 'CREA', 44, 80, 'µmol/L', 1),
(21, 3, 'Мочевая кислота (муж)', 'URIC', 200, 420, 'µmol/L', 1),
(22, 3, 'Мочевая кислота (жен)', 'URIC', 140, 340, 'µmol/L', 1),
(23, 3, 'Гамма-глутамилтрансфераза (муж)', 'GGT', 11, 61, 'U/L', 1),
(24, 3, 'Гамма-глутамилтрансфераза (жен)', 'GGT', 9, 39, 'µmol/L', 1),
(25, 3, 'Креатининкиназа (муж)', 'CK NAC', 27, 190, 'U/L', 1),
(26, 3, 'Креатининкиназа (жен)', 'CK NAC', 24, 190, 'U/L', 1),
(27, 3, 'Щелочная фосфатаза (муж)', 'ALP', 80, 306, 'U/L', 1),
(28, 3, 'Щелочная фосфатаза (жен)', 'ALP', 64, 306, 'U/L', 1),
(29, 3, 'Щелочная фосфатаза (дети до 15)', 'ALP', 0, 644, 'U/L', 1),
(30, 3, 'Щелочная фосфатаза (Подростки 15-17)', 'ALP', 0, 483, 'U/L', 1),
(31, 3, 'Калий', 'Potassium', 3.6, 5.5, 'µmol/L', 1),
(32, 3, 'Калций', 'CA', 2.02, 2.6, 'µmol/L', 1),
(33, 3, 'Натрий', 'Sodium', 135, 155, 'µmol/L', 1),
(34, 3, 'Магний', 'MG', 1.9, 2.5, 'mg/dl', 1),
(35, 3, 'Фосфор	(дети)', 'Р', 2.5, 5, 'mg/dl', 1),
(36, 3, 'Фосфор	(Взрослые)', 'P', 4, 7, 'mg/dl', 1),
(37, 3, 'Железо (муж)', 'IRON', 10.6, 28.3, 'µmol/L', 1),
(38, 3, 'Железо	(жен)', 'IRON', 6.6, 26, 'µmol/L', 1),
(39, 4, 'Мужчины  20-39 лет', 'TESTO', 9, 38, 'ng/ml', 1),
(40, 4, '40-55 лет', 'TESTO', 6.9, 21, 'ng/ml', 1),
(41, 4, 'старше 55 лет', 'TESTO', 5.9, 18.1, 'ng/ml', 1),
(42, 4, 'Женщины :', 'TESTO', 0, 4.6, 'ng/ml', 1),
(43, 5, 'Мужчины :', 'fTESTO', 4.5, 42, 'pg/ml', 1),
(44, 5, 'Женщины :', 'fTESTO', 0, 4.1, 'pg/ml', 1),
(45, 5, 'Постменопауза :', 'fTESTO', 0.1, 4.7, 'pg/ml', 1),
(46, 6, 'Фолликулярная фаза :', 'LH', 2, 9.5, 'U/L', 1),
(47, 6, 'Овуляции :', 'LH', 10, 45, 'U/L', 1),
(48, 6, 'Лютеинизирующая :', 'LH', 0.5, 17, 'U/L', 1),
(49, 6, 'Мужчины :', 'LH', 1.5, 9, 'U/L', 1),
(50, 7, 'Фолликулярная фаза :', 'FSH', 3, 12, 'U/L', 1),
(51, 7, 'Лютеинизирующая фаза :', 'FSH', 2, 12, 'U/L', 1),
(52, 7, 'Овуляции :', 'FSH', 6, 25, 'U/L', 1),
(53, 7, 'Менопауза :', 'FSH', 10, 150, 'U/L', 1),
(54, 7, 'Мужчин :', 'FSH', 0.8, 25, 'U/L', 1),
(55, 8, 'Мужчины :10-20 лет', 'AMH', 1.3, 140, 'ng/ml', 1),
(56, 8, 'муж &gt;20 лет', 'AMH', 0.8, 14.8, 'ng/ml', 1),
(57, 8, 'Женщины : 18-30 лет', 'AMH', 0.2, 12.6, 'ng/ml', 1),
(58, 8, '31-50 лет', 'AMH', 0.025, 5.1, 'ng/ml', 1),
(59, 8, 'менопауза', 'AMH', 0, 0.4, 'ng/ml', 1),
(60, 9, 'Беременные : 1-й триместр :', 'PRL', 0, 2000, 'UI/L', 1),
(61, 9, 'Беременные : 2-й триместр :', 'PRL', 0, 6000, 'UI/L', 1),
(62, 9, 'Беременные : 3-й триместр :', 'PRL', 0, 10000, 'UI/L', 1),
(63, 9, 'Фазы цикла : Фолликулярная фаза :', 'PRL', 60, 600, 'UI/L', 1),
(64, 9, 'Фазы цикла : Лютеинизирующая фаза :', 'PRL', 120, 900, 'UI/L', 1),
(65, 9, 'Фазы цикла : Менопауза :', 'PRL', 40, 550, 'UI/L', 1),
(66, 9, 'Мужчины :', 'PRL', 60, 560, 'UI/L', 1),
(67, 10, 'Мужчин :', 'PROG', 0.1, 1.37, 'ng/ml', 1),
(68, 10, 'Фолликулярная фаза :', 'PROG', 0.19, 1.46, 'ng/ml', 1),
(69, 10, 'Лютеинизирующая фаза :', 'PROG', 2.39, 25.4, 'ng/ml', 1),
(70, 10, 'менопауза', 'PROG', 0.1, 0.73, 'ng/ml', 1),
(71, 11, 'Мужчин :', 'E2', 0.029, 0.3, 'nmol/l', 1),
(72, 11, 'Фолликулярная фаза :', 'E2', 0.05, 0.7, 'nmol/l', 1),
(73, 11, 'Лютеинизирующая фаза :', 'E2', 0.1, 1.1, 'nmol/l', 1),
(74, 11, 'Овуляция :', 'E2', 0.34, 1.8, 'nmol/l', 1),
(75, 11, 'Менопауза :', 'E2', 0, 0.23, 'nmol/l', 1),
(76, 12, 'Кортизол', 'CORT', 140, 600, 'nmol/l', 1),
(77, 13, 'Жен', 'T4', 60, 160, 'nmol/l', 1),
(78, 13, 'Муж', 'T4', 60, 135, 'nmol/l', 1),
(79, 15, 'Трийодтиронин', 'T3', 1.2, 3.2, 'nmol/l', 1),
(80, 16, 'Свободный Трийодтиронин', 'fT3', 2.5, 5.8, 'pgmol/l', 1),
(81, 17, 'До 60 лет :', 'fT4', 10, 25, 'pmol/l', 1),
(82, 17, 'Старше 60 лет', 'fT4', 10, 21, 'pmol/l', 1),
(83, 18, 'Тиреотропный гормон', 'THS', 0.3, 4, 'mlU/l', 1),
(84, 19, 'Мужчины :', 'DHEA-S', 1, 4.2, 'μg/ml', 1),
(85, 19, 'Дети : 1-5 лет :', 'DHEA-S', 0, 0.3, 'μg/ml', 1),
(86, 19, 'Дети : 6-11 лет :', 'DHEA-S', 0.1, 1.5, 'μg/ml', 1),
(87, 19, 'Дети : 12-17 лет :', 'DHEA-S', 0.3, 5.5, 'μg/ml', 1),
(88, 19, 'Постменопауза :', 'DHEA-S', 0.1, 0.6, 'μg/ml', 1),
(89, 19, 'Период беремен :', 'DHEA-S', 0.2, 1.2, 'μg/ml', 1),
(90, 19, 'Предменопауза :', 'DHEA-S', 0.8, 3.9, 'μg/ml', 1),
(91, 20, 'Женщины :', 'АТ-ТПО', 0, 30, 'UI/L', 1),
(92, 20, 'Женщины &gt;50 лет :', 'АТ-ТПО', 0, 50, 'UI/L', 1),
(93, 20, 'Мужчины :', 'АТ-ТПО', 0, 30, 'UI/L', 1),
(94, 21, 'Мужчины', 'АТ-TГ', 0, 100, 'UI/L', 1),
(95, 21, 'Женщины', 'АТ-TГ', 0, 100, 'UI/L', 1),
(96, 21, 'Старше 50 лет :', 'АТ-TГ', 0, 150, 'UI/L', 1),
(97, 22, 'Новорожденные', 'GH EIA', 20, 80, 'mlU/l', 1),
(98, 22, 'Дети', 'GH EIA', 2, 20, 'mlU/l', 1),
(99, 22, 'Взрослые', 'GH EIA', 0, 20, 'mlU/l', 1),
(100, 23, 'возраст 3-8 лет:', 'IGF-1', 20, 250, 'ng/ml', 1),
(101, 23, 'возраст 11-16 лет:', 'IGF-1', 130, 600, 'ng/ml', 1),
(102, 23, 'взрослые после пол.созревания:', 'IGF-1', 150, 350, 'ng/ml', 1),
(103, 24, 'АКТГ', 'ACTH', 7, 63, 'пг/мл', 1),
(104, 25, 'Парат гормон', 'PTH', 18.5, 88, 'пг/мл', 1),
(105, 26, 'Дети', '17-OH-PROG', 0.1, 2.7, 'nmol/l', 1),
(106, 26, 'Мужчины', '17-OH-PROG', 0.2, 6, 'nmol/l', 1),
(107, 26, 'Женщины', '17-OH-PROG', 0.1, 8.7, 'nmol/l', 1),
(108, 26, 'Фоликулярная фаза', '17-OH-PROG', 0.2, 2.4, 'nmol/l', 1),
(109, 26, 'Лютеиновая фаза', '17-OH-PROG', 0.9, 8.7, 'nmol/l', 1),
(110, 26, 'Менопауза', '17-OH-PROG', 0.12, 7, 'nmol/l', 1),
(111, 27, 'ҳомиладор бўлмаган аёлларда :', 'hCG', 0, 5, 'UI/L', 1),
(112, 27, 'эркакларда :', 'hCG', 0, 5, 'UI/L', 1),
(113, 27, 'Беременные : 1- неделя', 'hCG', 10, 30, 'UI/L', 1),
(114, 27, 'Беременные : 2- неделя', 'hCG', 30, 100, 'UI/L', 1),
(115, 27, 'Беременные: 3- неделя', 'hCG', 100, 1000, 'UI/L', 1),
(116, 27, 'Беременные: 4- неделя', 'hCG', 1000, 10000, 'UI/L', 1),
(117, 27, 'Беременные : 2-3 месяц', 'hCG', 30000, 100000, 'UI/L', 1),
(118, 27, 'Беременные: 2-триместр', 'hCG', 10000, 30000, 'UI/L', 1),
(119, 27, 'Беременные: 3-триместр', 'hCG', 5000, 15000, 'UI/L', 1),
(120, 28, 'Аутоимун антитело IgG', 'ds ДНК', 0, 25, 'МЕ/мл', 1),
(121, 29, 'Витамин D', 'Vit D', 20, 50, 'ng/ml', 1),
(122, 30, 'Лямблия', 'Giardia.I', 0, 0.926, 'IgG', 1),
(123, 31, 'Эхинокок', 'Echinococcus', 0, 0.311, 'IgG', 1),
(124, 32, 'Трихинелла', 'Trichinella sp', 0, 0.322, 'IgG', 1),
(125, 33, 'Аскарида', 'Ascaris.L', 0, 0.451, 'IgG', 1),
(126, 34, 'Токсокар', 'Toxocariasis', 0, 0.296, 'IgG', 1),
(127, 35, 'Описторхис', 'Opistorchis fel', 0, 0.243, 'IgG', 1),
(128, 36, 'Глюкоза в крови (экспр)', 'GLU', 3.3, 5.5, 'mmol/L', 1),
(129, 37, 'D-Димер', 'D-dimer', 0, 500, 'нг/мл', 1),
(130, 38, 'Гепатит А', 'HAV IgM', 0, 0.236, 'IgM', 1),
(131, 39, 'Вирус гепатита &quot;В&quot;', 'HbsAg', 0, 0.489, 'IgG', 1),
(132, 40, 'Вирус гепатита &quot;С&quot;', 'HCVAg', 0, 0.248, 'IgG', 1),
(133, 41, 'Вирус гепатита &quot;D&quot;', 'HDVAg', 1601, 0, 'IgG', 1),
(134, 42, 'Cytomegalovirus	lgG', 'CMV', 0, 0.289, 'IgG', 1),
(135, 43, 'Herpes simplex virus –I,II', 'HSV', 0, 0.317, 'IgG', 1),
(136, 44, 'Toxoplasma gondii', 'TOXO', 0, 0.329, 'IgG', 1),
(137, 45, 'Rubella', 'RUB', 15.1, 75.3, 'U/ml', 1),
(138, 46, 'Chlamydia  trachomatis', 'CHLAM', 0, 0.294, 'IgG', 1),
(139, 47, 'Ureaplasma urealyticum', 'UREA', 0, 0.315, 'IgG', 1),
(140, 48, 'Mycoplasma hominis', 'MYCO', 0, 0.301, 'IgG', 1),
(141, 49, 'Helicobacter Pylori', 'H.pylori', 0, 0.343, 'IgG', 1),
(142, 50, 'Туберкулёзный-АГ', 'AT-Tub', 0, 0.171, 'IgG', 1),
(143, 51, 'Cytomegalovirus  Ig M', 'CMV Ig M', 0, 0.312, 'IgM', 1),
(144, 52, 'Herpes simplex virus –I,II  Ig M', 'HSV Ig M', 0, 0.278, 'IgM', 1),
(145, 53, 'Toxoplasma gondii  Ig M', 'TOXO Ig M', 0, 0.215, 'IgM', 1),
(146, 54, 'Rubella Ig M', 'RUB Ig M', 0, 0.267, 'IgM', 1),
(147, 55, 'Micoplasma hominis  Ig M', 'MYCO Ig M', 0, 0.343, 'IgM', 1),
(148, 56, 'Ureaplasma urealyticum  Ig M', 'UREA Ig M', 0, 0.236, 'IgM', 1),
(149, 57, 'Chlamydia  trachomatis Ig M', 'CHLAM Ig M', 0, 0.226, 'IgM', 1),
(150, 58, 'Протромбиновое время', 'PT', 8, 15, 'секунд', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(65,1) NOT NULL DEFAULT 0.0,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `date_text` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` int(11) DEFAULT 0,
  `time_text` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `operation`
--

CREATE TABLE `operation` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `grant_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `oper_date` datetime DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp(),
  `priced_date` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `operation`
--

INSERT INTO `operation` (`id`, `visit_id`, `user_id`, `grant_id`, `parent_id`, `division_id`, `service_id`, `oper_date`, `add_date`, `priced_date`, `completed`) VALUES
(1, 1, 33, 5, 5, 10, 34, '2021-01-27 15:35:00', '2021-01-27 15:29:16', NULL, '2021-01-27 15:59:00');

-- --------------------------------------------------------

--
-- Структура таблицы `operation_inspection`
--

CREATE TABLE `operation_inspection` (
  `id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnostic` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recommendation` varchar(700) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `operation_member`
--

CREATE TABLE `operation_member` (
  `id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `operation_stats`
--

CREATE TABLE `operation_stats` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `time` time NOT NULL,
  `pressure` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pulse` smallint(11) DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `saturation` tinyint(4) DEFAULT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(200) CHARACTER SET utf32 DEFAULT NULL,
  `gen_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `o_price` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profit` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catg` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `onhand_qty` int(10) DEFAULT NULL,
  `qty` int(10) DEFAULT NULL,
  `qty_sold` int(10) DEFAULT NULL,
  `sdate` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `ediz` varchar(56) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `expiry_date` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_arrival` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fakturanumber` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qtyu` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shcod` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `product_code`, `gen_name`, `product_name`, `cost`, `o_price`, `price`, `profit`, `supplier`, `catg`, `onhand_qty`, `qty`, `qty_sold`, `sdate`, `ediz`, `expiry_date`, `date_arrival`, `fakturanumber`, `qtyu`, `shcod`) VALUES
(158, 'Шприц 2 мг 1 шт', 'wqeqwe', '1231232', NULL, '1000', '1030', '30', 'STeam', '3', NULL, 38, NULL, '1231-03-13', 'УП', '2020-12-10', '2020-12-10', '213213', '20', '132132131231231232'),
(159, 'Волшебные таблетки', 'Жасур', '213213', NULL, '5000', '5500', '500', 'STeam', '3', NULL, 40, NULL, '2020-12-04', 'ШТ', '2020-12-18', '2020-12-10', '12312', '2', 'йцуйцуйцу'),
(161, 'Бисопролол 2,5 мг\r\n', '112', '2232', NULL, '4000', '4600', '600', 'STeam', '2', NULL, 42, NULL, '2020-12-02', 'ШТ', '2020-12-10', '2020-12-11', 'wwww', '10', 'qwerqwerwere'),
(162, 'Глимепирид таблетки 1 мг\r\n', 'wwww', 'wwww', NULL, '25000', '28750', '3750', 'STeam', '2', NULL, 67, NULL, '2020-12-10', 'ШТ', '2021-06-18', '2020-12-11', '222', '20', 'wwwww'),
(163, 'Кислота ацетилсалициловая таб. 500 мг №10\r\n', '', 'eee', NULL, '6000', '6900', '900', 'STeam', '2', NULL, 77, NULL, '2020-12-02', 'ШТ', '2020-12-03', '2020-12-10', '3223', '20', 'wewqeqweqw'),
(164, 'Сульфаметаксазол/триметоприм таблетки 480 мг №10\r\n', '2333', 'ww', NULL, '10000', '11500', '1500', 'STeam', '4', NULL, 13, NULL, '2020-12-02', 'ШТ', '2020-12-24', '2020-12-10', 'weewq', '5', 'wwwwwww');

-- --------------------------------------------------------

--
-- Структура таблицы `province`
--

CREATE TABLE `province` (
  `id` int(11) NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `province`
--

INSERT INTO `province` (`id`, `name`) VALUES
(1, 'Ташкент'),
(2, 'Андижанская область'),
(3, 'Бухарская область'),
(4, 'Ферганская область'),
(5, 'Джизакская область'),
(6, 'Наманганская область'),
(7, 'Навоийская область'),
(8, 'Кашкадарьинская область'),
(9, 'Самаркандская область'),
(10, 'Сырдарьинская область'),
(11, 'Сурхандарьинская область'),
(12, 'Хорезмская область'),
(13, 'Республика Каракалпакстан');

-- --------------------------------------------------------

--
-- Структура таблицы `purchases`
--

CREATE TABLE `purchases` (
  `transaction_id` int(11) NOT NULL,
  `invoice_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suplier` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `purchases_item`
--

CREATE TABLE `purchases_item` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `cost` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `region`
--

INSERT INTO `region` (`id`, `province_id`, `name`) VALUES
(1, 1, 'Бектемирский район\r\n'),
(2, 1, 'М.Улугбекский район'),
(3, 1, 'Мирабадский район'),
(4, 1, 'Алмазарский район '),
(5, 1, 'Сергелиский район'),
(6, 1, 'Учтепинский район'),
(7, 1, 'Чиланзарский район\r\n'),
(8, 1, 'Шайхантахурский район'),
(9, 1, 'Юнусабадский район '),
(10, 1, 'Яккасарайский район'),
(11, 1, 'Яшнабадский район'),
(12, 2, 'Андижан (город)'),
(13, 2, 'Ханабад (город)'),
(14, 2, 'Алтынкульский район'),
(15, 2, 'Андижанский район'),
(16, 2, 'Асакинский район'),
(17, 2, 'Балыкчинский район'),
(18, 2, 'Бустанский район'),
(19, 2, 'Булакбашинский район'),
(20, 2, 'Джалакудукский район'),
(21, 2, 'Избасканский район'),
(22, 2, 'Кургантепинский район'),
(23, 2, 'Мархаматский район'),
(24, 2, 'Пахтаабадский район'),
(25, 2, 'Улугнорский район'),
(26, 2, 'Ходжаабадский район'),
(27, 2, 'Ходжаабадский район'),
(28, 2, 'Шахриханский район'),
(29, 3, 'Алатский район'),
(30, 3, 'Бухарский район'),
(31, 3, 'Гиждуванский район'),
(32, 3, 'Жондорский район'),
(33, 3, 'Каганский район '),
(34, 3, 'Каракульский район'),
(35, 3, 'Караулбазарский район '),
(36, 3, 'Пешкунский район'),
(37, 3, 'Ромитанский район '),
(38, 3, 'Шафирканский район'),
(39, 3, 'Вабкентский район '),
(40, 4, 'Алтыарыкский район'),
(41, 4, 'Багдатский'),
(42, 4, 'Бешарыкский район '),
(43, 4, 'Кокандский район'),
(44, 4, 'Кувинский район '),
(45, 4, 'Кудашский район'),
(46, 4, 'Маргеланский район '),
(47, 4, 'Риштанский район'),
(48, 4, 'Ферганский район'),
(49, 5, 'Арнасайский район'),
(50, 5, 'Бахмальский район'),
(51, 5, 'Дустликский район '),
(52, 5, 'Фаришский район '),
(53, 5, 'Галляаральский район '),
(54, 5, 'Шараф-Рашидовский район'),
(55, 5, 'Мирзачульский район'),
(56, 5, 'Пахтакорский район '),
(57, 5, 'Янгиабадский район '),
(58, 5, 'Зааминский район '),
(59, 5, 'Зафарабадский район'),
(60, 5, 'Зарбдарский район '),
(61, 6, 'Касансайский район'),
(62, 6, 'Мингбулакский район'),
(63, 6, 'Наманганский район'),
(64, 6, 'Нарынский район'),
(65, 6, 'Папский район'),
(66, 6, 'Туракурганский район'),
(67, 6, 'Уйчинский район'),
(68, 6, 'Учкурганский район'),
(69, 6, 'Чартакский район'),
(70, 6, 'Чустский район'),
(71, 6, 'Янгикурганский район'),
(72, 7, 'Канимехский район'),
(73, 7, 'Карманинский район'),
(74, 7, 'Кызылтепинский район'),
(75, 7, 'Хатырчинский район'),
(76, 7, 'Навбахорский район'),
(77, 7, 'Нуратинский район '),
(78, 7, 'Тамдынский район'),
(79, 7, 'Учкудукский район '),
(80, 8, 'Чиракчинский район'),
(81, 8, 'Дехканабадский район'),
(82, 8, 'Гузарский район'),
(83, 8, 'Камашинский район'),
(84, 8, 'Каршинский район '),
(85, 8, 'Касанский район'),
(86, 8, 'Касбийский район'),
(87, 8, 'Китабский район'),
(88, 8, 'Миришкорский район '),
(89, 8, 'Мубарекский район '),
(90, 8, 'Нишанский район'),
(91, 8, 'Шахрисабзский район'),
(92, 8, 'Яккабагский район'),
(93, 9, 'Булунгурский район '),
(94, 9, 'Иштыханский район '),
(95, 9, 'Джамбайский район '),
(96, 9, 'Каттакурганский район'),
(97, 9, 'Кошрабадский район '),
(98, 9, 'Нарпайский район'),
(99, 9, 'Нурабадский район'),
(100, 9, 'Акдарьинский район'),
(101, 9, 'Пахтачийский район'),
(102, 9, 'Пайарыкский район'),
(103, 9, 'Пастдаргомский район'),
(104, 9, 'Самаркандский район'),
(105, 9, 'Тайлакский район'),
(106, 9, 'Ургутский район '),
(107, 10, 'Акалтынский район'),
(108, 10, 'Баяутский район'),
(109, 10, 'Гулистанский район '),
(110, 10, 'Хавастский район '),
(111, 10, 'Мирзаабадский район'),
(112, 10, 'Сардобинский район'),
(113, 10, 'Сайхунабадский район'),
(114, 10, 'Сырдарьинский район'),
(115, 11, 'Алтынсайский район'),
(116, 11, 'Ангорский район'),
(117, 11, 'Байсунский район'),
(118, 11, 'Бандыханский район'),
(119, 11, 'Денауский район'),
(120, 11, 'Джаркурганский район'),
(121, 11, 'Кизирикский район'),
(122, 11, 'Кумкурганский район'),
(123, 11, 'Музрабадский район'),
(124, 11, 'Сариасийский район'),
(125, 11, 'Термезский район'),
(126, 11, 'Узунский район'),
(127, 11, 'Шерабадский район'),
(128, 11, 'Шурчинский район'),
(129, 12, 'Багатский район'),
(130, 12, 'Гурленский район'),
(131, 12, 'Кошкупырский район '),
(132, 12, 'Ургенчский район'),
(133, 12, 'Хазараспский район '),
(134, 12, 'Ханкинский район'),
(135, 12, 'Хивинский район '),
(136, 12, 'Шаватский район'),
(137, 12, 'Янгиарыкский район'),
(138, 12, 'Янгибазарский район '),
(139, 12, 'Тупраккалинский район '),
(140, 13, 'г. Нукус'),
(141, 13, 'Амударьинский район'),
(142, 13, 'Берунийский район'),
(143, 13, 'Бозатауский район'),
(144, 13, 'Канлыкульский район'),
(145, 13, 'Караузякский район'),
(146, 13, 'Кегейлинский район'),
(147, 13, ' Кунградский район'),
(148, 13, 'Муйнакский район'),
(149, 13, 'Нукусский район'),
(150, 13, 'Тахиаташский район'),
(151, 13, 'Тахтакупырский район'),
(152, 13, 'Турткульский район'),
(153, 13, 'Ходжейлинский район'),
(154, 13, 'Чимбайский район'),
(155, 13, 'Шуманайский район'),
(156, 13, 'Элликкалинский район');

-- --------------------------------------------------------

--
-- Структура таблицы `sales`
--

CREATE TABLE `sales` (
  `transaction_id` int(11) NOT NULL,
  `invoice_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cashier` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profit` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sales_order`
--

CREATE TABLE `sales_order` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profit` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gen_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sales_order`
--

INSERT INTO `sales_order` (`transaction_id`, `user_id`, `product`, `qty`, `amount`, `profit`, `product_code`, `gen_name`, `name`, `price`, `discount`, `add_date`) VALUES
(47, 21, '164', '5', '57500', '7500', 'Сульфаметаксазол/триметоприм таблетки 480 мг №10\r\n', '2333', 'ww', '11500', NULL, '2020-12-29 21:08:00'),
(48, 14, '163', '2', '13800', '1800', 'Кислота ацетилсалициловая таб. 500 мг №10\r\n', '', 'eee', '6900', NULL, '2020-12-29 21:10:22'),
(49, 14, '158', '1', '1030', '30', 'Шприц 2 мг 1 шт', 'wqeqwe', '1231232', '1030', NULL, '2020-12-29 21:12:07'),
(50, 14, '161', '3', '13800', '1800', 'Бисопролол 2,5 мг\r\n', '112', '2232', '4600', NULL, '2021-01-09 21:07:48'),
(51, 14, '162', '3', '86250', '11250', 'Глимепирид таблетки 1 мг\r\n', 'wwww', 'wwww', '28750', NULL, '2021-01-09 21:07:49'),
(52, 14, '163', '3', '20700', '2700', 'Кислота ацетилсалициловая таб. 500 мг №10\r\n', '', 'eee', '6900', NULL, '2021-01-09 21:07:49'),
(53, 14, '162', '2', '57500', '7500', 'Глимепирид таблетки 1 мг\r\n', 'wwww', 'wwww', '28750', NULL, '2021-01-16 15:53:13'),
(54, 14, '163', '2', '13800', '1800', 'Кислота ацетилсалициловая таб. 500 мг №10\r\n', '', 'eee', '6900', NULL, '2021-01-16 15:53:13'),
(55, 14, '162', '1', '28750', '3750', 'Глимепирид таблетки 1 мг\r\n', 'wwww', 'wwww', '28750', NULL, '2021-01-18 17:42:15'),
(56, 14, '163', '1', '6900', '900', 'Кислота ацетилсалициловая таб. 500 мг №10\r\n', '', 'eee', '6900', NULL, '2021-01-18 17:42:15'),
(57, 14, '158', '1', '1030', '30', 'Шприц 2 мг 1 шт', 'wqeqwe', '1231232', '1030', NULL, '2021-01-18 17:43:04'),
(58, 21, '164', '2', '23000', '3000', 'Сульфаметаксазол/триметоприм таблетки 480 мг №10\r\n', '2333', 'ww', '11500', NULL, '2021-01-20 09:57:55');

-- --------------------------------------------------------

--
-- Структура таблицы `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `user_level` tinyint(4) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `code` varchar(30) DEFAULT NULL,
  `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `price` decimal(65,1) DEFAULT NULL,
  `type` smallint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `service`
--

INSERT INTO `service` (`id`, `user_level`, `division_id`, `code`, `name`, `price`, `type`) VALUES
(1, 1, NULL, NULL, 'Стационарный Осмотр', NULL, 101),
(2, 12, 145, NULL, 'Массаж спины', '50000.0', 1),
(3, 6, 8, NULL, 'Биохимический анализ крови', '45000.0', 1),
(4, 6, 8, NULL, 'Тестостерон', '38000.0', 1),
(5, 6, 8, NULL, 'Своб. Тестостерон', '37000.0', 1),
(6, 6, 8, NULL, 'Лютеинизирующий гормон (ЛГ)', '37000.0', 1),
(7, 6, 8, NULL, 'Фолликулостимулирующий (ФСГ)', '37000.0', 1),
(8, 6, 8, NULL, 'Антимюллер гормон', '270000.0', 1),
(9, 6, 8, NULL, 'Пролактин', '38000.0', 1),
(10, 6, 8, 'PROG', 'Прогестерон', '42000.0', 1),
(11, 6, 8, NULL, 'Эстрадиол', '37000.0', 1),
(12, 6, 8, NULL, 'Кортизол', '37000.0', 1),
(13, 6, 8, NULL, 'Тироксин (T4)', '38000.0', 1),
(15, 6, 8, NULL, 'Трийодтиронин ( T3)', '38000.0', 1),
(16, 6, 8, NULL, 'Свободный Трийодтиронин  (fT3)', '39000.0', 1),
(17, 6, 8, NULL, 'Свободный Тироксин  (fT4)', '37000.0', 1),
(18, 6, 8, NULL, 'Тиреотропный гормон  (ТТГ)', '38000.0', 1),
(19, 6, 8, NULL, 'Дегидроэпиандростерон -Сульфата (ДГАЭС)', '43000.0', 1),
(20, 6, 8, NULL, 'Аутоантител к тиреопероксидазе (ТПО)', '40000.0', 1),
(21, 6, 8, NULL, 'Антитело к треоглобулину (Анти-ТГ)', '40000.0', 1),
(22, 6, 8, NULL, 'Гормон Роста', '52000.0', 1),
(23, 6, 8, NULL, 'Инсулиноподобный фактор (ИФР-1)', '145000.0', 1),
(24, 6, 8, NULL, 'АКТГ', '145000.0', 1),
(25, 6, 8, NULL, 'Парат гормон', '150000.0', 1),
(26, 6, 8, NULL, '17-ОН-Прогестерон', '42000.0', 1),
(27, 6, 8, NULL, 'Хорионический Гонадотропин Человека', '35000.0', 1),
(28, 6, 8, NULL, 'Аутоимун антитело IgG', '45000.0', 1),
(29, 6, 8, NULL, 'Витамин D', '120000.0', 1),
(30, 6, 8, NULL, 'Лямблия', '28000.0', 1),
(31, 6, 8, NULL, 'Эхинокок', '25000.0', 1),
(32, 6, 8, NULL, 'Трихинелла', '20000.0', 1),
(33, 6, 8, NULL, 'Аскарида', '28000.0', 1),
(34, 6, 8, NULL, 'Токсокар', '20000.0', 1),
(35, 6, 8, NULL, 'Описторхис', '28000.0', 1),
(36, 6, 8, NULL, 'Глюкоза в крови (экспр)', '7000.0', 1),
(37, 6, 8, NULL, 'D-Димер', '90000.0', 1),
(38, 6, 8, NULL, 'Гепатит А', '30000.0', 1),
(39, 6, 8, NULL, 'Вирус гепатита &quot;В&quot;', '20000.0', 1),
(40, 6, 8, NULL, 'Вирус гепатита &quot;С&quot;', '20000.0', 1),
(41, 6, 8, NULL, 'Вирус гепатита &quot;D&quot;', '30000.0', 1),
(42, 6, 8, NULL, 'Cytomegalovirus', '27000.0', 1),
(43, 6, 8, NULL, 'Herpes simplex virus –I,II		lgG', '27000.0', 1),
(44, 6, 8, NULL, 'Toxoplasma gondii		lgG', '27000.0', 1),
(45, 6, 8, NULL, 'Rubella		lgG', '27000.0', 1),
(46, 6, 8, NULL, 'Chlamydia  trachomatis lgG', '27000.0', 1),
(47, 6, 8, NULL, 'Ureaplasma urealyticum		lgG', '30000.0', 1),
(48, 6, 8, NULL, 'Mycoplasma hominis  lgG', '30000.0', 1),
(49, 6, 8, NULL, 'Helicobacter Pylori', '48000.0', 1),
(50, 6, 8, NULL, 'Туберкулёзный-АГ', '40000.0', 1),
(51, 6, 8, NULL, 'Cytomegalovirus  Ig M', '30000.0', 1),
(52, 6, 8, NULL, 'Herpes simplex virus –I,II  Ig M', '30000.0', 1),
(53, 6, 8, NULL, 'Toxoplasma gondii  Ig M', '30000.0', 1),
(54, 6, 8, NULL, 'Rubella Ig M', '30000.0', 1),
(55, 6, 8, NULL, 'Micoplasma hominis  Ig M', '33000.0', 1),
(56, 6, 8, NULL, 'Ureaplasma urealyticum  Ig M', '33000.0', 1),
(57, 6, 8, NULL, 'Chlamydia  trachomatis Ig M', '30000.0', 1),
(58, 6, 8, NULL, 'Протромбиновое время', '8000.0', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `storage_orders`
--

CREATE TABLE `storage_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `preparat_id` int(11) NOT NULL,
  `qty` smallint(6) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `storage_preparat`
--

CREATE TABLE `storage_preparat` (
  `id` int(11) NOT NULL,
  `division_id` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `preparat_id` int(11) NOT NULL,
  `preparat_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_qty` int(11) NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` decimal(10,1) NOT NULL DEFAULT 0.0,
  `amount` decimal(10,1) DEFAULT 0.0,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Структура таблицы `supliers`
--

CREATE TABLE `supliers` (
  `suplier_id` int(11) NOT NULL,
  `suplier_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `suplier_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suplier_contact` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `note` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsh` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mf` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inn` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `supliers`
--

INSERT INTO `supliers` (`suplier_id`, `suplier_name`, `suplier_address`, `suplier_contact`, `contact_person`, `note`, `rsh`, `bank`, `mf`, `inn`) VALUES
(15, 'STeam', 'STeam', 'STeam', '1232132131212', '312312312', '31232', '1312321', '12321312', '12321312');

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
  `resident` tinyint(1) DEFAULT NULL,
  `room` smallint(6) DEFAULT NULL,
  `token_telegramm` varchar(250) DEFAULT NULL,
  `add_date` datetime(6) DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `parent_id`, `username`, `password`, `first_name`, `last_name`, `father_name`, `dateBith`, `region`, `passport`, `placeWork`, `position`, `numberPhone`, `residenceAddress`, `registrationAddress`, `gender`, `user_level`, `division_id`, `status`, `share`, `resident`, `room`, `token_telegramm`, `add_date`) VALUES
(1, NULL, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Jasur', 'Rakhmatov', 'Ilhomovich', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 99.1, NULL, NULL, NULL, '2020-10-31 22:48:15.000000'),
(2, NULL, 'reg', 'e06b95860a6082ae37ef08874f8eb5fade2549da', 'Регистратура', 'Регистратура', 'xxx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 0, NULL, NULL, NULL, '2020-11-08 19:03:49.000000'),
(3, NULL, 'kassa', '913c8fd5abbf64f58c66b63dd31f6c310c757702', 'kassa', 'kassa', 'kassa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, 10, NULL, NULL, NULL, '2020-11-18 20:55:30.000000'),
(4, NULL, 'main', 'b28b7af69320201d1cf206ebf28373980add1451', 'врач', 'главный', 'xxx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, 5, NULL, 1, NULL, '2020-12-04 17:36:43.000000'),
(5, NULL, 'doc_xirurg', '6f0d864cd22ec68deaa7b2c6e84420f7f8515825', 'Шариф', 'Ахмедов', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 10, NULL, 15, NULL, 2, NULL, '2020-12-05 05:00:29.000000'),
(6, NULL, 'laboratory', '80240dcecd105d50195cce7a318413dc013733e3', 'Дилноза', 'Шарипова', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 8, NULL, 12, NULL, 3, NULL, '2020-12-05 05:01:19.000000'),
(7, NULL, 'mrt', 'f2b83e490eacf0abfbda89413282a3744dc9a2b8', 'Давид', 'Нагараев', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 2, NULL, 20, NULL, 3, NULL, '2020-12-05 05:01:55.000000'),
(8, NULL, 'rentgen', '9928bac9a395fc4d8b99d4cdf9577d2d6e19bdaf', 'Жамшид', 'Рахмонов', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 3, NULL, NULL, NULL, 4, NULL, '2020-12-05 05:02:33.000000'),
(9, NULL, 'uzi', 'f2b545bd0099b1c89c3ef7acd0e4e1e50874bf74', 'Шухрат', 'Аллаёров', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 6, NULL, NULL, NULL, 5, NULL, '2020-12-05 05:03:21.000000'),
(10, NULL, 'kt', '3553b226127e0cccd2bec8c74a70f7d1603f41f9', 'Самандар', 'Файзиев', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 4, NULL, NULL, NULL, 6, NULL, '2020-12-05 05:04:40.000000'),
(11, NULL, 'doc_nevrolog', '9e509e93c9b6f6624b4a1cfb30b636974a4ab57d', 'Дилафруз', 'Ахмедова', 'Баходировна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 14, NULL, 12, NULL, 7, NULL, '2020-12-05 06:11:56.000000'),
(12, NULL, 'doc_ginekolog', '32e27b059f80416a798458f2e67b898f078172a0', 'Гулрух', 'Ахматова', 'Рахматовна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 13, NULL, 5, NULL, 8, NULL, '2020-12-05 06:12:43.000000'),
(14, NULL, 'nurce', '98b8f939651a9c9f10a7a0c83815083e96ae52c9', 'Шамсия', 'Турсунова', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, 0, NULL, NULL, NULL, '2020-12-05 06:14:36.000000'),
(15, 2, NULL, NULL, 'Бемор 1', 'Бемор 1', 'ххх', '2001-12-04', 'Бухарский район', 'АА12345678', 'Химчан', 'ИТ', '998912474353', 'Кучабог 8', 'Рухшобод', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2020-12-05 06:59:59.000000'),
(16, 2, NULL, NULL, 'Бемор-2', 'Бемор-2', 'ххх', '2001-10-03', 'Олмазор', 'АА1234567', 'ААА', 'ААА', '998912474353', 'ААА', 'ААА', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2020-12-05 07:53:03.000000'),
(17, NULL, 'farm', '36a3bbe0659d5cf5e918a70a1da0c90ff6a33ba9', 'farm', 'farm', 'farm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, 1, NULL, NULL, NULL, '2020-12-06 21:30:42.000000'),
(18, NULL, 'radiolog', 'd92ffb3b4c6121a260f303bee9b228ca020786ba', 'doc_rad', 'doc_rad', 'doc_rad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 1, NULL, 3, NULL, 10, NULL, '2020-12-07 17:56:02.000000'),
(19, 2, NULL, NULL, 'qweqwe', 'eqweqw', 'eqweqw', '2020-12-02', 'Ромитан', '21321321312', 'eqweqw', 'eqweqw', '231312321313123', 'eqweqw', 'eqweqw', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2020-12-10 21:01:05.000000'),
(20, 2, NULL, NULL, 'Test', 'Test', 'Test', '2000-12-12', 'Ромитан', 'АА454545', 'аап', 'апапап', '998912474353', 'г .Бухара', 'Кучабох 8', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2020-12-13 15:59:40.000000'),
(21, NULL, 'any', 'c5fe0200d1c7a5139bd18fd22268c4ca8bf45e90', 'any', 'any', 'any', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL, 11, NULL, 11, NULL, '2020-12-22 17:46:42.000000'),
(22, 2, NULL, NULL, 'Tester', 'tester', 'Tester', '2020-12-17', 'Миробод', '001', 'qweqweqw', 'asdasddqwdqwe', '123232131312', 'Tester', 'Tester', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2020-12-23 14:36:57.000000'),
(23, 2, NULL, NULL, 'Нигина', 'Ниязова', 'Иззатуллаевна', '1989-04-13', 'Ромитан', 'АА4578213', 'ПромСтрой Банк', 'Бухгалтер', '998914030104', 'Алпомиш кучаси,13/4 дом 13 кв', 'г.Ташкент р.Яшнабадский ул.Сокин, 5-3', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-08 17:30:04.502855'),
(24, 2, NULL, NULL, 'Регистратура_1', 'Регистратура_1', 'xxx', '2001-12-12', 'Беруний тумани', 'kl;kl;kl', 'kl;k', 'l;kl;', '998974411547', 'l;lk;', 'kl;kl;', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-08 18:04:07.424631'),
(25, 2, NULL, NULL, 'Нигина', 'Виязова', 'Иззатуллаевна', '2000-12-12', 'Юнусабадский район', 'АА4578213', 'ПромСтрой Банк', 'Бухгалтер', '998912456575', 'Алпомиш кучаси,13/4 дом 13 кв', 'г.Ташкент р.Яшнабадский ул.Сокин, 5-3', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 15:49:58.553400'),
(26, 2, NULL, NULL, 'Абдурахмон', 'Абдурахмонов', 'Абдурахмонович', '1993-02-12', 'Бухарский район', 'AC 45215', 'Лукоил', 'инжинер', '998914252123', 'махачкала 4/25', 'махачкала 4/25', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 16:05:20.076527'),
(28, 2, NULL, NULL, 'Рахимжон', 'Рахмижонов', 'Рахимжонович', '1985-02-12', 'М.Улугбекский район', 'AC 45265', 'Хокимият', 'Бухгалтер', '998914582363', 'махачкала 5 / 63', 'махачкала 5 / 63', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 16:08:06.897534'),
(29, 2, NULL, NULL, 'Нигора', 'Нозимова', 'Абдулаевна', '1989-06-09', 'Алтыарыкский район', 'AC 20551', '9 поликниника', 'медсестра', '998912523698', 'очилгул 5 дом', 'очилгул 5 дом', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 16:12:23.530646'),
(32, 2, NULL, NULL, 'test20212', 'test20212', 'test20212', '2000-12-12', 'Сергелиский район', 'AA121232', 'defs', 'sefef', '9989475465465', 'dsd', 'sdvcsdv', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 16:46:57.809933'),
(33, 2, NULL, NULL, '7777', '7777', '7777', '2000-01-12', 'Учтепинский район', 'AA45213613', '354121', '54534', '998975412161', '232', '+6+6', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 20:21:25.743902'),
(34, 2, NULL, NULL, 'fasdf', 'fasdf', 'fasdf', '2021-01-16', 'Бектемирский район', '21', 'fasdf', 'fasdf', '2', 'fasdf', 'fasdf', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 20:25:08.334117'),
(35, 2, NULL, NULL, 'Farxod', 'Yakubov', 'Abdurasulovich', '1988-04-19', 'Бухарский район', 'AA1234567', 'himchan', 'IT', '998912474353', 'Ул.Кучабог', 'Ул.Кучабог 8', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-13 20:14:41.930907'),
(36, 2, NULL, NULL, 'Бэтмен', 'Бэтмобиль', 'Бэтбункер', '1989-01-01', 'Бектемирский район', 'SD 545525', 'БЭТМЕН comporeyshen', 'СУПЕР ГЕРОЙ', '+998914520245', 'Бэтмен сити', 'Бэтмен сити', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-18 18:16:03.300391'),
(37, 2, NULL, NULL, 'плей бой', 'плей боев', 'плей боивич', '1969-02-22', 'Учтепинский район', 'РО 0211222', 'кулб', 'танцор', '+998902522855', 'губмен', 'губмен', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-18 18:18:14.392906'),
(38, 2, NULL, NULL, 'баран', 'баранов', 'бврвнович', '2000-06-05', 'Сергелиский район', 'БА 15241', 'поле', 'травоед', '+998956253322', 'лес', 'лес', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-18 18:54:48.360964'),
(39, NULL, 'fiz', 'b308e7c524d90a2e314a7077beb43ab0b24d7700', 'fiz', 'fiz', 'fiz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, 145, NULL, 13, NULL, 108, NULL, '2021-01-27 18:22:31.813671');

-- --------------------------------------------------------

--
-- Структура таблицы `user_card`
--

CREATE TABLE `user_card` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `weight` float DEFAULT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp(),
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_settings`
--

CREATE TABLE `user_settings` (
  `user_id` int(11) NOT NULL,
  `navbar_fix` tinyint(1) NOT NULL,
  `sidebar_fix` tinyint(1) NOT NULL,
  `night_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `pulse` smallint(11) DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `saturation` tinyint(4) DEFAULT NULL,
  `breath` float DEFAULT NULL,
  `urine` float DEFAULT NULL,
  `description` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
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
  `assist_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `bed_id` int(11) DEFAULT NULL,
  `direction` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `diagnostic` tinyint(1) DEFAULT NULL,
  `laboratory` tinyint(1) DEFAULT NULL,
  `guide_id` int(11) DEFAULT NULL,
  `complaint` varchar(700) DEFAULT NULL,
  `failure` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `report_title` varchar(200) DEFAULT NULL,
  `report_description` text DEFAULT NULL,
  `report_diagnostic` text DEFAULT NULL,
  `report_recommendation` text DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp(),
  `accept_date` datetime DEFAULT NULL,
  `priced_date` datetime DEFAULT NULL,
  `discharge_date` date DEFAULT NULL,
  `completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_inspection`
--

CREATE TABLE `visit_inspection` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnostic` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recommendation` varchar(700) COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_price`
--

CREATE TABLE `visit_price` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pricer_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `price_cash` decimal(65,1) NOT NULL DEFAULT 0.0,
  `price_card` decimal(65,1) NOT NULL DEFAULT 0.0,
  `price_transfer` decimal(65,1) NOT NULL DEFAULT 0.0,
  `sale` float DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `item_type` tinyint(4) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_cost` decimal(65,1) NOT NULL,
  `item_name` varchar(500) NOT NULL,
  `price_date` datetime DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `barcode`
--
ALTER TABLE `barcode`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`);

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
-- Индексы таблицы `bypass_date`
--
ALTER TABLE `bypass_date`
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
-- Индексы таблицы `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Индексы таблицы `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `guides`
--
ALTER TABLE `guides`
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
-- Индексы таблицы `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `operation_inspection`
--
ALTER TABLE `operation_inspection`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `operation_member`
--
ALTER TABLE `operation_member`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `operation_stats`
--
ALTER TABLE `operation_stats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Индексы таблицы `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Индексы таблицы `purchases_item`
--
ALTER TABLE `purchases_item`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Индексы таблицы `sales_order`
--
ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Индексы таблицы `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `storage_orders`
--
ALTER TABLE `storage_orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `storage_preparat`
--
ALTER TABLE `storage_preparat`
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
-- Индексы таблицы `user_card`
--
ALTER TABLE `user_card`
  ADD PRIMARY KEY (`id`);

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
-- Индексы таблицы `visit_inspection`
--
ALTER TABLE `visit_inspection`
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
-- AUTO_INCREMENT для таблицы `barcode`
--
ALTER TABLE `barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `beds`
--
ALTER TABLE `beds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT для таблицы `bypass_date`
--
ALTER TABLE `bypass_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `bypass_preparat`
--
ALTER TABLE `bypass_preparat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `bypass_time`
--
ALTER TABLE `bypass_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `collection`
--
ALTER TABLE `collection`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `guides`
--
ALTER TABLE `guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `investment`
--
ALTER TABLE `investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze`
--
ALTER TABLE `laboratory_analyze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze_type`
--
ALTER TABLE `laboratory_analyze_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT для таблицы `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `operation`
--
ALTER TABLE `operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `operation_inspection`
--
ALTER TABLE `operation_inspection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `operation_member`
--
ALTER TABLE `operation_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `operation_stats`
--
ALTER TABLE `operation_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT для таблицы `province`
--
ALTER TABLE `province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `purchases`
--
ALTER TABLE `purchases`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `purchases_item`
--
ALTER TABLE `purchases_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT для таблицы `sales`
--
ALTER TABLE `sales`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `storage_orders`
--
ALTER TABLE `storage_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `storage_preparat`
--
ALTER TABLE `storage_preparat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT для таблицы `user_card`
--
ALTER TABLE `user_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_stats`
--
ALTER TABLE `user_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_inspection`
--
ALTER TABLE `visit_inspection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_price`
--
ALTER TABLE `visit_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wards`
--
ALTER TABLE `wards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
