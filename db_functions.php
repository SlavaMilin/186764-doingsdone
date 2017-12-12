<?php
require_once('mysql_helper.php');

/**Принимает параметры и возвращает данные из БД в ввиде двумерного массива
 * @param $con mysqli ресурс соединения
 * @param $query string SQL запрос с плейсхолдерами вместо значений
 * @param $data array данные для вставки на место плейсхолдеров
 * @return array двумерный массив данных из БД
 */
function db_select ($con, $query, $data) {
    $stmt = db_get_prepare_stmt($con, $query, $data);
    if (!$stmt) {
        return [];
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        return [];
    }
    return get_save_content_for_array(mysqli_fetch_all($result, MYSQLI_ASSOC));
}

/**Принимает параметры и редактирует запись в БД возвращая после результат операции
 * @param $con mysqli ресурс соединения
 * @param $query string SQL запрос с плейсхолдерами вместо значений
 * @param $data array данные для вставки на место плейсхолдеров
 * @return array|bool|mysqli_result возвращает статус операции
 */
function db_update($con, $query, $data) {
    $stmt = db_get_prepare_stmt($con, $query, $data);
    if (!$stmt) {
        return [];
    }
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

/**Производит вставку в БД
 * @param $con mysqli Ресурс соединения
 * @param $table_name string название таблицу куда производить запрос
 * @param $data array двумерный массив, где key - название поля, а value - его значение
 * @return bool|int|string
 */
function db_insert($con, $table_name, $data) {
    $field_names = [];
    $values = [];
    $placeholders = [];

    foreach ($data as $key => $value) {
        $field_names[] = $key;
        $values[] = $value;
        $placeholders[] = '?';
    }

    $sql = 'INSERT INTO ' . $table_name . ' (' . implode(", ", $field_names) .' )' . ' VALUES (' . implode(", ", $placeholders) . ')';
    $stmt = db_get_prepare_stmt($con, $sql, $values);
    if (!$stmt) {
        return false;
    }
    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        return false;
    }
    return mysqli_insert_id($con);
}
