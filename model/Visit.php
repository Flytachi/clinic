<?php

use Mixin\Hell;
use Mixin\HellCrud;
use Mixin\Model;

class Visit extends Model
{
    use ResponceRender;
    public $table = 'visits';
    public $tBed = 'beds';
    public $tPatient = 'patients';
    public $tBedType = 'bed_types';
    public $tService = 'services';
    public $tDivision = 'divisions';
    public $tStatus = 'visit_status';
    public $tVisitService = 'visit_services';
    public $tVisitServiceTransaction = 'visit_service_transactions';
    public $tVisitApplication = 'visit_applications';
    public $tVisitInitial = "visit_initial";
    public $tVisitBed = 'visit_beds';

    public function Axe()
    {
        if ($this->getGet('type') == "ajax") return $this->ajax();

        importModel('Patient', 'VisitStatus');
        if (permission([2,32]) and $obj = (new Patient)->byId($this->getGet('patient_id'))) {

            $this->visit = $this->Where("patient_id=$obj->id AND completed IS NULL")->get('id', 'direction');
            if ($this->getGet('type') == "stationar" and $obj->status) Hell::error('report_permissions_false');
            if( $this->visit ) {
                if ( $this->visit->direction ) Hell::error('report_permissions_false');
                $this->status_data = (new VisitStatus)->Where("visit_id=" . $this->visit->id)->get();
            }
            $this->setPost($obj);
            return $this->{$this->getGet('type')}();

        } else Hell::error('report_permissions_false');

    }

