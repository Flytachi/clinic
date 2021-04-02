<?php

class StorageSale extends Model
{
    public $table = 'storage';

    public function form($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form" onsubmit="AmountSubmit(this)">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="table-responsive card">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="bg-info">
                            <th style="width:55%">Препарат</th>
                            <th class="text-right" style="width: 100px">Кол-во</th>
                            <th class="text-right">Цена ед.</th>
                            <th class="text-right" style="width:50px">Действия</th>
                        </tr>
                    </thead>
                    <tbody id="sale_items">

                    </tbody>
                    <tbody>
                        <tr class="table-secondary">
                            <th colspan="2" class="text-right">Итого:</th>
                            <th class="text-right" id="total_cost">0</th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-right">

                <button type="button" class="btn btn-outline-danger btn-sm" onclick="Amount_check('Возврат')">Возврат</button>
                <button type="button" class="btn btn-outline-success btn-sm" onclick="Amount_check('Продажа')">Продажа</button>

            </div>

            <div style="display:none;" id="form_amounts"></div>

        </form>
        <script type="text/javascript">

            if (sessionStorage['message']) {
                var mes = JSON.parse(sessionStorage['message']);
                setTimeout( function() {
                        new Noty(mes).show();
                    }, 100)
                delete sessionStorage['message'];
            }

            function AmountSubmit(){
                event.preventDefault();
                $.ajax({
                    type: $('#<?= __CLASS__ ?>_form').attr("method"),
                    url: $('#<?= __CLASS__ ?>_form').attr("action"),
                    data: $('#<?= __CLASS__ ?>_form').serializeArray(),
                    success: function (data) {
                        var result = JSON.parse(data);
                        // console.log(result);
                        if (result.type == "success") {
                            Print(result.val);
                            delete result.val;
                        }
                        sessionStorage['message'] = data;
                        setTimeout( function() {
                                location.reload();
                            }, 300)
                    },
                });
            }

            function Amount_check(btn_type){
                $('#modal_amount').modal('show');
                var price = $('#total_cost').text().replace(/,/g,'');
                $('#total_amount').val(price);
                $('#total_amount_original').val(price);
                $('#type_btn').val(btn_type);
            }

        </script>
        <?php
    }

    public function modal()
    {
        ?>
        <script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
        <script src="<?= stack("vendors/js/custom.js") ?>"></script>

        <div class="modal-body" id="amount_body">

            <input type="hidden" name="btn_type" id="type_btn">

            <div class="form-group row">

                <div class="col-md-9">
                    <label class="col-form-label">Сумма к оплате:</label>
                    <input type="text" class="form-control" id="total_amount" disabled>
                    <input type="hidden" id="total_amount_original">
                </div>
                <div class="col-md-3">
                    <label class="col-form-label">Скидка:</label>
                    <div class="form-group-feedback form-group-feedback-right">
                        <input type="number" class="form-control" step="0.1" name="sale" id="sale_input" placeholder="">
                        <div class="form-control-feedback text-success">
                            <span style="font-size: 20px;">%</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <label class="col-form-label col-md-3">Наличный</label>
                <div class="col-md-9">
                    <div class="input-group">
                        <input type="number" name="price_cash" id="input_chek_1" step="0.5" class="form-control" placeholder="расчет" disabled>
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
                        <input type="number" name="price_card" id="input_chek_2" step="0.5" class="form-control" placeholder="расчет" disabled>
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
                        <input type="number" name="price_transfer" id="input_chek_3" step="0.5" class="form-control" placeholder="расчет" disabled>
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
            <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
            <button type="button" class="btn btn-outline-info btn-sm" onclick="Submit_amount()">Готово</button>
        </div>

        <script type="text/javascript">

            function Submit_amount() {
                $('#modal_amount').modal('hide');
                $('#form_amounts').html($('#amount_body'));
                AmountSubmit();
            }

            function Checkert(event) {
                var input = $('#input_'+event.id);
                if(!input.prop('disabled')){
                    input.attr("disabled", "disabled");
                    Downsum(input);
                }else {
                    input.removeAttr("disabled");
                    Upsum(input);
                }
            }

            $("#sale_input").keyup(function() {
                var sum = $("#total_amount_original").val();
                var proc = $("#sale_input").val() / 100;
                $("#total_amount").val(sum - (sum * proc));
            });

            function Downsum(input) {
    			input.attr("class", 'form-control');
    			input.val("");
    			var inp_s = $('.input_chek');
    			inp_s.val($('#total_amount').val()/inp_s.length);
    		}

    		function Upsum(input) {
    			input.attr("class", 'form-control input_chek');
    			var inp_s = $('.input_chek');
    			var vas = 0;
    			for (let key of inp_s) {
    				vas += Number(key.value);
    			}
    			input.val($('#total_amount').val()-vas);
    		}

        </script>
        <?php
    }

