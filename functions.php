<?php
session_start();
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
        if ($category_item === $item['project_name']) {
            $count += 1;
        };
    };
    return $count;
};

//фильтрует массив
function filtering_category_array(array $get_tasks, array $get_projects, $page_link) {
    $result = [];
    if ($page_link === 1) {
        return $get_tasks;
    };
    if (array_key_exists(intval($page_link - 1), $get_projects)) {
        foreach ($get_tasks as $value) {
            if ($value['project_name'] === $get_projects[$page_link - 1]['project_name']) {
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

//function db_select ($table, array $fields, $filter, $order) {
//    $fields_result = '';
//    foreach ($fields as $key => $value) {
//        if (count($fields) === 1) {
//            $fields_result = $value;
//            break;
//        } elseif ($key === count($fields) - 1) {
//            $fields_result .= $value;
//        } else {
//            $fields_result .= $value . ', ';
//        }
//    }
//    $filter = empty($filter) ? '' : ' WHERE ' . $filter;
//    $order = empty($order) ? '' :
//    return 'SELECT ' . $fields_result . ' FROM ' . $table . $filter;
//}

function getSqlData($connect, $query) {
    $result_array = mysqli_query($connect, $query);
      return $result_array ? mysqli_fetch_all($result_array, MYSQLI_ASSOC) : $result_array;
};

function getSqlError($link) {
    $page_error = mysqli_error($link);
    $error_layout = get_template('error', [
        'page_error' => $page_error
    ]);
    return print($error_layout);
}

function validateForm ($get_data, $get_required) {
    $result = [];
    foreach ($get_required as $value) {
        if (empty($get_data[$value])) {
            $result[$value] = true;
        }
    };
    return $result;
};