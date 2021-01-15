-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Янв 12 2021 г., 16:16
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

--
-- Дамп данных таблицы `beds`
--

INSERT INTO `beds` (`id`, `ward_id`, `bed`, `types`, `user_id`, `add_date`) VALUES
(1, 1, 1, 1, 15, '2020-11-28 02:25:43'),
(2, 1, 2, 1, 23, '2020-11-28 02:27:22'),
(3, 1, 3, 1, NULL, '2020-11-28 02:27:30'),
(4, 1, 4, 1, NULL, '2020-11-28 02:27:43'),
(5, 4, 1, 2, NULL, '2020-11-28 02:29:20'),
(6, 4, 2, 2, NULL, '2020-11-28 02:29:30'),
(7, 5, 1, 2, NULL, '2020-11-28 02:29:39'),
(8, 2, 1, 1, NULL, '2021-01-09 02:12:09');

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
  `activity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `chat`
--

INSERT INTO `chat` (`id`, `id_push`, `id_pull`, `message`, `date`, `time`, `activity`) VALUES
(1, '4', '20', '5', '2021.01.12', '17:23', 0),
(2, '4', '20', '\n', '2021.01.12', '17:23', 0);

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
(144, 5, 'Урололгия', 'Уролог', NULL);

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

--
-- Дамп данных таблицы `guides`
--

INSERT INTO `guides` (`id`, `name`, `price`, `add_date`) VALUES
(1, 'Обл Болинца', '25000.0', '2020-12-28 14:20:28');

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
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `investment`
--

INSERT INTO `investment` (`id`, `pricer_id`, `user_id`, `balance_cash`, `balance_card`, `balance_transfer`, `status`, `add_date`) VALUES
(1, 3, 23, '500000.0', '0.0', '0.0', 1, '2021-01-12 17:27:08');

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

--
-- Дамп данных таблицы `laboratory_analyze`
--

INSERT INTO `laboratory_analyze` (`id`, `user_id`, `visit_id`, `service_id`, `analyze_id`, `result`, `deviation`, `description`) VALUES
(1, 19, 8, 26, 4, '15', NULL, ''),
(2, 19, 8, 26, 5, '12', NULL, ''),
(3, 33, 11, 56, 9, '10', NULL, ''),
(4, 33, 11, 56, 10, '4', 1, ''),
(5, 19, 24, 26, 4, '15', NULL, ''),
(6, 19, 24, 26, 5, '2', 1, ''),
(7, 19, 25, 45, 1, '12', 1, 'плохо'),
(8, 19, 25, 45, 2, '30', NULL, ''),
(9, 19, 25, 45, 3, '80', NULL, ''),
(10, 33, 27, 26, 4, '12', NULL, ''),
(11, 33, 27, 26, 5, '', NULL, ''),
(12, 33, 29, 45, 1, '', NULL, ''),
(13, 33, 29, 45, 2, '', NULL, ''),
(14, 33, 29, 45, 3, '', NULL, ''),
(15, 23, 30, 45, 1, '20', NULL, ''),
(16, 23, 30, 45, 2, '15', NULL, ''),
(17, 23, 30, 45, 3, '60', NULL, ''),
(18, 23, 31, 56, 9, '4', NULL, ''),
(19, 23, 31, 56, 10, '45', NULL, ''),
(20, 26, 35, 45, 1, '25', NULL, ''),
(21, 26, 35, 45, 2, '20', NULL, ''),
(22, 26, 35, 45, 3, '554', NULL, ''),
(23, 26, 33, 26, 4, '', NULL, ''),
(24, 26, 33, 26, 5, '', NULL, ''),
(25, 26, 36, 56, 9, '52', NULL, ''),
(26, 26, 36, 56, 10, '5434', NULL, ''),
(27, 26, 32, 25, 8, '252', NULL, ''),
(28, 19, 37, 25, 8, '45245245', NULL, ''),
(29, 20, 51, 25, 8, '', NULL, ''),
(30, 20, 52, 26, 4, '15', NULL, ''),
(31, 20, 52, 26, 5, '12', NULL, '');

-- --------------------------------------------------------

--
-- Структура таблицы `laboratory_analyze_type`
--

CREATE TABLE `laboratory_analyze_type` (
  `id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `standart_min` float NOT NULL DEFAULT 0,
  `standart_max` float NOT NULL DEFAULT 1,
  `unit` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `laboratory_analyze_type`
--

INSERT INTO `laboratory_analyze_type` (`id`, `service_id`, `name`, `code`, `standart_min`, `standart_max`, `unit`, `status`) VALUES
(1, 45, 'АЛТ', 'lab-07', 20, 40, NULL, 1),
(2, 45, 'АСТ', 'lab-08', 0, 1, NULL, 1),
(3, 45, 'Общий белок', 'lab-09', 0, 1, NULL, 1),
(4, 26, 'ss1', 'RGM', 3.15, 13.5, '%', 1),
(5, 26, 'eeee', '234325', 1.1, 5.1, 'GG', 1),
(8, 25, 'dv', 'vd', 0, 1, NULL, 1),
(9, 56, 'WBC (Лейкоциты)', '1234', 4.2, 10, NULL, 1),
(10, 56, 'RBC (Эритроциты)', '1234', 3.8, 5.2, NULL, 1);

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

--
-- Дамп данных таблицы `members`
--

INSERT INTO `members` (`id`, `name`, `price`, `add_date`) VALUES
(1, 'Вадим Китаец', '50000.0', '2020-12-28 14:15:04');

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

--
-- Дамп данных таблицы `notes`
--

INSERT INTO `notes` (`id`, `parent_id`, `visit_id`, `date_text`, `description`, `status`, `time_text`) VALUES
(45, 5, NULL, '2021-01-07', '12qwe', 1, '12:21');

-- --------------------------------------------------------

--
-- Структура таблицы `pharmacy_category`
--

