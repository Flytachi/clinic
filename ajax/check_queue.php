<?php
require_once '../tools/warframe.php';

$panel = $db->query("SELECT * FROM panels WHERE id = {$_POST['panel']}")->fetch();

if ($panel) {
    if ($panel['is_active']) {
        $rooms = implode(",", json_decode($panel['rooms']));
        $data = $db->query("SELECT * FROM queue WHERE room_id IN ($rooms)")->fetchAll();
        if ($panel['title'] == "name") foreach ($data as $key => $value) $data[$key]["user_name"] = get_full_name($value['user_id']);
        //
        echo json_encode(array('status' => 1, 'data' => $data));
    } else echo json_encode(array('status' => 201, 'id' => $panel['id']));
} else echo json_encode(array('status' => 0));
?>

