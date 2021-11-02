<?php

class VisitPanel extends VisitModel
{
    public $table = 'visits';
    public $_client = 'clients';

    public function get_or_404(int $pk)
    {
        global $db;
        if (permission([21,23])) {
            $object = $db->query("SELECT * FROM $this->_client WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
            if($object){

                if ($_GET['form'] == "stationar") {
                    
                    if ($object['status']) {
                        Mixin\error('report_permissions_false');
                        exit;
                    }

                }else {

                    if ($object['status'] and $db->query("SELECT id FROM $this->table WHERE client_id = $pk AND completed IS NULL AND direction IS NOT NULL")->fetchColumn()) {
                        Mixin\error('report_permissions_false');
                        exit;
                    }
                    $this->visit_pk = $db->query("SELECT id FROM $this->table WHERE client_id = $pk AND completed IS NULL")->fetchColumn();
                    if ( $this->visit_pk ) {
                        $this->order_data = $db->query("SELECT * FROM visit_orders WHERE visit_id = $this->visit_pk")->fetch();
                    }

                }

                $this->set_post($object);
                return $this->{$_GET['form']}($object['id']);
                
            }else{
                Mixin\error('report_permissions_false');
                exit;
            }
        } else {
            Mixin\error('report_permissions_false');
            exit;
        }
        
        

    }

    public function ambulator($pk = null)
    {
        global $db, $classes, $session;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h5 class="modal-title">Назначить амбулаторное лечение</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">
        
            <div class="modal-body">

                <input type="hidden" name="model" value="<?= get_parent_class($this) ?>">
                <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
                <input type="hidden" name="route_id" value="<?= $session->session_id ?>">
                <input type="hidden" name="client_id" value="<?= $pk ?>">

                <div class="form-group row">

                    <div class="col-md-8">

                        <div class="mb-3">

                            <div class="table-responsive">
                                <table class="table table-hover table-sm table-bordered">
                                    <tbody class="bg-<?= ($this->value('status')) ? 'danger' : 'success' ?>">
                                        <tr>
                                            <th style="width:50%" colspan="2">Статус:</th>
                                            <th style="width:50%" colspan="2"><?= ($this->value('status')) ? 'Лечится' : 'Свободен' ?></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm table-bordered">
                                    <tbody class="bg-secondary">
                                        <tr>
                                            <th style="width:150px">ID:</th>
                                            <td><?= addZero($pk) ?></td>

                                            <th style="width:150px">Пол:</th>
                                            <td><?= ($this->value('gender')) ? "Мужской" : "Женский" ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width:150px">FIO:</th>
                                            <td><?= get_full_name($pk) ?></td>

                                            <th style="width:150px">Дата рождения:</th>
                                            <td><?= date_f($this->value('birth_date')) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="form-group">
                            <label>Направитель:</label>
                            <select data-placeholder="Выберите направителя" name="guide_id" class="<?= $classes['form-select'] ?>">
                                <option></option>
                                <?php foreach ($db->query("SELECT * FROM guides ORDER BY name") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div class="col-md-4">

                        <?php if( isset($this->order_data) and $this->order_data ): ?>
                            <div class="<?= $classes['card'] ?>">

                                <div class="<?= $classes['card-header'] ?>">
                                    <h6 class="card-title">Ордер</h6>
                                </div>

                                <div class="card-body">

                                    <div class="form-group row">

                                        <div class="col-md-6">
                                            <label>Дата выдачи:</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                                </span>
                                                <input type="date" value="<?= $this->order_data['order_date'] ?>" class="form-control daterange-single" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Номер ордера:</label>
                                            <input type="number" value="<?= $this->order_data['order_number'] ?>" class="form-control" placeholder="Введите номер ордера" readonly>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label>Кем выдан:</label>
                                        <input type="text" value="<?= $this->order_data['order_author'] ?>" class="form-control" placeholder="Введите имя" readonly>
                                    </div>

                                </div>

                            </div> 
                        <?php else: ?>
                            <div class="form-check form-check-switchery form-check-switchery-double">
                                <label class="form-check-label">
                                    <input type="checkbox" name="order_status" class="swit" onclick="Checkert(this)">
                                    Ордер
                                </label>
                            </div>

                            <div class="<?= $classes['card'] ?>" id="order_card" style="display:none;">

                                <div class="<?= $classes['card-header'] ?>">
                                    <h6 class="card-title">Ордер</h6>
                                </div>

                                <div class="card-body">

                                    <div class="form-group row">

                                        <div class="col-md-6">
                                            <label>Дата выдачи:</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                                </span>
                                                <input type="date" name="order[order_date]" class="form-control daterange-single order_inputs" disambled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Номер ордера:</label>
                                            <input type="number" name="order[order_number]" class="form-control order_inputs" placeholder="Введите номер ордера" disambled>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label>Кем выдан:</label>
                                        <input type="text" name="order[order_author]" class="form-control order_inputs" placeholder="Введите имя" disambled>
                                    </div>

                                </div>

                            </div> 
                        <?php endif; ?>

                    </div>

                </div>

                <div class="form-group">
                    <label>Отделы</label>
                    <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="<?= $classes['form-multiselect'] ?>" onchange="TableChangeServices(this)" required>
                        <optgroup label="Врачи">
                            <?php foreach ($db->query("SELECT * FROM divisions WHERE branch_id = $session->branch AND level = 11") as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                        <?php if(module('module_diagnostic')): ?>
                            <optgroup label="Диогностика">
                                <?php foreach ($db->query("SELECT * FROM divisions WHERE branch_id = $session->branch AND level = 12 AND (assist IS NULL OR assist = 1)") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                        <?php if(module('module_laboratory')): ?>
                            <optgroup label="Лаборатория">
                                <?php foreach ($db->query("SELECT * FROM divisions WHERE branch_id = $session->branch AND level = 13") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                        <?php if(module('module_physio')): ?>
                            <optgroup label="Физиотерапия">
                                <?php foreach ($db->query("SELECT * FROM divisions WHERE branch_id = $session->branch AND level = 14") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group-feedback form-group-feedback-right row">

                    <div class="col-md-11">
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input_service" placeholder="Поиск..." title="Введите назване отдела или услуги">
                        <div class="form-control-feedback">
                            <i class="icon-search4 font-size-base text-muted"></i>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                                <span class="ladda-label">Отправить</span>
                                <span class="ladda-spinner"></span>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="form-group">

                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="bg-dark">
                                    <th>#</th>
                                    <th>Отдел</th>
                                    <th>Услуга</th>
                                    <th>Тип</th>
                                    <th>Cпециалист</th>
                                    <th style="width:100px">Кол-во</th>
                                    <th class="text-right">Цена</th>
                                </tr>
                            </thead>
                            <tbody id="table_form">

                            </tbody>
                        </table>
                    </div>

                </div>
                
            </div>

        </form>

        <div class="modal-footer">
            <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Отмена</button>
        </div>
        <?php
        $this->jquery_init();
        ?>
        <script src="<?= stack("assets/js/custom.js") ?>"></script>
        <script type="text/javascript">
        
            function Checkert(event) {
                if (event.checked) {
                    $('#order_card').show();
                    $('.order_inputs').attr("required", true);
                    $('.order_inputs').attr("disambled", false);
                } else {
                    $('#order_card').hide();
                    $('.order_inputs').attr("required", false);
                    $('.order_inputs').attr("disambled", true);
                }
                $('.order_inputs').val("");
            }

            var service = {};

            $("#search_input_service").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        branch_id: <?= $session->branch ?>,
                        divisions: $("#division_selector").val(),
                        is_foreigner: "<?= $this->value('is_foreigner') ?>",
                        search: this.value,
                        selected: service,
                        types: "1,2",
                        cols: 0
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function TableChangeServices(params) {

                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        branch_id: <?= $session->branch ?>,
                        divisions: $(params).val(),
                        is_foreigner: "<?= $this->value('is_foreigner') ?>",
                        selected: service,
                        types: "1,2",
                        cols: 0
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function stationar($pk = null)
    {
        global $db, $classes, $session;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h5 class="modal-title">Назначить стационарное лечение</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">
        
            <div class="modal-body">

                <input type="hidden" name="model" value="<?= get_parent_class($this) ?>">
                <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
                <input type="hidden" name="route_id" value="<?= $session->session_id ?>">
                <input type="hidden" name="client_id" value="<?= $pk ?>">
                <input type="hidden" name="direction" value="1">

                <div class="form-group row mb-3">

                    <div class="col-md-7">

                        <div class="table-responsive mb-2">
                            <table class="table table-hover table-sm table-bordered">
                                <tbody class="bg-secondary">
                                    <tr>
                                        <th style="width:150px">ID:</th>
                                        <td><?= addZero($pk) ?></td>

                                        <th style="width:150px">Пол:</th>
                                        <td><?= ($this->value('gender')) ? "Мужской" : "Женский" ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:150px">FIO:</th>
                                        <td><?= get_full_name($pk) ?></td>

                                        <th style="width:150px">Дата рождения:</th>
                                        <td><?= date_f($this->value('birth_date')) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label>Направитель:</label>
                            <select data-placeholder="Выберите направителя" name="guide_id" class="<?= $classes['form-select'] ?>">
                                <option></option>
                                <?php foreach ($db->query("SELECT * FROM guides") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Отдел:</label>
                            <select data-placeholder="Выберите отдел" name="division_id" id="division_id" class="<?= $classes['form-select'] ?>" required>
                                <option></option>
                                <?php foreach($db->query("SELECT * FROM divisions WHERE branch_id = $session->branch AND level = 11") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Специалиста:</label>
                            <select data-placeholder="Выберите специалиста" name="responsible_id" id="responsible_id" class="<?= $classes['form-select'] ?>" required>
                                <?php foreach($db->query("SELECT * FROM users WHERE branch_id = $session->branch AND user_level = 11 AND is_active IS NOT NULL") as $row): ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div class="col-md-5">

                        <?php if( isset($this->order_data) and $this->order_data ): ?>
                            <div class="<?= $classes['card'] ?>">

                                <div class="<?= $classes['card-header'] ?>">
                                    <h6 class="card-title">Ордер</h6>
                                </div>

                                <div class="card-body">

                                    <div class="form-group row">

                                        <div class="col-md-6">
                                            <label>Дата выдачи:</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                                </span>
                                                <input type="date" value="<?= $this->order_data['order_date'] ?>" class="form-control daterange-single" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Номер ордера:</label>
                                            <input type="number" value="<?= $this->order_data['order_number'] ?>" class="form-control" placeholder="Введите номер ордера" readonly>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label>Кем выдан:</label>
                                        <input type="text" value="<?= $this->order_data['order_author'] ?>" class="form-control" placeholder="Введите имя" readonly>
                                    </div>

                                </div>

                            </div> 
                        <?php else: ?>
                            <div class="form-check form-check-switchery form-check-switchery-double">
                                <label class="form-check-label">
                                    <input type="checkbox" name="order_status" class="swit" onclick="Checkert(this)">
                                    Ордер
                                </label>
                            </div>

                            <div class="<?= $classes['card'] ?>" id="order_card" style="display:none;">

                                <div class="<?= $classes['card-header'] ?>">
                                    <h6 class="card-title">Ордер</h6>
                                </div>

                                <div class="card-body">

                                    <div class="form-group row">

                                        <div class="col-md-6">
                                            <label>Дата выдачи:</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                                </span>
                                                <input type="date" name="order[order_date]" class="form-control daterange-single order_inputs" disambled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Номер ордера:</label>
                                            <input type="number" name="order[order_number]" class="form-control order_inputs" placeholder="Введите номер ордера" disambled>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label>Кем выдан:</label>
                                        <input type="text" name="order[order_author]" class="form-control order_inputs" placeholder="Введите имя" disambled>
                                    </div>

                                </div>

                            </div> 
                        <?php endif; ?>

                    </div>

                </div>

                <legend><b>Расположение</b></legend>

                <div class="form-group row">

                    <div class="col-md-3">
                        <label>Выбирите здание:</label>
                        <select data-placeholder="Выбрать здание" id="building_id" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT DISTINCT bg.id, bg.name FROM wards w LEFT JOIN buildings bg ON(bg.id=w.building_id) WHERE w.branch_id = $session->branch") as $row): ?>
                                <?php
                                $result = [];
                                foreach ($db->query("SELECT division_id FROM wards WHERE branch_id = $session->branch AND building_id = {$row['id']}") as $value) if(!in_array($value['division_id'], $result)) $result[] = $value['division_id'];
                                ?>
                                <option value="<?= $row['id'] ?>" data-divisions="<?= json_encode($result) ?>"><?= $row['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Выбирите этаж:</label>
                        <select data-placeholder="Выбрать этаж" id="floor" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT DISTINCT bg.id, bg.floors FROM wards w LEFT JOIN buildings bg ON(bg.id=w.building_id) WHERE w.branch_id = $session->branch") as $row): ?>
                                <?php for ($i=1; $i <= $row['floors']; $i++): ?>
                                    <?php
                                    $result = [];
                                    foreach ($db->query("SELECT division_id FROM wards WHERE branch_id = $session->branch AND building_id = {$row['id']} AND floor = $i") as $value) if(!in_array($value['division_id'], $result)) $result[] = $value['division_id'];
                                    ?>
                                    <option value="<?= $i ?>" data-chained="<?= $row['id'] ?>" data-divisions="<?= json_encode($result) ?>" data-ward_qty="<?= $db->query("SELECT * FROM wards WHERE branch_id = $session->branch AND building_id = {$row['id']} AND floor = $i")->rowCount() ?>"><?= $i ?> этаж</option>
                                <?php endfor; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Выбирите палату:</label>
                        <select data-placeholder="Выбрать палату" id="ward_id" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Койка:</label>
                        <select data-placeholder="Выбрать койку" name="bed" id="bed" class="<?= $classes['form-select_price'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT bd.*, bdt.price FROM beds bd LEFT JOIN bed_types bdt ON(bd.type_id=bdt.id) WHERE bd.branch_id = $session->branch") as $row): ?>
                                <?php if ($row['user_id']): ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-name="<?= $row['types'] ?>" disabled><?= $row['bed'] ?> койка (<?= ($db->query("SELECT gender FROM users WHERE id = {$row['user_id']}")->fetchColumn()) ? "Male" : "Female" ?>)</option>
                                <?php else: ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-name="<?= $row['types'] ?>"><?= $row['bed'] ?> койка</option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                
            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Отмена</button>
                <button type="submit" onclick="submitAlert()" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Отправить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>

        <?php
        $this->jquery_init();
        ?>
        <?php if(config('wards_by_division')): ?>
            <script type="text/javascript">

                $('#division_id').change(function(){
                    var building_id = document.querySelector("#building_id");
                    var floor = document.querySelector("#floor");
                    var ward_id = document.querySelector("#ward_id");
                    var divis = document.querySelector("#division_id").value;

                    // buildings
                    var i = 1;
                    Array.prototype.slice.call(building_id.options).forEach(function(item) {

                        if(item.dataset.divisions){
                            var data = JSON.parse(item.dataset.divisions);

                            if(data.includes( Number(divis) )){
                                if(i == 1){
                                    $(building_id).val(item.value).change();
                                    i++;
                                }
                                item.disabled = false;
                            }else{
                                item.disabled = true;
                            }
                            delete data;
                        }
                        
                    });

                    // floor
                    var i = 1;
                    Array.prototype.slice.call(floor.options).forEach(function(item) {

                        if(item.dataset.divisions){
                            var data = JSON.parse(item.dataset.divisions);
                            
                            if(data.includes( Number(divis) ) && item.dataset.ward_qty > 0){
                                if(i == 1){
                                    $(floor).val(item.value).change();
                                    i++;
                                }
                                item.disabled = false;
                            }else{
                                item.disabled = true;
                            }
                            delete data;
                        }

                    });
                    // FormLayouts.init();

                });

            </script>
        <?php endif; ?>
        <script src="<?= stack("assets/js/custom.js") ?>"></script>
        <script type="text/javascript">
            $(function(){
                $("#bed").chained("#ward_id");
                $("#floor").chained("#building_id");
                $("#responsible_id").chained("#division_id");
            });

            $('#building_id').change(function(){
                if(document.querySelector("#floor").value){
                    document.querySelector("#floor").value = "";
                }
            });

            function Checkert(event) {
                if (event.checked) {
                    $('#order_card').show();
                    $('.order_inputs').attr("required", true);
                    $('.order_inputs').attr("disambled", false);
                } else {
                    $('#order_card').hide();
                    $('.order_inputs').attr("required", false);
                    $('.order_inputs').attr("disambled", true);
                }
                $('.order_inputs').val("");
            }

            $('#floor').change(function(){
                var params = this;
                if (params.selectedOptions[0].value) {
                    $.ajax({
                        type: "GET",
                        url: "<?= ajax('options_wards') ?>",
                        data: {
                            branch_id: <?= $session->branch ?>,
                            building_id: params.selectedOptions[0].dataset.chained,
                            division_id: document.querySelector("#division_id").value,
                            floor: params.selectedOptions[0].value,
                        },
                        success: function (result) {
                            if (result.trim() == "<option></option>") {
                                document.querySelector("#ward_id").disabled = true;
                            } else {
                                document.querySelector("#ward_id").disabled = false;
                                document.querySelector("#ward_id").innerHTML = result;
                            }
                        },
                    });
                }else{
                    document.querySelector("#ward_id").disabled = true;
                }
            });

            function submitAlert() {
                let obj = JSON.stringify({ type : 'alert_new_patient',  id : $("#responsible_id").val(), message: "У вас новый стационарный пациент!" });
                conn.send(obj);
            }
        </script>
        <?php
    }

    protected function jquery_init()
    {
        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                FormLayouts.init();
                BootstrapMultiselect.init();
                Swit.init();
            });
        </script>
        <?php
    }
   
}
        
?>