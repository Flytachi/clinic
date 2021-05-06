<?php
require_once '../../../tools/warframe.php';
$session->is_auth();

if(empty($_GET['search'])){
    $where = "user_level = 15";
}else {
    $ser = $_GET['search'];
    $where = "user_level = 15 AND (id LIKE '%$ser%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$ser%'))";
}
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
            <?php
            $table = new Table($db, "users us");
            $table->set_data("id, dateBith, numberPhone, add_date");
            $table->where($where);
            $table->order_by("id DESC");
            $table->set_limit(20);
            ?>
            <?php foreach ($table->get_table() as $row): ?>
                <tr>
                    <td><?= addZero($row['id']) ?></td>
                    <td><div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div></td>
                    <td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
                    <td><?= $row['numberPhone'] ?></td>
                    <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                    <td class="text-center">
                        <a href="<?= viv('archive/all/list_visit') ?>?id=<?= $row['id'] ?>" type="button" class="btn btn-outline-info btn-sm legitRipple">Визиты</button>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    
</div>

<?php $table->get_panel(); ?>
