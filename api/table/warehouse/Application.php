<?php

use Mixin\Hell;

require '../../../tools/warframe.php';
$session->is_auth();

importModel('WarehouseStorageApplication');

$tb = new WarehouseStorageApplication('wa');
$search = $tb->getSearch();
$tb->Data('wa.id, wa.responsible_id, win.name, wa.item_manufacturer_id, wa.item_qty, wa.status, wa.add_date');
$tb->JoinLEFT('warehouse_item_names win', 'win.id=wa.item_name_id');
if ($_GET['is_grant']) {
	$where = array(
		"wa.warehouse_id_in = {$_GET['warehouse']} AND wa.status != 3", 
		"wa.warehouse_id_in = {$_GET['warehouse']} AND wa.status != 3 AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
	);
} else {
	$where = array(
		"wa.warehouse_id_in = {$_GET['warehouse']} AND wa.status != 3 AND wa.responsible_id = $session->session_id", 
		"wa.warehouse_id_in = {$_GET['warehouse']} AND wa.status != 3 AND wa.responsible_id = $session->session_id AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
	);
}
$tb->Where($where)->Order("win.name ASC")->Limit(20);
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th style="width: 50px">#</th>
                <?php if($_GET['is_grant']): ?>
                    <th style="width:200px">Заявитель</th>
                <?php endif; ?>
                <th>Наименование</th>
                <th style="width:250px">Производитель</th>
                <th style="width:200px">Дата заяки</th>
                <th class="text-right" style="width:100px">Кол-во</th>
                <th class="text-center">Статус</th>
                <th class="text-right" style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->list(1) as $row): ?>
                <tr id="TR_item_<?= $row->count ?>">
                    <td><?= $row->count ?></td>
                    <?php if($_GET['is_grant']): ?>
                        <td><?= get_full_name($row->responsible_id) ?></td>
                    <?php endif; ?>
                    <td><?= $row->name ?></td>
                    <td>
                        <?php if($row->item_manufacturer_id): ?>
                            <span><?= $db->query("SELECT manufacturer FROM warehouse_item_manufacturers WHERE id = $row->item_manufacturer_id")->fetchColumn() ?></span>
                        <?php else: ?>
                            <span class="text-muted">Нет данных</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date_f($row->add_date, 1) ?></td>
                    <td class="text-right"><?= $row->item_qty ?></td>
                    <td class="text-center">
                        <?php if ($row->status == 1): ?>
                            <span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Подтверждение</span>
                        <?php elseif ($row->status == 2): ?>
                            <span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Перевод</span>
                        <?php elseif ($row->status == 3): ?>
                            <span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершён</span>
                        <?php elseif ($row->status == 4): ?>
                            <span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Отказано</span>
                        <?php else: ?>
                            <span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Неизвестный</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right"s>
                        <div class="list-icons">
                            <?php if ( ($row->responsible_id == $session->session_id and $row->status == 1) or ($_GET['is_grant'] and in_array($row->status, [1,2,4])) ): ?>
                                <a href="#" onclick="Delete(<?= $row->count ?>, '<?= Hell::apiDelete('WarehouseStorageApplication', $row->id) ?>')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                            <?php endif; ?>
                            <?php if ($_GET['is_grant']): ?>
                                <?php if ( $row->status == 2 ): ?>
                                    <span class="list-icons-item text-success ml-1"><i class="icon-clipboard2"></i></span>
                                <?php else: ?>
                                    <a href="#" onclick="ConfirmApplication(<?= $row->count ?>, '<?= Hell::apiAxe('WarehouseStorageApplication', array('id' => $row->id, 'status' => 2)) ?>')" class="list-icons-item ml-1"><i class="icon-clipboard"></i></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->panel(); ?>