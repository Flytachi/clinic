<?php

class VisitInvestmentsModel extends Model
{
    public $table = 'visit_investments';
    public $_visits = 'visits';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->_visits WHERE id = $pk AND direction IS NOT NULL AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            $this->post['type'] = $_GET['type'];
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('report_permissions_false');
        }

    }
    
    public function form($pk = null)
    {
        global $classes, $session;
        $vps = (new VisitModel)->price_status($pk);
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title"><?= ($this->value('type')) ? "Возврат": "Предоплата" ?>: <?= get_full_name($this->value('user_id')) ?></h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>" onsubmit="Subi_investment()">

            <div class="modal-body">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="visit_id" value="<?= $pk ?>">
                <input type="hidden" name="user_id" value="<?= $this->value('user_id') ?>">
                <input type="hidden" name="pricer_id" value="<?= $session->session_id ?>">
                <input type="hidden" name="price_type" value="<?= $this->value('type') ?>">

                <table class="table table-hover mb-2">
                    <tbody>
                        <tr class="table-secondary">
                            <td><?= ($this->value('type')) ? "Баланс": "Сумма к оплате" ?></td>
                            <td><?= ($this->value('type')) ? number_format($vps['balance']): number_format(-$vps['result']) ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Наличный</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" name="balance_cash" id="input_chek_1" step="0.5" class="form-control input-price" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="swit" id="chek_1" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Пластиковый</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" name="balance_card" id="input_chek_2" step="0.5" class="form-control input-price" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="swit" id="chek_2" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Перечисление</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" name="balance_transfer" id="input_chek_3" step="0.5" class="form-control input-price" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="swit" id="chek_3" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Оплатить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>

        <script type="text/javascript">

            function Checkert(event) {
                var input = document.querySelector("#input_"+event.id);
                if(input.disabled){
                    input.disabled = false;
                }else {
                    input.disabled = true;
                }
            }

            $(".input-price").on("input", function (event) {
                if (isNaN(Number(event.target.value.replace(/,/g, "")))) {
                    try {
                        event.target.value = event.target.value.replace(
                            new RegExp(event.originalEvent.data, "g"),
                            ""
                        );
                    } catch (e) {
                        event.target.value = event.target.value.replace(
                            event.originalEvent.data,
                            ""
                        );
                    }
                } else {
                    event.target.value = number_with(
                        event.target.value.replace(/,/g, "")
                    );
                }
            });

            function Subi_investment() {
                event.preventDefault();
                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (result) {
                        if (result == 1) {
                            new Noty({
                                text: 'Успешно!',
                                type: 'success'
                            }).show();
                        }else {
                            new Noty({
                                text: result,
                                type: 'error'
                            }).show();
                        }
                        $('#modal_default').modal('hide');
                        Check('<?= up_url($pk, 'TransactionPanel') ?>');
                    },
                });
            }

        </script>
        <?php
    }

    public function clean()
    {
        if( isset($this->post['balance_cash']) ) $this->post['balance_cash'] = str_replace(',', '', $this->post['balance_cash']);
        if( isset($this->post['balance_card']) ) $this->post['balance_card'] = str_replace(',', '', $this->post['balance_card']);
        if( isset($this->post['balance_transfer']) ) $this->post['balance_transfer'] = str_replace(',', '', $this->post['balance_transfer']);
        if ($this->post['price_type']) {
            if (isset($this->post['balance_cash'])) {
                $this->post['balance_cash'] *= -1;
            }
            if (isset($this->post['balance_card'])) {
                $this->post['balance_card'] *= -1;
            }
            if (isset($this->post['balance_transfer'])) {
                $this->post['balance_transfer'] *= -1;
            }
        }
        unset($this->post['price_type']);
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo 1;
    }

    public function error($message)
    {
        echo $message;
    }
}
        
?>