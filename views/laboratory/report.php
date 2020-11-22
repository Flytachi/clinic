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
        <table class="table table-hover table-sm table-bordered">
            <thead>
                <tr class="bg-info">
                    <th style="width:3%">№</th>
                    <th>Название услуги</th>
                    <th>Анализ</th>
                    <th>Направитель</th>
                    <th style="width:10%">Норматив</th>
                    <th style="width:10%">Результат</th>
                    <th class="text-center" style="width:25%">Примечание</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($db->query("SELECT la.id, la.result, la.description, lat.service_id 'ser_id', lat.name, lat.standart FROM laboratory_analyze la LEFT JOIN laboratory_analyze_type lat ON (la.analyze_id = lat.id) WHERE la.visit_id = {$_GET['pk']}") as $row) {
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $db->query("SELECT name FROM service WHERE id={$row['ser_id']}")->fetch()['name'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= get_full_name($pacc['route_id']) ?></td>
                        <td><?= $row['standart'] ?></td>
                        <td><?= $row['result'] ?></td>
                        <td><?= $row['description'] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-info legitRipple" data-dismiss="modal">Закрыть</button>
</div>
