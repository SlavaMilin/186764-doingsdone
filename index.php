<?php
define('SECONDS_IN_DAY', 86400);
define('TEMPLATE_DIR_PATH', 'templates/');
define('TEMPLATE_EXT', '.php');
require_once('functions.php');
require_once('data.php');

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
$days_until_deadline = floor((strtotime($date_deadline) - $current_ts) / SECONDS_IN_DAY);

$page_content = get_template('index', [
    'projects' => $projects,
    'tasks' => $tasks
]);
$layout_content = get_template('layout', [
    'content' => $page_content,
    'title' => 'Дела в порядке'
]);
print($layout_content);