<?php
require_once('functions.php');
define("SECONS_IN_DAY", 86400);

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

$days = rand(-3, 3);
$task_deadline_ts = strtotime("+" . $days . " day midnight"); // метка времени даты выполнения задачи
$current_ts = strtotime('now midnight'); // текущая метка времени

// запишите сюда дату выполнения задачи в формате дд.мм.гггг
$date_deadline = date("d.m.Y", $task_deadline_ts);
// в эту переменную запишите кол-во дней до даты задачи
$days_until_deadline = floor((strtotime($date_deadline) - $current_ts) / SECONS_IN_DAY);

//массивы для вывода задач в HTML
$projects = ['Все', 'Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];
$tasks = [
    ['task' => 'Собеседование в IT компании', 'date' => '01.06.2018', 'category' => 'Работа', 'status' => 'Нет'],
    ['task' => 'Выполнить тестовое задание', 'date' => '25.05.2018', 'category' => 'Работа', 'status' => 'Нет'],
    ['task' => 'Сделать задание первого раздела', 'date' => '21.04.2018', 'category' => 'Учеба', 'status' => 'Да'],
    ['task' => 'Встреча с другом', 'date' => '22.04.2018', 'category' => 'Входящие', 'status' => 'Нет'],
    ['task' => 'Купить корм для кота', 'date' => 'Нет', 'category' => 'Домашние дела', 'status' => 'Нет'],
    ['task' => 'Заказать пиццу', 'date' => 'Нет', 'category' => 'Домашние дела', 'status' => 'Нет'],
];

//принимает на вход данные и возвращает количество повторов в двумерном массиве
function get_task_count($tasks, $categoryItem) {
    $count = 0;
    foreach ($tasks as $item) {
        if ($categoryItem === 'Все') {
            $count += 1;
        } elseif ($categoryItem === $item['category']) {
            $count += 1;
        };
    }
    return $count;
};

$page_content = get_template('templates/index.php', [
    'projects' => $projects,
    'tasks' => $tasks
]);
$layout_content = get_template('templates/layout.php', [
    'content' => $page_content,
    'title' => 'Дела в порядке'
]);
print($layout_content);
?>