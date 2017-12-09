<?php
require_once ('config/config.php');
require_once('functions.php');
require_once ('userdata.php');
require_once ('init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['register'])) {
    $required = ['email', 'password', 'name'];
    $error = validateForm($_POST, $required);
    $duplicate = getSqlData($db_connect, 'SELECT email FROM users');

}
if (isset($error)) {
    $page_register = get_template('register', []);
    print($page_register);
} else {
    $page_register = get_template('register', [
        'error' => $error
    ]);
    print($page_register);
}

