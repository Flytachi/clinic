<?php
ini_set('display_errors', 1);
session_set_save_handler(
    '_open',
    '_close',
    '_read',
    '_write',
    '_destroy',
    '_clean');


require_once '../tools/functions/connection.php';

function _open()
{
    global $db;
    // db connect
    return true;
}
    
function _close()
{
    global $db;
    $db = null;
}

function _read($id)
{
    global $db;
    $sql = "SELECT * FROM sessions2 WHERE id = \"$id\"";
    $result = $db->query($sql)->fetch();
    // $current_time = date('Y-m-d H:i:s');
    // Если данные получены, нам нужно обновить дату
    // доступа к данным:
    if ($result)
    {
        // $sql = "UPDATE sessions1 SET date_touched=\"$current_time\" WHERE session_id = \"$sess_id\"";
        
        // $result = $db->query($sql)->fetch();
        // Как мы помним только из этого обработчика
        // Мы возвращаем данные, а не логическое значение:
        return $result['data'];
    }
    // else
    // {
    //     $sql = "INSERT INTO sessions1 SET session_id=\"$sess_id\", date_touched=\"$current_time\"";
    //     $result = $db->query($sql)->fetch();
    //     echo $result;
        
    //     return true;
    // } 

    // global $_sess_db;
 
    // $id = mysqli_real_escape_string($id);
 
    // $sql = "SELECT data
    //         FROM sessions
    //         WHERE id = '$id'";
 
    // if ($result = mysql_query($sql, $_sess_db)) {
    //     if (mysql_num_rows($result)) {
    //         $record = mysql_fetch_assoc($result);
 
    //         return $record['data'];
    //     }
    // }
 
    return '';
}

function _write($id, $data)
{
    global $db;
    $access = time();
    $sql = "REPLACE INTO sessions2 VALUES ('$id', '$access', '$data')";
    // $sql = "INSERT INTO sessions1 SET session_id=\"$sess_id\", date_touched=\"$current_time\"";
    $result = $db->query($sql)->fetch();
    return true;

    // global $_sess_db;
 
    // $access = time();
 
    // $id = mysql_real_escape_string($id);
    // $access = mysql_real_escape_string($access);
    // $data = mysql_real_escape_string($data);
 
    // $sql = "REPLACE
    //         INTO sessions
    //         VALUES ('$id', '$access', '$data')";
 
    // return mysql_query($sql, $_sess_db);
}

function _destroy($id)
{
    global $_sess_db;
 
    $id = mysql_real_escape_string($id);
 
    $sql = "DELETE
            FROM sessions
            WHERE id = '$id'";
 
    return mysql_query($sql, $_sess_db);
}

function _clean($max)
{
    global $_sess_db;
 
    $old = time() - $max;
    $old = mysql_real_escape_string($old);
 
    $sql = "DELETE
            FROM sessions
            WHERE access < '$old'";
 
    return mysql_query($sql, $_sess_db);
}

session_start();

?>
 