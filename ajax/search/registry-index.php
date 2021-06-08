<?php
require_once '../../tools/warframe.php';
$session->is_auth([2, 32]);

$tb = new Table($db, "users");
$search = $tb->get_serch();
$where_search = array("user_level = 15", "user_level = 15 AND (id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%'))");

$tb->where_or_serch($where_search)->order_by("add_date DESC")->set_limit(20);
$tb->set_self(viv('registry/list_patient'));  
?>
<?php
if( isset($_SESSION['message']) ){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
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
                <th class="text-center">Статус</th>
                <th class="text-center">Тип визита</th>
                <th class="text-center">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table() as $row): ?>
                <tr>
                    <td><?= addZero($row->id) ?></td>
                    <td>
                        <div class="font-weight-semibold"><?= get_full_name($row->id) ?></div>
                        <div class="text-muted">
                            <?php
                            if($stm = $db->query("SELECT wd.floor, wd.ward, bd.bed FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) WHERE bd.user_id= $row->id")->fetch()){
                                echo $stm['floor']." этаж ".$stm['ward']." палата ".$stm['bed']." койка";
                            }
                            ?>
                        </div>
                    </td>
                    <td><?= date_f($row->birth_date) ?></td>
                    <td><?= $row->phone_number ?></td>
                    <td><?= $row->region ?></td>
                    <td><?= date_f($row->add_date, 1) ?></td>
                    <td class="text-center">
                        <?php if ($row->status): ?>
                            <span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
                        <?php else: ?>
                            <span style="font-size:15px;" class="badge badge-flat border-grey text-grey-600">Закрытый</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">	
                        <?php $stm_dr = $db->query("SELECT id, direction FROM visits WHERE user_id = $row->id AND completed IS NULL")->fetch() ?>
                        <?php if ( isset($stm_dr['id']) ): ?>
                            <?php if ($stm_dr['direction']): ?>
                                <span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
                            <?php else: ?>
                                <span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span style="font-size:15px;" class="badge badge-flat border-grey text-grey-300">Нет данных</span>
                        <?php endif; ?>
                    </td>
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