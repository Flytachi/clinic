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
                $sql = "SELECT
                            SUM(iv.price) 'investment',
                            ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), vs.add_date), '%H') / 24) * bdt.price 'cost_bed',
                            (SELECT SUM(sc.price) 'cost' FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.user_id = $pk AND vs.priced_date IS NULL) 'cost_service'
                            -- bdt.price 'bed_price',
                            -- vs.add_date
                        FROM users us
                            LEFT JOIN investment iv ON(iv.user_id = us.id)
                            LEFT JOIN beds bd ON(bd.user_id = us.id)
                            LEFT JOIN bed_type bdt ON(bdt.id = bd.types)
                            LEFT JOIN visit vs ON(vs.user_id = us.id AND vs.grant_id = vs.parent_id)
                        WHERE us.id = $pk";
                $price = $db->query($sql)->fetch();

                prit($price);
                // parad("Инвестиции",$price['investment']);
                // parad("Стоимость кровати",$price['cost_bed']);
                // parad("Стоимость услуг",$price['cost_service']);

                $price_cost -= $price['cost_service'] + $price['cost_bed'];
                ?>
                <div class="form-group form-group-float">
                    <div class="form-group-feedback form-group-feedback-right">
                        <?php if (($invests + $total_cost) > 0): ?>
                            <input type="text" class="form-control border-success" value="<?= number_format($price['investment'] + $price_cost) ?>" disabled>
                        <?php elseif(($invests + $total_cost) < 0): ?>
                            <input type="text" class="form-control border-danger" value="<?= number_format($price['investment'] + $price_cost) ?>" disabled>
                        <?php else: ?>
                            <input type="text" class="form-control border-dark" value="<?= number_format($price['investment'] + $price_cost) ?>" disabled>
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
