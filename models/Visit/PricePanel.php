<?php

class PricePanel extends Model
{
    public $table = 'visits';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);

            if ($object['direction']) {
                if ($_GET['form'] != "form") {
                    return $this->{$_GET['form']}($object['id']);
                } else {
                    return $this->FirstPanel($object['id']);
                }
            } else {
                if (!(isset($_GET['refund']) and $_GET['refund'])) {
                    return $this->SecondPanel($object['id']);
                } else {
                    return $this->ThirdPanel($object['id']);
                }
            }

        }else{
            Mixin\error('cash_permissions_false');
        }

    }

    public function FirstPanel($pk = null)
    {
        global $db, $classes;
        $vps = (new VisitModel)->price_status($pk);
        ?>
        <div class="card border-1 border-dark">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b><?= addZero($this->value('user_id')) ?> - <em><?= get_full_name($this->value('user_id')) ?></em></b></h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a href="<?= viv('card/content-2')."?pk=$pk" ?>" class="<?= $classes['btn-render'] ?>">Перейти к визиту № <?= $pk ?></a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-calculator3 mr-2"></i>Информация
                </legend>

                <table class="table table-hover">
                    <tbody>
                        <tr class="table-secondary">
                            <td>Баланс</td>
                            <td class="text-right text-<?= number_color($vps['balance']) ?>"><?= number_format($vps['balance']) ?></td>
                        </tr>
                        <tr class="table-secondary">
                            <td>Сумма к оплате</td>
                            <td class="text-right text-<?= number_color(-$vps['total_cost'], true) ?>"><?= number_format(-$vps['total_cost']) ?></td>
                        </tr>
                        <tr class="table-secondary">
                            <td>Скидка</td>
                            <td class="text-right text-dark"><?= number_format($vps['sale-total']) ?></td>
                        </tr>
                        <?php /*if(module('module_pharmacy')): ?>
                            <tr class="table-secondary">
                                <td>Сумма к оплате(лекарства)</td>
                                <td class="text-right text-danger"><?= number_format(round($price['cost_item_2'])) ?></td>
                            </tr>
                        <?php endif;*/ ?>
                        <tr class="table-secondary">
                            <td>Разница</td>
                            <td class="text-right text-<?= number_color($vps['result']) ?>"><?= number_format($vps['result']) ?></td>
                        </tr>
                        <input type="hidden" id="prot_item" value="<?= 0//$price['balance'] + $price_cost ?>">
                    </tbody>
                </table>

                <div class="text-right mt-3">

                    <?php (new VisitPricesModel)->form_button($pk, $vps) ?>

                </div>

                <div id="detail_div"></div>

            </div>
        </div>
        <?php
    }

    public function SecondPanel($pk = null)
    {
        global $db, $classes;
        ?>
        <div class="card border-1 border-dark" id="card_info">

            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b><?= addZero($this->value('user_id')) ?> - <em><?= get_full_name($this->value('user_id')) ?></em></b></h5>
            </div>

            <div class="card-body">

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-bag mr-2"></i>Услуги
                </legend>

                <div class="table-responsive card">
                    <table class="table table-hover table-sm">
                        <thead class="<?= $classes['table_detail-thead'] ?>">
                            <tr>
                                <th class="text-left">Дата назначения</th>
                                <th>Мед услуги</th>
                                <th class="text-right">Сумма</th>
                                <th class="text-center" style="width: 150px">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db->query("SELECT vss.id, vss.parent_id, vss.add_date, vss.service_name, vp.item_cost FROM visit_services vss LEFT JOIN visit_prices vp ON(vp.visit_service_id=vss.id) WHERE vss.visit_id = $pk AND vss.status = 1") as $row): ?>
                                <tr id="tr_VisitServicesModel_<?= $row['id'] ?>">
                                    <input type="hidden" class="parent_class" value="<?= $row['parent_id'] ?>">
                                    <input type="hidden" class="prices_class" value="<?= $row['id'] ?>">
                                    <td><?= date($row['add_date'], 1) ?></td>
                                    <td><?= $row['service_name'] ?></td>
                                    <td class="text-right total_cost"><?= $row['item_cost'] ?></td>
                                    <th class="text-center">
                                        <div class="list-icons">
                                            <button onclick="Delete('<?= del_url($row['id'], 'VisitServicesModel') ?>', 'tr_VisitServicesModel_<?= $row['id'] ?>')" class="btn btn-outline-danger btn-sm"><i class="icon-minus2"></i></button>
                                        </div>
                                    </th>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-left">
                    <strong>Итого: </strong><strong id="total_title"></strong>
                </div>
                <div class="text-right">
                    <button onclick="CardFuncCheck('<?= $pk ?>')" type="button" class="<?= $classes['btn-price'] ?>" data-toggle="modal" data-target="#modal_default">Оплата</button>
                </div>

            </div>

            </div>
            <script type="text/javascript">

                function CardFuncCheck(pk) {
                    var array_services = [];

                    Array.prototype.slice.call(document.querySelectorAll('.prices_class')).forEach(function(item) {
                        array_services.push(item.value);
                    });

                    $.ajax({
                        type: "GET",
                        url: "<?= up_url(null, 'VisitPricesModel') ?>",
                        data: {
                            visit_pk: pk,
                            service_pks: array_services,
                        },
                        success: function (result) {
                            $("#form_card").html(result);
                            Swit.init();
                        },
                    });
                }

                function Delete(events, tr) {
                    swal({
                        position: 'top',
                        title: 'Вы уверены что хотоите отменить услугу?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: "Да"
                    }).then(function(ivi) {
                        if (ivi.value) {
                            $.ajax({
                                type: "GET",
                                url: events,
                                success: function (result) {
                                    var data = JSON.parse(result);

                                    if (data.status == "success") {
                                        if (data.count == 0) {
                                            $('#check_div').html("");
                                            $('#VisitIDPrice_'+data.visit_pk).css("background-color", "red");
                                            $('#VisitIDPrice_'+data.visit_pk).css("color", "white");
                                            $('#VisitIDPrice_'+data.visit_pk).fadeOut('slow', function() {
                                                $(this).remove();
                                            });
                                        }else{
                                            $('#'+tr).css("background-color", "red");
                                            $('#'+tr).css("color", "white");
                                            $('#'+tr).fadeOut('slow', function() {
                                                $(this).remove();
                                                sumTo($('.total_cost'));
                                            });
                                        }
                                        new Noty({
                                            text: data.message,
                                            type: 'success'
                                        }).show();
                                        
                                    }else {

                                        new Noty({
                                            text: data.message,
                                            type: 'error'
                                        }).show();
                                        
                                    }
                                },
                            });
                        }
                    });
                };

            </script>
        <?php
    }

    public function ThirdPanel($pk = null)
    {
        global $db, $classes;
        ?>
        <div class="card border-1 border-dark" id="card_info">

            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b><?= addZero($this->value('user_id')) ?> - <em><?= get_full_name($this->value('user_id')) ?></em></b></h5>
            </div>

            <div class="card-body">

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-bag mr-2"></i>Услуги
                </legend>

                <div class="table-responsive card">
                    <table class="table table-hover table-sm">
                        <thead class="<?= $classes['table_detail-thead'] ?>">
                            <tr>
                                <th class="text-left">Дата назначения</th>
                                <th>Мед услуги</th>
                                <th class="text-right">Сумма</th>
                                <th class="text-center" style="width: 150px">Дата оплаты</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db->query("SELECT vss.id, vss.parent_id, vss.add_date, vss.service_name, (vp.price_cash + vp.price_card + vp.price_transfer) 'item_cost', vp.price_date FROM visit_services vss LEFT JOIN visit_prices vp ON(vp.visit_service_id=vss.id) WHERE vss.visit_id = $pk AND vss.status = 5") as $row): ?>
                                <tr id="tr_VisitServicesModel_<?= $row['id'] ?>">
                                    <input type="hidden" class="prices_class" value="<?= $row['id'] ?>">
                                    <td><?= date_f($row['add_date'], 1) ?></td>
                                    <td><?= $row['service_name'] ?></td>
                                    <td class="text-right total_cost"><?= $row['item_cost'] ?></td>
                                    <td><?= date_f($row['price_date'], 1) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-left">
                    <strong>Итого: </strong><strong id="total_title"></strong>
                </div>
                <div class="text-right">
                    <button onclick="CardFuncCheck('<?= $pk ?>')" type="button" class="<?= $classes['btn-price'] ?>" data-toggle="modal" data-target="#modal_default">Оплата</button>
                </div>

            </div>

        </div>
        <script type="text/javascript">
            function CardFuncCheck(pk) {
                var array_services = [];

                Array.prototype.slice.call(document.querySelectorAll('.prices_class')).forEach(function(item) {
                    array_services.push(item.value);
                });

                $.ajax({
                    type: "GET",
                    url: "<?= up_url(null, 'VisitPricesModel') ?>",
                    data: {
                        visit_pk: pk,
                        refund: 1,
                        service_pks: array_services,
                    },
                    success: function (result) {
                        $("#form_card").html(result);
                        Swit.init();
                    },
                });
            }
        </script>
        <?php
    }

    public function DetailPanel($pk = null)
    {
        ?>
        <legend class="font-weight-semibold text-uppercase font-size-sm">
            <i class="icon-cogs mr-2"></i>Детально
            <a class="float-right text-dark mr-1" onclick="printdiv('check_detail')">
                <i class="icon-printer2"></i>
            </a>
        </legend>

        <ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
            <li class="nav-item"><a onclick="DetailControl('<?= up_url($pk, 'PricePanel', 'DetailPanelInvestments') ?>')" href="#" class="nav-link legitRipple active show" data-toggle="tab">Инвестиции</a></li>
            <li class="nav-item"><a onclick="DetailControl('<?= up_url($pk, 'PricePanel', 'DetailPanelServices') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Услуги</a></li>
            <?php if(module('module_pharmacy')): ?>
                <li class="nav-item"><a onclick="DetailControl('<?= up_url($pk, 'PricePanel', 'DetailPanelPharm') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Лекарства</a></li>
            <?php endif; ?>
            <li class="nav-item"><a onclick="DetailControl('<?= up_url($pk, 'PricePanel', 'DetailPanelTotal') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Итог</a></li>
        </ul>

        <div class="table-responsive" id="div_show_detail">
            <script>
                $(document).ready(function(){
                    DetailControl('<?= up_url($pk, 'PricePanel', 'DetailPanelInvestments') ?>');
                });
            </script>
        </div>

        <script type="text/javascript">
            function DetailControl(params) {
                $.ajax({
                    type: "POST",
                    url: params,	
                    success: function (result) {
                        $('#div_show_detail').html(result);
                    },
                });
            }
        </script>
        <?php
    }

    public function DetailPanelInvestments($pk = null)
    {
        global $db, $classes;
        $tb = new Table($db, "visit_investments");
        $tb->where("visit_id = $pk")->order_by("add_date ASC");
        $tbc_cash = $tbc_card = $tbc_transfer = 0;
        ?>
        <div class="table-responsive mt-3 card" id="check_detail">
            <table class="table table-hover table-sm">
                <thead class="<?= $classes['table_detail-thead'] ?> text-right">
                    <tr>
                        <th class="text-left">Дата и время</th>
                        <th>Наличные</th>
                        <th>Пластик</th>
                        <th>Перечисление</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tb->get_table(1) as $row): ?>
                        <tr class="text-right">
                            <td class="text-left">  
                                <?php if($row->expense): ?>
                                    <span class="badge bg-danger">Used</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Not used</span>
                                <?php endif; ?>
                                <?= date_f($row->add_date, 1) ?>
                            </td>
                            <td class="text-<?= number_color($row->balance_cash) ?>"><?php $tbc_cash += $row->balance_cash; echo number_format($row->balance_cash); ?></td>
                            <td class="text-<?= number_color($row->balance_card) ?>"><?php $tbc_card += $row->balance_card; echo number_format($row->balance_card); ?></td>
                            <td class="text-<?= number_color($row->balance_transfer) ?>"><?php $tbc_transfer += $row->balance_transfer; echo number_format($row->balance_transfer); ?></td>
                            <td class="text-<?= number_color($row->balance_cash + $row->balance_card + $row->balance_transfer) ?>"><?= number_format($row->balance_cash + $row->balance_card + $row->balance_transfer) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(isset($row->count)): ?>
                        <tr class="<?= $classes['table_detail-count_menu'] ?>">
                            <th class="text-left">Всего: <?= $row->count ?></th>
                            <th class="text-right"><?= number_format($tbc_cash) ?></th>
                            <th class="text-right"><?= number_format($tbc_card) ?></th>
                            <th class="text-right"><?= number_format($tbc_transfer) ?></th>
                            <th class="text-right"><?= number_format($tbc_cash + $tbc_card +$tbc_transfer) ?></th>
                        </tr>
                    <?php else: ?>
                        <tr class="table-secondary">
                            <th colspan="5" class="text-center">Нет данных</th>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function DetailPanelServices($pk = null)
    {
        global $db, $classes;
        $tb = new Table($db, "visit_prices");
        $tb->set_data("DISTINCT item_id, item_name, item_cost")->where("visit_id = $pk AND item_type IN (1,3)")->order_by("item_name ASC");
        $tpc = $tqy = 0;
        ?>
        <div class="table-responsive mt-3 card" id="check_detail">
            <table class="table table-hover table-sm">
                <thead class="<?= $classes['table_detail-thead'] ?> text-right">
                    <tr>
                        <th class="text-left">Услуга</th>
                        <th>Цена(ед)</th>
                        <th class="text-center">Кол-во</th>
                        <th>Стоимость</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tb->get_table(1) as $row): ?>
                        <tr class="text-right">
                            <td class="text-left">
                                <?= $row->item_name ?>
                            </td>
                            <td><?= number_format($row->item_cost); ?></td>
                            <td class="text-center"><?php $tqy += $row->qty = $db->query("SELECT * FROM visit_prices WHERE visit_id = $pk AND item_id = $row->item_id AND item_cost = $row->item_cost")->rowCount(); echo $row->qty; ?></td>
                            <td class="text-<?= number_color($row->qty * $row->item_cost, true) ?>"><?php $tpc += $row->qty * $row->item_cost; echo number_format($row->qty * $row->item_cost); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(isset($row->count)): ?>
                        <tr class="<?= $classes['table_detail-count_menu'] ?>">
                            <th class="text-left" colspan="2"></th>
                            <th class="text-center"><?= number_format($tqy) ?></th>
                            <th class="text-right"><?= number_format($tpc) ?></th>
                        </tr>
                    <?php else: ?>
                        <tr class="table-secondary">
                            <th colspan="5" class="text-center">Нет данных</th>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function DetailPanelTotal($pk = null)
    {
        global $db, $classes;
        $vps = (new VisitModel)->price_status($pk);
        $tb = new Table($db, "visit_beds");
        $tb->set_data("location, type, cost, ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(end_date, CURRENT_TIMESTAMP()), start_date), '%H')) 'time'")->where("visit_id = $pk")->order_by("start_date ASC");
        $sale_info = (new Table($db, "visit_sales"))->where("visit_id = $pk")->get_row();
        ?>
        <div class="table-responsive mt-3 card" id="check_detail">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-dark">
                        <th class="text-left">Информация</th>
                        <th class="text-right">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td>
                            <strong style="font-size: 15px;">Прибывание:</strong><br>
                            <ul class="list-unstyled">
                                <?php foreach($tb->get_table() as $row): ?>
                                    <li>
                                        <span class="text-success"><?= number_format( $row->time * ($row->cost / 24) ) ?> -</span>
                                        <?= $row->location ?> 
                                        <span class="text-primary">(<?= $row->type ?>)</span> 
                                        ------> <?= number_format($row->cost) ?>/День 
                                        <span class="text-primary">(<?= minToStr($row->time) ?>)</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td class="text-right"><?= number_format(-$vps['cost-beds']) ?></td>
                    </tr>
                    <tr>
                        <td><strong style="font-size: 15px;">Услуги</strong></td>
                        <td class="text-right"><?= number_format(-$vps['cost-services']) ?></td>
                    </tr>
                    <?php if($sale_info): ?>
                        <tr>
                            <td>
                                <strong style="font-size: 15px;">Скидки:</strong><br>
                                <ul class="list-unstyled">
                                    <li>
                                        Койка - <?= number_format($sale_info->sale_bed_unit) ?> <span class="text-muted">(<?= $sale_info->sale_bed ?>%)</span><br>
                                        Услуги - <?= number_format($sale_info->sale_service_unit) ?> <span class="text-muted">(<?= $sale_info->sale_service ?>%)</span>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-right"><?= number_format($vps['sale-total']) ?></td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td><strong style="font-size: 15px;">Инвестиции</strong></td>
                        <td class="text-right text-success"><?= number_format($vps['balance']) ?></td>
                    </tr>
                    <tr>
                        <td><strong style="font-size: 15px;">К оплате</strong></td>
                        <td class="text-right text-danger"><?= number_format(-$vps['total_cost']) ?></td>
                    </tr>
                    <?php if($vps['result'] > 0): ?>
                        <tr class="table-danger">
                            <td><strong style="font-size: 15px;">Остаток</strong></td>
                            <td class="text-right text-success"><?= number_format($vps['result']) ?></td>
                        </tr>
                    <?php elseif($vps['result'] < 0): ?>
                        <tr class="table-danger">
                            <td><strong style="font-size: 15px;">Недостаток</strong></td>
                            <td class="text-right text-danger"><?= number_format(-$vps['result']) ?></td>
                        </tr>
                    <?php endif; ?>

                    

                </tbody>
            </table>
        </div>
        <?php
    }

    public function DetailPanelPharm($pk = null)
    {
        global $classes;
        if (!module('module_pharmacy')) Mixin\error('cash_permissions_false');
        ?>
        <div class="table-responsive mt-3 card" id="check_detail">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-dark">
                        <th class="text-left" colspan="2">Наименование</th>
                        <th>Дата и время</th>
                        <th class="text-right">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    

                </tbody>
            </table>
        </div>
        <?php
    }

}
        
?>