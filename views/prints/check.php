<?php
require_once '../../tools/warframe.php';
is_auth();
?>
<!DOCTYPE html>
<html lang="en">

    <?php include '../layout/head.php' ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <body onload="window.print();" style="weight: 4cm; font-size: 10px; font-family: arial;">

        <div class="my_hr-1"></div>

        <div class="container-fluid">
            <div class="row">
                <?php foreach ($db->query("SELECT vs.id, vs.parent_id, vs.add_date, sc.name, sc.price FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = {$_GET['id']} AND vs.priced_date IS NULL") as $row): ?>
                    <span class="text-left">
                        <b><?= $row['name'] ?></b>
                    </span>
                    <span class="text-right">
                        <?= $row['price'] ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>


    </body>
</html>
