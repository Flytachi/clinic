<?php

use Mixin\Hell;

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
                p.id, p.first_name, p.last_name, p.father_name, 
                p.birth_date, p.province_id, p.region_id, p.phone_number, p.gender, 
                p.address_residence, p.address_registration, p.status, p.is_foreigner,
                v.id 'visit_id', v.parad_id, v.grant_id, v.direction, v.division_id, v.icd_id, 
                v.icd_autor, v.is_active, v.add_date, v.discharge_date, v.completed, v.comment,
                vt.id 'status_id', vt.name 'status_name'
            FROM visits v
                LEFT JOIN visit_status vt ON (v.id = vt.visit_id)
                LEFT JOIN patients p ON (v.patient_id = p.id)
            WHERE v.id = {$_GET['pk']}";

    $patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);

    if (!$patient or ($activity and $patient->completed) ) Hell::error('404');
    if (!$patient->is_active and $activity) Hell::error('404');
    elseif(!$patient->is_active and !$activity) $activity = False;

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
    
} else Hell::error('404');
?>