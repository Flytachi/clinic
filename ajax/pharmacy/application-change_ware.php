<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
?>
<div class="table-responsive card">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>Информация</th>
            </tr>
        </thead>
        <tbody>
            <tr onclick="ChangeWare(this)">
                <td>Все</td>
            </tr>
        </tbody>
    </table>
</div>