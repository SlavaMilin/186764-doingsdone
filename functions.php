<?php

//Возвращает html шаблон с заполненными значениями из массива.

function get_template(string $file_way, array $data) {
    $count = '';
    extract($data);
    if (file_exists($file_way)) {
        ob_start();
        require_once($file_way);
        $count = ob_get_clean();
    }
    return $count;
};
?>