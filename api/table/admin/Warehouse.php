<?php

use Mixin\Hell;

require '../../../tools/warframe.php';

importModel('Warehouse');

$tb = new Warehouse;
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th style="width:50px">№</th>
                <th>Наименование</th>
                <th>Статус</th>
                <th>Тип</th>
                <th style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->list(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= $row->name ?></td>
                    <td>
                        <?php 
                            if($row->is_payment){
                                echo "Платный";
                            }elseif ($row->is_free) {
                                echo "Бесплатный";
                            }else{
                                echo "<span class=\"text-muted\">Нет данных</span>";
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($row->is_internal){
                                echo "Внутренний<br>";
                            }if ($row->is_external) {
                                echo "Внешний<br>";
                            }if ($row->is_operation) {
                                echo "Операционный<br>";
                            }if(!$row->is_internal and !$row->is_external and !$row->is_operation){
                                echo "<span class=\"text-muted\">Нет данных</span>";
                            }
                        ?>
                    </td>
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
                            <!-- <a onclick="ShowConf('<?= up_url($row->id, 'WarehouseSettingsModel') ?>')" href="#" class="list-icons-item text-primary"><i class="icon-cog4"></i></a> -->
                            <a onclick="ModalCheck('<?= Hell::apiGet('Warehouse', $row->id, 'permissions') ?>')" href="#" class="list-icons-item text-primary"><i class="icon-cog4"></i></a>
                            <a onclick="ModalCheck('<?= Hell::apiGet('Warehouse', $row->id, 'form') ?>')" href="#" class="list-icons-item text-dark"><i class="icon-pencil7"></i></a>
                            <?php if (config("admin_delete_button_warehouses")): ?>										
                                <a onclick="Delete('<?= Hell::apiDelete('Warehouse', $row->id) ?>', 'склад')" href="#" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