CREATE TABLE `pharmacy_category` (
  `id` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pharmacy_category`
--

INSERT INTO `pharmacy_category` (`id`, `name`) VALUES
(1, 'Расходный материал'),
(2, 'Таблетки');

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
(158, 'Шприц 2 мг 1 шт', 'wqeqwe', '1231232', NULL, '1000', '1030', '30', 'STeam', '3', NULL, 39, NULL, '1231-03-13', 'УП', '2020-12-10', '2020-12-10', '213213', '20', '132132131231231232'),
(159, 'Волшебные таблетки', 'Жасур', '213213', NULL, '5000', '5500', '500', 'STeam', '3', NULL, 40, NULL, '2020-12-04', 'ШТ', '2020-12-18', '2020-12-10', '12312', '2', 'йцуйцуйцу'),
(161, 'Бисопролол 2,5 мг\r\n', '112', '2232', NULL, '4000', '4600', '600', 'STeam', '2', NULL, 42, NULL, '2020-12-02', 'ШТ', '2020-12-10', '2020-12-11', 'wwww', '10', 'qwerqwerwere'),
(162, 'Глимепирид таблетки 1 мг\r\n', 'wwww', 'wwww', NULL, '25000', '28750', '3750', 'STeam', '2', NULL, 70, NULL, '2020-12-10', 'ШТ', '2021-06-18', '2020-12-11', '222', '20', 'wwwww'),
(163, 'Кислота ацетилсалициловая таб. 500 мг №10\r\n', '', 'eee', NULL, '6000', '6900', '900', 'STeam', '2', NULL, 80, NULL, '2020-12-02', 'ШТ', '2020-12-03', '2020-12-10', '3223', '20', 'wewqeqweqw'),
(164, 'Сульфаметаксазол/триметоприм таблетки 480 мг №10\r\n', '2333', 'ww', NULL, '10000', '11500', '1500', 'STeam', '4', NULL, 15, NULL, '2020-12-02', 'ШТ', '2020-12-24', '2020-12-10', 'weewq', '5', 'wwwwwww');

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
(52, 14, '163', '3', '20700', '2700', 'Кислота ацетилсалициловая таб. 500 мг №10\r\n', '', 'eee', '6900', NULL, '2021-01-09 21:07:49');

-- --------------------------------------------------------

--
-- Структура таблицы `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `user_level` tinyint(4) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `price` decimal(65,1) DEFAULT NULL,
  `type` smallint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `service`
--

INSERT INTO `service` (`id`, `user_level`, `division_id`, `code`, `name`, `price`, `type`) VALUES
(1, 1, NULL, NULL, 'Стационарный Осмотр', NULL, 101),
(2, 10, 2, '4R15', 'МРТ Головного мозга', '100000.0', 1),
(3, 10, 2, NULL, 'Шейный отдел позвоночника', '200000.0', 1),
(4, 10, 2, NULL, 'Грудной отдел позвоночника', '150000.0', 1),
(5, 10, 2, NULL, 'Позвоночный столб', '120000.0', 1),
(6, 10, 2, NULL, 'Правая ключица RT', '130000.0', 1),
(7, 10, 2, NULL, 'Правое предплечье', '150000.0', 1),
(8, 10, 2, NULL, 'Левый коленный сустав LT', '160000.0', 1),
(9, 10, 2, NULL, 'Фораминалный Обзор (Полный)', '180000.0', 1),
(10, 10, 3, NULL, 'Задне-передняя проекция', '60000.0', 1),
(11, 10, 3, NULL, 'Передне-задняя проекция', '60000.0', 1),
(12, 10, 3, NULL, 'Передне-задняя проекция/Боковая', '80000.0', 1),
(13, 10, 3, NULL, 'Оба Ключицы Передне-задняя', '80000.0', 1),
(14, 10, 3, NULL, 'Грудной отдел позвоночника Передне-задняя/Боковая', '100000.0', 1),
(15, 10, 3, NULL, 'Оба Пальцев Передне-задняя/Боковая', '120000.0', 1),
(16, 10, 4, NULL, 'КТ Позвоночный столб 3D', '80000.0', 1),
(17, 10, 4, NULL, 'КТ Правая плечевая кость', '150000.0', 1),
(18, 10, 4, NULL, 'КТ Кости таза', '160000.0', 1),
(19, 10, 4, NULL, 'КТ Левая стопа', '200000.0', 1),
(20, 10, 6, NULL, 'Транскраниальная Допплерография', '80000.0', 1),
(21, 10, 6, NULL, 'Щитовидная железа', '90000.0', 1),
(22, 10, 6, NULL, 'Тромбоз Допплерография (Обе)', '140000.0', 1),
(23, 10, 6, NULL, 'Молочная железа-Щитовидная железа', '150000.0', 1),
(24, 10, 7, NULL, 'ЭКГ', '100000.0', 1),
(25, 6, 8, NULL, 'Электролиты крови', '50000.0', 1),
(26, 6, 8, NULL, 'Общий белок', '30000.0', 1),
(27, 6, 8, NULL, 'Альбумин', '20000.0', 1),
(29, 6, 8, NULL, 'Ревматоидный фактор', '70000.0', 1),
(30, 5, 9, NULL, 'Первичная консультация терапевта', '50000.0', 1),
(31, 5, 9, NULL, 'Вторичная консультация терапевта', '30000.0', 1),
(32, 5, 10, 'e312312', 'Консультация хирурга, первичная', '50000.0', 2),
(33, 5, 10, NULL, 'Консультация хирурга, повторная', '30000.0', 1),
(34, 5, 10, NULL, 'Раны грудной клетки', '60000.0', 1),
(35, 5, 10, NULL, 'Раны промежности (без повреждения кишки)', '15000.0', 1),
(36, 5, 11, NULL, 'Первичная консультация кардиолога', '50000.0', 1),
(37, 5, 11, NULL, 'Вторичная консультация кардиолога', '30000.0', 1),
(38, 5, 12, NULL, 'Прием (осмотр, консультация) врача-инфекциониста', '60000.0', 1),
(39, 5, 12, NULL, 'Исследование уровня  тимоловой пробы в крови', '60000.0', 1),
(40, 5, 13, NULL, 'Первичная консультация гинеколога', '60000.0', 1),
(41, 5, 13, NULL, 'Вторичная консультация гинеколога', '50000.0', 1),
(42, 5, 13, NULL, 'Кольпоскопия', '80000.0', 1),
(43, 5, 14, NULL, 'Первичная консультация невропатолога', '60000.0', 1),
(44, 5, 14, NULL, 'Вторичная консультация детс.невропатолога', '50000.0', 1),
(45, 6, 8, NULL, 'Биохимия', '14000.0', 1),
(52, 5, 11, '4545', 'Первичная консультация кардиолога', '60000.0', 1),
(53, 5, 11, '4546', 'повторный осмотр', '30000.0', 1),
(54, 5, 9, 'DS43', 'Первичная консультация', '100000.0', 1),
(55, 5, 142, 'FG554', 'Первичная консультация', '34000.0', 1),
(56, 6, 8, '1234', 'Общий анализ крови', '100000.0', 1);

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
(1, NULL, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Jasur', 'Rakhmatov', 'Ilhomovich', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 99.1, NULL, NULL, NULL, '2020-10-31 22:48:15.000000'),
(2, NULL, 'reg', 'e06b95860a6082ae37ef08874f8eb5fade2549da', 'Регистратура', 'Регистратура', 'xxx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 1, 0, NULL, NULL, NULL, '2020-11-08 19:03:49.000000'),
(3, NULL, 'kassa', '913c8fd5abbf64f58c66b63dd31f6c310c757702', 'kassa', 'kassa', 'kassa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 1, 10, NULL, NULL, NULL, '2020-11-18 20:55:30.000000'),
(4, NULL, 'main', 'b28b7af69320201d1cf206ebf28373980add1451', 'врач', 'главный', 'xxx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, 1, 5, NULL, 1, NULL, '2020-12-04 17:36:43.000000'),
(5, NULL, 'doc_xirurg', '6f0d864cd22ec68deaa7b2c6e84420f7f8515825', 'Шариф', 'Ахмедов', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 10, 1, 15, NULL, 2, NULL, '2020-12-05 05:00:29.000000'),
(6, NULL, 'laboratory', '80240dcecd105d50195cce7a318413dc013733e3', 'Дилноза', 'Шарипова', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 8, 1, 12, NULL, 3, NULL, '2020-12-05 05:01:19.000000'),
(7, NULL, 'mrt', 'f2b83e490eacf0abfbda89413282a3744dc9a2b8', 'Давид', 'Нагараев', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 2, 1, 20, NULL, 3, NULL, '2020-12-05 05:01:55.000000'),
(8, NULL, 'rentgen', '9928bac9a395fc4d8b99d4cdf9577d2d6e19bdaf', 'Жамшид', 'Рахмонов', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 3, 1, NULL, NULL, 4, NULL, '2020-12-05 05:02:33.000000'),
(9, NULL, 'uzi', 'f2b545bd0099b1c89c3ef7acd0e4e1e50874bf74', 'Шухрат', 'Аллаёров', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 6, 1, NULL, NULL, 5, NULL, '2020-12-05 05:03:21.000000'),
(10, NULL, 'kt', '3553b226127e0cccd2bec8c74a70f7d1603f41f9', 'Самандар', 'Файзиев', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 4, 1, NULL, NULL, 6, NULL, '2020-12-05 05:04:40.000000'),
(11, NULL, 'doc_nevrolog', '9e509e93c9b6f6624b4a1cfb30b636974a4ab57d', 'Дилафруз', 'Ахмедова', 'Баходировна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 14, 1, 12, NULL, 7, NULL, '2020-12-05 06:11:56.000000'),
(12, NULL, 'doc_ginekolog', '32e27b059f80416a798458f2e67b898f078172a0', 'Гулрух', 'Ахматова', 'Рахматовна', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 13, 1, 5, NULL, 8, NULL, '2020-12-05 06:12:43.000000'),
(14, NULL, 'nurce', '98b8f939651a9c9f10a7a0c83815083e96ae52c9', 'Шамсия', 'Турсунова', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, 1, 0, NULL, NULL, NULL, '2020-12-05 06:14:36.000000'),
(15, 2, NULL, NULL, 'Бемор 1', 'Бемор 1', 'ххх', '2001-12-04', 'Бухарский район', 'АА12345678', 'Химчан', 'ИТ', '998912474353', 'Кучабог 8', 'Рухшобод', NULL, 15, NULL, 1, 0, NULL, NULL, NULL, '2020-12-05 06:59:59.000000'),
(16, 2, NULL, NULL, 'Бемор-2', 'Бемор-2', 'ххх', '2001-10-03', 'Олмазор', 'АА1234567', 'ААА', 'ААА', '998912474353', 'ААА', 'ААА', 1, 15, NULL, 1, 0, NULL, NULL, NULL, '2020-12-05 07:53:03.000000'),
(17, NULL, 'farm', '36a3bbe0659d5cf5e918a70a1da0c90ff6a33ba9', 'farm', 'farm', 'farm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, 1, 1, NULL, NULL, NULL, '2020-12-06 21:30:42.000000'),
(18, NULL, 'radiolog', 'd92ffb3b4c6121a260f303bee9b228ca020786ba', 'doc_rad', 'doc_rad', 'doc_rad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 1, 1, 3, NULL, 10, NULL, '2020-12-07 17:56:02.000000'),
(19, 2, NULL, NULL, 'qweqwe', 'eqweqw', 'eqweqw', '2020-12-02', 'Ромитан', '21321321312', 'eqweqw', 'eqweqw', '231312321313123', 'eqweqw', 'eqweqw', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2020-12-10 21:01:05.000000'),
(20, 2, NULL, NULL, 'Test', 'Test', 'Test', '2000-12-12', 'Ромитан', 'АА454545', 'аап', 'апапап', '998912474353', 'г .Бухара', 'Кучабох 8', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2020-12-13 15:59:40.000000'),
(21, NULL, 'any', 'c5fe0200d1c7a5139bd18fd22268c4ca8bf45e90', 'any', 'any', 'any', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL, 11, NULL, 11, NULL, '2020-12-22 17:46:42.000000'),
(22, 2, NULL, NULL, 'Tester', 'tester', 'Tester', '2020-12-17', 'Миробод', '001', 'qweqweqw', 'asdasddqwdqwe', '123232131312', 'Tester', 'Tester', 1, 15, NULL, 1, 0, NULL, NULL, NULL, '2020-12-23 14:36:57.000000'),
(23, 2, NULL, NULL, 'Нигина', 'Ниязова', 'Иззатуллаевна', '1989-04-13', 'Ромитан', 'АА4578213', 'ПромСтрой Банк', 'Бухгалтер', '998914030104', 'Алпомиш кучаси,13/4 дом 13 кв', 'г.Ташкент р.Яшнабадский ул.Сокин, 5-3', NULL, 15, NULL, 1, 0, NULL, NULL, NULL, '2021-01-08 17:30:04.502855'),
(24, 2, NULL, NULL, 'Регистратура_1', 'Регистратура_1', 'xxx', '2001-12-12', 'Беруний тумани', 'kl;kl;kl', 'kl;k', 'l;kl;', '998974411547', 'l;lk;', 'kl;kl;', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-08 18:04:07.424631'),
(25, 2, NULL, NULL, 'Нигина', 'Ниязова', 'Иззатуллаевна', '2000-12-12', 'Избасканский район', 'АА4578213', 'ПромСтрой Банк', 'Бухгалтер', '998912456575', 'Алпомиш кучаси,13/4 дом 13 кв', 'г.Ташкент р.Яшнабадский ул.Сокин, 5-3', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 15:49:58.553400'),
(26, 2, NULL, NULL, 'Абдурахмон', 'Абдурахмонов', 'Абдурахмонович', '1993-02-12', 'Бухарский район', 'AC 45215', 'Лукоил', 'инжинер', '998914252123', 'махачкала 4/25', 'махачкала 4/25', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 16:05:20.076527'),
(28, 2, NULL, NULL, 'Рахимжон', 'Рахмижонов', 'Рахимжонович', '1985-02-12', 'М.Улугбекский район', 'AC 45265', 'Хокимият', 'Бухгалтер', '998914582363', 'махачкала 5 / 63', 'махачкала 5 / 63', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 16:08:06.897534'),
(29, 2, NULL, NULL, 'Нигора', 'Нозимова', 'Абдулаевна', '1989-06-09', 'Алтыарыкский район', 'AC 20551', '9 поликниника', 'медсестра', '998912523698', 'очилгул 5 дом', 'очилгул 5 дом', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 16:12:23.530646'),
(32, 2, NULL, NULL, 'test20212', 'test20212', 'test20212', '2000-12-12', 'Сергелиский район', 'AA121232', 'defs', 'sefef', '9989475465465', 'dsd', 'sdvcsdv', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 16:46:57.809933'),
(33, 2, NULL, NULL, '7777', '7777', '7777', '2000-01-12', 'Учтепинский район', 'AA45213613', '354121', '54534', '998975412161', '232', '+6+6', NULL, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 20:21:25.743902'),
(34, 2, NULL, NULL, 'fasdf', 'fasdf', 'fasdf', '2021-01-16', 'Бектемирский район', '21', 'fasdf', 'fasdf', '2', 'fasdf', 'fasdf', 1, 15, NULL, NULL, 0, NULL, NULL, NULL, '2021-01-09 20:25:08.334117');

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
  `status` tinyint(1) DEFAULT NULL,
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
  `oper_date` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `visit`
--

INSERT INTO `visit` (`id`, `user_id`, `grant_id`, `parent_id`, `route_id`, `assist_id`, `division_id`, `service_id`, `bed_id`, `direction`, `status`, `diagnostic`, `laboratory`, `guide_id`, `complaint`, `failure`, `report_title`, `report_description`, `report_diagnostic`, `report_recommendation`, `add_date`, `accept_date`, `priced_date`, `discharge_date`, `oper_date`, `completed`) VALUES
(5, 19, 5, 5, 2, NULL, 10, 32, NULL, NULL, NULL, NULL, NULL, 1, 'www', NULL, 'Консультация хирурга, первичная', 'xxx', 'xxx', 'cccc', '2021-01-11 20:51:48', '2021-01-11 20:59:01', '2021-01-11 20:55:32', NULL, NULL, '2021-01-11 21:17:31'),
(6, 19, 7, 18, 2, 7, 2, 2, NULL, NULL, 0, NULL, NULL, 1, 'www', NULL, 'МРТ Головного мозга', NULL, NULL, NULL, '2021-01-11 20:51:48', '2021-01-11 20:56:28', '2021-01-11 20:55:32', NULL, NULL, '2021-01-11 21:18:38'),
(7, 19, 5, 5, 2, NULL, 10, 33, NULL, NULL, NULL, NULL, NULL, 1, 'dd', NULL, 'Консультация хирурга, повторная', 'wqe', 'q', 'qweqw', '2021-01-11 21:20:13', '2021-01-11 21:22:35', '2021-01-11 21:20:44', NULL, NULL, '2021-01-11 21:48:21'),
(8, 19, 6, 6, 2, NULL, 8, 26, NULL, NULL, NULL, NULL, 1, 1, 'dd', NULL, NULL, NULL, NULL, NULL, '2021-01-11 21:20:13', '2021-01-11 21:22:10', '2021-01-11 21:20:44', NULL, NULL, '2021-01-11 21:46:50'),
(9, 20, 8, 18, 2, 8, 3, 12, NULL, NULL, 0, NULL, NULL, 1, '231', NULL, 'Передне-задняя проекция/Боковая', 'eqwewq', 'qweqwewq', 'qeqww', '2021-01-11 21:25:24', '2021-01-12 16:34:45', '2021-01-11 21:25:48', NULL, NULL, '2021-01-12 16:35:14'),
(10, 20, 9, 9, 2, NULL, 6, 22, NULL, NULL, 0, NULL, NULL, 1, '231', NULL, 'Тромбоз Допплерография (Обе)', 'eqwewq', 'eqweqwe', 'qweqwe', '2021-01-11 21:25:24', '2021-01-11 21:26:05', '2021-01-11 21:25:48', NULL, NULL, '2021-01-11 21:26:21'),
(11, 33, 6, 6, 2, NULL, 8, 56, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-11 21:53:36', '2021-01-11 21:54:11', '2021-01-11 21:53:53', NULL, NULL, '2021-01-11 21:55:00'),
(12, 19, 5, 5, 2, NULL, 10, 32, NULL, NULL, 2, NULL, NULL, 1, 'wq', NULL, NULL, NULL, NULL, NULL, '2021-01-12 01:42:14', '2021-01-12 15:20:50', '2021-01-12 01:46:22', NULL, NULL, NULL),
(13, 19, 27, 27, 2, NULL, 11, 36, NULL, NULL, 1, NULL, NULL, 1, 'wq', NULL, NULL, NULL, NULL, NULL, '2021-01-12 01:42:14', NULL, '2021-01-12 01:46:22', NULL, NULL, NULL),
(17, 19, NULL, 27, 5, NULL, 11, 53, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 15:56:50', NULL, '2021-01-12 16:24:47', NULL, NULL, NULL),
(18, 19, NULL, 12, 5, NULL, 13, 40, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 15:56:50', '2021-01-12 16:48:44', '2021-01-12 16:24:47', NULL, NULL, NULL),
(22, 19, NULL, 18, 5, 7, 2, 2, NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, 'МРТ Головного мозга', 'eqe', 'qweq', 'q', '2021-01-12 16:06:20', '2021-01-12 16:25:22', '2021-01-12 16:24:47', NULL, NULL, '2021-01-12 17:02:14'),
(23, 19, NULL, 18, 5, 7, 2, 3, NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, 'Шейный отдел позвоночника', 'qeqwe', 'qweqw', 'eqe', '2021-01-12 16:06:20', '2021-01-12 16:25:23', '2021-01-12 16:24:47', NULL, NULL, '2021-01-12 16:25:55'),
(24, 19, NULL, 6, 5, NULL, 8, 26, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:20:17', '2021-01-12 16:26:06', '2021-01-12 16:24:47', NULL, NULL, '2021-01-12 16:26:45'),
(25, 19, NULL, 6, 5, NULL, 8, 45, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:20:17', '2021-01-12 16:26:07', '2021-01-12 16:24:47', NULL, NULL, '2021-01-12 16:26:45'),
(26, 25, 8, 18, 2, 8, 3, 13, NULL, NULL, 0, NULL, NULL, 1, 'dfafsd', NULL, 'Оба Ключицы Передне-задняя', '111111', '11111', '1111', '2021-01-12 16:29:05', '2021-01-12 16:37:27', '2021-01-12 16:36:36', NULL, NULL, '2021-01-12 16:37:48'),
(27, 33, 6, 6, 2, NULL, 8, 26, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:39:04', '2021-01-12 16:44:12', '2021-01-12 16:43:35', NULL, NULL, '2021-01-12 16:44:42'),
(28, 33, 6, 6, 2, NULL, 8, 27, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:39:04', '2021-01-12 16:44:16', '2021-01-12 16:43:35', NULL, NULL, '2021-01-12 16:44:42'),
(29, 33, 6, 6, 2, NULL, 8, 45, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:39:04', '2021-01-12 16:44:18', '2021-01-12 16:43:35', NULL, NULL, '2021-01-12 16:44:42'),
(30, 23, 6, 6, 2, NULL, 8, 45, NULL, NULL, NULL, NULL, 1, NULL, 'gadghdfh', NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:48:09', '2021-01-12 16:49:25', '2021-01-12 16:48:56', NULL, NULL, '2021-01-12 16:53:18'),
(31, 23, 6, 6, 2, NULL, 8, 56, NULL, NULL, NULL, NULL, 1, NULL, 'gadghdfh', NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:48:09', '2021-01-12 16:49:27', '2021-01-12 16:48:56', NULL, NULL, '2021-01-12 16:53:18'),
(32, 26, 6, 6, 2, NULL, 8, 25, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:48:30', '2021-01-12 16:52:59', '2021-01-12 16:49:03', NULL, NULL, '2021-01-12 16:53:08'),
(33, 26, 6, 6, 2, NULL, 8, 26, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:48:30', '2021-01-12 16:51:27', '2021-01-12 16:49:03', NULL, NULL, '2021-01-12 16:51:47'),
(34, 26, 6, 6, 2, NULL, 8, 27, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:48:30', '2021-01-12 16:50:40', '2021-01-12 16:49:03', NULL, NULL, '2021-01-12 16:51:14'),
(35, 26, 6, 6, 2, NULL, 8, 45, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:48:30', '2021-01-12 16:50:42', '2021-01-12 16:49:03', NULL, NULL, '2021-01-12 16:51:14'),
(36, 26, 6, 6, 2, NULL, 8, 56, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:48:30', '2021-01-12 16:51:28', '2021-01-12 16:49:03', NULL, NULL, '2021-01-12 16:51:47'),
(37, 19, 6, 6, 2, NULL, 8, 25, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 16:48:43', '2021-01-12 16:52:59', '2021-01-12 16:49:10', NULL, NULL, '2021-01-12 16:53:13'),
(38, 28, 9, 9, 2, NULL, 6, 20, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Транскраниальная Допплерография', 'vbgfhnfzsg', 'fBDbfbDFb', 'FDSbDAFbzfb', '2021-01-12 16:54:06', '2021-01-12 16:56:43', '2021-01-12 16:54:17', NULL, NULL, '2021-01-12 16:57:15'),
(39, 32, 9, 9, 2, NULL, 6, 21, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Щитовидная железа', '454254', '4524524', '000000000000000000000000000000000', '2021-01-12 16:54:30', '2021-01-12 16:57:40', '2021-01-12 16:55:33', NULL, NULL, '2021-01-12 16:58:27'),
(40, 34, 9, 9, 2, NULL, 6, 23, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Молочная железа-Щитовидная железа', 'wefaaaaaaaa', 'sdf', '5555', '2021-01-12 16:54:45', '2021-01-12 16:57:19', '2021-01-12 16:56:06', NULL, NULL, '2021-01-12 16:58:22'),
(41, 24, 10, 18, 2, 10, 4, 18, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'КТ Кости таза', 'eqw', 'qwewq', 'qweq', '2021-01-12 16:59:09', '2021-01-12 18:59:31', '2021-01-12 16:59:42', NULL, NULL, '2021-01-12 19:33:55'),
(42, 26, 10, 18, 2, 10, 4, 19, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'КТ Левая стопа', 'aw', '2131', '231321312', '2021-01-12 16:59:23', '2021-01-12 18:59:30', '2021-01-12 16:59:51', NULL, NULL, '2021-01-12 19:31:08'),
(43, 22, 7, 18, 2, 7, 2, 4, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Грудной отдел позвоночника', '1221', '2121', '1qw1', '2021-01-12 16:59:51', '2021-01-12 17:01:02', '2021-01-12 17:00:30', NULL, NULL, '2021-01-12 17:01:47'),
(44, 22, 7, 18, 2, 7, 2, 5, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Позвоночный столб', NULL, NULL, NULL, '2021-01-12 16:59:51', '2021-01-12 17:01:04', '2021-01-12 17:00:30', NULL, NULL, '2021-01-12 17:01:58'),
(45, 22, 7, 18, 2, 7, 2, 7, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Правое предплечье', 'qewq', 'wqewqe', 'wqe', '2021-01-12 16:59:51', '2021-01-12 17:01:01', '2021-01-12 17:00:30', NULL, NULL, '2021-01-12 17:01:37'),
(46, 25, 7, 18, 2, 7, 2, 2, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'МРТ Головного мозга', 'ssa', 'qweqwe', 'qwewqeq', '2021-01-12 17:02:32', '2021-01-12 17:03:26', '2021-01-12 17:02:54', NULL, NULL, '2021-01-12 17:04:05'),
(47, 25, 7, 18, 2, 7, 2, 3, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Шейный отдел позвоночника', 'qqq', 'qqqq', 'qqq', '2021-01-12 17:02:32', '2021-01-12 17:03:29', '2021-01-12 17:02:54', NULL, NULL, '2021-01-12 17:04:14'),
(48, 33, 7, 18, 2, 7, 2, 2, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'МРТ Головного мозга', 'qweqweqw', 'eqwewqeqeq', 'qweqweqw', '2021-01-12 17:04:27', '2021-01-12 17:04:42', '2021-01-12 17:04:32', NULL, NULL, '2021-01-12 17:05:31'),
(49, 33, 7, 18, 2, 7, 2, 3, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Шейный отдел позвоночника', 'ewqeq', 'e12121', '21', '2021-01-12 17:04:27', '2021-01-12 17:04:42', '2021-01-12 17:04:32', NULL, NULL, '2021-01-12 17:05:14'),
(50, 33, 7, 18, 2, 7, 2, 4, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Грудной отдел позвоночника', NULL, NULL, NULL, '2021-01-12 17:04:27', '2021-01-12 17:04:41', '2021-01-12 17:04:32', NULL, NULL, '2021-01-12 17:05:24'),
(51, 20, 6, 6, 2, NULL, 8, 25, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 17:16:56', '2021-01-12 17:17:42', '2021-01-12 17:17:14', NULL, NULL, '2021-01-12 20:46:27'),
(52, 20, 6, 6, 2, NULL, 8, 26, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 17:16:56', '2021-01-12 19:49:47', '2021-01-12 17:17:14', NULL, NULL, '2021-01-12 20:46:27'),
(53, 19, 10, 18, 2, 10, 4, 16, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'КТ Позвоночный столб 3D', 'wqeqw', 'eqwe', 'qweqwe21213', '2021-01-12 17:24:05', '2021-01-12 18:59:32', '2021-01-12 17:25:22', NULL, NULL, '2021-01-12 19:34:02'),
(54, 19, 6, 6, 2, NULL, 8, 25, NULL, NULL, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 17:24:05', '2021-01-12 20:46:36', '2021-01-12 17:25:22', NULL, NULL, NULL),
(55, 23, 5, 5, 2, NULL, 10, 1, 2, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 17:26:35', NULL, NULL, NULL, NULL, NULL),
(56, 25, 8, 18, 2, 8, 3, 10, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Задне-передняя проекция', 'qweqwe', 'qweqweqw', 'qweqw', '2021-01-12 19:01:52', '2021-01-12 19:05:32', '2021-01-12 19:02:22', NULL, NULL, '2021-01-12 19:34:10'),
(57, 25, 8, 8, 2, 8, 3, 11, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 19:01:52', '2021-01-12 19:05:37', '2021-01-12 19:02:22', NULL, NULL, NULL),
(58, 25, 8, 8, 2, 8, 3, 12, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 19:01:52', '2021-01-12 19:05:33', '2021-01-12 19:02:22', NULL, NULL, NULL),
(59, 22, 7, 7, 2, NULL, 2, 6, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 19:31:50', NULL, '2021-01-12 19:36:16', NULL, NULL, NULL),
(60, 22, 10, 10, 2, NULL, 4, 16, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 19:31:50', NULL, '2021-01-12 19:36:16', NULL, NULL, NULL),
(61, 22, 6, 6, 2, NULL, 8, 25, NULL, NULL, 2, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-12 19:31:50', '2021-01-12 20:46:37', '2021-01-12 19:36:16', NULL, NULL, NULL);

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
  `status` tinyint(1) DEFAULT NULL,
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_member`
--

CREATE TABLE `visit_member` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_price`
--

CREATE TABLE `visit_price` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `pricer_id` int(11) DEFAULT NULL,
  `price_cash` decimal(65,1) NOT NULL DEFAULT 0.0,
  `price_card` decimal(65,1) NOT NULL DEFAULT 0.0,
  `price_transfer` decimal(65,1) NOT NULL DEFAULT 0.0,
  `sale` tinyint(4) DEFAULT 0,
  `refund` decimal(65,1) NOT NULL DEFAULT 0.0,
  `item_type` tinyint(4) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_cost` decimal(65,1) NOT NULL,
  `item_name` varchar(500) NOT NULL,
  `price_date` datetime DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `visit_price`
--

INSERT INTO `visit_price` (`id`, `visit_id`, `pricer_id`, `price_cash`, `price_card`, `price_transfer`, `sale`, `refund`, `item_type`, `item_id`, `item_cost`, `item_name`, `price_date`, `add_date`) VALUES
(5, 5, 3, '50000.0', '0.0', '0.0', NULL, '0.0', 1, 32, '50000.0', 'Консультация хирурга, первичная', '2021-01-11 20:55:00', '2021-01-11 20:51:48'),
(6, 6, 3, '100000.0', '0.0', '0.0', NULL, '0.0', 1, 2, '100000.0', 'МРТ Головного мозга', '2021-01-11 20:55:00', '2021-01-11 20:51:48'),
(7, 7, 3, '30000.0', '0.0', '0.0', NULL, '0.0', 1, 33, '30000.0', 'Консультация хирурга, повторная', '2021-01-11 21:20:00', '2021-01-11 21:20:13'),
(8, 8, 3, '30000.0', '0.0', '0.0', NULL, '0.0', 1, 26, '30000.0', 'Общий белок', '2021-01-11 21:20:00', '2021-01-11 21:20:13'),
(9, 9, 3, '0.0', '80000.0', '0.0', NULL, '0.0', 1, 12, '80000.0', 'Передне-задняя проекция/Боковая', '2021-01-11 21:25:00', '2021-01-11 21:25:24'),
(10, 10, 3, '0.0', '140000.0', '0.0', NULL, '0.0', 1, 22, '140000.0', 'Тромбоз Допплерография (Обе)', '2021-01-11 21:25:00', '2021-01-11 21:25:24'),
(11, 11, 3, '0.0', '0.0', '100000.0', NULL, '0.0', 1, 56, '100000.0', 'Общий анализ крови', '2021-01-11 21:53:00', '2021-01-11 21:53:36'),
(12, 12, 3, '50000.0', '0.0', '0.0', NULL, '0.0', 1, 32, '50000.0', 'Консультация хирурга, первичная', '2021-01-12 01:46:00', '2021-01-12 01:42:14'),
(13, 13, 3, '50000.0', '0.0', '0.0', NULL, '0.0', 1, 36, '50000.0', 'Первичная консультация кардиолога', '2021-01-12 01:46:00', '2021-01-12 01:42:14'),
(16, 17, 3, '30000.0', '0.0', '0.0', NULL, '0.0', 1, 53, '30000.0', 'повторный осмотр', '2021-01-12 16:24:00', '2021-01-12 15:56:50'),
(17, 18, 3, '60000.0', '0.0', '0.0', NULL, '0.0', 1, 40, '60000.0', 'Первичная консультация гинеколога', '2021-01-12 16:24:00', '2021-01-12 15:56:50'),
(18, 19, NULL, '0.0', '0.0', '0.0', 0, '0.0', 1, 2, '100000.0', 'МРТ Головного мозга', NULL, '2021-01-12 16:03:40'),
(20, 22, 3, '100000.0', '0.0', '0.0', NULL, '0.0', 1, 2, '100000.0', 'МРТ Головного мозга', '2021-01-12 16:24:00', '2021-01-12 16:06:20'),
(21, 23, 3, '200000.0', '0.0', '0.0', NULL, '0.0', 1, 3, '200000.0', 'Шейный отдел позвоночника', '2021-01-12 16:24:00', '2021-01-12 16:06:20'),
(22, 24, 3, '30000.0', '0.0', '0.0', NULL, '0.0', 1, 26, '30000.0', 'Общий белок', '2021-01-12 16:24:00', '2021-01-12 16:20:17'),
(23, 25, 3, '14000.0', '0.0', '0.0', NULL, '0.0', 1, 45, '14000.0', 'Биохимия', '2021-01-12 16:24:00', '2021-01-12 16:20:17'),
(24, 26, 3, '80000.0', '0.0', '0.0', NULL, '0.0', 1, 13, '80000.0', 'Оба Ключицы Передне-задняя', '2021-01-12 16:36:00', '2021-01-12 16:29:05'),
(25, 27, 3, '30000.0', '0.0', '0.0', NULL, '0.0', 1, 26, '30000.0', 'Общий белок', '2021-01-12 16:43:00', '2021-01-12 16:39:04'),
(26, 28, 3, '20000.0', '0.0', '0.0', NULL, '0.0', 1, 27, '20000.0', 'Альбумин', '2021-01-12 16:43:00', '2021-01-12 16:39:04'),
(27, 29, 3, '14000.0', '0.0', '0.0', NULL, '0.0', 1, 45, '14000.0', 'Биохимия', '2021-01-12 16:43:00', '2021-01-12 16:39:04'),
(28, 30, 3, '14000.0', '0.0', '0.0', NULL, '0.0', 1, 45, '14000.0', 'Биохимия', '2021-01-12 16:48:00', '2021-01-12 16:48:09'),
(29, 31, 3, '100000.0', '0.0', '0.0', NULL, '0.0', 1, 56, '100000.0', 'Общий анализ крови', '2021-01-12 16:48:00', '2021-01-12 16:48:09'),
(30, 32, 3, '50000.0', '0.0', '0.0', NULL, '0.0', 1, 25, '50000.0', 'Электролиты крови', '2021-01-12 16:49:00', '2021-01-12 16:48:30'),
(31, 33, 3, '30000.0', '0.0', '0.0', NULL, '0.0', 1, 26, '30000.0', 'Общий белок', '2021-01-12 16:49:00', '2021-01-12 16:48:30'),
(32, 34, 3, '20000.0', '0.0', '0.0', NULL, '0.0', 1, 27, '20000.0', 'Альбумин', '2021-01-12 16:49:00', '2021-01-12 16:48:30'),
(33, 35, 3, '14000.0', '0.0', '0.0', NULL, '0.0', 1, 45, '14000.0', 'Биохимия', '2021-01-12 16:49:00', '2021-01-12 16:48:30'),
(34, 36, 3, '100000.0', '0.0', '0.0', NULL, '0.0', 1, 56, '100000.0', 'Общий анализ крови', '2021-01-12 16:49:00', '2021-01-12 16:48:30'),
(35, 37, 3, '50000.0', '0.0', '0.0', NULL, '0.0', 1, 25, '50000.0', 'Электролиты крови', '2021-01-12 16:49:00', '2021-01-12 16:48:43'),
(36, 38, 3, '80000.0', '0.0', '0.0', NULL, '0.0', 1, 20, '80000.0', 'Транскраниальная Допплерография', '2021-01-12 16:54:00', '2021-01-12 16:54:06'),
(37, 39, 3, '90000.0', '0.0', '0.0', NULL, '0.0', 1, 21, '90000.0', 'Щитовидная железа', '2021-01-12 16:55:00', '2021-01-12 16:54:30'),
(38, 40, 3, '150000.0', '0.0', '0.0', NULL, '0.0', 1, 23, '150000.0', 'Молочная железа-Щитовидная железа', '2021-01-12 16:56:00', '2021-01-12 16:54:45'),
(39, 41, 3, '160000.0', '0.0', '0.0', NULL, '0.0', 1, 18, '160000.0', 'КТ Кости таза', '2021-01-12 16:59:00', '2021-01-12 16:59:09'),
(40, 42, 3, '200000.0', '0.0', '0.0', NULL, '0.0', 1, 19, '200000.0', 'КТ Левая стопа', '2021-01-12 16:59:00', '2021-01-12 16:59:23'),
(41, 43, 3, '0.0', '150000.0', '0.0', NULL, '0.0', 1, 4, '150000.0', 'Грудной отдел позвоночника', '2021-01-12 17:00:00', '2021-01-12 16:59:51'),
(42, 44, 3, '0.0', '120000.0', '0.0', NULL, '0.0', 1, 5, '120000.0', 'Позвоночный столб', '2021-01-12 17:00:00', '2021-01-12 16:59:51'),
(43, 45, 3, '0.0', '150000.0', '0.0', NULL, '0.0', 1, 7, '150000.0', 'Правое предплечье', '2021-01-12 17:00:00', '2021-01-12 16:59:51'),
(44, 46, 3, '100000.0', '0.0', '0.0', NULL, '0.0', 1, 2, '100000.0', 'МРТ Головного мозга', '2021-01-12 17:02:00', '2021-01-12 17:02:32'),
(45, 47, 3, '200000.0', '0.0', '0.0', NULL, '0.0', 1, 3, '200000.0', 'Шейный отдел позвоночника', '2021-01-12 17:02:00', '2021-01-12 17:02:32'),
(46, 48, 3, '0.0', '0.0', '100000.0', NULL, '0.0', 1, 2, '100000.0', 'МРТ Головного мозга', '2021-01-12 17:04:00', '2021-01-12 17:04:27'),
(47, 49, 3, '0.0', '0.0', '200000.0', NULL, '0.0', 1, 3, '200000.0', 'Шейный отдел позвоночника', '2021-01-12 17:04:00', '2021-01-12 17:04:27'),
(48, 50, 3, '0.0', '0.0', '150000.0', NULL, '0.0', 1, 4, '150000.0', 'Грудной отдел позвоночника', '2021-01-12 17:04:00', '2021-01-12 17:04:27'),
(49, 51, 3, '50000.0', '0.0', '0.0', NULL, '0.0', 1, 25, '50000.0', 'Электролиты крови', '2021-01-12 17:17:00', '2021-01-12 17:16:56'),
(50, 52, 3, '30000.0', '0.0', '0.0', NULL, '0.0', 1, 26, '30000.0', 'Общий белок', '2021-01-12 17:17:00', '2021-01-12 17:16:56'),
(51, 53, NULL, '0.0', '0.0', '0.0', 0, '0.0', 1, 16, '80000.0', 'КТ Позвоночный столб 3D', NULL, '2021-01-12 17:24:05'),
(52, 54, 3, '50000.0', '0.0', '0.0', NULL, '0.0', 1, 25, '50000.0', 'Электролиты крови', '2021-01-12 17:25:00', '2021-01-12 17:24:05'),
(53, 56, 3, '0.0', '60000.0', '0.0', NULL, '0.0', 1, 10, '60000.0', 'Задне-передняя проекция', '2021-01-12 19:02:00', '2021-01-12 19:01:52'),
(54, 57, 3, '0.0', '60000.0', '0.0', NULL, '0.0', 1, 11, '60000.0', 'Передне-задняя проекция', '2021-01-12 19:02:00', '2021-01-12 19:01:52'),
(55, 58, 3, '0.0', '80000.0', '0.0', NULL, '0.0', 1, 12, '80000.0', 'Передне-задняя проекция/Боковая', '2021-01-12 19:02:00', '2021-01-12 19:01:52'),
(56, 59, 3, '70000.0', '60000.0', '0.0', NULL, '0.0', 1, 6, '130000.0', 'Правая ключица RT', '2021-01-12 19:36:00', '2021-01-12 19:31:50'),
(57, 60, 3, '80000.0', '0.0', '0.0', NULL, '0.0', 1, 16, '80000.0', 'КТ Позвоночный столб 3D', '2021-01-12 19:36:00', '2021-01-12 19:31:50'),
(58, 61, 3, '50000.0', '0.0', '0.0', NULL, '0.0', 1, 25, '50000.0', 'Электролиты крови', '2021-01-12 19:36:00', '2021-01-12 19:31:50');

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
-- Индексы таблицы `pharmacy_category`
--
ALTER TABLE `pharmacy_category`
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
-- Индексы таблицы `visit_member`
--
ALTER TABLE `visit_member`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `collection`
--
ALTER TABLE `collection`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `guides`
--
ALTER TABLE `guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `investment`
--
ALTER TABLE `investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze`
--
ALTER TABLE `laboratory_analyze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze_type`
--
ALTER TABLE `laboratory_analyze_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT для таблицы `pharmacy_category`
--
ALTER TABLE `pharmacy_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT для таблицы `storage_orders`
--
ALTER TABLE `storage_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `storage_preparat`
--
ALTER TABLE `storage_preparat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `storage_type`
--
ALTER TABLE `storage_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT для таблицы `visit_inspection`
--
ALTER TABLE `visit_inspection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_member`
--
ALTER TABLE `visit_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_price`
--
ALTER TABLE `visit_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `wards`
--
ALTER TABLE `wards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;