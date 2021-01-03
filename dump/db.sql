-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 28 2020 г., 14:04
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
(1, 1, 1, 1, NULL, '2020-11-28 02:25:43'),
(2, 1, 2, 1, NULL, '2020-11-28 02:27:22'),
(3, 1, 3, 1, NULL, '2020-11-28 02:27:30'),
(4, 1, 4, 1, NULL, '2020-11-28 02:27:43'),
(5, 4, 1, 2, NULL, '2020-11-28 02:29:20'),
(6, 4, 2, 2, NULL, '2020-11-28 02:29:30'),
(7, 5, 1, 2, NULL, '2020-11-28 02:29:39');

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

--
-- Дамп данных таблицы `bypass`
--

INSERT INTO `bypass` (`id`, `user_id`, `visit_id`, `parent_id`, `method`, `description`, `update_date`, `add_date`) VALUES
(1, 15, 1, 5, 1, '3 раза', NULL, '2020-12-19 17:06:22'),
(3, 15, 1, 5, 1, '3343344 34423  5254 2 22', NULL, '2020-12-21 15:37:39'),
(4, 15, 1, 5, 1, 'weweqeqw qweq', NULL, '2020-12-21 16:28:55'),
(5, 22, 36, 5, 1, 'wwe', NULL, '2020-12-23 14:55:30');

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

--
-- Дамп данных таблицы `bypass_preparat`
--

