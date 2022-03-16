<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visits vs");
$search = $tb->get_serch();
$tb->set_data("DISTINCT vss.visit_id, vs.patient_id, p.last_name, p.first_name, p.father_name")->additions("LEFT JOIN visit_services vss ON(vss.visit_id=vs.id) LEFT JOIN patients p ON(p.id=vs.patient_id)");

$where_search = array(
	"vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 5", 
	"vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 5 AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($where_search);
$tb->set_self(viv('cashbox/index'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th class="text-center">ФИО</th>
            </tr>
        </thead>
        <tbody id="search_display">
            <?php foreach($tb->get_table(1) as $row): ?>
                <tr onclick="Check('<?= up_url($row->visit_id, 'TransactionPanel') ?>')">
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