    public function clean()
    {
        global $db;
        $db->beginTransaction();
        if (!$this->post['preparat']) {
            $this->error('Пустой запрос!');
        }
        foreach ($this->post['preparat'] as $key => $value) {
            if ($this->post['btn_type'] == "Продажа") {
                $qty = $this->post['qty'][$key];
                if ($qty > $value) {
                    $this->error('Ошибка в колличестве!');
                }
            }else {
                $qty = -$this->post['qty'][$key];
            }
            $post = $db->query("SELECT * FROM storage WHERE id = $key")->fetch();
            unset($post['add_date']);
            $post['parent_id'] = $this->post['parent_id'];
            // расход препеарата
            $object = Mixin\update('storage', array('qty' => $post['qty']-$qty, 'qty_sold' => $post['qty_sold']+$qty), $key);
            if (!intval($object)) {
                $this->error('storage '.$object);
                $db->rollBack();
            }
            $this->amount($key, $value, $post, $qty);
        }
        $db->commit();
        $this->success();
    }

    public function amount($key, $value, $post_or, $qty)
    {
        global $db;
        if ($this->post['sale'] > 0) {
            $total_price = ($qty * $post_or['price']) - (($qty * $post_or['price']) * ($this->post['sale'] / 100));
        }else {
            $total_price = $qty * $post_or['price'];
        }

        $post = array(
            'code' => $post_or['code'], 'name' => $post_or['name'],
            'supplier' => $post_or['supplier'], 'qty' => $qty,
            'price' => $post_or['price'], 'sale' => ($this->post['sale']) ? $this->post['sale'] : 0);

        if ($this->post['price_cash'])
        {
            if ($this->post['price_cash'] >= $total_price) {
                $this->post['price_cash'] -= $total_price;
                $post['amount_cash'] = $total_price;
            }else {
                $post['amount_cash'] = $this->post['price_cash'];
                $this->post['price_cash'] = 0;
                $temp = round($total_price - $post['amount_cash']);
                if ($this->post['price_card'] >= $temp) {
                    $this->post['price_card'] -= $temp;
                    $post['amount_card'] = $temp;
                }else {
                    $post['amount_card'] = $this->post['price_card'];
                    $this->post['price_card'] = 0;
                    $temp = round($temp - $post['amount_card']);
                    if ($this->post['price_transfer'] >= $temp) {
                        $this->post['price_transfer'] -= $temp;
                        $post['amount_transfer'] = $temp;
                    }else {
                        $this->error("Ошибка в amount transfer");
                    }
                }
            }
        }
        elseif ($this->post['price_card'])
        {
            if ($this->post['price_card'] >= $total_price) {
                $this->post['price_card'] -= $total_price;
                $post['amount_card'] = $total_price;
            }else {
                $post['amount_card'] = $this->post['price_card'];
                $this->post['price_card'] = 0;
                $temp = round($total_price - $post['amount_card']);
                if ($this->post['amount_transfer'] >= $temp) {
                    $this->post['amount_transfer'] -= $temp;
                    $post['amount_transfer'] = $temp;
                }else {
                    $this->error("Ошибка в amount transfer");
                }
            }
        }
        else
        {
            if ($this->post['price_transfer'] >= $total_price) {
                $this->post['price_transfer'] -= $total_price;
                $post['amount_transfer'] = $total_price;
            }else {
                $this->error("Ошибка в amount transfer");
            }
        }

        $object = Mixin\insert('storage_sales', $post);
        if (!intval($object)) {
            $this->error('storage_sales '.$object);
            $db->rollBack();
        }
        $this->items[] = $object;
    }

    public function success()
    {
        echo json_encode(array(
            'type' => "success",
            'text' => "Успешно",
            'val' => viv('prints/check_pharm')."?items=".json_encode($this->items)
        ));
        exit;
    }

    public function error($message)
    {
        echo json_encode(array(
            'type' => "error",
            'text' => $message
        ));
        exit;
    }
}

?>