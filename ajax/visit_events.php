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

    #009600 - Success
    #EF5350 - Danger

*/

$tb = new Table($db, "visit_bypass_events");
$tb->where("visit_id = {$_GET['pk']}");
$list = [];
foreach ($tb->get_table() as $row) {
    $arr = array(
        'id' => $row->id, 
        'title' => "$row->event_title", 
        'start' => "$row->event_start", 
        'end' => "$row->event_end",
    );
    $today = date('Ymd');
    $start = date_f($row->event_start, 'Ymd');
    if ($row->event_end) $end = date_f($row->event_end, 'Ymd');

    if (permission(5)) {

        if ($row->event_completed) $arr['color'] = "#009600";
        elseif ($row->event_fail) $arr['color'] = "#546E7A";
        else{
            if ( $today <= $start ){
                if ($row->responsible_id == $session->session_id) $arr['color'] = "#039be5";
                else $arr['color'] = "#5C6BC0";
            }
            else $arr['color'] = "#546E7A";
        }

    }else{

        if ($row->event_completed) $arr['color'] = "#009600";
        elseif ($row->event_fail) $arr['color'] = "#546E7A";
        else {
            if ( (isset($end) and $start <= $today && $today <= $end) || ( $start == $today ) ) $arr['color'] = "#FF4430";
            else $arr['color'] = "#546E7A";
        }

    }
    
    $list[] = $arr;
}


echo json_encode($list);
?>