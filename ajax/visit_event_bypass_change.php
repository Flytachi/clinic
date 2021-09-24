<?php
require_once '../tools/warframe.php';
$session->is_auth();

$bypass = (new Table($db, "visit_bypass"))->where("id = {$_GET['pk']}")->get_row();
$items = json_decode($bypass->items);

$warehouse_q = $db->query("SELECT * FROM warehouse_settings WHERE division_id = $session->session_division");
$qty = $warehouse_q->rowCount();

if ($qty == 1) {

    $w_pk = $warehouse_q->fetch()['warehouse_id'];
    foreach ($items as $item) {
        if( isset($item->item_name_id) ){

            $m = ( isset($item->item_manufacturer_id) and $item->item_manufacturer_id ) ? " AND item_manufacturer_id = ".$item->item_manufacturer_id : null;
            $s = ( isset($item->item_supplier_id) and $item->item_supplier_id ) ? " AND item_supplier_id = ".$item->item_supplier_id : null;

            $qty_max = $db->query("SELECT SUM(item_qty) FROM warehouse_custom WHERE warehouse_id = $w_pk AND item_die_date > CURRENT_DATE() AND item_name_id = $item->item_name_id $m $s")->fetchColumn(); 
            $qty_applications = $db->query("SELECT SUM(wc.item_qty) FROM visit_bypass_event_applications wc WHERE wc.warehouse_id = $w_pk AND wc.item_name_id = $item->item_name_id $m $s")->fetchColumn();
            $qty = $qty_max - $qty_applications;
            if($qty < $item->item_qty) {
                $item_name = (new Table($db, "warehouse_item_names"))->where("id = $item->item_name_id")->get_row()->name;
                echo "\"$item_name\" - требуемое кол-во отсутствует!";
                exit;
            }
        }
    }
    echo "success";

}elseif ($qty > 1) {
    // echo $qty;
    echo "Найдено более одного склада!";
}else {
    echo "Не найден подходящий склад!";
}
?>