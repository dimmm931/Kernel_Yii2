-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 06 2020 г., 18:33
-- Версия сервера: 5.5.28-log
-- Версия PHP: 5.4.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `kernel_casers_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('adminX', '1', 1577374243),
('adminX', '2', 1577373920);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('adminX', 1, 'Админ', NULL, NULL, 1577373781, 1577373781);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `balance`
--

CREATE TABLE IF NOT EXISTS `balance` (
  `balance_id` int(11) NOT NULL AUTO_INCREMENT,
  `balance_productName_id` int(11) NOT NULL,
  `balance_user_id` int(11) NOT NULL,
  `balance_amount_kg` int(11) NOT NULL,
  `balance_last_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`balance_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `balance`
--

INSERT INTO `balance` (`balance_id`, `balance_productName_id`, `balance_user_id`, `balance_amount_kg`, `balance_last_edit`) VALUES
(13, 1, 2, 238, '2020-02-05 15:44:45'),
(14, 2, 2, 644, '2020-02-05 14:44:45'),
(15, 2, 14, 235, '2020-02-05 14:59:16'),
(16, 1, 14, 760, '2020-02-05 15:56:56');

-- --------------------------------------------------------

--
-- Структура таблицы `elevators`
--

CREATE TABLE IF NOT EXISTS `elevators` (
  `e_id` int(11) NOT NULL AUTO_INCREMENT,
  `e_elevator` varchar(77) NOT NULL,
  `e_discription` text NOT NULL,
  `e_operated_by` varchar(77) NOT NULL,
  PRIMARY KEY (`e_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `elevators`
--

INSERT INTO `elevators` (`e_id`, `e_elevator`, `e_discription`, `e_operated_by`) VALUES
(1, 'Елеватор 1', '9.00-18.00', ''),
(2, 'Елеватор 2', '9.00-18.00', ''),
(3, 'Елеватор 3', '9.00-18.00', ''),
(4, 'Елеватор 4', '9.00-18.00', ''),
(5, 'Елеватор 5', '9.00-18.00', '');

-- --------------------------------------------------------

--
-- Структура таблицы `invoice_load_in`
--

