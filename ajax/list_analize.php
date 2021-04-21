<?php
require_once '../tools/warframe.php';
$session->is_auth();
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
                    <th>Название услуги</th>
                    <th>Анализ</th>
                    <th class="text-right" style="width:12%">Норма</th>
                    <th class="text-right" style="width:7%">Ед</th>
                    <th class="text-right" style="width:10%">Результат</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $info = $db->query("SELECT user_id, add_date, IFNULL(completed, CURRENT_TIMESTAMP()) 'completed' FROM visit WHERE id={$_GET['pk']}")->fetch();
                $norm = "scl.name, scl.code, scl.standart";
                ?>
                <?php foreach ($db->query("SELECT id FROM visit WHERE user_id = {$info['user_id']} AND laboratory IS NOT NULL AND accept_date IS NOT NULL AND (DATE_FORMAT(add_date, '%Y-%m-%d %H:%i') BETWEEN \"{$info['add_date']}\" AND \"{$info['completed']}\")") as $vis): ?>
                    <?php $items[] = $vis['id'] ?>
                    <?php foreach ($db->query("SELECT vl.id, vl.result, vl.deviation, scl.service_id 'ser_id', $norm, scl.unit FROM visit_analyze vl LEFT JOIN service_analyze scl ON (vl.analyze_id = scl.id) WHERE vl.visit_id = {$vis['id']}") as $row): ?>
                        <tr class="<?= ($row['deviation']) ? "table-danger" : "" ?>">
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
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<div class="modal-footer">
    <button onclick="Print('<?= viv('prints/document_2') ?>?id=<?= $info['user_id'] ?>&items=<?= json_encode($items) ?>')" type="button" class="btn btn-sm"><i class="icon-printer2"></i></button>
    <!-- <a onclick="PrePrint('<?= viv('prints/document_2') ?>?id=')" type="button" class="float-right <?= $class_color_add ?> mr-1"><i class="icon-printer2"></i></a> -->
    <button type="button" class="btn btn-outline-info btn-sm legitRipple" data-dismiss="modal">Закрыть</button>
</div>
