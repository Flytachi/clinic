<?php

use Mixin\Hell;
use Mixin\HellCrud;
use Mixin\Model;

class WarehouseStorageApplication extends Model
{
    public $table = 'warehouse_storage_applications';
    public $tItemManufacturers = 'warehouse_item_manufacturers';
    public $tItemNames = 'warehouse_item_names';

    public function Axe()
    {
        $this->updateBefore();
        $object = HellCrud::update($this->table, array( 'status' => $this->getGet('status') ), $this->getGet('id'));
        if (!is_numeric($object) and $object <= 0) $this->error($object);
        $this->updateAfter();
    }

    public function saveBody()
    {
        global $session;
        foreach ($this->getPost('applications') as $appl) if ($this->byId($appl, 'status')->status != 2) $this->error("Заявка уже обработана!");

        if ( $this->getPost('rejection') ) {
            // Отказ
            $obj = HellCrud::update($this->table, array('status' => 4), array('id' => $this->getPost('applications')));
            if (!is_numeric($obj) and $obj <= 0) $this->error("Ошибка изменения статуса заявки");

        } else {
            // Перемещение
            $obj = HellCrud::update($this->table, array('status' => 3), array('id' => $this->getPost('applications')));
            if (!is_numeric($obj) and $obj <= 0) $this->error("Ошибка изменения статуса заявки");

            // Обработка транксации
            importModel('WarehouseStorageTransaction');
            (new WarehouseStorageTransaction)->addTransaction($this->getPost('warehouse_id_in'), $session->session_id, $this->getPost('item'));
            
        }
    }

    public function listApplications()
    {
        global $classes;
        $this->as('wsa')->Data("wsa.item_name_id, wsa.item_manufacturer_id, win.name, wim.manufacturer, wsa.item_price, SUM(wsa.item_qty) 'qty'");
        $this->JoinLEFT("$this->tItemNames win", 'win.id=wsa.item_name_id')->JoinLEFT("$this->tItemManufacturers wim", 'wim.id=wsa.item_manufacturer_id');
        $this->Where("wsa.warehouse_id_from = " . $this->getGet('warehouse_id_from') . " AND wsa.warehouse_id_in = " . $this->getGet('warehouse_id_in') . " AND wsa.status = 2");
        $this->Group("win.id, wim.id, wsa.item_price");
        ?>
        <div class="table-responsive card">
            <table class="table table-hover">
                <thead>
                    <tr class="<?= $classes['table-thead'] ?>">
                        <th style="width: 50px">#</th>
                        <th>Наименование</th>
                        <th style="width:250px">Производитель</th>
                        <th style="width:250px">Цена</th>
                        <th class="text-right" style="width:100px">Кол-во</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->list(1) as $row): ?>
                        <tr id="TR_application-<?= $row->count ?>" class="application_item" onclick="applicationDetail(<?= $row->count ?>, <?= $this->getGet('warehouse_id_from') ?>, <?= $this->getGet('warehouse_id_in') ?>, <?= $row->item_name_id ?>, <?= $row->item_manufacturer_id ?>, <?= $row->item_price ?>)">
                            <td><?= $row->count ?></td>
                            <td><?= $row->name ?></td>
                            <td><?= ($row->manufacturer) ? $row->manufacturer : '<span class="text-muted">Нет данных</span>' ?></td>
                            <td><?= number_format($row->item_price) ?></td>
                            <td class="text-right"><?= number_format($row->qty) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function detailApplication()
    {
        global $classes;
        importModel('Warehouse', 'WarehouseStorage', 'WarehouseItemName', 'WarehouseItemManufacturer');
        $item = (new Warehouse)->byId($this->getGet('warehouse_id_in'));
        if(!$item) Hell::error("403");

        $store = new WarehouseStorage;
        $store->Where("warehouse_id = " . $this->getGet('warehouse_id_from') . " AND item_name_id = " . $this->getGet('item_name_id') . " AND item_manufacturer_id = " . $this->getGet('item_manufacturer_id') . " AND item_price = " . $this->getGet('item_price'));
        $store->Order("item_die_date ASC");
        if ($products = $store->list()) {
            $indicator = "secondary";
            $indicator_feed = "success";
        }else {
            $indicator = "danger";
            $indicator_feed = "danger";
        }
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Обработать заявку</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= $this->urlHook() ?>" onsubmit="submitForm()">

            <?php $this->csrfToken() ?>
            <input type="hidden" name="warehouse_id_in" value="<?= $this->getGet('warehouse_id_in') ?>">
            
            <div class="modal-body">
    
                <div class="card card-body border-top-1 border-top-<?= $indicator ?>" id="indicator-card">
                    <div class="list-feed list-feed-rhombus list-feed-solid">
                        <div class="list-feed-item border-<?= $indicator_feed ?>">
                            <strong>Препарат: </strong>
                            <span><?= $name = (new WarehouseItemName)->byId($this->getGet('item_name_id'), 'name')->name ?></span>
                        </div>
    
                        <div class="list-feed-item border-<?= $indicator_feed ?>">
                            <strong>Данные: </strong><br>
                            Производитель - <?= (new WarehouseItemManufacturer)->byId($this->getGet('item_manufacturer_id'), 'manufacturer')->manufacturer ?><br>
                            Цена - <?= number_format($this->getGet('item_price')) ?><br>
                        </div>
    
                        <div class="list-feed-item border-<?= $indicator ?>" id="indicator-feed">
                            <strong>Требуемое кол-во: </strong>
                            <span id="item_qty_required" style="font-size:15px;" class="ml-1">
                                <?= $this->Data("SUM(item_qty) 'c'")->by(array_merge($this->getGet(), array('status' => 2)))->c ?>
                            </span> / <span id="item_qty_count">0</span>
                        </div>

                    </div>
                </div>
    
                <?php if($products): ?>

                    <?php foreach ($this->Data("id")->Wr(array_merge($this->getGet(), array('status' => 2)))->list() as $app): ?>
                        <input type="hidden" name="applications[]" value="<?= $app->id ?>">
                    <?php endforeach; ?>

                    <h4 class="text-center"><?= $name ?></h4>
        
                    <div class="table-responsive card">
                        <table class="table table-hover">
                            <thead>
                                <tr class="<?= $classes['table-thead'] ?>">
                                    <th style="width:150px">Срок годности</th>
                                    <th>Производитель</th>
                                    <th>Цена</th>
                                    <th class="text-right" style="width:100px">Кол-во</th>
                                    <th class="text-right" style="width:100px">Расход</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $row): ?>
                                    <tr>
                                        <td><?= ($row->item_die_date) ? date_f($row->item_die_date) : '<span class="text-muted">Нет данных</span>' ?></td>
                                        <td><?= ($row->item_manufacturer_id) ? (new WarehouseItemManufacturer)->byId($row->item_manufacturer_id, 'manufacturer')->manufacturer : '<span class="text-muted">Нет данных</span>' ?></td>
                                        <td><?= ($row->item_price) ? number_format($row->item_price) : '<span class="text-muted">Нет данных</span>' ?></td>
                                        <td class="text-right"><?= number_format($row->item_qty) ?></td>
                                        <td>
                                            <input type="number" class="form-control text-right input_count-qty" name="item[<?= $row->id ?>]" min="0" max="<?= $row->item_qty ?>" style="border-width: 0px 0; padding: 0.2rem 0;">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
    
