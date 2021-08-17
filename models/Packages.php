<?php

class PackageModel extends Model
{
    public $table = 'packages';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        if($pk){
            $this->post['items'] = json_decode($this->post['items']);
            $this->post['divisions'] = json_decode($this->post['divisions']);
            // dd($this->value('items'));
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
                                        type: "GET",
                                        url: "<?= ajax('service_table') ?>",
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

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
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
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
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

    public function form_old($pk = null)
    {
        global $db, $classes, $session;
        if($pk){
            $this->post['items'] = json_decode($this->post['items']);
            foreach ($this->post['items'] as $key => $value) {
                $service_pk[] = $key;
                $parent_pk[] = $value->parent_id;
                if (!isset($division) or ($division and !in_array($value->division_id, $division))) {
                    $division[] = $value->division_id;
                }
            }
        }
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="autor_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group">
                <label>Название пакета:</label>
                <input type="text" name="name" value="<?= $this->value('name') ?>" class="form-control" placeholder="Введите название пакета" required>
            </div>

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="<?= $classes['form-multiselect'] ?>" onchange="TableChangeServices(this)">
                    <optgroup label="Врачи">
                        <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 5 AND id != $session->session_division") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ( isset($division) and in_array($row['id'], $division)) ? "selected" : "" ?>><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <?php if(module('module_diagnostic')): ?>
                        <optgroup label="Диогностика">
                            <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= ( isset($division) and in_array($row['id'], $division)) ? "selected" : "" ?>><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                    <?php if(module('module_laboratory')): ?>
                        <optgroup label="Лаборатория">
                            <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 6") as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= ( isset($division) and in_array($row['id'], $division)) ? "selected" : "" ?>><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                    <?php if(module('module_physio')): ?>
                        <optgroup label="Физиотерапия">
                            <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 12") as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= ( isset($division) and in_array($row['id'], $division)) ? "selected" : "" ?>><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-11">
                    <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input" placeholder="Поиск..." title="Введите назване отдела или услуги">
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
                                <th>Доктор</th>
                                <th style="width:100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                            <?php if ( isset($this->post['items']) ): ?>
                                <?php
                                $_GET['cols'] = 0;
                                $_GET['head'] = null;
                                dd($this->post['items']);
                                dd($division);
                                dd($service_pk);
                                dd($parent_pk);
                                ?>

                                <script type="text/javascript">var service = {};</script>
                                <?php foreach ($this->post['items'] as $key => $value): ?>
                                    <script type="text/javascript">service["<?= $key ?>"] = "<?= $value->count ?>";</script>
                                <?php endforeach; ?>

                                <?php $i=$cost=0; foreach ($division as $divis_pk): ?>

                                    <?php foreach ($db->query("SELECT sc.id, sc.user_level, dv.title, sc.name, sc.type, sc.price FROM services sc LEFT JOIN divisions dv ON(dv.id=sc.division_id) WHERE sc.division_id = $divis_pk AND sc.type IN (1,2) AND sc.id IN (".implode(', ', $service_pk).")") as $row): ?>
                                        <?php $i++; ?>
                                        <tr>

                                            <td>
                                                <?php
                                                if (in_array($row['id'], $service_pk)) {
                                                    $result = "checked";
                                                    $cost += ($row['price'] * ((array) $this->post['items'])[$row['id']]->count);
                                                }else {
                                                    $result = "";
                                                }
                                                ?>
                                                <input type="checkbox" name="service[<?= $i ?>]" value="<?= $row['id'] ?>" class="form-input-styled" onchange="tot_sum(this, <?= $row['price'] ?>)" <?= $result ?>>
                                                <input type="hidden" name="division_id[<?= $i ?>]" value="<?= $divis_pk ?>">
                                            </td>

                                            <?php if ($_GET['cols'] < 2): ?>
                                                <td><?= $row['title'] ?></td>
                                            <?php endif; ?>
                                            <td><?= $row['name'] ?></td>
                                            <?php if ($_GET['cols'] < 1): ?>
                                                <td>
                                                    <?php switch ($row['type']) {
                                                        case 1:
                                                            echo "Обычная";
                                                            break;
                                                        case 2:
                                                            echo "Консультация";
                                                            break;
                                                        case 3:
                                                            echo "Операционная";
                                                            break;
                                                    } ?>
                                                </td>
                                            <?php endif; ?>
                                            <?php if (!$_GET['head']): ?>
                                                <td>
                                                    <select data-placeholder="Выберите специалиста" name="parent_id[<?= $i ?>]" class="<?= $classes['form-select'] ?>">
                                                        <option value="">Выберан весь отдел</option>
                                                        <?php if ($row->user_level == 6): ?>
                                                            <?php foreach ($db->query("SELECT id FROM users WHERE user_level = 6 AND is_active IS NOT NULL") as $parent): ?>
                                                                <option value="<?= $parent['id'] ?>"><?= get_full_name($parent['id']) ?></option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <?php foreach ($db->query("SELECT id FROM users WHERE division_id = $divis_pk AND is_active IS NOT NULL") as $parent): ?>
                                                                <option value="<?= $parent['id'] ?>"><?= get_full_name($parent['id']) ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </td>
                                            <?php endif; ?>
                                            <td style="width:70px;">
                                                <input type="number" id="count_input_<?= $row['id'] ?>" data-id="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>" class="form-control counts" name="count[<?= $i ?>]" value="<?= ((array) $this->post['items'])[$row['id']]->count ?>" min="1" max="1000000">
                                            </td>
                                            <td class="text-right text-success"><?= number_format($row['price']) ?></td>

                                        </tr>
                                    <?php endforeach; ?>

                                <?php endforeach; ?>
                                <tr class="table-secondary">
                                    <th class="text-right" colspan="<?= 6-$_GET['cols'] ?>">Итого:</th>
                                    <th class="text-right" id="total_price"><?= number_format($cost) ?></th>
                                </tr>

                                <script type="text/javascript">
                                    $( document ).ready(function() {
                                        FormLayouts.init();
                                        BootstrapMultiselect.init();
                                    });

                                    function tot_sum(the, price) {
                                        var total = $('#total_price');
                                        var cost = total.text().replace(/,/g,'');
                                        if (the.checked) {
                                            service[the.value] = $("#count_input_"+the.value).val();
                                            total.text( number_format(Number(cost) + (Number(price) * service[the.value]), '.', ',') );
                                        }else {
                                            total.text( number_format(Number(cost) - (Number(price) * service[the.value]), '.', ',') );
                                            delete service[the.value];
                                        }
                                        console.log(service);
                                    }

                                    $(".counts").keyup(function() {
                                        var total = $('#total_price');
                                        var cost = total.text().replace(/,/g,'');

                                        if (typeof service[this.dataset.id] !== "undefined") {
                                            total.text( number_format(Number(cost) + (this.dataset.price * (this.value - service[this.dataset.id])), '.', ',') );
                                            service[this.dataset.id] = this.value;
                                        }
                                        console.log(service);
                                    });

                                </script>

                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>

            </div>
            

        </form>

        <script type="text/javascript">

            var service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
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
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
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

            // var service = {};

            // $("#search_input").keyup(function() {
            //     $.ajax({
            //         type: "GET",
            //         url: "<?= ajax('service_table') ?>",
            //         data: {
            //             divisions: $("#division_selector").val(),
            //             search: $("#search_input").val(),
            //             selected: service,
            //             types: "1,2",
            //             cols: 0
            //         },
            //         success: function (result) {
            //             var service = {};
            //             $('#table_form').html(result);
            //         },
            //     });
            // });

            // function table_change(the) {

            //     $.ajax({
            //         type: "GET",
            //         url: "<?= ajax('service_table') ?>",
            //         data: {
            //             divisions: $(the).val(),
            //             selected: service,
            //             types: "1,2",
            //             cols: 0
            //         },
            //         success: function (result) {
            //             var service = {};
            //             $('#table_form').html(result);
            //         },
            //     });

            // }

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
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }
}

?>
