<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_services vs");
$tb->set_data("vs.id, vs.user_id, vs.service_name, vs.add_date, vs.route_id, vs.division_id, vs.parent_id")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 2", 
	"vs.status = 2 AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%') OR LOWER(vs.service_name) LIKE LOWER('%$search%') )"
);
$tb->where_or_serch($search_array)->order_by('vs.id ASC')->set_limit(20);
$tb->set_self(viv('cashbox/services_not_accepted'));  
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>ID</th>
                <th>ФИО</th>
                <th>Мед услуга</th>
                <th>Дата назначения</th>
                <th>Направитель</th>
                <th>Отдел</th>
                <th class="text-center" style="width:210px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table() as $row): ?>
                <tr id="PatientFailure_tr_<?= $row->id ?>">
                    <td><?= addZero($row->user_id) ?></td>
                    <td>
                        <div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
                    </td>
                    <td><?= $row->service_name ?></td>
                    <td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td>
                        <?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
                        <div class="text-muted"><?= get_full_name($row->route_id) ?></div>
                    </td>
                    <td>
                        <?php if($row->parent_id): ?>
                            <?= division_title($row->parent_id) ?>
                            <div class="text-muted"><?= get_full_name($row->parent_id) ?></div>
                        <?php else: ?>
                            <?= $db->query("SELECT title FROM divisions WHERE id = $row->division_id")->fetchColumn() ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <button onclick="FailureVisitService('<?= del_url($row->id, 'VisitFailure') ?>')" type="button" class="btn btn-outline-danger btn-sm legitRipple">Отмена</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>