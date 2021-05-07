<?php
require_once '../../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "users");
$tb->set_data("id, dateBith, numberPhone, add_date");
$tb->set_self(viv('archive/all/list'));
$ser = $tb->get_serch();
$tb->where_or_serch(array("user_level = 15", "user_level = 15 AND (id LIKE '%$ser%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$ser%'))"));
$tb->order_by("id DESC")->set_limit(20);
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
                        <a href="<?= viv('archive/all/list_visit') ?>?id=<?= $row->id ?>" type="button" class="btn btn-outline-info btn-sm legitRipple">Визиты</button>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    
</div>

<?php $tb->get_panel(); ?>