CREATE TABLE IF NOT EXISTS `invoice_load_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_kontagent_id` int(11) NOT NULL,
  `product_nomenklatura_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `unix` int(11) NOT NULL,
  `invoice_id` varchar(77) NOT NULL,
  `elevator_id` int(11) NOT NULL,
  `carrier` varchar(77) NOT NULL,
  `driver` varchar(77) NOT NULL,
  `truck` varchar(77) NOT NULL,
  `truck_weight_netto` int(11) NOT NULL,
  `truck_weight_bruto` int(11) NOT NULL,
  `product_wight` int(11) NOT NULL,
  `trash_content` int(11) NOT NULL,
  `humidity` int(11) NOT NULL,
  `final_balance` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Дамп данных таблицы `invoice_load_in`
--

INSERT INTO `invoice_load_in` (`id`, `user_kontagent_id`, `product_nomenklatura_id`, `date`, `unix`, `invoice_id`, `elevator_id`, `carrier`, `driver`, `truck`, `truck_weight_netto`, `truck_weight_bruto`, `product_wight`, `trash_content`, `humidity`, `final_balance`) VALUES
(36, 2, 1, '2020-02-05 14:44:17', 1580913822, '_P-C9-1580913822', 1, 'Carrier1', 'Nikolay', 'Volvo', 3000, 4000, 250, 23, 13, 250),
(37, 2, 2, '2020-02-05 14:44:45', 1580913857, 'dQU-X-1580913857', 5, 'Carrier1', 'Nikolay', 'Volvo', 3000, 4000, 650, 23, 12, 650),
(38, 14, 1, '2020-02-05 14:58:54', 1580914709, 'UgrbO-1580914709', 4, 'Carrier1', 'Nikolay', 'Volvo', 3000, 4000, 750, 23, 13, 750),
(39, 14, 2, '2020-02-05 14:59:16', 1580914735, 'Nk26q-1580914735', 4, 'Carrier1', 'Nikolay', 'Volvo', 3000, 4000, 230, 23, 12, 235),
(40, 2, 1, '2020-02-05 15:23:08', 1580916161, 'o5f85-1580916160', 1, 'Carrier1', 'Nikolay', 'Volvo', 3000, 4000, 15, 23, 12, 245),
(41, 2, 1, '2020-02-05 15:44:45', 1580917455, '4Uu-L-1580917454', 1, 'Carrier1', 'Nikolay', 'Volvo', 3000, 4000, 1, 23, 13, 243);

-- --------------------------------------------------------

--
-- Структура таблицы `invoice_load_out`
--

CREATE TABLE IF NOT EXISTS `invoice_load_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `invoice_unique_id` varchar(77) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_wieght` int(11) NOT NULL,
  `user_date_unix` int(11) NOT NULL,
  `confirmed_by_admin` enum('0','1') NOT NULL DEFAULT '0',
  `confirmed_date_unix` int(11) NOT NULL,
  `date_to_load_out` int(77) NOT NULL,
  `b_intervals` int(3) NOT NULL,
  `b_quarters` int(3) NOT NULL,
  `elevator_id` int(11) NOT NULL,
  `completed` enum('0','1') NOT NULL DEFAULT '0',
  `completed_date_unix` int(11) NOT NULL,
  `final_balance` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Дамп данных таблицы `invoice_load_out`
--

INSERT INTO `invoice_load_out` (`id`, `user_id`, `invoice_unique_id`, `product_id`, `product_wieght`, `user_date_unix`, `confirmed_by_admin`, `confirmed_date_unix`, `date_to_load_out`, `b_intervals`, `b_quarters`, `elevator_id`, `completed`, `completed_date_unix`, `final_balance`) VALUES
(38, 2, 'zlwR2-1580913913', 1, 10, 1580913913, '0', 0, 0, 0, 0, 0, '0', 0, 240),
(39, 2, 'wNRRY-1580915898', 1, 5, 1580915888, '1', 1580915927, 1581033600, 8, 0, 3, '0', 0, 235),
(40, 2, 'iTgCY-1580916968', 1, 3, 1580916962, '0', 0, 0, 0, 0, 0, '0', 0, 242),
(41, 2, 'gXNxm-1580917296', 2, 1, 1580917287, '1', 1580917377, 1581033600, 8, 3, 2, '0', 0, 644);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `m_unix` int(11) NOT NULL,
  `m_sender_id` int(11) NOT NULL,
  `m_receiver_id` int(11) NOT NULL,
  `m_text` text NOT NULL,
  `m_status_read` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=122 ;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`m_id`, `m_time`, `m_unix`, `m_sender_id`, `m_receiver_id`, `m_text`, `m_status_read`) VALUES
(104, '2020-02-05 14:44:17', 1580913857, 1, 2, '<p>Шановний <b>Dmitriy</b></p><p>На Ваш баланс зараховано надходження продукту <b>Пшениця 250кг.</b></p><p> Номер накладної <b>_P-C9-1580913822.</b></p><p>Деталі можна подивитися у розділі <b>''Історія''</b></p><p>Best regards, Admin team. </p>', '0'),
(105, '2020-02-05 14:44:45', 1580913885, 1, 2, '<p>Шановний <b>Dmitriy</b></p><p>На Ваш баланс зараховано надходження продукту <b>Кукурудза 650кг.</b></p><p> Номер накладної <b>dQU-X-1580913857.</b></p><p>Деталі можна подивитися у розділі <b>''Історія''</b></p><p>Best regards, Admin team. </p>', '0'),
(106, '2020-02-05 14:45:20', 1580913920, 1, 2, '<p>Dear user <b>Dmitriy</b></p><p>Ви надiслали запит на вiдвантаження Пшениця у кількості  10кг.</p><p> Номер накладної  zlwR2-1580913913.</p><p> Очікуйте на повідомлення з підтвердженням адміністратора та датою і часом</p><p>Best regards, Admin team. </p>', '0'),
(107, '2020-02-05 14:45:43', 1580913943, 2, 2, '<p> Шановний <b>Dmitriy</b></p><p>Ви переоформили  на користувача Olga Кукурудза 5кг.</p><p> Номер накладної Trans-Y_2kR-1580913927.</p><p>Best regards, Admin team. </p>', '1'),
(108, '2020-02-05 14:45:43', 1580913943, 2, 14, '<p>Шановний <b>Olga</b></p><p>Користувач <b>Dmitriy</b> переоформив на Вас Кукурудза 5кг.</p><p> Номер накладної  Trans-Y_2kR-1580913927.</p><p>Best regards, Admin team. </p>', '0'),
(109, '2020-02-05 14:58:54', 1580914734, 1, 14, '<p>Шановний <b>Olga</b></p><p>На Ваш баланс зараховано надходження продукту <b>Пшениця 750кг.</b></p><p> Номер накладної <b>UgrbO-1580914709.</b></p><p>Деталі можна подивитися у розділі <b>''Історія''</b></p><p>Best regards, Admin team. </p>', '0'),
(110, '2020-02-05 14:59:16', 1580914756, 1, 14, '<p>Шановний <b>Olga</b></p><p>На Ваш баланс зараховано надходження продукту <b>Кукурудза 230кг.</b></p><p> Номер накладної <b>Nk26q-1580914735.</b></p><p>Деталі можна подивитися у розділі <b>''Історія''</b></p><p>Best regards, Admin team. </p>', '0'),
(111, '2020-02-05 15:18:30', 1580915910, 1, 2, '<p>Dear user <b>Dmitriy</b></p><p>Ви надiслали запит на вiдвантаження Пшениця у кількості  5кг.</p><p> Номер накладної  wNRRY-1580915898.</p><p> Очікуйте на повідомлення з підтвердженням адміністратора та датою і часом</p><p>Best regards, Admin team. </p>', '0'),
(112, '2020-02-05 15:19:35', 1580915975, 1, 2, '<p>Dear user <b>Dmitriy</b></p><p>Ми отримали Ваш запит на вiдвантаження <b>Пшениця</b> у кількості  <b>5</b> кг.</p><p> Номер накладної <b> wNRRY-1580915898</b>.</p><p>Вашу заявку було схвалено адміністратором. Ваша дата та час для відвантаження продукції <b>07-02-2020 2:00 8.00 </b>. Елеватор номер <b>3</b>.</p><p>Best regards, Admin team. </p>', '1'),
(113, '2020-02-05 15:21:07', 1580916067, 2, 2, '<p> Шановний <b>Dmitriy</b></p><p>Ви переоформили  на користувача Olga Пшениця 5кг.</p><p> Номер накладної Trans-rFqit-1580916047.</p><p>Best regards, Admin team. </p>', '1'),
(114, '2020-02-05 15:21:07', 1580916067, 2, 14, '<p>Шановний <b>Olga</b></p><p>Користувач <b>Dmitriy</b> переоформив на Вас Пшениця 5кг.</p><p> Номер накладної  Trans-rFqit-1580916047.</p><p>Best regards, Admin team. </p>', '0'),
(115, '2020-02-05 15:23:08', 1580916188, 1, 2, '<p>Шановний <b>Dmitriy</b></p><p>На Ваш баланс зараховано надходження продукту <b>Пшениця 15кг.</b></p><p> Номер накладної <b>o5f85-1580916160.</b></p><p>Деталі можна подивитися у розділі <b>''Історія''</b></p><p>Best regards, Admin team. </p>', '0'),
(116, '2020-02-05 15:36:20', 1580916980, 1, 2, '<p>Dear user <b>Dmitriy</b></p><p>Ви надiслали запит на вiдвантаження Пшениця у кількості  3кг.</p><p> Номер накладної  iTgCY-1580916968.</p><p> Очікуйте на повідомлення з підтвердженням адміністратора та датою і часом</p><p>Best regards, Admin team. </p>', '0'),
(117, '2020-02-05 15:41:47', 1580917307, 1, 2, '<p>Dear user <b>Dmitriy</b></p><p>Ви надiслали запит на вiдвантаження Кукурудза у кількості  1кг.</p><p> Номер накладної  gXNxm-1580917296.</p><p> Очікуйте на повідомлення з підтвердженням адміністратора та датою і часом</p><p>Best regards, Admin team. </p>', '1'),
(118, '2020-02-05 15:43:40', 1580917420, 1, 2, '<p>Dear user <b>Dmitriy</b></p><p>Ми отримали Ваш запит на вiдвантаження <b>Кукурудза</b> у кількості  <b>1</b> кг.</p><p> Номер накладної <b> gXNxm-1580917296</b>.</p><p>Вашу заявку було схвалено адміністратором. Ваша дата та час для відвантаження продукції <b>07-02-2020 2:00 8.30 </b>. Елеватор номер <b>2</b>.</p><p>Best regards, Admin team. </p>', '0'),
(119, '2020-02-05 15:44:45', 1580917485, 1, 2, '<p>Шановний <b>Dmitriy</b></p><p>На Ваш баланс зараховано надходження продукту <b>Пшениця 1кг.</b></p><p> Номер накладної <b>4Uu-L-1580917454.</b></p><p>Деталі можна подивитися у розділі <b>''Історія''</b></p><p>Best regards, Admin team. </p>', '0'),
(120, '2020-02-05 15:56:56', 1580918216, 2, 2, '<p> Шановний <b>Dmitriy</b></p><p>Ви переоформили  на користувача Olga Пшениця 5кг.</p><p> Номер накладної Trans-ufQCh-1580918175.</p><p>Best regards, Admin team. </p>', '1'),
(121, '2020-02-05 15:56:56', 1580918216, 2, 14, '<p>Шановний <b>Olga</b></p><p>Користувач <b>Dmitriy</b> переоформив на Вас Пшениця 5кг.</p><p> Номер накладної  Trans-ufQCh-1580918175.</p><p>Best regards, Admin team. </p>', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1577195156),
('m140506_102106_rbac_init', 1577373715),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1577373715),
('m191224_134405_create_user_table', 1577195161);

-- --------------------------------------------------------

--
-- Структура таблицы `product_name`
--

CREATE TABLE IF NOT EXISTS `product_name` (
  `pr_name_id` int(11) NOT NULL AUTO_INCREMENT,
  `pr_name_name` text NOT NULL,
  `pr_name_descr` varchar(155) NOT NULL,
  `pr_name_measure` varchar(12) NOT NULL,
  PRIMARY KEY (`pr_name_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `product_name`
