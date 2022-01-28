<?php require_once '../../tools/warframe.php'; ?>
<?php if(isset($_GET['building']) and isset($_GET['division']) and isset($_GET['floor'])): ?>
    <label>Выбирите палату:</label>
    <select data-placeholder="Выбрать палату" id="ward_id" class="<?= $classes['form-select'] ?>" required>
        <?php $sql = "SELECT w.id, w.ward, COUNT(b.id) FROM wards w JOIN beds b ON(b.ward_id=w.id) WHERE w.building_id = {$_GET['building']} AND w.division_id = {$_GET['division']} AND b.floor = {$_GET['floor']} AND b.user_id IS NULL GROUP BY w.id"; ?>
        <?php foreach ($db->query($sql) as $row): ?>
            <option value="<?= $row['id'] ?>"><?= $row['ward'] ?> этаж</option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>