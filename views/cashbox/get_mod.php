<?php
require_once '../../tools/warframe.php';
is_auth(3);
if ($_GET['pk']) {
    $pk = $_GET['pk'];
    if($_GET['mod']){
        ?>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><em><?= get_full_name($pk) ?></em></h5>
                <div class="header-elements">
                    <div class="list-icons">

                    </div>
                </div>
            </div>

            <div class="card-body">

                <?php
                foreach($db->query("SELECT * FROM visit_price WHERE visit_id = $pk") as $row) {
                    if(empty($total_price_payment)){
                        $total_price_payment = $row['price_payment'];
                    }else{
                        $total_price_payment += $row['price_payment'];
                    }
                }
                ?>
                <div class="form-group form-group-float">
                    <div class="form-group-feedback form-group-feedback-right">
                        <input type="text" class="form-control border-success" value="<?= number_format($total_price_payment) ?>" disabled>
                    </div>
                </div>

                <?php UserCheckStationaryModel::form(); ?>

            </div>
        </div>
        <?php
    }else {
        ?>
        <div class="card">

            <div class="card-header header-elements-inline">
                <h5 class="card-title"><em><?= get_full_name($_GET['user_id']); ?></em></h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-blue">
                                <th>Мед услуги</th>
                                <th class="text-right">Сумма</th>
                                <th class="text-center" style="width: 150px">Отменить</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($db->query("SELECT * FROM visit_service WHERE visit_id = $pk AND priced IS NULL") as $row) {
                                $service = $db->query('SELECT * FROM service WHERE id='.$row['service_id'])->fetch();
                                ?>
                                    <tr id="tr_UserServiceForm_<?= $row['id'] ?>">
                                        <td><?= $service['name'] ?></td>
                                        <td class="text-right total_cost"><?= $service['price'] ?></td>
                                        <th class="text-center">
                                            <div class="list-icons">
                                                <button onclick="Update('<?= up_url($row['id'], 'UserServiceForm') ?>', 'tr_UserServiceForm_<?= $row['id'] ?>')" class="btn border-danger-600 text-danger-600"><i class="icon-minus2"></i></button>
                                            </div>
                                        </th>
                                    </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                    <br>
                    <div class="text-left">
                        <strong>Итого: </strong><strong id="total_title"></strong>
                    </div>
                    <div class="text-right">
                        <button onclick="$('#total_price').val($('#total_title').text());$('#visit_amb_id').val(this.dataset.pk);" type="button" class="btn btn-outline-primary border-transparent legitRipple" data-toggle="modal" data-pk="<?= $pk ?>" data-target="#modal_default">Оплата</button>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }
}else {
    ?>
    <div class="alert bg-danger alert-styled-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        <span class="font-weight-semibold">Нет данных!</span>
    </div>
    <?php
}
?>