INSERT INTO `bypass_preparat` (`id`, `bypass_id`, `preparat_id`, `add_date`) VALUES
(1, 1, 161, '2020-12-19 12:06:22'),
(2, 2, 162, '2020-12-19 12:29:47'),
(3, 3, 162, '2020-12-21 10:37:39'),
(4, 3, 163, '2020-12-21 10:37:39'),
(5, 4, 163, '2020-12-21 11:28:55'),
(6, 5, 163, '2020-12-23 09:55:30');

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
(1, 1, '18:00:00', '2020-12-19 12:06:22'),
(2, 1, '21:00:00', '2020-12-19 12:06:22'),
(6, 3, '16:00:00', '2020-12-21 10:37:39'),
(7, 3, '17:00:00', '2020-12-21 10:37:39'),
(8, 3, '20:30:00', '2020-12-21 10:37:39'),
(9, 3, '21:10:00', '2020-12-21 10:37:39'),
(10, 4, '17:00:00', '2020-12-21 11:28:55'),
(11, 4, '20:00:00', '2020-12-21 11:28:55'),
(12, 5, '16:00:00', '2020-12-23 09:55:30'),
(13, 5, '20:15:00', '2020-12-23 09:55:30');

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
(14, 5, 'Неврология', 'Невролог', NULL);

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
  `add_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `investment`
--

INSERT INTO `investment` (`id`, `pricer_id`, `user_id`, `balance_cash`, `balance_card`, `balance_transfer`, `add_date`) VALUES
(1, 3, 15, '100000.0', '50000.0', '0.0', '2020-12-14 23:11:13'),
(7, 3, 15, '2900000.0', '0.0', '0.0', '2020-12-26 21:04:19'),
(8, 3, 15, '4000.0', '0.0', '0.0', '2020-12-28 15:44:04'),
(9, 3, 15, '-5000.0', '0.0', '0.0', '2020-12-28 15:44:24'),
(10, 3, 15, '2000.0', '0.0', '0.0', '2020-12-28 15:49:32'),
(11, 3, 15, '-1000.0', '0.0', '0.0', '2020-12-28 15:49:44');

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
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `standart` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `laboratory_analyze_type`
--

INSERT INTO `laboratory_analyze_type` (`id`, `service_id`, `name`, `code`, `standart`, `status`) VALUES
(1, 45, 'АЛТ', 'lab-07', '20-40', 1),
(2, 45, 'АСТ', 'lab-08', '15-35', 1),
(3, 45, 'Общий белок', 'lab-09', '55-80', 1),
(4, 26, 'ss1', 'RGM', '15', 1),
(5, 26, 'eeee', '234325', '12', 1);

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
(158, 'Шприц 2 мг 1 шт', 'wqeqwe', '1231232', NULL, '1000', '1030', '30', 'STeam', '3', NULL, 40, NULL, '1231-03-13', 'УП', '2020-12-10', '2020-12-10', '213213', '20', '132132131231231232'),
(159, 'Волшебные таблетки', 'Жасур', '213213', NULL, '5000', '5500', '500', 'STeam', '3', NULL, 40, NULL, '2020-12-04', 'ШТ', '2020-12-18', '2020-12-10', '12312', '2', 'йцуйцуйцу'),
(161, 'Бисопролол 2,5 мг\r\n', '112', '2232', NULL, '4000', '4600', '600', 'STeam', '2', NULL, 45, NULL, '2020-12-02', 'ШТ', '2020-12-10', '2020-12-11', 'wwww', '10', 'qwerqwerwere'),
(162, 'Глимепирид таблетки 1 мг\r\n', 'wwww', 'wwww', NULL, '25000', '28750', '3750', 'STeam', '2', NULL, 73, NULL, '2020-12-10', 'ШТ', '2021-06-18', '2020-12-11', '222', '20', 'wwwww'),
(163, 'Кислота ацетилсалициловая таб. 500 мг №10\r\n', '', 'eee', NULL, '6000', '6900', '900', 'STeam', '2', NULL, 85, NULL, '2020-12-02', 'ШТ', '2020-12-03', '2020-12-10', '3223', '20', 'wewqeqweqw'),
(164, 'Сульфаметаксазол/триметоприм таблетки 480 мг №10\r\n', '2333', 'ww', NULL, '10000', '11500', '1500', 'STeam', '4', NULL, 20, NULL, '2020-12-02', 'ШТ', '2020-12-24', '2020-12-10', 'weewq', '5', 'wwwwwww');

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
  `price` decimal(65,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `service`
--

INSERT INTO `service` (`id`, `user_level`, `division_id`, `code`, `name`, `price`) VALUES
(1, 1, NULL, NULL, 'Стационарный Осмотр', NULL),
(2, 10, 2, '4R15', 'МРТ Головного мозга', '100000.0'),
(3, 10, 2, NULL, 'Шейный отдел позвоночника', '200000.0'),
(4, 10, 2, NULL, 'Грудной отдел позвоночника', '150000.0'),
(5, 10, 2, NULL, 'Позвоночный столб', '120000.0'),
(6, 10, 2, NULL, 'Правая ключица RT', '130000.0'),
(7, 10, 2, NULL, 'Правое предплечье', '150000.0'),
(8, 10, 2, NULL, 'Левый коленный сустав LT', '160000.0'),
(9, 10, 2, NULL, 'Фораминалный Обзор (Полный)', '180000.0'),
(10, 10, 3, NULL, 'Задне-передняя проекция', '60000.0'),
(11, 10, 3, NULL, 'Передне-задняя проекция', '60000.0'),
(12, 10, 3, NULL, 'Передне-задняя проекция/Боковая', '80000.0'),
(13, 10, 3, NULL, 'Оба Ключицы Передне-задняя', '80000.0'),
(14, 10, 3, NULL, 'Грудной отдел позвоночника Передне-задняя/Боковая', '100000.0'),
(15, 10, 3, NULL, 'Оба Пальцев Передне-задняя/Боковая', '120000.0'),
(16, 10, 4, NULL, 'КТ Позвоночный столб 3D', '80000.0'),
(17, 10, 4, NULL, 'КТ Правая плечевая кость', '150000.0'),
(18, 10, 4, NULL, 'КТ Кости таза', '160000.0'),
(19, 10, 4, NULL, 'КТ Левая стопа', '200000.0'),
(20, 10, 6, NULL, 'Транскраниальная Допплерография', '80000.0'),
(21, 10, 6, NULL, 'Щитовидная железа', '90000.0'),
(22, 10, 6, NULL, 'Тромбоз Допплерография (Обе)', '140000.0'),
(23, 10, 6, NULL, 'Молочная железа-Щитовидная железа', '150000.0'),
(24, 10, 7, NULL, 'ЭКГ', '100000.0'),
(25, 6, 8, NULL, 'Электролиты крови', '50000.0'),
(26, 6, 8, NULL, 'Общий белок', '30000.0'),
(27, 6, 8, NULL, 'Альбумин', '20000.0'),
(28, 6, 8, NULL, 'Общий анализ крови', '60000.0'),
(29, 6, 8, NULL, 'Ревматоидный фактор', '70000.0'),
(30, 5, 9, NULL, 'Первичная консультация терапевта', '50000.0'),
(31, 5, 9, NULL, 'Вторичная консультация терапевта', '30000.0'),
(32, 5, 10, NULL, 'Консультация хирурга, первичная', '50000.0'),
(33, 5, 10, NULL, 'Консультация хирурга, повторная', '30000.0'),
(34, 5, 10, NULL, 'Раны грудной клетки', '60000.0'),
(35, 5, 10, NULL, 'Раны промежности (без повреждения кишки)', '15000.0'),
(36, 5, 11, NULL, 'Первичная консультация кардиолога', '50000.0'),
(37, 5, 11, NULL, 'Вторичная консультация кардиолога', '30000.0'),
(38, 5, 12, NULL, 'Прием (осмотр, консультация) врача-инфекциониста', '60000.0'),
(39, 5, 12, NULL, 'Исследование уровня  тимоловой пробы в крови', '60000.0'),
(40, 5, 13, NULL, 'Первичная консультация гинеколога', '60000.0'),
(41, 5, 13, NULL, 'Вторичная консультация гинеколога', '50000.0'),
(42, 5, 13, NULL, 'Кольпоскопия', '80000.0'),
(43, 5, 14, NULL, 'Первичная консультация невропатолога', '60000.0'),
(44, 5, 14, NULL, 'Вторичная консультация детс.невропатолога', '50000.0'),
(45, 6, 8, NULL, 'Биохимия', '14000.0');

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
  `token_telegramm` varchar(250) DEFAULT NULL,
  `add_date` datetime(6) DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `parent_id`, `username`, `password`, `first_name`, `last_name`, `father_name`, `dateBith`, `region`, `passport`, `placeWork`, `position`, `numberPhone`, `residenceAddress`, `registrationAddress`, `gender`, `user_level`, `division_id`, `status`, `share`, `resident`, `token_telegramm`, `add_date`) VALUES
(1, NULL, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Jasur', 'Rakhmatov', 'Ilhomovich', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 99.1, NULL, NULL, '2020-10-31 22:48:15.000000'),
(2, NULL, 'reg', 'e06b95860a6082ae37ef08874f8eb5fade2549da', 'Регистратура', 'Регистратура', 'xxx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 1, NULL, NULL, NULL, '2020-11-08 19:03:49.000000'),
(3, NULL, 'kassa', '913c8fd5abbf64f58c66b63dd31f6c310c757702', 'kassa', 'kassa', 'kassa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 1, 10, NULL, NULL, '2020-11-18 20:55:30.000000'),
(4, NULL, 'main', 'b28b7af69320201d1cf206ebf28373980add1451', 'врач', 'главный', 'xxx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, 1, NULL, NULL, NULL, '2020-12-04 17:36:43.000000'),
(5, NULL, 'doc_xirurg', '6f0d864cd22ec68deaa7b2c6e84420f7f8515825', 'Шариф', 'Ахмедов', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 10, 1, NULL, NULL, NULL, '2020-12-05 05:00:29.000000'),
(6, NULL, 'laboratory', '80240dcecd105d50195cce7a318413dc013733e3', 'Дилноза', 'Шарипова', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 8, 1, NULL, NULL, NULL, '2020-12-05 05:01:19.000000'),
(7, NULL, 'mrt', 'f2b83e490eacf0abfbda89413282a3744dc9a2b8', 'Давид', 'Нагараев', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 2, 1, NULL, NULL, NULL, '2020-12-05 05:01:55.000000'),
(8, NULL, 'rentgen', '9928bac9a395fc4d8b99d4cdf9577d2d6e19bdaf', 'Жамшид', 'Рахмонов', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 3, 1, NULL, NULL, NULL, '2020-12-05 05:02:33.000000'),
(9, NULL, 'uzi', 'f2b545bd0099b1c89c3ef7acd0e4e1e50874bf74', 'Шухрат', 'Аллаёров', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 6, 1, NULL, NULL, NULL, '2020-12-05 05:03:21.000000'),
(10, NULL, 'kt', '3553b226127e0cccd2bec8c74a70f7d1603f41f9', 'Самандар', 'Файзиев', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 4, 1, NULL, NULL, NULL, '2020-12-05 05:04:40.000000'),
(11, NULL, 'doc_nevrolog', '9e509e93c9b6f6624b4a1cfb30b636974a4ab57d', 'Сухроб', 'Гулямов', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 14, 1, NULL, NULL, NULL, '2020-12-05 06:11:56.000000'),
(12, NULL, 'doc_ginekolog', '32e27b059f80416a798458f2e67b898f078172a0', 'Нафиса', 'Шарипова', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 13, 1, NULL, NULL, NULL, '2020-12-05 06:12:43.000000'),
(14, NULL, 'nurce', '98b8f939651a9c9f10a7a0c83815083e96ae52c9', 'Шамсия', 'Турсунова', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, 1, NULL, NULL, NULL, '2020-12-05 06:14:36.000000'),
(15, 2, NULL, NULL, 'Бемор 1', 'Бемор 1', 'ххх', '2001-12-04', 'Ромитан', 'АА12345678', 'Химчан', 'ИТ', '998912474353', 'Кучабог 8', 'Рухшобод', NULL, 15, NULL, NULL, 0, NULL, NULL, '2020-12-05 06:59:59.000000'),
(16, 2, NULL, NULL, 'Бемор-2', 'Бемор-2', 'ххх', '2001-10-03', 'Олмазор', 'АА1234567', 'ААА', 'ААА', '998912474353', 'ААА', 'ААА', 1, 15, NULL, NULL, 0, NULL, NULL, '2020-12-05 07:53:03.000000'),
(17, NULL, 'farm', '36a3bbe0659d5cf5e918a70a1da0c90ff6a33ba9', 'farm', 'farm', 'farm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, 1, 1, NULL, NULL, '2020-12-06 21:30:42.000000'),
(18, NULL, 'radiolog', 'd92ffb3b4c6121a260f303bee9b228ca020786ba', 'doc_rad', 'doc_rad', 'doc_rad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 1, 1, NULL, NULL, NULL, '2020-12-07 17:56:02.000000'),
(19, 2, NULL, NULL, 'qweqwe', 'eqweqw', 'eqweqw', '2020-12-02', 'Ромитан', '21321321312', 'eqweqw', 'eqweqw', '231312321313123', 'eqweqw', 'eqweqw', 1, 15, NULL, NULL, 0, NULL, NULL, '2020-12-10 21:01:05.000000'),
(20, 2, NULL, NULL, 'Test', 'Test', 'Test', '2000-12-12', 'Ромитан', 'АА454545', 'аап', 'апапап', '998912474353', 'г .Бухара', 'Кучабох 8', 1, 15, NULL, 1, 0, NULL, NULL, '2020-12-13 15:59:40.000000'),
(21, NULL, 'any', 'c5fe0200d1c7a5139bd18fd22268c4ca8bf45e90', 'any', 'any', 'any', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL, 11, NULL, NULL, '2020-12-22 17:46:42.000000'),
(22, 2, NULL, NULL, 'Tester', 'tester', 'Tester', '2020-12-17', 'Миробод', '001', 'qweqweqw', 'asdasddqwdqwe', '123232131312', 'Tester', 'Tester', 1, 15, NULL, 1, 0, NULL, NULL, '2020-12-23 14:36:57.000000');

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

--
-- Дамп данных таблицы `user_stats`
--

INSERT INTO `user_stats` (`id`, `parent_id`, `visit_id`, `stat`, `pressure`, `pulse`, `temperature`, `saturation`, `breath`, `urine`, `description`, `status`, `add_date`) VALUES
(2, 14, 1, NULL, '120/90', 85, 36.6, 75, 45, 2.45, NULL, NULL, '2020-12-09 20:50:56'),
(3, 14, 1, NULL, '130/80', 85, 36.6, 75, 30, 2.45, NULL, NULL, '2020-12-10 20:01:51'),
(4, 14, 1, NULL, '150/80', 78, 36.6, 57, 36, 2.45, NULL, NULL, '2020-12-11 20:01:59'),
(5, 14, 1, NULL, '100/90', 147, 39.5, 37, 12, 0.8, NULL, NULL, '2020-12-11 20:27:06'),
(6, 14, 1, 2, '100/50', 111, 39.6, 53, 47, 1.4, 'Очень плохо', NULL, '2020-12-17 20:59:43'),
(7, 5, 1, NULL, '90/40', 50, 35.5, 50, NULL, NULL, NULL, 2, '2020-12-23 12:53:00'),
(8, 5, 1, NULL, '120/80', 85, 36.6, 75, NULL, NULL, NULL, 2, '2020-12-23 13:50:00'),
(9, 5, 1, NULL, '30/5', 40, 35, 25, NULL, NULL, NULL, 2, '2020-12-23 15:00:00'),
(10, 5, 1, NULL, '140/60', 85, 36.7, 90, NULL, NULL, NULL, 2, '2020-12-24 16:00:00'),
(11, 5, 1, NULL, '220/140', 150, 42, 99, NULL, NULL, NULL, 2, '2020-12-24 17:00:00');

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

INSERT INTO `visit` (`id`, `user_id`, `grant_id`, `parent_id`, `route_id`, `assist_id`, `division_id`, `service_id`, `bed_id`, `direction`, `status`, `diagnostic`, `laboratory`, `guide_id`, `failure`, `report_title`, `report_description`, `report_diagnostic`, `report_recommendation`, `add_date`, `accept_date`, `priced_date`, `discharge_date`, `oper_date`, `completed`) VALUES
(1, 15, 5, 5, 2, NULL, 10, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'wererer eqwe  qq w', 'w qw qw qe qwqwe  q', '1111111', 'q qw qw qwe qw e', '2020-12-07 22:20:00', '2020-12-07 22:20:12', NULL, '2020-12-19', '2020-12-25 17:35:00', '2020-12-26 20:31:00'),
(44, 19, 5, 5, 2, NULL, 10, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Консультация хирурга, первичная', 'Консультация пластического хирурга пройдет более плодотворно, если Вы возьмите на неё свою фотографию, на которой хорошо видны места предполагаемой операции. Например, ринопластика, блефаропластика, отопластика предполагают наличие фотографии портретного типа. А вот увеличении груди, липосакция, абдоминопластика, наоборот — в полный рост! Для ринопластики будет не лишне взять с собой даже две фотографии — в профиль и анфас. Заранее обдумайте, какие фотографии будут уместны для объяснения Ваших пожеланий и возьмите их с собой.', 'Причем, имея на руках фотографии, уже первая консультация пластического хирурга позволит Вам увидеть свой будущий образ, который будет смонтирован при помощи компьютерной программы. Такое моделирование позволит точно сформировать предполагаемые конечные результаты.', 'Благодаря чему перед хирургическим вмешательством Ваши представления будут совпадать с виденьем врача. Это позволит получить максимально желаемый результат!', '2020-12-25 20:45:51', '2020-12-25 21:17:05', '2020-12-25 20:46:38', NULL, NULL, '2020-12-25 22:40:00'),
(48, 19, 5, 18, 5, 7, 2, 2, NULL, NULL, 0, 1, NULL, NULL, NULL, 'МРТ Головного мозга', 'МРТ головного мозга — это неинвазивное исследование, которое подразумевает использование мощных магнитных полей, высокочастотных импульсов, компьютерной системы и программного обеспечения, позволяющих получить детальное изображение мозга. Рентгеновское излучение при МРТ не используется. Именно поэтому на сегодняшний день МРТ — одно из наиболее безопасных и притом очень точных исследований. Качество визуализации при МРТ намного лучше, чем при рентгенологическом или ультразвуковом исследовании, компьютерной томографии. Магнитно-резонансная томография дает возможность обнаружить опухоли, аневризму и другие патологии сосудов, а также некоторые проблемы нервной системы. Словом, возможности метода очень широки. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', 'Несмотря на то, что для разных методов диагностики (рентгеновской, радионуклидной, магнитно-резонансной, ультразвуковой) используются различные физические принципы и источники излучения, их объединяет применение правил математического моделирования при создании изображений. Поэтому данные методы относят к методам лучевой диагностики, и обследование проводится в специальном отделении с аналогичным названием. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', 'Контрастные препараты других классов (например, на основе оксида железа) в России на данный момент не зарегистрированы Оригинал статьи.', '2020-12-25 22:13:31', '2020-12-25 22:37:17', '2020-12-25 22:36:03', NULL, NULL, '2020-12-25 22:38:42'),
(49, 15, 5, 18, 5, 7, 2, 3, NULL, 1, 0, 1, NULL, NULL, NULL, 'Шейный отдел позвоночника', 'Шейный отдел позвоночника — это неинвазивное исследование, которое подразумевает использование мощных магнитных полей, высокочастотных импульсов, компьютерной системы и программного обеспечения, позволяющих получить детальное изображение мозга. Рентгеновское излучение при МРТ не используется. Именно поэтому на сегодняшний день МРТ — одно из наиболее безопасных и притом очень точных исследований. Качество визуализации при МРТ намного лучше, чем при рентгенологическом или ультразвуковом исследовании, компьютерной томографии. Магнитно-резонансная томография дает возможность обнаружить опухоли, аневризму и другие патологии сосудов, а также некоторые проблемы нервной системы. Словом, возможности метода очень широки. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', 'Решение о проведении МРТ с контрастом выносится в тех случаях, когда проведение обследования без контраста будет недостаточным для постановки диагноза. Так, абсолютным показанием к внутривенному контрастированию является подозрение или уже подтвержденное онкологическое заболевание. В большинстве случаев применяются препараты макроциклических хелатов гадолиния в низких дозах, достаточных для проведения обследования. Такое обследование проводят с осторожностью, поскольку контрастирующее вещество может вызывать аллергические реакции. Оригинал статьи: https://www.kp.ru/guide/mrt-golovnogo-mozga.html', 'Решение о проведении МРТ с контрастом выносится в тех случаях, когда проведение обследования без контраста будет недостаточным для постановки диагноза. Так, абсолютным показанием к внутривенному контрастированию является подозрение или уже подтвержденное онкологическое заболевание. В большинстве', '2020-12-25 22:41:17', '2020-12-25 22:41:50', NULL, NULL, NULL, '2020-12-25 22:43:20'),
(52, 20, 5, 5, 2, NULL, 10, 32, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-28 15:03:35', NULL, NULL, NULL, NULL, NULL),
(53, 22, 9, 9, 2, NULL, 6, 20, NULL, NULL, 0, NULL, NULL, 1, NULL, 'Транскраниальная Допплерография', 'Транскраниальная ДопплерографияТ ранскраниальная Допплерография', '9999', 'Транскраниальная Допплерография wq\r\nqqweqw\r\neqwe\r\nqw\r\neqwe\r\nqwe\r\nqw', '2020-12-28 17:01:18', '2020-12-28 17:03:55', '2020-12-28 17:03:20', NULL, NULL, '2020-12-28 17:11:31'),
(55, 19, 7, 18, 2, 7, 2, 2, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'МРТ Головного мозга', 'qweqwewqeq qe qweqw eqw', 'qwsadd qw', '777', '2020-12-28 17:44:04', '2020-12-28 17:46:44', '2020-12-28 17:44:45', NULL, NULL, '2020-12-28 18:07:38'),
(56, 22, 10, 10, 2, 10, 4, 17, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-28 17:45:16', '2020-12-28 17:46:47', '2020-12-28 17:45:27', NULL, NULL, NULL);

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

--
-- Дамп данных таблицы `visit_inspection`
--

INSERT INTO `visit_inspection` (`id`, `visit_id`, `parent_id`, `description`, `diagnostic`, `recommendation`, `status`, `add_date`) VALUES
(1, 1, 5, 'qwwqwq', NULL, 'qw123 323 12 313 1', NULL, '2020-12-12 21:52:45'),
(2, 1, 5, 'test1', NULL, 'test', NULL, '2020-12-12 22:09:28'),
(3, 1, 5, 'hdihqidhid', NULL, 'dhwihqidhqwid', NULL, '2020-12-12 22:14:34'),
(4, 1, 5, 'dfdbdfbdf', NULL, 'dfbdfbdfb', NULL, '2020-12-13 16:11:27'),
(5, 1, 5, 'wew qeqwe', 'qw eqweq weqwe', 'weqwe qweqweq weqw', NULL, '2020-12-17 20:51:57'),
(6, 1, 21, 'wqewqe', 'qwewqewq', 'qwewq', 1, '2020-12-22 21:50:40'),
(7, 1, 5, 'pick', 'pick', 'pick', NULL, '2020-12-22 21:54:19'),
(10, 1, 5, 'eee12', '3213123123', '123', NULL, '2020-12-23 21:08:43'),
(11, 1, 5, 'T11', 'T11', 'T11', 2, '2020-12-23 21:10:10'),
(12, 1, 5, 'Дибилизм', 'Далбаеб', 'Лечится', 2, '2020-12-24 18:52:16');

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

--
-- Дамп данных таблицы `visit_member`
--

INSERT INTO `visit_member` (`id`, `visit_id`, `member_id`, `status`) VALUES
(3, 1, 11, NULL);

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
  `sale` tinyint(4) DEFAULT NULL,
  `refund` decimal(65,1) NOT NULL DEFAULT 0.0,
  `item_type` tinyint(4) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_cost` decimal(65,1) NOT NULL,
  `item_name` varchar(500) NOT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `visit_price`
