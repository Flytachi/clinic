<?php
require_once '../tools/warframe.php';
is_auth();
?>
<div class="table-responsive card" id="check_card">
    <table class="table table-hover table-sm">
        <thead>
            <tr class="bg-info">
                <th>№</th>
                <th>Препарат</th>
                <th>Ответственный</th>
                <th>Изначально</th>
                <th>Остаток</th>
                <th class="text-right">Цена</th>
                <th class="text-right">Сумма</th>
                <th class="text-right" style="width:70px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach ($db->query("SELECT * FROM storage_home WHERE DATEDIFF(die_date, CURRENT_DATE()) <= 10 ORDER BY name ASC") as $row): ?>
                <?php
                $tr="";
                if ($dr= date_diff(new \DateTime(), new \DateTime($row['die_date']))->days <= 10) {
                    // Предупреждение срока годности
                    $tr = "bg-danger";
                    $btn = "text-success";
                }
                ?>
                <tr class="<?= $tr ?>">
                    <td><?= $i++ ?></td>
                    <td><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>)</td>
                    <td><?= get_full_name($row['parent_id']) ?></td>
                    <td><?= $row['qty'] + $row['qty_sold'] ?></td>
                    <td><?= $row['qty'] ?></td>
                    <td class="text-right"><?= number_format($row['price'],1) ?></td>
                    <td class="text-right"><?= number_format(($row['price'] * $row['qty']), 1) ?></td>
                    <td class="text-right">
                        <div class="list-icons">
                            <a href="<?= del_url($row['id'], 'StorageHomeModel') ?>" onclick="return confirm(`Возврат препарата - '<?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>)' ?`)" class="list-icons-item <?= ($btn) ? $btn :"text-danger" ?>"><i class="icon-reply"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
