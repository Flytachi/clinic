<?php
require_once '../../tools/warframe.php';
$session->is_auth();
is_module('module_laboratory');
?>

<div class="modal-header bg-info">
    <h5 class="modal-title">Анализы: </h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="bg-info">
                    <th style="width:3%">№</th>
                    <th>Название услуги</th>
                    <th>Анализ</th>
                    <th class="text-right" style="width:12%">Норма</th>
                    <th class="text-right" style="width:7%">Ед</th>
                    <th class="text-right" style="width:10%">Результат</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $norm = "scl.name, scl.code, scl.standart";
                foreach ($db->query("SELECT vl.id, vl.result, vl.deviation, scl.service_id 'ser_id', $norm, scl.unit FROM visit_analyze vl LEFT JOIN service_analyze scl ON (vl.analyze_id = scl.id) WHERE vl.visit_id = {$_GET['pk']}") as $row) {
                    ?>
                    <tr class="<?= ($row['deviation']) ? "table-danger" : "" ?>">
                        <td><?= $i++ ?></td>
                        <td><?= $db->query("SELECT name FROM service WHERE id={$row['ser_id']}")->fetch()['name'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td class="text-right">
                            <?= preg_replace("#\r?\n#", "<br />", $row['standart']) ?>
                        </td>
                        <td class="text-right">
                            <?= preg_replace("#\r?\n#", "<br />", $row['unit']) ?>
                        </td>
                        <td class="text-right"><?= $row['result'] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-outline-info btn-sm legitRipple" data-dismiss="modal">Закрыть</button>
</div>
