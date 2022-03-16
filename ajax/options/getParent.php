<?php require '../../tools/warframe.php'; ?>
<?php if( isset($_GET) ): ?>

    <?php if( isset($_GET['division']) ): ?>

        <label>Специалиста:</label>
        <select name="parent_id" class="<?= $classes['form-select'] ?>">
            <?php if(config('stationar_on_division')): ?>
                <option value="">Выбран весь отдел</option>
            <?php endif; ?>
            <?php foreach($db->query("SELECT * FROM users WHERE user_level = 5 AND is_active IS NOT NULL AND division_id = {$_GET['division']}") as $row): ?>
                <option value="<?= $row['id'] ?>"><?= get_full_name($row['id']) ?></option>
            <?php endforeach; ?>
        </select>

    <?php else: ?>
        <?php header("HTTP/1.0 400 Bad Request"); ?>
    <?php endif; ?>
    
<?php else: ?>
    <?php header("HTTP/1.0 400 Bad Request"); ?>
<?php endif; ?>