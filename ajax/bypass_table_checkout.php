<?php
require_once '../tools/warframe.php';
$session->is_auth();
// dd($_POST);
if ($_POST['type']) {
    ?>
    <div class="form-group row">
        <div class="col-md-12">
            <label>Диеты:</label>
            <select data-placeholder="Выбрать диету" name="diet_id" class="form-control myselect">
                <option></option>
                <?php foreach ($db->query("SELECT * FROM diet") as $row): ?>
                    <option value="<?= $row['id'] ?>" ><?= $row['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    <legend><b>Время принятия:</b></legend>
    <div class="form-group row" id="time_div"></div>
    <?php foreach ($DIET_TIME as $time): ?>
        <script type="text/javascript">
            AddinputTime("<?= $time ?>");
        </script>
    <?php endforeach; ?>
    
    <script type="text/javascript">
        Select2Selects.init();
    </script>
    <?php
} else {
    ?>
    <div class="form-group row">
        <div class="col-md-9">
            <label>Препараты:</label>
            <select id="select_preparat" class="form-control my_multiselect" data-placeholder="Выбрать препарат" name="preparat[]" multiple="multiple">
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

        </div>

        <div class="col-md-3">
            <label>Сторонний препарат:</label>
            <button onclick="AddPreparat()" class="btn btn-outline-success btn-sm legitRipple" type="button"><i class="icon-plus22 mr-2"></i>Добавить препарат</button>
        </div>

    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Препарат</th>
                        <th class="text-right" style="width:100px">Кол-во</th>
                    </tr>
                </thead>
                <tbody id="preparat_div"></tbody>
                <tbody id="preparat_div_outside"></tbody>
            </table>
        </div>
    </div>

    <div class="form-group row">

        <div class="col-md-6">
            <label>Метод:</label>
            <select data-placeholder="Выбрать метод" name="method" class="<?= $classes['form-select'] ?>" required>
                <option></option>
                <?php foreach ($methods as $key => $value): ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>

        </div>

        <div class="col-md-6">
            <label>Описание:</label>
            <input type="text" class="form-control" name="description" placeholder="Введите описание">
        </div>

    </div>

    <legend><b>Время принятия:</b></legend>
    <div class="form-group row" id="time_div">
        <div class="col-md-3" id="time_input_0">
            <input type="time" name="time[0]" class="form-control" required>
        </div>
    </div>

    <script type="text/javascript">
        $('#select_preparat').on('change', function(events){
            // $('#preparat_div').html();

            $.ajax({
                type: "GET",
                url: "<?= ajax('bypass_table') ?>",
                data: $('#select_preparat').serializeArray(),
                success: function (result) {
                    $('#preparat_div').html(result);
                },
            });

        });
        BootstrapMultiselect.init();
        FormLayouts.init();
    </script>
    <?php
}
?>