<?php

class VisitSaleModel extends Model
{
    public $table = 'visit_sale';

    public function form($pk = null)
    {
        global $db;
        $post = $db->query("SELECT * FROM visit_sale WHERE visit_id = $pk")->fetch();
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="visit_id" value="<?= $pk ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-9">
                        <label class="col-form-label">Сумма койки:</label>
                        <input type="text" class="form-control" id="bed_price_sale" disabled>
                        <input type="hidden" id="bed_price_original_sale">
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">Скидка:</label>
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="number" class="form-control" step="0.1" name="sale_bed" id="bed_input_sale" value="<?= $post['sale_bed'] ?>">
                            <div class="form-control-feedback text-success">
                                <span style="font-size: 20px;">%</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-9">
                        <label class="col-form-label">Сумма Услуг:</label>
                        <input type="text" class="form-control" id="service_price_sale" disabled>
                        <input type="hidden" id="service_price_original_sale">
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">Скидка:</label>
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="number" class="form-control" step="0.1" name="sale_service" id="service_input_sale" value="<?= $post['sale_service'] ?>">
                            <div class="form-control-feedback text-success">
                                <span style="font-size: 20px;">%</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">

            $("#bed_input_sale").keyup(function() {
                var sum = $("#bed_price_original_sale").val();
                var proc = $("#bed_input_sale").val() / 100;
                $("#bed_price_sale").val(sum - (sum * proc));
            });

            $("#service_input_sale").keyup(function() {
                var sum = $("#service_price_original_sale").val();
                var proc = $("#service_input_sale").val() / 100;
                $("#service_price_sale").val(sum - (sum * proc));
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