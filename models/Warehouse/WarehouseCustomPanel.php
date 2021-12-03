<?php

use Warframe\Model;

class WarehouseCustomPanel extends Model
{
    public $table = 'warehouse_custom';
    public $_oreders = 'warehouse_orders';
    public $_name = 'warehouse_item_names';
    public $_suppliers = 'warehouse_item_suppliers';
    public $_manufacturers = 'warehouse_item_manufacturers';
    public $_applications = 'visit_bypass_event_applications';
    public $_bypass_transactions = 'visit_bypass_transactions';
    public $i = 0;
    public $cost = 0;

    public function get_or_404(int $pk)
    {
        global $db;
        if ( isset($_GET) and $_GET['id'] == 1 and isset($_POST) ) {
            $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->set_post($_POST);
            unset($_POST);
            if ( isset($this->post['search']) and $this->post['search'] ) {
                $this->{$_GET['form']}();
            }else {
                $this->empty_result();
            }
        }elseif (isset($_GET) and $_GET['id'] == 2 and isset($_POST)) {
            $this->ajax_control($_POST);
        }elseif(isset($_GET) and $_GET['id'] == 3 and isset($_POST)){
            $this->transaction((object) $_POST);
        }

    }

    public function form($pk = null)
    {
        global $classes, $db, $session;
        $patient = json_decode($_GET['patient']);
        $is_order = ($patient->direction) ? $patient->order : null;
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Добавить расходник</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="direction" value="<?= $patient->direction ?>">
                <input type="hidden" name="client_id" value="<?= $patient->id ?>">

                <ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
                    <?php if($is_order): ?>
                        <li class="nav-item"><a href="#" onclick="ChangeWare('order')" class="nav-link legitRipple" data-toggle="tab">Склад бесплатных препаратов</a></li>
                    <?php endif; ?>
                    <?php if( module('pharmacy') and $ware_sett = (new Table($db, "warehouse_settings ws"))->set_data("w.id, w.name")->additions("LEFT JOIN warehouses w ON(w.id=ws.warehouse_id)")->where("ws.branch_id = $session->branch AND ws.division_id = $session->session_division AND w.is_active IS NOT NULL")->get_table() ): ?>
                        <?php foreach ($ware_sett as $ware): ?>
                            <li class="nav-item"><a href="#" onclick="ChangeWare(<?= $ware->id ?>)" class="nav-link legitRipple" data-toggle="tab"><?= $ware->name ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <div class="form-group-feedback form-group-feedback-right">

                    <div id="bypass_search_input" style="display:none;">
                        <input type="text" class="<?= $classes['input-product_search'] ?>" id="search_input_product" placeholder="Поиск..." title="Введите название препарата">
                        <div class="form-control-feedback">
                            <i class="icon-search4 font-size-base text-muted"></i>
                        </div>
                    </div>

                </div>

                <div class="form-group" id="bypass_search_area"></div>

            </div>

        </form>
        <script type="text/javascript">
            var s = 0;
            var warehouse = null;

            function ChangeWare(params) {
                
                if (!warehouse) {
                    document.querySelector("#bypass_search_input").style.display = "block"; 
                }else{
                    document.querySelector("#search_input_product").value = ""; 
                }

                if (params == "order") {
                    var table = `
                    <div class="form-group" id="search_area">

                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-dark">
                                        <th>Наименование</th>
                                        <th style="width:370px">Производитель</th>
                                        <th class="text-center" style="width:150px">На складе</th>
                                        <th style="width:100px">Кол-во</th>
                                        <th class="text-center" style="width:50px">#</th>
                                    </tr>
                                </thead>
                                <tbody id="table_form">

                                </tbody>
                            </table>
                        </div>

                    </div>`;
                } else {
                    var table = `
                    <div class="form-group" id="search_area">

                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-dark">
                                        <th>Наименование</th>
                                        <th style="width:370px">Производитель</th>
                                        <th style="width:370px">Стоимость</th>
                                        <th class="text-center" style="width:150px">На складе</th>
                                        <th style="width:100px">Кол-во</th>
                                        <th class="text-center" style="width:50px">#</th>
                                    </tr>
                                </thead>
                                <tbody id="table_form">

                                </tbody>
                            </table>
                        </div>

                    </div>`;
                }
                
                document.querySelector("#bypass_search_area").innerHTML = table;
                warehouse = params;
            }

            $("#search_input_product").keyup(function() {

                if (warehouse == "order") {
                    $.ajax({
                        type: "POST",
                        url: "<?= up_url(1, 'WarehouseOrderPanel', 'change_table') ?>",
                        data: {
                            branch_id: <?= $session->branch ?>,
                            search: this.value,
                        },
                        success: function (result) {
                            
                            $('#table_form').html(result);
                        },
                    });
                }else{
                    $.ajax({
                        type: "POST",
                        url: "<?= up_url(1, 'WarehouseCustomPanel', 'change_table') ?>",
                        data: {
                            branch_id: <?= $session->branch ?>,
                            warehouse_id: warehouse,
                            search: this.value,
                            default: 1,
                        },
                        success: function (result) {
                            
                            $('#table_form').html(result);
                        },
                    });
                }
            });

            function SelectProduct(btn, index) {
                btn.disabled = true;

                if (warehouse == "order") {
                    var data = {
                        branch_id: <?= $session->branch ?>,
                        visit_id: <?= $patient->visit_id ?>,
                        client_id: <?= $patient->id ?>,
                        warehouse_id: warehouse,
                        item_name_id: document.querySelector('#name_id_input_'+index).value,
                        item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                        item_price: 0,
                        item_qty: document.querySelector('#qty_input_'+index).value,
                    };
                } else {
                    var data = {
                        branch_id: <?= $session->branch ?>,
                        visit_id: <?= $patient->visit_id ?>,
                        client_id: <?= $patient->id ?>,
                        warehouse_id: warehouse,
                        item_name_id: document.querySelector('#name_id_input_'+index).value,
                        item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                        item_price: document.querySelector('#price_id_input_'+index).value,
                        item_qty: document.querySelector('#qty_input_'+index).value,
                    };
                }

                $.ajax({
                    type: "POST",
                    url: "<?= up_url(3, __CLASS__) ?>",
                    data: data,
                    success: function (result) {
                        var data = JSON.parse(result);
                        if (data.status == "success") {
                            $(`#Item_${index}`).css("background-color", "rgb(70, 200, 150)");
                            $(`#Item_${index}`).css("color", "black");
                            $(`#Item_${index}`).fadeOut(900, function() {
                                $(this).remove();
                            });
                        } else {
                            new Noty({
                                text: data.message,
                                type: data.status
                            }).show();
                            btn.disabled = false;
                        }
                    },
                });
            }

        </script>
        <?php
        $this->jquery_init();
    }

