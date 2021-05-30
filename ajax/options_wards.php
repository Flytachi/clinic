<?php
require_once '../tools/warframe.php';
?>
<option></option>
<?php foreach ($db->query("SELECT w.*, (SELECT COUNT(*) FROM beds b WHERE b.ward_id=w.id) 'bed_qty' FROM wards w WHERE w.building_id = {$_GET['building_id']} AND w.floor = {$_GET['floor']}") as $row): ?>
    <?php if( config('wards_by_division') and isset($_GET['division_id']) ): ?>

        <?php if( $row['division_id'] == $_GET['division_id'] ): ?>
            <option value="<?= $row['id'] ?>" <?= ($row['bed_qty'] == 0) ? "disabled" : "" ?>><?= $row['ward'] ?></option>
        <?php endif; ?>
    
    <?php else: ?>
        <option value="<?= $row['id'] ?>" <?= ($row['bed_qty'] == 0) ? "disabled" : "" ?>><?= $row['ward'] ?></option>
    <?php endif; ?>
<?php endforeach; ?>