<?php
require_once '../../tools/warframe.php';
$session->is_auth();

importModel('Region');
$tb = new Table($db, "patients");
$search = $tb->get_serch();
$where_search = array(null, "(id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%'))");

$tb->where_or_serch($where_search)->order_by("add_date DESC")->set_limit(30);
$tb->set_self(viv('archive/all/list'));
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
                        <div class="font-weight-semibold"><?= patient_name($row) ?></div>
                        <div class="text-muted">
                            <?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE patient_id = $row->id")->fetch()): ?>
                                <?= $stm['building'] ?>  <?= $stm['floor'] ?> этаж <?= $stm['ward'] ?> палата <?= $stm['bed'] ?> койка;
                            <?php endif; ?>
                        </div>
                    </td>
                    <td><?= date_f($row->birth_date) ?></td>
                    <td><?= $row->phone_number ?></td>
                    <td><?= (new Region)->byId($row->region_id, 'name')->name ?></td>
                    <td><?= date_f($row->add_date, 1) ?></td>
                    <td class="text-center">
                        <?php if ($row->status): ?>
                            <span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
                        <?php else: ?>
                            <span style="font-size:15px;" class="badge badge-flat border-grey text-grey-600">Закрытый</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">	
                        <?php $stm_dr = $db->query("SELECT id, direction FROM visits WHERE patient_id = $row->id AND completed IS NULL")->fetch() ?>
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
                        <a href="<?= viv('archive/all/list_visit') ?>?id=<?= $row->id ?>" class="<?= $classes['btn-detail'] ?>"><i class="icon-eye mr-2"></i> Просмотр</a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>