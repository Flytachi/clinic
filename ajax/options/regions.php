<?php require_once '../../tools/warframe.php'; ?>
<?php if(isset($_GET['province'])): ?>
    <label>Регионы:</label>
    <select class="form-control" data-placeholder="Выбрать регион" name="region_id[]" multiple="multiple">
        <?php foreach ($db->query("SELECT DISTINCT region_id, region FROM users WHERE user_level = 15 AND province_id IN(".implode(",", $_GET['province']) .")") as $row): ?>
            <option value="<?= $row['region_id'] ?>" <?= ( isset($_GET['region_id']) and in_array($row['region_id'], $_GET['region_id'])) ? "selected" : "" ?>><?= $row['region'] ?></option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>