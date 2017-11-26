<?php
define('SECONDS_IN_DAY', 86400);
define('TEMPLATE_DIR_PATH', 'templates/');
define('UPLOAD_DIR_PATH', 'uploads/');
define('TEMPLATE_EXT', '.php');
define('HOST_NAME', 'http://doingsdone/');
require_once('functions.php');
require_once('data.php');

$category_page = 0;
$add_form = null;
$modal_form = '';


//Считывает параметр запроса category_page и передаёт её параметр для переключения категорий

if (isset($_GET['category_page'])) {
    $category_page = intval($_GET['category_page']);
};

//Включает отображение попапа формы при параметре запроса get=form

if (isset($_GET['add'])) {
    if ($_GET['add'] === 'form') {
        $add_form = true;
        $modal_form = get_template('form', [
            'projects' => $projects,
        ]);
    }
};

//При получении данных из формы производит валидацию. Если проходит валидацию добавляет задачу, если нет выводит ошибки

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $get_data = $_POST;
    $errors = [];
    $required = ['task', 'category'];
    foreach ($required as $value) {
        if (!array_key_exists($value, $get_data) || empty($get_data[$value])) {
            $errors[$value] = true;
        }
    }
    if (isset($_FILES['preview']['name']) && empty($errors)) {
        $path = $_FILES['preview']['name'];
        $res = move_uploaded_file($_FILES['preview']['tmp_name'], UPLOAD_DIR_PATH . $path);
        $get_data['preview'] = $path;
    }
    if (!empty($errors)) {
        $add_form = true;
        $modal_form = get_template('form', [
            'get_data' => $get_data,
            'errors' => $errors,
            'projects' => $projects,
        ]);
    } else {
        $get_data['status'] = 'Нет';
        if (empty($get_data['date'])) {
            $get_data['date'] = 'Нет';
        } else {
            $get_data['date'] = date_format(date_create($get_data['date']), 'd.m.Y');
        }
        array_unshift($tasks, $get_data);
    }
}

if (isset($_GET['show_completed'])) {
    $show_completed = $_GET['show_completed'];
    setcookie('show_completed', $show_completed, strtotime('+30 days'));
    header('Location: /');
}

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

$days = rand(-3, 3);
$task_deadline_ts = strtotime("+" . $days . " day midnight"); // метка времени даты выполнения задачи
$current_ts = strtotime('now midnight'); // текущая метка времени

// запишите сюда дату выполнения задачи в формате дд.мм.гггг
$date_deadline = date('d.m.Y', $task_deadline_ts);
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