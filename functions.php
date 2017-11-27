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
        return count($tasks);
    }
    foreach ($tasks as $item) {
        if ($category_item === $item['category']) {
            $count += 1;
        };
    };
    return $count;
};

//фильтрует массив
function filtering_category_array(array $get_tasks, array $get_projects, $page_link) {
    $result = [];
    if ($page_link === 0) {
        return $get_tasks;
    };
    if (array_key_exists($page_link, $get_projects)) {
        foreach ($get_tasks as $value) {
            if ($value['category'] === $get_projects[$page_link]) {
                array_push($result, $value);
            }
        };
        return $result;
    };
    http_response_code(404);
    echo '<h2>Страница не найдена</h2>';
    return $result;
};

function show_complete_task($get_task) {
    if (isset($_COOKIE['show_completed']) ? (!(bool) $_COOKIE['show_completed']) : true && is_array($get_task)) {
        return array_filter($get_task, function($value) {
            return ($value['status'] === 'Нет');
        });
    }
    return $get_task;
};

function searchUserByEmail ($email, $users) {
    foreach ($users as $value) {
        $result = null;
        if ($value['email'] === $email) {
            $result = $value;
            break;
        }
    }
    return $result;
};
