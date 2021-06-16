<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

$tb = new Table($db, "wards w");
$search = $tb->get_serch();
$tb->set_data("w.id, bg.name, ds.title, w.floor, w.ward")->additions("LEFT JOIN buildings bg ON(bg.id=w.building_id) LEFT JOIN divisions ds ON(ds.id=w.division_id)");
$where_search = array(null, "LOWER(bg.name) LIKE LOWER('%$search%') OR LOWER(ds.title) LIKE LOWER('%$search%') OR LOWER(w.ward) LIKE LOWER('%$search%')");

$tb->where_or_serch($where_search)->order_by("bg.name, w.floor, w.ward ASC")->set_limit(15);
$tb->set_self(viv('admin/objects_ward'));
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th style="width:8%">№</th>
                <th>Здание</th>
                <th>Этаж</th>
                <th>Палата</th>
                <?php if(config('wards_by_division')): ?>
                    <th>Отдел</th>
                <?php endif; ?>
                <th style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= $row->name ?></td>
                    <td><?= $row->floor ?> этажей</td>
                    <td><?= $row->ward ?></td>
                    <?php if(config('wards_by_division')): ?>
                        <td><?= $row->title ?></td>
                    <?php endif; ?>
                    <td>
                        <div class="list-icons">
                            <a onclick="Update('<?= up_url($row->id, 'WardsModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                            <a href="<?= del_url($row->id, 'WardsModel') ?>" onclick="return confirm('Вы уверены что хотите удалить палату?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>