            </div>
    
            <div class="modal-footer">
                <button type="submit" id="indicator-btn" class="btn btn-outline-secondary btn-sm legitRipple" disabled>Принять</button>
                <input type="submit" name="rejection" value="Отказать" class="btn btn-outline-danger btn-sm legitRipple">
            </div>

        </form>

        <script  type="text/javascript">

            var qty_required = document.querySelector("#item_qty_required");
            var inputs = document.querySelectorAll(".input_count-qty");
            
            $(".input_count-qty").on("input", function (event) {
                var qty_count = document.querySelector("#item_qty_count");
                var qty = 0;

                if ( Number(event.target.max) >= Number(event.target.value) ) {
                    event.target.className = "form-control text-right input_count-qty";
                    for (let i = 0; i < inputs.length; i++) {
                        qty += Number(inputs[i].value);
                    }

                    if ( Number(qty_required.innerHTML.replace(/,/g, "")) == qty ) {
                        qty_count.className = "text-success";
                        document.querySelector("#indicator-card").className = "card card-body border-top-1 border-top-success";
                        document.querySelector("#indicator-feed").className = "list-feed-item border-success";
                        document.querySelector("#indicator-btn").className = "btn btn-outline-success btn-sm legitRipple";
                        document.querySelector("#indicator-btn").disabled = false;
                    }else if ( Number(qty_required.innerHTML.replace(/,/g, "")) < qty) {
                        qty_count.className = "text-danger";
                        document.querySelector("#indicator-card").className = "card card-body border-top-1 border-top-danger";
                        document.querySelector("#indicator-feed").className = "list-feed-item border-danger";
                        document.querySelector("#indicator-btn").className = "btn btn-outline-secondary btn-sm legitRipple";
                        document.querySelector("#indicator-btn").disabled = false;
                    } else {
                        qty_count.className = "";
                        document.querySelector("#indicator-card").className = "card card-body border-top-1 border-top-secondary";
                        document.querySelector("#indicator-feed").className = "list-feed-item border-secondary";
                        document.querySelector("#indicator-btn").className = "btn btn-outline-secondary btn-sm legitRipple";
                        document.querySelector("#indicator-btn").disabled = false;
                    }
                }else{
                    event.target.className = "form-control text-right input_count-qty text-danger";
                }
                
                qty_count.innerHTML = number_format(qty);

            });

        </script>
        <?php
    }

}

?>