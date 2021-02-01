<?php
require_once '../../tools/warframe.php';
is_auth();

if ($_GET['items']) {
    $docs = $db->query("SELECT * FROM users WHERE id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
}else {
    $docs = $db->query("SELECT vs.user_id, vs.parent_id, vs.service_id, us.dateBith, vs.completed FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
}
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <body>

        <div class="row">

            <div class="col-6">
                <img src="<?= img('prints/icon/company.png') ?>" width="400" height="120">
            </div>

            <div class="col-6 text-right h3">
                <b>
                    Медицинский оздоровительный комплекс<br>
                    г.Бухара, ул. М.Икбол, ( )<br>
                    Тел: (+998945487701)<br>
                </b>
            </div>

        </div>

        <div class="my_hr-1"></div>
        <div class="my_hr-2"></div>

        <div class="text-left">
            <div class="h3">
                <?php if ($_GET['items']): ?>
                    <b>Ф.И.О.: </b><?= get_full_name($docs->id) ?><br>
                    <b>ID Пациента: </b><?= addZero($docs->id) ?><br>
                    <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->dateBith)) ?><br>
                <?php else: ?>
                    <b>Ф.И.О.: </b><?= get_full_name($docs->user_id) ?><br>
                    <b>ID Пациента: </b><?= addZero($docs->user_id) ?><br>
                    <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->dateBith)) ?><br>
                    <b>Дата исследования: </b><?= date('d.m.Y H:i', strtotime($docs->completed)) ?><br>
                <?php endif; ?>
            </div>

            <?php if ($_GET['items']): ?>

                <?php foreach (json_decode($_GET['items']) as $item): ?>
                    <h1 class="text-center"><b><?= $db->query("SELECT sc.name FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.id=$item")->fetch()['name'] ?></b></h1>

                    <div class="table-responsive card">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th style="width:3%">№</th>
                                    <th class="text-left">Анализ</th>
                                    <th class="text-right" style="width:10%">Ед</th>
                                    <th class="text-right" style="width:15%">Результат</th>
                                    <th class="text-right" style="width:15%">Норма</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $norm = "lat.name, lat.code, lat.standart_type, lat.standart_fun,
                                            lat.standart_min, lat.standart_sign, lat.standart_max,
                                            lat.standart_sex0_min, lat.standart_sex0_sign, lat.standart_sex0_max,
                                            lat.standart_sex1_min, lat.standart_sex1_sign, lat.standart_sex1_max";
                                $sql = "SELECT la.id, la.result, la.deviation, $norm, lat.unit FROM laboratory_analyze la LEFT JOIN laboratory_analyze_type lat ON (la.analyze_id = lat.id) WHERE la.visit_id = $item";
                                foreach ($db->query($sql) as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td class="text-left"><?= $row['name'] ?></td>
                                        <td class="text-right"><?= $row['unit'] ?></td>
                                        <td class="text-right"><?= $row['result'] ?></td>
                                        <td class="text-right">
                                            <?php
                                            switch ($row['standart_type']) {
                                                case 1:
                                                    echo $row['standart_min']." ".$row['standart_sign']." ".$row['standart_max'];
                                                    break;
                                                case 2:
                                                    if ($row['standart_fun'] == 2) {
                                                        echo "Положительный (+)";
                                                    }else {
                                                        echo "Отрицательный (-)";
                                                    };
                                                    break;
                                                case 3:
                                                    if ($pat['gender']) {
                                                        echo "Муж (".$row['standart_sex1_min']." ".$row['standart_sex1_sign']." ".$row['standart_sex1_max'].")";
                                                    }else {
                                                        echo "Жен (".$row['standart_sex0_min']." ".$row['standart_sex0_sign']." ".$row['standart_sex0_max'].") <br>";
                                                    }
                                                    break;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>

                <h1 class="text-center"><b><?= $db->query("SELECT name FROM service WHERE id={$docs->service_id}")->fetch()['name'] ?></b></h1>

                <div class="table-responsive card">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th style="width:3%">№</th>
                                <th class="text-left">Анализ</th>
                                <th class="text-right" style="width:10%">Ед</th>
                                <th class="text-right" style="width:15%">Результат</th>
                                <th class="text-right" style="width:15%">Норма</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $norm = "lat.name, lat.code, lat.standart_type, lat.standart_fun,
                                        lat.standart_min, lat.standart_sign, lat.standart_max,
                                        lat.standart_sex0_min, lat.standart_sex0_sign, lat.standart_sex0_max,
                                        lat.standart_sex1_min, lat.standart_sex1_sign, lat.standart_sex1_max";
                            $sql = "SELECT la.id, la.result, la.deviation, $norm, lat.unit FROM laboratory_analyze la LEFT JOIN laboratory_analyze_type lat ON (la.analyze_id = lat.id) WHERE la.visit_id = {$_GET['id']}";
                            foreach ($db->query($sql) as $row) {
                                ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td class="text-left"><?= $row['name'] ?></td>
                                    <td class="text-right"><?= $row['unit'] ?></td>
                                    <td class="text-right"><?= $row['result'] ?></td>
                                    <td class="text-right">
                                        <?php
                                        switch ($row['standart_type']) {
                                            case 1:
                                                echo $row['standart_min']." ".$row['standart_sign']." ".$row['standart_max'];
                                                break;
                                            case 2:
                                                if ($row['standart_fun'] == 2) {
                                                    echo "Положительный (+)";
                                                }else {
                                                    echo "Отрицательный (-)";
                                                };
                                                break;
                                            case 3:
                                                if ($pat['gender']) {
                                                    echo "Муж (".$row['standart_sex1_min']." ".$row['standart_sex1_sign']." ".$row['standart_sex1_max'].")";
                                                }else {
                                                    echo "Жен (".$row['standart_sex0_min']." ".$row['standart_sex0_sign']." ".$row['standart_sex0_max'].") <br>";
                                                }
                                                break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        </div>

    </body>
</html>
