<?php

class PatientForm extends Model
{
    public $table = 'users';

    public function form($pk = null)
    {
        global $db;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
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
                            <input type="text" name="passport_seria" id="passport_serial_input" placeholder="Серия паспорта" class="form-control" value="<?= $post['passport_seria']?>">
                        </div>
                        <div class="col-md-6">
                            <label id="label_pin_fl_input" data-popup="tooltip" title="" data-original-title="14 цифр с идентификатора">PINFL:</label>
                            <input type="text" name="passport_pin_fl" id="pin_fl_input" placeholder="PINFL паспорта" class="form-control" value="<?= $post['passport_pin_fl']?>">
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-large btn-block" onclick="SearchData(this, 'Подождите...')">Получить данные</button>

                </div>

                <div class="col-md-12">
                    <legend><b>Личные даные</b></legend>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <fieldset>

                                <div class="form-group">
                                    <label>Фамилия пациента:</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Введите Фамилия" value="<?= $post['last_name']?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Имя пациента:</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Введите имя" value="<?= $post['first_name']?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Отчество пациента:</label>
                                    <input type="text" name="father_name" id="father_name" class="form-control" placeholder="Введите Отчество" value="<?= $post['father_name']?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Дата рождение:</label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                        </span>
                                        <input type="date" name="dateBith" id="birth_date" class="form-control daterange-single" value="<?= $post['dateBith']?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Выбирите область:</label>
                                        <select data-placeholder="Выбрать область" id="province" class="form-control form-control-select2">
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
                                        <select data-placeholder="Выбрать регион" name="region" id="region" class="form-control form-control-select2">
                                            <option></option>
                                            <?php foreach ($db->query("SELECT * FROM region") as $row): ?>
                                                <option value="<?= $row['name'] ?>" data-chained="<?= $row['province_id'] ?>" <?= ($post['region'] == $row['name']) ? "selected" : "" ?>><?= $row['name'] ?></option>
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
                                        <input type="text" name="residenceAddress" class="form-control" placeholder="Введите адрес" value="<?= $post['residenceAddress']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Адрес по прописке:</label>
                                        <input type="text" name="registrationAddress" class="form-control" placeholder="Введите адрес" value="<?= $post['registrationAddress']?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label>Телефон номер:</label>
                                        <input type="text" name="numberPhone" class="form-control" value="<?= ($post['numberPhone']) ? $post['numberPhone'] : '+998'?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Место работы:</label>
                                    <input type="text" name="placeWork" placeholder="Введите место работы" class="form-control" value="<?= $post['placeWork']?>">
                                </div>

                                <div class="form-group">
                                    <label>Должность:</label>
                                    <input type="text" name="position" placeholder="Введите должность" class="form-control" value="<?= $post['position']?>">
                                </div>

                                <div class="form-group">
                                   <label class="d-block font-weight-semibold">Пол</label>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" id="gender_1" <?php if(1 == $post['gender']){echo "checked";} ?> value="1" class="form-check-input" name="unstyled-radio-left" checked>
                                            Мужчина
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" id="gender_0" <?php if(0 == $post['gender']){echo "checked";} ?> value="0" class="form-check-input" name="unstyled-radio-left">
                                            Женщина
                                        </label>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label class="d-block font-weight-semibold">Статус</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="resident" id="custom_checkbox_stacked_unchecked">
                                        <label class="custom-control-label" for="custom_checkbox_stacked_unchecked">Резидент</label>
                                    </div>
                                </div> -->

                            </fieldset>
                        </div>
                    </div>

                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#region").chained("#province");
            });

            function SearchData(btn, btn_new) {
        		var l_pin = document.getElementById('label_pin_fl_input');
        		var l_serial = document.getElementById('label_passport_serial_input');


        		var pin = document.getElementById('pin_fl_input');
        		var serial = document.getElementById('passport_serial_input');
        		var btn_old = btn.innerHTML;

        		if (pin.value && serial.value) {

        			btn.innerHTML = btn_new;
        			btn.disabled = true;

        			$.ajax({
        				type: "POST",
        				url: "<?= ajax("MVD_api") ?>",
        				data: {
        					pin_fl: pin.value,
        					seria: serial.value
        				},
        				success: function (response) {

        					try {
        						var data = JSON.parse(JSON.parse(response));
        						if (data.Status == 1) {

        							var result = data.Data;
        							$('#last_name').val(result.surname_latin.FirstUpperWords());
                                    $('#first_name').val(result.name_latin.FirstUpperWords());
        							$('#father_name').val(result.patronym_latin.FirstUpperWords());
        							$('#birth_date').val(result.birth_date);

        							if (result.sex == 1) {
        								$('#gender_1').prop('checked', true);
        							}else {
        								$('#gender_0').prop('checked', true);
        							}

        							l_pin.className = "text-success";
        							l_serial.className = "text-success";
        							pin.className = "form-control border-success";
        							serial.className = "form-control border-success";
        						}else{
        							l_pin.className = "text-danger";
        							l_serial.className = "text-danger";
        							pin.className = "form-control border-danger";
        							serial.className = "form-control border-danger";

        						}
        						console.log(data);
        					}catch (e) {

        						l_pin.className = "text-danger";
        						l_serial.className = "text-danger";
        						pin.className = "form-control border-danger";
        						serial.className = "form-control border-danger";
        						// инструкции для обработки ошибок
        						console.log("Ошибка"); // передать объект исключения обработчику ошибок

        					}finally {
        						btn.innerHTML = btn_old;
        						btn.disabled = false;
        					}

        				},
        			});

        		}
        	}
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