<?php
require_once '../../tools/warframe.php';
$session->is_auth();
is_module('module_laboratory');
?>

<div class="<?= $classes['modal-global_header'] ?>">
    <h5 class="modal-title"> 
        <?php if(isset($_GET['visit_pk'])): ?>
            Сводка Анализов
        <?php else: ?>
            Анализы
        <?php endif; ?>
    </h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="<?= $classes['table-thead'] ?>">
                <tr>
                    <th>Анализ</th>
                    <th class="text-right" style="width:12%">Норма</th>
                    <th class="text-right" style="width:7%">Ед</th>
                    <th class="text-right" style="width:10%">Результат</th>
                </tr>
            </thead>
            <tbody>

                <?php if(isset($_GET['visit_pk'])): ?>

                    <?php foreach ($db->query("SELECT id, service_name FROM visit_services WHERE visit_id = {$_GET['visit_pk']} AND level = 6 AND status = 7") as $parent): ?>
                        <tr class="table-primary text-center">
                            <th colspan="5"><b><?= $parent['service_name'] ?></b></th>
                        </tr>
                        <?php foreach ($db->query("SELECT va.deviation, va.analyze_name, va.result, sa.standart, sa.unit FROM visit_analyzes va LEFT JOIN service_analyzes sa ON(va.service_analyze_id=sa.id) WHERE va.visit_id = {$_GET['visit_pk']} AND va.visit_service_id = {$parent['id']}") as $row): ?>
                            <tr class="<?= ($row['deviation']) ? "table-danger" : "" ?>">
                                <td><?= $row['analyze_name'] ?></td>
                                <td class="text-right"><?= preg_replace("#\r?\n#", "<br />", $row['standart']) ?></td>
                                <td class="text-right"><?= preg_replace("#\r?\n#", "<br />", $row['unit']) ?></td>
                                <td class="text-right"><?= $row['result'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>

                <?php else: ?>

                    <?php $data = $db->query("SELECT visit_id, service_name FROM visit_services WHERE id = {$_GET['pk']} AND level = 6 AND status IN (3,7)")->fetch(); ?>
                    <tr class="table-primary text-center">
                        <th colspan="5"><b><?= $data['service_name'] ?></b></th>
                    </tr>
                    <?php foreach ($db->query("SELECT va.deviation, va.analyze_name, va.result, sa.standart, sa.unit FROM visit_analyzes va LEFT JOIN service_analyzes sa ON(va.service_analyze_id=sa.id) WHERE va.visit_id = {$data['visit_id']} AND va.visit_service_id = {$_GET['pk']}") as $row): ?>
                        <tr class="<?= ($row['deviation']) ? "table-danger" : "" ?>">
                            <td><?= $row['analyze_name'] ?></td>
                            <td class="text-right"><?= preg_replace("#\r?\n#", "<br />", $row['standart']) ?></td>
                            <td class="text-right"><?= preg_replace("#\r?\n#", "<br />", $row['unit']) ?></td>
                            <td class="text-right"><?= $row['result'] ?></td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>
                
            </tbody>
        </table>
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
</div>
