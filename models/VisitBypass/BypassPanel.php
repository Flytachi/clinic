<?php

class BypassPanel extends Model
{
    public $_package = 'package_bypass';
    public $_bypass = 'visit_bypass';
    public $_visits = 'visits';

    public function get_or_404(int $pk)
    {
        global $db;
        // Visit
        $object = $db->query("SELECT * FROM $this->_visits WHERE id = $pk AND direction IS NOT NULL AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){
            return $this->{$_GET['form']}($pk);
        }else{
            Mixin\error('report_permissions_false');
        }

    }

    public function TabPanel($pk = null)
    {
        ?>
        <ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
            <li class="nav-item"><a onclick="DetailControl('<?= up_url($pk, 'BypassPanel', 'DetailPanelCustom') ?>')" href="#" class="nav-link legitRipple active show" data-toggle="tab">Пользовательские</a></li>
            <!-- <li class="nav-item"><a onclick="DetailControl('<?= up_url($pk, 'BypassPanel', 'DetailPanelPackage') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Мои</a></li> -->
            <?php if(module('diet')): ?>
                <li class="nav-item"><a onclick="DetailControl('<?= up_url($pk, 'BypassPanel', 'DetailPanelDiet') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Диета</a></li>
            <?php endif; ?>
        </ul>

        <div class="fc-events-container mb-3" id="efect">
            <script>
                $(document).ready(function(){
                    DetailControl('<?= up_url($pk, 'BypassPanel', 'DetailPanelCustom') ?>');
                });
            </script>
        </div>

        <script type="text/javascript">
            function DetailControl(params) {
                $.ajax({
                    type: "POST",
                    url: params,	
                    success: function (result) {
                        $('#efect').html(result);
                    },
                });
            }
        </script>
        <?php
    }

    public function DetailPanelCustom($pk = null)
    {
        global $db, $session;
        $tb = new Table($db, $this->_bypass);
        $tb->where("visit_id = $pk AND responsible_id = $session->session_id")->order_by("name ASC");
        foreach ($tb->get_table(1) as $row) {
            ?>
            <div class="fc-event fc-item" data-id="<?= $row->id ?>"><?= $row->name ?></div>
            <?php
        }
        if ( isset($row->count) and $row->count > 0 ) echo "<hr>";
        ?>
        <button onclick="Update('<?= up_url($pk, 'VisitBypassModel') ?>')" class="btn btn-success btn-block btn-sm legitRipple" type="button"><i class="icon-plus22 mr-1"></i>Добавить</button>
        <?php
        $this->jquery_init();
    }

    public function DetailPanelPackage($pk = null)
    {
        global $db, $session;
        $tb = new Table($db, $this->_package);
        $tb->where("is_active IS NOT NULL AND autor_id = $session->session_id")->order_by("name ASC");
        foreach ($tb->get_table() as $row) {
            ?>
            <div class="fc-event" onmousedown="CheckPack(this)" data-id="<?= $row->id ?>"><?= $row->name ?></div>
            <?php
        }
        ?>
        <div class="fc-event" data-color="#546E7A" onmousedown="CheckPack(this)">Sauna and stuff</div>
        <?php
        $this->jquery_init();
    }

    public function DetailPanelDiet($pk = null)
    {
        ?>
        <div class="fc-event" data-color="#FF7043" onmousedown="CheckPack(this)">Диета №1</div>
        <div class="fc-event" data-color="#FF7043" onmousedown="CheckPack(this)">Диета №2</div>
        <?php
        $this->jquery_init();
    }

    protected function jquery_init()
    {
        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                FullCalendarAdvanced.init();
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
        echo "Успешно";
    }

    public function error($message)
    {
        echo $message;
    }
    
}
        
?>