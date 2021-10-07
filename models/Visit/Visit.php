<?php

class VisitModel extends Model
{
    public $table = 'visits';
    public $table2 = 'beds';
    public $_user = 'users';
    public $_beds = 'visit_beds';
    public $_orders = 'visit_orders';
    public $_bed_types = 'bed_types';
    public $_service = 'visit_services';
    public $_transactions = 'visit_service_transactions';

    public function form_grant($pk = null)
    {
        global $db, $classes;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Переназначить лечащего врача</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <label>Отдел:</label>
                        <select data-placeholder="Выберите отдел" id="division_id" name="division_id" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                            <?php foreach($db->query("SELECT * from divisions WHERE level = 5") as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= (division($this->value('grant_id')) == $row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Специалиста:</label>
                        <select data-placeholder="Выберите специалиста" name="grant_id" id="parent_id" class="<?= $classes['form-select'] ?>" required>
                            <?php foreach($db->query("SELECT * from users WHERE user_level = 5 AND is_active IS NOT NULL") as $row): ?>
                                <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" <?= ($this->value('grant_id') == $row['id']) ? "selected" : "" ?>><?= get_full_name($row['id']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Переназначить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#parent_id").chained("#division_id");
            });
        </script>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function form_icd($pk = null)
    {
        global $db, $classes, $session;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Назначить диагноз</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="icd_autor" value="<?= $session->session_id ?>">

            <div class="modal-body">

                <div class="form-group">
                    <label>ICD (МКБ):</label>
                    <select data-placeholder="Выберите диагноз" name="icd_id" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach($db->query("SELECT * from international_classification_diseases") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($this->value('icd_id') == $row['id']) ? "selected" : "" ?>><?= $row['decryption'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Назначить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function create_or_update_visit()
    {
        global $db;
        $post = array(
            'parad_id' => ( isset($this->post['direction']) ) ? $db->query("SELECT IFNULL(MAX(parad_id), 0) FROM $this->table WHERE direction IS NOT NULL")->fetchColumn() + 1 : null,
            'grant_id' => ( isset($this->post['direction']) and $this->post['direction'] ) ? $this->post['parent_id'] : null,
            'user_id' => ($this->post['user_id']) ? $this->post['user_id'] : null,
            'direction' => ( isset($this->post['direction']) ) ? $this->post['direction'] : null,
            'division_id' => ( isset($this->post['direction']) ) ? $this->post['division_id'] : null,
        );
        $object = Mixin\insert_or_update($this->table, $post, 'user_id', "completed IS NULL");
        if (!intval($object)) {
            $this->error("Ошибка создании или обновлении визита!");
            $db->rollBack();
        }else{
            $this->visit_pk = $object;
            $this->is_foreigner = $db->query("SELECT is_foreigner FROM $this->_user WHERE id = {$this->post['user_id']}")->fetchColumn();
            $this->chek_order();
        }
    }

    public function add_visit_service($key = null, $value)
    {
        global $db;
        $data = $db->query("SELECT * FROM services WHERE id = $value")->fetch();
        if ( isset($this->post['direction']) and $this->post['direction'] ) {
            $post['division_id'] = $this->post['division_id'];
        }else{
            if ( isset($this->post['division_id'][$key]) and $this->post['division_id'][$key] ) {
                $post['division_id'] = $this->post['division_id'][$key];
            }
        }

        $post['visit_id'] = $this->visit_pk;
        $post['user_id'] = $this->post['user_id'];
        $post['parent_id'] = (isset($this->post['direction']) and $this->post['direction']) ? $this->post['parent_id'] : $this->post['parent_id'][$key];
        $post['route_id'] = $_SESSION['session_id'];
        $post['guide_id'] = $this->post['guide_id'];
        $post['level'] = ( isset($post['division_id']) and $post['division_id'] ) ? $db->query("SELECT level FROM divisions WHERE id = {$post['division_id']}")->fetchColumn() : $this->post['level'][$key];
        $post['status'] = ( (isset($this->post['direction']) and $this->post['direction']) or (isset($this->is_order) and $this->is_order) ) ? 2 : 1;
        $post['service_id'] = $data['id'];
        $post['service_name'] = $data['name'];
   
        $count = (isset($this->post['direction']) and $this->post['direction']) ? 1 : $this->post['count'][$key];
        for ($i=0; $i < $count; $i++) {
            $post = Mixin\clean_form($post);
            $post = Mixin\to_null($post);
            $object = Mixin\insert($this->_service, $post);
            if (!intval($object)){
                $this->error("Ошибка при создании услуги!");
                $db->rollBack();
            }
            
            if ( empty($this->is_order) or (isset($this->is_order) and !$this->is_order) ) {
                if (empty($this->post['direction']) or (!permission([2, 32]) and isset($this->post['direction']) and $this->post['direction'])) {
                    $post_price['visit_id'] = $this->visit_pk;
                    $post_price['visit_service_id'] = $object;
                    $post_price['user_id'] = $this->post['user_id'];
                    $post_price['item_type'] = $data['type'];
                    $post_price['item_id'] = $data['id'];
                    $post_price['item_cost'] = ($this->is_foreigner) ? $data['price_foreigner'] : $data['price'];
                    $post_price['item_name'] = $data['name'];
                    $post_price['is_visibility'] = (isset($this->post['direction']) and $this->post['direction']) ? null : 1;
                    $object = Mixin\insert($this->_transactions, $post_price);
                    if (!intval($object)){
                        $this->error("Ошибка при создании платежа услуги!");
                        $db->rollBack();
                    }
                } 
            }
        }
        unset($post);
    }

    public function add_visit_bed()
    {
        global $db, $session;
        $bed_data = $db->query("SELECT * FROM $this->table2 WHERE id = {$this->post['bed']}")->fetch();
        $bed_types = $db->query("SELECT * FROM  $this->_bed_types WHERE id = {$bed_data['type_id']}")->fetch();

        $post = array(
            'visit_id' => $this->visit_pk,
            'parent_id' => $session->session_id,
            'user_id' => $this->post['user_id'],
            'bed_id' => $this->post['bed'],
            'location' => "{$bed_data['building']} {$bed_data['floor']} этаж {$bed_data['ward']} палата {$bed_data['bed']} койка",
            'type' => $bed_data['types'],
            'cost' => ($this->is_foreigner) ? $bed_types['price_foreigner'] : $bed_types['price'],
        );

        $object = Mixin\insert($this->_beds, $post);
        if (!intval($object)) {
            $this->error("Ошибка при создании платежа для койки!");
            $db->rollBack();
        }

        $object2 = Mixin\update($this->table2, array('user_id' => $this->post['user_id']), $this->post['bed']);
        if (!intval($object2)){
            $this->error("Ошибка при бронировании пациентом койки!");
            $db->rollBack();
        }
    }

    public function chek_order()
    {
        global $db, $session;
        if ($db->query("SELECT id FROM $this->_orders WHERE visit_id = $this->visit_pk")->fetchColumn()) {
            $this->is_order = True;
        }else if (isset($this->post['order_status'])) {
            $post = Mixin\clean_form($this->post['order']);
            $post = Mixin\to_null($post);
            $post['visit_id'] = $this->visit_pk;
            $post['parent_id'] = $session->session_id;
            $post['user_id'] = $this->post['user_id'];
            $object = Mixin\insert($this->_orders, $post);
            if (!intval($object)) {
                $this->error($object);
                $db->rollBack();
                $this->error("Ошибка при создании ордера!");
            }
            $this->is_order = True;
        }
    }

    public function save()
    {
        global $db;
        if($this->clean()){

            $db->beginTransaction();

            $this->create_or_update_visit();
            if (isset($this->post['service']) and is_array($this->post['service'])) {
                
                foreach ($this->post['service'] as $key => $value) {
                    $this->add_visit_service($key, $value);
                }

            }else{
                
                $this->add_visit_service(null, 1);
                $this->add_visit_bed();
                
            }

            // Обновление статуса у пациента
            $object1 = Mixin\update($this->_user, array('status' => True), $this->post['user_id']);
            if (!intval($object1)){
                $this->error("Ошибка в обновление статуса пациента!");
                $db->rollBack();
            }
            
            $db->commit();
            $this->success();

        }
    }

    public function update()
    {
        global $db, $session;
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);

            $db->beginTransaction();
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
                $db->rollBack();
            }
            if ($this->post['grant_id']) {
                $data = $db->query("SELECT id, user_id, level, status, service_id, service_name FROM $this->_service WHERE visit_id = $pk AND service_id = 1 AND status = 3")->fetch();
                $data['visit_id'] = $pk;
                $data['parent_id'] = $this->post['grant_id'];
                $data['route_id'] = $session->session_id;
                $data['division_id'] = $this->post['division_id'];
                $data['status'] = 2;
                $old = $data['id']; unset($data['id']);
                Mixin\update($this->_service, array('status' => 6), $old);
                Mixin\insert($this->_service, $data);
            }

            $db->commit();
            $this->success();
        }
    }

