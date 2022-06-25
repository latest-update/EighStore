-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 25 2022 г., 21:01
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kz_eighstore`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cash_bank`
--

CREATE TABLE `cash_bank` (
  `MB-ID` int NOT NULL,
  `ORDER-ID` int DEFAULT NULL,
  `ADDED-CASH` int DEFAULT NULL,
  `PAYMENT-TYPE` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `CATEGORY-ID` int NOT NULL,
  `CATEGORY-NAME` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Имя категории',
  `SUBCATEGORY-NAME` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Имя подкатегории',
  `SUBSUBCATEGORY-NAME` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Тип товара(Под-Подкатегория)(Если имеется)',
  `CATEGORY-IMAGE` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`CATEGORY-ID`, `CATEGORY-NAME`, `SUBCATEGORY-NAME`, `SUBSUBCATEGORY-NAME`, `CATEGORY-IMAGE`) VALUES
(1, 'Лампы', 'Светодиодные', NULL, 'imgs/lamp.png'),
(2, 'Лампы', 'Накаливание', NULL, 'imgs/lamp.png'),
(3, 'Лампы', 'Люминесцентные', NULL, 'imgs/lamp.png'),
(4, 'Лампы', 'Галогенные', NULL, 'imgs/lamp.png'),
(5, 'Лампы', 'Энергосберегающие', NULL, 'imgs/lamp.png'),
(8, 'Прожектора', 'Металлогалогенные', NULL, 'imgs/projector.png'),
(9, 'Прожектора', 'Натриевые', NULL, 'imgs/projector.png'),
(10, 'Прожектора', 'Светодиодные', NULL, 'imgs/projector.png'),
(30, 'Прожектора', 'Галогенные', NULL, 'imgs/projector.png'),
(31, 'Лампы', 'Лайт', NULL, 'imgs/lamp.png'),
(32, 'Лампы', 'Daryn', NULL, 'imgs/lamp.png');

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_price`
--

CREATE TABLE `delivery_price` (
  `ID` int NOT NULL,
  `CITY` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ГОРОД',
  `DELIVER-TYPE` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ТИП ДОСТАВКИ',
  `COST` int DEFAULT NULL COMMENT 'ЦЕНА ДОСТАВКИ',
  `PERIOD` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'СРОК ДОСТАВКИ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `delivery_price`
--

INSERT INTO `delivery_price` (`ID`, `CITY`, `DELIVER-TYPE`, `COST`, `PERIOD`) VALUES
(1, 'Алматы', 'Доставка', 1000, '1'),
(2, 'Алматы', 'Самовывоз', 0, '1'),
(3, 'Астана', 'Казпочта', 2000, '7-14'),
(4, 'Караганды', 'Казпочта', 2000, '7-14');

-- --------------------------------------------------------

--
-- Структура таблицы `kaspi_payment`
--

CREATE TABLE `kaspi_payment` (
  `KP-ID` int NOT NULL COMMENT 'KASPI PAYMENT ID',
  `ORDER-ID` int DEFAULT NULL COMMENT 'ID ЗАКАЗА',
  `PAYMENT-INFO` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'КАСПИ НОМЕР ПОКУПАТЕЛЯ',
  `STATUS` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'СТАТУС ОПЛАТЫ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kaspi_payment`
--

