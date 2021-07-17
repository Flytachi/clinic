<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_services vs");
$tb->set_data("DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, v.direction, v.add_date")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 2 AND vs.level = 12 AND v.direction IS NOT NULL",
	"vs.status = 2 AND vs.level = 12 AND v.direction IS NOT NULL AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->set_limit(20);
$tb->set_self(viv('physio/list_stationary'));
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Дата рождения</th>
                <th>Дата назначения</th>
                <th>Мед услуга</th>
                <th class="text-center" style="width:300px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table() as $row): ?>
                <tr id="VisitService_tr_<?= $row->id ?>">
                    <td><?= addZero($row->user_id) ?></td>
                    <td>
                        <div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
                    </td>
                    <td><?= date_f($row->birth_date) ?></td>
                    <td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td>
                        <?php foreach($db->query("SELECT DISTINCT service_name FROM visit_services WHERE visit_id = $row->id AND level = 12") as $serv): ?>
                            <span><?= $serv['service_name'] ?></span><br>
                        <?php endforeach; ?>
                    </td>
                    <td class="text-center">
                        <button onclick="MListVisit('<?= up_url($row->id, 'VisitPhysioModel') ?>')" class="<?= $classes['btn-viewing'] ?>">Детально</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>