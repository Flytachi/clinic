<?php

class VisitModel extends Model
{
    public $table = 'visits';
    public $table2 = 'beds';
    public $_bed_types = 'bed_types';
    public $_user = 'users';
    public $_service = 'visit_services';
    public $_beds = 'visit_beds';
    public $_prices = 'visit_prices';

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
                        <select data-placeholder="Выберите отдел" id="division_id" class="<?= $classes['form-select'] ?>" required>
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

    public function form_gudes($pk = null)
    {
        global $db, $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group row">
                <div class="col-md-6">
                    <label>Направитель:</label>
                    <select data-placeholder="Выберите направителя" name="guide_id" class="<?= $classes['form-select'] ?>">
                        <option></option>
                        <?php foreach ($db->query("SELECT * from guides ORDER BY name") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($this->value('guide_id') == $row['id']) ? "selected" : "" ?>><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
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
            'complaint' => ( isset($this->post['complaint']) ) ? $this->post['complaint'] : null,
        );
        $object = Mixin\insert_or_update($this->table, $post, 'user_id', "completed IS NULL");
        if (!intval($object)) {
            $this->error($object);
            $db->rollBack();
        }else{
            $this->visit_pk = $object;
            $this->is_foreigner = $db->query("SELECT is_foreigner FROM $this->_user WHERE id = {$this->post['user_id']}")->fetchColumn();
        }
    }

    public function add_visit_service($key = null, $value)
    {
        global $db;
        $data = $db->query("SELECT * FROM services WHERE id = $value")->fetch();
        $post['division_id'] = ($this->post['direction']) ? $this->post['division_id'] : $this->post['division_id'][$key];

        $post['visit_id'] = $this->visit_pk;
        $post['user_id'] = $this->post['user_id'];
        $post['parent_id'] = ($this->post['direction']) ? $this->post['parent_id'] : $this->post['parent_id'][$key];
        $post['route_id'] = $_SESSION['session_id'];
        $post['guide_id'] = $this->post['guide_id'];
        $post['level'] = ($this->post['division_id']) ? $db->query("SELECT level FROM divisions WHERE id = {$post['division_id']}")->fetchColumn() : $this->post['level'][$key];
        $post['status'] = ($this->post['direction']) ? 2 : 1;
        $post['service_id'] = $data['id'];
        $post['service_name'] = $data['name'];
        
        $count = ($this->post['direction']) ? 1 : $this->post['count'][$key];
        for ($i=0; $i < $count; $i++) {
            $post = Mixin\clean_form($post);
            $post = Mixin\to_null($post);
            $object = Mixin\insert($this->_service, $post);
            if (!intval($object)){
                $this->error($object);
                $db->rollBack();
            }

            if (!$this->post['direction'] or (!permission([2, 32]) and $this->post['direction'])) {
                $post_price['visit_id'] = $this->visit_pk;
                $post_price['visit_service_id'] = $object;
                $post_price['user_id'] = $this->post['user_id'];
                $post_price['item_type'] = 1;
                $post_price['item_id'] = $data['id'];
                $post_price['item_cost'] = ($this->is_foreigner) ? $data['price_foreigner'] : $data['price'];
                $post_price['item_name'] = $data['name'];
                $post_price['is_visibility'] = ($this->post['direction']) ? null : 1;
                $object = Mixin\insert($this->_prices, $post_price);
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
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
            $this->error($object);
            $db->rollBack();
        }

        $object2 = Mixin\update($this->table2, array('user_id' => $this->post['user_id']), $this->post['bed']);
        if (!intval($object2)){
            $this->error($object2);
            $db->rollBack();
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
                $this->error($object1);
                $db->rollBack();
            }
            
            $db->commit();
            $this->success();

        }
    }

    public function update()
    {
        global $db;
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
                $object = Mixin\update($this->_service, array('parent_id' => $this->post['grant_id']), array('visit_id' => $pk, 'service_id' => 1));
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
                }
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

    public function change_beds($visit)
    {
        global $db;
        // $bed_old = $db->query("SELECT * FROM beds WHERE id = {$visit['bed_id']}")->fetch();
        // $bed_new = $db->query("SELECT * FROM beds WHERE id = {$this->post['bed_id']}")->fetch();
        // $bed_old['user_id'] = null;
        // $bed_new['user_id'] = $visit['user_id'];
        // $object = Mixin\insert_or_update('beds', $bed_old);
        // if (!intval($object)) {
        //     $this->error($object);
        // }
        // $object = Mixin\insert_or_update('beds', $bed_new);
        // if (!intval($object)) {
        //     $this->error($object);
        // }
    }

    public function bed_price($visit)
    {
        global $db;
        // $sql = "SELECT wd.floor,
        //             wd.ward, bd.bed,
        //             ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), IFNULL(vp.add_date, vs.add_date)), '%H')) * (bdt.price / 24) 'bed_cost'
        //         FROM visit vs
        //             LEFT JOIN beds bd ON(bd.id=vs.bed_id)
        //             LEFT JOIN wards wd ON(wd.id=bd.ward_id)
        //             LEFT JOIN bed_type bdt ON(bdt.id=bd.types)
        //             LEFT JOIN visit_price vp ON(vp.visit_id=vs.id AND vp.item_type = 101)
        //         WHERE vs.id = {$visit['id']} ORDER BY vp.add_date DESC";
        // $bed = $db->query($sql)->fetch();
        // if ($bed['bed_cost'] > 0) {
        //     $post['visit_id'] = $visit['id'];
        //     $post['user_id'] = $visit['user_id'];
        //     $post['status'] = 0;
        //     $post['item_type'] = 101;
        //     $post['item_id'] = $visit['bed_id'];
        //     $post['item_cost'] = $bed['bed_cost'];
        //     $post['item_name'] = $bed['floor']." этаж ".$bed['ward']." палата ".$bed['bed']." койка";
        //     $object = Mixin\insert('visit_price', $post);
        //     if (!intval($object)) {
        //         $this->error($object);
        //     }
        // }
    }

