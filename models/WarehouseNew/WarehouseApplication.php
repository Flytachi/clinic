<?php

use function Mixin\error;

class WarehouseApplication extends Model
{
    public $table = 'warehouse_storage_applications';
    public $warehouses = 'warehouses';
    public $storage = 'warehouses';

    public function get_or_404(int $pk)
    {
        $this->set_post($_POST);
        if($pk == 1) $this->frame();
    }

    public function panel($storage_from = null, $storage_in = null)
    {
        global $classes, $db;
        ?>
        <div class="row">
            <div class="col-md-4 offset-md-2">
                <label>Склад (с):</label>
                <select data-placeholder="Выберите склад" id="storege_from" class="<?= $classes['form-select'] ?>" onchange="CheckPks()" required>
                    <option></option>
                    <?php foreach($db->query("SELECT * FROM $this->warehouses WHERE is_active IS NOT NULL") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?= ($storage_from and $storage_from == $row['id']) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Склад (на):</label>
                <select data-placeholder="Выберите склад" id="storege_in" class="<?= $classes['form-select'] ?>" onchange="CheckPks()" required>
                    <option></option>
                    <?php foreach($db->query("SELECT * FROM $this->warehouses WHERE is_active IS NOT NULL") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?= ($storage_in and $storage_in == $row['id']) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div id="panel-frame" class="mt-4"></div>
        <script type="text/javascript">

            function CheckPks(){
                var sFrom = document.querySelector("#storege_from").value;
                var sIn = document.querySelector("#storege_in").value;
                if (sFrom && sIn) {
                    $.ajax({
                        type: "POST",
                        url: "<?= up_url(1, __CLASS__) ?>",
                        data: {
                            warehouse_id_from: sFrom, 
                            warehouse_id_in: sIn,
                        },
                        success: function (result) {
                            $('#panel-frame').html(result);
                        },
                    });
                }
            }
            <?php if($storage_from and $storage_in) echo "CheckPks()"; ?>

        </script>
        <?php
    }

    public function frame()
    {
        global $session, $classes;
        ?>
        <div class="form-group-feedback form-group-feedback-right">

            <input type="text" class="<?= $classes['input-product_search'] ?>" id="panel-search_input_product" placeholder="Поиск..." title="Введите название препарата">
            <div class="form-control-feedback">
                <i class="icon-search4 font-size-base text-muted"></i>
            </div>

        </div>

        <div class="form-group">

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
                    <tbody id="panel-items">

                    </tbody>
                </table>
            </div>

        </div>
        <script type="text/javascript">

            $("#panel-search_input_product").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'WarehouseStoragePanel') ?>",
                    data: {
                        warehouse_id_from: <?= $this->post['warehouse_id_from'] ?>,
                        warehouse_id_in: <?= $this->post['warehouse_id_in'] ?>,
                        default: true,
                        search: this.value, 
                    },
                    success: function (result) {
                        $('#panel-items').html(result);
                    },
                });
            });

            function SelectProduct(btn, index) {
                btn.disabled = true;

                var data = {
                    model: "<?= __CLASS__ ?>",
                    warehouse_id_from: <?= $this->post['warehouse_id_from'] ?>,
                    warehouse_id_in: <?= $this->post['warehouse_id_in'] ?>,
                    responsible_id: <?= $session->session_id ?>,
                    item_name_id: document.querySelector('#name_id_input_'+index).value,
                    item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                    item_price: document.querySelector('#price_id_input_'+index).value,
                    item_qty: document.querySelector('#qty_input_'+index).value,
                    status: 1,
                };

                $.ajax({
                    type: "POST",
                    url: "<?= add_url() ?>",
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
    }

    public function clean()
    {
        global $db;
        if ($this->post['item_manufacturer_id'] and !$this->post['item_price']) {
            $count = $db->query("SELECT * FROM warehouse_storage WHERE warehouse_id = {$this->post['warehouse_id_from']} AND item_name_id = {$this->post['item_name_id']} AND item_manufacturer_id = {$this->post['item_manufacturer_id']}")->fetchAll();
            if (count($count) == 1) $this->post['item_price'] = $count[0]['item_price'];
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo json_encode(array(
            'status' => 'success', 
        ));
        exit;
    }

    public function error($message)
    {
        echo json_encode(array(
            'status' => "error", 
            'message' => $message
        ));
        exit;
    }
}
        
?>