<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_services vs");
$tb->set_data("DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, v.direction, v.add_date, vr.id 'order'")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 2 AND vs.level = 6",
	"vs.status = 2 AND vs.level = 6 AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->set_limit(20);
$tb->set_self(viv('laboratory/index'));
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Дата рождения</th>
                <th>Дата назначения</th>
                <th>Услуги</th>
                <th>Направитель</th>
                <th>Тип визита</th>
                <th class="text-center" style="width:210px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table() as $row): ?>
                <tr id="VisitService_tr_<?= $row->id ?>">
                    <td><?= addZero($row->user_id) ?></td>
                    <td>
                        <div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
                        <div class="text-muted">
                            <?php
                            // if($stm = $db->query('SELECT wd.floor, wd.ward, bd.bed FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) WHERE bd.user_id='.$row['id'])->fetch()){
                            // 	echo $stm['floor']." этаж ".$stm['ward']." палата ".$stm['bed']." койка";
                            // }
                            ?>
                        </div>
                    </td>
                    <td><?= date_f($row->birth_date) ?></td>
                    <td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td>
                        <?php foreach($db->query("SELECT id, service_name FROM visit_services WHERE visit_id = $row->id AND status = 2 AND route_id = $row->route_id AND level = 6") as $serv): ?>
                            <?php $services[] = $serv['id'] ?>
                            <span><?= $serv['service_name'] ?></span><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
                        <div class="text-muted"><?= get_full_name($row->route_id) ?></div>
                    </td>
                    <td class="text-center">
                        <?php if($row->direction): ?>
                            <span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
                        <?php else: ?>
                            <span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
                        <?php endif; ?>
                        <?php if ( $row->order ): ?>
                            <span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Ордер</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <button onclick="VisitUpStatus(<?= $row->id ?>, <?= json_encode($services) ?>)" type="button" class="btn btn-outline-success btn-sm legitRipple">Принять</button>
                    </td>
                </tr>
            <?php unset($services); endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>