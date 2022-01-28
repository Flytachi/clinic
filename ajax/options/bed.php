<?php require_once '../../tools/warframe.php'; ?>
<?php if(isset($_GET['ward'])): ?>
    <label>Выбирите палату:</label>
    <select data-placeholder="Выбрать койку" name="bed" id="bed" class="<?= $classes['form-select_price'] ?>" required>
        <?php $sql = "SELECT b.*, bt.price FROM beds b LEFT JOIN bed_types bt ON(b.type_id=bt.id) WHERE b.ward_id = {$_GET['ward']}"; ?>
        <?php foreach ($db->query($sql) as $row): ?>
            <?php if ($row['user_id']): ?>
                <option value="<?= $row['id'] ?>" data-name="<?= $row['types'] ?>" disabled><?= $row['bed'] ?> койка (<?= ($db->query("SELECT gender FROM users WHERE id = {$row['user_id']}")->fetchColumn()) ? "Male" : "Female" ?>)</option>
            <?php else: ?>
                <option value="<?= $row['id'] ?>" data-name="<?= $row['types'] ?>"><?= $row['bed'] ?> койка</option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
<?php endif; ?>