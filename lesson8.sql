-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 02 2021 г., 15:32
-- Версия сервера: 8.0.19
-- Версия PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lesson8`
--

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

CREATE TABLE `basket` (
  `id_basket` int NOT NULL,
  `id_customer` tinytext NOT NULL,
  `order_number` varchar(16) NOT NULL,
  `pr_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pr_name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `size` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `color` tinytext NOT NULL,
  `photo` tinytext NOT NULL,
  `description` text NOT NULL,
  `price_unit` float NOT NULL,
  `quantity` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `basket`
--

INSERT INTO `basket` (`id_basket`, `id_customer`, `order_number`, `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`, `description`, `price_unit`, `quantity`) VALUES
(92, 'Ivan', '160b764fc97677', 'A85372', 'футболка', 'М', 'S', 'бирюзовый', '03_t_shirt_cian.jpg', '2', 688, 1),
(94, 'Ivanka', '160b7654577cbc', 'A55427', 'футболка', 'Ж', 'XXL', 'черный', '01_t_shirt_black.jpg', '4', 612, 1),
(95, 'Ivanka', '160b7654577cbc', 'A42187', 'футболка', 'Ж', 'M', 'темно-бирюзовый', '08_t_shirt_darkocean.jpg', '2', 837, 1),
(96, 'Ivanka', '160b7654577cbc', 'A44880', 'футболка', 'Ж', 'XL', 'желтый', '07_t_shirt_brightyellow.jpg', '3', 1508, 3),
(97, 'Ivan', '460b765728f0c7', 'A84809', 'футболка', 'Ж', 'L', 'темно-зеленый', '02_t_shirt_darkgreen.jpg', '3', 1301, 2),
(98, 'Ivan', '960b765c1d36c2', 'A84809', 'футболка', 'Ж', 'L', 'темно-зеленый', '02_t_shirt_darkgreen.jpg', '3', 1301, 2),
(100, 'Ivan', '860b76bb1d275e', 'A42187', 'футболка', 'Ж', 'M', 'темно-бирюзовый', '08_t_shirt_darkocean.jpg', '2', 837, 1),
(101, 'Ivan', '860b76bb1d275e', 'A55427', 'футболка', 'Ж', 'XXL', 'черный', '01_t_shirt_black.jpg', '4', 612, 3),
(102, 'Ivan', '160b76d6161abf', 'A42187', 'футболка', 'Ж', 'M', 'темно-бирюзовый', '08_t_shirt_darkocean.jpg', '2', 837, 1),
(103, 'Ivan', '160b76d6161abf', 'A55427', 'футболка', 'Ж', 'XXL', 'черный', '01_t_shirt_black.jpg', '4', 612, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `catalogue`
--

CREATE TABLE `catalogue` (
  `id` int NOT NULL,
  `pr_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pr_name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `size` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `color` tinytext NOT NULL,
  `photo` tinytext NOT NULL,
  `price` float NOT NULL,
  `on_stock` smallint NOT NULL,
  `selected` smallint NOT NULL,
  `description` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `catalogue`
--

INSERT INTO `catalogue` (`id`, `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`, `price`, `on_stock`, `selected`, `description`) VALUES
(541, 'A44880', 'футболка', 'Ж', 'XL', 'желтый', '07_t_shirt_brightyellow.jpg', 1508, 31, 0, '3'),
(542, 'A85372', 'футболка', 'М', 'S', 'бирюзовый', '03_t_shirt_cian.jpg', 688, 32, 0, '2'),
(543, 'A92284', 'футболка', 'Ж', 'XXL', 'белый', '09_t_shirt_white.jpg', 1796, 16, 0, '4'),
(544, 'A42187', 'футболка', 'Ж', 'M', 'темно-бирюзовый', '08_t_shirt_darkocean.jpg', 837, 30, 0, '2'),
(545, 'A55427', 'футболка', 'Ж', 'XXL', 'черный', '01_t_shirt_black.jpg', 612, 24, 0, '4'),
(546, 'A84809', 'футболка', 'Ж', 'L', 'темно-зеленый', '02_t_shirt_darkgreen.jpg', 1301, 30, 0, '3'),
(547, 'A45390', 'футболка', 'Ж', 'XXL', 'темно-бирюзовый', '08_t_shirt_darkocean.jpg', 1922, 7, 0, '3');

-- --------------------------------------------------------

--
-- Структура таблицы `colors`
--

CREATE TABLE `colors` (
  `id_color` tinyint NOT NULL,
  `color` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`id_color`, `color`) VALUES
(1, 'белый'),
(2, 'бирюзово-зеленый'),
(3, 'бирюзовый'),
(4, 'желтый'),
(5, 'красный'),
(6, 'кремовый'),
(7, 'оранжевый'),
(8, 'темно-бирюзовый'),
(9, 'темно-желтый'),
(10, 'темно-зеленый'),
(11, 'фиолетовый'),
(12, 'черный');

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE `customers` (
  `customer_id` int NOT NULL,
  `customer_name` tinytext NOT NULL,
  `pass_hash` varchar(1024) NOT NULL,
  `id_hash` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `pass_hash`, `id_hash`) VALUES
(12, 'Ivan', '$2y$10$ZKoKHoUKFY8/HAIU7uTzu.fVsnGesvK3F3VC0vrNxFf.PPYVDCKFy', '5186860b764fc7127c1.05365413'),
(13, 'Ivanka', '$2y$10$2quEX15NHJ.A1ihJdEoHv.SBYD7vI91msavp5zPRH07XJ4Y8h262q', '8444860b7654551ca02.68863473');

-- --------------------------------------------------------

--
-- Структура таблицы `descriptions`
--

CREATE TABLE `descriptions` (
  `id_description` tinyint NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `descriptions`
--

INSERT INTO `descriptions` (`id_description`, `description`) VALUES
(1, 'Футболка из натурального хлопка премиум класса, прямого кроя и округлым вырезом - настоящая классика. Выполнена из плотного и мягкого хлопкового полотна приятного к телу. Прямой крой подходит ко всем видам фигур - что подтверждают отзывы наших довольных покупателей. Авторский принт подчеркивает ее уникальность. Не скатывается, сохраняет форму и цвет после множества стирок.'),
(2, 'Хенли – простая модель с длинными рукавами, без воротника, но с глубоким вырезом на пуговицах, из тонкого хлопка.'),
(3, 'Футболка с круглым вырезом однотонная.'),
(4, 'Футболка с круглым вырезом однотонная с принтом.'),
(5, 'Модель с воротником отложного типа, классическая, с длинным рукавом.');

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` tinyint NOT NULL,
  `photoname` tinytext NOT NULL,
  `color` tinytext NOT NULL,
  `imagepath` text NOT NULL,
  `iconpath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `photoname`, `color`, `imagepath`, `iconpath`) VALUES
(1, '01_t_shirt_black.jpg', 'черный', 'products/images/', 'products/icons/'),
(2, '02_t_shirt_darkgreen.jpg', 'темно-зеленый', 'products/images/', 'products/icons/'),
(3, '03_t_shirt_cian.jpg', 'бирюзовый', 'products/images/', 'products/icons/'),
(4, '04_t_shirt_ocean.jpg', 'бирюзово-зеленый', 'products/images/', 'products/icons/'),
(5, '05_t_shirt_violet.jpg', 'фиолетовый', 'products/images/', 'products/icons/'),
(6, '06_t_shirt_bisque.jpg', 'кремовый', 'products/images/', 'products/icons/'),
(7, '07_t_shirt_brightyellow.jpg', 'желтый', 'products/images/', 'products/icons/'),
(8, '08_t_shirt_darkocean.jpg', 'темно-бирюзовый', 'products/images/', 'products/icons/'),
(9, '09_t_shirt_white.jpg', 'белый', 'products/images/', 'products/icons/'),
(10, '10_t_shirt_darkyellow.jpg', 'темно-желтый', 'products/images/', 'products/icons/'),
(11, '11_t_shirt_simplyred.jpg', 'красный', 'products/images/', 'products/icons/'),
(12, '12_t_shirt_orange.jpg', 'оранжевый', 'products/images/', 'products/icons/');

-- --------------------------------------------------------

--
-- Структура таблицы `managers`
--

CREATE TABLE `managers` (
  `id_managers` tinyint NOT NULL,
  `title` tinytext NOT NULL,
  `manager_name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass_hash` varchar(1024) NOT NULL,
  `id_hash` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `managers`
--

INSERT INTO `managers` (`id_managers`, `title`, `manager_name`, `pass_hash`, `id_hash`) VALUES
(1, 'admin', 'Nachalnik', '$2y$10$vcHDx.LZjpPJD6lNTK3UOeFbMtK9jRkuDi0VyoJxRnfsqjlJQvSaK', '5803460af46cfd7af45.98658866'),
(2, 'cleaner', 'Ivan', '$2y$10$bB5JybfEg37YywbSx1BXCuM6/VjtsMq2D4Od3fYu9SzEJQiXWcGnS', '');

-- --------------------------------------------------------

--
-- Структура таблицы `temp_basket`
--

CREATE TABLE `temp_basket` (
  `id_basket` int NOT NULL,
  `temp_hash` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pr_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pr_name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `size` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `color` tinytext NOT NULL,
  `photo` tinytext NOT NULL,
  `description` text NOT NULL,
  `price_unit` float NOT NULL,
  `quantity` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `temp_basket`
--

INSERT INTO `temp_basket` (`id_basket`, `temp_hash`, `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`, `description`, `price_unit`, `quantity`) VALUES
(154, '1488660b764e293d1d7.27605823', 'A44880', 'футболка', 'Ж', 'XL', 'желтый', '07_t_shirt_brightyellow.jpg', '3', 1508, 1),
(155, '1488660b764e293d1d7.27605823', 'A85372', 'футболка', 'М', 'S', 'бирюзовый', '03_t_shirt_cian.jpg', '2', 688, 1),
(156, '1488660b764e293d1d7.27605823', 'A92284', 'футболка', 'Ж', 'XXL', 'белый', '09_t_shirt_white.jpg', '4', 1796, 2),
(157, '4975660b76507302949.65952424', 'A55427', 'футболка', 'Ж', 'XXL', 'черный', '01_t_shirt_black.jpg', '4', 612, 1),
(158, '4975660b76507302949.65952424', 'A42187', 'футболка', 'Ж', 'M', 'темно-бирюзовый', '08_t_shirt_darkocean.jpg', '2', 837, 1),
(159, '4975660b76507302949.65952424', 'A44880', 'футболка', 'Ж', 'XL', 'желтый', '07_t_shirt_brightyellow.jpg', '3', 1508, 3),
(160, '9190860b765487b48f4.73857665', 'A84809', 'футболка', 'Ж', 'L', 'темно-зеленый', '02_t_shirt_darkgreen.jpg', '3', 1301, 2),
(161, '2063360b76b9a0f5571.63733705', 'A42187', 'футболка', 'Ж', 'M', 'темно-бирюзовый', '08_t_shirt_darkocean.jpg', '2', 837, 1),
(162, '2063360b76b9a0f5571.63733705', 'A55427', 'футболка', 'Ж', 'XXL', 'черный', '01_t_shirt_black.jpg', '4', 612, 3),
(163, '6172860b77070cc0747.99161826', 'A92284', 'футболка', 'Ж', 'XXL', 'белый', '09_t_shirt_white.jpg', '4', 1796, 1),
(164, '6172860b77070cc0747.99161826', 'A42187', 'футболка', 'Ж', 'M', 'темно-бирюзовый', '08_t_shirt_darkocean.jpg', '2', 837, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id_basket`);

--
-- Индексы таблицы `catalogue`
--
ALTER TABLE `catalogue`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id_color`);

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Индексы таблицы `descriptions`
--
ALTER TABLE `descriptions`
  ADD PRIMARY KEY (`id_description`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id_managers`);

--
-- Индексы таблицы `temp_basket`
--
ALTER TABLE `temp_basket`
  ADD PRIMARY KEY (`id_basket`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `basket`
--
ALTER TABLE `basket`
  MODIFY `id_basket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT для таблицы `catalogue`
--
ALTER TABLE `catalogue`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=548;

--
-- AUTO_INCREMENT для таблицы `colors`
--
ALTER TABLE `colors`
  MODIFY `id_color` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `descriptions`
--
ALTER TABLE `descriptions`
  MODIFY `id_description` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `managers`
--
ALTER TABLE `managers`
  MODIFY `id_managers` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `temp_basket`
--
ALTER TABLE `temp_basket`
  MODIFY `id_basket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
