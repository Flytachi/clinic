<?php
require_once '../../tools/warframe.php';
$session->is_auth();
?>
<?php if( isset($_GET['level']) and $_GET['level']): ?>
    <?php $level = implode(',', $_GET['level']); ?>
    <div class="col-md-6">
        <label>Отделы:</label>
        <select data-placeholder="Выбрать отделы" multiple="multiple" name="division[]" id="division" class="<?= $classes['form-multiselect'] ?>">
            <?php if($level == 7): ?>
                <?php $sql = "SELECT * from divisions WHERE level IN (5)"; ?>
            <?php else: ?>
                <?php $sql = "SELECT * from divisions WHERE level IN ($level)"; ?>
            <?php endif; ?>

            <?php foreach($db->query($sql) as $row): ?>
                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label>Ответственное лицо:</label>
        <select data-placeholder="Выберите ответственное лицо" name="parent_id" id="parent_id" class="<?= $classes['form-select'] ?>" required>
            <?php foreach($db->query("SELECT * from users WHERE is_active IS NOT NULL AND user_level IN ($level)") as $row): ?>
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
