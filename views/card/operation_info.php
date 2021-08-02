<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$operation = (new Table($db, "visit_operations"))->where("id = {$_GET['pk']}")->order_by('add_date ASC')->get_row();
$patient = json_decode($_GET['patient']);
dd($_GET);
dd($operation);
// $sql = "SELECT
//             op.id 'pk', op.user_id 'id', vs.id 'visit_id', vs.grant_id, op.oper_date,
//             vs.accept_date, vs.direction, vs.add_date, vs.discharge_date,
//             vs.complaint, op.completed, op.item_id, op.item_name, op.item_cost
//         FROM visit_operations op
//             LEFT JOIN visits vs ON (vs.id = op.visit_id)
//         WHERE op.id = {$_GET['pk']}";

// $patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);

$total_opetrator_price = $total_service_price = $total_preparats_price = $total_other_price = 0;

$activity = $_GET['activity'];

if (!isset($_GET['type'])) {
    $color = "primary";
}else {
    if ($_GET['type'] == 1) {
        $color = "success";
    }else {
        $color = "warning";
    }
}
?>

<div class="col-md-12 text-center">
    <h3> <b>Операция:</b> <?= $operation->operation_name ?></h3>
</div>

