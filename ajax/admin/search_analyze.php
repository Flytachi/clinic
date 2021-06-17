<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

$tb = new Table($db, "service_analyzes sl");
$tb->set_data("sl.*, sc.name 'service_name'")->additions("LEFT JOIN services sc ON(sc.id=sl.service_id)");
$search = $tb->get_serch();
$where_search = array(null, "LOWER(sc.name) LIKE LOWER('%$search%') OR LOWER(sl.code) LIKE LOWER('%$search%') OR LOWER(sl.name) LIKE LOWER('%$search%')");

$tb->where_or_serch($where_search)->order_by("sc.name, sl.code, sl.name ASC")->set_limit(15);
$tb->set_self(viv('admin/analyze'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th style="width:7%">№</th>
                <th>Услуга</th>
                <th>Код</th>
                <th>Название</th>
                <th>Норма</th>
                <th>Ед</th>
                <th style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= $row->service_name ?></td>
                    <td><?= $row->code ?></td>
                    <td><?= $row->name ?></td>
                    <td>
                        <?= preg_replace("#\r?\n#", "<br />", $row->standart) ?>
                    </td>
                    <td>
                        <?= preg_replace("#\r?\n#", "<br />", $row->unit) ?>
                    </td>
                    <td>
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
                            <a onclick="Update('<?= up_url($row->id, 'ServiceAnalyzesModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                            <a href="<?= del_url($row->id, 'ServiceAnalyzesModel') ?>" onclick="return confirm('Вы уверены что хотите удалить анализ?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>