--

INSERT INTO `visit_price` (`id`, `visit_id`, `pricer_id`, `price_cash`, `price_card`, `price_transfer`, `sale`, `refund`, `item_type`, `item_id`, `item_cost`, `item_name`, `add_date`) VALUES
(81, 44, 3, '20000.0', '30000.0', '0.0', NULL, '0.0', 1, 44, '50000.0', 'Консультация хирурга, первичная', '2020-12-25 20:46:38'),
(85, 48, 3, '35000.0', '65000.0', '0.0', NULL, '0.0', 1, 2, '100000.0', 'МРТ Головного мозга', '2020-12-25 22:13:31'),
(86, 49, NULL, '0.0', '0.0', '0.0', NULL, '0.0', 1, 3, '200000.0', 'Шейный отдел позвоночника', '2020-12-25 22:41:17'),
(88, 52, NULL, '0.0', '0.0', '0.0', NULL, '0.0', 1, 32, '50000.0', 'Консультация хирурга, первичная', '2020-12-28 15:03:35'),
(89, 53, 3, '80000.0', '0.0', '0.0', NULL, '0.0', 1, 20, '80000.0', 'Транскраниальная Допплерография', '2020-12-28 17:01:18'),
(91, 55, 3, '100000.0', '0.0', '0.0', NULL, '0.0', 1, 2, '100000.0', 'МРТ Головного мозга', '2020-12-28 17:44:04'),
(92, 56, 3, '0.0', '150000.0', '0.0', NULL, '0.0', 1, 17, '150000.0', 'КТ Правая плечевая кость', '2020-12-28 17:45:16');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `bed_type`
--
ALTER TABLE `bed_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `bypass`
--
ALTER TABLE `bypass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `bypass_date`
--
ALTER TABLE `bypass_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT для таблицы `bypass_preparat`
--
ALTER TABLE `bypass_preparat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `bypass_time`
--
ALTER TABLE `bypass_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `collection`
--
ALTER TABLE `collection`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze`
--
ALTER TABLE `laboratory_analyze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze_type`
--
ALTER TABLE `laboratory_analyze_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

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
-- AUTO_INCREMENT для таблицы `sales`
--
ALTER TABLE `sales`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT для таблицы `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `storage_orders`
--
ALTER TABLE `storage_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT для таблицы `storage_preparat`
--
ALTER TABLE `storage_preparat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `storage_type`
--
ALTER TABLE `storage_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `user_card`
--
ALTER TABLE `user_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_stats`
--
ALTER TABLE `user_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT для таблицы `visit_inspection`
--
ALTER TABLE `visit_inspection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `visit_member`
--
ALTER TABLE `visit_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `visit_price`
--
ALTER TABLE `visit_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT для таблицы `wards`
--
ALTER TABLE `wards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
