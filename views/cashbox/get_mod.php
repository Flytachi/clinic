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
                // Инвестиции
                $sql = "SELECT SUM(price) 'total_price' FROM investment WHERE user_id = $pk ";
                $invests = $db->query($sql)->fetch()['total_price'];

                // Время прёма
                $sql_1 = "SELECT add_date FROM visit WHERE user_id = $pk AND priced_date IS NULL AND grant_id=parent_id";
                $cost_time = $db->query($sql_1)->fetch()['add_date'];

                // Стоимость койки
                $sql_2 = "SELECT bdt.price FROM beds bd LEFT JOIN bed_type bdt ON(bdt.id=bd.types) WHERE bd.user_id = $pk";
                $cost_bed = $db->query($sql_2)->fetch()['price'];

                // Сумма койка -> день
                $cost_bed_time = $cost_bed * intval(date_diff(new \DateTime(), new \DateTime($cost_time))->days);

                // Стоимость услуг
                $sql_3 = "SELECT SUM(sc.price) 'cost' FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.user_id = $pk AND vs.priced_date IS NULL";
                $cost_service = $db->query($sql_3)->fetch()['cost'];

                // prit($invests);
                // prit($cost_time);
                // prit($cost_bed);
                // prit($cost_service);
                // prit($cost_bed_time);

                $total_cost -= $cost_service + $cost_bed_time;
                ?>
                <div class="form-group form-group-float">
                    <div class="form-group-feedback form-group-feedback-right">
                        <?php if (($invests + $total_cost) > 0): ?>
                            <input type="text" class="form-control border-success" value="<?= number_format($invests + $total_cost) ?>" disabled>
                        <?php elseif(($invests + $total_cost) < 0): ?>
                            <input type="text" class="form-control border-danger" value="<?= number_format($invests + $total_cost) ?>" disabled>
                        <?php else: ?>
                            <input type="text" class="form-control border-dark" value="<?= number_format($invests + $total_cost) ?>" disabled>
                        <?php endif; ?>
                    </div>
                </div>

                <?php InvestmentModel::form(); ?>

            </div>
        </div>
        <?php
    }else {
        ?>
        <div class="card">

            <div class="card-header header-elements-inline">
                <h5 class="card-title"><em><?= get_full_name($pk); ?></em></h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-blue">
                                <th class="text-left">Дата и время</th>
                                <th>Мед услуги</th>
                                <th class="text-right">Сумма</th>
                                <th class="text-center" style="width: 150px">Отменить</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($db->query("SELECT vs.id, vs.add_date, sc.name, sc.price FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = $pk AND vs.priced_date IS NULL") as $row) {
                                ?>
                                    <tr id="tr_VisitModel_<?= $row['id'] ?>">
                                        <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td class="text-right total_cost"><?= $row['price'] ?></td>
                                        <th class="text-center">
                                            <a onclick="Delete('<?= del_url($row['id'], 'VisitModel') ?>', 'tr_VisitModel_<?= $row['id'] ?>')" class="btn list-icons-item border-danger text-danger"><i class="icon-minus2"></i></a>
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
                        <button onclick="$('#total_price').val($('#total_title').text());$('#user_amb_id').val('<?= $pk ?>');" type="button" class="btn btn-outline-primary border-transparent legitRipple" data-toggle="modal" data-target="#modal_default">Оплата</button>
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
