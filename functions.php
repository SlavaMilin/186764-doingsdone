<?php
session_start();
require_once ('db_functions.php');

/**Функция шаблонизации
 * @param $file_way string путь до шаблона
 * @param $data array переменные с данными
 * @return string возвращает шаблон с подставленными значениями
 */
function get_template($file_way, $data) {
    if (file_exists(TEMPLATE_DIR_PATH . $file_way . TEMPLATE_EXT)) {
        extract($data);
        ob_start();
        require_once(TEMPLATE_DIR_PATH . $file_way . TEMPLATE_EXT);
        return ob_get_clean();
    }
    return '';
};

/**Возарщает количество задач по категории
 * @param $tasks array задачи
 * @param $category_item string категория
 * @return int сумма
 */
function get_task_count($tasks, $category_item) {
    $count = 0;
    if ($category_item === 1) {
        return count($tasks);
    }
    foreach ($tasks as $item) {
        if ($category_item === $item['project_id']) {
            $count += 1;
        };
    };
    return $count;
};

/**Фильтрует массив задач по совпадению id категории
 * @param $get_tasks array все задачи
 * @param $get_projects array все категории
 * @param $page_link integer id задачи
 * @return array
 */
function filtering_category_array(array $get_tasks, array $get_projects, $page_link) {
    $result = [];
    if ($page_link === 1) {
        return $get_tasks;
    };
    if (array_key_exists(intval($page_link - 1), $get_projects)) {
        foreach ($get_tasks as $value) {
            if ($value['project_id'] === $get_projects[$page_link - 1]['project_id']) {
                array_push($result, $value);
            }
        };
        return $result;
    };
    http_response_code(404);
    echo '<h2>Страница не найдена</h2>';
    return $result;
};

/**Фильтрует задачи по статусу выполнения
 * @param $get_task
 * @return array
 */
function show_complete_task($get_task) {
    if (isset($_COOKIE['show_completed']) ? (!(bool) $_COOKIE['show_completed']) : true && is_array($get_task)) {
        return array_filter($get_task, function($value) {
            return !isset($value['date_finish']);
        });
    }
    return $get_task;
};

/**
 * Проверяет существует ли в БД повторяющийся email возвращает boolean
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
 * @param $user_id integer id пользователя
 * @return array
 */
function get_tasks ($connect, $user_id) {
    $query = '
    SELECT task, date_deadline, user_id, project_id, file_link, date_finish, task_id FROM tasks
    WHERE user_id = ?;
    ';
    return db_select($connect, $query, [$user_id]);
}

/**Выводит ошибку БД на страницу
 * @param $link mysqli
 * @return int
 */
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

/** Рекурсивоно проходет по массиву и делает безопасным данные из БД
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

/**Выводит данные пользователя по email
 * @param $connect mysqli
 * @param $email string
 * @return array
 */
function get_users_data ($connect, $email) {
    $query = '
        SELECT user_id, user_name FROM users
        WHERE email = ?
    ';
    return db_select($connect, $query, [$email]);

}

/**Записывает время выполнения для проекта в БД
 * @param $connect mysqli
 * @param $date_data string|null
 * @param $task_id integer
 * @return array|bool|mysqli_result
 */
function update_date_finish ($connect, $date_data, $task_id) {
    $query = '
    UPDATE tasks
    SET date_finish = ?
    WHERE task_id = ?;
    ';
    return db_update($connect, $query, [$date_data, $task_id]);
}

/** Записывает время выполнения как null
 * @param $connect mysqli
 * @param $task_id integer
 * @return array|bool|mysqli_result
 */
function update_date_finish_null ($connect, $task_id) {
    $query = '
    UPDATE tasks
    SET date_finish = NULL
    WHERE task_id = ?;
    ';
    return db_update($connect, $query, [$task_id]);
}

/** Проверяет есть ли такая категория в переданных данных
 * @param $array array
 * @param $project_id integer
 * @return bool
 */
function check_exist_project ($array, $project_id) {
    $result = false;
    foreach ($array as $value) {
        if ($value['project_id'] === $project_id) {
            $result = true;
            break;
        }
    }
    return $result;
}


/** Возвращает данные для задач из БД
 * @param $connect mysqli ресурс соединения
 * @param $user_id integer id пользователя
 * @return array
 */
function filtred_day_tasks ($connect, $user_id, $day) {
    $query = '
    SELECT task, date_deadline, user_id, project_id, file_link, date_finish, task_id FROM tasks
    WHERE user_id = ? 
    AND date_deadline = ?;
    ';
    return db_select($connect, $query, [$user_id, $day]);
}
function filtred_delay_tasks ($connect, $user_id, $day) {
    $query = '
    SELECT task, date_deadline, user_id, project_id, file_link, date_finish, task_id FROM tasks
    WHERE user_id = ? 
    AND date_deadline < ?
    AND date_finish IS NULL;
    ';
    return db_select($connect, $query, [$user_id, $day]);
}