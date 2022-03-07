<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_service_transactions vt");
$tb->set_data('DISTINCT vt.patient_id, p.last_name, p.first_name, p.father_name')->additions('LEFT JOIN patients p ON(p.id=vt.patient_id)');
$search = $tb->get_serch();
$search_array = array(
	"vt.is_visibility IS NOT NULL", 
	"vt.is_visibility IS NOT NULL AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->order_by('vt.add_date DESC')->set_limit(20);
$tb->set_self(viv('cashbox/list_payment'));  
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th class="text-right" style="width:210px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table() as $row): ?>
                <tr>
                    <td><?= addZero($row->patient_id) ?></td>
                    <td><div class="font-weight-semibold"><?= patient_name($row) ?></div></td>
                    <td class="text-right">
                        <a href="<?= viv('cashbox/detail_payment') ?>?pk=<?= $row->patient_id ?>" class="<?= $classes['btn-viewing'] ?>">Детально</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>