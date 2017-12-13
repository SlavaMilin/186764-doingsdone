<?php
require_once('functions.php');
require_once ('config/config.php');
require_once ('init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['register'])) {
    $get_data = $_POST;
    $required = ['email', 'password', 'user_name'];
    $error = validateForm($_POST, $required);
    if (isset($get_data['email'])) {
        $duplicate = check_exist_email($db_connect, $get_data['email']);
        $correct_email = filter_var($get_data['email'],FILTER_VALIDATE_EMAIL);
        if (!$correct_email) {
            $error['email'] = true;
        }
        if ($duplicate) {
            $error['email_duplicate'] = true;
        }
    }
    if (empty($error)) {
        $get_data['password'] = password_hash($get_data['password'], PASSWORD_BCRYPT);
        $get_data['date_registration'] = date_now_sql();
        $res = db_insert($db_connect, 'users', $get_data);
        if ($res) {
            header('Location: index.php?login');
        } else {
            print (getSqlError($db_connect));
            exit();
        }

    } else {
        $page_register = get_template('register', [
            'error' => $error,
            'get_data' => $get_data
        ]);
        print($page_register);
    }
}

$page_register = get_template('register', []);
print($page_register);