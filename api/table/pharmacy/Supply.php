<?php
require '../../../tools/warframe.php';
$session->is_auth();

importModel('WarehouseSupply');

$tb = new WarehouseSupply;
$tb->Order('supply_date DESC')->Limit(30);
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th style="width:50px">№</th>
                <th style="width:200px">Ключ</th>
                <th style="width:35%">Ответственный</th>
                <th>Склад</th>
                <th>Дата поставки</th>
                <th>Дата заноса</th>
                <th class="text-right" style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->list(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= $row->uniq_key ?></td>
                    <td><?= get_full_name($row->parent_id) ?></td>
                    <td><?= (new Table($db, "warehouses"))->where("id = $row->warehouse_id")->get_row()->name ?></td>
                    <td><?= date_f($row->supply_date) ?></td>
                    <td><?= ($row->completed) ? date_f($row->completed_date, 1) : '<span class="text-muted">Нет данных</span>'; ?></td>
                    <td class="text-right">
                        <div class="list-icons">
                            <?php if(!$row->completed): ?>
                                <?php if($session->session_id == $row->parent_id): ?>
                                    <a href="" onclick="Update('<?= up_url($row->id, 'WarehouseSupplyModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                <?php endif; ?>
                                <a href="<?= viv('pharmacy/supply_items') ?>?pk=<?= $row->id ?>" class="list-icons-item text-primary-600"><i class="icon-list"></i></a>
                            <?php else: ?>
                                <a href="<?= viv('pharmacy/supply_items') ?>?pk=<?= $row->id ?>" class="list-icons-item text-dark"><i class="icon-list"></i></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->panel() ?>