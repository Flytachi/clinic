<?php

class PatientForm extends Model
{
    public $table = 'users';

    public function form($pk = null)
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
                            <input type="text" name="passport_seria" id="passport_serial_input" placeholder="Серия паспорта" class="form-control" value="<?= $this->value('passport_seria') ?>">
                        </div>
                        <div class="col-md-6">
                            <label id="label_pin_fl_input" data-popup="tooltip" title="" data-original-title="14 цифр с идентификатора">PINFL:</label>
                            <input type="text" name="passport_pin_fl" id="pin_fl_input" placeholder="PINFL паспорта" class="form-control" value="<?= $this->value('passport_pin_fl') ?>">
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
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Введите Фамилия" value="<?= $this->value('last_name') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Имя пациента:</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Введите имя" value="<?= $this->value('first_name') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Отчество пациента:</label>
                                    <input type="text" name="father_name" id="father_name" class="form-control" placeholder="Введите Отчество" value="<?= $this->value('father_name') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Дата рождение:</label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                        </span>
                                        <input type="date" name="dateBith" id="birth_date" class="form-control daterange-single" value="<?= $this->value('dateBith') ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Выбирите область:</label>
                                        <select data-placeholder="Выбрать область" id="province" class="<?= $classes['form-select'] ?>">
                                            <option></option>
                                            <?php foreach ($db->query("SELECT DISTINCT pv.name, pv.id FROM region rg LEFT JOIN province pv ON(pv.id=rg.province_id)") as $province): ?>
                                                <option value="<?= $province['id'] ?>"><?= $province['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Выбирите регион:</label>
                                        <select data-placeholder="Выбрать регион" name="region" id="region" class="<?= $classes['form-select'] ?>">
                                            <option></option>
                                            <?php foreach ($db->query("SELECT * FROM region") as $row): ?>
                                                <option value="<?= $row['name'] ?>" data-chained="<?= $row['province_id'] ?>" <?= ($this->value('region') == $row['name']) ? "selected" : "" ?>><?= $row['name'] ?></option>
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
                                        <input type="text" name="residenceAddress" class="form-control" placeholder="Введите адрес" value="<?= $this->value('residenceAddress') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Адрес по прописке:</label>
                                        <input type="text" name="registrationAddress" class="form-control" placeholder="Введите адрес" value="<?= $this->value('registrationAddress') ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label>Телефон номер:</label>
                                        <input type="text" name="numberPhone" class="form-control" value="<?= ($this->value('numberPhone')) ? $this->value('numberPhone') : '+998' ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Место работы:</label>
                                    <input type="text" name="placeWork" placeholder="Введите место работы" class="form-control" value="<?= $this->value('placeWork') ?>">
                                </div>

                                <div class="form-group">
                                    <label>Должность:</label>
                                    <input type="text" name="position" placeholder="Введите должность" class="form-control" value="<?= $this->value('position') ?>">
                                </div>

                                <div class="form-group">
                                   <label class="d-block font-weight-semibold">Пол</label>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" id="gender_1" <?php if(1 == $this->value('gender')){echo "checked";} ?> value="1" class="form-check-input" name="unstyled-radio-left" checked>
                                            Мужчина
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" id="gender_0" <?php if(0 == $this->value('gender')){echo "checked";} ?> value="0" class="form-check-input" name="unstyled-radio-left">
                                            Женщина
                                        </label>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                   
                                    <label class="form-check-label">
                                        Резидент
                                        <input type="checkbox" class="swit" name="is_alien">
                                    </label>
                                
                                </div> -->

                                

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

        </form>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
        ?>
        <script src="<?= stack("vendors/js/custom.js") ?>"></script>
        <script type="text/javascript">
            $(function(){
                $("#region").chained("#province");
            });
        </script>
        <?php
    }

    public function clean()
    {
        if ($this->post['is_alien']) {
            $this->post['is_alien'] = true;
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
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