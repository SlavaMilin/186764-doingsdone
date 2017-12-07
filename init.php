<?php
$con = @mysqli_connect("localhost", "root", "", "doingsdone");
if ($con === false) {
    $page_error = mysqli_connect_error();
     $error_layout = get_template('error', [
        'page_error' => $page_error
    ]);
     print($error_layout);
     exit();
}