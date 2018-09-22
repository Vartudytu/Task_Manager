
--
-- Структура таблицы `tasks`
--
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `value` varchar(10) NOT NULL,
  `image` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHARSET=utf8 AUTO_INCREMENT=1 ;


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
