<?php
require_once '../../tools/warframe.php';
$session->is_auth();
?>
<?php if($_POST['level']): ?>
    <?php if($_POST['level'] == 7) $_POST['level'] = 5; ?>
    <div class="form-group">
        <label>Отделы</label>
        <select data-placeholder="Выбрать отдел" multiple="multiple" name="permission[division][]" required class="settin <?= $classes['form-multiselect'] ?>" onchange="ChangeDivision(this)">
            <?php foreach($db->query("SELECT * from divisions WHERE level = {$_POST['level']}") as $row): ?>
                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
<?php endif; ?>