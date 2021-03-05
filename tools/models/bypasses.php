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

class BypassDateModel extends Model
{
    public $table = 'bypass_date';

    public function table_form_doc($pk = null)
    {
        global $db, $methods, $grant;
        $this_date = new \DateTime();
        $bypass = $db->query("SELECT user_id, add_date FROM bypass WHERE id = {$_GET['pk']}")->fetch();
        $add_date = date('Y-m-d', strtotime($bypass['add_date']));
        $first_date = date_diff(new \DateTime(), new \DateTime($add_date))->days;
        $col = $db->query("SELECT id, time FROM bypass_time WHERE bypass_id = {$_GET['pk']} ORDER BY time ASC")->fetchAll();
        $span = count($col);
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="text-right">
                <button onclick="AddTrDate()" type="button" class="btn btn-outline-success btn-sm" style="margin-bottom:20px"><i class="icon-plus22 mr-2"></i>Добавить день</button>
            </div>

            <div class="table-responsive">
                <table class="table table-xs table-bordered">
                    <thead>
                        <tr class="bg-info">
                            <th style="width: 50px">№</th>
                            <th style="width: 50%">Дата</th>
                            <th style="width: 30%">Время</th>
                            <th colspan="2" class="text-center">Коструктор</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $day_show = 5;
                        $max_day_show = 30;
                        $s = 0;
                        for ($i=-$first_date; $i < $max_day_show; $i++) {
                            $s++;
                            $row_stat = True;
                            foreach ($col as $value) {
                                ?>
                                <tr <?= ($s>$day_show) ? 'class="table_date_hidden" style="display:none;"' : 'class="table_date"' ?>>
                                    <?php if ($row_stat): ?>
                                        <td rowspan="<?= $span ?>"><?= $s ?></td>
                                        <td rowspan="<?= $span ?>">
                                            <?php
                                            $date = new \DateTime();
                                            $date->modify("+$i day");
                                            echo $date->format('d.m.Y');
                                            ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php
                                    $dat = $date->format('Y-m-d');
                                    $post = $db->query("SELECT * FROM bypass_date WHERE bypass_id = {$_GET['pk']} AND time = \"{$value['time']}\" AND date = \"$dat\"")->fetch();
                                    ?>
                                    <td>
                                        <?= $time = date('H:i', strtotime($value['time'])) ?>
                                    </td>
                                    <td>
                                        <?php if ($dat." ".$time < $this_date->format('Y-m-d H:i')): ?>
                                            <?php if ($post['status']): ?>
                                                <i style="font-size:1.5rem;" class="icon-checkmark-circle"></i>
                                            <?php else: ?>
                                                <i style="font-size:1.5rem;" class="icon-circle"></i>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if ($post['completed']): ?>
                                                <i style="font-size:1.5rem;" class="icon-checkmark-circle"></i>
                                            <?php else: ?>
                                                <?php if ($grant): ?>
                                                    <?php if ($post['status']): ?>
                                                        <i style="font-size:1.5rem;" class="text-success icon-checkmark-circle" onclick="SwetDate(this)" data-id="<?= $post['id'] ?>" data-date="<?= $date->format('Y-m-d') ?>" data-time="<?= $value['time'] ?>" data-val=""></i>
                                                    <?php else: ?>
                                                        <i style="font-size:1.5rem;" class="text-success icon-circle" onclick="SwetDate(this)" data-id="<?= $post['id'] ?>" data-date="<?= $date->format('Y-m-d') ?>" data-time="<?= $value['time'] ?>" data-val="1"></i>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php if ($post['status']): ?>
                                                        <i style="font-size:1.5rem;" class="icon-checkmark-circle"></i>
                                                    <?php else: ?>
                                                        <i style="font-size:1.5rem;" class="icon-circle"></i>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($post['completed']): ?>
                                            <i style="font-size:1.5rem;" class="icon-checkmark-circle tolltip" data-head="<?= get_full_name($post['parent_id']) ?>" data-content="<?= $post['comment'] ?>"></i>
                                        <?php else: ?>
                                            <i style="font-size:1.5rem;" class="icon-circle"></i>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                                $row_stat= False;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </form>
        <script type="text/javascript">
            $(".tolltip").on('mouseenter', function() {
                $(this).popover({
                    title: event.target.dataset.head,
                    content: event.target.dataset.content,
                    placement: 'top'
                })
                $(this).popover('show');
            }).on('mouseleave', function() {
                $(this).popover('hide');
            });

            function AddTrDate() {
                for (var i = 0; i < Number("<?= $span ?>"); i++) {
                    var tr = $('.table_date_hidden').first();
                    tr.removeClass("table_date_hidden");
                    tr.addClass("table_date");
                    tr.fadeIn();
                }
            }

            function SwetDate(swet_input) {
                var form = $('#<?= __CLASS__ ?>_form');
                var products = [], i = 0;
                document.querySelectorAll('.products').forEach(function(events) {
                    products[i] = $(events).val();
                    i++;
                });

                if (swet_input.dataset.id) {
                    var data = {
                        model: "<?= __CLASS__ ?>",
                        bypass_id: "<?= $_GET['pk'] ?>",
                        id: swet_input.dataset.id,
                        user_id: "<?= $bypass['user_id'] ?>",
                        time: swet_input.dataset.time,
                        date: swet_input.dataset.date,
                        status: swet_input.dataset.val,
                        products: products
                    };
                }else {
                    var data = {
                        model: "<?= __CLASS__ ?>",
                        bypass_id: "<?= $_GET['pk'] ?>",
                        user_id: "<?= $bypass['user_id'] ?>",
                        time: swet_input.dataset.time,
                        date: swet_input.dataset.date,
                        status: swet_input.dataset.val,
                        products: products
                    };
                }
                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: data,
                    success: function (result) {
                        if (!Number(result) && result != "success") {
                            new Noty({
                                text: result,
                            type: 'error'
                            }).show();
                        }else if(Number(result)){
                            swet_input.dataset.id = result;
                            if (swet_input.dataset.val == 1) {
                                $(swet_input).removeClass('icon-circle');
                                $(swet_input).addClass('icon-checkmark-circle');
                                swet_input.dataset.val = "";
                            }else if(swet_input.dataset.val == ""){
                                $(swet_input).removeClass('icon-checkmark-circle');
                                $(swet_input).addClass('icon-circle');
                                swet_input.dataset.val = 1;
                            }
                        }else {
                            if (swet_input.dataset.val == 1) {
                                $(swet_input).removeClass('icon-circle');
                                $(swet_input).addClass('icon-checkmark-circle');
                                swet_input.dataset.val = "";
                            }else if(swet_input.dataset.val == ""){
                                $(swet_input).removeClass('icon-checkmark-circle');
                                $(swet_input).addClass('icon-circle');
                                swet_input.dataset.val = 1;
                            }
                        }
                    },
                });
            }
        </script>
        <?php
    }

