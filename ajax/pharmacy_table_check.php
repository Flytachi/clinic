<?php
require_once '../tools/warframe.php';
is_auth();
?>
<div class="table-responsive card" id="check_card">
    <table class="table table-hover table-sm">
        <thead>
            <tr class="bg-info">
                <th style="width:45%">Препарат</th>
                <th>Поставщик</th>
                <th>Код</th>
                <th>Категория</th>
                <th>Срок годности</th>
                <th class="text-right">Кол-во</th>
                <th class="text-right">Цена ед.</th>
                <!-- <th class="text-right" style="width:50px">Действия</th> -->
            </tr>
        </thead>
        <tbody>
            <?php if ($_GET['type']): ?>
                <?php $sql = "SELECT * FROM storage WHERE 10 >= qty ORDER BY name ASC"; ?>
            <?php else: ?>
                <?php $sql = "SELECT * FROM storage WHERE qty_limit IS NOT NULL AND qty_limit >= qty AND 10 < qty ORDER BY name ASC"; ?>
            <?php endif; ?>
            <?php foreach ($db->query($sql) as $row): ?>
                <?php
                $tr="";
                if ($row['qty'] <= 10) {
                    // Предупреждение критическое
                    $tr = "bg-danger";
                }elseif ($row['qty_limit'] and $row['qty'] <= $row['qty_limit']){
                    // Предупреждение
                    $tr = "bg-orange text-dark";
                }
                ?>
                <tr class="<?= $tr ?>">
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['supplier'] ?></td>
                    <td><?= $row['code'] ?></td>
                    <td><?= $CATEGORY[$row['category']] ?></td>
                    <td><?= date("d.m.Y", strtotime($row['die_date'])) ?></td>
                    <td class="text-right"><?= $row['qty'] ?></td>
                    <td class="text-right"><?= number_format($row['price'], 1) ?></td>
                    <!--
                    <td>
                        <div class="list-icons">
                            <a href="<?= up_url($row['id'], 'Storage') ?>" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                            <a href="<?= del_url($row['id'], 'Storage') ?>" onclick="return confirm('Вы уверены что хотите удалить препарат?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                        </div>
                    </td>
                    -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
