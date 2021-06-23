<?php

class VisitPriceModel extends Model
{
    public $table = 'visit_prices';
    public $_services = 'visit_services';
    public $table1 = 'visits';
    public $table2 = 'investment';

    public function form($pk = null)
    {
        global $db, $classes;
        if ( isset($_GET['refund']) and $_GET['refund'] ) {
            $amount = $db->query("SELECT SUM(price_cash + price_card + price_transfer) FROM $this->table WHERE price_date IS NOT NULL AND visit_id = {$_GET['visit_pk']} AND visit_service_id IN (".implode(",", $_GET['service_pks']).")")->fetchColumn();
            $price_cash = $db->query("SELECT SUM(price_cash) FROM $this->table WHERE price_date IS NOT NULL AND visit_id = {$_GET['visit_pk']} AND visit_service_id IN (".implode(",", $_GET['service_pks']).")")->fetchColumn();
            $price_card = $db->query("SELECT SUM(price_card) FROM $this->table WHERE price_date IS NOT NULL AND visit_id = {$_GET['visit_pk']} AND visit_service_id IN (".implode(",", $_GET['service_pks']).")")->fetchColumn();
            $price_transfer = $db->query("SELECT SUM(price_transfer) FROM $this->table WHERE price_date IS NOT NULL AND visit_id = {$_GET['visit_pk']} AND visit_service_id IN (".implode(",", $_GET['service_pks']).")")->fetchColumn();
        }else{
            $amount = $db->query("SELECT SUM(item_cost) FROM $this->table WHERE price_date IS NULL AND visit_id = {$_GET['visit_pk']} AND visit_service_id IN (".implode(",", $_GET['service_pks']).")")->fetchColumn();
        }
        ?>
        <form method="post" action="<?= add_url() ?>" onsubmit="Submit_alert()">

            <div class="modal-body">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="pricer_id" value="<?= $_SESSION['session_id'] ?>">
                <input type="hidden" name="visit_id" value="<?= $_GET['visit_pk'] ?>">
                <?php if( isset($_GET['refund']) and $_GET['refund'] ): ?>
                    <input type="hidden" name="is_refund" value="<?= $_GET['refund'] ?>">
                <?php endif; ?>

                <?php foreach ($_GET['service_pks'] as $value): ?>
                    <input type="hidden" name="visit_services[]" value="<?= $value ?>">
                <?php endforeach; ?>

                <div class="form-group row">

                    <div class="col-md-9">
                        <label class="col-form-label">Сумма к оплате:</label>
                        <input type="text" class="form-control" id="total_price" value="<?= number_format($amount, 1) ?>" disabled>
                        <input type="hidden" id="total_price_original" value="<?= $amount ?>">
                    </div>
                    <?php if( empty($_GET['refund']) ): ?>
                        <div class="col-md-3">
                            <label class="col-form-label">Скидка:</label>
                            <div class="form-group-feedback form-group-feedback-right">
                                <input type="number" class="form-control" step="0.1" name="sale" id="sale_input" placeholder="">
                                <div class="form-control-feedback text-success">
                                    <span style="font-size: 20px;">%</span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Наличный</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="price_cash" id="input_chek_1" step="0.5" class="form-control" placeholder="<?= ( isset($price_cash) ) ? number_format($price_cash) : 'расчет' ?>" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="swit" id="chek_1" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Пластиковый</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="price_card" id="input_chek_2" step="0.5" class="form-control" placeholder="<?= ( isset($price_card) ) ? number_format($price_card) : 'расчет' ?>" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="swit" id="chek_2" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Перечисление</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="price_transfer" id="input_chek_3" step="0.5" class="form-control" placeholder="<?= ( isset($price_transfer) ) ? number_format($price_transfer) : 'расчет' ?>" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="swit" id="chek_3" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Оплатить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>

        <script type="text/javascript">

            function Submit_alert() {
                var btn = event.submitter;
                event.preventDefault();
                btn.disabled = true;
                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (result) {
                        var result = JSON.parse(result);
                        
                        if (result.status == "success") {

                            // var parent_id = document.querySelectorAll('.parent_class');
                            // let par_id;

                            // parent_id.forEach(function(events) {
                            //     let obj = JSON.stringify({ type : 'alert_new_patient',  id : $(events).val(), message: "У вас новый амбулаторный пациент!" });
                            //     par_id = $(events).val()
                            //     conn.send(obj);
                            // });

                            // // send 
                            // let obj1 = JSON.stringify({ type : 'new_patient',  id : "1983", user_id : $('#user_amb_id').val() , parent_id : par_id});
                            // conn.send(obj1);

                            // Печать:
                            Print(result.val);
                            setTimeout( function() {
                                location.reload();
                            }, 1000)

                        }else{
                            new Noty({
                                text: result.message,
                                type: 'error'
                            }).show();
                            btn.disabled = false;
                            
                        }

                    },
                });
            }

            function Checkert(event) {
                var input = document.querySelector("#input_"+event.id);
                if(input.disabled){
                    input.disabled = false;
                    Upsum(input);
                }else {
                    input.disabled = true;
                    Downsum(input);
                }
            }

            $("#sale_input").keyup(function() {
                var sum = document.querySelector("#total_price_original").value;
                var proc = document.querySelector("#sale_input").value / 100;
                document.querySelector("#total_price").value = number_format( (sum - (sum * proc)), 1);
            });

        </script>
        <?php
    }

    public function form_pharm($pk = null)
    {
        dd("old function");
        ?>
        <form method="post" action="<?= add_url() ?>" onsubmit="Subi_pharm()">

            <div class="modal-body">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="pricer_id" value="<?= $_SESSION['session_id'] ?>">
                <input type="hidden" name="user_id" id="pharm_user_id">
                <input type="hidden" name="pharm_cost" id="pharm_total_price_hidden">

                <div class="form-group row">

                    <div class="col-md-12">
                        <label class="col-form-label">Сумма к оплате:</label>
                        <input type="text" class="form-control" id="pharm_total_price" disabled>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Наличный</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="price_cash" id="input_pharm_chek_1" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="form-control-switchery" data-fouc id="pharm_chek_1" onchange="Checkert2(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Пластиковый</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="price_card" id="input_pharm_chek_2" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="form-control-switchery" data-fouc id="pharm_chek_2" onchange="Checkert2(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Перечисление</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="price_transfer" id="input_pharm_chek_3" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="form-control-switchery" data-fouc id="pharm_chek_3" onchange="Checkert2(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Оплатить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>

        <script type="text/javascript">

            function Checkert2(event) {
                var input = $('#input_'+event.id);
                if(!input.prop('disabled')){
                    input.attr("disabled", "disabled");
                    // Downsum(input);
                }else {
                    input.removeAttr("disabled");
                    // Upsum(input); 
                }
            }

            function Subi_pharm() {
                event.preventDefault();
                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (result) {
                        if (result == 1) {
                            new Noty({
                                text: 'Успешно!',
                                type: 'success'
                            }).show();
                        }else {
                            new Noty({
                                text: result,
                                type: 'error'
                            }).show();
                        }
                        $('#modal_default').modal('hide');
                        Check('get_mod.php?pk='+$('#user_st_id').val() ,$('#user_st_id').val());
                    },
                });
            }

        </script>
        <?php
    }

    public function form_button($pk = null)
    {
        global $pk_visit, $completed, $price, $price_cost;
        dd("old function");
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="pricer_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="user_id" value="<?= $pk ?>">
            <input type="hidden" name="bed_cost" value="<?= $price['cost_bed'] ?>">
            <?php if(module('module_pharmacy')): ?>
                <?php if($completed): ?>
                    <button onclick="Pharm(<?= $pk ?>, '<?= $price['cost_item_2'] ?>', '<?= number_format($price['cost_item_2']) ?>')" type="button" class="btn btn-outline-primary btn-sm" <?= ($price['cost_item_2'] == 0) ? "disabled" : "" ?>>Лекарства</button>
                <?php endif; ?>
            <?php endif; ?>
            <button onclick="SaleCheck(<?= $pk_visit ?>, <?= round($price['cost_bed'] + $price['cost_beds'], 1) ?>, <?= round($price['cost_service'], 1) ?>)" type="button" class="btn btn-outline-secondary btn-sm">Скидка</button>
            <button onclick="Invest(1)" type="button" data-name="Разница" data-balance="<?= number_format($price['balance'] + $price_cost) ?>" class="btn btn-outline-success btn-sm">Предоплата</button>
            <button onclick="Invest(0)" type="button" data-name="Баланс" data-balance="<?= number_format($price['balance']) ?>" class="btn btn-outline-danger btn-sm">Возврат</button>
            <button onclick="Proter('<?= $pk_visit ?>')" type="button" class="btn btn-outline-warning btn-sm" <?= ($completed and $price['cost_item_2'] == 0) ? "" : "disabled" ?>>Расщёт</button>
            <button onclick="Detail('<?= viv('cashbox/get_detail')."?pk=".$pk?>')" type="button" class="btn btn-outline-primary btn-sm" data-show="1">Детально</button>
        </form>
        <script type="text/javascript">

            function printdiv(printpage) {
                var printContents = document.getElementById(printpage).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }

            function Pharm(pk, cost, format_cost) {
                $('#modal_default').modal('show');
                $('#pharm_user_id').val(pk);
                $('#pharm_total_price_hidden').val(cost);
                $('#pharm_total_price').val(format_cost);
            }

            function SaleCheck(pk, bed_cost, service_cost){
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('cashbox_sale') ?>",
                    data: {pk:pk},
                    success: function (result) {
                        $('#modal_sale').modal('show');
                        $('#modal_sale_div').html(result);
                        $('#bed_price_sale').val(bed_cost);
                        $('#bed_price_original_sale').val(bed_cost);
                        $('#service_price_sale').val(service_cost);
                        $('#service_price_original_sale').val(service_cost);
                    }
                });
            }

            function Proter(pk) {
                event.preventDefault();
                // $('#<?= __CLASS__ ?>_form').submit();

                if (Math.round($('#prot_item').val()) != 0) {

                    if ($('#prot_item').val() < 0) {
                        var text = "Нехватка средств!";
                    }else {
                        var text = "Верните пациенту деньги!";
                    }
                    new Noty({
                        text: text,
                        type: 'error'
                    }).show();

                }else {
                    $.ajax({
                        type: $('#<?= __CLASS__ ?>_form').attr("method"),
                        url: $('#<?= __CLASS__ ?>_form').attr("action"),
                        data: $('#<?= __CLASS__ ?>_form').serializeArray(),
                        success: function (result) {
                            // alert(result);
                            var result = JSON.parse(result);

                            if (result.status == "success") {
                                // Выдача выписки
                                var url = "<?= viv('prints/document_3') ?>?id="+pk;
                                Print(url);
                                // Перезагрузка
                                sessionStorage['message'] = result.message;
                                setTimeout( function() {
                                        location.reload();
                                    }, 1000)
                            }else {
                                $('#check_div').html(result.message);
                            }

                        },
                    });
                }
            }

        </script>
        <?php
    }

    public function clean()
    {
        global $db;
        // Constructor
        $this->post['price_cash'] = (isset($this->post['price_cash'])) ? $this->post['price_cash'] : 0;
        $this->post['price_card'] = (isset($this->post['price_card'])) ? $this->post['price_card'] : 0;
        $this->post['price_transfer'] = (isset($this->post['price_transfer'])) ? $this->post['price_transfer'] : 0;
        $this->visit = $db->query("SELECT * FROM $this->table1 WHERE id = {$this->post['visit_id']}")->fetch();
        unset($this->post['visit_id']);
        
        if ($this->visit['direction']) {
            # Stationar 
            $this->dd();
        }else{
            # Ambulator

            // Refund or Price
            if ( isset($this->post['is_refund']) and $this->post['is_refund'] ) {
                $sql = "SELECT SUM(price_cash + price_card + price_transfer) FROM $this->table WHERE price_date IS NOT NULL AND visit_id = {$this->visit['id']} AND visit_service_id IN (".implode(",", $this->post['visit_services']).")";
            } else {
                $sql = "SELECT SUM(item_cost) FROM $this->table WHERE price_date IS NULL AND visit_id = {$this->visit['id']} AND visit_service_id IN (".implode(",", $this->post['visit_services']).")";
            }
            $amount = $db->query($sql)->fetchColumn();
            if ( isset($this->post['sale']) and $this->post['sale'] > 0) $amount = $amount - ($amount * ($this->post['sale'] / 100));
            $result = $amount - ($this->post['price_cash'] + $this->post['price_card'] + $this->post['price_transfer']);
            if ($result < 0) {
                $this->error("Есть остаток ".$result);
            }elseif ($result > 0) {
                $this->error("Недостаточно средств! ". $result);
            }else {
                $this->post = Mixin\clean_form($this->post);
                $this->post = Mixin\to_null($this->post);
                return True;
            }
        }

        // $this->user_pk = $this->post['user_id'];
        // unset($this->post['user_id']);
        // if (isset($this->post['bed_cost'])) {

        //     $this->bed_cost = $this->post['bed_cost'];
        //     unset($this->post['bed_cost']);
        //     $this->status = null;
        //     return True;

        // }elseif (module('module_pharmacy') and isset($this->post['pharm_cost'])) {

        //     $result = round(round($this->post['pharm_cost']) - ($this->post['price_cash'] + $this->post['price_card'] + $this->post['price_transfer']));
        //     if ($result < 0) {
        //         echo "Есть остаток ".$result;
        //         exit;
        //     }elseif ($result > 0) {
        //         echo "Недостаточно средств! ". $result;
        //         exit;
        //     }else {
        //         $this->pharm_cost = $this->post['pharm_cost'];
        //         unset($this->post['pharm_cost']);
        //         $this->status = null;
        //         return True;
        //     }

        // } else {

        //     $tot = $db->query("SELECT SUM(vp.item_cost) 'total_price' FROM $this->table1 vs LEFT JOIN $this->table vp ON(vp.visit_id=vs.id) WHERE vs.priced_date IS NULL AND vs.user_id = $this->user_pk")->fetch();
        //     if ($this->post['sale'] > 0) {
        //         $tot['total_price'] = $tot['total_price'] - ($tot['total_price'] * ($this->post['sale'] / 100));
        //     }
        //     $result = $tot['total_price'] - ($this->post['price_cash'] + $this->post['price_card'] + $this->post['price_transfer']);
        //     if ($result < 0) {
        //         $this->error("Есть остаток ".$result);
        //     }elseif ($result > 0) {
        //         $this->error("Недостаточно средств! ". $result);
        //     }else {
        //         $this->post = Mixin\clean_form($this->post);
        //         $this->post = Mixin\to_null($this->post);
        //         $this->status = 1;
        //         return True;
        //     }

        // }
    }

    public function price($row)
    {
        global $db;
        $post = array(
            'pricer_id' => $this->post['pricer_id'],
            'sale' => (isset($this->post['sale'])) ? $this->post['sale'] : null,
            'price_date' => date("Y-m-d H:i:s"),
            'status' => ($this->visit['direction']) ? null : 1
        );

        // Sale for Stationar
        if ($this->visit['direction']) {
            if (isset($this->sale_service) and $this->sale_service > 0 and in_array($row['item_type'], [1,5])) {
                $row['item_cost'] = $row['item_cost'] - ($row['item_cost'] * ($this->sale_service / 100));
                $post['sale'] = $this->sale_service;
            }
            if (isset($this->sale_bed) and $this->sale_bed > 0 and in_array($row['item_type'], [101])) {
                $row['item_cost'] = $row['item_cost'] - ($row['item_cost'] * ($this->sale_bed / 100));
                $post['sale'] = $this->sale_bed;
            }
        }

        // Begin script 'PRICE'
        if ($this->post['price_cash'])
        {
            if ($this->post['price_cash'] >= $row['item_cost']) {
                $this->post['price_cash'] -= $row['item_cost'];
                $post['price_cash'] = $row['item_cost'];
            }else {
                $post['price_cash'] = $this->post['price_cash'];
                $this->post['price_cash'] = 0;
                $temp = round($row['item_cost'] - $post['price_cash']);
                if ($this->post['price_card'] >= $temp) {
                    $this->post['price_card'] -= $temp;
                    $post['price_card'] = $temp;
                }else {
                    $post['price_card'] = $this->post['price_card'];
                    $this->post['price_card'] = 0;
                    $temp = round($temp - $post['price_card']);
                    if ($this->post['price_transfer'] >= $temp) {
                        $this->post['price_transfer'] -= $temp;
                        $post['price_transfer'] = $temp;
                    }else {
                        if ($this->err_temp($temp)) {
                            $this->error("Ошибка в price cash => transfer");
                        }
                    }
                }
            }
        }
        elseif ($this->post['price_card'])
        {
            if ($this->post['price_card'] >= $row['item_cost']) {
                $this->post['price_card'] -= $row['item_cost'];
                $post['price_card'] = $row['item_cost'];
            }else {
                $post['price_card'] = $this->post['price_card'];
                $this->post['price_card'] = 0;
                $temp = round($row['item_cost'] - $post['price_card']);
                if ($this->post['price_transfer'] >= $temp) {
                    $this->post['price_transfer'] -= $temp;
                    $post['price_transfer'] = $temp;
                }else {
                    if ($this->err_temp($temp)) {
                        $this->error("Ошибка в price card => transfer");
                    }
                }
            }
        }
        else
        {
            if ($this->post['price_transfer'] >= $row['item_cost']) {
                $this->post['price_transfer'] -= $row['item_cost'];
                $post['price_transfer'] = $row['item_cost'];
            }else {
                $this->error("Ошибка в price transfer => transfer");
            }
        }
        // End

        // Price visit_price
        $object = Mixin\update($this->table, $post, $row['id']);
        if (!intval($object)){
            $this->error($object);
        }
        $this->visit_prices_items[] = $row['id'];

        // Update visit_services 
        $object = Mixin\update($this->_services, array('status' => ($this->visit['direction']) ? 1 : 2), $row['visit_service_id']);
        if (!intval($object)){
            $this->error($object);
        }
        // if (empty($this->pharm_cost)) {
        //     $object = Mixin\update($this->table1, array('status' => $this->status, 'priced_date' => date('Y-m-d H:i:s')), $row['visit_id']);
        //     if (!intval($object)){
        //         $this->error($object);
        //     }
        // }
    }

    public function refund($row)
    {
        global $db;
        $post = array(
            'visit_id' => $row['visit_id'],
            'visit_service_id' => $row['visit_service_id'],
            'user_id' => $row['user_id'],
            'pricer_id' => $this->post['pricer_id'],
            'status' => 1,
            'item_type' => $row['item_type'],
            'item_id' => $row['item_id'],
            'item_cost' => $row['item_cost'],
            'item_name' => $row['item_name'],
            'price_date' => date("Y-m-d H:i:s"),
        );

        // Begin script 'PRICE'
        if ($this->post['price_cash'])
        {
            if ($this->post['price_cash'] >= $row['item_cost']) {
                $this->post['price_cash'] -= $row['item_cost'];
                $post['price_cash'] = $row['item_cost'];
            }else {
                $post['price_cash'] = $this->post['price_cash'];
                $this->post['price_cash'] = 0;
                $temp = round($row['item_cost'] - $post['price_cash']);
                if ($this->post['price_card'] >= $temp) {
                    $this->post['price_card'] -= $temp;
                    $post['price_card'] = $temp;
                }else {
                    $post['price_card'] = $this->post['price_card'];
                    $this->post['price_card'] = 0;
                    $temp = round($temp - $post['price_card']);
                    if ($this->post['price_transfer'] >= $temp) {
                        $this->post['price_transfer'] -= $temp;
                        $post['price_transfer'] = $temp;
                    }else {
                        if ($this->err_temp($temp)) {
                            $this->error("Ошибка в price cash => transfer");
                        }
                    }
                }
            }
        }
        elseif ($this->post['price_card'])
        {
            if ($this->post['price_card'] >= $row['item_cost']) {
                $this->post['price_card'] -= $row['item_cost'];
                $post['price_card'] = $row['item_cost'];
            }else {
                $post['price_card'] = $this->post['price_card'];
                $this->post['price_card'] = 0;
                $temp = round($row['item_cost'] - $post['price_card']);
                if ($this->post['price_transfer'] >= $temp) {
                    $this->post['price_transfer'] -= $temp;
                    $post['price_transfer'] = $temp;
                }else {
                    if ($this->err_temp($temp)) {
                        $this->error("Ошибка в price card => transfer");
                    }
                }
            }
        }
        else
        {
            if ($this->post['price_transfer'] >= $row['item_cost']) {
                $this->post['price_transfer'] -= $row['item_cost'];
                $post['price_transfer'] = $row['item_cost'];
            }else {
                $this->error("Ошибка в price transfer => transfer");
            }
        }
        // End

        // Price visit_price
        if(isset($post['price_cash'])) $post['price_cash'] = -$post['price_cash'];
        if(isset($post['price_card'])) $post['price_card'] = -$post['price_card'];
        if(isset($post['price_transfer'])) $post['price_transfer'] = -$post['price_transfer'];

        $object = Mixin\insert($this->table, $post);
        if (!intval($object)){
            $this->error($object);
        }
        $this->visit_prices_items[] = $object;

        // Update visit_services 
        $object = Mixin\update($this->_services, array('status' => 6, 'completed' => date("Y-m-d H:i:s")), $row['visit_service_id']);
        if (!intval($object)){
            $this->error($object);
        }
        // if (empty($this->pharm_cost)) {
        //     $object = Mixin\update($this->table1, array('status' => $this->status, 'priced_date' => date('Y-m-d H:i:s')), $row['visit_id']);
        //     if (!intval($object)){
        //         $this->error($object);
        //     }
        // }
    }

    public function ambulator_price()
    {
        global $db;
        // Refund or Price
        if ( isset($this->post['is_refund']) and $this->post['is_refund'] ) {
            $sql = "SELECT *, (price_cash + price_card + price_transfer) 'item_cost' FROM $this->table WHERE price_date IS NOT NULL AND visit_id = {$this->visit['id']} AND visit_service_id IN (".implode(",", $this->post['visit_services']).") ORDER BY item_cost ASC";
            $action = "refund";
        } else {
            $sql = "SELECT id, visit_service_id, item_cost, item_name FROM $this->table WHERE price_date IS NULL AND visit_id = {$this->visit['id']} AND visit_service_id IN (".implode(",", $this->post['visit_services']).") ORDER BY item_cost ASC";
            $action = "price";
        }

        foreach ($db->query($sql) as $row) {
            if ( isset($this->post['sale']) and $this->post['sale'] > 0) {
                $row['item_cost'] = $row['item_cost'] - ($row['item_cost'] * ($this->post['sale'] / 100));
            }
            $this->{$action}($row);
        }
        (new VisitModel())->is_update($this->visit['id']);
    }

    public function stationar_price()
    {
        global $db;
        // if (isset($this->pharm_cost)) {
        //     foreach ($db->query("SELECT vp.id, vs.id 'visit_id', vp.operation_id, vp.item_type, vp.item_id, vp.item_cost, vp.item_name FROM $this->table1 vs LEFT JOIN $this->table vp ON(vp.visit_id=vs.id) WHERE vp.item_type IN(2,3,4) AND vs.priced_date IS NULL AND vs.user_id = $this->user_pk ORDER BY vp.item_cost") as $row) {
        //         $this->price($row, 0);
        //     }
        //     $db->commit();
        //     echo 1;
        //     exit;
        // } else {
        //     if (module('module_pharmacy') and 0 < $db->query("SELECT vp.id FROM $this->table1 vs LEFT JOIN $this->table vp ON(vp.visit_id=vs.id) WHERE vp.item_type IN(2,3,4) AND vs.priced_date IS NULL AND vs.user_id = $this->user_pk AND vp.price_date IS NULL ORDER BY vp.item_cost")->rowCount()) {
        //         $this->error("Ошибка! Оплатите лекарства.");
        //         exit;
        //     }
        //     $balance = $db->query("SELECT SUM(balance_cash) 'balance_cash', SUM(balance_card) 'balance_card', SUM(balance_transfer) 'balance_transfer' FROM $this->table2 WHERE user_id = $this->user_pk")->fetch();
        //     if ($balance['balance_cash'] < 0 or $balance['balance_card'] < 0 or $balance['balance_transfer'] < 0) {
        //         $this->error("Критическая ошибка!");
        //         exit;
        //     }
        //     $this->add_bed();
        //     $this->post['sale'] = null;
        //     if ($balance['balance_cash'] != 0) {
        //         $this->post['price_cash'] = $balance['balance_cash'];
        //     }
        //     if ($balance['balance_card'] != 0) {
        //         $this->post['price_card'] = $balance['balance_card'];
        //     }
        //     if ($balance['balance_transfer'] != 0) {
        //         $this->post['price_transfer'] = $balance['balance_transfer'];
        //     }

        //     foreach ($db->query("SELECT vp.id, vs.id 'visit_id', vp.operation_id, vp.item_type, vp.item_id, vp.item_cost, vp.item_name FROM $this->table1 vs LEFT JOIN $this->table vp ON(vp.visit_id=vs.id) WHERE vp.item_type IN(1,5,101) AND vs.priced_date IS NULL AND vs.user_id = $this->user_pk ORDER BY vp.item_cost") as $row) {
        //         if ($row['operation_id']) {
        //             Mixin\update('operation', array('priced_date' => date('Y-m-d H:i:s')), $row['operation_id']);
        //             unset($row['operation_id']);
        //         }
        //         $this->price($row, 0);
        //     }
        //     $this->up_invest();
        //     Mixin\update($this->table1, array('status' => null), $this->ti);
        // }
    }

    // public function add_bed()
    // {
    //     global $db;
    //     $ti = $db->query("SELECT vs.*, vss.sale_bed, vss.sale_service FROM $this->table1 vs LEFT JOIN visit_sale vss ON(vss.visit_id=vs.id) WHERE vs.user_id = $this->user_pk AND vs.service_id = 1 AND vs.priced_date IS NULL AND vs.completed IS NOT NULL")->fetch();
    //     $this->ti = $ti['id'];
    //     $this->sale_bed = $ti['sale_bed'];
    //     $this->sale_service = $ti['sale_service'];
    //     $bed = $db->query("SELECT wd.floor, wd.ward, bd.bed FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) WHERE bd.id = {$ti['bed_id']}")->fetch();
    //     $post['visit_id'] = $ti['id'];
    //     $post['user_id'] = $this->user_pk;
    //     $post['pricer_id'] = $this->post['pricer_id'];
    //     $post['status'] = 0;
    //     $post['item_type'] = 101;
    //     $post['item_id'] = $ti['bed_id'];
    //     $post['item_name'] = $bed['floor']." этаж ".$bed['ward']." палата ".$bed['bed']." койка";
    //     $post['item_cost'] = $this->bed_cost;
    //     $object = Mixin\insert($this->table, $post);
    //     if (!intval($object)) {
    //         $this->error($object);
    //     }
    // }

    // public function up_invest()
    // {
    //     global $db;
    //     foreach ($db->query("SELECT * FROM $this->table2 WHERE user_id = $this->user_pk") as $row) {
    //         $object = Mixin\update($this->table2, array('status' => null), $row['id']);
    //         if (!intval($object)){
    //             $this->error($object);
    //         }
    //     }
    //     Mixin\update('users', array('status' => null), $this->user_pk);
    // }

    public function err_temp(Int $temp = 0)
    {
        if (isset($this->bed_cost)) {
            $range = range(-500,500);
        } else {
            $range = range(-1,1);
        }
        
        if (in_array($temp, $range)) {
            return false;
        }
        return true;
    }

    public function save()
    {
        global $db;
        if($this->clean()){

            $db->beginTransaction();
            if ( $this->visit['direction'] ) {
                $this->stationar_price();
            }else {
                $this->ambulator_price();
            }
            $db->commit();
            $this->success();

        }
    }

    public function success()
    {
        $value = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        if (isset($this->bed_cost)) {
            echo json_encode(array(
                'status' => "success",
                'message' => $value
            ));
        }else {
            echo json_encode(array(
                'status' => "success" ,
                'message' => $value,
                'val' => prints('check')."?id=".$this->visit['user_id']."&items=".json_encode($this->visit_prices_items)
            ));
        }
    }

    public function error($message)
    {
        $value = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold">'.$message.'</span>
        </div>
        ';
        echo json_encode(array(
            'status' => "error" ,
            'message' => $value
        ));
        exit;
    }

}

?>