    public function table_form_nurce($pk = null)
    {
        global $db, $methods;
        $this_date = new \DateTime();
        $bypass = $db->query("SELECT user_id, visit_id, add_date FROM bypass WHERE id = {$_GET['pk']}")->fetch();
        $add_date = date('Y-m-d', strtotime($bypass['add_date']));
        $first_date = date_diff(new \DateTime(), new \DateTime($add_date))->days;
        $col = $db->query("SELECT id, time FROM bypass_time WHERE bypass_id = {$_GET['pk']} ORDER BY time ASC")->fetchAll();
        $span = count($col);
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="table-responsive">
                <table class="table table-xs table-bordered">
                    <thead>
                        <tr class="bg-info">
                            <th style="width: 50px">№</th>
                            <th style="width: 50%">Дата</th>
                            <th style="width: 30%">Время</th>
                            <th colspan="2" class="text-center">Коструктор</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $day_show = 5;
                        $max_day_show = 30;
                        $s = 0;
                        $tr = 0;
                        for ($i=-2; $i < $max_day_show; $i++) {
                            $s++;
                            $row_stat = True;
                            foreach ($col as $value) {
                                $tr++;
                                ?>
                                <tr <?= ($s>$day_show) ? 'class="table_date_hidden" style="display:none;"' : 'class="table_date"' ?>>
                                    <?php if ($row_stat): ?>
                                        <td rowspan="<?= $span ?>"><?= $s ?></td>
                                        <td rowspan="<?= $span ?>">
                                            <?php
                                            $date = new \DateTime();
                                            $date->modify("+$i day");
                                            echo $date->format('d.m.Y');
                                            ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php
                                    $dat = $date->format('Y-m-d');
                                    $post = $db->query("SELECT * FROM bypass_date WHERE bypass_id = {$_GET['pk']} AND time = \"{$value['time']}\" AND date = \"$dat\"")->fetch();
                                    ?>
                                    <td>
                                        <?= date('H:i', strtotime($value['time'])) ?>
                                    </td>
                                    <td class="text-dar text-center">
                                        <?php if ($post['status']): ?>
                                            <i style="font-size:1.5rem;" class="icon-checkmark-circle"></i>
                                        <?php else: ?>
                                            <i style="font-size:1.5rem;" class="icon-circle"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td id="tr_<?= $tr ?>">
                                        <?php if ($dat < $this_date->format('Y-m-d')): ?>
                                            <?php if ($post['completed']): ?>
                                                <i style="font-size:1.5rem;" class="text-dark icon-checkmark-circle tolltip" data-head="<?= get_full_name($post['parent_id']) ?>" data-content="<?= $post['comment'] ?>"></i>
                                            <?php elseif($post['status'] and $dat == $this_date->format('Y-m-d')): ?>
                                                <i style="font-size:1.5rem;" class="text-dark icon-circle"></i>
                                            <?php else: ?>
                                                <i style="font-size:1.5rem;" class="text-dark icon-circle"></i>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if ($post['completed']): ?>
                                                <i style="font-size:1.5rem;" class="text-success icon-checkmark-circle tolltip" data-head="<?= get_full_name($post['parent_id']) ?>" data-content="<?= $post['comment'] ?>"></i>
                                            <?php elseif($post['status'] and $dat == $this_date->format('Y-m-d')): ?>
                                                <i style="font-size:1.5rem;" class="text-success icon-circle" onclick="SwetDate('#tr_<?= $tr ?>')" data-id="<?= $post['id'] ?>" data-value="1"></i>
                                            <?php else: ?>
                                                <i style="font-size:1.5rem;" class="text-dark icon-circle"></i>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                                $row_stat= False;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </form>
        <script type="text/javascript">
            $(".tolltip").on('mouseenter', function() {
                $(this).popover({
                    title: event.target.dataset.head,
                    content: event.target.dataset.content,
                    placement: 'top'
                })
                $(this).popover('show');
            }).on('mouseleave', function() {
                $(this).popover('hide');
            });

            function SwetDate(tr) {
                var form = $('#<?= __CLASS__ ?>_form');
                var products = [], i = 0;
                document.querySelectorAll('.products').forEach(function(events) {
                    products[i] = $(events).val();
                    i++;
                });
                if (comment = prompt('Примечание', '')) {
                    var data = {
                        model: "<?= __CLASS__ ?>",
                        bypass_id: "<?= $_GET['pk'] ?>",
                        visit_id: "<?= $bypass['visit_id'] ?>",
                        id: event.target.dataset.id,
                        completed: event.target.dataset.value,
                        user_id: "<?= $bypass['user_id'] ?>",
                        parent_id: "<?= $_SESSION['session_id'] ?>",
                        comment: comment,
                        products: products
                    }
                }else {
                    var data = {
                        model: "<?= __CLASS__ ?>",
                        bypass_id: "<?= $_GET['pk'] ?>",
                        visit_id: "<?= $bypass['visit_id'] ?>",
                        id: event.target.dataset.id,
                        completed: event.target.dataset.value,
                        user_id: "<?= $bypass['user_id'] ?>",
                        parent_id: "<?= $_SESSION['session_id'] ?>",
                        products: products
                    }
                }

                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: data,
                    success: function (result) {
                        if (!Number(result)) {
                            if (result != "success") {
                                new Noty({
                                    text: result,
                                type: 'error'
                                }).show();
                            }else {
                                $(tr).html('<i style="font-size:1.5rem;" class="text-success icon-checkmark-circle"></i>');
                            }
                        }
                    },
                });

            }
        </script>
        <?php
    }

