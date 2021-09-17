<?php

class VisitSaleModel extends Model
{
    public $table = 'visit_sale';

    public function form($pk = null)
    {
        global $db;
        $post = $db->query("SELECT * FROM visit_sale WHERE visit_id = $pk")->fetch();
        ?>
        <script src="<?= stack("vendors/js/custom.js") ?>"></script>
        <form method="post" action="<?= add_url() ?>" onsubmit="Subi()">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= (isset($post['id'])) ? $post['id'] : '' ?>">
            <input type="hidden" name="visit_id" value="<?= $pk ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <fieldset>

                    <legend>Сумма койки</legend>
                
                    <div class="form-group row">

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="bed_price_original_sale" disabled>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="bed_price_sale" disabled>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Скидка:</label>
                        <div class="col-md-10">
                            <div class="input-group">

                                <input type="number" name="sale_bed_unit" id="input_sale_bed_unit" step="0.01" class="form-control" value="<?= $post['sale_bed_unit'] ?>">
                                
                                <div class="form-group-feedback form-group-feedback-right" style="margin-left: 20px;">
                                    <input type="number" class="form-control" step="0.01" name="sale_bed" id="input_sale_bed" value="<?= $post['sale_bed'] ?>">
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

                    <div class="form-group row">

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="service_price_original_sale" disabled>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="service_price_sale" disabled>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Скидка:</label>
                        <div class="col-md-10">
                            <div class="input-group">

                                <input type="number" name="sale_service_unit" id="input_sale_service_unit" step="0.01" class="form-control" value="<?= $post['sale_service_unit'] ?>">
                                
                                <div class="form-group-feedback form-group-feedback-right" style="margin-left: 20px;">
                                    <input type="number" class="form-control" step="0.01" name="sale_service" id="input_sale_service" value="<?= $post['sale_service'] ?>">
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
                <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
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
                var proc = Math.round( (bed_price_original.value * (bed_input.value / 100)) *100)/100;
                bed_input_unit.value = proc;
                bed_price.value = Math.round( (bed_price_original.value - proc) *100)/100;
            });
            $(bed_input_unit).keyup(function() {
                var proc = bed_input_unit.value;
                bed_input.value = Math.round( (proc / (bed_price_original.value / 100)) *100)/100;
                bed_price.value = Math.round( (bed_price_original.value - proc) *100)/100 ;
            });

            $(service_input).keyup(function() {
                var proc = Math.round( (service_price_original.value * (service_input.value / 100)) *100)/100;
                service_input_unit.value = proc;
                service_price.value = Math.round( (service_price_original.value - proc) *100)/100;
            });
            $(service_input_unit).keyup(function() {
                var proc = service_input_unit.value;
                service_input.value = Math.round( (proc / (service_price_original.value / 100)) *100)/100;
                service_price.value = Math.round( (service_price_original.value - proc) *100)/100 ;
            });

            function Subi() {
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
                        $('#modal_sale').modal('hide');
                        Check('get_mod.php?pk='+$('#user_st_id').val() ,$('#user_st_id').val());
                    },
                });
            }

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
        echo 1;
    }

    public function error($message)
    {
        echo $message;
    }
}
        
?>