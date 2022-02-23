<?php

use Mixin\ModelOld;

class VisitBypassModel extends ModelOld
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
            Mixin\error('report_permissions_false');
        }

    }

    public function form($pk = null)
    {
        global $session, $classes, $db;
        importModel('Method');
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Составить новое назначение</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="visit_id" value="<?= $pk ?>">
                <input type="hidden" name="user_id" value="<?= $this->visit['user_id'] ?>">
                <input type="hidden" name="parent_id" value="<?= $session->session_id ?>">

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
                                <?php foreach ((new Method)->Where('is_active IS NOT NULL')->list() as $row): ?>
                                    <option value="<?= $row->id ?>" <?= ($this->value('method') == $row->id) ? 'selected' : '' ?>><?= $row->name ?></option>
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
                    <?php if( module('pharmacy') ): ?>
                        <?php
                        $warehouses = (new Table($db, "warehouse_setting_applications wsa"))->set_data("w.id, w.name")->additions("LEFT JOIN warehouses w ON(w.id=wsa.warehouse_id)")->where("wsa.division_id = {$this->visit['division_id']} AND w.is_active IS NOT NULL");
                        ?>
                        <?php foreach ($warehouses->get_table() as $ware): ?>
                            <li class="nav-item"><a href="#" onclick="ChangeWare(<?= $ware->id ?>)" class="nav-link legitRipple" data-toggle="tab"><?= $ware->name ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <div class="form-group-feedback form-group-feedback-right row">

                    <!-- <div class="col-md-10">
                        <div id="bypass_search_input" style="display:none;">
                            <input type="text" class="<?= $classes['input-product_search'] ?>" id="search_input_product" placeholder="Поиск..." title="Введите название препарата">
                            <div class="form-control-feedback">
                                <i class="icon-search4 font-size-base text-muted"></i>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-2">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                                <span class="ladda-label">Сохранить</span>
                                <span class="ladda-spinner"></span>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="form-group" id="panel-frame"></div>

            </div>

        </form>
        <script type="text/javascript">
            var s = 0;
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

                var data = {
                    warehouse_id: warehouse,
                    item_name: document.querySelector('#name_input_'+index).innerHTML,
                    item_name_id: document.querySelector('#name_id_input_'+index).value,
                    item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                    item_price: document.querySelector('#price_id_input_'+index).value,
                    item_qty: document.querySelector('#qty_input_'+index).value,
                };
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
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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