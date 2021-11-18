<?php

class VisitBypassEventTransactionModel extends Model
{
    public $table = 'visit_bypass_event_transactions';

    public function form($pk = null)
    {
        global $classes, $db, $session;
        $patient = json_decode($_GET['patient']);
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Добавить расходник</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="direction" value="<?= $patient->direction ?>">
                <input type="hidden" name="user_id" value="<?= $patient->id ?>">

                <ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
                    <?php if( module('pharmacy') ): ?>
                        <?php
                        $warehouses = (new Table($db, "warehouse_setting_applications wsa"))->set_data("w.id, w.name")->additions("LEFT JOIN warehouses w ON(w.id=wsa.warehouse_id)")->where("wsa.division_id = $session->session_division AND w.is_active IS NOT NULL");
                        ?>
                        <?php foreach ($warehouses->get_table() as $ware): ?>
                            <li class="nav-item"><a href="#" onclick="ChangeWare(<?= $ware->id ?>)" class="nav-link legitRipple" data-toggle="tab"><?= $ware->name ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <div class="form-group" id="panel-frame"></div>

            </div>

        </form>
        <script type="text/javascript">
            var warehouse = null;

            function ChangeWare(params) {
                
                if (params) {
                    $.ajax({
                        type: "POST",
                        url: "<?= up_url(1, 'WarehouseApplication') ?>",
                        data: {
                            warehouse_id_from: params,
                            status: 1,
                        },
                        success: function (result) {
                            document.querySelector("#panel-frame").innerHTML = result;
                        },
                    });
                }
                
                warehouse = params;
            }

            function __WarehouseApplication__search(input){
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'WarehouseStoragePanel') ?>",
                    data: {
                        warehouse_id_from: warehouse,
                        default: true,
                        search: input.value, 
                    },
                    success: function (result) {
                        $('#panel-items').html(result);
                    },
                });
            }

            function __WarehouseStoragePanel__select(btn, index) {
                btn.disabled = true;

                $.ajax({
                    type: "POST",
                    url: "<?= add_url() ?>",
                    data: {
                        model: "<?= __CLASS__ ?>",
                        visit_id: <?= $patient->visit_id ?>,
                        user_id: <?= $patient->id ?>,
                        warehouse_id: warehouse,
                        item_name_id: document.querySelector('#name_id_input_'+index).value,
                        item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                        item_price: document.querySelector('#price_id_input_'+index).value,
                        item_qty: document.querySelector('#qty_input_'+index).value,
                    },
                    success: function (result) {
                        console.log(result);
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

    public function save()
    {
        $this->error("Требуемое доработка!");
        //
        $this->where = "warehouse_id = {$this->post['warehouse_id']} AND item_die_date > CURRENT_DATE() AND item_name_id = {$this->post['item_name_id']}";
        $table = $this->table;
        $this->where .= " AND warehouse_id = $app->warehouse_id AND item_manufacturer_id = $app->item_manufacturer_id AND item_price = $app->item_price";
        if (!$app->item_price) $this->error("Выберите стоимость!");
        $item = $db->query("SELECT * FROM $table WHERE $this->where ORDER BY item_die_date ASC, item_price ASC")->fetch();
        $qty_sold = $item['item_qty'] - $app->item_qty;

        if ($qty_sold > 0) {

            // Update
            Mixin\update($table, array('item_qty' => $qty_sold), $item['id']);
            Mixin\insert($this->_bypass_transactions, array(
                'visit_id' => $app->visit_id,
                'responsible_id' => $session->session_id,
                'user_id' => $app->user_id,
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
                'visit_id' => $app->visit_id,
                'responsible_id' => $session->session_id,
                'user_id' => $app->user_id,
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