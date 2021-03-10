<?php
require_once '../tools/warframe.php';
is_auth();
?>

<?php if ($_GET['search']): ?>
    <?php
    $ser = $_GET['search'];
    $sql = "SELECT st.*,
            (
                IFNULL((SELECT SUM(opp.item_qty) FROM operation op LEFT JOIN operation_preparat opp ON(opp.operation_id=op.id) WHERE op.completed IS NULL AND opp.item_id=st.id), 0) +
                IFNULL((SELECT SUM(sto.qty) FROM storage_orders sto WHERE sto.preparat_id=st.id), 0)

            ) 'reservation'
            FROM storage st WHERE st.category IN (2,3) AND st.qty > 0 AND (st.shtrih LIKE '$ser' OR LOWER(st.name) LIKE LOWER('%$ser%')) ORDER BY st.name ASC";
    $i=0;
    ?>
    <?php foreach ($db->query($sql) as $row): ?>
        <tr onclick="Check(<?= $row['id'] ?>)">
            <td><?= $row['name'] ?> | <?= $row['supplier'] ?></td>
            <td><?= date("d.m.Y", strtotime($row['die_date'])) ?></td>
            <td class="text-right"><?= $row['qty'] - $row['reservation'] ?></td>
            <td class="text-right"><?= number_format($row['price'], 1) ?></td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
