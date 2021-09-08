<?php
require_once '../../tools/warframe.php';
$session->is_auth();
?>

<?php if( isset($_GET['search']) and $_GET['search'] ): ?>
    <?php $search = Mixin\clean($_GET['search']); ?>
    <?php foreach ($db->query("SELECT * FROM international_classification_diseases WHERE ( LOWER(code) LIKE LOWER('%$search%') ) OR ( LOWER(decryption) LIKE LOWER('%$search%') ) LIMIT 10") as $row): ?>
        <tr><td><b><?= $row['code'] ?> - </b> <?= $row['decryption'] ?></td></tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr class="table-secondary text-center"><td>Нет данных</td></tr>
<?php endif; ?>

