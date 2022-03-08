<?php
require_once '../tools/warframe.php';

$panel = $db->query("SELECT * FROM panels WHERE id = {$_POST['panel']}")->fetch();

if ($panel) {
    if ($panel['is_active']) {
        $rooms = implode(",", json_decode($panel['rooms']));
        $data = $db->query("SELECT * FROM queue WHERE room_id IN ($rooms)")->fetchAll();
        if ($panel['title'] == "name") foreach ($data as $key => $value) $data[$key]["patient_name"] = patient_name($value['patient_id']);
        //
        foreach ($data as $key => $value) {
            if ($panel['is_day']) {
                if ($value['add_date'] < date("Y-m-d")) $data[$key]['is_delete'] = true;
            }
            if ($panel['duration'] and $panel['duration'] > 0 and $value['is_accept']) {
                if(date_diff(new DateTime(date("Y-m-d H:i:s")), new DateTime($value['accept_date']))->i > $panel['duration']) $data[$key]['is_delete'] = true;
            }
        }
        //
        echo json_encode(array('status' => 1, 'data' => $data));
    } else echo json_encode(array('status' => 201, 'id' => $panel['id']));
} else echo json_encode(array('status' => 0));
?>

