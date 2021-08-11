<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

$tb = new Table($db, "users");
$search = $tb->get_serch();
$where_search = array("user_level != 15", "user_level != 15 AND (username LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%'))");

$tb->where_or_serch($where_search)->order_by("user_level, last_name ASC")->set_limit(15);
$tb->set_self(viv('admin/index'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>#</th>
                <th>Логин</th>
                <th>ФИО</th>
                <th>Роль</th>
                <th>Кабинет</th>
                <th style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= $row->username ?></td>
                    <td><?= get_full_name($row->id); ?></td>
                    <td>
                        <?php
                        echo $PERSONAL[$row->user_level];
                        if(division_name($row->id)){
                            echo " (".division_name($row->id).")";
                        }
                        ?>
                    </td>
                    <td><?= $row->room ?></td>
                    <td>
                        <div class="list-icons">

                            <?php if ($row->user_level != 1): ?>
                                <div class="dropdown">                      
                                    <?php if ($row->is_active): ?>
                                        <a href="#" id="status_change_<?= $row->id ?>" class="badge bg-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Active</a>
                                    <?php else: ?>
                                        <a href="#" id="status_change_<?= $row->id ?>" class="badge bg-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Pasive</a>
                                    <?php endif; ?>

                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(74px, 21px, 0px);">
                                        <a onclick="Change(<?= $row->id ?>, 1)" class="dropdown-item">
                                            <span class="badge badge-mark mr-2 border-success"></span>
                                            Active
                                        </a>
                                        <a onclick="Change(<?= $row->id ?>, 0)" class="dropdown-item">
                                            <span class="badge badge-mark mr-2 border-secondary"></span>
                                            Pasive
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <a onclick="Update('<?= up_url($row->id, 'UserModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                            <?php if (config("admin_delete_button_users")): ?>
                                <?php if ($row->user_level != 1): ?>
                                    <a href="<?= del_url($row->id, 'UserModel') ?>" onclick="return confirm('Вы уверены что хотите удалить пользоватиля?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                                <?php endif; ?>													
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>
