<?php
require_once '../tools/warframe.php';
is_auth();
// dd($_POST);
if ($_POST['type']) {
    ?>
    <select data-placeholder="Выбрать регион" name="region" id="region" class="form-control myselect">
        <option></option>
        <?php foreach ($db->query("SELECT * FROM diet") as $row): ?>
            <option value="<?= $row['name'] ?>" data-chained="<?= $row['id'] ?>" <?= ($post[''] == $row['']) ? "" : "" ?>><?= $row[''] ?></option>
        <?php endforeach; ?>
    </select>
    <?php
} else {
    ?>
    <select id="select_preparat" class="form-control multiselect-full-featured" data-placeholder="Выбрать препарат" name="preparat[]" multiple="multiple" data-fouc>
        <?php $sql = "SELECT st.id, st.price, st.name, st.supplier, st.die_date,
            ( 
                st.qty -
                IFNULL((SELECT SUM(opp.item_qty) FROM operation op LEFT JOIN operation_preparat opp ON(opp.operation_id=op.id) WHERE op.completed IS NULL AND opp.item_id=st.id), 0) -
                IFNULL((SELECT SUM(sto.qty) FROM storage_orders sto WHERE sto.preparat_id=st.id), 0)
            ) 'qty'
            FROM storage st WHERE st.category = 2 AND st.qty != 0";?>
        <?php foreach ($db->query($sql) as $row): ?>
            <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>) в наличии - <?= $row['qty'] ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}
?>
<script type="text/javascript">
    $( document ).ready(function() {
        Select2Selects.init();
        BootstrapMultiselect.init();
    });
</script>