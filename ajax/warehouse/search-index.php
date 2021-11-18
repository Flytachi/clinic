<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$is_grant = $_GET['is_grant'];

$tb = new Table($db, "warehouse_storage wc");
$search = $tb->get_serch();
$tb->set_data("wc.warehouse_id, wc.item_name_id, wc.item_manufacturer_id, wc.item_price, win.name, wim.manufacturer, wc.item_qty, wc.item_die_date")->additions("LEFT JOIN warehouse_item_names win ON(win.id=wc.item_name_id) LEFT JOIN warehouse_item_manufacturers wim ON(wim.id=wc.item_manufacturer_id)");
$where_search = array(
    "wc.warehouse_id = {$_GET['pk']}", 
    "wc.warehouse_id = {$_GET['pk']} AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
);
$tb->where_or_serch($where_search)->order_by("win.name ASC, wim.manufacturer ASC")->set_limit(20);
$tb->set_self(viv('warehouse/index'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>Наименование</th>
                <th style="width:250px">Производитель</th>
                <th class="text-right" style="width:200px">Стоимость</th>
                <th class="text-center" style="width:2s00px">Кол-во доступно/бронь</th>
                <th class="text-center">Срок годности</th>
                <!-- <th class="text-right" style="width: 100px">Действия</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table() as $row): ?>
                <tr>
                    <td><?= $row->name ?></td>
                    <td><?= $row->manufacturer ?></td>
                    <td class="text-right"><?= number_format($row->item_price) ?></td>
                    <td class="text-center">
                        <?php
                        $row->reservation = $db->query("SELECT SUM(item_qty) FROM warehouse_storage_applications WHERE warehouse_id_from = $row->warehouse_id AND item_name_id = $row->item_name_id AND item_manufacturer_id = $row->item_manufacturer_id AND item_price = $row->item_price")->fetchColumn();
                        $row->reservation += $db->query("SELECT SUM(item_qty) FROM visit_bypass_event_applications WHERE warehouse_id = $row->warehouse_id AND item_name_id = $row->item_name_id AND item_manufacturer_id = $row->item_manufacturer_id AND item_price = $row->item_price")->fetchColumn();
                        ?>
                        <?= number_format($row->item_qty - $row->reservation) ?> /
                        <span class="<?= ($row->reservation) ? "text-danger" : "text-muted" ?>"> <?= number_format($row->reservation) ?></span>
                    </td>
                    <td class="text-center"><?= $row->item_die_date ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>