--

INSERT INTO `product_name` (`pr_name_id`, `pr_name_name`, `pr_name_descr`, `pr_name_measure`) VALUES
(1, 'Пшениця', 'Wheat crops', 'kg'),
(2, 'Кукурудза', 'Corn crops', 'kg'),
(3, 'Рис', 'Rice crops', 'kg'),
(4, 'Гречка', 'buckwheat', 'kg'),
(5, 'Овес', 'Oats', 'kg');

-- --------------------------------------------------------

--
-- Структура таблицы `transfer_rights`
--

CREATE TABLE IF NOT EXISTS `transfer_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(3) NOT NULL,
  `invoice_id` varchar(77) NOT NULL,
  `from_user_id` int(6) NOT NULL,
  `to_user_id` int(6) NOT NULL,
  `product_weight` int(12) NOT NULL,
  `unix_time` int(77) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `final_balance_sender` int(11) NOT NULL,
  `final_balance_receiver` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Дамп данных таблицы `transfer_rights`
--

INSERT INTO `transfer_rights` (`id`, `product_id`, `invoice_id`, `from_user_id`, `to_user_id`, `product_weight`, `unix_time`, `date`, `final_balance_sender`, `final_balance_receiver`) VALUES
(27, 2, 'Trans-Y_2kR-1580913927', 2, 14, 5, 1580913927, '2020-02-05 14:45:43', 645, 5),
(28, 1, 'Trans-rFqit-1580916047', 2, 14, 5, 1580916047, '2020-02-05 15:21:07', 230, 755),
(29, 1, 'Trans-ufQCh-1580918175', 2, 14, 5, 1580918175, '2020-02-05 15:56:56', 238, 760);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '9',
  `first_name` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(33) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(77) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `first_name`, `last_name`, `company_name`, `phone_number`, `address`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'dP_dfIwbCsJI6uT81siaGhQlCtZL-qO8', '$2y$13$oMLFyRqmOIfiqUEZiCySbecfimjMixTXFUQDoyFy4mUanrhBM.B5O', NULL, 'admin@ukr.net', 10, 'Admin', 'Admin', 'Administration', '+380975431111', 'Kyiv, st. Perova, 14', 1577195541, 1577195541),
(2, 'Dima', '_bICf_IGlSe_EbaNwQWqSkPnSxD6Otdz', '$2y$13$UAYnbtP85axqt6EpBHGOPescY3HoUhIWQa8Tg2Fdi9gIOWpTBF/N2', NULL, 'dima@ukr.net', 10, 'Dmitriy', 'Admin', 'Company Name', '+380975436444', 'Kyiv, st. Prorizna, 44', 1577197958, 1577197958),
(13, 'Vasya', 'oQZKPTcYnsGj44i7xNppGnWnC2VTzqdO', '$2y$13$ZOMrnN04wXJgN8f5Fpk65OUxDNcKhnRrxD/KmGFmEdSiym7gBZGNm', NULL, 'vasya@ukr.net', 9, 'Vasyl', 'Ivanov', 'Sealand Ltd', '+380975456475', 'Kyiv, st. Darwina, 4', 1577200843, 1577461104),
(14, 'Olya', 'ItV8wT4dMV1crN9mYchD1Q_82DPGPS6N', '$2y$13$uGEZIOwp5hN11WAEfULEFuWy74vu.cc7zB1Z1vJQhnKyTUlGIUv8e', NULL, 'olya@ukr.net', 10, 'Olga', 'Ivanova', 'Brief Ltd', '+38097543654', 'Kyiv, st New', 1577203225, 1579707439),
(15, 'Petrov', 'EaFiYu7EZMBSNFUnwXHq6E5Viw7BFIME', '$2y$13$6Ggjxeum9JcnO16.L/sNuO0w/W6VV36avq64UMCF9E9Xz62KyIGLy', NULL, 'petrov@ukr.net', 9, 'Ivan', 'Petrov', 'Ceder', '+380976641344', 'Kyiv st', 1577552914, 1577552914),
(16, 'Dmitriy', 'ttyYL9Q3xHVyBZOYS-SmWvVz9h30Ax3X', '$2y$13$B9KxVLP8deCxKJhs72DLFe8l978aCAVRUPTrCu6FjKuvEe.tpEeVG', NULL, 'dmitriy_a@ukr.net', 10, 'Dmitriy', 'Petrov', 'Company Name', '+380976641344', 'Kyiv st', 1579447502, 1580916262),
(17, 'John', 'bjX8FDXv_rP7cd964x4-hqHOBwahPXRJ', '$2y$13$wgpRicQVBTjqoHo66AaGwOsomU6qMDm2VpVIYOpuicNmKU/jRzu9u', NULL, 'john@ukr.net', 10, 'John', 'Bee', 'New Company', '+380976641344', 'Kyiv st. Darwina', 1579450689, 1579451487);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
