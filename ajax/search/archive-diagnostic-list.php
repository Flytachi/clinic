<?php
require_once '../../tools/warframe.php';
$session->is_auth();

importModel('Region');
$tb = new Table($db, "patients p");
$search = $tb->get_serch();
$where_search = array(
	"vs.parent_id = $session->session_id AND vs.status = 7",
	"vs.parent_id = $session->session_id AND vs.status = 7 AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
);

$tb->set_data("DISTINCT p.id, p.last_name, p.first_name, p.father_name, p.birth_date, p.phone_number, p.region_id, p.add_date")->additions("LEFT JOIN visit_services vs ON(vs.patient_id=p.id)")->where_or_serch($where_search)->order_by("p.add_date DESC")->set_limit(20);
$tb->set_self(viv('archive/diagnostic/list'));  
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Дата рождение</th>
                <th>Телефон</th>
                <th>Регион</th>
                <th>Дата регистрации</th>
                <th class="text-center">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table() as $row): ?>
                <tr>
                    <td><?= addZero($row->id) ?></td>
                    <td>
                        <div class="font-weight-semibold"><?= patient_name($row) ?></div>
                    </td>
                    <td><?= date_f($row->birth_date) ?></td>
                    <td><?= $row->phone_number ?></td>
                    <td><?= (new Region)->byId($row->region_id, 'name')->name ?></td>
                    <td><?= date_f($row->add_date, 1) ?></td>
                    <td class="text-center">
                        <a href="<?= viv('archive/diagnostic/list_visit') ?>?id=<?= $row->id ?>" class="<?= $classes['btn-detail'] ?>"><i class="icon-eye mr-2"></i> Просмотр</a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>