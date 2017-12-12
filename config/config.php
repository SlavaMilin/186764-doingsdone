<?php
define('SECONDS_IN_DAY', 86400);
define('TEMPLATE_DIR_PATH', 'templates/');
define('UPLOAD_DIR_PATH', 'uploads/');
define('TEMPLATE_EXT', '.php');
define('HOST_NAME', 'http://doingsdone/');
// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');
$current_ts = strtotime('now midnight'); // текущая метка времени