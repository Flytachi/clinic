<?php
require_once '../tools/warframe.php';
$session->is_auth();
?>
<div class="modal-header bg-info">
    <h5 class="modal-title">Детально</h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

    <div class="card table-responsive">
        <table class="table table-sm table-hover">

            <thead class="<?= $classes['table-thead'] ?>">
                <tr>
                    <th>Название</th>
                    <th>Комментарий</th>
                    <th class="text-center">Кол-во</th>
                    <th class="text-right">Действия Ед.</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($db->query("SELECT DISTINCT sc.id, sc.name FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.user_id = {$_GET['user_id']} AND vs.physio IS NOT NULL AND vs.completed IS NULL AND vs.status != 5") as $value): ?>
                    <?php
                    $li = $db->query("SELECT vs.id, vs.report, COUNT(sc.name) 'count' FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.user_id = {$_GET['user_id']} AND vs.physio IS NOT NULL AND vs.completed IS NULL AND vs.service_id = {$value['id']} AND vs.status != 5")->fetch();
                    ?>
                    <tr>
                        <td>
                            <?= $value['name'] ?>
                        </td>
                        <td><?= $li['report'] ?></td>
                        <td class="text-center"><?= $li['count'] ?></td>
                        <td class="text-right">
                            <a onclick="Complt('<?= up_url($li['id'], 'VisitFinish') ?>', '<?= $_GET['user_id'] ?>')" class="text-success">Завершить</a>
                            <a onclick="Delete('<?= del_url($li['id'], 'VisitModel') ?><?= ($_GET['type']) ? "&type=1" : "" ?>', '<?= $_GET['user_id'] ?>')" class="text-danger">Отменить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</div>
