<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

$tb = new Table($db, "multi_accounts");
$search = $tb->get_serch();
$where_search = array(null, "LOWER(slot) LIKE LOWER('%$search%')");

$tb->where_or_serch($where_search)->order_by("slot ASC")->set_limit(15);
$tb->set_self(viv('admin/multi_account'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>Slot</th>
                <th>id</th>
                <th>Пользователь</th>
                <th style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table() as $row): ?>
                <tr>
                    <td><?= $row->slot ?></td>
                    <td><?= $row->user_id ?></td>
                    <td><?= get_full_name($row->user_id) ?></td>
                    <td>
                        <div class="list-icons">
                            <a onclick="Update('<?= up_url($row->id, 'MultiAccountsModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                            <a href="<?= del_url($row->id, 'MultiAccountsModel') ?>" onclick="return confirm('Вы уверены что хотите удалить слот?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>