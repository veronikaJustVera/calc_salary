-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 13 2022 г., 17:20
-- Версия сервера: 8.0.24
-- Версия PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `salary_calc`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_salary_for_report` (IN `param_employee_id` INT, IN `param_date` DATE)  sp:BEGIN

    SELECT DATE_FORMAT(param_date, "%M %Y") INTO @date;
    IF EXISTS(SELECT id from employees WHERE id = param_employee_id) THEN
        SELECT CONCAT(name , ' ', surname) FROM employees WHERE id = param_employee_id INTO @name;
        IF (EXISTS(SELECT efr.id FROM employee_film_roles efr INNER JOIN film_roles fr ON fr.id = efr.film_role_id INNER JOIN films f ON f.id = fr.film_id WHERE efr.employee_id = param_employee_id AND f.start_production_date <= param_date AND f.end_production_date >= param_date GROUP BY efr.id)) THEN
            SELECT GROUP_CONCAT(r.title SEPARATOR ', '), efr.film_role_id FROM roles r INNER JOIN film_roles fr ON fr.role_id = r.id INNER JOIN employee_film_roles efr ON efr.film_role_id = fr.id INNER JOIN films f ON f.id = fr.film_id WHERE efr.employee_id = param_employee_id AND f.start_production_date <= param_date AND f.end_production_date >= param_date GROUP BY r.id INTO @role, @film_role_id;
            SELECT IFNULL(s.month_salary, 0) FROM salaries s WHERE s.film_role_id = @film_role_id INTO @salary;
            INSERT INTO histories(film_role_id, date, salary) VALUES (@film_role_id, param_date, @salary) ON DUPLICATE KEY UPDATE salary = @salary;
            SELECT @date as date,
                @salary as salary,
                @name as name,
                @role as role;
        ELSE
            -- Employee has no work in this period
            SELECT @date as date,
                0 as salary,
                @name as name,
                'Unknown' as role;
        END IF;
    ELSE
        -- Unknown employee
        SELECT @date as date,
            0 as salary,
            'Unknown' as name,
            'Unknown' as role;
    END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`id`, `name`, `surname`, `created_at`, `updated_at`) VALUES
(1, 'Keanu', 'Reeves', NULL, NULL),
(2, 'Kate ', 'Winslet', NULL, NULL),
(3, 'Thomas', 'Lucas', NULL, NULL),
(4, 'Michelle', 'Lynn', NULL, NULL),
(5, 'Franc', 'Bulley', NULL, NULL),
(6, 'Vera', 'Demianenko', '2022-11-11 16:45:15', '2022-11-11 16:45:15'),
(7, 'Vera', 'Lynn', '2022-11-11 16:45:51', '2022-11-11 16:45:51');

-- --------------------------------------------------------

--
-- Структура таблицы `employee_film_roles`
--

CREATE TABLE `employee_film_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `film_role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `employee_film_roles`
--

INSERT INTO `employee_film_roles` (`id`, `employee_id`, `film_role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 2, NULL, NULL),
(3, 4, 3, NULL, NULL),
(4, 3, 4, NULL, NULL),
(7, 4, 8, '2022-11-12 15:53:44', '2022-11-12 15:53:44');

-- --------------------------------------------------------

--
-- Структура таблицы `films`
--

CREATE TABLE `films` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_production_date` date NOT NULL,
  `end_production_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `films`
--

INSERT INTO `films` (`id`, `title`, `start_production_date`, `end_production_date`, `created_at`, `updated_at`) VALUES
(1, 'Titanic', '2020-09-01', '2021-06-30', NULL, NULL),
(2, 'Matrix', '2021-06-01', '2022-04-01', NULL, NULL),
(4, 'Lord of Rings', '2022-10-01', '2022-10-22', '2022-10-20 12:57:58', '2022-10-20 12:57:58'),
(22, 'Forrest Gump', '2021-03-01', '2022-11-30', '2022-11-12 15:59:03', '2022-11-12 15:59:03');

-- --------------------------------------------------------

--
-- Структура таблицы `film_roles`
--

CREATE TABLE `film_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `film_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `film_roles`
--

