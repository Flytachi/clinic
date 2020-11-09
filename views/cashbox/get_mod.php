<?php
require_once '../../tools/warframe.php';
is_auth(3);
if ($_GET['pk']) {
    $pk = $_GET['pk'];
    ?>
    <div class="card">

        <div class="card-header header-elements-inline">
            <h5 class="card-title"><b><?= get_full_name($pk); ?></b></h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="bg-blue">
                            <th>Дата и время</th>
                            <th>Мед услуги</th>
                            <th>Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($db->query("SELECT * FROM user_service WHERE user_id = $pk AND deleted IS NULL") as $row) {
                            $service = $db->query('SELECT * FROM service WHERE id='.$row['service_id'])->fetch();
                            ?>
                                <tr>
                                    <td></td>
                                    <td><?= $service['name'] ?></td>
                                    <td><?= $service['price'] ?></td>
                                </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple" data-toggle="modal" data-target="#modal_default">Оплата</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <?php
}else {
    ?>
    <div class="alert bg-danger alert-styled-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        <span class="font-weight-semibold">Нет данных!</span>
    </div>
    <?php
}
?>
