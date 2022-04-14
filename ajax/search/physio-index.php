<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_services vs");
$tb->set_data("DISTINCT v.id, vs.patient_id, p.last_name, p.first_name, p.father_name, p.birth_date, v.direction, vr.name 'status_name'")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN patients p ON(p.id=vs.patient_id) LEFT JOIN visit_status vr ON (v.id = vr.visit_id)");
$search = $tb->get_serch();
$is_division = (division()) ? "AND vs.division_id = ".division() : null;
$is_division2 = (division()) ? "AND division_id = ".division() : null;
$search_array = array(
	"vs.status = 2 AND vs.level = 12 AND v.direction IS NULL AND (vs.parent_id IS NULL OR vs.parent_id = $session->session_id) $is_division",
	"vs.status = 2 AND vs.level = 12 AND v.direction IS NULL AND (vs.parent_id IS NULL OR vs.parent_id = $session->session_id) $is_division AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->set_limit(20);
$tb->set_self(viv('physio/index'));
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Дата рождения</th>
                <th>Мед услуга</th>
                <th class="text-right">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table() as $row): ?>
                <tr id="VisitService_tr_<?= $row->id ?>">
                    <td><?= addZero($row->patient_id) ?></td>
                    <td>
                        <span class="font-weight-semibold"><?= patient_name($row) ?></span>
                        <?php if ( $row->status_name ): ?>
                            <span style="font-size:13px;" class="badge badge-flat border-danger text-danger"><?= $row->status_name ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?= date_f($row->birth_date) ?></td>
                    <td>
                        <?php foreach($db->query("SELECT DISTINCT service_name FROM visit_services WHERE visit_id = $row->id AND status = 2 AND level = 12 AND (parent_id IS NULL OR parent_id = $session->session_id) $is_division2") as $serv): ?>
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