INSERT INTO `film_roles` (`id`, `film_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, NULL),
(2, 1, 1, NULL, NULL),
(3, 2, 3, NULL, NULL),
(4, 1, 2, NULL, NULL),
(8, 4, 3, '2022-11-12 15:53:44', '2022-11-12 15:53:44');

-- --------------------------------------------------------

--
-- Структура таблицы `histories`
--

CREATE TABLE `histories` (
  `id` bigint UNSIGNED NOT NULL,
  `film_role_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `salary` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `histories`
--

INSERT INTO `histories` (`id`, `film_role_id`, `date`, `salary`, `created_at`, `updated_at`) VALUES
(1, 2, '2020-10-01', 2500, NULL, NULL),
(2, 2, '2020-12-01', 2500, NULL, NULL),
(3, 2, '2021-04-01', 2500, NULL, NULL),
(4, 2, '2021-06-01', 2500, NULL, NULL),
(6, 4, '2020-10-01', 3500, '2022-10-23 16:44:01', '2022-10-23 16:44:01'),
(7, 2, '2020-11-01', 2500, '2022-10-23 16:46:38', '2022-10-23 16:46:38'),
(8, 4, '2020-11-01', 3500, '2022-10-23 16:46:57', '2022-10-23 16:46:57'),
(9, 4, '2020-09-01', 3500, '2022-11-12 17:13:41', '2022-11-12 17:13:41'),
(10, 2, '2020-09-01', 2500, NULL, NULL),
(11, 1, '2021-08-01', 555, NULL, NULL),
(12, 1, '2021-09-01', 555, NULL, NULL),
(13, 1, '2021-10-01', 555, NULL, NULL),
(14, 1, '2021-11-01', 555, NULL, NULL),
(15, 1, '2022-02-01', 555, NULL, NULL),
(16, 2, '2021-08-01', 2500, NULL, NULL),
(17, 2, '2021-09-01', 2500, NULL, NULL),
(18, 2, '2021-10-01', 2500, NULL, NULL),
(19, 2, '2021-11-01', 2500, NULL, NULL),
(20, 2, '2022-02-01', 2500, NULL, NULL),
(21, 4, '2021-08-01', 3500, NULL, NULL),
(22, 4, '2021-09-01', 3500, NULL, NULL),
(23, 4, '2021-10-01', 3500, NULL, NULL),
(24, 4, '2021-11-01', 3500, NULL, NULL),
(25, 4, '2022-02-01', 3500, NULL, NULL),
(26, 3, '2021-08-01', 4000, NULL, NULL),
(27, 3, '2021-09-01', 4000, NULL, NULL),
(28, 3, '2021-10-01', 4000, NULL, NULL),
(29, 3, '2021-11-01', 4000, NULL, NULL),
(30, 3, '2022-02-01', 4000, NULL, NULL),
(32, 1, '2021-12-01', 555, NULL, NULL),
(33, 1, '2022-01-01', 555, NULL, NULL),
(34, 1, '2022-03-01', 555, NULL, NULL),
(35, 2, '2021-12-01', 2500, NULL, NULL),
(36, 2, '2022-01-01', 2500, NULL, NULL),
(37, 2, '2022-03-01', 2500, NULL, NULL),
(38, 4, '2021-12-01', 3500, NULL, NULL),
(39, 4, '2022-01-01', 3500, NULL, NULL),
(40, 4, '2022-03-01', 3500, NULL, NULL),
(41, 3, '2021-12-01', 4000, NULL, NULL),
(42, 3, '2022-01-01', 4000, NULL, NULL),
(43, 3, '2022-03-01', 4000, NULL, NULL),
(105, 2, '2021-01-01', 2500, NULL, NULL),
(106, 2, '2021-03-01', 2500, NULL, NULL),
(107, 2, '2021-07-01', 2500, NULL, NULL),
(108, 3, '2020-11-01', 4000, NULL, NULL),
(109, 3, '2021-01-01', 4000, NULL, NULL),
(110, 3, '2021-03-01', 4000, NULL, NULL),
(111, 3, '2021-07-01', 4000, NULL, NULL),
(118, 4, '2020-12-01', 3500, NULL, NULL),
(119, 4, '2021-03-01', 3500, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2022_10_09_173852_create_films_table', 1),
(3, '2022_10_09_173923_create_roles_table', 1),
(4, '2022_10_09_174006_create_employees_table', 1),
(5, '2022_10_09_174055_create_film_roles_table', 1),
(6, '2022_10_09_174132_create_employee_film_roles_table', 1),
(7, '2022_10_09_174155_create_salaries_table', 1),
(8, '2022_10_09_182003_create_histories_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Actor', NULL, NULL),
(2, 'Director', NULL, NULL),
(3, 'Operator', NULL, NULL),
(4, 'Sound Engineer', NULL, NULL),
(7, 'Scriptwriter', '2022-11-12 16:09:26', '2022-11-12 16:09:26');

-- --------------------------------------------------------

--
-- Структура таблицы `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint UNSIGNED NOT NULL,
  `film_role_id` bigint UNSIGNED NOT NULL,
  `month_salary` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `salaries`
--

INSERT INTO `salaries` (`id`, `film_role_id`, `month_salary`, `created_at`, `updated_at`) VALUES
(1, 1, 555, NULL, '2022-10-24 04:20:32'),
(2, 2, 2500, NULL, NULL),
(3, 3, 4000, NULL, '2022-10-23 14:06:36'),
(4, 4, 3500, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `employee_film_roles`
--
ALTER TABLE `employee_film_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_film_roles_employee_id_film_role_id_unique` (`employee_id`,`film_role_id`),
  ADD KEY `employee_film_roles_employee_id_index` (`employee_id`),
  ADD KEY `employee_film_roles_film_role_id_index` (`film_role_id`);

--
-- Индексы таблицы `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `film_roles`
--
ALTER TABLE `film_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `film_roles_film_id_index` (`film_id`),
  ADD KEY `film_roles_role_id_index` (`role_id`);

--
-- Индексы таблицы `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `histories_film_role_id_date_salary_unique` (`film_role_id`,`date`,`salary`),
  ADD KEY `histories_film_role_id_index` (`film_role_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salaries_film_role_id_index` (`film_role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `employee_film_roles`
--
ALTER TABLE `employee_film_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `films`
--
ALTER TABLE `films`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `film_roles`
--
ALTER TABLE `film_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `employee_film_roles`
--
ALTER TABLE `employee_film_roles`
  ADD CONSTRAINT `employee_film_roles_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_film_roles_film_role_id_foreign` FOREIGN KEY (`film_role_id`) REFERENCES `film_roles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `film_roles`
--
ALTER TABLE `film_roles`
  ADD CONSTRAINT `film_roles_film_id_foreign` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `film_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `histories`
--
ALTER TABLE `histories`
  ADD CONSTRAINT `histories_film_role_id_foreign` FOREIGN KEY (`film_role_id`) REFERENCES `film_roles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_film_role_id_foreign` FOREIGN KEY (`film_role_id`) REFERENCES `film_roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
