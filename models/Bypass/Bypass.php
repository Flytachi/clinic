<?php

class BypassModel extends Model
{
    public $table = 'bypass';

    public function form($pk = null)
    {
        global $db, $patient, $methods, $classes;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <?php if(module('module_diet')): ?>
					<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
                        <li class="nav-item">
                            <a onclick="Tab_Diet_Preparat(this, 0)" href="#" class="nav-link legitRipple active show" style="white-space:nowrap;" data-toggle="tab"><i class="icon-clipboard6 mr-1"></i>Препараты</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="Tab_Diet_Preparat(this, 1)" href="#" class="nav-link legitRipple" style="white-space:nowrap;" data-toggle="tab"><i class="icon-add mr-1"></i>Диета</a>
                        </li>
                    </ul>
                <?php endif; ?>
                
                <div id="div_live">

                    <div class="form-group row">

                        <?php if(module('module_pharmacy')): ?>
                            <div class="col-md-9">
                                <label>Препараты:</label>
                                <select id="select_preparat" class="<?= $classes['form-multiselect'] ?>" data-placeholder="Выбрать препарат" name="preparat[]" multiple="multiple">
                                    <?php $sql = "SELECT st.id, st.price, st.name, st.supplier, st.die_date,
                                        ( 
                                            st.qty -
                                            IFNULL((SELECT SUM(opp.item_qty) FROM operation op LEFT JOIN operation_preparat opp ON(opp.operation_id=op.id) WHERE op.completed IS NULL AND opp.item_id=st.id), 0) -
                                            IFNULL((SELECT SUM(sto.qty) FROM storage_orders sto WHERE sto.preparat_id=st.id), 0)
                                        ) 'qty'
                                        FROM storage st WHERE st.category = 2 AND st.qty != 0";?>
                                    <?php foreach ($db->query($sql) as $row): ?>
                                        <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>) в наличии - <?= $row['qty'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        

                        <div class="col-md-3">
                            <label>Сторонний препарат:</label>
                            <button onclick="AddPreparat()" class="btn btn-outline-success btn-sm legitRipple" type="button"><i class="icon-plus22 mr-2"></i>Добавить препарат</button>
                        </div>

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

                    <div class="form-group row">

                        <div class="col-md-6">
                            <label>Метод:</label>
                            <select data-placeholder="Выбрать метод" name="method" class="<?= $classes['form-select'] ?>" required>
                                <option></option>
                                <?php foreach ($methods as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <div class="col-md-6">
                            <label>Описание:</label>
                            <input type="text" class="form-control" name="description" placeholder="Введите описание">
                        </div>

                    </div>

                    <legend><b>Время принятия:</b></legend>
                    <div class="form-group row" id="time_div">
                        <div class="col-md-3" id="time_input_0">
                            <input type="time" name="time[0]" class="form-control" required>
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button onclick="AddinputTime()" id="bypass_button_AddinputTime" type="button" class="btn btn-outline-success btn-sm"><i class="icon-plus22 mr-2"></i>Добавить время</button>
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            let i = 1;
            let s = 0;
            function AddinputTime(time = null) {
                $('#time_div').append(`
                    <div class="col-md-3" id="time_input_${i}">
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="time" name="time[${i}]" class="form-control" value="${time}" required>
                            <div class="form-control-feedback text-danger">
                                <i class="icon-minus-circle2" onclick="$('#time_input_${i}').remove();"></i>
                            </div>
                        </div>
                    </div>
                `);
                i++;
            }

            function AddPreparat() {
                $('#preparat_div_outside').append(`
                <tr class="table-secondary" id="preparat_outside_tr-${s}">
                    <td>
                        <div class="form-group-feedback form-group-feedback-right">
                            <input class="form-control" type="text" name="preparat_outside[${s}]" required style="border-width: 0px 0; padding: 0.2rem 0;">
                            <div class="form-control-feedback text-danger">
                                <i class="icon-minus-circle2" onclick="$('#preparat_outside_tr-${s}').remove();"></i>
                            </div>
                        </div>
                    </td>
                    <td class="text-right">
                        <input type="number" class="form-control" name="qty_outside[${s}]" value="1" min="1" style="border-width: 0px 0; padding: 0.2rem 0;" required>
                    </td>
                </tr>`);
                s++;
            }

            $('#select_preparat').on('change', function(events){
                // $('#preparat_div').html();

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('bypass_table') ?>",
                    data: $('#select_preparat').serializeArray(),
                    success: function (result) {
                        $('#preparat_div').html(result);
                    },
                });

            });

            function Tab_Diet_Preparat(params, t) {
                $.ajax({
                    type: "POST",
                    url: "<?= ajax('bypass_table_checkout') ?>",
                    data: { type:t },
                    success: function (result) {
                        $('#div_live').html(result);
                    },
                });
            }
        </script>
        <?php
    }

    public function save()
    {
        global $db;
        if($this->clean()){
            $db->beginTransaction();
            $object = Mixin\insert($this->table, $this->post);
            if (intval($object)){
                $this->set_table('bypass_preparat');
                $this->preparats_create($object);

                $this->set_table('bypass_time');
                $this->time_create($object);

                $db->commit();
                $this->success();
                $this->dd();
            }else{
                $this->error($object);
            }
        }
    }

    public function preparats_create(Int $object)
    {
        global $db;
        if ($this->post_preparat) {
            foreach ($this->post_preparat as $value) {
                $storage = $db->query("SELECT name, supplier, die_date FROM storage WHERE id = $value")->fetch();
                $object1 = Mixin\insert($this->table, array(
                    'bypass_id' => $object,
                    'preparat_id' => $value,
                    'preparat_name' => $storage['name'],
                    'preparat_supplier' => $storage['supplier'],
                    'preparat_die_date' => $storage['die_date'],
                    'qty' => $this->post_qty[$value],
                ));
                if (!intval($object1)) {
                    $this->error($object1);
                }
            }
        }
        if ($this->post_preparat_outside) {
            foreach ($this->post_preparat_outside as $key => $value) {
                $object1 = Mixin\insert($this->table, array(
                    'bypass_id' => $object,
                    'preparat_id' => null,
                    'preparat_name' => $value,
                    'preparat_supplier' => null,
                    'preparat_die_date' => null,
                    'qty' => $this->post_qty_outside[$key],
                ));
                if (!intval($object1)) {
                    $this->error($object1);
                }
            }
        }
    }

    public function time_create(Int $object)
    {
        global $db;
        foreach ($this->post_time as $value) {
            $object1 = Mixin\insert($this->table, array(
                'bypass_id' => $object,
                'time' => $value,
            ));
            if (!intval($object1)) {
                $this->error($object1);
            }
        }
    }

    public function clean()
    {
        $this->post_preparat_outside = $this->post['preparat_outside'];
        $this->post_qty_outside = $this->post['qty_outside'];
        $this->post_preparat = $this->post['preparat'];
        $this->post_time = $this->post['time'];
        $this->post_qty = $this->post['qty'];
        unset($this->post['preparat_outside']);
        unset($this->post['qty_outside']);
        unset($this->post['preparat']);
        unset($this->post['time']);
        unset($this->post['qty']);
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
        // $this->dd();
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}

?>
