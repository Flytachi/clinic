<?php
require_once '../../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "users us");
$tb->set_data("DISTINCT us.id, us.dateBith, us.numberPhone, us.add_date");
$tb->set_self(viv('archive/assist/list'));
$search = $tb->get_serch();

$search_array = array(
	"vs.completed IS NOT NULL AND vs.assist_id = $session->session_id", 
	"vs.completed IS NOT NULL AND vs.assist_id = $session->session_id AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->additions("LEFT JOIN visit vs ON(us.id=vs.user_id)")->where_or_serch($search_array)->order_by("us.id DESC")->set_limit(20);
?>
<div class="table-responsive card">
    <table class="table table-hover table-sm">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>ID</th>
                <th>ФИО</th>
                <th>Дата рождения</th>
                <th>Номер телефона</th>
                <th>Дата регистрации </th>
                <th class="text-center" style="width:210px">Действия</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($tb->get_table() as $row): ?>
                <tr>
                    <td><?= addZero($row->id) ?></td>
                    <td><div class="font-weight-semibold"><?= get_full_name($row->id) ?></div></td>
                    <td><?= date_f($row->dateBith) ?></td>
                    <td><?= $row->numberPhone ?></td>
                    <td><?= date_f($row->add_date, 1) ?></td>
                    <td class="text-center">
                        <a href="<?= viv('archive/assist/list_visit') ?>?id=<?= $row->id ?>" type="button" class="<?= $classes['btn_detail'] ?>">Визиты</button>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>