    // public function delete(int $pk)
    // {
    //     global $db;
    //     if (empty($_GET['type'])) {
            
    //         // Нахождение id визита
    //         $object_sel = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_OBJ);

    //         if ($object_sel->direction) {
    //             $db->beginTransaction();

    //             if ($object_sel->service_id == 1) {
    //                 // Удаляем все визиты внутри гланого визита

    //                 foreach ($db->query("SELECT vs.id FROM $this->table vs WHERE vs.id != $pk AND vs.user_id = $object_sel->user_id AND vs.direction IS NOT NULL AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i:%s') BETWEEN \"$object_sel->add_date\" AND \"IFNULL($object_sel->completed, CURRENT_TIMESTAMP())\")") as $value) {
    //                     $object = Mixin\delete($this->table, $value['id']);
    //                     if (!intval($object)) {
    //                         $this->error($object, 1);
    //                         $db->rollBack();
    //                     }
    //                     Mixin\delete('visit_price', $value['id'], 'visit_id');
    //                 }
    
    //                 // Удаляем главный визит
    //                 $object = Mixin\delete($this->table, $pk);
    //                 if (!intval($object)) {
    //                     $this->error($object, 1);
    //                     $db->rollBack();
    //                 }
    //                 Mixin\delete('visit_price', $pk, 'visit_id');
    //                 // Освобождаем койку
    //                 Mixin\update($this->table2, array('user_id' => null), $object_sel->bed_id);
    //                 // Обновляем статус
    //                 Mixin\update($this->_user, array('status' => null), $object_sel->user_id);
    
    //                 $success = 2;
    
    //             }else{
    
    //                 // Удаляем визит
    //                 $object = Mixin\delete($this->table, $pk);
    //                 if (!intval($object)) {
    //                     $this->error($object, 1);
    //                     $db->rollBack();
    //                 }
    //                 Mixin\delete('visit_price', $pk, 'visit_id');
    
    //                 // Обновляем статус
    //                 $status = $db->query("SELECT * FROM $this->table WHERE user_id = $object_sel->user_id AND completed IS NULL")->rowCount();
    //                 if($status <= 1){
    //                     if ($status == 0) {
    //                         Mixin\update($this->_user, array('status' => null), $object_sel->user_id);
    //                     }
    //                     $success = 2;
    //                 }else {
    //                     $success = 1;
    //                 }
    //             }

    //             $db->commit();
    //             $this->success($success);
    //         }else {
    //             $db->beginTransaction();
                
    //             // Удаляем визит
    //             $object = Mixin\delete($this->table, $pk);
    //             if (!intval($object)) {
    //                 $this->error($object, 1);
    //                 $db->rollBack();
    //             }
    //             Mixin\delete('visit_price', $pk, 'visit_id');

    //             // Обновляем статус
    //             $status = $db->query("SELECT * FROM $this->table WHERE user_id = $object_sel->user_id AND completed IS NULL")->rowCount();
    //             if($status <= 1){
    //                 if ($status == 0) {
    //                     Mixin\update($this->_user, array('status' => null), $object_sel->user_id);
    //                 }
    //                 $success = 2;
    //             }else {
    //                 $success = 1;
    //             }
    //             $db->commit();
    //             $this->success($success);
    //         }

    //     }else {
    //         $object = Mixin\update($this->table, array('status' => 5), $pk);
    //         $this->success(1);
    //     }

    // }

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
                return "В разработке!";
            } else {
                $sql = "SELECT
                        v.id,
                        v.grant_id,
                        IFNULL( (SELECT SUM(vi.balance_cash + vi.balance_card + vi.balance_transfer) FROM visit_investments vi WHERE vi.visit_id = v.id AND vi.expense IS NULL) , 0) 'balance',
                        IFNULL( (SELECT SUM(ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(vb.end_date, CURRENT_TIMESTAMP()), vb.start_date), '%H'))) FROM visit_beds vb WHERE vb.visit_id = v.id) , 0) 'bed-time',
                        IFNULL( (SELECT SUM(ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(vb.end_date, CURRENT_TIMESTAMP()), vb.start_date), '%H')) * (vb.cost / 24)) FROM visit_beds vb WHERE vb.visit_id = v.id) * -1, 0) 'cost-beds',
                        IFNULL( (SELECT SUM(vp.item_cost) FROM visit_prices vp WHERE vp.visit_id = v.id AND vp.item_type IN (1,3) AND vp.is_price IS NULL) * -1, 0) 'cost-services',
                        IFNULL( vl.sale_bed_unit , 0) 'sale-bed',
                        IFNULL( vl.sale_service_unit , 0) 'sale-service',
                        IFNULL( vl.sale_bed_unit + vl.sale_service_unit , 0) 'sale-total',
                        -- @cost_item_2 := IFNULL((SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (2,3,4) AND price_date IS NULL), 0) 'cost_item_2',
                        v.add_date
                    FROM visits v 
                        LEFT JOIN visit_sales vl ON(vl.visit_id = v.id)
                    WHERE v.id = $pk";
                $object = $db->query($sql)->fetch();
                $object['total_cost'] = $object['cost-services'] + $object['cost-beds'];
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
