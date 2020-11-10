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
                            <th class="text-center">Отменить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($db->query("SELECT * FROM user_service WHERE user_id = $pk AND deleted IS NULL") as $row) {
                            $service = $db->query('SELECT * FROM service WHERE id='.$row['service_id'])->fetch();
                            if(isset($total_price)){
                                $total_price = $service['price'];
                            }else{
                                $total_price += $service['price'];
                            }
                            ?>
                                <tr>
                                    <td><?= date("d/m/Y H:i"); ?></td>
                                    <td><?= $service['name'] ?></td>
                                    <td><?= $service['price'] ?></td>
                                    <th class="text-center">
                                        <div class="list-icons">
                                            <a href="<?= up_url($row['id'], 'UserServiceForm') ?>" class="list-icons-item btn border-danger-600 text-danger-600"><i class="icon-minus2"></i></a>
                                        </div>
                                    </th>
                                </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
                <br>
                <div class="text-right">
                    <button onclick="$('#total_price').val(this.dataset.price);$('#user_amb_id').val(this.dataset.pk);" type="button" class="btn btn-outline-primary border-transparent legitRipple" data-toggle="modal" data-pk="<?= $pk ?>" data-price="<?= $total_price ?>" data-target="#modal_default">Оплата (<?= $total_price ?>)</button>
                </div>
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
