<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$is_grant = $_GET['is_grant'];

$tb = new Table($db, "warehouse_storage_applications wa");
$search = $tb->get_serch();
$tb->set_data('wa.id, wa.responsible_id, win.name, wa.item_manufacturer_id, wa.item_qty, wa.status, wa.add_date')->additions("LEFT JOIN warehouse_item_names win ON(win.id=wa.item_name_id)");
if ($is_grant) {
	$where_search = array(
		"wa.warehouse_id_in = {$_GET['pk']} AND wa.status != 3", 
		"wa.warehouse_id_in = {$_GET['pk']} AND wa.status != 3 AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
	);
} else {
	$where_search = array(
		"wa.warehouse_id_in = {$_GET['pk']} AND wa.status != 3 AND wa.responsible_id = $session->session_id", 
		"wa.warehouse_id_in = {$_GET['pk']} AND wa.status != 3 AND wa.responsible_id = $session->session_id AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
	);
}


$tb->where_or_serch($where_search)->order_by("win.name ASC")->set_limit(20);
$tb->set_self(viv('warehouse/application'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th style="width: 50px">#</th>
                <?php if($is_grant): ?>
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
            <?php foreach ($tb->get_table(1) as $row): ?>
                <tr id="TR_item_<?= $row->count ?>">
                    <td><?= $row->count ?></td>
                    <?php if($is_grant): ?>
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
                            <?php if ( ($row->responsible_id == $session->session_id and $row->status == 1) or ($is_grant and in_array($row->status, [1,2,4])) ): ?>
                                <a href="#" onclick="Delete(<?= $row->count ?>, '<?= del_url($row->id, 'WarehouseApplication') ?>')" onclick="return confirm('Вы уверены что хотите удалить заявку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                            <?php endif; ?>
                            <?php if ($is_grant): ?>
                                <?php if ( $row->status == 2 ): ?>
                                    <span class="list-icons-item text-success ml-1"><i class="icon-clipboard2"></i></span>
                                <?php else: ?>
                                    <a href="#" onclick="ConfirmApplication(<?= $row->id ?>, <?= $row->count ?>)" class="list-icons-item ml-1"><i class="icon-clipboard"></i></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>