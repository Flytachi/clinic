<?php
require_once '../../tools/warframe.php';
$session->is_auth();

if ($_GET['main']) {

    if ($_GET['stage'] == 1) {
        $sql = "SELECT id FROM visit_services WHERE visit_id = {$_GET['pk']} AND parent_id != $session->session_id AND completed IS NULL";
    } else if($_GET['stage'] == 2) {
        $sql = "SELECT id FROM visit_operations WHERE visit_id = {$_GET['pk']} AND completed IS NULL";
    } else if($_GET['stage'] == 3) {
        // $sql = "SELECT
        //             (
        //                 -- SELECT COUNT(bpd.id) FROM bypass bp LEFT JOIN bypass_date bpd ON(bpd.bypass_id=bp.id AND bpd.status IS NOT NULL AND bpd.completed IS NULL AND bpd.date >= CURRENT_DATE()) WHERE bp.user_id = {$_GET['id']} AND bp.visit_id = vs.id AND bp.diet_id IS NULL
        //                 SELECT COUNT(bpd.id) FROM bypass bp LEFT JOIN bypass_date bpd ON(bpd.bypass_id=bp.id AND bpd.status IS NOT NULL AND bpd.completed IS NULL AND bpd.date >= CURRENT_DATE()) WHERE bp.user_id = {$_GET['id']} AND bp.visit_id = vs.id
        //             ) 'result'
        //         FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.grant_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND vs.service_id = 1";
        // echo $db->query($sql)->fetchColumn();
        // exit;
        echo 0;
        exit;
    } else if($_GET['stage'] == 4) {
        $sql = "SELECT ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_DATE(), discharge_date), '%H') / 24) 'result' FROM visits WHERE id = {$_GET['pk']} AND grant_id = $session->session_id";
        echo $db->query($sql)->fetchColumn();
        exit;
    } else if($_GET['stage'] == 5) {
        $sql = "SELECT id FROM visit_services WHERE visit_id = {$_GET['pk']} AND parent_id = $session->session_id AND completed IS NULL AND service_id != 1 AND service_title IS NULL";
    } else if($_GET['stage'] == 6) {
        // $sql = "SELECT id FROM visit_services WHERE visit_id = {$_GET['pk']} AND parent_id = $session->session_id AND completed IS NULL AND service_id = 1 AND service_title IS NULL";
    }

}else {

    if ($_GET['stage'] == 1) {
        $sql = "SELECT id FROM visit_services WHERE visit_id = {$_GET['pk']} AND route_id = $session->session_id AND parent_id != $session->session_id AND completed IS NULL";
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
