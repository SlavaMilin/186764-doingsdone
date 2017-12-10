<?php
require_once ('config/config.php');
require_once('functions.php');
require_once ('userdata.php');
require_once ('init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['register'])) {
    $get_data = $_POST;
    $required = ['email', 'password', 'name'];
    $error = validateForm($_POST, $required);
    if (isset($get_data['email'])) {
        $duplicate = getSqlData($db_connect, 'SELECT email FROM users WHERE email = '. '\'' . $get_data['email'] . '\'');
        $correct_email = filter_var($get_data['email'],FILTER_VALIDATE_EMAIL);
        if (!empty($duplicate) || !$correct_email) {
            $error['email'] = true;
        }
    }
    if (empty($error)) {
        $password = password_hash($get_data['password'], PASSWORD_BCRYPT);
        $sql = 'INSERT INTO users (user_name, password, email, date_registration) VALUES (?, ?, ?, NOW())';
        $stmt = mysqli_prepare($db_connect, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $get_data['name'], $password, $get_data['email']);
        $res = mysqli_stmt_execute($stmt);
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


