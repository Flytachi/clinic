<?php
require_once '../../tools/warframe.php';
is_auth();

if ($_GET['main']) {

    if ($_GET['stage'] == 1) {
        // $sql = "SELECT vs.id FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.grant_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND vs.service_id != 1 AND (vs.diagnostic IS NULL OR (vs.diagnostic IS NOT NULL AND vs.accept_date IS NULL))";
        $sql = "SELECT vs.id FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.grant_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND vs.service_id != 1";
    } else if($_GET['stage'] == 2) {
        $sql = "SELECT vs.id FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.parent_id = {$_SESSION['session_id']} AND vs.route_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND vs.service_id != 1 AND vs.report_title IS NULL AND vs.report IS NULL";
    } else if($_GET['stage'] == 3) {
        $sql = "SELECT ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_DATE(), vs.discharge_date), '%H') / 24) 'result' FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.grant_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND vs.service_id = 1";
        echo $db->query($sql)->fetch()['result'];
        exit;
    } else if($_GET['stage'] == 4) {
        $sql = "SELECT
                    (
                        SELECT COUNT(bpd.id) FROM bypass bp LEFT JOIN bypass_date bpd ON(bpd.bypass_id=bp.id AND bpd.status IS NOT NULL AND bpd.completed IS NULL AND bpd.date >= CURRENT_DATE()) WHERE bp.user_id = {$_GET['id']} AND bp.visit_id = vs.id
                    ) 'result'
                FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.grant_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND vs.service_id = 1";
        echo $db->query($sql)->fetch()['result'];
        exit;
    } else if($_GET['stage'] == 5) {
        $sql = "SELECT id FROM operation WHERE user_id = {$_GET['id']} AND grant_id = {$_SESSION['session_id']} AND completed IS NULL";
    } /*else if($_GET['stage'] == 6) {
        $sql = "SELECT vs.id FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.grant_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND vs.service_id != 1 AND vs.diagnostic IS NOT NULL AND vs.accept_date IS NOT NULL AND vs.completed IS NULL";
    }*/

}else {

    if ($_GET['stage'] == 1) {
        $sql = "SELECT vs.id FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.parent_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND vs.report_title IS NOT NULL AND vs.report IS NOT NULL";
    } else if($_GET['stage'] == 2) {
        $sql = "SELECT vs.id FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.route_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND (vs.diagnostic IS NULL OR (vs.diagnostic IS NOT NULL AND vs.accept_date IS NULL))";
    } else if($_GET['stage'] == 3) {
        $sql = "SELECT vs.id FROM visit vs WHERE vs.user_id = {$_GET['id']} AND vs.route_id = {$_SESSION['session_id']} AND vs.completed IS NULL AND vs.diagnostic IS NOT NULL AND vs.accept_date IS NOT NULL AND vs.completed IS NULL";
    }

}

echo $db->query($sql)->rowCount();
?>