    public function clean()
    {
        global $db;
        if (isset($this->post['division_id']) and is_array($this->post['division_id']) and empty($this->post['direction']) and !$this->post['service']) {
            $this->error("Не назначены услуги!");
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function is_update(int $pk)
    {
        global $db;
        $user = $db->query("SELECT user_id FROM $this->table WHERE id = $pk")->fetchColumn();
        $data = $db->query("SELECT * FROM $this->_service WHERE visit_id = $pk AND status NOT IN(6,7)")->rowCount();

        if ($data == 0) {

            $object = Mixin\update($this->table, array('completed' => date("Y-m-d H:i:s")), $pk);
            if(!intval($object)){
                return $object;
            }
            $this->status_update($user);
            return null;

        } else {
            return $data;
        }
        
    }

    public function is_delete(int $pk)
    {
        global $db;
        $user = $db->query("SELECT user_id FROM $this->table WHERE id = $pk")->fetchColumn();
        $data = $db->query("SELECT * FROM $this->_service WHERE visit_id = $pk")->rowCount();
        $data_update = $db->query("SELECT * FROM $this->_service WHERE visit_id = $pk AND status IN(1,2,3,5)")->rowCount();

        if ($data == 0) {

            $object = Mixin\delete($this->table, $pk);
            if(!intval($object)){
                return $object;
            }
            $this->status_update($user);
            return null;

        } else {

            if ($data_update == 0) {
                $object = Mixin\update($this->table, array('completed' => date("Y-m-d H:i:s")), $pk);
                if(!intval($object)){
                    return $object;
                }
                $this->status_update($user);
            }
            return $data;
        }
        
    }

    public function price_status(Int $pk = null)
    {
        global $db;
        if ($pk) {
            if ($db->query("SELECT completed FROM $this->table WHERE id = $pk")->fetchColumn()) {
                $sql = "SELECT
                        v.id,
                        v.grant_id,
                        v.direction,
                        IFNULL( (SELECT vr.id FROM visit_orders vr WHERE vr.visit_id=v.id), NULL) 'order',
                        IFNULL( ROUND((SELECT SUM(vi.balance_cash + vi.balance_card + vi.balance_transfer) FROM visit_investments vi WHERE vi.visit_id = v.id AND vi.expense IS NOT NULL)), 0) 'balance',
                        IFNULL( (SELECT SUM(ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(vb.end_date, CURRENT_TIMESTAMP()), vb.start_date), '%H'))) FROM visit_beds vb WHERE vb.visit_id = v.id) , 0) 'bed-time',
                        IFNULL( ROUND((SELECT SUM(ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(vb.end_date, CURRENT_TIMESTAMP()), vb.start_date), '%H')) * (vb.cost / 24)) FROM visit_beds vb WHERE vb.visit_id = v.id) * -1), 0) 'cost-beds',
                        IFNULL( ROUND((SELECT SUM(vp.item_cost) FROM visit_service_transactions vp WHERE vp.visit_id = v.id AND vp.is_price IS NOT NULL) * -1), 0) 'cost-services',
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
                $object = $db->query($sql)->fetch();
                if ($object['direction'] and $object['order']) $object['cost-beds'] = 0;
                $object['sale-total'] = $object['sale-bed'] + $object['sale-service'];
                $object['total_cost'] = $object['cost-services'] + $object['cost-beds'] + $object['cost-preparats'];
                $object['result'] = $object['balance'] + $object['total_cost'] + $object['sale-total'];
                return $object;
            } else {
                $sql = "SELECT
                        v.id,
                        v.grant_id,
                        v.direction,
                        IFNULL( (SELECT vr.id FROM visit_orders vr WHERE vr.visit_id=v.id), NULL) 'order',
                        IFNULL( ROUND((SELECT SUM(vi.balance_cash + vi.balance_card + vi.balance_transfer) FROM visit_investments vi WHERE vi.visit_id = v.id AND vi.expense IS NULL)), 0) 'balance',
                        IFNULL( (SELECT SUM(ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(vb.end_date, CURRENT_TIMESTAMP()), vb.start_date), '%H'))) FROM visit_beds vb WHERE vb.visit_id = v.id) , 0) 'bed-time',
                        IFNULL( ROUND((SELECT SUM(ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(vb.end_date, CURRENT_TIMESTAMP()), vb.start_date), '%H')) * (vb.cost / 24)) FROM visit_beds vb WHERE vb.visit_id = v.id) * -1), 0) 'cost-beds',
                        IFNULL( ROUND((SELECT SUM(vp.item_cost) FROM visit_service_transactions vp WHERE vp.visit_id = v.id AND vp.item_type IN (1,2,3) AND vp.is_price IS NULL) * -1), 0) 'cost-services',
                        IFNULL( ROUND((SELECT SUM(vt.item_qty*vt.item_cost) FROM visit_bypass_transactions vt WHERE vt.visit_id = v.id AND vt.is_price IS NULL) * -1), 0) 'cost-preparats',
                        IFNULL( vl.sale_bed_unit , 0) 'sale-bed',
                        IFNULL( vl.sale_service_unit , 0) 'sale-service',
                        -- @cost_item_2 := IFNULL((SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (2,3,4) AND price_date IS NULL), 0) 'cost_item_2',
                        v.add_date,
                        v.is_active
                    FROM visits v 
                        LEFT JOIN visit_sales vl ON(vl.visit_id = v.id)
                    WHERE v.id = $pk";
                $object = $db->query($sql)->fetch();
                if ($object['direction'] and $object['order']) $object['cost-beds'] = 0;
                $object['sale-total'] = $object['sale-bed'] + $object['sale-service'];
                $object['total_cost'] = $object['cost-services'] + $object['cost-beds'] + $object['cost-preparats'];
                $object['result'] = $object['balance'] + $object['total_cost'] + $object['sale-total'];
                return $object;
            }
        } else {
            return array();
        }
        
        

    }

    public function status_update($user)
    {
        return (new UserModel())->update_status($user);
    }

    public function success($stat=null)
    {
        if ($stat == 2) {
            echo '<div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Успешно
            </div>';
        }elseif ($stat == 1) {
            echo 1;
        }else {
            $_SESSION['message'] = '
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Успешно
            </div>
            ';
            render();
        }
    }

    public function error($message, $stat=null)
    {
        if ($stat) {
            echo '
            <div class="alert bg-danger alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <span class="font-weight-semibold"> '.$message.'</span>
            </div>
            ';
        } else {
            $_SESSION['message'] = '
            <div class="alert bg-danger alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <span class="font-weight-semibold"> '.$message.'</span>
            </div>
            ';
            render();
        }
    }
}

?>
