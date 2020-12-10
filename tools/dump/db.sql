-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 10 2020 г., 15:50
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
(1, 15, 1, 5, 1, '123', NULL, '2020-12-09 22:44:21');

-- --------------------------------------------------------

--
-- Структура таблицы `bypass_date`
--

CREATE TABLE `bypass_date` (
  `id` int(11) NOT NULL,
  `bypass_id` int(11) DEFAULT NULL,
  `bypass_time_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
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
(1, 1, 158, '2020-12-09 17:44:21');

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
(1, 1, '12:00:00', '2020-12-09 17:44:21');

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

--
-- Дамп данных таблицы `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `address`, `contact`, `membership_number`, `prod_name`, `expected_date`, `note`) VALUES
(1, 'r', 'r', 'r', '34', 'r', '2020-11-05', 'r'),
(2, '1', '1', '1', '1', '1', '2020-11-13', '1'),
(3, '3', '3', '3', '3', '3', '2020-11-02', '3');

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
(1, 'Шприц 2 мг 1 шт', NULL);

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
(1, 3, 15, '50000.0', '2020-12-08 01:13:05'),
(2, 3, 15, '15000.0', '2020-12-08 01:17:08');

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
(1, 16, 3, 26, 4, '15', NULL, 'w');

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
(4, 26, 'ss1', 'RGM', '15', 1);

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
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `notes`
--

INSERT INTO `notes` (`id`, `parent_id`, `visit_id`, `date_text`, `description`, `status`) VALUES
(3, 5, 1, 'June 4th 08:47', 'tes', NULL);

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
(1, 'Расходный материал');

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
(158, 'Шприц 2 мг 1 шт', 'wqeqwe', '1231232', NULL, '1000', '1030', '30', 'STeam', '1', NULL, 10, NULL, '1231-03-13', 'УП', '2020-12-10', '2020-12-10', '213213', '0', '132132131231231232');

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
  `client` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profit` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gen_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
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
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `position`) VALUES
(1, 'admin', 'admin', 'Admin', 'admin'),
(2, 'dili', 'dili', 'dili', 'Cashier'),
(3, 'admin', 'admin123', 'Kassir', 'admin');

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
(2, NULL, 'reg', 'e06b95860a6082ae37ef08874f8eb5fade2549da', 'Регистратура', 'Регистратура', 'xxx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 1, NULL, NULL, '2020-11-08 14:03:49'),
(3, NULL, 'kassa', '913c8fd5abbf64f58c66b63dd31f6c310c757702', 'kassa', 'kassa', 'kassa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 1, 10, NULL, '2020-11-18 15:55:30'),
(4, NULL, 'main', 'b28b7af69320201d1cf206ebf28373980add1451', 'врач', 'главный', 'xxx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, 1, NULL, NULL, '2020-12-04 12:36:43'),
(5, NULL, 'doc_xirurg', '6f0d864cd22ec68deaa7b2c6e84420f7f8515825', 'Шариф', 'Ахмедов', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 10, 1, NULL, NULL, '2020-12-05 00:00:29'),
(6, NULL, 'laboratory', '80240dcecd105d50195cce7a318413dc013733e3', 'Дилноза', 'Шарипова', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 8, 1, NULL, NULL, '2020-12-05 00:01:19'),
(7, NULL, 'mrt', 'f2b83e490eacf0abfbda89413282a3744dc9a2b8', 'Давид', 'Нагараев', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 2, 1, NULL, NULL, '2020-12-05 00:01:55'),
(8, NULL, 'rentgen', '9928bac9a395fc4d8b99d4cdf9577d2d6e19bdaf', 'Жамшид', 'Рахмонов', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 3, 1, NULL, NULL, '2020-12-05 00:02:33'),
(9, NULL, 'uzi', 'f2b545bd0099b1c89c3ef7acd0e4e1e50874bf74', 'Шухрат', 'Аллаёров', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 6, 1, NULL, NULL, '2020-12-05 00:03:21'),
(10, NULL, 'kt', '3553b226127e0cccd2bec8c74a70f7d1603f41f9', 'Самандар', 'Файзиев', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 4, 1, NULL, NULL, '2020-12-05 00:04:40'),
(11, NULL, 'doc_nevrolog', '9e509e93c9b6f6624b4a1cfb30b636974a4ab57d', 'Сухроб', 'Гулямов', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 14, 1, NULL, NULL, '2020-12-05 01:11:56'),
(12, NULL, 'doc_ginekolog', '32e27b059f80416a798458f2e67b898f078172a0', 'Нафиса', 'Шарипова', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 13, 1, NULL, NULL, '2020-12-05 01:12:43'),
(14, NULL, 'nurce_1', 'c000e8b0a3f6e91f586867365618581675fa20d7', 'Шамсия', 'Турсунова', 'ххх', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, 1, NULL, NULL, '2020-12-05 01:14:36'),
(15, 2, NULL, NULL, 'Бемор 1', 'Бемор 1', 'ххх', '2001-12-04', 'Ромитан', 'АА12345678', 'Химчан', 'ИТ', '998912474353', 'Кучабог 8', 'Рухшобод', NULL, 15, NULL, 1, 0, NULL, '2020-12-05 01:59:59'),
(16, 2, NULL, NULL, 'Бемор-2', 'Бемор-2', 'ххх', '2001-10-03', 'Олмазор', 'АА1234567', 'ААА', 'ААА', '998912474353', 'ААА', 'ААА', 1, 15, NULL, 1, 0, NULL, '2020-12-05 02:53:03'),
(17, NULL, 'farm', '36a3bbe0659d5cf5e918a70a1da0c90ff6a33ba9', 'farm', 'farm', 'farm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, 1, 1, NULL, '2020-12-06 16:30:42'),
(18, NULL, 'radiolog', 'd92ffb3b4c6121a260f303bee9b228ca020786ba', 'doc_rad', 'doc_rad', 'doc_rad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 1, 1, 1, NULL, '2020-12-07 12:56:02');

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
  `weight` smallint(6) DEFAULT NULL,
  `urine` float DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_stats`
