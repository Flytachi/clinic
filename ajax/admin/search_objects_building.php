<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

$tb = new Table($db, "buildings");
$search = $tb->get_serch();
$where_search = array(null, "LOWER(name) LIKE LOWER('%$search%')");

$tb->where_or_serch($where_search)->set_limit(15);
$tb->set_self(viv('admin/objects_building'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>Название</th>
                <th>Этажи</th>
                <th style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table() as $row): ?>
                <tr>
                    <td><?= $row->name ?></td>
                    <td><?= $row->floors ?> этажей</td>
                    <td>
                        <div class="list-icons">
                            <a onclick="Update('<?= up_url($row->id, 'BuildingsModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                            <a href="<?= del_url($row->id, 'BuildingsModel') ?>" onclick="return confirm('Вы уверены что хотите удалить объект?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>
