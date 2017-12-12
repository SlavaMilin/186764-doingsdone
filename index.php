<?php
require_once('config/config.php');
require_once ('functions.php');
require_once ('init.php');

$category_page = 1;
$modal_form = '';
$modal_login = '';
$user_name = $_SESSION['user_name'];

$projects = get_projects($db_connect);
$tasks = get_tasks($db_connect, $_SESSION['user_id']);


//Считывает параметр запроса category_page и передаёт её параметр для переключения категорий

if (isset($_GET['category_page'])) {
    $category_page = intval($_GET['category_page']);
};

//Включает отображение попапа формы при параметре запроса get=form

if (isset($_GET['form']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $modal_form = get_template('form', [
        'projects' => $projects,
    ]);
};

//Включает отображение попапа логина при параметре запроса get=login

if (isset($_GET['login']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $modal_login = get_template('login', []);
}

//При получении данных из формы производит валидацию. Если проходит валидацию добавляет задачу, если нет выводит ошибки

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['form'])) {
    $get_data = $_POST;
    $required = ['task', 'project_id'];
    $errors = validateForm($get_data, $required);

    if (isset($_FILES['file_link']['name']) && empty($errors)) {
        $path = $_FILES['file_link']['name'];
        $res = move_uploaded_file($_FILES['file_link']['tmp_name'], UPLOAD_DIR_PATH . $path);
        $get_data['file_link'] = $path;
    }
    if (!empty($errors)) {
        $modal_form = get_template('form', [
            'get_data' => $get_data,
            'errors' => $errors,
            'projects' => $projects,
        ]);
    } else {
        if (empty($get_data['date_deadline'])) {
            $get_data['date_deadline'] = NULL;
        } else {
            $get_data['date_deadline'] = date_format(date_create($get_data['date_deadline']), 'Y-m-d H:i:s');
        }
        $get_data['date_start'] = date_now_sql();
        $get_data['user_id'] = $_SESSION['user_id'];
        $get_data['project_id'] = (int) $get_data['project_id'];
        db_insert($db_connect, 'tasks', $get_data);
        header('Location: index.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['login'])) {
    $get_data = $_POST;
    $required = ['email', 'password'];
    $errors = validateForm($get_data, $required);
    $user = check_exist_email($db_connect, $get_data['email']);

    if ($user) {
        if (check_password($db_connect, $get_data['email'], $get_data['password'])) {
            $user_data = get_users_data($db_connect, $get_data['email']);
            $_SESSION['user'] = $get_data['email'];
            $_SESSION['user_id'] = $user_data[0]['user_id'];
            $_SESSION['user_name'] = $user_data[0]['user_name'];
        } else {
            $errors['password'] = true;
        }
    } else {
        $errors['email'] = true;
    }

    if (empty($errors)) {
        header('Location: index.php');
    } else {
        $modal_login = get_template('login', [
            'errors' => $errors,
            'get_data' => $get_data
        ]);
    }
}

// при параметре запросе show_completed устанавливает куки равные значению запроса

if (isset($_GET['show_completed'])) {
    $show_completed = $_GET['show_completed'];
    setcookie('show_completed', $show_completed, strtotime('+30 days'));
    header('Location: /');
};

if (isset($_SESSION['user'])) {
    $page_content = get_template('index', [
        'projects' => $projects,
        'tasks' => $tasks,
        'category_page' => $category_page
    ]);
    $layout_content = get_template('layout', [
        'content' => $page_content,
        'title' => 'Дела в порядке',
        'user_name' => $user_name,
        'modal_form' => $modal_form,
        'modal_login' => $modal_login
    ]);
    print($layout_content);
} else {
    $page_content = get_template('guest', [
        'modal_login' => $modal_login
    ]);
    print($page_content);
}