--

INSERT INTO `user_stats` (`id`, `parent_id`, `visit_id`, `stat`, `pressure`, `pulse`, `temperature`, `saturation`, `breath`, `weight`, `urine`, `add_date`) VALUES
(2, 14, 1, NULL, '120/80', 85, 36.6, 75, 45, 200, 2.45, '2020-12-09 15:50:56');

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

INSERT INTO `visit` (`id`, `user_id`, `grant_id`, `parent_id`, `route_id`, `assist_id`, `division_id`, `service_id`, `bed_id`, `direction`, `status`, `diagnostic`, `laboratory`, `failure`, `report_title`, `report_description`, `report_conclusion`, `add_date`, `accept_date`, `priced_date`, `discharge_date`, `completed`) VALUES
(1, 15, 5, 5, 2, NULL, 10, 1, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-07 22:20:00', '2020-12-07 22:20:12', NULL, NULL, NULL),
(2, 15, 5, 18, 5, 7, 2, 3, NULL, 1, 0, 1, NULL, NULL, 'Шейный отдел позвоночника', 'Шейные позвонки испытывают наименьшую нагрузку по сравнению с позвонками других отделов позвоночника, поэтому у них небольшие, низкие тела. Шейный отдел больше всего подвержен травмам, потому что имеет слабые мышцы, подвергающиеся довольно существенным нагрузкам, а его позвонки характеризуются маленькими размерами и невысокой прочностью.\r\nПозвонки шеи включают в себя поперечные отростки, имеющие отверстия. В этих отверстиях проходят артерии и вены, участвующие в обеспечении головного мозга кислородом и питанием. \r\nПри различных патологиях шейного отдела позвоночника, например при появлении грыж, сдавливающих кровеносные сосуды, возникает недостаточность мозгового кровоснабжения.', 'Шейный отдел – самый подвижный участок позвоночника. Он отвечает за осуществление движений шеи, за наклоны и повороты головы. Повреждения шейного отдела позвоночника могут произойти вследствие сильного удара в область шеи или при чрезмерном или резком наклоне головы. Такой вид травмы может сопровождаться травмой спинного мозга. Шейных позвонков у человека семь.', '2020-12-07 22:20:42', '2020-12-07 22:20:55', NULL, NULL, '2020-12-07 22:22:04'),
(3, 16, 6, 6, 2, NULL, 8, 26, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2020-12-08 21:40:38', '2020-12-08 21:41:02', '2020-12-08 21:40:55', NULL, '2020-12-08 21:55:52'),
(4, 16, 5, 5, 2, NULL, 10, 32, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-09 18:04:39', '2020-12-09 18:04:57', '2020-12-09 18:04:49', NULL, NULL),
(5, 16, 5, 11, 5, NULL, 14, 43, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-09 18:06:00', '2020-12-09 18:06:20', '2020-12-09 18:06:13', NULL, NULL),
(6, 15, NULL, 5, 5, NULL, 10, 34, NULL, 1, 2, NULL, NULL, NULL, 'Раны грудной клетки', 'Раны грудной клетки', 'Раны грудной клетки', '2020-12-09 18:28:59', '2020-12-09 18:30:13', NULL, NULL, NULL);

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
(1, 3, 3, '30000.0', NULL, NULL, NULL, '2020-12-08 16:40:55'),
(2, 4, 3, '50000.0', NULL, NULL, NULL, '2020-12-09 13:04:49'),
(3, 5, 3, '60000.0', NULL, NULL, NULL, '2020-12-09 13:06:13');

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
-- Индексы таблицы `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

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
-- Индексы таблицы `storage_type`
--
ALTER TABLE `storage_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `supliers`
--
ALTER TABLE `supliers`
  ADD PRIMARY KEY (`suplier_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `bypass_date`
--
ALTER TABLE `bypass_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `bypass_preparat`
--
ALTER TABLE `bypass_preparat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `bypass_time`
--
ALTER TABLE `bypass_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `collection`
--
ALTER TABLE `collection`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `investment`
--
ALTER TABLE `investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `laboratory_analyze`
--
ALTER TABLE `laboratory_analyze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT для таблицы `pharmacy_category`
--
ALTER TABLE `pharmacy_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

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
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `storage_type`
--
ALTER TABLE `storage_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `supliers`
--
ALTER TABLE `supliers`
  MODIFY `suplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `user_stats`
--
ALTER TABLE `user_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
