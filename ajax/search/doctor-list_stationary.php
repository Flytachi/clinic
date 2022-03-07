<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_services vs");
$tb->set_data("DISTINCT v.id, vs.patient_id, p.birth_date, p.last_name, p.first_name, p.father_name, vs.route_id, vr.id 'order'")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN patients p ON(p.id=vs.patient_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 3 AND vs.level = 5 AND v.direction IS NOT NULL AND vs.parent_id = $session->session_id AND vs.route_id != $session->session_id",
	"vs.status = 3 AND vs.level = 5 AND v.direction IS NOT NULL AND vs.parent_id = $session->session_id AND vs.route_id != $session->session_id AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->order_by('vs.accept_date DESC')->set_limit(20);
$tb->set_self(viv('doctor/list_stationary'));
?>
<?php
if( isset($_SESSION['message']) ){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
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
                    <td><?= addZero($row->patient_id) ?></td>
                    <td>
                        <span class="font-weight-semibold"><?= patient_name($row) ?></span>
                        <?php if ( $row->order ): ?>
                            <span style="font-size:15px;" class="badge badge-flat border-danger text-danger ml-1">Ордер</span>
                        <?php endif; ?>
                        <div class="text-muted">
                            <?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE patient_id = $row->patient_id")->fetch()): ?>
                                <?= $stm['building'] ?>  <?= $stm['floor'] ?> этаж <?= $stm['ward'] ?> палата <?= $stm['bed'] ?> койка;
                            <?php endif; ?>
                        </div>
                    </td>
                    <td><?= date_f($row->birth_date) ?></td>
                    <td>
                        <?php foreach($db->query("SELECT service_name, service_title FROM visit_services WHERE visit_id = $row->id AND status = 3 AND parent_id = $session->session_id AND level = 5") as $serv): ?>
                            <span class="<?= ($serv['service_title']) ? 'text-primary' : 'text-danger' ?>"><?= $serv['service_name'] ?></span><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
                        <div class="text-muted"><?= get_full_name($row->route_id) ?></div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                            <a href="<?= viv('card/content-1') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-repo-forked"></i>Осмотр Врача</a>
                            <a href="<?= viv('card/content-5') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-add"></i>Назначенные услуги</a>
                            <?php if(module('module_laboratory')): ?>
                                <a href="<?= viv('card/content-7') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
                            <?php endif; ?>
                            <?php if(module('module_diagnostic')): ?>
                                <a href="<?= viv('card/content-8') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-pulse2"></i>Диагностика</a>
                            <?php endif; ?>
                            <?php if(module('module_bypass')): ?>
                                <a href="<?= viv('card/content-9') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-magazine"></i>Лист назначения</a>
                            <?php endif; ?>
                            <a href="<?= viv('card/content-12') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-clipboard2"></i> Состояние</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>