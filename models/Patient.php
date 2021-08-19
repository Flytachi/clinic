<?php

class PatientForm extends Model
{
    public $table = 'users';
    public $table1 = 'province';
    public $table2 = 'region';

    public function form($pk = null)
    {
        global $db, $classes;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h5 class="modal-title">Добавить/Редактировать пациента <span id="vis_title"></h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">
        
            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">
                <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
                <input type="hidden" name="user_level" value="15">
                <?php if (!$pk): ?>
                    <input type="hidden" name="status" value="0">
                <?php endif; ?>

                <div class="row">

                    <div class="col-md-12">

                        <legend><b>Паспорт</b></legend>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label id="label_passport_serial_input">Серия:</label>
                                <input type="text" name="passport_seria" placeholder="Серия паспорта" class="form-control" value="<?= $this->value('passport_seria') ?>">
                            </div>
                            <div class="col-md-6">
                                <label id="label_pin_fl_input" data-popup="tooltip" title="" data-original-title="14 цифр с идентификатора">PINFL:</label>
                                <input type="text" name="passport_pin_fl" placeholder="PINFL паспорта" class="form-control" value="<?= $this->value('passport_pin_fl') ?>">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <legend><b>Личные даные</b></legend>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <fieldset>

                                    <div class="form-group">
                                        <label>Фамилия пациента:</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control text-capitalize" placeholder="Введите Фамилия" value="<?= $this->value('last_name') ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Имя пациента:</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control text-capitalize" placeholder="Введите имя" value="<?= $this->value('first_name') ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Отчество пациента:</label>
                                        <input type="text" name="father_name" id="father_name" class="form-control text-capitalize" placeholder="Введите Отчество" value="<?= $this->value('father_name') ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Дата рождение:</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                            </span>
                                            <input type="date" name="birth_date" id="birth_date" class="form-control daterange-single" value="<?= $this->value('birth_date') ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Выбирите область:</label>
                                            <select data-placeholder="Выбрать область" id="province" name="province_id" class="<?= $classes['form-select'] ?>">
                                                <option></option>
                                                <?php foreach ($db->query("SELECT DISTINCT pv.name, pv.id FROM region rg LEFT JOIN province pv ON(pv.id=rg.province_id)") as $province): ?>
                                                    <option value="<?= $province['id'] ?>" <?= ($this->value('province_id') == $province['id']) ? "selected" : "" ?>><?= $province['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Выбирите регион:</label>
                                            <select data-placeholder="Выбрать регион" name="region_id" id="region" class="<?= $classes['form-select'] ?>">
                                                <option></option>
                                                <?php foreach ($db->query("SELECT * FROM region") as $row): ?>
                                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['province_id'] ?>" <?= ($this->value('region_id') == $row['id']) ? "selected" : "" ?>><?= $row['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label>Адрес проживание:</label>
                                            <input type="text" name="address_residence" class="form-control" placeholder="Введите адрес" value="<?= $this->value('address_residence') ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Адрес по прописке:</label>
                                            <input type="text" name="address_registration" class="form-control" placeholder="Введите адрес" value="<?= $this->value('address_registration') ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label>Телефон номер:</label>
                                            <input type="text" name="phone_number" class="form-control" value="<?= ($this->value('phone_number')) ? $this->value('phone_number') : '+998' ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Место работы:</label>
                                        <input type="text" name="work_place" placeholder="Введите место работы" class="form-control" value="<?= $this->value('work_place') ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Должность:</label>
                                        <input type="text" name="work_position" placeholder="Введите должность" class="form-control" value="<?= $this->value('work_position') ?>">
                                    </div>


                                    <div class="form-group mb-3 mb-md-2">
                                        <label class="d-block font-weight-semibold">Пол</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" name="gender" value="0" id="custom_radio_inline_unchecked" <?php if(!$this->value('gender') or 0 == $this->value('gender')){echo "checked";} ?>>
                                            <label class="custom-control-label" for="custom_radio_inline_unchecked">Женский</label>
                                        </div>

                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" name="gender" value="1" id="custom_radio_inline_checked" <?php if(1 == $this->value('gender')){echo "checked";} ?>>
                                            <label class="custom-control-label" for="custom_radio_inline_checked">Мужской</label>
                                        </div>
                                    </div>

                                    <div class="form-check form-check-switchery form-check-switchery-double">
                                        <label class="form-check-label">
                                            Местный
                                            <input type="checkbox" class="swit" name="is_foreigner" <?= ($this->value('is_foreigner')) ? "checked" : "" ?>>
                                            Иностранец
                                        </label>
                                    </div>

                                </fieldset>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                        <span class="ladda-label">Сохранить</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
                
            </div>

        </form>
        <?php
        $this->jquery_init();
        ?>
        <script src="<?= stack("assets/js/custom.js") ?>"></script>
        <script type="text/javascript">
            $(function(){
                $("#region").chained("#province");
            });
        </script>
        <?php
    }

    public function clean()
    {
        global $db;
        if ( isset($this->post['is_foreigner']) ) {
            $this->post['is_foreigner'] = true;
        }else{
            $this->post['is_foreigner'] = false;
        }
        //
        if ( isset($this->post['province_id']) ) {
            $this->post['province'] = $db->query("SELECT name FROM $this->table1 WHERE id = {$this->post['province_id']}")->fetchColumn();
        }
        if ( isset($this->post['region_id']) ) {
            $this->post['region'] = $db->query("SELECT name FROM $this->table2 WHERE id = {$this->post['region_id']}")->fetchColumn();
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function jquery_init()
    {
        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                FormLayouts.init();
                Swit.init();
            });
        </script>
        <?php
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-info" role="alert">
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

?>