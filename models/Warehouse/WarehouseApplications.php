<?php

class WarehouseApplicationsModel extends Model
{
    public $table = 'warehouse_applications';

    public function store($status = 1)
    {
        global $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <div class="form-group-feedback form-group-feedback-right">

            <input type="text" class="<?= $classes['input-product_search'] ?>" id="search_input_product" placeholder="Поиск..." title="Введите название препарата">
            <div class="form-control-feedback">
                <i class="icon-search4 font-size-base text-muted"></i>
            </div>

        </div>

        <div class="form-group">

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="bg-dark">
                            <th>Наименование</th>
                            <th style="width:370px">Производитель</th>
                            <th class="text-center" style="width:150px">На складе</th>
                            <th style="width:100px">Кол-во</th>
                            <th class="text-center" style="width:50px">#</th>
                        </tr>
                    </thead>
                    <tbody id="table_form">

                    </tbody>
                </table>
            </div>

        </div>
        <script type="text/javascript">

            $("#search_input_product").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'WarehouseCommonPanel') ?>",
                    data: {
                        warehouse_id: "<?= $_GET['pk'] ?>", 
                        status: <?= $status ?>,
                        search: this.value, 
                    },
                    success: function (result) {
                        $('#table_form').html(result);
                    },
                });
            });

        </script>
        <?php
    }

    public function clean()
    {
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
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }
}


class WarehouseApplications extends WarehouseApplicationsModel
{
    public function success()
    {
        echo "success";
    }

    public function error($message)
    {
        echo $message;
    }
}



class WarehouseApplicationsCompleted extends WarehouseApplicationsModel
{
    public $_common_transactions = 'warehouse_common_transactions';
    public $_application = 'warehouse_applications';
    public $_common = 'warehouse_common';
    public $_custom = 'warehouse_custom';

    public function save()
    {
        global $db, $session;
        if($this->clean()){
            $db->beginTransaction();

            if ( isset($this->post['rejection']) ) {
                // Application rejection
                $object = Mixin\update($this->_application, array('status' => 4), array('id' => $this->post['applications']));
                if (!intval($object)) {
                    $db->rollBack();
                }

            } else {
                // Application complete
                $object = Mixin\update($this->_application, array('status' => 3), array('id' => $this->post['applications']));
                if (!intval($object)) {
                    $db->rollBack();
                }
    
                $this->template();
    
                foreach ($this->post['item'] as $id => $qty) {
                    if ($qty > 0) {
                        if ( $item = $db->query("SELECT * FROM $this->_common WHERE id = $id")->fetch() ) {
    
                            // Warehouse common delete
                            if ($item['item_qty']-$qty == 0) Mixin\delete($this->_common, $id);
                            else Mixin\update($this->_common, array('item_qty' => ($item['item_qty']-$qty)), $id);
    
                            // Create transaction
                            $transaction_post = array(
                                'warehouse_id' => $this->post['warehouse_id'],
                                'item_id' => $id,
                                'item_name' => $this->names[$item['item_name_id']],
                                'item_manufacturer' => $this->manufacturers[$item['item_manufacturer_id']],
                                'item_qty' => -$qty,
                                'item_price' => $item['item_price'],
                                'tran_status' => 1,
                                'responsible_id' => $session->session_id,
                                'cost' => -$qty*$item['item_price'],
                            );
                            Mixin\insert($this->_common_transactions, $transaction_post);
    
                            // Warehouse custom add
                            $where = "warehouse_id = {$this->post['warehouse_id']} AND item_name_id = {$item['item_name_id']} AND item_manufacturer_id = {$item['item_manufacturer_id']}";
                            $where .= " AND item_price = {$item['item_price']} AND DATE(item_die_date) = DATE('".$item['item_die_date']."')";
                            $obj = $db->query("SELECT id, item_qty FROM $this->_custom WHERE $where")->fetch();
                            if ($obj) Mixin\update($this->_custom, array('item_qty' => $obj['item_qty']+$qty), $obj['id']);
                            else{
                                $custom_post = array(
                                    'warehouse_id' => $this->post['warehouse_id'],
                                    'item_name_id' => $item['item_name_id'],
                                    'item_manufacturer_id' => $item['item_manufacturer_id'],
                                    'item_qty' => $qty,
                                    'item_price' => $item['item_price'],
                                    'item_die_date' => $item['item_die_date'],
                                );
                                Mixin\insert($this->_custom, $custom_post);
                                unset($custom_post);
                            }
                            unset($transaction_post);
                            
                        }else {
                            $db->rollBack();
                        }
                    }
                }
                
            }
            
            $db->commit();
            $this->success();
        }
    }

    public function template()
    {
        global $db;
        $this->names = $this->manufacturers = $this->suppliers = [];
        foreach ($db->query("SELECT id, name FROM warehouse_item_names")->fetchAll() as $n) $this->names[$n['id']] = $n['name'];
        foreach ($db->query("SELECT id, manufacturer FROM warehouse_item_manufacturers")->fetchAll() as $n) $this->manufacturers[$n['id']] = $n['manufacturer'];
    }

}

?>