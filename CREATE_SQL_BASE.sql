
--
-- Структура таблицы `tasks`
--
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `email`, `description`, `value`, `image`) VALUES

(1, 'Micho', 'demo1@demo.com', 'Текст, очень много какого-то теста Текст, очень много какого-то теста Текст, очень много какого-то теста Текст, очень много какого-то теста Текст.', 'Активно', ''),
(2, 'Daisy', 'desdamo1@demo.com', 'Текст, очень много какого-то теста Текст, очень много какого-то теста Текст, очень много какого-то теста Текст, очень много какого-то теста Текст.', 'Активно', '');


--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
ADD PRIMARY KEY (`id`);


--
-- Структура таблицы `users`
--
CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '123');

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`id`);