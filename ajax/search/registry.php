<?php
require_once '../../tools/warframe.php';
$session->is_auth([2, 32]);

$tb = new Table($db, "users");
$search = $tb->get_serch();
$where_search = array("user_level = 15", "user_level = 15 AND (id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%'))");

$tb->where_or_serch($where_search)->order_by("add_date DESC")->set_limit(20);
$tb->set_self(viv('registry/list_patient'));  
?>
<div class="table-responsive">
    <table class="table table-hover table-sm table-bordered">
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
                    <td><?= date_f($row->dateBith) ?></td>
                    <td><?= $row->numberPhone ?></td>
                    <td><?= $row->region ?></td>
                    <td><?= date_f($row->add_date, 1) ?></td>
                    <td class="text-center">
                        <button type="button" class="<?= $classes['btn_detail'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                            <a onclick="Update('<?= up_url($row->id, 'PatientForm') ?>')" class="dropdown-item"><i class="icon-quill2"></i>Редактировать</a>
                            <a href="<?= viv('archive/all/list_visit') ?>?id=<?= $row->id ?>" class="dropdown-item"><i class="icon-users4"></i> Визиты</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>
