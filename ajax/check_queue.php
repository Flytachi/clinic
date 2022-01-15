<?php
require_once '../tools/warframe.php';

$panel = $db->query("SELECT * FROM panels WHERE id = {$_POST['panel']}")->fetch();

if ($panel) {
    if ($panel['is_active']) {
        $rooms = implode(",", json_decode($panel['rooms']));
        echo json_encode(array('status' => 1, 'data' => $db->query("SELECT * FROM queue WHERE room_id IN ($rooms)")->fetchAll()));
    } else echo json_encode(array('status' => 201, 'id' => $panel['id']));
} else echo json_encode(array('status' => 0));
?>

