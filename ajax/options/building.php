<?php require_once '../../tools/warframe.php'; ?>
<?php if(isset($_GET['division'])): ?>
    <label>Выбирите здание:</label>
    <select data-placeholder="Выбрать здание" id="building_id" class="<?= $classes['form-select'] ?>" required>
        <?php $sql = "SELECT g.id, g.name, COUNT(b.id) FROM buildings g JOIN wards w ON(w.building_id=g.id) JOIN beds b ON(b.ward_id=w.id) WHERE w.division_id = {$_GET['division']} AND b.user_id IS NULL GROUP BY g.id"; ?>
        <?php foreach ($db->query($sql) as $row): ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>