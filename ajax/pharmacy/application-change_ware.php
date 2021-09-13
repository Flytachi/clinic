<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
$pk = $_GET['pk'];
?>
<div class="table-responsive card">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>Информация</th>
                <th class="text-right">Кол-во заявок</th>
            </tr>
        </thead>
        <tbody>
            <tr onclick="ChangeWareType(this)">
                <td>Все</td>
                <td class="text-right"><?= $db->query("SELECT * FROM warehouse_applications WHERE warehouse_id = $pk AND status = 2")->rowCount(); ?></td>
            </tr>
            <tr onclick="ChangeWareType(this)">
                <td>Пациенты</td>
                <td class="text-right"><?= $db->query("SELECT * FROM warehouse_applications WHERE warehouse_id = $pk AND status = 2 AND user_id IS NOT NULL")->rowCount(); ?></td>
            </tr>
            <tr onclick="ChangeWareType(this)">
                <td>Персонал</td>
                <td class="text-right"><?= $db->query("SELECT * FROM warehouse_applications WHERE warehouse_id = $pk AND status = 2 AND user_id IS NULL")->rowCount(); ?></td>
            </tr>
        </tbody>
    </table>
</div>