    public function ambulator()
    {
        global $classes, $session;
        importModel('VisitType');
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h5 class="modal-title">Назначить амбулаторное лечение</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= $this->urlHook() ?>">
        
            <div class="modal-body">

                <?php $this->csrfToken(); ?>
                <input type="hidden" name="route_id" value="<?= $session->session_id ?>">
                <input type="hidden" name="patient_id" value="<?= $this->value('id') ?>">

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
                                            <td><?= addZero($this->value('id')) ?></td>

                                            <th style="width:150px">Пол:</th>
                                            <td><?= ($this->value('gender')) ? "Мужской" : "Женский" ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width:150px">FIO:</th>
                                            <td><?= patient_name($this->getPost()) ?></td>

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
                                <?php foreach ($this->db->query("SELECT * from guides ORDER BY name") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">
                            <label>Тип визита:</label>
                            <?php if(isset($this->status_data) and $this->status_data): ?>
                                <input type="text" class="form-control" value="<?= $this->status_data->name ?>" readonly>
                            <?php else: ?>
                                <select data-placeholder="Выберите тип" name="status_is" class="<?= $classes['form-select'] ?>">
                                    <option></option>
                                    <?php foreach ((new VisitType)->Where("is_ambulator IS NOT NULL")->list() as $row): ?>
                                        <option value="<?= $row->id ?>" ><?= $row->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>

                        <?php /* ?>
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
                                            <input type="date" class="form-control daterange-single order_inputs" disambled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Номер ордера:</label>
                                        <input type="number" class="form-control order_inputs" placeholder="Введите номер ордера" disambled>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label>Кем выдан:</label>
                                    <input type="text" class="form-control order_inputs" placeholder="Введите имя" disambled>
                                </div>

                            </div>

                        </div>
                        <?php */ ?>

                    </div>

                </div>

                <div class="form-group">
                    <label>Отделы</label>
                    <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="<?= $classes['form-multiselect'] ?>" onchange="TableChangeServices(this)" required>
                        <optgroup label="Врачи">
                            <?php foreach ($this->db->query("SELECT * FROM divisions WHERE level = 5") as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                        <?php if(module('module_diagnostic')): ?>
                            <optgroup label="Диогностика">
                                <?php foreach ($this->db->query("SELECT * FROM divisions WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                        <?php if(module('module_laboratory')): ?>
                            <optgroup label="Лаборатория">
                                <?php foreach ($this->db->query("SELECT * FROM divisions WHERE level = 6") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                        <?php if(module('module_physio')): ?>
                            <optgroup label="Физиотерапия">
                                <?php foreach ($this->db->query("SELECT * FROM divisions WHERE level = 12") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                        <optgroup label="Остальные">
                            <?php /* foreach ($PERSONAL as $key => $value): ?>
                                <?php if(in_array($key, [13])): ?>
                                    <option value="other_<?= $key ?>"><?= $value ?></option>
                                <?php endif; ?>
                            <?php endforeach;*/ ?>
                        </optgroup>
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
        <script src="<?= stack("assets/js/custom.js") ?>"></script>
        <script type="text/javascript">

            var service = {};

            $("#search_input_service").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
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

            $( document ).ready(function() {
                FormLayouts.init();
                BootstrapMultiselect.init();
                Swit.init();
            });

        </script>
        <?php
    }

    public function stationar()
    {
        global $classes, $session;
        importModel('VisitType');
        if(isset($_GET['application']) and $_GET['application']) $application = $this->db->query("SELECT * FROM visit_applications WHERE id = {$_GET['application']}")->fetch();
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h5 class="modal-title">Назначить стационарное лечение</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= $this->urlHook() ?>">
        
            <div class="modal-body">

                <?php $this->csrfToken(); ?>
                <input type="hidden" name="route_id" value="<?= $session->session_id ?>">
                <input type="hidden" name="patient_id" value="<?= $this->value('id') ?>">
                <input type="hidden" name="direction" value="1">
                <input type="hidden" name="status" value="1">
                <?php if(isset($application) and $application['id']): ?>
                    <input type="hidden" name="application" value="<?= $application['id'] ?>">
                <?php endif; ?>

                <div class="form-group row mb-3">

                    <div class="col-md-7">

                        <div class="table-responsive mb-2">
                            <table class="table table-hover table-sm table-bordered">
                                <tbody class="bg-secondary">
                                    <tr>
                                        <th style="width:150px">ID:</th>
                                        <td><?= addZero($this->value('id')) ?></td>

                                        <th style="width:150px">Пол:</th>
                                        <td><?= ($this->value('gender')) ? "Мужской" : "Женский" ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:150px">FIO:</th>
                                        <td><?= patient_name($this->getPost()) ?></td>

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
                                <?php foreach ($this->db->query("SELECT * FROM guides") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Отдел:</label>
                            <select data-placeholder="Выберите отдел" name="division_id" id="division_id" class="<?= $classes['form-select'] ?>" required>
                                <option></option>
                                <?php $sql = "SELECT d.id, d.title, COUNT(b.id) FROM divisions d JOIN wards w ON(w.division_id=d.id) JOIN beds b ON(b.ward_id=w.id) WHERE d.level = 5 AND b.patient_id IS NULL GROUP BY d.id"; ?>
                                <?php foreach($this->db->query($sql) as $row): ?>
                                    <option value="<?= $row['id'] ?>" <?php if(isset($application) and $row['id'] == $application['division_id']) echo "selected" ?>><?= $row['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group" id="parent_area"></div>

                    </div>

                    <div class="col-md-5">

                        <div class="form-group">
                            <label>Тип визита:</label>
                            <?php if(isset($this->status_data) and $this->status_data): ?>
                                <input type="text" class="form-control" value="<?= $this->status_data->name ?>" readonly>
                            <?php else: ?>
                                <select data-placeholder="Выберите тип" name="status_is" class="<?= $classes['form-select'] ?>">
                                    <option></option>
                                    <?php foreach ((new VisitType)->Where("is_stationar IS NOT NULL")->list() as $row): ?>
                                        <option value="<?= $row->id ?>" ><?= $row->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>

                        <div class="<?= $classes['card'] ?>">

                            <div class="<?= $classes['card-header'] ?>">
                                <h6 class="card-title">Данные при поступлении</h6>
                            </div>

                            <div class="card-body">

                                <div class="form-group row">

                                    <div class="col-md-4">
                                        <label>Вес:</label>
                                        <div class="form-group form-group-feedback form-group-feedback-right">
                                            <input type="number" name="initial[weight]" class="form-control" placeholder="Введите вес" step="0.1" min="0" max="300">
                                            <div class="form-control-feedback">Кг</div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Рост:</label>
                                        <div class="form-group form-group-feedback form-group-feedback-right">
                                            <input type="number" name="initial[height]" class="form-control" placeholder="Введите рост" step="0.1" min="0" max="500">
                                            <div class="form-control-feedback">См</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Температура:</label>
                                        <div class="form-group form-group-feedback form-group-feedback-right">
                                            <input type="number" name="initial[temperature]" class="form-control" placeholder="Введите температуру" step="0.1" min="30" max="45">
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                        
                    </div>

                </div>

                <legend><b>Расположение</b></legend>

                <div class="form-group row">

                    <div class="col-md-3" id="building_area"></div>
                    <div class="col-md-3" id="floor_area"></div>
                    <div class="col-md-3" id="ward_area"></div>
                    <div class="col-md-3" id="bed_area"></div>

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

        <script src="<?= stack("assets/js/custom.js") ?>"></script>
        <script type="text/javascript">
            $("#division_id").on("change", () => changeDivision());

            function changeDivision(){
                var division = document.querySelector("#division_id").value;
                $.ajax({
                    type: "GET",
                    url: "<?= Hell::apiAxe('Visit', array('type' => 'ajax')) ?>",
                    data: { division },
                    success: (response) => {
                        document.querySelector("#building_area").innerHTML = response;
                        $("#building_id").on("change", () => changeBuilding());
                        changeBuilding();
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('options/getParent') ?>",
                    data: { division },
                    success: (response) => {
                        document.querySelector("#parent_area").innerHTML = response;
                    }
                });
            }

            function changeBuilding(){
                var division = document.querySelector("#division_id").value;
                var building = document.querySelector("#building_id").value;
                $.ajax({
                    type: "GET",
                    url: "<?= Hell::apiAxe('Visit', array('type' => 'ajax')) ?>",
                    data: { division, building },
                    success: (response) => {
                        document.querySelector("#floor_area").innerHTML = response;
                        $("#floor").on("change", () => changeFloor());
                        changeFloor();
                    }
                });
            }

            function changeFloor(){
                var division = document.querySelector("#division_id").value;
                var building = document.querySelector("#building_id").value;
                var floor = document.querySelector("#floor").value;
                $.ajax({
                    type: "GET",
                    url: "<?= Hell::apiAxe('Visit', array('type' => 'ajax')) ?>",
                    data: { division, building, floor },
                    success: (response) => {
                        document.querySelector("#ward_area").innerHTML = response;
                        $("#ward_id").on("change", () => changeWard());
                        changeWard();
                    }
                });
            }

            function changeWard(){
                var division = document.querySelector("#division_id").value;
                var building = document.querySelector("#building_id").value;
                var floor = document.querySelector("#floor").value;
                var ward = document.querySelector("#ward_id").value;
                $.ajax({
                    type: "GET",
                    url: "<?= Hell::apiAxe('Visit', array('type' => 'ajax')) ?>",
                    data: { building, floor, ward },
                    success: (response) => {
                        document.querySelector("#bed_area").innerHTML = response;
                        FormLayouts.init();
                    }
                });
            }

            <?php if(isset($application) and $application['division_id']): ?>
                changeDivision();
            <?php endif; ?>

            $( document ).ready(function() {
                FormLayouts.init();
                BootstrapMultiselect.init();
                Swit.init();
            });
            
        </script>
        <?php
    }

    public function ajax()
    {
        global $classes;

        if ( $this->getGet('ward') ) {
            ?>
            <label>Выбирите койку:</label>
            <select data-placeholder="Выбрать койку" name="bed" id="bed" class="<?= $classes['form-select_price'] ?>" required>
                <?php $sql = "SELECT b.*, bt.price FROM beds b LEFT JOIN bed_types bt ON(b.type_id=bt.id) WHERE b.ward_id = " . $this->getGet('ward'); ?>
                <?php foreach ($this->db->query($sql) as $row): ?>
                    <?php if ($row['patient_id']): ?>
                        <option value="<?= $row['id'] ?>" data-name="<?= $row['types'] ?>" disabled><?= $row['bed'] ?> койка (<?= ($this->db->query("SELECT gender FROM patients WHERE id = {$row['patient_id']}")->fetchColumn()) ? "Male" : "Female" ?>)</option>
                    <?php else: ?>
                        <option value="<?= $row['id'] ?>" data-name="<?= $row['types'] ?>"><?= $row['bed'] ?> койка</option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <?php
        } elseif( $this->getGet('division') and $this->getGet('building') and $this->getGet('floor')) {
            ?>
            <label>Выбирите палату:</label>
            <select data-placeholder="Выбрать палату" id="ward_id" class="<?= $classes['form-select'] ?>" required>
                <?php $sql = "SELECT w.id, w.ward, COUNT(b.id) FROM wards w JOIN beds b ON(b.ward_id=w.id) WHERE w.building_id = " . $this->getGet('building') . " AND w.division_id = " . $this->getGet('division') . " AND b.floor = " . $this->getGet('floor') . " AND b.patient_id IS NULL GROUP BY w.id"; ?>
                <?php foreach ($this->db->query($sql) as $row): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['ward'] ?> палата</option>
                <?php endforeach; ?>
            </select>
            <?php
        } elseif( $this->getGet('division') and $this->getGet('building') ) {
            ?>
            <label>Выбирите этаж:</label>
            <select data-placeholder="Выбрать этаж" id="floor" class="<?= $classes['form-select'] ?>" required>
                <?php $sql = "SELECT b.floor, COUNT(b.id) FROM wards w JOIN beds b ON(b.ward_id=w.id) WHERE w.building_id = " . $this->getGet('building') . " AND w.division_id = " . $this->getGet('division') . " AND b.patient_id IS NULL GROUP BY b.floor"; ?>
                <?php foreach ($this->db->query($sql) as $row): ?>
                    <option value="<?= $row['floor'] ?>"><?= $row['floor'] ?> этаж</option>
                <?php endforeach; ?>
            </select>
            <?php
        } elseif( $this->getGet('division') ) {
            ?>
            <label>Выбирите здание:</label>
            <select data-placeholder="Выбрать здание" id="building_id" class="<?= $classes['form-select'] ?>" required>
                <?php $sql = "SELECT g.id, g.name, COUNT(b.id) FROM buildings g JOIN wards w ON(w.building_id=g.id) JOIN beds b ON(b.ward_id=w.id) WHERE w.division_id = " . $this->getGet('division') . " AND b.patient_id IS NULL GROUP BY g.id"; ?>
                <?php foreach ($this->db->query($sql) as $row): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php
        }
        
    }

    public function saveBody()
    {
        $this->createOrUpdateVisit();

        if (is_array($this->getPost('service'))) {
            // Амбулатор
            foreach ($this->getPost('service') as $key => $value) $this->addVisitService($key, $value);
        }else{
            // Стационар
            $this->application();
            $this->initial();
            $this->addVisitService(null, 1);
            $this->addVisitBed();
        }

        $this->patientUpdateStatus();
    }

    private function patientUpdateStatus()
    {
        // Обновление статуса у пациента
        $obj = Mixin\update($this->tPatient, array('status' => True), $this->getPost('patient_id'));
        if (!intval($obj)){
            $this->error("Ошибка в обновление статуса пациента!");
            $this->db->rollBack();
        }
    }

    private function createOrUpdateVisit()
    {
        $post = array(
            'parad_id' => ( $this->getPost('direction') ) ? $this->Data("IFNULL(MAX(parad_id), 0) 't'")->Where('direction IS NOT NULL')->get()->t + 1 : null,
            'grant_id' => ( $this->getPost('direction') ) ? $this->getPost('parent_id') : null,
            'patient_id' => ( $this->getPost('patient_id') ) ? $this->getPost('patient_id') : null,
            'direction' => ( $this->getPost('direction') ) ? $this->getPost('direction') : null,
            'division_id' => ( $this->getPost('direction') ) ? $this->getPost('division_id') : null,
            'last_update' => date("Y-m-d H:i:s"),
        );
        $obj = HellCrud::insert_or_update($this->table, $post, 'patient_id', 'completed IS NULL');
        if (!is_numeric($obj)) {
            $this->error("Ошибка создании или обновлении визита!");
            $this->db->rollBack();
        }else{
            $this->visit_pk = $obj;
            $this->is_foreigner = $this->db->query("SELECT is_foreigner FROM $this->tPatient WHERE id = " . $this->getPost('patient_id'))->fetchColumn();
            $this->chekStatus();
        }
    }

    private function chekStatus()
    {
        importModel('VisitType', 'VisitStatus');
        $this->status_is = (new VisitStatus)->Where('visit_id=' . $this->visit_pk)->get();
        if( !$this->status_is and $this->getPost('status_is') ) {
            $type = (new VisitType)->byId($this->getPost('status_is'), ['name', 'free_service_1', 'free_service_2', 'free_service_3', 'free_laboratory', 'free_diagnostic', 'free_physio', 'free_bed']);
            $object = HellCrud::insert($this->tStatus, array_merge((array) $type, array('visit_id' => $this->visit_pk)));
            
            if (!is_numeric($object)) {
                $this->error("Ошибка при назначении статуса!");
                $this->db->rollBack();
            }else {
                $this->status_is = (new VisitStatus)->Where('visit_id=' . $this->visit_pk)->get();
            }
        }
    }

    private function serviceIsFree($service = null)
    {
        if(isset($this->status_is) and $this->status_is){
            if($service->user_level == 1 and $service->type == 101) return true;
            elseif($service->user_level == 5) {
                if($this->status_is->free_service_1 and $service->type == 1) return true;
                elseif($this->status_is->free_service_2 and $service->type == 2) return true;
                elseif($this->status_is->free_service_3 and $service->type == 3) return true;
            }
            elseif($service->user_level == 6 and $this->status_is->free_laboratory) return true;
            elseif($service->user_level == 10 and $this->status_is->free_diagnostic) return true;
            elseif($service->user_level == 12 and $this->status_is->free_physio) return true;
            return false;
        }
        return false;
    }

    private function addVisitService($key = null, $value)
    {
        global $session;
        importModel('Service');
        $service = (new Service)->byId($value);

        if ( $this->getPost('direction') ) $post['division_id'] = $this->getPost('division_id');
        else{
            if ( isset($this->getPost('division_id')[$key]) and $this->getPost('division_id')[$key] ) {
                $post['division_id'] = $this->getPost('division_id')[$key];
            }
        }

        $post['visit_id'] = $this->visit_pk;
        $post['patient_id'] = $this->getPost('patient_id');
        $post['parent_id'] = ( $this->getPost('direction') ) ? $this->getPost('parent_id') : $this->getPost('parent_id')[$key];
        $post['route_id'] = $session->session_id;
        $post['guide_id'] = $this->getPost('guide_id');
        $post['level'] = ( isset($post['division_id']) and $post['division_id'] ) ? $this->db->query("SELECT level FROM $this->tDivision WHERE id=" . $post['division_id'])->fetchColumn() : $this->getPost('level')[$key];
        $post['status'] = ( $this->getPost('direction') or $this->serviceIsFree($service) ) ? 2 : 1;
        $post['service_id'] = $service->id;
        $post['service_name'] = $service->name;
   
        $count = ( $this->getPost('direction') ) ? 1 : $this->getPost('count')[$key];
        for ($i=0; $i < $count; $i++) {
            $post = HellCrud::clean_form($post);
            $post = HellCrud::to_null($post);
            $obj = HellCrud::insert($this->tVisitService, $post);
            if (!is_numeric($obj)){
                $this->error("Ошибка при создании услуги!");
                $this->db->rollBack();
            }
            
            if ( !$this->serviceIsFree($service) ) {
                $post_price['visit_id'] = $this->visit_pk;
                $post_price['visit_service_id'] = $obj;
                $post_price['patient_id'] = $this->getPost('patient_id');
                $post_price['item_type'] = $service->type;
                $post_price['item_id'] = $service->id;
                $post_price['item_cost'] = ($this->is_foreigner) ? $service->price_foreigner : $service->price;
                $post_price['item_name'] = $service->name;
                $post_price['is_visibility'] = ( $this->getPost('direction') ) ? null : 1;
                $object = Mixin\insert($this->tVisitServiceTransaction, $post_price);
                if (!is_numeric($object)){
                    $this->error("Ошибка при создании платежа услуги!");
                    $this->db->rollBack();
                }
            }
            $this->pacsSend();
        }
        unset($post);
    }

    private function application(){
        if( $this->getPost('application') ){
            Mixin\delete($this->tVisitApplication, $this->getPost('application'));
        }
    }

    private function initial(){
        if( $this->getPost('initial') ){
            Mixin\insert($this->tVisitInitial, array_merge(array('visit_id' => $this->visit_pk), $this->getPost('initial')));
        }
    }

    private function addVisitBed()
    {
        global $session;
        $bed = $this->db->query("SELECT * FROM $this->tBed WHERE id=" . $this->getPost('bed'))->fetch();
        $bed_type = $this->db->query("SELECT * FROM $this->tBedType WHERE id=" . $bed['type_id'])->fetch();

        $price = ($this->is_foreigner) ? $bed_type['price_foreigner'] : $bed_type['price'];
        $post = array(
            'visit_id' => $this->visit_pk,
            'parent_id' => $session->session_id,
            'patient_id' => $this->getPost('patient_id'),
            'bed_id' => $bed['id'],
            'location' => $bed['building'] . " " . $bed['floor'] . " этаж " . $bed['ward'] . " палата " . $bed['bed'] . " койка",
            'type' => $bed['types'],
            'cost' => ($this->bedIsFree()) ? 0 : $price,
        );

        $object = HellCrud::insert($this->tVisitBed, $post);
        if (!is_numeric($object)) {
            $this->error("Ошибка при создании платежа для койки!");
            $this->db->rollBack();
        }

        $object2 = HellCrud::update($this->tBed, array('patient_id' => $this->getPost('patient_id')), $this->getPost('bed'));
        if (!is_numeric($object2) and $object <= 0){
            $this->error("Ошибка при бронировании пациентом койки!");
            $this->db->rollBack();
        }
    }

    private function bedIsFree()
    {
        if(isset($this->status_is) and $this->status_is and $this->status_is->free_bed) return true;
        else return false;
    }

    private function pacsSend()
    {
        /*
            // pacs
            $DNS = "odbc:Driver=ODBC Driver 17 for SQL Server;Server=192.168.10.89;Port:1433;Database=OCS;";
            try {
                $pacs = new PDO($DNS, "OCS", "OCS");
                $pacs->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $pacs->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
                $pacs->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                // die($e->getMessage());
                $this->error("Ошибка при соединении с PACS!");
                $db->rollBack();
            }
            $pacsData = $db->query("SELECT vs.user_id, us.first_name, us.last_name, us.father_name, us.gender, us.birth_date, d.name, vs.add_date, vs.service_name, vs.route_id FROM $this->_service vs JOIN users us ON(us.id=vs.user_id) JOIN divisions d ON(d.id=vs.division_id) WHERE vs.id = $object_s")->fetch();
            $pdata = array(
                'PatientID' => $pacsData['user_id'],
                'LastName' => $pacsData['last_name'] ." ". $pacsData['first_name'] ." ". $pacsData['father_name'], 
                'Sex' => ($pacsData['gender']) ? 'M' : 'F', 
                'BirthDate' => $pacsData['birth_date'], 
                'Modality' => 'MR', 
                'Department' => $pacsData['name'],
                'TimeDate' => $pacsData['add_date'],
                'StudyName' => $pacsData['service_name'],
                'PACSOCSBridgeKey' => $object_s,
                'Status' => 0,
                'ReadStatus' => 0,
                'OrderDoctor' => $pacsData['route_id'],
                'OCSComment' => '',
            );

            $col = implode(",", array_keys($pdata));
            $val = ":".implode(", :", array_keys($pdata));
            $sql = "INSERT INTO QueueRecord ($col) VALUES ($val)";
            try{
                $stm = $pacs->prepare($sql)->execute($pdata);
            }
            catch (\PDOException $ex) {
                $this->error($ex->getMessage());
            }
            // end pacs
            */
    }

    public function is_update(int $pk)
    {
        $patient = $this->byId($pk, 'patient_id')->patient_id;
        $service = $this->db->query("SELECT * FROM $this->tVisitService WHERE visit_id = $pk AND status NOT IN(6,7)")->rowCount();

        if ($service == 0) {

            $object = Mixin\update($this->table, array('completed' => date("Y-m-d H:i:s")), $pk);
            if(!intval($object)) return $object;
            $this->status_update($patient);
            return null;

        } else return $service;
        
    }

    public function is_delete(int $pk)
    {
        $patient = $this->byId($pk, 'patient_id')->patient_id;
        $service = $this->db->query("SELECT * FROM $this->tVisitService WHERE visit_id = $pk")->rowCount();
        $service_update = $this->db->query("SELECT * FROM $this->tVisitService WHERE visit_id = $pk AND status IN(1,2,3,5)")->rowCount();

        if ($service == 0) {

            $object = Mixin\delete($this->table, $pk);
            if(!intval($object)) return $object;
            $this->status_update($patient);
            return null;

        } else {

            if ($service_update == 0) {
                $object = Mixin\update($this->table, array('completed' => date("Y-m-d H:i:s")), $pk);
                if(!intval($object)) return $object;
                $this->status_update($patient);
            }
            return $service;
        }
        
    }

    public function status_update($user)
    {
        importModel('Patient');
        return (new Patient)->update_status($user);
    }

    public function VPS(Int $pk)
    {
        if ($pk) {
            if ($this->db->query("SELECT completed FROM $this->table WHERE id = $pk")->fetchColumn()) {
                $sql = "SELECT
                        v.id,
                        v.grant_id,
                        v.direction,
                        IFNULL( (SELECT vr.id FROM $this->tStatus vr WHERE vr.visit_id=v.id), NULL) 'status_id',
                        IFNULL( ROUND((SELECT SUM(vi.balance_cash + vi.balance_card + vi.balance_transfer) FROM visit_investments vi WHERE vi.visit_id = v.id AND vi.expense IS NOT NULL)), 0) 'balance',
                        IFNULL( (SELECT SUM(ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(vb.end_date, CURRENT_TIMESTAMP()), vb.start_date), '%H'))) FROM $this->tVisitBed vb WHERE vb.visit_id = v.id) , 0) 'bed-time',
                        IFNULL( ROUND((SELECT SUM(ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(vb.end_date, CURRENT_TIMESTAMP()), vb.start_date), '%H')) * (vb.cost / 24)) FROM $this->tVisitBed vb WHERE vb.visit_id = v.id) * -1), 0) 'cost-beds',
                        IFNULL( ROUND((SELECT SUM(vp.item_cost) FROM $this->tVisitServiceTransaction vp WHERE vp.visit_id = v.id AND vp.is_price IS NOT NULL) * -1), 0) 'cost-services',
                        IFNULL( ROUND((SELECT SUM(vt.item_qty*vt.item_cost) FROM visit_bypass_transactions vt WHERE vt.visit_id = v.id AND vt.is_price IS NOT NULL) * -1), 0) 'cost-preparats',
                        IFNULL( vl.sale_bed_unit , 0) 'sale-bed',
                        IFNULL( vl.sale_service_unit , 0) 'sale-service',
                        -- @cost_item_2 := IFNULL((SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (2,3,4) AND price_date IS NULL), 0) 'cost_item_2',
                        v.add_date,
                        v.is_active,
                        v.completed
                    FROM visits v 
                        LEFT JOIN visit_sales vl ON(vl.visit_id = v.id)
                    WHERE v.id = $pk";
                $object = $this->db->query($sql)->fetch();
                $object['sale-total'] = $object['sale-bed'] + $object['sale-service'];
                $object['total_cost'] = $object['cost-services'] + $object['cost-beds'] + $object['cost-preparats'];
                $object['result'] = $object['balance'] + $object['total_cost'] + $object['sale-total'];
                return $object;
            } else {
                $sql = "SELECT
                        v.id,
                        v.grant_id,
                        v.direction,
                        IFNULL( (SELECT vr.id FROM $this->tStatus vr WHERE vr.visit_id=v.id), NULL) 'status_id',
                        IFNULL( ROUND((SELECT SUM(vi.balance_cash + vi.balance_card + vi.balance_transfer) FROM visit_investments vi WHERE vi.visit_id = v.id AND vi.expense IS NULL)), 0) 'balance',
                        IFNULL( (SELECT SUM(ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(vb.end_date, CURRENT_TIMESTAMP()), vb.start_date), '%H'))) FROM $this->tVisitBed vb WHERE vb.visit_id = v.id) , 0) 'bed-time',
                        IFNULL( ROUND((SELECT SUM(ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(vb.end_date, CURRENT_TIMESTAMP()), vb.start_date), '%H')) * (vb.cost / 24)) FROM $this->tVisitBed vb WHERE vb.visit_id = v.id) * -1), 0) 'cost-beds',
                        IFNULL( ROUND((SELECT SUM(vp.item_cost) FROM $this->tVisitServiceTransaction vp WHERE vp.visit_id = v.id AND vp.item_type IN (1,2,3) AND vp.is_price IS NULL) * -1), 0) 'cost-services',
                        IFNULL( ROUND((SELECT SUM(vt.item_qty*vt.item_cost) FROM visit_bypass_transactions vt WHERE vt.visit_id = v.id AND vt.is_price IS NULL) * -1), 0) 'cost-preparats',
                        IFNULL( vl.sale_bed_unit , 0) 'sale-bed',
                        IFNULL( vl.sale_service_unit , 0) 'sale-service',
                        -- @cost_item_2 := IFNULL((SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (2,3,4) AND price_date IS NULL), 0) 'cost_item_2',
                        v.add_date,
                        v.is_active
                    FROM visits v 
                        LEFT JOIN visit_sales vl ON(vl.visit_id = v.id)
                    WHERE v.id = $pk";
                $object = $this->db->query($sql)->fetch();
                $object['sale-total'] = $object['sale-bed'] + $object['sale-service'];
                $object['total_cost'] = $object['cost-services'] + $object['cost-beds'] + $object['cost-preparats'];
                $object['result'] = $object['balance'] + $object['total_cost'] + $object['sale-total'];
                return $object;
            }
        } else return array();
    }

}

?>