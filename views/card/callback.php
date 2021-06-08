<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Пациент";

if ( isset($_GET['pk']) ) {
    $agr = "?pk=".$_GET['pk'];
    if ( isset($_GET['activity']) and $_GET['activity'] ) {
        $agr .= "&activity=".$_GET['activity'];
        $activity = True;
    }else{
        $activity = False;
    }
    // $sql = "SELECT
    //             us.id, vs.id 'visit_id', vs.grant_id,
    //             us.dateBith, us.numberPhone, us.gender,
    //             us.region, us.residenceAddress, vs.priced_date,
    //             us.registrationAddress, vs.add_date, vs.accept_date,
    //             vs.direction, vs.add_date, vs.discharge_date,
    //             vs.complaint, vs.status, vp.item_name, vs.completed
    //         FROM users us
    //             LEFT JOIN visit vs ON (vs.user_id = us.id)
    //             LEFT JOIN visit_price vp ON (vp.visit_id=vs.id AND vp.item_type = 101)
    //         WHERE vs.id = {$_GET['pk']} ORDER BY add_date ASC";

    $sql = "SELECT
                us.id, us.birth_date, us.province, us.region, us.phone_number, us.gender, us.address_residence, us.address_registration, us.status, us.is_foreigner,
                v.id 'visit_id', v.grant_id, v.direction, v.complaint, v.add_date, v.discharge_date, v.completed
            FROM visits v
                LEFT JOIN users us ON (v.user_id = us.id)
            WHERE v.id = {$_GET['pk']}";

    $patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);
    if (!$patient) {
        Mixin\error('404');
    }
} else {
    Mixin\error('404');
}
// dd($patient);
?>