<?php
require_once '../../tools/warframe.php';
is_auth();
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
                    <th class="text-right" style="width:7%">Ед</th>
                    <th class="text-right" style="width:10%">Норма</th>
                    <th class="text-right" style="width:10%">Результат</th>
                    <!-- <th class="text-center" style="width:25%">Примечание</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($db->query("SELECT la.id, la.result, la.deviation, la.description, lat.service_id 'ser_id', lat.name, lat.standart_min, lat.standart_max, lat.unit FROM laboratory_analyze la LEFT JOIN laboratory_analyze_type lat ON (la.analyze_id = lat.id) WHERE la.visit_id = {$_GET['pk']}") as $row) {
                    ?>
                    <tr class="<?= ($row['deviation']) ? "table-danger" : "" ?>">
                        <td><?= $i++ ?></td>
                        <td><?= $db->query("SELECT name FROM service WHERE id={$row['ser_id']}")->fetch()['name'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td class="text-right"><?= $row['unit'] ?></td>
                        <td class="text-right"><?= $row['standart_min']."-".$row['standart_max'] ?></td>
                        <td class="text-right"><?= $row['result'] ?></td>
                        <!-- <td><?= $row['description'] ?></td> -->
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
