INSERT INTO projects
VALUES (1, "Все", 1),
  (2, "Входящие", 2),
  (3, "Учеба", 3),
  (4, "Работа", 1),
  (5, "Домашние дела", 2),
  (6, "Авто", 3)
;
INSERT INTO tasks (task, date_finish, date_deadline, user_id, project_id)
VALUES ("Собеседование в IT компании", "2018-06-01 00:00:00", "2017-12-07 00:00:00", 1, 4),
  ("Выполнить тестовое задание", "2018-05-25 00:00:00", "2018-12-07 00:00:00", 2, 4),
  ("Сделать задание первого раздела", "2018-04-21 00:00:00", "2017-12-07 00:00:00", 3, 3),
  ("Встреча с другом", "2018-04-22 00:00:00", "2018-12-07 00:00:00", 1, 2),
  ("Купить корм для кота", NULL, "2017-12-07 00:00:00", 2, 5),
  ("Заказать пиццу", NULL, "2018-12-07 00:00:00", 3, 5)
;
INSERT INTO doingsdone.users (user_name, password, email)
VALUES ("Игнат", "$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka", "ignat.v@gmail.com"),
  ("Леночка", "$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa", "kitty_93@li.ru"),
  ("Руслан", "$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW", "warrior07@mail.ru");

# получить список из всех проектов для одного пользователя
SELECT project_name FROM projects WHERE user_id = 1;
# получить список из всех задач для одного проекта
SELECT task FROM tasks WHERE project_id = 5;
# пометить задачу как выполненную
UPDATE tasks
    SET date_finish = now()
WHERE task_id = 5;
# получить все задачи для завтрашнего дня
SELECT task FROM tasks
WHERE date_deadline BETWEEN "2017-12-07 00:00:00" AND "2017-12-07 23:59:59";
# обновить название задачи по её идентификатору
UPDATE tasks
SET task = "Погулять с собакой"
WHERE task_id = 1;
