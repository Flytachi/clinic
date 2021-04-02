<?php

class BypassModel extends Model
{
    public $table = 'bypass';

    public function form($pk = null)
    {
        global $db, $patient, $methods;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <legend><b>Препараты:</b></legend>

                <div class="form-group row">

                    <div class="col-md-12">

                        <label>Препарат:</label>
                        <select id="select_preparat" class="form-control multiselect-full-featured" data-placeholder="Выбрать препарат" name="preparat[]" multiple="multiple" required data-fouc>
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
                        </table>
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Метод:</label>
                        <select data-placeholder="Выбрать метод" name="method" class="form-control form-control-select2" required>
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

            <div class="modal-footer">
                <button onclick="AddinputTime()" type="button" class="btn btn-outline-success btn-sm"><i class="icon-plus22 mr-2"></i>Добавить время</button>
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            var i = 0;
            function AddinputTime() {
                i++;
                $('#time_div').append(`
                    <div class="col-md-3" id="time_input_${i}">
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="time" name="time[${i}]" class="form-control" required>
                            <div class="form-control-feedback text-danger">
                                <i class="icon-minus-circle2" onclick="$('#time_input_`+ i +`').remove();"></i>
                            </div>
                        </div>
                    </div>
                `);
            }

            $('#select_preparat').on('change', function(events){
                // $('#preparat_div').html();

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('bypass_table') ?>",
                    data: $('#select_preparat').serializeArray(),
                    success: function (result) {
                        console.log(result);
                        $('#preparat_div').html(result);
                    },
                });
                // $('#select_preparat').val().forEach(function(i) {
                //     $('#preparat_div').append(`
                //         <tr class="table-secondary">
                //             <td>${i}</td>
                //             <td class="text-right">
                //                 <input type="number" class="form-control" name="qty[${i}]" value="1" style="border-width: 0px 0; padding: 0.2rem 0;">
                //             </td>
                //         </tr>
                //     `);
                // });

            })
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
                $this->set_table('bypass_time');
                foreach ($this->post_time as $value) {
                    $object1 = Mixin\insert($this->table, array(
                        'bypass_id' => $object,
                        'time' => $value,
                    ));
                    if (!intval($object1)) {
                        $this->error($object1);
                    }
                }
                $db->commit();
                $this->success();
            }else{
                $this->error($object);
            }
        }
    }

    public function clean()
    {
        $this->post_preparat = $this->post['preparat'];
        $this->post_time = $this->post['time'];
        $this->post_qty = $this->post['qty'];
        unset($this->post['preparat']);
        unset($this->post['time']);
        unset($this->post['qty']);
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}

?>
