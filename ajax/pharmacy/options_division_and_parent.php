<?php
require_once '../../tools/warframe.php';
$session->is_auth();
?>
<?php if( isset($_GET['level']) and $_GET['level']): ?>
    <?php $level = implode(',', $_GET['level']); ?>
    <div class="col-md-6">
        <label>Отделы:</label>
        <select data-placeholder="Выбрать отделы" multiple="multiple" name="division[]" id="division" class="<?= $classes['form-multiselect'] ?>">
            <?php foreach($db->query("SELECT * from divisions WHERE branch_id = $session->branch AND level IN ($level)") as $row): ?>
                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label>Ответственное лицо:</label>
        <select data-placeholder="Выберите ответственное лицо" name="responsible_id" id="responsible_id" class="<?= $classes['form-select'] ?>" required>
            <?php foreach($db->query("SELECT * from users WHERE branch_id = $session->branch AND is_active IS NOT NULL AND user_level IN ($level)") as $row): ?>
                <option value="<?= $row['id'] ?>"><?= get_full_name($row['id']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
<?php endif; ?>
<script type="text/javascript">

    $('#division').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true
    });

</script>
