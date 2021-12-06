<?php

use Mixin\Hell;
use Mixin\HellCrud;
use Mixin\Model;

class VisitBypassModel extends Model
{
    public $table = 'visit_bypass';
    public $_visits = 'visits';

    public function get_or_404(int $pk)
    {
        global $db;
        // Visit
        $object = $db->query("SELECT * FROM $this->_visits WHERE id = $pk AND direction IS NOT NULL AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){

            // Bypass
            $this->visit = $object;
            $this->order = $db->query("SELECT * FROM visit_orders WHERE visit_id = $pk")->fetchColumn();
            return $this->{$_GET['form']}($pk);

        }else{
            Hell::error('report_permissions_false');
        }

    }

    public function form($pk = null)
    {
        global $session, $classes, $methods, $db;
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Составить новое назначение</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
                <input type="hidden" name="visit_id" value="<?= $pk ?>">
                <input type="hidden" name="client_id" value="<?= $this->visit['client_id'] ?>">
                <input type="hidden" name="responsible_id" value="<?= $session->session_id ?>">

                <div class="row">

                    <div class="col-4">

                        <div class="form-group">
                            <label>Название назначения:</label>
                            <input type="text" name="name" value="<?= $this->value('name') ?>" class="form-control" placeholder="Введите название назначения" required>
                        </div>

                        <div class="form-group">
                            <label>Метод:</label>
                            <select data-placeholder="Выбрать метод" name="method" class="<?= $classes['form-select'] ?>" required>
                                <option></option>
                                <?php foreach ($methods as $key => $value): ?>
                                    <option value="<?= $key ?>" <?= ($this->value('method') == $key) ? 'selected' : '' ?>><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Описание:</label>
                            <textarea class="form-control" name="description" rows="2" cols="1" placeholder="Описание"><?= $this->value('description') ?></textarea>
                        </div>

                    </div>

                    <div class="col-8">
                        <div class="text-right">
                            <button onclick="AddPreparat()" class="btn btn-outline-success btn-sm legitRipple mb-1" type="button"><i class="icon-plus22 mr-2"></i>Добавить Сторонний Препарат</button>
                        </div>

                        <div class="card">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Препарат</th>
                                            <th class="text-right" style="width:100px">Кол-во</th>
                                        </tr>
                                    </thead>
                                    <tbody id="preparat_div"></tbody>
                                    <tbody id="preparat_div_outside"></tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                
                </div>

                <ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
                    <?php if($this->order): ?>
                        <li class="nav-item"><a href="#" onclick="ChangeWare('order')" class="nav-link legitRipple" data-toggle="tab">Склад бесплатных препаратов</a></li>
                    <?php endif; ?>
                    <?php if( module('pharmacy') and $ware_sett = (new Table($db, "warehouse_settings ws"))->set_data("w.id, w.name")->additions("LEFT JOIN warehouses w ON(w.id=ws.warehouse_id)")->where("ws.division_id = {$this->visit['division_id']} AND w.is_active IS NOT NULL")->get_table() ): ?>
                        <?php foreach ($ware_sett as $ware): ?>
                            <li class="nav-item"><a href="#" onclick="ChangeWare(<?= $ware->id ?>)" class="nav-link legitRipple" data-toggle="tab"><?= $ware->name ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <div class="form-group-feedback form-group-feedback-right row">

                    <div class="col-md-10">
                        <div id="bypass_search_input" style="display:none;">
                            <input type="text" class="<?= $classes['input-product_search'] ?>" id="search_input_product" placeholder="Поиск..." title="Введите название препарата">
                            <div class="form-control-feedback">
                                <i class="icon-search4 font-size-base text-muted"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                                <span class="ladda-label">Сохранить</span>
                                <span class="ladda-spinner"></span>
                            </button>
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
                        warehouse_id: 'order',
                        item_name: document.querySelector('#name_input_'+index).innerHTML,
                        item_name_id: document.querySelector('#name_id_input_'+index).value,
                        item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                        item_price: 0,
                        item_qty: document.querySelector('#qty_input_'+index).value,
                    };
                } else {
                    var data = {
                        warehouse_id: warehouse,
                        item_name: document.querySelector('#name_input_'+index).innerHTML,
                        item_name_id: document.querySelector('#name_id_input_'+index).value,
                        item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                        item_price: document.querySelector('#price_id_input_'+index).value,
                        item_qty: document.querySelector('#qty_input_'+index).value,
                    };
                }

                AddPreparat(data);

                $(`#Item_${index}`).css("background-color", "rgb(70, 200, 150)");
                $(`#Item_${index}`).css("color", "black");
                $(`#Item_${index}`).fadeOut(900, function() {
                    $(this).remove();
                });
            }

            function AddPreparat(data) {
                if(data){
                    $('#preparat_div_outside').append(`
                    <tr class="table-secondary" id="preparat_outside_tr-${s}">
                        <td>
                            <div class="form-group-feedback form-group-feedback-right">
                                <input type="hidden" name="items[${s}][warehouse_id]" value="${data.warehouse_id}">
                                <input type="hidden" name="items[${s}][item_name_id]" value="${data.item_name_id}">
                                <input type="hidden" name="items[${s}][item_manufacturer_id]" value="${data.item_manufacturer_id}">
                                <input type="hidden" name="items[${s}][item_price]" value="${data.item_price}">
                                <input class="form-control" type="text" value="${data.item_name}" readonly style="border-width: 0px 0; padding: 0.2rem 0;">
                                <div class="form-control-feedback text-danger">
                                    <i class="icon-minus-circle2" onclick="$('#preparat_outside_tr-${s}').remove();"></i>
                                </div>
                            </div>
                        </td>
                        <td class="text-right">
                            <input type="number" class="form-control" readonly name="items[${s}][item_qty]" value="${data.item_qty}" min="1" style="border-width: 0px 0; padding: 0.2rem 0;" required>
                        </td>
                    </tr>`);
                }else{
                    $('#preparat_div_outside').append(`
                    <tr class="table-secondary" id="preparat_outside_tr-${s}">
                        <td>
                            <div class="form-group-feedback form-group-feedback-right">
                                <input class="form-control" type="text" name="items[${s}][item_name]" required style="border-width: 0px 0; padding: 0.2rem 0;">
                                <div class="form-control-feedback text-danger">
                                    <i class="icon-minus-circle2" onclick="$('#preparat_outside_tr-${s}').remove();"></i>
                                </div>
                            </div>
                        </td>
                        <td class="text-right">
                            <input type="number" class="form-control" name="items[${s}][item_qty]" value="1" min="1" style="border-width: 0px 0; padding: 0.2rem 0;" required>
                        </td>
                    </tr>`);
                }
                s++;
            }

        </script>
        <?php
        if ($pk) $this->jquery_init();
    }

    public function clean()
    {
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
        if ($this->post['items']) $this->post['items'] = json_encode($this->post['items']);
        return True;
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render();
    }
}
        
?>