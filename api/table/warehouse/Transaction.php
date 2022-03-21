<?php
require '../../../tools/warframe.php';

importModel('WarehouseStorageApplication');
$tb = new WarehouseStorageApplication('wsa');
$tb->Data("w.id, w.name")->JoinRIGHT('warehouses w', 'w.id=wsa.warehouse_id_in');
$tb->Where("wsa.warehouse_id_from = {$_GET['warehouse_id']} AND wsa.status = 2")->Group('w.id');
?>
<div class="table-responsive card">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table_detail-thead'] ?>">
                <th style="width:80%">Склад</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->list(1) as $row): ?>
                <tr id="TR_storage_item_<?= $row->id ?>" onclick="selectStorage(<?= $row->id ?>)">
                    <td><?= $row->name ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>