<?php
require_once('config/config_db.php');
$db_connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

if (!$db_connect) {
    $page_error = mysqli_connect_error();
    $error_layout = get_template('error', [
        'page_error' => $page_error
    ]);
    print($error_layout);
    exit();
}