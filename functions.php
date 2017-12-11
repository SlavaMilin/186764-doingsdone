<?php
session_start();
require_once ('db_functions.php');
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


/**
 * Проверяет суествует ли в БД повторяющийся email возвращает boolean
 * @param $connect mysqli ресурс соединения
 * @param $user_email string пользовательсий ввод email
 * @return boolean
 */
function check_exist_email ($connect, $user_email) {
    $query = '
    SELECT email FROM users
    WHERE email = ?;';
    $result = db_select($connect, $query, [$user_email]);
    return !empty($result);
}

/**Сравнивает пароль из БД и введённый пользователем и возвращает boolean
 * @param $connect mysqli ресурс соединения
 * @param $email string email введённый пользователем
 * @param $password string пароль введённый пользователем
 * @return bool
 */
function check_password ($connect, $email, $password) {
    $query = '
    SELECT password FROM users
    WHERE email = ?;
    ';
    $result = db_select($connect, $query, [$email]);
    return password_verify($password, $result[0]['password']);
}

/** Возвращает двумерный массив из категорий
 * @param $connect mysqli ресурс соединения
 * @return array
 */
function get_projects ($connect) {
    $query = '
    SELECT project_name, project_id FROM projects;
    ';
    return db_select($connect, $query, []);
}

/** Возвращает данные для задач из БД
 * @param $connect mysqli ресурс соединения
 * @return array
 */
function get_tasks ($connect) {
    $query = '
    SELECT task, date_deadline, project_name FROM tasks 
    JOIN projects ON projects.project_id = tasks.project_id;
    ';
    return db_select($connect, $query, []);
}
function getSqlError($link) {
    $page_error = mysqli_error($link);
    $error_layout = get_template('error', [
        'page_error' => $page_error
    ]);
    return print($error_layout);
}

/** Проходит по массиву и возвращает пункты которые не были заполненны
 * @param $get_data array данные по которым происходит проверка
 * @param $get_required array обязательные для заполнения пункты
 * @return array
 */
function validateForm ($get_data, $get_required) {
    $result = [];
    foreach ($get_required as $value) {
        if (empty($get_data[$value])) {
            $result[$value] = true;
        }
    };
    return $result;
};

/** Обезопашивает данные из БД
 * @param $content string входящие данные
 * @return string
 */
function get_save_content($content) {
    return htmlentities($content, ENT_QUOTES, "UTF-8");
}

/** Рекурсивоно проходет по массиву и делает безопасным данные и БД
 * @param $arr array входящий массив
 * @return array
 */
function get_save_content_for_array($arr) {
    $result = array_map(function ($data) {
        if (gettype($data) === 'array') {
            return get_save_content_for_array($data);
        }
        if (gettype($data) === 'string') {
            return get_save_content($data);
        }
        return $data;
    }, $arr);
    return $result;
}

/**Возвращает текущую дату формата SQL
 * @return false|string
 */
function date_now_sql () {
    return date('Y-m-d H:i:s', strtotime("now"));
}