<?php
require_once '../tools/warframe.php';
$session->is_auth();

/*
    Colors

    #039be5 - Primary
    #26A69A - Teal
    #5C6BC0 - Indigo
    #546E7A - Secondary
    #FF7043 - Orange

    # - Success
    #EF5350 - Danger

*/

$tb = new Table($db, "visit_bypass_events");
$tb->where("visit_id = {$_GET['pk']}");
$list = [];
foreach ($tb->get_table() as $row) {
    $list[] = array(
        'id' => $row->id, 
        'title' => "$row->event_title", 
        'start' => "$row->event_start", 
        'end' => "$row->event_end", 
        'color' => "#039be5",
    );
}


echo json_encode($list);
?>