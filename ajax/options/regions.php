<?php require_once '../../tools/warframe.php'; ?>

<label>Регионы:</label>
<select class="form-control" data-placeholder="Выбрать регион" name="region_id[]" multiple="multiple">
    <?php if(isset($_GET['province'])): ?>
        <?php foreach ($db->query("SELECT * FROM region WHERE province_id IN(".implode(",", $_GET['province']) .")") as $row): ?>
            <option value="<?= $row['id'] ?>" <?= ( isset($_GET['region_id']) and in_array($row['id'], $_GET['region_id'])) ? "selected" : "" ?>><?= $row['name'] ?></option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>