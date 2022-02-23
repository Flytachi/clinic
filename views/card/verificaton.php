<?php
require_once '../../tools/warframe.php';
$session->is_auth();

if ($_GET['main']) {

    if ($_GET['stage'] == 1) {
        $sql = "SELECT id FROM visit_services WHERE visit_id = {$_GET['pk']} AND (parent_id IS NULL OR parent_id IS NOT NULL AND parent_id != $session->session_id) AND completed IS NULL AND service_id != 1";
    } else if($_GET['stage'] == 2) {
        $sql = "SELECT id FROM visit_operations WHERE visit_id = {$_GET['pk']} AND completed IS NULL";
    } else if($_GET['stage'] == 3) {
        $sql = "SELECT * FROM visit_bypass_events WHERE visit_id = {$_GET['pk']} AND event_start >= CURRENT_DATE() AND event_completed IS NULL AND event_fail IS NULL";
    } else if($_GET['stage'] == 4) {
        $sql = "SELECT ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_DATE(), discharge_date), '%H') / 24) 'result' FROM visits WHERE id = {$_GET['pk']} AND grant_id = $session->session_id";
        echo $db->query($sql)->fetchColumn();
        exit;
    } else if($_GET['stage'] == 5) {
        $sql = "SELECT id FROM visit_services WHERE visit_id = {$_GET['pk']} AND parent_id = $session->session_id AND completed IS NULL AND service_id != 1";
    } else if($_GET['stage'] == 6) {
        // $sql = "SELECT id FROM visit_services WHERE visit_id = {$_GET['pk']} AND parent_id = $session->session_id AND completed IS NULL AND service_id = 1 AND service_title IS NULL";
    }

}else {

    if ($_GET['stage'] == 1) {
        $sql = "SELECT id FROM visit_services WHERE visit_id = {$_GET['pk']} AND route_id = $session->session_id AND (parent_id IS NULL OR parent_id IS NOT NULL AND parent_id != $session->session_id) AND completed IS NULL";
    } else if($_GET['stage'] == 2) {
        $sql = "SELECT id FROM visit_services WHERE visit_id = {$_GET['pk']} AND parent_id = $session->session_id AND completed IS NULL AND service_title IS NOT NULL";
    } else if($_GET['stage'] == 3) {
        // $sql = "SELECT vs.id FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.route_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND vs.diagnostic IS NOT NULL AND vs.accept_date IS NOT NULL AND vs.completed IS NULL";
        echo 0;
        exit;
    }

}

echo $db->query($sql)->rowCount();
?>
