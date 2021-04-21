<?php
require_once '../tools/warframe.php';
$session->is_auth();
?>
<?php if ($_GET['item']): ?>
    <?php
    $id = $_GET['item'];
    $sql = "SELECT st.*,
            (
                IFNULL((SELECT SUM(opp.item_qty) FROM operation op LEFT JOIN operation_preparat opp ON(opp.operation_id=op.id) WHERE op.completed IS NULL AND opp.item_id=st.id), 0) +
                IFNULL((SELECT SUM(sto.qty) FROM storage_orders sto WHERE sto.preparat_id=st.id), 0)

            ) 'reservation'
            FROM storage st WHERE st.id = $id";
    $row = $db->query($sql)->fetch();
    ?>
    <tr id="sales_table-<?= $row['id'] ?>">
        <input type="hidden" name="preparat[<?= $row['id'] ?>]" value="<?= $row['qty'] - $row['reservation'] ?>">
        <td><?= $row['name'] ?> | <?= $row['supplier'] ?></td>
        <td class="text-right">
            <input type="number" class="form-control counts" name="qty[<?= $row['id'] ?>]"
                    data-price="<?= $row['price'] ?>" onkeyup="Sum(); "
                    value="1" min="1" max="<?= $row['qty'] - $row['reservation'] ?>"
                    style="border-width: 0px 0; padding: 0.2rem 0;">
        </td>
        <td class="text-right"><?= number_format($row['price'], 1) ?></td>
        <td class="text-right">
            <div class="list-icons">
                <a onclick="$('#sales_table-<?= $row['id'] ?>').remove(); Sum();" href="#" class="list-icons-item text-danger-600"><i class="icon-x"></i></a>
            </div>
        </td>
    </tr>
    <script type="text/javascript">
        Sum();
    </script>
<?php endif; ?>
