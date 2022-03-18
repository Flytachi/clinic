<?php

use Mixin\Hell;

require '../../../tools/warframe.php';

importModel('WarehouseStorage');

$tb = new WarehouseStorage('wc');
$search = $tb->getSearch();
$tb->Data('wc.id, wc.warehouse_id, wc.item_name_id, wc.item_manufacturer_id, wc.item_price, win.name, wim.manufacturer, wc.item_qty, wc.item_die_date');
$tb->JoinLEFT('warehouse_item_names win', 'win.id=wc.item_name_id')->JoinLEFT('warehouse_item_manufacturers wim', 'wim.id=wc.item_manufacturer_id');
$tb->Where(array(
    "wc.warehouse_id = {$_GET['warehouse']}", 
    "wc.warehouse_id = {$_GET['warehouse']} AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
));
$tb->Order('win.name ASC, wim.manufacturer ASC')->Limit(20);
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>Наименование</th>
                <th style="width:250px">Производитель</th>
                <?php if($_GET['is_payment']): ?>
                    <th class="text-right" style="width:200px">Стоимость</th>
                <?php endif; ?>
                <th class="text-center" style="width:2s00px">Кол-во доступно/бронь</th>
                <th class="text-center">Срок годности</th>
                <th class="text-right" style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->list() as $row): ?>
                <tr>
                    <td><?= $row->name ?></td>
                    <td><?= $row->manufacturer ?></td>
                    <?php if($_GET['is_payment']): ?>
                        <td class="text-right"><?= number_format($row->item_price) ?></td>
                    <?php endif; ?>
                    <td class="text-center">
                        <?php
                        $price = ($_GET['is_payment']) ? "AND item_price = $row->item_price" : null;
                        $row->reservation = $db->query("SELECT SUM(item_qty) FROM warehouse_storage_applications WHERE status IN(1,2) AND warehouse_id_from = $row->warehouse_id AND item_name_id = $row->item_name_id AND item_manufacturer_id = $row->item_manufacturer_id $price")->fetchColumn();
                        $row->reservation += $db->query("SELECT SUM(item_qty) FROM visit_bypass_event_applications WHERE warehouse_id = $row->warehouse_id AND item_name_id = $row->item_name_id AND item_manufacturer_id = $row->item_manufacturer_id $price")->fetchColumn();
                        ?>
                        <?= number_format($row->item_qty - $row->reservation) ?> /
                        <span class="<?= ($row->reservation) ? "text-danger" : "text-muted" ?>"> <?= number_format($row->reservation) ?></span>
                    </td>
                    <td class="text-center"><?= $row->item_die_date ?></td>
                    <td class="text-right"s>
                        <div class="list-icons">
                            <a href="#" onclick="Check('<?= Hell::apiAxe('WarehouseStorage', array('form' => 'listAplications', 'id' => $row->id)) ?>')" class="list-icons-item text-primary-600"><i class="icon-list"></i></a>
                            <a href="#" onclick="Check('<?= Hell::apiAxe('WarehouseStorage', array('form' => 'refundItem', 'id' => $row->id)) ?>')" class="list-icons-item text-warning-600"><i class="icon-redo"></i></a>
                            <?php if($_GET['is_grant']): ?>
                                <a href="#" onclick="Check('<?= Hell::apiAxe('WarehouseStorage', array('form' => 'writtenOffItem', 'id' => $row->id)) ?>')" class="list-icons-item text-danger-600"><i class="icon-clipboard6"></i></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->panel(); ?>