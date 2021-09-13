<?php
require_once '../tools/warframe.php';

$bypass = (new Table($db, "visit_bypass"))->where("id = {$_GET['pk']}")->get_row();
$items = json_decode($bypass->items);

foreach ($items as $item) {
    if( isset($item->item_name_id) ){

        $m = ( isset($item->item_manufacturer_id) and $item->item_manufacturer_id ) ? " AND wc.item_manufacturer_id = ".$item->item_manufacturer_id : null;
        $s = ( isset($item->item_supplier_id) and $item->item_supplier_id ) ? " AND wc.item_supplier_id = ".$item->item_supplier_id : null;

        $qty_max = $db->query("SELECT SUM(wc.item_qty) FROM warehouse_common wc WHERE wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $item->item_name_id $m $s")->fetchColumn(); 
        $qty_applications = $db->query("SELECT SUM(wc.item_qty) FROM warehouse_applications wc WHERE wc.item_name_id = $item->item_name_id AND wc.status != 3 $m $s")->fetchColumn();
        $qty = $qty_max - $qty_applications;
        if($qty < $item->item_qty) {
            $item_name = (new Table($db, "warehouse_item_names"))->where("id = $item->item_name_id")->get_row()->name;
            echo "\"$item_name\" - требуемое кол-во отсутствует!";
            exit;
        }
    }
}

echo "success";
?>