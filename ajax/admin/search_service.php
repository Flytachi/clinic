<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

$tb = new Table($db, "services sc");
$tb->set_data("sc.*, ds.title")->additions("LEFT JOIN divisions ds ON(ds.id=sc.division_id)");
$search = $tb->get_serch();
$where_search = array("sc.type != 101", "sc.type != 101 AND ( sc.code LIKE '%$search%' OR LOWER(sc.name) LIKE LOWER('%$search%') OR LOWER(ds.title) LIKE LOWER('%$search%') )");

$tb->where_or_serch($where_search)->order_by("user_level, division_id, code, name ASC")->set_limit(15);
$tb->set_self(viv('admin/service'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th style="width:7%">№</th>
                <th>Роль</th>
                <th>Отдел</th>
                <th style="width:10%">Код</th>
                <th style="width:40%">Название</th>
                <th>Тип</th>
                <th>Цена</th>
                <th style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= $PERSONAL[$row->user_level] ?></td>
                    <td><?= $row->title ?></td>
                    <td><?= $row->code ?></td>
                    <td><?= $row->name ?></td>
                    <td>
                        <?php switch ($row->type) {
                            case 1:
                                echo "Обычная";
                                break;
                            case 2:
                                echo "Консультация";
                                break;
                            case 3:
                                echo "Операционная";
                                break;
                        } ?>
                    </td>
                    <td><?= $row->price ?></td>
                    <td>
                        <div class="list-icons">
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
                            <a onclick="Update('<?= up_url($row->id, 'ServiceModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                            <?php if (config("admin_delete_button_services")): ?>										
                                <a href="<?= del_url($row->id, 'ServiceModel') ?>" onclick="return confirm('Вы уверены что хотите удалить услугу?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>