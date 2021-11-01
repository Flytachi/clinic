<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Пациент";

if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {

    $agr = "?pk=".$_GET['pk'];
    if ( isset($_GET['activity']) and is_numeric($_GET['activity']) and $_GET['activity'] ) {
        $agr .= "&activity=".$_GET['activity'];
        $activity = True;
    }else{
        $activity = False;
    }

    $sql = "SELECT
                c.id, c.birth_date, c.province, c.region, c.phone_number, c.gender, 
                c.address_residence, c.address_registration, c.status, c.is_foreigner,
                v.id 'visit_id', v.parad_id, v.grant_id, v.direction, v.icd_id, v.icd_autor, v.is_active, v.add_date, v.discharge_date, v.completed, 
                vr.id 'order'
            FROM visits v
                LEFT JOIN visit_orders vr ON (v.id = vr.visit_id)
                LEFT JOIN clients c ON (v.client_id = c.id)
            WHERE v.id = {$_GET['pk']}";

    $patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);

    if (!$patient or ($activity and $patient->completed) ) {
        Mixin\error('404');
    }if (!$patient->is_active and $activity) {
        Mixin\error('404');
    }elseif(!$patient->is_active and !$activity) {
        $activity = False;
    }

    function is_grant(Int $id = null)
    {
        global $patient, $session;
        if ($patient->grant_id) {
            if ($id) {
                return ($patient->grant_id == $id) ? True : False;
            }else {
                return ($patient->grant_id == $session->session_id) ? True : False;
            }
        } else {
            return False;
        }
    }
    
} else {
    Mixin\error('404');
}
?>