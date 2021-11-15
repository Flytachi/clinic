<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

$tb = (new UserModel)->tb();
$search = $tb->get_serch();
$tb->set_data("id, is_active, branch_id, username, first_name, last_name, father_name, user_level, division_id");
$where_search = array("", "(username LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%'))");
$tb->where_or_serch($where_search)->order_by("user_level, last_name ASC")->set_limit(20);
$tb->set_self(viv('admin/users'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>#</th>
                <th>Филиал</th>
                <th>Логин</th>
                <th>ФИО</th>
                <th>Роль</th>
                <th style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= ($row->branch_id) ? (new CorpBranchModel)->tb()->by_id($row->branch_id)->get_row()->name : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td><?= $row->username ?></td>
                    <td><?= get_full_name($row); ?></td>
                    <td>
                        <?php
                        echo $PERSONAL[$row->user_level];
                        if(division_name($row->id)){
                            echo " (".division_name($row->id).")";
                        }
                        ?>
                    </td>
                    <td>
                        <div class="list-icons">

                            <?php if ($row->user_level != $session->session_level): ?>
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
                                <a href="<?= ajax("master/avatar") ?>?pk=<?= $row->id ?>" class="list-icons-up text-success"><i class="icon-arrow-up16"></i></a>
                            <?php endif; ?>
                            <a onclick="Update('<?= up_url($row->id, 'UserModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                            <?php if (config("admin_delete_button_users")): ?>
                                <?php if ($row->user_level != $session->session_level): ?>
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