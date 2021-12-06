-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 23 2021 г., 12:10
-- Версия сервера: 10.6.5-MariaDB
-- Версия PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `clinic_v3`
--

-- --------------------------------------------------------

--
-- Структура таблицы `beds`
--

CREATE TABLE `beds` (
  `id` smallint(5) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `building_id` tinyint(2) DEFAULT NULL,
  `ward_id` smallint(5) DEFAULT NULL,
  `type_id` tinyint(3) DEFAULT NULL,
  `building` char(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` tinyint(3) DEFAULT NULL,
  `ward` smallint(6) DEFAULT NULL,
  `bed` smallint(5) DEFAULT NULL,
  `types` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `beds`
--

INSERT INTO `beds` (`id`, `branch_id`, `building_id`, `ward_id`, `type_id`, `building`, `floor`, `ward`, `bed`, `types`, `client_id`, `add_date`) VALUES
(6, 1, 1, 2, 1, 'Здание A', 1, 101, 2, 'Default', NULL, '2021-11-22 17:42:27'),
(7, 1, 1, 2, 1, 'Здание A', 1, 101, 1, 'Default', NULL, '2021-11-22 17:46:49');

-- --------------------------------------------------------

--
-- Структура таблицы `bed_types`
--

CREATE TABLE `bed_types` (
  `id` tinyint(3) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(65,1) DEFAULT 0.0,
  `price_foreigner` decimal(65,1) DEFAULT 0.0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bed_types`
--

INSERT INTO `bed_types` (`id`, `branch_id`, `name`, `price`, `price_foreigner`) VALUES
(1, 1, 'Default', NULL, NULL);

--
-- Триггеры `bed_types`
--
DELIMITER $$
CREATE TRIGGER `bed_types_before_update` BEFORE UPDATE ON `bed_types` FOR EACH ROW BEGIN
	UPDATE beds SET types = NEW.name WHERE type_id = NEW.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `buildings`
--

CREATE TABLE `buildings` (
  `id` tinyint(2) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `name` char(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floors` tinyint(3) NOT NULL DEFAULT 1,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `buildings`
--

INSERT INTO `buildings` (`id`, `branch_id`, `name`, `floors`, `add_date`) VALUES
(1, 1, 'Здание A', 2, '2021-11-22 17:39:53');

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `is_foreigner` tinyint(1) DEFAULT NULL,
  `first_name` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `province_id` tinyint(3) DEFAULT NULL,
  `province` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region_id` smallint(5) DEFAULT NULL,
  `region` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_seria` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_pin_fl` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_place` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_position` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_residence` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_registration` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_telegramm` char(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance_policy` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `responsible_id`, `status`, `gender`, `is_foreigner`, `first_name`, `last_name`, `father_name`, `birth_date`, `province_id`, `province`, `region_id`, `region`, `passport_seria`, `passport_pin_fl`, `work_place`, `work_position`, `phone_number`, `address_residence`, `address_registration`, `token_telegramm`, `insurance_policy`, `add_date`) VALUES
(1, 2, 1, 1, NULL, 'a', 'a', 'a', '2021-11-22', 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-22 17:43:41');

-- --------------------------------------------------------

--
-- Структура таблицы `corp_branchs`
--

CREATE TABLE `corp_branchs` (
  `id` smallint(5) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `name` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `corp_branchs`
--

INSERT INTO `corp_branchs` (`id`, `is_active`, `name`, `address`, `add_date`) VALUES
(1, 1, 'Head Fillial', NULL, '2021-11-22 17:38:23');

-- --------------------------------------------------------

--
-- Структура таблицы `corp_constants`
--

CREATE TABLE `corp_constants` (
  `const_label` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `const_value` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `corp_constants`
--

INSERT INTO `corp_constants` (`const_label`, `const_value`) VALUES
('constant_admin_delete_button_analyzes', 'on'),
('constant_admin_delete_button_services', 'on'),
('constant_admin_delete_button_users', 'on'),
('constant_admin_delete_button_warehouses', 'on'),
('constant_card_stationar_analyze_button', 'on'),
('constant_card_stationar_condition_button', 'on'),
('constant_card_stationar_diagnostic_button', 'on'),
('constant_card_stationar_doctor_button', 'on'),
('constant_card_stationar_journal_edit', 'on'),
('constant_card_stationar_physio_button', 'on'),
('constant_document_autosave', 'on'),
('constant_laboratory_end_all_button', 'on'),
('constant_laboratory_end_service_button', 'on'),
('constant_laboratory_failure_service_button', 'on'),
('constant_package', 'on'),
('constant_pharmacy_percent', '20'),
('constant_print_document_1-aligin', 'left'),
('constant_print_document_1-logotype', '/storage/images/8d47f2e21193a63bfe77e45973de2e3adbd49eb4.jpg'),
('constant_print_document_1-logotype-height', '170'),
('constant_print_document_1-logotype-is_circle', 'on'),
('constant_print_document_1-logotype-width', '170'),
('constant_print_document_1-text-1', ''),
('constant_print_document_1-text-1-color', '#000000'),
('constant_print_document_1-text-1-is_bold', NULL),
('constant_print_document_1-text-1-size', ''),
('constant_print_document_1-text-2', ''),
('constant_print_document_1-text-2-color', '#000000'),
('constant_print_document_1-text-2-is_bold', NULL),
('constant_print_document_1-text-2-size', ''),
('constant_print_document_1-text-3', ''),
('constant_print_document_1-text-3-color', '#000000'),
('constant_print_document_1-text-3-is_bold', NULL),
('constant_print_document_1-text-3-size', ''),
('constant_print_document_1-type', 'on'),
('constant_print_document_2-aligin', 'right'),
('constant_print_document_2-logotype-height', '120'),
('constant_print_document_2-logotype-is_circle', NULL),
('constant_print_document_2-logotype-width', '400'),
('constant_print_document_2-text-1', 'Med24line'),
('constant_print_document_2-text-1-color', '#d300a1'),
('constant_print_document_2-text-1-is_bold', 'on'),
('constant_print_document_2-text-1-size', '26'),
('constant_print_document_2-text-2', 'Version 3'),
('constant_print_document_2-text-2-color', '#000000'),
('constant_print_document_2-text-2-is_bold', NULL),
('constant_print_document_2-text-2-size', '24'),
('constant_print_document_2-text-3', '(33) 099-77-95'),
('constant_print_document_2-text-3-color', '#000000'),
('constant_print_document_2-text-3-is_bold', NULL),
('constant_print_document_2-text-3-size', ''),
('constant_print_document_2-type', NULL),
('constant_print_document_3-aligin', 'left'),
('constant_print_document_3-logotype-height', '120'),
('constant_print_document_3-logotype-is_circle', NULL),
('constant_print_document_3-logotype-width', '400'),
('constant_print_document_3-text-1', ''),
('constant_print_document_3-text-1-color', '#000000'),
('constant_print_document_3-text-1-is_bold', NULL),
('constant_print_document_3-text-1-size', ''),
('constant_print_document_3-text-2', ''),
('constant_print_document_3-text-2-color', '#000000'),
('constant_print_document_3-text-2-is_bold', NULL),
('constant_print_document_3-text-2-size', ''),
('constant_print_document_3-text-3', ''),
('constant_print_document_3-text-3-color', '#000000'),
('constant_print_document_3-text-3-is_bold', NULL),
('constant_print_document_3-text-3-size', ''),
('constant_print_document_3-type', NULL),
('constant_print_document_blocks', '2'),
('constant_print_document_hr-1', 'on'),
('constant_print_document_hr-1-color', '#000000'),
('constant_print_document_hr-2', 'on'),
('constant_print_document_hr-2-color', '#000000'),
('constant_print_document_hr-3', 'on'),
('constant_print_document_hr-3-color', '#000000'),
('constant_print_document_hr-4', 'on'),
('constant_print_document_hr-4-color', '#000000'),
('constant_print_document_qrcode', 'on'),
('constant_template', 'on'),
('constant_wards_by_division', 'on'),
('module_bypass', 'on'),
('module_diagnostic', 'on'),
('module_diet', 'on'),
('module_laboratory', 'on'),
('module_personal_qty', '5'),
('module_pharmacy', 'on'),
('module_physio', 'on'),
('module_zetta_pacs', 'on');

-- --------------------------------------------------------

--
-- Структура таблицы `divisions`
--

CREATE TABLE `divisions` (
  `id` smallint(5) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `mark` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assist` tinyint(1) DEFAULT NULL,
  `is_document` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `divisions`
--

INSERT INTO `divisions` (`id`, `branch_id`, `level`, `mark`, `title`, `name`, `assist`, `is_document`) VALUES
(1, 1, 11, 'X', 'Хирургия', 'Хирург', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `guides`
--

CREATE TABLE `guides` (
  `id` mediumint(7) NOT NULL,
  `name` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(65,1) DEFAULT 0.0,
  `share` float DEFAULT 0,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `international_classification_diseases`
--

CREATE TABLE `international_classification_diseases` (
  `id` smallint(5) NOT NULL,
  `code` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `decryption` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `multi_accounts`
--

CREATE TABLE `multi_accounts` (
  `id` smallint(5) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `slot` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `package_bypass`
--

CREATE TABLE `package_bypass` (
  `id` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `autor_id` int(11) DEFAULT NULL,
  `name` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` tinyint(2) DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `package_services`
--

CREATE TABLE `package_services` (
  `id` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `autor_id` int(11) DEFAULT NULL,
  `name` char(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisions` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `province`
--

CREATE TABLE `province` (
  `id` tinyint(3) NOT NULL,
  `name` char(70) COLLATE utf8mb4_unicode_ci NOT NULL
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
-- Структура таблицы `region`
--

CREATE TABLE `region` (
  `id` smallint(5) NOT NULL,
  `province_id` tinyint(3) NOT NULL,
  `name` char(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `region`
--

INSERT INTO `region` (`id`, `province_id`, `name`) VALUES
(1, 1, 'Бектемирский район\r\n'),
(2, 1, 'М.Улугбекский район'),
(3, 1, 'Мирабадский район'),
(4, 1, 'Алмазарский район'),
(5, 1, 'Сергелиский район'),
(6, 1, 'Учтепинский район'),
(7, 1, 'Чиланзарский район\r\n'),
(8, 1, 'Шайхантахурский район'),
(9, 1, 'Юнусабадский район'),
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
(33, 3, 'Каганский район'),
(34, 3, 'Каракульский район'),
(35, 3, 'Караулбазарский район'),
(36, 3, 'Пешкунский район'),
(37, 3, 'Ромитанский район'),
(38, 3, 'Шафирканский район'),
(39, 3, 'Вабкентский район'),
(40, 4, 'Алтыарыкский район'),
(41, 4, 'Багдатский'),
(42, 4, 'Бешарыкский район'),
(43, 4, 'Кокандский район'),
(44, 4, 'Кувинский район'),
(45, 4, 'Кудашский район'),
(46, 4, 'Маргеланский район'),
(47, 4, 'Риштанский район'),
(48, 4, 'Ферганский район'),
(49, 5, 'Арнасайский район'),
(50, 5, 'Бахмальский район'),
(51, 5, 'Дустликский район'),
(52, 5, 'Фаришский район'),
(53, 5, 'Галляаральский район'),
(54, 5, 'Шараф-Рашидовский район'),
(55, 5, 'Мирзачульский район'),
(56, 5, 'Пахтакорский район'),
(57, 5, 'Янгиабадский район'),
(58, 5, 'Зааминский район'),
(59, 5, 'Зафарабадский район'),
(60, 5, 'Зарбдарский район'),
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
(77, 7, 'Нуратинский район'),
(78, 7, 'Тамдынский район'),
(79, 7, 'Учкудукский район'),
(80, 8, 'Чиракчинский район'),
(81, 8, 'Дехканабадский район'),
(82, 8, 'Гузарский район'),
(83, 8, 'Камашинский район'),
(84, 8, 'Каршинский район'),
(85, 8, 'Касанский район'),
(86, 8, 'Касбийский район'),
(87, 8, 'Китабский район'),
(88, 8, 'Миришкорский район'),
(89, 8, 'Мубарекский район'),
(90, 8, 'Нишанский район'),
(91, 8, 'Шахрисабзский район'),
(92, 8, 'Яккабагский район'),
(93, 9, 'Булунгурский район'),
(94, 9, 'Иштыханский район'),
(95, 9, 'Джамбайский район'),
(96, 9, 'Каттакурганский район'),
(97, 9, 'Кошрабадский район'),
(98, 9, 'Нарпайский район'),
(99, 9, 'Нурабадский район'),
(100, 9, 'Акдарьинский район'),
(101, 9, 'Пахтачийский район'),
(102, 9, 'Пайарыкский район'),
(103, 9, 'Пастдаргомский район'),
(104, 9, 'Самаркандский район'),
(105, 9, 'Тайлакский район'),
(106, 9, 'Ургутский район'),
(107, 10, 'Акалтынский район'),
(108, 10, 'Баяутский район'),
(109, 10, 'Гулистанский район'),
(110, 10, 'Хавастский район'),
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
(131, 12, 'Кошкупырский район'),
(132, 12, 'Ургенчский район'),
(133, 12, 'Хазараспский район'),
(134, 12, 'Ханкинский район'),
(135, 12, 'Хивинский район'),
(136, 12, 'Шаватский район'),
(137, 12, 'Янгиарыкский район'),
(138, 12, 'Янгибазарский район'),
(139, 12, 'Тупраккалинский район'),
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
(156, 13, 'Элликкалинский район'),
(157, 3, 'Город Бухара');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` smallint(5) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `level` tinyint(4) DEFAULT NULL,
  `division_id` smallint(5) DEFAULT NULL,
  `code` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(65,1) DEFAULT 0.0,
  `price_foreigner` decimal(65,1) DEFAULT 0.0,
  `type` smallint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `branch_id`, `is_active`, `level`, `division_id`, `code`, `name`, `price`, `price_foreigner`, `type`) VALUES
(1, NULL, 1, 1, NULL, NULL, 'Стационарный Осмотр', NULL, NULL, 101);

-- --------------------------------------------------------

--
-- Структура таблицы `service_analyzes`
--

CREATE TABLE `service_analyzes` (
  `id` smallint(5) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `service_id` smallint(5) DEFAULT NULL,
  `name` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `standart` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `session_id` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `self_id` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `self_ip` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `self_login` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `self_render` char(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `self_agent` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_login` datetime DEFAULT current_timestamp(),
  `last_update` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`session_id`, `self_id`, `self_ip`, `self_login`, `self_render`, `self_agent`, `first_login`, `last_update`) VALUES
('91dcf8t9ts84lhp99qas6pfdo43o9jf9l189hqkkegn3qb59', 'master', '127.0.0.1', 'master', '/views/master/logs.php', 'Mozilla/5.0 (X11; Linux x86_64; rv:94.0) Gecko/20100101 Firefox/94.0', '2021-11-23 15:57:40', '2021-11-23 17:06:17');

-- --------------------------------------------------------

--
-- Структура таблицы `sidebar`
--

CREATE TABLE `sidebar` (
  `id` tinyint(3) NOT NULL,
  `level` smallint(2) DEFAULT NULL,
  `sort` tinyint(2) DEFAULT NULL,
  `is_parent` tinyint(1) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `module` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_division` char(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script_item` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge_class` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sidebar`
--

INSERT INTO `sidebar` (`id`, `level`, `sort`, `is_parent`, `parent_id`, `module`, `route`, `icon`, `name`, `is_active`, `is_division`, `script`, `script_item`, `badge_class`) VALUES
(1, 3, 1, NULL, NULL, NULL, 'manager/index', 'icon-users', 'Персонал', '[\"manager/index\"]', NULL, NULL, NULL, NULL),
(2, 3, 2, NULL, NULL, NULL, 'manager/division', 'icon-users4', 'Класификация персонала', '[\"manager/division\"]', NULL, NULL, NULL, NULL),
(3, 3, 3, NULL, NULL, NULL, 'manager/service', 'icon-bag', 'Услуги', '[\"manager/service\"]', NULL, NULL, NULL, NULL),
(4, 3, 4, NULL, NULL, 'module_laboratory', 'manager/analyze', 'icon-fire', 'Анализы', '[\"manager/analyze\"]', NULL, NULL, NULL, NULL),
(5, 3, 5, 1, NULL, NULL, NULL, 'icon-city', 'Объекты', '[\"manager/objects_building\",\"manager/objects_ward\",\"manager/objects_type\",\"manager/objects_bed\"]', NULL, NULL, NULL, NULL),
(6, 3, 1, NULL, 1, NULL, 'manager/objects_building', NULL, 'Объекты', '[\"manager/objects_building\"]', NULL, NULL, NULL, NULL),
(7, 3, 2, NULL, 1, NULL, 'manager/objects_ward', NULL, 'Палаты', '[\"manager/objects_ward\"]', NULL, NULL, NULL, NULL),
(8, 3, 3, NULL, 1, NULL, 'manager/objects_bed', NULL, 'Койки', '[\"manager/objects_bed\"]', NULL, NULL, NULL, NULL),
(9, 3, 4, NULL, 1, NULL, 'manager/objects_type', NULL, 'Типы', '[\"manager/objects_type\"]', NULL, NULL, NULL, NULL),
(10, 3, 6, 2, NULL, NULL, NULL, 'icon-cog2', 'Настройки', '[\"manager/setting_config\",\"manager/setting_prints\"]', NULL, NULL, NULL, NULL),
(11, 3, 1, NULL, 2, NULL, 'manager/setting_config', '', 'Конфигурации', '[\"manager/setting_config\"]', NULL, NULL, NULL, NULL),
(12, 3, 2, NULL, 2, NULL, 'manager/setting_prints', '', 'Документ', '[\"manager/setting_prints\"]', NULL, NULL, NULL, NULL),
(13, 3, 7, NULL, NULL, NULL, 'manager/multi_account', 'icon-switch22', 'Мульти-аккаунт', '[\"manager/multi_account\"]', NULL, NULL, NULL, NULL),
(14, 3, 8, NULL, NULL, NULL, 'manager/guide', 'icon-width', 'Напровители', '[\"manager/guide\"]', NULL, NULL, NULL, NULL),
(15, 3, 9, NULL, NULL, 'module_pharmacy', 'manager/warehouse', 'icon-store', 'Склады', '[\"manager/warehouse\"]', NULL, NULL, NULL, NULL),
(16, 21, 1, NULL, NULL, NULL, 'registry/index', 'icon-display', 'Рабочий стол', '[\"registry/index\"]', NULL, NULL, NULL, NULL),
(17, 21, 2, NULL, NULL, NULL, 'registry/guide', 'icon-width', 'Напровители', '[\"registry/guide\"]', NULL, NULL, NULL, NULL),
(18, 21, 3, NULL, NULL, NULL, 'archive/journal', 'icon-floppy-disk', 'Журнал', '[\"archive/journal\"]', NULL, NULL, NULL, NULL),
(19, 21, 4, NULL, NULL, NULL, 'reports/index', 'icon-stack-text', 'Отчёт', '[\"reports/index\"]', NULL, NULL, NULL, NULL),
(20, 22, 1, NULL, NULL, NULL, 'cashbox/index', 'icon-display', 'Рабочий стол', '[\"cashbox/index\",\"cashbox/stationary\"]', NULL, 'SELECT DISTINCT vss.visit_id, vs.user_id FROM visits vs LEFT JOIN visit_services vss ON(vss.visit_id=vs.id) LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 1', NULL, 'badge bg-primary badge-pill ml-auto'),
(21, 22, 2, NULL, NULL, NULL, 'cashbox/refund', 'icon-reply-all', 'Возврат', '[\"cashbox/refund\",\"cashbox/services_not_accepted\"]', NULL, 'SELECT DISTINCT vss.visit_id, vs.user_id FROM visits vs LEFT JOIN visit_services vss ON(vss.visit_id=vs.id) LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 5', NULL, 'badge bg-danger badge-pill ml-auto'),
(22, 22, 3, NULL, NULL, NULL, 'cashbox/list_payment', 'icon-bookmark', 'История платижей', '[\"cashbox/list_payment\",\"cashbox/detail_payment\"]', NULL, NULL, NULL, NULL),
(23, 22, 4, NULL, NULL, NULL, 'reports/index', 'icon-stack-text', 'Отчёт', '[\"reports/index\"]', NULL, NULL, NULL, NULL),
(24, 11, 1, NULL, NULL, NULL, 'doctor/index', 'icon-user-plus', 'Принять пациента', '[\"doctor/index\"]', NULL, 'SELECT vs.id, vs.user_id, us.birth_date, vs.add_date, vs.service_name, vs.route_id, v.direction, vs.parent_id, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 2 AND vs.level = 5 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = _sk0) OR (vs.parent_id IS NULL AND vs.division_id = _sk1) ) ORDER BY vs.id ASC', '{\"_sk0\":\"session_id\",\"_sk1\":\"session_division\"}', 'badge bg-danger badge-pill ml-auto'),
(25, 11, 2, NULL, NULL, NULL, 'doctor/list_outpatient', 'icon-users2', 'Амбулаторные пациенты', '[\"doctor/list_outpatient\"]', NULL, 'SELECT DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 3 AND vs.level = 5 AND v.direction IS NULL AND vs.parent_id = _sk0 ORDER BY vs.accept_date DESC', '{\"_sk0\":\"session_id\"}', 'badge bg-blue badge-pill ml-auto'),
(26, 11, 3, NULL, NULL, NULL, 'doctor/list_stationary', 'icon-users2', 'Стационарные пациенты', '[\"doctor/list_stationary\"]', NULL, 'SELECT DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 3 AND vs.level = 5 AND v.direction IS NOT NULL AND vs.parent_id = _sk0 AND vs.route_id != _sk0 ORDER BY vs.accept_date DESC', '{\"_sk0\":\"session_id\"}', 'badge bg-success badge-pill ml-auto'),
(27, 11, 4, NULL, NULL, NULL, 'archive/doctor/list', 'icon-collaboration', 'Завершёные пациенты', '[\"archive/doctor/list\", \"archive/doctor/list_visit\"]', NULL, NULL, NULL, NULL),
(28, 11, 5, NULL, NULL, NULL, 'note/index', 'icon-bubbles9', 'Заметки', '[\"note/index\"]', NULL, NULL, NULL, NULL),
(29, 11, 6, NULL, NULL, NULL, 'archive/journal', 'icon-floppy-disk', 'Журнал', '[\"archive/journal\"]', NULL, NULL, NULL, NULL),
(30, 11, 7, NULL, NULL, NULL, 'archive/all/list', 'icon-archive', 'Архив', '[\"archive/all/list\",\"archive/all/list_visit\"]', NULL, NULL, NULL, NULL),
(31, 11, 8, NULL, NULL, NULL, 'reports/index', 'icon-stack-text', 'Отчёт', '[\"reports/index\"]', NULL, NULL, NULL, NULL),
(32, 12, 1, NULL, NULL, 'module_diagnostic', 'diagnostic/index', 'icon-display', 'Рабочий стол', '[\"diagnostic/index\"]', '110', 'SELECT vs.id, vs.user_id, us.birth_date, vs.add_date, vs.service_name, vs.route_id, v.direction, vs.parent_id, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 2 AND vs.level = 10 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = _sk0) OR (vs.parent_id IS NULL AND vs.division_id = _sk1) ) ORDER BY vs.id ASC', '{\"_sk0\":\"session_id\",\"_sk1\":\"session_division\"}', 'badge bg-danger badge-pill ml-auto'),
(33, 12, 2, NULL, NULL, 'module_diagnostic', 'diagnostic/list_outpatient', 'icon-users2', 'Амбулаторные пациенты', '[\"diagnostic/list_outpatient\"]', '101', 'SELECT vs.id, vs.user_id, us.birth_date, vs.accept_date, vs.route_id, vs.service_title, vs.service_name, vs.parent_id, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 3 AND vs.level = 10 AND v.direction IS NULL AND ( vs.parent_id = _sk0 selector ) ORDER BY vs.accept_date DESC', '{\"_sk0\":\"session_id\",\"selector\":1}', 'badge bg-blue badge-pill ml-auto'),
(34, 12, 3, NULL, NULL, 'module_diagnostic', 'diagnostic/list_stationary', 'icon-users2', 'Стационарные пациенты', '[\"diagnostic/list_stationary\"]', '101', 'SELECT vs.id, vs.user_id, us.birth_date, vs.accept_date, vs.route_id, vs.service_title, vs.service_name, vs.parent_id, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 3 AND vs.level = 10 AND v.direction IS NOT NULL AND ( vs.parent_id = _sk0 selector ) ORDER BY vs.accept_date DESC', '{\"_sk0\":\"session_id\",\"selector\":1}', 'badge bg-success badge-pill ml-auto'),
(35, 12, 4, NULL, NULL, 'module_diagnostic', 'archive/diagnostic/list', 'icon-collaboration', 'Завершёные пациенты', '[\"archive/diagnostic/list\", \"archive/diagnostic/list_visit\"]', '101', NULL, NULL, NULL),
(36, 12, 5, NULL, NULL, 'module_diagnostic', 'note/index', 'icon-bubbles9', 'Заметки', '[\"note/index\"]', '111', NULL, NULL, NULL),
(37, 12, 6, NULL, NULL, 'module_diagnostic', 'archive/journal', 'icon-floppy-disk', 'Журнал', '[\"archive/journal\"]', '111', NULL, NULL, NULL),
(38, 12, 7, NULL, NULL, 'module_diagnostic', 'archive/all/list', 'icon-archive', 'Архив', '[\"archive/all/list\",\"archive/all/list_visit\"]', '111', NULL, NULL, NULL),
(39, 12, 8, NULL, NULL, 'module_diagnostic', 'reports/index', 'icon-stack-text', 'Отчёт', '[\"reports/index\"]', '111', NULL, NULL, NULL),
(40, 13, 1, NULL, NULL, 'module_laboratory', 'laboratory/index', 'icon-display', 'Рабочий стол', '[\"laboratory/index\"]', NULL, 'SELECT DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, v.direction, v.add_date, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 2 AND vs.level = 6', NULL, 'badge bg-danger badge-pill ml-auto'),
(41, 13, 2, NULL, NULL, 'module_laboratory', 'laboratory/list_outpatient', 'icon-users2', 'Амбулаторные пациенты', '[\"laboratory/list_outpatient\"]', NULL, 'SELECT DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, v.add_date, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)  LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 3 AND vs.level = 6 AND v.direction IS NULL selector', '{\"selector\":0}', 'badge bg-blue badge-pill ml-auto'),
(42, 13, 3, NULL, NULL, 'module_laboratory', 'laboratory/list_stationary', 'icon-users2', 'Стационарные пациенты', '[\"laboratory/list_stationary\"]', NULL, 'SELECT DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, v.add_date, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)  LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 3 AND vs.level = 6 AND v.direction IS NOT NULL selector', '{\"selector\":0}', 'badge bg-success badge-pill ml-auto'),
(43, 13, 4, NULL, NULL, 'module_laboratory', 'archive/laboratory/list', 'icon-collaboration', 'Завершёные пациенты', '[\"archive/laboratory/list\", \"archive/laboratory/list_visit\"]', NULL, NULL, NULL, NULL),
(44, 13, 5, NULL, NULL, 'module_laboratory', 'note/index', 'icon-bubbles9', 'Заметки', '[\"note/index\"]', NULL, NULL, NULL, NULL),
(45, 13, 6, NULL, NULL, 'module_laboratory', 'archive/journal', 'icon-floppy-disk', 'Журнал', '[\"archive/journal\"]', NULL, NULL, NULL, NULL),
(46, 13, 7, NULL, NULL, 'module_laboratory', 'archive/all/list', 'icon-archive', 'Архив', '[\"archive/all/list\",\"archive/all/list_visit\"]', NULL, NULL, NULL, NULL),
(47, 13, 8, NULL, NULL, 'module_laboratory', 'reports/index', 'icon-stack-text', 'Отчёт', '[\"reports/index\"]', NULL, NULL, NULL, NULL),
(48, 23, 1, NULL, NULL, NULL, 'registry/index', 'icon-display', 'Рабочий стол', '[\"registry/index\"]', NULL, NULL, NULL, NULL),
(49, 23, 2, NULL, NULL, NULL, 'registry/guide', 'icon-width', 'Напровители', '[\"registry/guide\"]', NULL, NULL, NULL, NULL),
(50, 23, 3, NULL, NULL, NULL, 'cashbox/index', 'icon-coins', 'Приём платежей', '[\"cashbox/index\",\"cashbox/stationary\"]', NULL, 'SELECT DISTINCT vss.visit_id, vs.user_id FROM visits vs LEFT JOIN visit_services vss ON(vss.visit_id=vs.id) LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 1', NULL, 'badge bg-primary badge-pill ml-auto'),
(51, 23, 4, NULL, NULL, NULL, 'cashbox/refund', 'icon-reply-all', 'Возврат', '[\"cashbox/refund\",\"cashbox/services_not_accepted\"]', NULL, 'SELECT DISTINCT vss.visit_id, vs.user_id FROM visits vs LEFT JOIN visit_services vss ON(vss.visit_id=vs.id) LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 5', NULL, 'badge bg-danger badge-pill ml-auto'),
(52, 23, 5, NULL, NULL, NULL, 'cashbox/list_payment', 'icon-bookmark', 'История платижей', '[\"cashbox/list_payment\",\"cashbox/detail_payment\"]', NULL, NULL, NULL, NULL),
(53, 23, 6, NULL, NULL, NULL, 'archive/journal', 'icon-floppy-disk', 'Журнал', '[\"archive/journal\"]', NULL, NULL, NULL, NULL),
(54, 23, 7, NULL, NULL, NULL, 'reports/index', 'icon-stack-text', 'Отчёт', '[\"reports/index\"]', NULL, NULL, NULL, NULL),
(55, 14, 1, NULL, NULL, 'module_physio', 'physio/index', 'icon-users2', 'Амбулаторные пациенты', '[\"physio/index\"]', NULL, 'SELECT DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, v.direction, v.add_date, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 2 AND vs.level = 12 AND v.direction IS NULL AND (vs.parent_id IS NULL OR vs.parent_id = _sk0) selector', '{\"_sk0\":\"session_id\",\"selector\":0}', 'badge bg-blue badge-pill ml-auto'),
(56, 14, 2, NULL, NULL, 'module_physio', 'physio/list_stationary', 'icon-users2', 'Стационарные пациенты', '[\"physio/list_stationary\"]', NULL, 'SELECT DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, v.direction, v.add_date, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 2 AND vs.level = 12 AND v.direction IS NOT NULL AND (vs.parent_id IS NULL OR vs.parent_id = _sk0) selector', '{\"_sk0\":\"session_id\",\"selector\":0}', 'badge bg-success badge-pill ml-auto'),
(57, 14, 3, NULL, NULL, 'module_physio', 'archive/physio/list', 'icon-collaboration', 'Завершёные пациенты', '[\"archive/physio/list\", \"archive/physio/list_visit\"]', NULL, NULL, NULL, NULL),
(58, 14, 4, NULL, NULL, 'module_physio', 'note/index', 'icon-bubbles9', 'Заметки', '[\"note/index\"]', NULL, NULL, NULL, NULL),
(59, 14, 5, NULL, NULL, 'module_physio', 'archive/all/list', 'icon-archive', 'Архив', '[\"archive/all/list\",\"archive/all/list_visit\"]', NULL, NULL, NULL, NULL),
(60, 14, 6, NULL, NULL, 'module_physio', 'reports/index', 'icon-stack-text', 'Отчёт', '[\"reports/index\"]', NULL, NULL, NULL, NULL),
(61, 24, 1, NULL, NULL, NULL, 'pharmacy/index', 'icon-display', 'Рабочий стол', '[\"pharmacy/index\"]', NULL, NULL, NULL, NULL),
(62, 24, 2, NULL, NULL, NULL, 'pharmacy/supply', 'icon-book3', 'Поставки', '[\"pharmacy/supply\",\"pharmacy/supply_items\"]', NULL, 'SELECT * FROM warehouse_supply WHERE completed IS NULL AND supply_date = CURRENT_DATE AND parent_id = _sk0', '{\"_sk0\":\"session_id\"}', 'badge bg-danger badge-pill ml-auto'),
(63, 24, 3, NULL, NULL, NULL, 'pharmacy/application', 'icon-clipboard6', 'Заявки', '[\"pharmacy/application\"]', NULL, 'SELECT DISTINCT w.id, w.name, w.parent_id, w.division FROM warehouse_applications wa LEFT JOIN warehouses w ON (w.id=wa.warehouse_id) WHERE wa.status = 2', NULL, 'badge bg-blue badge-pill ml-auto'),
(64, 25, 1, NULL, NULL, NULL, 'nurce/index', 'icon-bookmark', 'Задания', '[\"nurce/index\"]', NULL, '', NULL, 'badge bg-danger badge-pill ml-auto'),
(65, 25, 2, NULL, NULL, NULL, 'nurce/list_stationary', 'icon-users2', 'Стационарные пациенты', '[\"nurce/list_stationary\"]', NULL, NULL, NULL, NULL),
(66, 25, 3, NULL, NULL, NULL, 'archive/journal', 'icon-floppy-disk', 'Журнал', '[\"archive/journal\"]', NULL, NULL, NULL, NULL),
(67, 25, 4, NULL, NULL, NULL, 'note/index', 'icon-bubbles9', 'Заметки', '[\"note/index\"]', NULL, NULL, NULL, NULL),
(68, 15, 1, NULL, NULL, NULL, 'anesthetist/index', 'icon-user-plus', 'Принять пациента', '[\"anesthetist/index\"]', NULL, 'SELECT vs.id, vs.user_id, us.birth_date, vs.add_date, vs.service_name, vs.route_id, v.direction, vs.parent_id, vr.id \'order\' FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id) WHERE vs.status = 2 AND vs.level = 5 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = _sk0) OR (vs.parent_id IS NULL AND vs.division_id = _sk1) ) ORDER BY vs.id ASC', '{\"_sk0\":\"session_id\",\"_sk1\":\"session_division\"}', 'badge bg-danger badge-pill ml-auto');

-- --------------------------------------------------------

--
-- Структура таблицы `templates`
--

CREATE TABLE `templates` (
  `id` mediumint(7) NOT NULL,
  `autor_id` int(11) DEFAULT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `username` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` char(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `first_name` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_level` tinyint(4) NOT NULL,
  `division_id` smallint(5) DEFAULT NULL,
  `pacs_login` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pacs_password` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `branch_id`, `username`, `password`, `is_active`, `first_name`, `last_name`, `father_name`, `user_level`, `division_id`, `pacs_login`, `pacs_password`, `add_date`) VALUES
(1, NULL, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'admin', 'admin', 'admin', 1, NULL, NULL, NULL, NULL),
(2, 1, 'man', '8175e3c8753aeb1696959f72ede260ebf3ea14c5', 1, 'man', 'man', 'man', 3, NULL, NULL, NULL, '2021-11-22 17:38:58');

-- --------------------------------------------------------

--
-- Структура таблицы `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `client_id` int(11) DEFAULT NULL,
  `direction` tinyint(1) DEFAULT NULL,
  `parad_id` int(11) DEFAULT NULL,
  `grant_id` int(11) DEFAULT NULL,
  `division_id` smallint(5) DEFAULT NULL,
  `icd_id` smallint(5) DEFAULT NULL,
  `icd_autor` int(11) DEFAULT NULL,
  `discharge_date` date DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp(),
  `last_update` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_analyzes`
--

CREATE TABLE `visit_analyzes` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `visit_service_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `service_id` smallint(5) DEFAULT NULL,
  `service_analyze_id` smallint(5) DEFAULT NULL,
  `service_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `analyze_name` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deviation` tinyint(1) DEFAULT NULL,
  `description` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_beds`
--

CREATE TABLE `visit_beds` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `bed_id` smallint(5) DEFAULT NULL,
  `location` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` decimal(65,1) DEFAULT 0.0,
  `start_date` datetime DEFAULT current_timestamp(),
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_bypass`
--

CREATE TABLE `visit_bypass` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` char(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` tinyint(2) DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_bypass_events`
--

CREATE TABLE `visit_bypass_events` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `visit_bypass_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `event_title` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_start` datetime DEFAULT NULL,
  `event_end` datetime DEFAULT NULL,
  `event_completed` tinyint(1) DEFAULT NULL,
  `event_fail` tinyint(1) DEFAULT NULL,
  `event_comment` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completed_responsible_id` int(11) DEFAULT NULL,
  `completed_date` datetime DEFAULT NULL,
  `fail_responsible_id` int(11) DEFAULT NULL,
  `fail_date` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_bypass_event_applications`
--

CREATE TABLE `visit_bypass_event_applications` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `visit_bypass_event_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `warehouse_id` smallint(5) DEFAULT NULL,
  `warehouse_order` tinyint(1) DEFAULT NULL,
  `item_name_id` int(11) DEFAULT NULL,
  `item_manufacturer_id` tinyint(3) DEFAULT NULL,
  `item_price` decimal(65,1) DEFAULT 0.0,
  `item_qty` mediumint(7) DEFAULT 0,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_bypass_transactions`
--

CREATE TABLE `visit_bypass_transactions` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `visit_bypass_event_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `item_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_manufacturer` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_qty` int(11) DEFAULT NULL,
  `item_cost` decimal(65,1) DEFAULT 0.0,
  `price` decimal(65,1) DEFAULT 0.0,
  `is_price` tinyint(1) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_documents`
--

CREATE TABLE `visit_documents` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `file_format` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `file_extension` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mark` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(755) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_icd_history`
--

CREATE TABLE `visit_icd_history` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `icd_id` smallint(5) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_investments`
--

CREATE TABLE `visit_investments` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `pricer_id` int(11) DEFAULT NULL,
  `balance_cash` decimal(65,1) DEFAULT 0.0,
  `balance_card` decimal(65,1) DEFAULT 0.0,
  `balance_transfer` decimal(65,1) DEFAULT 0.0,
  `expense` tinyint(1) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp(),
  `expense_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_journals`
--

CREATE TABLE `visit_journals` (
  `id` mediumint(7) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `record` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_operations`
--

CREATE TABLE `visit_operations` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `grant_id` int(11) DEFAULT NULL,
  `division_id` smallint(5) DEFAULT NULL,
  `operation_id` smallint(5) DEFAULT NULL,
  `operation_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operation_cost` decimal(65,1) DEFAULT 0.0,
  `operation_date` date DEFAULT NULL,
  `operation_time` time DEFAULT NULL,
  `operation_end_date` date DEFAULT NULL,
  `operation_end_time` time DEFAULT NULL,
  `completed` tinyint(1) DEFAULT NULL,
  `completed_date` datetime DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_operation_consumables`
--

CREATE TABLE `visit_operation_consumables` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `creater_id` int(11) DEFAULT NULL,
  `item_name` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_cost` decimal(65,1) DEFAULT 0.0,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_operation_journals`
--

CREATE TABLE `visit_operation_journals` (
  `id` mediumint(7) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `record` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_operation_members`
--

CREATE TABLE `visit_operation_members` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `creater_id` int(11) DEFAULT NULL,
  `member_name` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_operator` tinyint(1) DEFAULT NULL,
  `member_price` decimal(65,1) DEFAULT 0.0,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_operation_services`
--

CREATE TABLE `visit_operation_services` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `creater_id` int(11) DEFAULT NULL,
  `item_id` smallint(5) DEFAULT NULL,
  `item_responsible_id` int(11) DEFAULT NULL,
  `item_name` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_cost` decimal(65,1) DEFAULT 0.0,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_operation_stats`
--

CREATE TABLE `visit_operation_stats` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `creater_id` int(11) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `pressure` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pulse` smallint(11) DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `saturation` tinyint(4) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_orders`
--

CREATE TABLE `visit_orders` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `order_number` smallint(5) DEFAULT NULL,
  `order_author` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_sales`
--

CREATE TABLE `visit_sales` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `sale_bed` float DEFAULT 0,
  `sale_bed_unit` decimal(65,1) DEFAULT 0.0,
  `sale_service` float DEFAULT 0,
  `sale_service_unit` decimal(65,1) DEFAULT 0.0,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_services`
--

CREATE TABLE `visit_services` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `division_id` smallint(5) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `assist_id` int(11) DEFAULT NULL,
  `guide_id` mediumint(7) DEFAULT NULL,
  `service_id` smallint(5) DEFAULT NULL,
  `service_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_title` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_report` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failure_id` int(11) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp(),
  `accept_date` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_service_transactions`
--

CREATE TABLE `visit_service_transactions` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `visit_service_id` int(11) DEFAULT NULL,
  `item_id` smallint(5) DEFAULT NULL,
  `item_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_type` tinyint(4) DEFAULT NULL,
  `item_cost` decimal(65,1) DEFAULT 0.0,
  `client_id` int(11) DEFAULT NULL,
  `pricer_id` int(11) DEFAULT NULL,
  `price_cash` decimal(65,1) DEFAULT 0.0,
  `price_card` decimal(65,1) DEFAULT 0.0,
  `price_transfer` decimal(65,1) DEFAULT 0.0,
  `sale` float DEFAULT 0,
  `is_visibility` tinyint(1) DEFAULT NULL,
  `is_price` tinyint(1) DEFAULT NULL,
  `price_date` datetime DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `visit_stats`
--

CREATE TABLE `visit_stats` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `stat` tinyint(1) DEFAULT NULL,
  `pressure` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pulse` smallint(5) DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `saturation` tinyint(4) DEFAULT NULL,
  `breath` float DEFAULT NULL,
  `urine` float DEFAULT NULL,
  `description` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `wards`
--

CREATE TABLE `wards` (
  `id` smallint(5) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `building_id` tinyint(2) DEFAULT NULL,
  `division_id` smallint(5) DEFAULT NULL,
  `floor` tinyint(3) DEFAULT NULL,
  `ward` smallint(6) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `wards`
--

INSERT INTO `wards` (`id`, `branch_id`, `building_id`, `division_id`, `floor`, `ward`, `add_date`) VALUES
(2, 1, 1, 1, 1, 101, '2021-11-22 17:42:03');

-- --------------------------------------------------------

--
-- Структура таблицы `warehouses`
--

CREATE TABLE `warehouses` (
  `id` smallint(5) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `name` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `level` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_applications`
--

CREATE TABLE `warehouse_applications` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `warehouse_id` smallint(5) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `item_name_id` int(11) DEFAULT NULL,
  `item_manufacturer_id` tinyint(3) DEFAULT NULL,
  `item_qty` mediumint(7) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_common`
--

CREATE TABLE `warehouse_common` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `item_name_id` int(11) DEFAULT NULL,
  `item_manufacturer_id` tinyint(3) DEFAULT NULL,
  `item_qty` mediumint(7) DEFAULT NULL,
  `item_price` decimal(65,1) DEFAULT 0.0,
  `item_die_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_common_transactions`
--

CREATE TABLE `warehouse_common_transactions` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `warehouse_id` smallint(5) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_manufacturer` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_qty` int(11) DEFAULT NULL,
  `item_price` decimal(65,1) DEFAULT 0.0,
  `tran_status` tinyint(1) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `cost` decimal(65,1) DEFAULT 0.0,
  `price_cash` decimal(65,1) DEFAULT 0.0,
  `price_card` decimal(65,1) DEFAULT 0.0,
  `price_transfer` decimal(65,1) DEFAULT 0.0,
  `is_price` tinyint(1) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_custom`
--

CREATE TABLE `warehouse_custom` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `warehouse_id` smallint(5) DEFAULT NULL,
  `item_name_id` int(11) DEFAULT NULL,
  `item_manufacturer_id` tinyint(3) DEFAULT NULL,
  `item_qty` mediumint(7) DEFAULT NULL,
  `item_price` decimal(65,1) DEFAULT 0.0,
  `item_die_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_item_manufacturers`
--

CREATE TABLE `warehouse_item_manufacturers` (
  `id` tinyint(3) NOT NULL,
  `manufacturer` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_item_names`
--

CREATE TABLE `warehouse_item_names` (
  `id` mediumint(7) NOT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shtrih` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_item_suppliers`
--

CREATE TABLE `warehouse_item_suppliers` (
  `id` smallint(5) NOT NULL,
  `supplier` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacts` char(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_orders`
--

CREATE TABLE `warehouse_orders` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `item_name_id` int(11) DEFAULT NULL,
  `item_manufacturer_id` tinyint(3) DEFAULT NULL,
  `item_qty` mediumint(7) DEFAULT NULL,
  `item_die_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_settings`
--

CREATE TABLE `warehouse_settings` (
  `id` mediumint(7) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `warehouse_id` smallint(5) DEFAULT NULL,
  `division_id` smallint(5) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_supply`
--

CREATE TABLE `warehouse_supply` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `uniq_key` char(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_order` tinyint(1) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp(),
  `supply_date` date DEFAULT NULL,
  `completed` tinyint(1) DEFAULT NULL,
  `completed_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse_supply_items`
--

CREATE TABLE `warehouse_supply_items` (
  `id` int(11) NOT NULL,
  `branch_id` smallint(5) DEFAULT NULL,
  `uniq_key` char(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_name_id` int(11) DEFAULT NULL,
  `item_manufacturer_id` tinyint(3) DEFAULT NULL,
  `item_supplier_id` smallint(5) DEFAULT NULL,
  `item_qty` mediumint(7) DEFAULT NULL,
  `item_cost` decimal(65,1) DEFAULT 0.0,
  `item_price` decimal(65,1) DEFAULT 0.0,
  `item_faktura` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_die_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `building_id` (`branch_id`,`building_id`,`floor`,`ward_id`,`bed`) USING BTREE,
  ADD KEY `building_id_2` (`building_id`),
  ADD KEY `ward_id` (`ward_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Индексы таблицы `bed_types`
--
ALTER TABLE `bed_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Индексы таблицы `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `responsible_id` (`responsible_id`),
  ADD KEY `province_id` (`province_id`),
  ADD KEY `region_id` (`region_id`);

--
-- Индексы таблицы `corp_branchs`
--
ALTER TABLE `corp_branchs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `corp_constants`
--
ALTER TABLE `corp_constants`
  ADD PRIMARY KEY (`const_label`);

--
-- Индексы таблицы `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_id` (`branch_id`,`mark`) USING BTREE;

--
-- Индексы таблицы `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `international_classification_diseases`
--
ALTER TABLE `international_classification_diseases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Индексы таблицы `multi_accounts`
--
ALTER TABLE `multi_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `package_bypass`
--
ALTER TABLE `package_bypass`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `package_services`
--
ALTER TABLE `package_services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_id` (`branch_id`,`code`) USING BTREE,
  ADD KEY `division_id` (`division_id`);

--
-- Индексы таблицы `service_analyzes`
--
ALTER TABLE `service_analyzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Индексы таблицы `sidebar`
--
ALTER TABLE `sidebar`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `division_id` (`division_id`);

--
-- Индексы таблицы `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `division_id` (`division_id`),
  ADD KEY `grant_id` (`grant_id`),
  ADD KEY `icd_id` (`icd_id`);

--
-- Индексы таблицы `visit_analyzes`
--
ALTER TABLE `visit_analyzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `service_analyze_id` (`service_analyze_id`),
  ADD KEY `visit_id` (`visit_id`),
  ADD KEY `visit_service_id` (`visit_service_id`);

--
-- Индексы таблицы `visit_beds`
--
ALTER TABLE `visit_beds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `bed_id` (`bed_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `responsible_id` (`responsible_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_bypass`
--
ALTER TABLE `visit_bypass`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `visit_id` (`visit_id`),
  ADD KEY `responsible_id` (`responsible_id`);

--
-- Индексы таблицы `visit_bypass_events`
--
ALTER TABLE `visit_bypass_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `completed_responsible_id` (`completed_responsible_id`),
  ADD KEY `fail_responsible_id` (`fail_responsible_id`),
  ADD KEY `responsible_id` (`responsible_id`),
  ADD KEY `visit_bypass_id` (`visit_bypass_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_bypass_event_applications`
--
ALTER TABLE `visit_bypass_event_applications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `visit_bypass_transactions`
--
ALTER TABLE `visit_bypass_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `visit_documents`
--
ALTER TABLE `visit_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `visit_id` (`visit_id`),
  ADD KEY `responsible_id` (`responsible_id`);

--
-- Индексы таблицы `visit_icd_history`
--
ALTER TABLE `visit_icd_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `icd_id` (`icd_id`),
  ADD KEY `responsible_id` (`responsible_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_investments`
--
ALTER TABLE `visit_investments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `pricer_id` (`pricer_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_journals`
--
ALTER TABLE `visit_journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `visit_id` (`visit_id`),
  ADD KEY `responsible_id` (`responsible_id`);

--
-- Индексы таблицы `visit_operations`
--
ALTER TABLE `visit_operations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `division_id` (`division_id`),
  ADD KEY `grant_id` (`grant_id`),
  ADD KEY `visit_id` (`visit_id`),
  ADD KEY `operation_id` (`operation_id`);

--
-- Индексы таблицы `visit_operation_consumables`
--
ALTER TABLE `visit_operation_consumables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `creater_id` (`creater_id`),
  ADD KEY `operation_id` (`operation_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_operation_journals`
--
ALTER TABLE `visit_operation_journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `operation_id` (`operation_id`),
  ADD KEY `responsible_id` (`responsible_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_operation_members`
--
ALTER TABLE `visit_operation_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `creater_id` (`creater_id`),
  ADD KEY `operation_id` (`operation_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_operation_services`
--
ALTER TABLE `visit_operation_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `creater_id` (`creater_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `item_responsible_id` (`item_responsible_id`),
  ADD KEY `operation_id` (`operation_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_operation_stats`
--
ALTER TABLE `visit_operation_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `creater_id` (`creater_id`),
  ADD KEY `operation_id` (`operation_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_orders`
--
ALTER TABLE `visit_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `responsible_id` (`responsible_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_sales`
--
ALTER TABLE `visit_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `responsible_id` (`responsible_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `visit_services`
--
ALTER TABLE `visit_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `assist_id` (`assist_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `division_id` (`division_id`),
  ADD KEY `failure_id` (`failure_id`),
  ADD KEY `responsible_id` (`responsible_id`),
  ADD KEY `route_id` (`route_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `visit_id` (`visit_id`),
  ADD KEY `guide_id` (`guide_id`);

--
-- Индексы таблицы `visit_service_transactions`
--
ALTER TABLE `visit_service_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `pricer_id` (`pricer_id`),
  ADD KEY `visit_id` (`visit_id`),
  ADD KEY `visit_service_id` (`visit_service_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Индексы таблицы `visit_stats`
--
ALTER TABLE `visit_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `responsible_id` (`responsible_id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Индексы таблицы `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_id` (`branch_id`,`building_id`,`floor`,`ward`) USING BTREE,
  ADD KEY `building_id` (`building_id`),
  ADD KEY `division_id` (`division_id`);

--
-- Индексы таблицы `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_applications`
--
ALTER TABLE `warehouse_applications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_common`
--
ALTER TABLE `warehouse_common`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_common_transactions`
--
ALTER TABLE `warehouse_common_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_custom`
--
ALTER TABLE `warehouse_custom`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_item_manufacturers`
--
ALTER TABLE `warehouse_item_manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_item_names`
--
ALTER TABLE `warehouse_item_names`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_item_suppliers`
--
ALTER TABLE `warehouse_item_suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_orders`
--
ALTER TABLE `warehouse_orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_settings`
--
ALTER TABLE `warehouse_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_supply`
--
ALTER TABLE `warehouse_supply`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `warehouse_supply_items`
--
ALTER TABLE `warehouse_supply_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `beds`
--
ALTER TABLE `beds`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `bed_types`
--
ALTER TABLE `bed_types`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `corp_branchs`
--
ALTER TABLE `corp_branchs`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `guides`
--
ALTER TABLE `guides`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `international_classification_diseases`
--
ALTER TABLE `international_classification_diseases`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `multi_accounts`
--
ALTER TABLE `multi_accounts`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `package_bypass`
--
ALTER TABLE `package_bypass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `package_services`
--
ALTER TABLE `package_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `province`
--
ALTER TABLE `province`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `region`
--
ALTER TABLE `region`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `service_analyzes`
--
ALTER TABLE `service_analyzes`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sidebar`
--
ALTER TABLE `sidebar`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT для таблицы `templates`
--
ALTER TABLE `templates`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_analyzes`
--
ALTER TABLE `visit_analyzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_beds`
--
ALTER TABLE `visit_beds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_bypass`
--
ALTER TABLE `visit_bypass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_bypass_events`
--
ALTER TABLE `visit_bypass_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_bypass_event_applications`
--
ALTER TABLE `visit_bypass_event_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_bypass_transactions`
--
ALTER TABLE `visit_bypass_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_documents`
--
ALTER TABLE `visit_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_icd_history`
--
ALTER TABLE `visit_icd_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_investments`
--
ALTER TABLE `visit_investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_journals`
--
ALTER TABLE `visit_journals`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_operations`
--
ALTER TABLE `visit_operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_operation_consumables`
--
ALTER TABLE `visit_operation_consumables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_operation_journals`
--
ALTER TABLE `visit_operation_journals`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_operation_members`
--
ALTER TABLE `visit_operation_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_operation_services`
--
ALTER TABLE `visit_operation_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_operation_stats`
--
ALTER TABLE `visit_operation_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_orders`
--
ALTER TABLE `visit_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_sales`
--
ALTER TABLE `visit_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_services`
--
ALTER TABLE `visit_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_service_transactions`
--
ALTER TABLE `visit_service_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visit_stats`
--
ALTER TABLE `visit_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wards`
--
ALTER TABLE `wards`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_applications`
--
ALTER TABLE `warehouse_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_common`
--
ALTER TABLE `warehouse_common`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_common_transactions`
--
ALTER TABLE `warehouse_common_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_custom`
--
ALTER TABLE `warehouse_custom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_item_manufacturers`
--
ALTER TABLE `warehouse_item_manufacturers`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_item_names`
--
ALTER TABLE `warehouse_item_names`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_item_suppliers`
--
ALTER TABLE `warehouse_item_suppliers`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_orders`
--
ALTER TABLE `warehouse_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_settings`
--
ALTER TABLE `warehouse_settings`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_supply`
--
ALTER TABLE `warehouse_supply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `warehouse_supply_items`
--
ALTER TABLE `warehouse_supply_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `beds`
--
ALTER TABLE `beds`
  ADD CONSTRAINT `beds_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beds_ibfk_2` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beds_ibfk_3` FOREIGN KEY (`ward_id`) REFERENCES `wards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beds_ibfk_5` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `beds_ibfk_6` FOREIGN KEY (`ward_id`) REFERENCES `wards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beds_ibfk_7` FOREIGN KEY (`type_id`) REFERENCES `bed_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `bed_types`
--
ALTER TABLE `bed_types`
  ADD CONSTRAINT `bed_types_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `buildings`
--
ALTER TABLE `buildings`
  ADD CONSTRAINT `buildings_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `clients_ibfk_3` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `divisions`
--
ALTER TABLE `divisions`
  ADD CONSTRAINT `divisions_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `multi_accounts`
--
ALTER TABLE `multi_accounts`
  ADD CONSTRAINT `multi_accounts_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `multi_accounts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `region_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `services_ibfk_2` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `service_analyzes`
--
ALTER TABLE `service_analyzes`
  ADD CONSTRAINT `service_analyzes_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_analyzes_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `templates`
--
ALTER TABLE `templates`
  ADD CONSTRAINT `templates_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visits_ibfk_3` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visits_ibfk_4` FOREIGN KEY (`grant_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visits_ibfk_5` FOREIGN KEY (`icd_id`) REFERENCES `international_classification_diseases` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_analyzes`
--
ALTER TABLE `visit_analyzes`
  ADD CONSTRAINT `visit_analyzes_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_analyzes_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_analyzes_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_analyzes_ibfk_4` FOREIGN KEY (`service_analyze_id`) REFERENCES `service_analyzes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_analyzes_ibfk_5` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_analyzes_ibfk_6` FOREIGN KEY (`visit_service_id`) REFERENCES `visit_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_beds`
--
ALTER TABLE `visit_beds`
  ADD CONSTRAINT `visit_beds_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_beds_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_beds_ibfk_4` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_beds_ibfk_5` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_bypass`
--
ALTER TABLE `visit_bypass`
  ADD CONSTRAINT `visit_bypass_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_bypass_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_bypass_ibfk_3` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_bypass_ibfk_4` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_bypass_events`
--
ALTER TABLE `visit_bypass_events`
  ADD CONSTRAINT `visit_bypass_events_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_bypass_events_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_bypass_events_ibfk_3` FOREIGN KEY (`completed_responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_bypass_events_ibfk_4` FOREIGN KEY (`fail_responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_bypass_events_ibfk_5` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_bypass_events_ibfk_6` FOREIGN KEY (`visit_bypass_id`) REFERENCES `visit_bypass` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_bypass_events_ibfk_7` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_documents`
--
ALTER TABLE `visit_documents`
  ADD CONSTRAINT `visit_documents_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_documents_ibfk_2` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_documents_ibfk_3` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_icd_history`
--
ALTER TABLE `visit_icd_history`
  ADD CONSTRAINT `visit_icd_history_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_icd_history_ibfk_2` FOREIGN KEY (`icd_id`) REFERENCES `international_classification_diseases` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_icd_history_ibfk_3` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_icd_history_ibfk_4` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_investments`
--
ALTER TABLE `visit_investments`
  ADD CONSTRAINT `visit_investments_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_investments_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_investments_ibfk_3` FOREIGN KEY (`pricer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_investments_ibfk_4` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_journals`
--
ALTER TABLE `visit_journals`
  ADD CONSTRAINT `visit_journals_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_journals_ibfk_2` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_journals_ibfk_3` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_operations`
--
ALTER TABLE `visit_operations`
  ADD CONSTRAINT `visit_operations_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operations_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operations_ibfk_3` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operations_ibfk_4` FOREIGN KEY (`grant_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operations_ibfk_5` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operations_ibfk_6` FOREIGN KEY (`operation_id`) REFERENCES `services` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_operation_consumables`
--
ALTER TABLE `visit_operation_consumables`
  ADD CONSTRAINT `visit_operation_consumables_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_consumables_ibfk_2` FOREIGN KEY (`creater_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_consumables_ibfk_3` FOREIGN KEY (`operation_id`) REFERENCES `visit_operations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_consumables_ibfk_4` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_operation_journals`
--
ALTER TABLE `visit_operation_journals`
  ADD CONSTRAINT `visit_operation_journals_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_journals_ibfk_2` FOREIGN KEY (`operation_id`) REFERENCES `visit_operations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_journals_ibfk_3` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_journals_ibfk_4` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_operation_members`
--
ALTER TABLE `visit_operation_members`
  ADD CONSTRAINT `visit_operation_members_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_members_ibfk_2` FOREIGN KEY (`creater_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_members_ibfk_3` FOREIGN KEY (`operation_id`) REFERENCES `visit_operations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_members_ibfk_4` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_operation_services`
--
ALTER TABLE `visit_operation_services`
  ADD CONSTRAINT `visit_operation_services_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_services_ibfk_2` FOREIGN KEY (`creater_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_services_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `services` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_services_ibfk_4` FOREIGN KEY (`item_responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_services_ibfk_5` FOREIGN KEY (`operation_id`) REFERENCES `visit_operations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_services_ibfk_6` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_operation_stats`
--
ALTER TABLE `visit_operation_stats`
  ADD CONSTRAINT `visit_operation_stats_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_stats_ibfk_2` FOREIGN KEY (`creater_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_stats_ibfk_3` FOREIGN KEY (`operation_id`) REFERENCES `visit_operations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_operation_stats_ibfk_4` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_orders`
--
ALTER TABLE `visit_orders`
  ADD CONSTRAINT `visit_orders_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_orders_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_orders_ibfk_3` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_orders_ibfk_4` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_sales`
--
ALTER TABLE `visit_sales`
  ADD CONSTRAINT `visit_sales_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_sales_ibfk_2` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_sales_ibfk_3` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_services`
--
ALTER TABLE `visit_services`
  ADD CONSTRAINT `visit_services_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_services_ibfk_10` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_services_ibfk_2` FOREIGN KEY (`assist_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_services_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_services_ibfk_4` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_services_ibfk_5` FOREIGN KEY (`failure_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_services_ibfk_6` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_services_ibfk_7` FOREIGN KEY (`route_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_services_ibfk_8` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_services_ibfk_9` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_service_transactions`
--
ALTER TABLE `visit_service_transactions`
  ADD CONSTRAINT `visit_service_transactions_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_service_transactions_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_service_transactions_ibfk_3` FOREIGN KEY (`pricer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_service_transactions_ibfk_4` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_service_transactions_ibfk_5` FOREIGN KEY (`visit_service_id`) REFERENCES `visit_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_service_transactions_ibfk_6` FOREIGN KEY (`item_id`) REFERENCES `services` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `visit_stats`
--
ALTER TABLE `visit_stats`
  ADD CONSTRAINT `visit_stats_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_stats_ibfk_2` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_stats_ibfk_3` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `wards`
--
ALTER TABLE `wards`
  ADD CONSTRAINT `wards_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `corp_branchs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wards_ibfk_2` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wards_ibfk_3` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
