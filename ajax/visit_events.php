<?php
require_once '../tools/warframe.php';

$tb = new Table($db, "visit_bypass_events");
$tb->where("visit_id = {$_GET['pk']}");
$list = [];
foreach ($tb->get_table() as $row) {
    $list[] = array(
        'id' => $row->id, 
        'title' => "$row->event_title", 
        'start' => "$row->event_start", 
        'end' => "$row->event_end", 
        'color' => "$row->event_color",
    );
}

echo json_encode($list);
?>