<?php require_once '../../tools/warframe.php'; ?>
<?php if( isset($_GET) ): ?>

    <?php if( isset($_GET['ward']) ): ?>

        <label>Выбирите койку:</label>
        <select data-placeholder="Выбрать койку" name="bed" id="bed" class="<?= $classes['form-select_price'] ?>" required>
            <?php $sql = "SELECT b.*, bt.price FROM beds b LEFT JOIN bed_types bt ON(b.type_id=bt.id) WHERE b.ward_id = {$_GET['ward']}"; ?>
            <?php foreach ($db->query($sql) as $row): ?>
                <?php if ($row['patient_id']): ?>
                    <option value="<?= $row['id'] ?>" data-name="<?= $row['types'] ?>" disabled><?= $row['bed'] ?> койка (<?= ($db->query("SELECT gender FROM patients WHERE id = {$row['patient_id']}")->fetchColumn()) ? "Male" : "Female" ?>)</option>
                <?php else: ?>
                    <option value="<?= $row['id'] ?>" data-name="<?= $row['types'] ?>"><?= $row['bed'] ?> койка</option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

    <?php elseif( isset($_GET['division']) and isset($_GET['building']) and isset($_GET['floor']) ): ?>

        <label>Выбирите палату:</label>
        <select data-placeholder="Выбрать палату" id="ward_id" class="<?= $classes['form-select'] ?>" required>
            <?php $sql = "SELECT w.id, w.ward, COUNT(b.id) FROM wards w JOIN beds b ON(b.ward_id=w.id) WHERE w.building_id = {$_GET['building']} AND w.division_id = {$_GET['division']} AND b.floor = {$_GET['floor']} AND b.patient_id IS NULL GROUP BY w.id"; ?>
            <?php foreach ($db->query($sql) as $row): ?>
                <option value="<?= $row['id'] ?>"><?= $row['ward'] ?> палата</option>
            <?php endforeach; ?>
        </select>
    
    <?php elseif( isset($_GET['division']) and isset($_GET['building']) ): ?>

        <label>Выбирите этаж:</label>
        <select data-placeholder="Выбрать этаж" id="floor" class="<?= $classes['form-select'] ?>" required>
            <?php $sql = "SELECT b.floor, COUNT(b.id) FROM wards w JOIN beds b ON(b.ward_id=w.id) WHERE w.building_id = {$_GET['building']} AND w.division_id = {$_GET['division']} AND b.patient_id IS NULL GROUP BY b.floor"; ?>
            <?php foreach ($db->query($sql) as $row): ?>
                <option value="<?= $row['floor'] ?>"><?= $row['floor'] ?> этаж</option>
            <?php endforeach; ?>
        </select>

    <?php elseif( isset($_GET['division']) ): ?>

        <label>Выбирите здание:</label>
        <select data-placeholder="Выбрать здание" id="building_id" class="<?= $classes['form-select'] ?>" required>
            <?php $sql = "SELECT g.id, g.name, COUNT(b.id) FROM buildings g JOIN wards w ON(w.building_id=g.id) JOIN beds b ON(b.ward_id=w.id) WHERE w.division_id = {$_GET['division']} AND b.patient_id IS NULL GROUP BY g.id"; ?>
            <?php foreach ($db->query($sql) as $row): ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php endforeach; ?>
        </select>

    <?php else: ?>
        <?php header("HTTP/1.0 400 Bad Request"); ?>
    <?php endif; ?>
    
<?php else: ?>
    <?php header("HTTP/1.0 400 Bad Request"); ?>
<?php endif; ?>