    public function change_table()
    {
        global $db, $classes;
        $search = Mixin\clean($this->post['search']);

        foreach ($db->query("SELECT DISTINCT wc.item_name_id, win.name FROM $this->table wc LEFT JOIN $this->_name win ON (win.id=wc.item_name_id) WHERE wc.branch_id = {$this->post['branch_id']} AND wc.warehouse_id = {$this->post['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND LOWER(win.name) LIKE LOWER('%$search%')") as $row){
            $this->i++;
            ?>
            <tr id="Item_<?= $this->i ?>">

                <!-- Name -->
                <td>
                    <span id="name_input_<?= $this->i ?>"><?= $row->name ?></span>
                    <input type="hidden" id="name_id_input_<?= $this->i ?>" value="<?= $row->item_name_id ?>">
                </td>

                <!-- Manufacturer -->
                <td>
                    <select id="manufacturer_id_input_<?= $this->i ?>" class="<?= $classes['form-select'] ?> manufacturers" data-i="<?= $this->i ?>" data-item_name="<?= $row->item_name_id ?>">
                        <?php if($this->post['default']): ?>
                            <option value="" >Производитель будет выбран автоматически</option>
                        <?php endif; ?>
                        <?php foreach ($db->query("SELECT DISTINCT wis.id, wis.manufacturer FROM $this->table wc LEFT JOIN $this->_manufacturers wis ON (wis.id=wc.item_manufacturer_id) WHERE wc.branch_id = {$this->post['branch_id']} AND wc.warehouse_id = {$this->post['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wis.manufacturer ASC") as $manufacturer): ?>
                            <?php // if(empty($the_manufacturer)) $the_manufacturer = $manufacturer->id; ?>
                            <option value="<?= $manufacturer->id ?>" ><?= $manufacturer->manufacturer ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <!-- Cost -->
                <td>
                    <select id="price_id_input_<?= $this->i ?>" class="<?= $classes['form-select'] ?> costs" data-i="<?= $this->i ?>" data-item_name="<?= $row->item_name_id ?>">
                        <?php if($this->post['default']): ?>
                            <option value="" >Стоимость будет выбрана автоматически</option>
                        <?php endif; ?>
                        <?php foreach ($db->query("SELECT DISTINCT wc.item_price FROM $this->table wc WHERE wc.branch_id = {$this->post['branch_id']} AND wc.warehouse_id = {$this->post['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wc.item_price ASC") as $price): ?>
                            <?php // if(empty($the_cost)) $the_cost = $price->item_price; ?>
                            <option value="<?= $price->item_price ?>" ><?= number_format($price->item_price) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <!-- Max qty -->
                <td class="text-center">
                    <span id="max_qty_input_<?= $this->i ?>">
                        <?php
                        $the_where = "item_name_id = $row->item_name_id";
                        $max_qty = $db->query("SELECT SUM(item_qty) FROM $this->table WHERE branch_id = {$this->post['branch_id']} AND warehouse_id = {$this->post['warehouse_id']} AND item_die_date > CURRENT_DATE() AND $the_where")->fetchColumn();
                        $applications = $db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE branch_id = {$this->post['branch_id']} AND $the_where")->fetchColumn();
                        echo $max_qty - $applications;
                        ?>
                    </span>
                </td>

                <!-- Qty -->
                <td style="width:70px;">
                    <input type="number" id="qty_input_<?= $this->i ?>" class="form-control counts" value="1" min="1" max="<?= $max_qty ?>">
                </td>

                <!-- Buttons -->
                <td>
                    <button onclick="SelectProduct(this, <?= $this->i ?>)" type="button" class="btn btn-sm btn-outline bg-teal border-teal text-teal btn-icon rounded-round legitRipple">
                        <i class="icon-plus2"></i>
                    </button>
                </td>

            </tr>
            <?php
        }

        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                FormLayouts.init();
            });

            $(".manufacturers").change(function() {
                var index = this.dataset.i;
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(2, __CLASS__) ?>",
                    data: {
                        branch_id: <?= $this->post['branch_id'] ?>,
                        warehouse_id: <?= $this->post['warehouse_id'] ?>,
                        item_name_id: this.dataset.item_name,
                        manufacturer_id: this.value,
                    },
                    success: function (result) {
                        var data = JSON.parse(result);
                        var options = `
                        <?php if($this->post['default']): ?>
                            <option value="" >Стоимость будет выбрана автоматически</option>
                        <?php endif; ?>
                        `;

                        for (let i = 0; i < data.price.length; i++) {
                            var element = data.price[i];
                            options += `<option value="${element.item_price}" >${number_format(element.item_price)}</option>`;
                        }
                        document.querySelector('#price_id_input_'+index).innerHTML = options;
                        document.querySelector('#max_qty_input_'+index).innerHTML = data.max_qty;
                    },
                });
            });

            $(".costs").change(function() {
                var index = this.dataset.i;
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(2, __CLASS__) ?>",
                    data: {
                        branch_id: <?= $this->post['branch_id'] ?>,
                        warehouse_id: <?= $this->post['warehouse_id'] ?>,
                        item_name_id: this.dataset.item_name,
                        manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                        item_price: this.value,
                    },
                    success: function (result) {
                        var data = JSON.parse(result);
                        document.querySelector('#max_qty_input_'+index).innerHTML = data.max_qty;
                    },
                });
            });

        </script>
        <?php
    }

    public function ajax_control(array $data)
    {
        global $db;
        $m = ( isset($data['manufacturer_id']) and $data['manufacturer_id'] ) ? " AND wc.item_manufacturer_id = ".$data['manufacturer_id'] : null;
        $s = ( isset($data['item_price']) and $data['item_price'] ) ? " AND wc.item_price = ".$data['item_price'] : null;

        $price_result = $db->query("SELECT DISTINCT wc.item_price FROM $this->table wc WHERE wc.branch_id = {$data['branch_id']} AND wc.warehouse_id = {$data['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = {$data['item_name_id']} $m $s ORDER BY wc.item_price ASC")->fetchAll();
        $qty_max = $db->query("SELECT SUM(wc.item_qty) FROM $this->table wc WHERE wc.branch_id = {$data['branch_id']} AND wc.warehouse_id = {$data['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = {$data['item_name_id']} $m $s")->fetchColumn(); 
        $qty_applications = $db->query("SELECT SUM(wc.item_qty) FROM $this->_applications wc WHERE wc.branch_id = {$data['branch_id']} AND wc.warehouse_id = {$data['warehouse_id']} AND wc.item_name_id = {$data['item_name_id']} $m $s")->fetchColumn();
        $qty = $qty_max - $qty_applications;
        echo json_encode(array('price' => $price_result, 'max_qty' => $qty));
    }

    public function transaction($app)
    {
        global $db, $session;
        if (!$app->item_manufacturer_id) $this->error("Выберите производителя!");

        $this->where = "branch_id = $app->branch_id AND item_die_date > CURRENT_DATE() AND item_name_id = $app->item_name_id";
        if ($app->warehouse_id == "order") {
            $table = $this->_oreders;
            $this->where .= " AND item_manufacturer_id = $app->item_manufacturer_id";
            $item = $db->query("SELECT * FROM $table WHERE $this->where ORDER BY item_die_date ASC")->fetch();
            $qty_sold = $item['item_qty'] - $app->item_qty;
        } else {
            $table = $this->table;
            $this->where .= " AND warehouse_id = $app->warehouse_id AND item_manufacturer_id = $app->item_manufacturer_id AND item_price = $app->item_price";
            if (!$app->item_price) $this->error("Выберите стоимость!");
            $item = $db->query("SELECT * FROM $table WHERE $this->where ORDER BY item_die_date ASC, item_price ASC")->fetch();
            $qty_sold = $item['item_qty'] - $app->item_qty;
        }
        if ($qty_sold > 0) {

            // Update
            Mixin\update($table, array('item_qty' => $qty_sold), $item['id']);
            Mixin\insert($this->_bypass_transactions, array(
                'branch_id' => $app->branch_id,
                'visit_id' => $app->visit_id,
                'responsible_id' => $session->session_id,
                'client_id' => $app->client_id,
                'item_name' => $db->query("SELECT name FROM warehouse_item_names WHERE id = $app->item_name_id")->fetchColumn(),
                'item_manufacturer' => $db->query("SELECT manufacturer FROM warehouse_item_manufacturers WHERE id = $app->item_manufacturer_id")->fetchColumn(),
                'item_qty' => $app->item_qty,
                'item_cost' => ($app->warehouse_id == "order") ? 0 : $item['item_price'],
                'price' => ($app->warehouse_id == "order") ? 0 : ($item['item_price'] * $app->item_qty),
            ));

        }elseif ($qty_sold == 0) {
            // Delete
            Mixin\delete($table, $item['id']);
            Mixin\insert($this->_bypass_transactions, array(
                'branch_id' => $app->branch_id,
                'visit_id' => $app->visit_id,
                'responsible_id' => $session->session_id,
                'client_id' => $app->client_id,
                'item_name' => $db->query("SELECT name FROM warehouse_item_names WHERE id = $app->item_name_id")->fetchColumn(),
                'item_manufacturer' => $db->query("SELECT manufacturer FROM warehouse_item_manufacturers WHERE id = $app->item_manufacturer_id")->fetchColumn(),
                'item_qty' => $app->item_qty,
                'item_cost' => ($app->warehouse_id == "order") ? 0 : $item['item_price'],
                'price' => ($app->warehouse_id == "order") ? 0 : ($item['item_price'] * $app->item_qty),
            ));

        }else{
            // Convert
            $this->error("Требуемое количество превышает имеющиеся!");
        }
        $this->success();
    }

    public function empty_result()
    {
        ?>
        <tr class="table-secondary">
            <th class="text-center" colspan="6">Нет данных</th>
        </tr>
        <?php
    }

    public function error($message)
    {
        echo json_encode(array('status' => "error", 'message' => $message));
        exit;
    }

    public function success()
    {
        echo json_encode(array('status' => "success"));
        exit;
    }
}
        
?>