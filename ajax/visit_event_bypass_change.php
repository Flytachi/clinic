<?php
require_once '../tools/warframe.php';
$session->is_auth();

$bypass = (new Table($db, "visit_bypass"))->where("id = {$_GET['pk']}")->get_row();
$items = json_decode($bypass->items);

foreach ($items as $item) {
    if( isset($item->item_name_id) ){

        $m = ( isset($item->item_manufacturer_id) and $item->item_manufacturer_id ) ? " AND item_manufacturer_id = ".$item->item_manufacturer_id : null;
        $c = ( isset($item->item_price) and $item->item_price ) ? " AND item_price = ".$item->item_price : null;
        $qty_max = $db->query("SELECT SUM(item_qty) FROM warehouse_storage WHERE warehouse_id = $item->warehouse_id AND item_die_date > CURRENT_DATE() AND item_name_id = $item->item_name_id $m $c")->fetchColumn(); 
        // $qty_applications = $db->query("SELECT SUM(wc.item_qty) FROM visit_bypass_event_applications wc WHERE wc.warehouse_id = $item->warehouse_id AND wc.item_name_id = $item->item_name_id $m $c")->fetchColumn();

        $qty = $qty_max; // - $qty_applications;
        if($qty < $item->item_qty) {
            $ware_name = (new Table($db, "warehouses"))->where("id = $item->warehouse_id")->get_row()->name;
            $item_name = (new Table($db, "warehouse_item_names"))->where("id = $item->item_name_id")->get_row()->name;
            echo "Склад <b>$ware_name:</b><br>";
            echo "\"$item_name\" - требуемое кол-во отсутствует!";
            exit;
        }
    }
}
echo "success";
?>