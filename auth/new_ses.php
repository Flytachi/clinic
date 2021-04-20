<?php
ini_set('display_errors', 1);
//Устанавливаем обработчики событиям сессии:
session_set_save_handler( 'sess_open',
                          'sess_close',
                          'sess_read',
                          'sess_write',
                          'sess_destroy',
                          'sess_gb' );

require_once '../tools/functions/connection.php';
// -----------------------------------------------------------------------

// Эти функции оставим пустыми...
function sess_open($sess_path, $sess_name)
{
  return true;
}
function sess_close()
{
  return true;
}
 
// Читаем данные
function sess_read($sess_id)
{
    global $db;
    $sql = "SELECT * FROM sessions1 WHERE session_id = \"$sess_id\"";
    $result = $db->query($sql)->fetch();
    $current_time = date('Y-m-d H:i:s');
    // Если данные получены, нам нужно обновить дату
    // доступа к данным:
    if ($result)
    {
        $sql = "UPDATE sessions1 SET date_touched=\"$current_time\" WHERE session_id = \"$sess_id\"";
        
        $result = $db->query($sql)->fetch();
        // Как мы помним только из этого обработчика
        // Мы возвращаем данные, а не логическое значение:
        return html_entity_decode($result['sess_data']);
    }
    else
    {
        $sql = "INSERT INTO sessions1 SET session_id=\"$sess_id\", date_touched=\"$current_time\"";
        $result = $db->query($sql)->fetch();
        echo $result;
        
        return true;
    } 
}
 
// Пишем данные:
function sess_write($sess_id, $data)
{
    global $db;
    $current_time = date('Y-m-d H:i:s');
    $data = htmlentities($data,ENT_QUOTES);
    $sql = "UPDATE sessions1 SET date_touched=\"$current_time\", sess_data=\"$data\" WHERE session_id = \"$sess_id\"";
    $result = $db->query($sql)->fetch();
    return true;
}
 
// Уничтожаем данные:
function sess_destroy($sess_id)
{
    global $db;
    $sql = "DELETE FROM sessions1 WHERE session_id = \"$sess_id\"";
    $result = $db->query($sql)->fetch();
    return true;
}
 
// Описываем действия сборщика мусора:
function sess_gb($sess_maxlifetime)
{
    global $db;
    $current_time = date('Y-m-d H:i:s');

    $sql = "DELETE FROM sessions1 WHERE date_touched + $sess_maxlifetime < $current_time";
    $result = $db->query($sql)->fetch();
    
    return true;
}
 
//---------------------- Тест работы сессии: ---------------------------------
 
session_start();
 
echo '<h1>'.session_id().'</h1>';
 
// Создадим некий инкремент, если он не существовал,
// И увеличим его на 1, если он существует:
var_dump($_SESSION);
if( isset($_SESSION['increment']) )
{ 
  $_SESSION['increment']++;
}
else
{
   $_SESSION['increment'] = 1;
}
 
echo '<h1> increment = '.$_SESSION['increment'].'</h1>';
?>