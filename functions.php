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
function get_task_count($tasks, $category_item) {
    $count = 0;
    if ($category_item === 'Все') {
        $count = count($tasks);
    } else {
        foreach ($tasks as $item) {
            if ($category_item === $item['category']) {
                $count += 1;
            };
        };
    };
    return $count;
};

//фильтрует массив
function filtering_category_array(array $get_tasks, array $get_projects, $page_link) {
    $result = [];
    if ($page_link === 0 or !isset($page_link)) {
        return $get_tasks;
    } elseif (array_key_exists($page_link, $get_projects)) {
        foreach ($get_tasks as $value) {
            if ($value['category'] === $get_projects[$page_link]) {
                array_push($result, $value);
            }
        }
    } else {
        http_response_code(404);
        echo '<h2>Страница не найдена</h2>';
    }
    return $result;
};