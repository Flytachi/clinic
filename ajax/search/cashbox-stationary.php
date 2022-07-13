<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visits vs");
$search = $tb->get_serch();
$tb->set_data("vs.id, vs.patient_id, vs.is_active, p.last_name, p.first_name, p.father_name")->additions("LEFT JOIN patients p ON(p.id=vs.patient_id)");
$where_search = array(
	"vs.direction IS NOT NULL AND vs.completed IS NULL", 
	"vs.direction IS NOT NULL AND vs.completed IS NULL AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($where_search)->set_limit(15);
$tb->set_self(viv('cashbox/stationary'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th class="text-center">ФИО</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table(1) as $row): ?>
                <tr class="<?= ($row->is_active) ? "" : "table-warning" ?>" onclick="Check('<?= up_url($row->id, 'TransactionPanel') ?>')" id="VisitIDPrice_<?= $row->id ?>">
                    <td><?= addZero($row->patient_id) ?></td>
                    <td class="text-center">
                        <div class="font-weight-semibold"><?= patient_name($row) ?></div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(isset($row->count)): ?>
                <tr class="<?= $classes['table-count_menu'] ?>">
                    <th colspan="2" class="text-right">Всего: <?= $row->count ?></th>
                </tr>
            <?php else: ?>
                <tr class="table-secondary">
                    <th colspan="2" class="text-center">Нет данных</th>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>