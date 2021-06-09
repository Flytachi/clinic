<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_services vs");
$tb->set_data("DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 3 AND v.direction IS NULL AND vs.parent_id = $session->session_id",
	"vs.status = 3 AND v.direction IS NULL AND vs.parent_id = $session->session_id AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->order_by('vs.accept_date DESC')->set_limit(20);
$tb->set_self(viv('doctor/list_outpatient'));
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>ID</th>
                <th>ФИО</th>
                <th>Дата рождения</th>
                <th>Мед услуга</th>
                <th>Направитель</th>
                <th class="text-center" style="width:210px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table() as $row): ?>
                <tr>
                    <td><?= addZero($row->user_id) ?></td>
                    <td><div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div></td>
                    <td><?= date_f($row->birth_date) ?></td>
                    <td>
                        <?php foreach($db->query("SELECT service_name, service_title FROM visit_services WHERE visit_id = $row->id AND status = 3 and parent_id = $session->session_id") as $serv): ?>
                            <span class="<?= ($serv['service_title']) ? 'text-primary' : 'text-danger' ?>"><?= $serv['service_name'] ?></span><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
                        <div class="text-muted"><?= get_full_name($row->route_id) ?></div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                            <a href="<?= viv('card/content_1') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-repo-forked"></i>Осмотр Врача</a>
                            <a href="<?= viv('card/content_3') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-add"></i>Добавить визит</a>
                            <?php if(module('module_laboratory')): ?>
                                <a href="<?= viv('card/content_5') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
                            <?php endif; ?>
                            <?php if(module('module_diagnostic')): ?>
                                <a href="<?= viv('card/content_6') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-pulse2"></i>Диагностика</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>