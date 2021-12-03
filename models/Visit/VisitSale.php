<?php

use Warframe\Model;

class VisitSaleModel extends Model
{
    public $table = 'visit_sales';
    public $_visits = 'visits';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->_visits WHERE id = $pk AND direction IS NOT NULL AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($db->query("SELECT * FROM visit_sales WHERE visit_id = $pk")->fetch());
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
            <h6 class="modal-title">Скидка</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>" onsubmit="Subi_Sales()">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $this->value('id') ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
            <input type="hidden" name="visit_id" value="<?= $pk ?>">
            <input type="hidden" name="responsible_id" value="<?= $session->session_id ?>">

            <div class="modal-body">

                <fieldset>

                    <legend>Сумма койки</legend>
                
                    <table class="table table-hover mb-2">
                        <tbody>
                            <tr class="table-secondary text-center">
                                <td style="width:50%;">
                                    <span id="bed_price_original_sale"><?= number_format(-$vps['cost-beds']) ?></span>
                                    <span class="text-muted">(к оплате)</span>
                                </td>
                                <td style="width:50%;">
                                    <span id="bed_price_sale"><?= number_format(-$vps['cost-beds'] - intval($this->value('sale_bed_unit'))) ?></span>
                                    <span class="text-muted">(остаток)</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Скидка:</label>
                        <div class="col-md-10">
                            <div class="input-group">
                            
                                <input type="text" name="sale_bed_unit" id="input_sale_bed_unit" class="form-control input-price" value="<?= number_format($this->value('sale_bed_unit')) ?>">
                                
                                <div class="form-group-feedback form-group-feedback-right" style="margin-left: 20px;">
                                    <input type="number" class="form-control" step="0.01" name="sale_bed" id="input_sale_bed" value="<?= $this->value('sale_bed') ?>">
                                    <div class="form-control-feedback text-success">
                                        <span style="font-size: 20px;">%</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </fieldset>
                   
                <fieldset>

                    <legend>Сумма Услуг</legend>

                    <table class="table table-hover mb-2">
                        <tbody>
                            <tr class="table-secondary text-center">
                                <td style="width:50%;">
                                    <span id="service_price_original_sale"><?= number_format(-$vps['cost-services']) ?></span>
                                    <span class="text-muted">(к оплате)</span>
                                </td>
                                <td style="width:50%;">
                                    <span id="service_price_sale"><?= number_format(-$vps['cost-services'] - intval($this->value('sale_service_unit'))) ?></span>
                                    <span class="text-muted">(остаток)</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Скидка:</label>
                        <div class="col-md-10">
                            <div class="input-group">

                                <input type="text" name="sale_service_unit" id="input_sale_service_unit" step="0.01" class="form-control input-price" value="<?= number_format($this->value('sale_service_unit')) ?>">
                                
                                <div class="form-group-feedback form-group-feedback-right" style="margin-left: 20px;">
                                    <input type="number" class="form-control" step="0.01" name="sale_service" id="input_sale_service" value="<?= $this->value('sale_service') ?>">
                                    <div class="form-control-feedback text-success">
                                        <span style="font-size: 20px;">%</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </fieldset>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        
        <script type="text/javascript">

            var bed_price_original = document.querySelector('#bed_price_original_sale');
            var bed_price = document.querySelector('#bed_price_sale');
            var bed_input_unit = document.querySelector('#input_sale_bed_unit');
            var bed_input = document.querySelector('#input_sale_bed');

            var service_price_original = document.querySelector('#service_price_original_sale');
            var service_price = document.querySelector('#service_price_sale');
            var service_input_unit = document.querySelector('#input_sale_service_unit');
            var service_input = document.querySelector('#input_sale_service');

            $(bed_input).keyup(function() {
                var original = bed_price_original.innerHTML.replace(/,/g,'');
                var proc = Math.round( (original * (bed_input.value / 100)) *100)/100;
                bed_input_unit.value = number_format(proc);
                bed_price.innerHTML = number_format( Math.round( (original - proc) *100)/100 );
            });
            $(bed_input_unit).keyup(function() {
                var original = bed_price_original.innerHTML.replace(/,/g,'');
                var proc = bed_input_unit.value.replace(/,/g,'');
                bed_input.value = Math.round( (proc / (original / 100)) *100)/100;
                bed_price.innerHTML = number_format( Math.round( (original - proc) *100)/100 );
            });

            $(service_input).keyup(function() {
                var original = service_price_original.innerHTML.replace(/,/g,'');
                var proc = Math.round( (original * (service_input.value / 100)) *100)/100;
                service_input_unit.value = number_format(proc);
                service_price.innerHTML = number_format( Math.round( (original - proc) *100)/100 );
            });
            $(service_input_unit).keyup(function() {
                var original = service_price_original.innerHTML.replace(/,/g,'');
                var proc = service_input_unit.value.replace(/,/g,'');
                service_input.value = Math.round( (proc / (original / 100)) *100)/100;
                service_price.innerHTML = number_format( Math.round( (original - proc) *100)/100 );
            });

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

            function Subi_Sales() {
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
        if( isset($this->post['sale_bed_unit']) ) $this->post['sale_bed_unit'] = str_replace(',', '', $this->post['sale_bed_unit']);
        if( isset($this->post['sale_service_unit']) ) $this->post['sale_service_unit'] = str_replace(',', '', $this->post['sale_service_unit']);
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