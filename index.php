<?php
define('SECONDS_IN_DAY', 86400);
define('TEMPLATE_DIR_PATH', 'templates/');
define('TEMPLATE_EXT', '.php');
define('HOST_NAME', 'http://doingsdone/');
require_once('functions.php');
require_once('data.php');

$category_page = 0;
$add_form = null;
$modal_form = '';


if (isset($_GET['category_page'])) {
    $category_page = intval($_GET['category_page']);
};
if (isset($_GET['add'])) {
    if ($_GET['add'] === 'form') {
        $add_form = true;
        $modal_form = get_template('form', [
            'projects' => $projects,
        ]);
    }
};
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $get_data = $_POST;
    $errors = [];
    $required = ['name', 'project', 'date'];
    foreach ($_POST as $key => $value) {
        if (in_array($key, $required)) {
            if (!$value) {
                $errors[$key] = '';
            }
        }
    }
    if (count($errors)) {
        $add_form = true;
        $modal_form = get_template('form', [
            'get_data' => $get_data,
            'errors' => $errors,
            'projects' => $projects,
        ]);
    }
}

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
    'tasks' => $tasks,
    'category_page' => $category_page
]);
$layout_content = get_template('layout', [
    'content' => $page_content,
    'title' => 'Дела в порядке',
    'modal_form' => $modal_form,
    'add_form' => $add_form
]);
print($layout_content);