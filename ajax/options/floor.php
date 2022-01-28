<?php require_once '../../tools/warframe.php'; ?>
<?php if(isset($_GET['building']) and isset($_GET['division'])): ?>
    <label>Выбирите этаж:</label>
    <select data-placeholder="Выбрать этаж" id="floor" class="<?= $classes['form-select'] ?>" required>
        <?php $sql = "SELECT b.floor, COUNT(b.id) FROM wards w JOIN beds b ON(b.ward_id=w.id) WHERE w.building_id = {$_GET['building']} AND w.division_id = {$_GET['division']} AND b.user_id IS NULL GROUP BY b.floor"; ?>
        <?php foreach ($db->query($sql) as $row): ?>
            <option value="<?= $row['floor'] ?>"><?= $row['floor'] ?> этаж</option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>