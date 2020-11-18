<?php
require_once '../../tools/warframe.php';
is_auth();
?>
<div class="modal-header bg-info">
    <h5 class="modal-title">Анализы: <?= get_full_name($_GET['id']) ?> </h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body" id="modal_result_show_content">

    <div class="table-responsive">
        <table class="table table-hover table-sm table-bordered">
            <thead>
                <tr class="bg-info">
                    <th style="width:3%">№</th>
                    <th>Название</th>
                    <th>Направитель</th>
                    <th style="width:10%">Стандарт</th>
                    <th style="width:10%">Норматив</th>
                    <th class="text-center" style="width:25%">Примечание</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($db->query("SELECT * FROM laboratory_analyze_type WHERE service_id = {$_GET['service_id']}") as $row) {
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= get_full_name($pacc['route_id']) ?></td>
                        <td><?= $row['standart'] ?></td>
                        <td>
                            <input type="text" class="form-control" name="" value="">
                        </td>
                        <td>
                            <textarea class="form-control" name="name" rows="1" cols="80"></textarea>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<div class="modal-footer">
    <button type="submit" class="btn bg-info">Сохранить</button>
</div>
