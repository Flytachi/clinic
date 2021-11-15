<?php
require_once '../../tools/warframe.php';
?>
<option></option>
<?php foreach ($db->query("SELECT * FROM wards WHERE building_id = {$_GET['building_id']} AND floor = {$_GET['floor']}") as $row): ?>
    <option value="<?= $row['id'] ?>"><?= $row['ward'] ?></option>
<?php endforeach; ?>