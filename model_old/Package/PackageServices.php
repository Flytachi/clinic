<?php

use Mixin\ModelOld;

class PackageServicesModel extends ModelOld
{
    public $table = 'package_services';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        if($pk){
            $this->post['items'] = json_decode($this->post['items']);
            $this->post['divisions'] = json_decode($this->post['divisions']);
        }
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="autor_id" value="<?= $session->session_id ?>">

            <div class="form-group">
                <label>Название пакета:</label>
                <input type="text" name="name" value="<?= $this->value('name') ?>" class="form-control" placeholder="Введите название пакета" required>
            </div>

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" name="divisions[]" id="division_selector" class="<?= $classes['form-multiselect'] ?>" onchange="TableChangeServices(this)">
                    <optgroup label="Врачи">
                        <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 5 AND id != $session->session_division") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ( $this->value('divisions') and in_array($row['id'], $this->value('divisions'))) ? "selected" : "" ?>><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <?php if(module('module_diagnostic')): ?>
                        <optgroup label="Диогностика">
                            <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= ( $this->value('divisions') and in_array($row['id'], $this->value('divisions'))) ? "selected" : "" ?>><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                    <?php if(module('module_laboratory')): ?>
                        <optgroup label="Лаборатория">
                            <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 6") as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= ( $this->value('divisions') and in_array($row['id'], $this->value('divisions'))) ? "selected" : "" ?>><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                    <?php if(module('module_physio')): ?>
                        <optgroup label="Физиотерапия">
                            <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 12") as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= ( $this->value('divisions') and in_array($row['id'], $this->value('divisions'))) ? "selected" : "" ?>><?= $row['title'] ?></option>
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
                                <th>Тип</th>
                                <th>Доктор</th>
                                <th style="width:100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                            <?php if ( $this->value('items') ): ?>

                                <script type="text/javascript">var service = {};</script>

                                <?php foreach ($this->value('items') as $value): ?>
                                    <script type="text/javascript">
                                        service["<?= $value->service_id ?>"] = {};
                                        service["<?= $value->service_id ?>"]['parent'] = "<?= $value->parent_id ?>";
                                        service["<?= $value->service_id ?>"]['count'] = "<?= $value->count ?>";
                                    </script>
                                <?php endforeach; ?>

                                <script type="text/javascript">
                                    $.ajax({
                                        type: "POST",
                                        url: "<?= up_url(1, 'ServicePanel') ?>",
                                        data: {
                                            divisions: $("#division_selector").val(),
                                            selected: service,
                                            types: "1,2",
                                            cols: 0,
                                            is_service_checked: 1,
                                        },
                                        success: function (result) {
                                            var service = {};
                                            $('#table_form').html(result);
                                        },
                                    });

                                    $( document ).ready(function() {
                                        FormLayouts.init();
                                        BootstrapMultiselect.init();
                                    });
                                </script>

                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>

            </div>
            

        </form>

        <?php if ( !$this->value('items') ): ?>
            <script type="text/javascript">var service = {};</script>
        <?php endif; ?>
        <script type="text/javascript">

            $("#search_input_service").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
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

    public function clean()
    {
        foreach ($this->post['service'] as $key => $value) {
            $items[] = array(
                'service_id' => $this->post['service'][$key],
                'division_id' => $this->post['division_id'][$key],
                'parent_id' => $this->post['parent_id'][$key],
                'count' => $this->post['count'][$key],
            );
        }
        unset($this->post['service']);
        unset($this->post['division_id']);
        unset($this->post['parent_id']);
        unset($this->post['count']);
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        $this->post['divisions'] = json_encode($this->post['divisions']);
        $this->post['items'] = json_encode($items);
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
            <span class="font-weight-semibold">Ошибка при создании пакета услуг!</span>
        </div>
        ';
        render();
    }
}

?>
