<?php

use Warframe\Model;

class VisitOperationServiceModel extends Model
{
    public $table = 'visit_operation_services';
    public $_visit_operations = 'visit_operations';
    public $_visits = 'visits';

    public function get_or_404(int $pk)
    {
        global $db, $session;

        // Visit
        $object = $db->query("SELECT * FROM $this->_visits WHERE id = {$_GET['visit_id']} AND direction IS NOT NULL AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){

            // Operation
            $object2 = $db->query("SELECT * FROM $this->_visit_operations WHERE id = $pk AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
            if($object2 and ($session->session_id == $object2['grant_id'] or permission([15])) ){

                $this->visit_id = $_GET['visit_id'];
                $this->operation_id = $pk;
                $this->is_foreigner = $db->query("SELECT is_foreigner FROM clients WHERE id = {$object['client_id']}")->fetchColumn();
                return $this->{$_GET['form']}();
                
            }else{
                Mixin\error('report_permissions_false');
                exit;
            }

        }else{
            Mixin\error('report_permissions_false');
        }

    }

    public function form($pk = null)
    {
        global $db, $classes, $session;
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Назначить Анестезию</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
                <input type="hidden" name="visit_id" value="<?= $this->visit_id ?>">
                <input type="hidden" name="operation_id" value="<?= $this->operation_id ?>">

                <div class="form-group">
                    <label>Отделы</label>
                    <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="<?= $classes['form-multiselect'] ?>" onchange="TableChangeServices(this)" required>
                        <?php foreach ($db->query("SELECT * FROM divisions WHERE branch_id = $session->branch AND level = 15") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group-feedback form-group-feedback-right row">

                    <div class="col-md-10">
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input" placeholder="Поиск..." title="Введите назване отдела или услуги">
                        <div class="form-control-feedback">
                            <i class="icon-search4 font-size-base text-muted"></i>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                                <span class="ladda-label">Сохранить</span>
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
                                    <th>Cпециалист</th>
                                    <th style="width: 100px">Кол-во</th>
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
        <script type="text/javascript">

            $("#<?= __CLASS__ ?>_form").submit(function( events ) {
                events.preventDefault();
                $.ajax({
                    type: $(events.target).attr("method"),
                    url: $(events.target).attr("action"),
                    data: $(events.target).serializeArray(),
                    success: function (data) {
                        var result = JSON.parse(data);

                        $('#modal_default').modal('hide');
                        if (result.status == "success") {
                            new Noty({
                                text: result.message,
                                type: 'success'
                            }).show();
                        }else {
                            new Noty({
                                text: result.message,
                                type: 'error'
                            }).show();
                        }

                        Title_up();
                    },
                });
            });

            BootstrapMultiselect.init();
            FormLayouts.init();

            var service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        branch_id: <?= $session->branch ?>,
                        divisions: $("#division_selector").val(),
                        is_foreigner: "<?= $this->is_foreigner ?>",
                        is_order: null,
                        search: $("#search_input").val(),
                        selected: service,
                        types: "3",
                        cols: 1,
                        is_requared:1,
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
                        is_foreigner: "<?= $this->is_foreigner ?>",
                        is_order: null,
                        selected: service,
                        types: "3",
                        cols: 1,
                        is_requared:1,
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

    public function save()
    {
        global $db, $session;
        if($this->clean()){

            $db->beginTransaction();
            $client_pk = $db->query("SELECT client_id FROM $this->_visit_operations WHERE id = {$this->post['operation_id']}")->fetchColumn();
            $this->is_foreigner = $db->query("SELECT is_foreigner FROM clients WHERE id = $client_pk")->fetchColumn();

            foreach ($this->post['service'] as $key => $value) {

                $serv = $db->query("SELECT * FROM services WHERE id = $value")->fetch();
                $post['branch_id'] = $this->post['branch_id'];
                $post['visit_id'] = $this->post['visit_id'];
                $post['operation_id'] = $this->post['operation_id'];
                $post['creater_id'] = $session->session_id;
                $post['item_id'] = $value;
                $post['item_responsible_id'] = $this->post['responsible_id'][$key];
                $post['item_name'] = $serv['name'];
                $post['item_cost'] = (isset($this->is_foreigner) and $this->is_foreigner) ? $serv['price_foreigner'] : $serv['price'];
    
                for ($i=0; $i < $this->post['count'][$key]; $i++) {
                    $object = Mixin\insert($this->table, $post);
                    if (!intval($object)){
                        $this->error($object);
                        $db->rollBack();
                    }
                }
    
            }   

            $db->commit();
            $this->success();
        }
    }

    public function clean()
    {
        // if (isset($this->post['division_id']) and is_array($this->post['division_id']) and empty($this->post['direction']) and !$this->post['service']) {
        //     $this->error("Не назначены услуги!");
        // }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo json_encode(array(
            'status' => "success",
            'message' => "Успешно"
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