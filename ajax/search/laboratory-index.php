<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_services vs");
$tb->set_data("DISTINCT v.id, vs.patient_id, p.last_name, p.first_name, p.father_name, p.birth_date, vs.route_id, v.direction, v.add_date, vr.id 'order'")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN patients p ON(p.id=vs.patient_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 2 AND vs.level = 6",
	"vs.status = 2 AND vs.level = 6 AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
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
            <?php foreach($tb->get_table(1) as $row): ?>
                <tr id="VisitService_tr_<?= $row->count ?>">
                    <td><?= addZero($row->patient_id) ?></td>
                    <td>
                        <span class="font-weight-semibold"><?= patient_name($row) ?></span>
                        <?php if ( $row->order ): ?>
                            <span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Ордер</span>
                        <?php endif; ?>
                        <div class="text-muted">
                            <?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE patient_id = $row->patient_id")->fetch()): ?>
                                <?= $stm['building'] ?>  <?= $stm['floor'] ?> этаж <?= $stm['ward'] ?> палата <?= $stm['bed'] ?> койка;
                            <?php endif; ?>
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
                    </td>
                    <td class="text-center">
                        <button onclick="VisitUpStatus(<?= $row->count ?>, <?= $row->patient_id ?>, <?= json_encode($services) ?>)" type="button" class="btn btn-outline-success btn-sm legitRipple">Забор</button>
                    </td>
                </tr>
            <?php unset($services); endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>