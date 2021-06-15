<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

$tb = new Table($db, "users");
$search = $tb->get_serch();
$where_search = array(
    $_GET['sql'], 
    $_GET['sql']." AND (username LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($where_search)->set_limit(1);
$tb->set_self(viv('admin/control_user'));  
?>
<div class="table-responsive">
    <table class="table table-hover table-sm table-bordered" id="table">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th style="width: 7%">ID</th>
                <th>ФИО</th>
                <th>Регистратор</th>
                <th>Дата регистрации</th>
                <th class="text-center">Status</th>
                <th class="text-center">Visit status</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table() as $row): ?>
                <tr>
                    <td><?= addZero($row->id) ?></td>
                    <td><?= get_full_name($row->id) ?></td>
                    <td><?= get_full_name($row->parent_id) ?></td>
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
                        <div class="list-icons">
                            <div class="dropdown">
                                <?php if ($row->status): ?>
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
                            <a href="<?= del_url($row->id, 'PatientForm') ?>" onclick="return confirm('Вы уверены что хотите удалить пациета?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>