    public function clean()
    {
        global $db, $patient;
        if ($this->post['products']) {
            $user_pk = $this->post['user_id'];
            if ($this->post['completed']) {
                // Медсестра
                $db->beginTransaction();
                foreach ($this->post['products'] as $value){
                    $qty = $db->query("SELECT qty FROM bypass_preparat WHERE bypass_id = {$this->post['bypass_id']} AND preparat_id = $value")->fetchColumn();
                    $post = $db->query("SELECT id, preparat_id 'item_id', price 'item_cost', name 'item_name', qty, qty_sold, category 'item_type' FROM storage_home WHERE preparat_id = $value")->fetch();
                    if(!$post){
                        $this->error("Не осталось препарата ".$value);
                        $this->stop();
                    }
                    $post['visit_id'] = $this->post['visit_id'];
                    $post['user_id'] = $user_pk;
                    if ($post['qty'] <= $qty) {
                        $object = Mixin\delete('storage_home', $post['id']);
                    }else {
                        $object = Mixin\update('storage_home', array('qty' => $post['qty']-$qty, 'qty_sold' => $post['qty_sold']+$qty), $post['id']);
                    }
                    if (!intval($object)) {
                        $this->error('storage_preparat'.$object);
                    }
                    unset($post['qty_sold']);
                    unset($post['qty']);
                    unset($post['id']);
                    for ($i=0; $i < $qty; $i++) {
                        $object1 = Mixin\insert('visit_price', $post);
                        if (!intval($object1)) {
                            $this->error('visit_price'.$object1);
                            $this->stop();
                        }
                    }
                }
                $db->commit();
            }else {
                // Доктор
                if ($this->post['status']) {

                    $db->beginTransaction();
                    foreach ($this->post['products'] as $value){
                        $qty = $db->query("SELECT qty FROM bypass_preparat WHERE bypass_id = {$this->post['bypass_id']} AND preparat_id = $value")->fetchColumn();
                        $store = $db->query("SELECT qty FROM storage WHERE id = $value")->fetchColumn();
                        $orders = $db->query("SELECT SUM(qty) FROM storage_orders WHERE preparat_id =$value")->fetchColumn();
                        if(!$store or ($store-$orders) < $qty){
                            $this->error("Не осталось препарата ".$store);
                            $this->stop();
                        }
                        $post = $db->query("SELECT * FROM storage_orders WHERE user_id = {$this->post['user_id']} AND parent_id = {$_SESSION['session_id']} AND preparat_id = $value AND date = '".$this->post['date']."'")->fetch();
                        if ($post) {
                            $post_pk = $post['id'];
                            unset($post['id']);
                            $post['qty'] += $qty;
                            $post['date'] = $this->post['date'];
                            $object = Mixin\update('storage_orders', $post, $post_pk);
                        }else {
                            $post = array(
                                'user_id' => $this->post['user_id'],
                                'parent_id' => $_SESSION['session_id'],
                                'preparat_id' => $value,
                                'qty' => $qty,
                                'date' => $this->post['date']
                            );
                            $object = Mixin\insert('storage_orders', $post);
                        }
                        if (!intval($object)) {
                            $this->error('storage_orders: '.$object);
                        }
                    }
                    $db->commit();

                } else {

                    $db->beginTransaction();
                    foreach ($this->post['products'] as $value){
                        $qty = $db->query("SELECT qty FROM bypass_preparat WHERE bypass_id = {$this->post['bypass_id']} AND preparat_id = $value")->fetchColumn();
                        $post = $db->query("SELECT * FROM storage_orders WHERE user_id = {$this->post['user_id']} AND parent_id = {$_SESSION['session_id']} AND preparat_id = $value AND date = '".$this->post['date']."'")->fetch();
                        if ($post['qty'] > $qty) {
                            $post_pk = $post['id'];
                            unset($post['id']);
                            $post['qty'] -= $qty;
                            $object = Mixin\update('storage_orders', $post, $post_pk);
                        }else {
                            $object = Mixin\delete('storage_orders', $post['id']);
                        }
                    }
                    $db->commit();

                }
            }
            unset($this->post['user_id']);
            unset($this->post['products']);
            if ($this->post['visit_id']) {
                unset($this->post['visit_id']);
            }
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function save()
    {
        if($this->clean()){
            $object = Mixin\insert($this->table, $this->post);
            if (intval($object)){
                $this->success($object);
            }else{
                $this->error($object);
            }
        }
    }

    public function success($message=null)
    {
        if ($message) {
            echo $message;
        }else {
            echo "success";
        }
    }

    public function error($message)
    {
        echo $message;
    }
}

?>
