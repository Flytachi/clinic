<?php
require_once '../tools/warframe.php';
is_auth();
?>
<?php foreach ($_GET['preparat'] as $pk): ?>
    <?php
    $inf = $db->query("SELECT name, supplier, die_date FROM storage WHERE id = $pk")->fetch();
    ?>
    <tr class="table-secondary">
        <td><?= $inf['name'] ?> | <?= $inf['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($inf['die_date'])) ?>)</td>
        <td class="text-right">
            <input type="number" class="form-control" name="qty[<?= $pk ?>]" value="1" style="border-width: 0px 0; padding: 0.2rem 0;">
        </td>
    </tr>
<?php endforeach; ?>
