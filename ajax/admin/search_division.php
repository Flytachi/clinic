<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

$tb = new Table($db, "divisions");
$search = $tb->get_serch();
$where_search = array(null, "LOWER(title) LIKE LOWER('%$search%') OR LOWER(name) LIKE LOWER('%$search%')");

$tb->where_or_serch($where_search)->order_by("level, title ASC")->set_limit(15);
$tb->set_self(viv('admin/division'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th style="width:7%">№</th>
                <th>Метка</th>
                <th>Роль</th>
                <th>Отдел</th>
                <th>Название специолиста</th>
                <th style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= $row->mark ?></td>
                    <td><?= $PERSONAL[$row->level] ?></td>
                    <td><?= $row->title ?></td>
                    <td><?= $row->name ?> <?= ($row->assist == 1) ? "\"Ассистент\"" : "" ?></td>
                    <td>
                        <div class="list-icons">
                            <a onclick="Update('<?= up_url($row->id, 'DivisionModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                            <a href="<?= del_url($row->id, 'DivisionModel') ?>" onclick="return confirm('Вы уверены что хотите удалить отдел?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>