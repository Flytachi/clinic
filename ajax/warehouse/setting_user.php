<?php
require_once '../../tools/warframe.php';
$session->is_auth();
?>
<?php if($_POST['level'] and $_POST['division']): ?>
    <div class="form-group">
        <label>Пользователь</label>
        <select data-placeholder="Выбрать пользователя" name="permission[responsible_id]" required class="<?= $classes['form-select'] ?>">
            <option></option>
            <?php foreach($db->query("SELECT * from users WHERE user_level = {$_POST['level']} AND division_id IN (". implode(',', $_POST['division']) .")") as $row): ?>
                <option value="<?= $row['id'] ?>"><?= get_full_name($row['id']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
<?php endif; ?>