INSERT INTO `kaspi_payment` (`KP-ID`, `ORDER-ID`, `PAYMENT-INFO`, `STATUS`) VALUES
(10, 23, '87478801397', 'Ожидание отправки счета для оплаты'),
(35, 57, '87478801397', 'Ожидание отправки счета для оплаты'),
(37, 61, '87878787878', 'Ожидание отправки счета для оплаты'),
(38, 63, '87487864864', 'Ожидание отправки счета для оплаты'),
(39, 66, '87478801397', 'Ожидание отправки счета для оплаты'),
(40, 67, '87478801397', 'Ожидание отправки счета для оплаты'),
(41, 68, '87478801397', 'Ожидание отправки счета для оплаты'),
(42, 71, '87478801397', 'Ожидание отправки счета для оплаты'),
(43, 72, '87484864864', 'Ожидание отправки счета для оплаты'),
(44, 73, '87478484646', 'Ожидание отправки счета для оплаты'),
(45, 75, '87478801397', 'Ожидание отправки счета для оплаты'),
(46, 76, '87484864864', 'Ожидание отправки счета для оплаты'),
(47, 77, '87781328796', 'Ожидание отправки счета для оплаты'),
(48, 78, '87484864864', 'Ожидание отправки счета для оплаты'),
(49, 79, '87478801397', 'Ожидание отправки счета для оплаты');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `ID` int NOT NULL,
  `LOGIN` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ID ЗАКАЗЫВАЮЩЕГО',
  `TIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ВРЕМЯ ОФОРМЛЕНИЕ ЗАКАЗА',
  `ORDER-JSON` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'ТОВАРЫ НА ОФОРМЛЕНИЕ ЗАКАЗА',
  `TOTAL` int DEFAULT NULL COMMENT 'ИТОГОВАЯ ЦЕНА',
  `ORDER-STAMP` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'НОМЕР ЗАКАЗА',
  `DELIVERY-PRICE` int DEFAULT NULL COMMENT 'СТОИМОСТЬ ДОСТАВКИ',
  `CITY` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ADDRESS` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `DELIVER-TYPE` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NAME-FAMILY` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TELNUM` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `STATUS` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'СТАТУС ЗАКАЗА',
  `PAYMENT-TYPE` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DONE` int NOT NULL DEFAULT '0' COMMENT 'СТАДИЯ ОФОРМЛЕНИЕ ЗАКАЗА, Т.Е ЕСЛИ ПОКУПАТЕЛЬ УЖЕ ОФОРМИЛ ТО ЗН. 1 В ДР СЛ. = 0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`ID`, `LOGIN`, `TIME`, `ORDER-JSON`, `TOTAL`, `ORDER-STAMP`, `DELIVERY-PRICE`, `CITY`, `ADDRESS`, `DELIVER-TYPE`, `NAME-FAMILY`, `TELNUM`, `STATUS`, `PAYMENT-TYPE`, `DONE`) VALUES
(23, 'unauthorized', '2021-07-12 12:58:57', '{\"2\":[2,1]}', 350, '669963773436', 2000, 'Астана', 'С. Абай, Карасайский район, Женис 21', 'Казпочта', 'Rakhat Bakytzhanov', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(55, 'unauthorized', '2021-07-25 07:15:54', '{\"3\":[3,1]}', 350, '491180742047', 2000, 'Алматы', 'Жибек жолы 11б', 'Доставка', 'Данияр Бауыржанов', '87088798484', 'Ожидание отправки счета для оплаты', 'cardPay', 1),
(56, 'idiksidik', '2021-07-25 07:21:27', '{\"3\":[3,1]}', 350, '698960573562', 1000, 'Алматы', 'Жибек жолы 11б', 'Доставка', 'Нияз Баубек', '87475454455', 'Ожидание оплаты', 'kaspi', 2),
(57, 'singlephon', '2021-07-26 18:46:29', '{\"3\":[3,1]}', 350, '975815957370', 2000, 'Астана', 'С. Абай, Карасайский район, Женис 21', 'Казпочта', 'Рахат Бакытжанов', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(61, 'singlephon', '2021-07-29 18:00:31', '{\"2\":[2,5],\"3\":[3,1],\"19\":[19,30]}', 21600, '569663527397', 0, 'Караганды', '29, Dechtilan', 'Казпочта', 'Рахат Бакытжанов', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(62, 'singlephon', '2021-07-29 18:17:18', '{\"2\":[2,5],\"3\":[3,1],\"19\":[19,30]}', 21600, '697848853815', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(63, 'singlephon', '2021-07-31 16:15:39', '{\"2\":[2,5],\"3\":[3,1]}', 2100, '558438084752', 1000, 'Алматы', 'С. Абай, Карасайский район, Женис 21', 'Доставка', 'Рахат Бакытжанов', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(64, 'singlephon', '2021-07-31 16:26:19', '{\"2\":[2,5],\"3\":[3,1],\"19\":[19,5]}', 5350, '92395159499', 2000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(65, 'unauthorized', '2021-08-06 16:46:03', '{\"2\":[2,5],\"3\":[3,1],\"19\":[19,5]}', 5350, '127837167118', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(66, 'singlephon', '2021-08-06 16:52:00', '{\"2\":[2,5],\"3\":[3,5]}', 3500, '461702798878', 1000, 'Алматы', 'adsadsdasd', 'Доставка', 'feoajeod aedead', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(67, 'unauthorized', '2021-08-21 19:47:06', '{\"2\":[2,5],\"19\":[19,5]}', 5000, '486451260552', 2000, 'Астана', 'Достык 19', 'Казпочта', 'Рахат Бакытжанов', '87781328796', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(68, 'unauthorized', '2021-09-08 08:57:44', '{\"2\":[2,5],\"19\":[19,5]}', 5000, '956125227873', 1000, 'Алматы', 'С. Абай, Карасайский район, Женис 21', 'Доставка', 'Кцфвлфзщвлф ываыфаф', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(69, 'idiksidik', '2021-09-08 10:54:30', '{\"2\":[2,5],\"3\":[3,5],\"19\":[19,5]}', 6750, '282581738438', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(70, 'unauthorized', '2021-11-19 08:24:35', '{\"2\":[2,5],\"3\":[3,5],\"19\":[19,5]}', 6750, '32537939575', 2000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(71, 'unauthorized', '2021-11-29 09:03:38', '{\"3\":[3,5],\"19\":[19,5]}', 5000, '561216605773', 2000, 'Астана', 'С. Абай, Карасайский район, Женис 21', 'Казпочта', 'Rakhat Bakytzhanov', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(72, 'unauthorized', '2021-12-13 18:24:01', '{\"3\":[3,5],\"19\":[19,5]}', 5000, '102508317826', 2000, 'Караганды', 'С. Абай, Карасайский район, Женис 21', 'Казпочта', 'Rakhat Bakytzhanov', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(73, 'unauthorized', '2022-01-12 13:27:16', '{\"3\":[3,9],\"19\":[19,5]}', 6400, '201904317764', 2000, 'Астана', 'С. Абай, Карасайский район, Женис 21', 'Казпочта', 'Rakhat Bakytzhanov', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(74, 'unauthorized', '2022-01-18 15:14:02', '{\"3\":[3,9],\"19\":[19,5]}', 6400, '814938095479', 1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(75, 'singlephon', '2022-02-10 10:02:43', '{\"2\":[2,5],\"19\":[19,5]}', 5000, '500742173317', 2000, 'Астана', 'С. Абай, Карасайский район, Женис 21', 'Казпочта', 'Рахат Бакытжанов', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(76, 'unauthorized', '2022-03-01 10:10:45', '{\"2\":[2,5]}', 1750, '191806147384', 1000, 'Алматы', 'С. Абай, Карасайский район, Женис 21', 'Доставка', 'Rakhat Bakytzhanov', '87058117651', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(77, 'unauthorized', '2022-03-11 11:18:34', '{\"2\":[2,5]}', 1750, '664666782545', 2000, 'Астана', 'С. Абай, Карасайский район, Женис 21', 'Казпочта', 'asdad sad asdas', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(78, 'unauthorized', '2022-03-28 11:50:34', '{\"2\":[2,5]}', 1750, '106352661300', 1000, 'Алматы', 'С. Абай, Карасайский район, Женис 21', 'Доставка', 'Rakhat Bakytzhanov', '87478801397', 'Ожидание отправки счета для оплаты', 'kaspi', 1),
(79, 'unauthorized', '2022-04-15 23:41:01', '{\"2\":[2,4],\"6\":[6,2]}', 2100, '791440505240', 1000, 'Алматы', 'С. Абай, Карасайский район, Женис 21', 'Доставка', 'Rakhat Bakytzhanov', '87787812854', 'Ожидание отправки счета для оплаты', 'kaspi', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `popular`
--

CREATE TABLE `popular` (
  `id` int NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `popular`
--

INSERT INTO `popular` (`id`, `product_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 6),
(5, 7),
(7, 9),
(8, 10),
(9, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `ID` int NOT NULL,
  `CATEGORY-ID` int DEFAULT NULL COMMENT 'ID-Категории',
  `BARCODE` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ШТРИХ-КОД',
  `COUNT` int DEFAULT '0' COMMENT 'КОЛИЧЕСТВО ТОВАРА НА СКЛАДЕ',
  `PRODUCT-NAME` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'НАИМЕНОВАНИЕ',
  `ARTICUL` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'АРТИКУЛ',
  `TYPE` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ТИП',
  `BRAND` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'БРЕНД',
  `MANUFACTURER` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ПРОИЗВОДИТЕЛЬ',
  `DESCRIPTION` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'ОПИСАНИЕ',
  `PRICE` int DEFAULT NULL COMMENT 'ЦЕНА',
  `ATTRIBUTES` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'АТРИБУТЫ',
  `MAIN-IMAGE` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'ГЛАВНОЕ ИЗОБРАЖЕНИЕ',
  `IMAGES` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'ИЗОБРАЖЕНИЕ ТОВАРА(JSON)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`ID`, `CATEGORY-ID`, `BARCODE`, `COUNT`, `PRODUCT-NAME`, `ARTICUL`, `TYPE`, `BRAND`, `MANUFACTURER`, `DESCRIPTION`, `PRICE`, `ATTRIBUTES`, `MAIN-IMAGE`, `IMAGES`) VALUES
(1, 1, NULL, 0, 'Лампа Светодиодная 10W', 'SN000001', 'Светодиодная', 'Эра', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей». Угол рассеивания её светового потока составляет 360 градусов. Лампочка имеет абсолютно прозрачную колбу, что также сказывается на качестве освещения. <br><br>Использование лампы Эра F-LED гарантирует снижение трат на оплату электроэнергии в 10 раз.', 700, '{\"Цоколь\": \"E28\", \"Степень защиты\": \"IP20\", \"Цветовая температура\": \"2700K\", \"Напряжение\": \"220В\", \"Срок службы\": \"30000Ч\", \"Вес\": \"0.05 кг\", \"Мощность\": \"10W\"}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(2, 1, NULL, 5, 'Лампа Светодиодная 12W', 'SN000002', 'Светодиодная', 'Эра', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей».', 350, '{\"Патрон\": \"Обычный\", \"Цоколь\": \"E27\", \"Степень защиты\": \"IP20\", \"Цветовая температура\": \"2700K\", \"Мощность\": \"12W\"}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(3, 2, NULL, 10, 'Лампа Накаливание 11W', 'SN000003', 'Накаливание', 'Эра', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей».', 350, '{\"Патрон\": \"Обычный\", \"Цоколь\": \"E27\", \"Степень защиты\": \"IP20\", \"Цветовая температура\": \"4000K\", \"Мощность\": \"11W\"}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(6, 4, NULL, 10, 'Лампа Галогенная 14W', 'SN000004', 'Галогенная', 'Заря', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей».', 350, '{\"Вес\": \"0.1 кг\", \"Напряжение\": \"220В\", \"Цветовая температура\": \"6000K\", \"Цоколь\": \"E27\", \"Мощность\": \"14W\"}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(7, 5, NULL, 10, 'Лампа Энергосберегающие 15W', 'SN000005', 'Энергосберегающие', 'Заря', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей»', 350, NULL, 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(9, 4, NULL, 10, 'Лампа Галогенная 14W', 'SN000007', 'Галогенная', 'Заря', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей».', 500, '{\"Патрон\": \"Обычный\", \"Цоколь\": \"E27\", \"Степень защиты\": \"IP44\", \"Цветовая температура\": \"2700K\", \"Мощность\": \"14W\"}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(10, 4, NULL, 10, 'Лампа Галогенная 17W', 'SN000008', 'Галогенная', 'Заря', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей».', 350, '{\"Патрон\": \"Обычный\", \"Цоколь\": \"E27\", \"Степень защиты\": \"IP44\", \"Цветовая температура\": \"6000K\", \"Мощность\": \"17W\"}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(11, 4, NULL, 10, 'Лампа Галогенная 22W', 'SN000009', 'Галогенная', 'Заря', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей».', 350, '{\"Патрон\": \"Обычный\", \"Цоколь\": \"E28\", \"Степень защиты\": \"IP55\", \"Цветовая температура\": \"6000K\", \"Мощность\": \"22W\"}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(12, 2, NULL, 8, 'Лампа Накаливание 80W', 'SN000010', 'Накаливание', 'Эра', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей».', 200, '{\"Патрон\": \"Обычный\", \"Цоколь\": \"E27\", \"Степень защиты\": \"IP55\", \"Цветовая температура\": \"6000K\", \"Мощность\": \"80W\"}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(13, 3, NULL, 0, 'Лампа Люминесцентные 15W', 'SN000011', 'Люминесцентные', 'Шам', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей».', 350, '{\"Патрон\": \"Обычный\", \"Цоколь\": \"E28\", \"Степень защиты\": \"IP55\", \"Цветовая температура\": \"6500K\", \"Мощность\": \"15W\"}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(15, 5, NULL, 52, 'Лампа Светодиодная Эконом 2021', 'SN00013', 'Светодиодная', 'Заря', 'Заря', 'ыфвфывыфвфывффывфвфывыфвыфвфывфы', 650, '{}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/SN00013/lamp.png\", \"Data/Product/SN00013/sl1.png\"]'),
(19, 5, NULL, 200, 'Лампа Энергосберегающая 17W', 'ISA00001', 'Энергосберегающая', 'Klaus', 'Reisdl', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей». Угол рассеивания её светового потока составляет 360 градусов. Лампочка имеет абсолютно прозрачную колбу, что также сказывается на качестве освещения.<br><br>Использование лампы Эра F-LED гарантирует снижение трат на оплату электроэнергии в 10 раз.', 650, '{\"Цветовая температура\": \"6500K\", \"Напряжение\": \"220В\", \"Вес\": \"0.2 кг\", \"Цоколь\": \"E27\", \"Мощность\": \"17W\"}', 'Data/Product/ISA00001/Без имени.png', '[\"Data/Product/ISA00001/Без имени.png\", \"Data/Product/ISA00001/ыфвывфвф.jpg\"]'),
(22, 1, NULL, 0, 'Лампа Светодиодная 102W', 'SN000018', 'Светодиодная', 'Эра', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей». Угол рассеивания её светового потока составляет 360 градусов. Лампочка имеет абсолютно прозрачную колбу, что также сказывается на качестве освещения. <br><br>Использование лампы Эра F-LED гарантирует снижение трат на оплату электроэнергии в 10 раз.', 700, '{\"Цоколь\": \"E28\", \"Степень защиты\": \"IP20\", \"Цветовая температура\": \"2700K\", \"Напряжение\": \"220В\", \"Срок службы\": \"30000Ч\", \"Вес\": \"0.05 кг\", \"Мощность\": \"102W\"}', 'Data/Product/Lampa/sl1.png', '[\"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\", \"Data/Product/Lampa/sl1.png\"]'),
(32, 1, NULL, 69, 'Лампа Светодиодная 500W', 'SN0000177', 'Светодиодная', 'Эра', 'DDS CORP.', 'Лампа изготовлена по технологии Filament – «светодиоды в форме нитей». Угол рассеивания её светового потока составляет 360 градусов. Лампочка имеет абсолютно прозрачную колбу, что также сказывается на качестве освещения. <br><br>Использование лампы Эра F-LED гарантирует снижение трат на оплату электроэнергии в 10 раз.', 9000, '{\"Цоколь\": \"E28\", \"Степень защиты\": \"IP20\", \"Цветовая температура\": \"2700K\", \"Напряжение\": \"220В\", \"Срок службы\": \"30000Ч\", \"Вес\": \"0.05 кг\", \"Мощность\": \"500W\", \"Размер\": \"520\"}', 'Data/Product/SN0000177/golova.png', '[\"Data/Product/SN0000177/golova.png\", \"Data/Product/SN0000177/mmm.jpg\"]');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `LOCAL-ID` int NOT NULL COMMENT 'УНИКАЛЬНЫЙ НОМЕР ПОЛЬЗОВАТЕЛЯ',
  `SN-ID` int DEFAULT NULL COMMENT 'ИДЕНТИФИКАТОР ПОЛЬЗОВАТЕЛЯ СОЦИАЛЬНОЙ СЕТИ',
  `LOGIN` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ЛОГИН',
  `PASSWORD` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ПАРОЛЬ',
  `EMAIL` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ЕМАЙЛ',
  `NAME` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ИМЯ',
  `SURNAME` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ФАМИЛИЯ',
  `PICTURE` text COLLATE utf8mb4_unicode_ci COMMENT 'КАРТИНКА ПОЛЬЗОВАТЕЛЯ',
  `PHONE` varchar(21) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'НОМЕР ТЕЛЕФОНА',
  `BASKET-ID` int DEFAULT NULL COMMENT 'ID КОРЗИНЫ',
  `FLAG` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`LOCAL-ID`, `SN-ID`, `LOGIN`, `PASSWORD`, `EMAIL`, `NAME`, `SURNAME`, `PICTURE`, `PHONE`, `BASKET-ID`, `FLAG`) VALUES
(3, NULL, 'singlephon', '72ebc843938964405631bb9b984974fd', 'singlephon@gmail.com', 'Рахат', 'Бакытжанов', 'Data/User/singlephon/user.png', '87478801397', NULL, 'ADMIN'),
(4, NULL, 'idiksidik', '72ebc843938964405631bb9b984974fd', 'sample@gmail.com', 'Сидик', 'Идикович', 'Data/User/idiksidik/user.jpg', '87478801397', NULL, 'USER'),
(5, NULL, 'palauich', '72ebc843938964405631bb9b984974fd', 'saddy@gmail.com', 'Pallau', 'Fallau', 'Data/User/Default/user.svg', '87478856565', NULL, 'USER'),
(7, NULL, 'ronnya', '72ebc843938964405631bb9b984974fd', 'sin@mail.com', 'Ron', 'Frost', 'Data/User/ronnya/user.jpg', '87478848796', NULL, 'USER');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cash_bank`
--
ALTER TABLE `cash_bank`
  ADD PRIMARY KEY (`MB-ID`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CATEGORY-ID`);

--
-- Индексы таблицы `delivery_price`
--
ALTER TABLE `delivery_price`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `kaspi_payment`
--
ALTER TABLE `kaspi_payment`
  ADD PRIMARY KEY (`KP-ID`),
  ADD KEY `ORDER-ID` (`ORDER-ID`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `popular`
--
ALTER TABLE `popular`
  ADD PRIMARY KEY (`id`),
  ADD KEY `popular_ibfk_1` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CATEGORY-ID` (`CATEGORY-ID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`LOCAL-ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cash_bank`
--
ALTER TABLE `cash_bank`
  MODIFY `MB-ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `CATEGORY-ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `delivery_price`
--
ALTER TABLE `delivery_price`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `kaspi_payment`
--
ALTER TABLE `kaspi_payment`
  MODIFY `KP-ID` int NOT NULL AUTO_INCREMENT COMMENT 'KASPI PAYMENT ID', AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT для таблицы `popular`
--
ALTER TABLE `popular`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `LOCAL-ID` int NOT NULL AUTO_INCREMENT COMMENT 'УНИКАЛЬНЫЙ НОМЕР ПОЛЬЗОВАТЕЛЯ', AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `kaspi_payment`
--
ALTER TABLE `kaspi_payment`
  ADD CONSTRAINT `kaspi_payment_ibfk_1` FOREIGN KEY (`ORDER-ID`) REFERENCES `orders` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `popular`
--
ALTER TABLE `popular`
  ADD CONSTRAINT `popular_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CATEGORY-ID`) REFERENCES `category` (`CATEGORY-ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
