<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "users us");
$search = $tb->get_serch();
$where_search = array(
	"us.user_level = 15 AND vs.parent_id = $session->session_id",
	"us.user_level = 15 AND vs.parent_id = $session->session_id AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);

$tb->set_data("DISTINCT us.id, us.birth_date, us.phone_number, us.region, us.add_date")->additions("LEFT JOIN visit_services vs ON(vs.user_id=us.id)")->where_or_serch($where_search)->order_by("us.add_date DESC")->set_limit(20);
$tb->set_self(viv('archive/doctor/list'));  
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
                        <div class="font-weight-semibold"><?= get_full_name($row->id) ?></div>
                    </td>
                    <td><?= date_f($row->birth_date) ?></td>
                    <td><?= $row->phone_number ?></td>
                    <td><?= $row->region ?></td>
                    <td><?= date_f($row->add_date, 1) ?></td>
                    <td class="text-center">
                        <a href="<?= viv('archive/doctor/list_visit') ?>?id=<?= $row->id ?>" class="<?= $classes['btn-detail'] ?>"><i class="icon-eye mr-2"></i> Просмотр</a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>