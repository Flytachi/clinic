<?php

use Mixin\Hell;
use Mixin\Model;

class Constant extends Model
{
    public $table = 'corp_constants';
    public $branch = 'corp_branchs';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->branch WHERE id = $pk AND is_active IS NOT NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Hell::error('report_permissions_false');
            exit;
        }
    }

    public function form($pk = null)
    {
        global $classes, $db;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Настройки филлиала <?= $this->value('name') ?></h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>" onsubmit="SubmitBp()">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="warehouse_id" value="<?= $this->value('id') ?>">
            
            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-6">

                        <legend>The Settings Modules</legend>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <?php
                                    try {
                                        $company = new stdClass();
                                        $comp = $db->query("SELECT * FROM corp_constants WHERE branch_id = $pk AND const_label LIKE 'module_%'")->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($comp as $value) {
                                            $company->{$value->const_label} = $value->const_value;
                                        }
                                        ?>
                                        <tr>
                                            <th>Stationar</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_stationar" <?= (isset($company->module_stationar) and $company->module_stationar) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Laboratory</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_laboratory" <?= (isset($company->module_laboratory) and $company->module_laboratory) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Diagnostic</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_diagnostic" <?= (isset($company->module_diagnostic) and $company->module_diagnostic) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Physio</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_physio" <?= (isset($company->module_physio) and $company->module_physio) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pharmacy</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_pharmacy" <?= (isset($company->module_pharmacy) and $company->module_pharmacy) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Anesthesia</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_anesthesia" <?= (isset($company->module_anesthesia) and $company->module_anesthesia) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Bypass</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_bypass" <?= (isset($company->module_bypass) and $company->module_bypass) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Diet</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_diet" <?= (isset($company->module_diet) and $company->module_diet) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ZeTTa PACS</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_zetta_pacs" <?= (isset($company->module_zetta_pacs) and $company->module_zetta_pacs) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    } catch (\Exception $e) {
                                        echo '<tr class="text-center"><th colspan="2">Не установлена база данных</th></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div class="col-md-6">

                        <legend>The Settings Configurations</legend>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <?php
                                    try {
                                        $config = new stdClass();
                                        $comp = $db->query("SELECT * FROM corp_constants WHERE branch_id = $pk AND const_label LIKE 'constant_%'")->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($comp as $value) {
                                            $config->{$value->const_label} = $value->const_value;
                                        }
                                        ?>
                                        <tr>
                                            <th style="width:90%">Package</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_package" <?= (isset($config->constant_package) and $config->constant_package) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Template</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_template" <?= (isset($config->constant_template) and $config->constant_template) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Wards by division</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_wards_by_division" <?= (isset($config->constant_wards_by_division) and $config->constant_wards_by_division) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Document Autosave</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_document_autosave" <?= (isset($config->constant_document_autosave) and $config->constant_document_autosave) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Admin -->
                                        <tr>
                                            <th>Admin Delete Button (users)</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_admin_delete_button_users" <?= (isset($config->constant_admin_delete_button_users) and $config->constant_admin_delete_button_users) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Admin Delete Button (services)</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_admin_delete_button_services" <?= (isset($config->constant_admin_delete_button_services) and $config->constant_admin_delete_button_services) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Admin Delete Button (analyzes)</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_admin_delete_button_analyzes" <?= (isset($config->constant_admin_delete_button_analyzes) and $config->constant_admin_delete_button_analyzes) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Admin Delete Button (warehouses)</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_admin_delete_button_warehouses" <?= (isset($config->constant_admin_delete_button_warehouses) and $config->constant_admin_delete_button_warehouses) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Laboratory -->
                                        <tr>
                                            <th>Laboratory End All Button</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_laboratory_end_all_button" <?= (isset($config->constant_laboratory_end_all_button) and $config->constant_laboratory_end_all_button) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Laboratory End Service Button</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_laboratory_end_service_button" <?= (isset($config->constant_laboratory_end_service_button) and $config->constant_laboratory_end_service_button) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Laboratory Failure Service Button</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_laboratory_failure_service_button" <?= (isset($config->constant_laboratory_failure_service_button) and $config->constant_laboratory_failure_service_button) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Card -->
                                        <tr>
                                            <th>Card Stationar Doctor Journal Edit</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_journal_edit" <?= (isset($config->constant_card_stationar_journal_edit) and $config->constant_card_stationar_journal_edit) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Card Stationar Doctor Button (not grant)</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_doctor_button" <?= (isset($config->constant_card_stationar_doctor_button) and $config->constant_card_stationar_doctor_button) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Card Stationar Analyze Button (not grant)</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_analyze_button" <?= (isset($config->constant_card_stationar_analyze_button) and $config->constant_card_stationar_analyze_button) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Card Stationar Diagnostic Button (not grant)</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_diagnostic_button" <?= (isset($config->constant_card_stationar_diagnostic_button) and $config->constant_card_stationar_diagnostic_button) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Card Stationar Physio Button (not grant)</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_physio_button" <?= (isset($config->constant_card_stationar_physio_button) and $config->constant_card_stationar_physio_button) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Card Stationar Doctor Add Condition Button (grant)</th>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <label class="form-check-label">
                                                        <input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_condition_button" <?= (isset($config->constant_card_stationar_condition_button) and $config->constant_card_stationar_condition_button) ? "checked" : "" ?>>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    } catch (\Exception $e) {
                                        echo '<tr class="text-center"><th colspan="2">Не установлена база данных</th></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
                
            </div>
            
            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
            </div>

        </form>
        <script>
            function ConstChange(input) {
                $.ajax({
                    type: "POST",
                    url: "<?= ajax('manager/controller') ?>",
                    data: Object.assign({}, { branch_id: <?= $pk ?>, module: input.name }, $(input).serializeArray()),
                    success: function (data) {
                        if (data == 1) {
                            new Noty({
                                text: "Успешно",
                                type: 'success'
                            }).show();
                        }else{
                            new Noty({
                                text: data,
                                type: 'error'
                            }).show();
                        }
                    },
                });
            }
        </script>
        <?php
        $this->jquery_init();
    }

    public function jquery_init()
    {
        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                Swit.init();
            });
        </script>
        <?php
    }

}
        
?>