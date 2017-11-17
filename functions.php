<?php
//Возвращает html шаблон с заполненными значениями из массива.
function get_template(string $file_way, array $data) {
    if (file_exists(TEMPLATE_DIR_PATH . $file_way . TEMPLATE_EXT)) {
        extract($data);
        ob_start();
        require_once(TEMPLATE_DIR_PATH . $file_way . TEMPLATE_EXT);
        return ob_get_clean();
    }
    return '';
};
//принимает на вход данные и возвращает количество повторов в двумерном массиве
function get_task_count($tasks, $categoryItem) {
    $count = 0;
    if ($categoryItem === 'Все') {
        $count = count($tasks);
    } else {
        foreach ($tasks as $item) {
            if ($categoryItem === $item['category']) {
                $count += 1;
            };
        };
    };
    return $count;
};