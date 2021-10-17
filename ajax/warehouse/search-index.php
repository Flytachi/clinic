<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$is_parent = $_GET['is_parent'];

$tb = new Table($db, "warehouse_custom wc");
$search = $tb->get_serch();
$tb->set_data("win.name, wim.manufacturer, wis.supplier, wc.item_qty, wc.item_price, wc.item_die_date,
    (SELECT SUM(vbea.item_qty) FROM visit_bypass_event_applications vbea WHERE vbea.warehouse_id = wc.warehouse_id AND wc.item_name_id = vbea.item_name_id AND wc.item_manufacturer_id = vbea.item_manufacturer_id AND wc.item_price = vbea.item_price ) 'reservation'")->additions("LEFT JOIN warehouse_item_names win ON(win.id=wc.item_name_id) LEFT JOIN warehouse_item_manufacturers wim ON(wim.id=wc.item_manufacturer_id) LEFT JOIN warehouse_item_suppliers wis ON(wis.id=wc.item_supplier_id)");
$where_search = array(
    "wc.warehouse_id = {$_GET['pk']}", 
    "wc.warehouse_id = {$_GET['pk']} AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
);
$tb->where_or_serch($where_search)->order_by("win.name ASC, wim.manufacturer ASC, wis.supplier ASC")->set_limit(20);
$tb->set_self(viv('warehouse/index'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>Наименование</th>
                <th style="width:250px">Производитель</th>
                <th style="width:250px">Поставщик</th>
                <th class="text-right" style="width:200px">Стоимость</th>
                <th class="text-center" style="width:2s00px">Кол-во/бронь</th>
                <th class="text-center">Срок годности</th>
                <!-- <th class="text-right" style="width: 100px">Действия</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table() as $row): ?>
                <tr>
                    <td><?= $row->name ?></td>
                    <td><?= $row->manufacturer ?></td>
                    <td><?= $row->supplier ?></td>
                    <td class="text-right"><?= number_format($row->item_price) ?></td>
                    <td class="text-center">
                        <?= number_format($row->item_qty) ?>
                        <span class="<?= ($row->reservation) ? "text-danger" : "text-muted" ?>">/ <?= number_format($row->reservation) ?></span>
                    </td>
                    <td class="text-center"><?= $row->item_die_date ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>