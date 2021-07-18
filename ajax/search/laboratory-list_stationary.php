<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_services vs");
$tb->set_data("DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, v.add_date")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)");
$search = $tb->get_serch();
$is_division = (division()) ? "AND vs.division_id = ".division() : null;
$search_array = array(
	"vs.status = 3 AND vs.level = 6 AND v.direction IS NOT NULL $is_division",
	"vs.status = 3 AND vs.level = 6 AND v.direction IS NOT NULL $is_division AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->set_limit(20);
$tb->set_self(viv('laboratory/list_stationary'));
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
                <th>Направитель</th>
                <th class="text-center" style="width:210px">Действия</th>
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
                        <?php foreach($db->query("SELECT vs.id, vs.service_name FROM visit_services vs WHERE vs.visit_id = $row->id AND vs.status = 3 AND vs.level = 6 AND vs.route_id = $row->route_id $is_division") as $serv): ?>
                            <?php $services[] = $serv['id'] ?>
                            <span><?= $serv['service_name'] ?></span><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
                        <div class="text-muted"><?= get_full_name($row->route_id) ?></div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i>Просмотр</button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                            <a onclick="ResultShow('<?= up_url($row->id, 'VisitAnalyzesModel') ?>&items=<?= json_encode($services) ?>')" class="dropdown-item"><i class="icon-pencil7"></i> Добавить результ</a>
                            <a onclick="PrintLab('<?= viv('prints/labrotoria_label') ?>?id=<?= $row->id ?>')" class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
                        </div>
                    </td>
                </tr>
            <?php unset($services); endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>