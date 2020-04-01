<div class="row">
	<div class="col-md-6">

	</div>

	<div class="col-md-6">

	</div>
</div>
<!-- /vertical form options -->

<!-- 2 columns form -->

<div class="card">

	<div class="card-body">
		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item"><a href="#basic-justified-tab1" class="nav-link legitRipple active show" data-toggle="tab">Регистрация</a></li>
			<li class="nav-item"><a href="#basic-justified-tab2" class="nav-link legitRipple" data-toggle="tab">Стационарная</a></li>
			<li class="nav-item"><a href="#basic-justified-tab3" class="nav-link legitRipple" data-toggle="tab">Амбулаторная</a></li>
			<li class="nav-item"><a href="#basic-justified-tab4" class="nav-link legitRipple" data-toggle="tab">Список пациетов</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane fade active show" id="basic-justified-tab1">
				<?php form('PatientRegistration');?>
			</div>

			<div class="tab-pane fade" id="basic-justified-tab2">
				<div class="row">

					<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Стационарная</legend>

					<div class="col-md-3">
						<div class="form-group">
                            <label>Выберите пациета:</label>
                            <select data-placeholder="Выбрать регион" name="region" class="form-control form-control-select2" data-fouc>
                               <?php

                               		$stm = $db->query('SELECT * FROM users WHERE user_level = 15 ');

                               		foreach ($stm as $key) {
                               			?>

                               			<option value="<?= addZero($key['id']) ?>"><?= addZero($key['id']) ?> - <?= $key['first_name'] ?> <?= $key['last_name'] ?> <?= $key['father_name'] ?></option>

                               			<?php
                               		}

                               ?>
                            </select>
                        </div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
		                    <label>Этаж:</label>
		                    <select data-placeholder="Выбрать группу" name="" id="floor" class="form-control form-control-select2" required data-fouc>
		                        <option></option>
		                        <?php
		                        foreach($FLOOR as $key => $value) {
		                            ?>
		                            <option value="<?= $key ?>"><?= $value ?></option>
		                            <?php
		                        }
		                        ?>
		                    </select>
		                </div>
		            </div>

					<div class="col-md-3">
		                <div class="form-group">
		                    <label>Палата:</label>
		                    <select data-placeholder="Выбрать категорию" name="" id="ward" class="form-control form-control-select2" required data-fouc>
		                        <option></option>
		                        <?php
		                        foreach($db->query('SELECT * from beds') as $row) {
		                            ?>
		                            <option value="<?= $row['ward'] ?>" data-chained="<?= $row['floor'] ?>"><?= $row['ward'] ?> палата</option>
		                            <?php
		                        }
		                        ?>
		                    </select>
		                </div>
		            </div>

					<div class="col-md-3">
		                <div class="form-group">
		                    <label>Койка:</label>
		                    <select data-placeholder="Выбрать койку" name="" id="bed" class="form-control form-control-select2" required data-fouc>
		                        <option></option>
		                        <?php
		                        foreach($db->query('SELECT * from beds') as $row) {
		                            ?>
		                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward'] ?>"><?= $row['num'] ?> палата</option>
		                            <?php
		                        }
		                        ?>
		                    </select>
		                </div>
		            </div>

		                <script type="text/javascript">
			                $(function(){
			                    $("#ward").chained("#floor");
			                    $("#bed").chained("#ward");

			                });
			            </script>
					</div>

					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group">
	                            <label>Выберите отдел:</label>
	                            <select data-placeholder="Выберите специалиста" name="region" class="form-control form-control-select2" data-fouc>
	                               <?php

	                               		$stm = $db->query('SELECT * FROM users WHERE user_level = 6 ');

	                               		foreach ($stm as $key) {
	                               			?>

	                               			<option value="<?= addZero($key['id']) ?>"><?= addZero($key['id']) ?> - <?= $key['first_name'] ?> <?= $key['last_name'] ?> <?= $key['father_name'] ?></option>

	                               			<?php
	                               		}

	                               ?>
	                            </select>
	                        </div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
	                            <label>Выберите специалиста:</label>
	                            <select data-placeholder="Выберите специалиста" name="region" class="form-control form-control-select2" data-fouc>
	                               <?php

	                               		$stm = $db->query('SELECT * FROM users WHERE user_level = 5 ');

	                               		foreach ($stm as $key) {
	                               			?>

	                               			<option value="<?= addZero($key['id']) ?>"><?= addZero($key['id']) ?> - <?= $key['first_name'] ?> <?= $key['last_name'] ?> <?= $key['father_name'] ?></option>

	                               			<?php
	                               		}

	                               ?>
	                            </select>
	                        </div>
						</div>

					</div>
					
				</div>

			<div class="tab-pane fade" id="basic-justified-tab3">
				<div class="row">

					<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Амбулаторная</legend>

					<div class="col-md-3">
						<div class="form-group">
                            <label>Выберите пациета:</label>
                            <select data-placeholder="Выбрать регион" name="region" class="form-control form-control-select2" data-fouc>
                               <?php

                               		$stm = $db->query('SELECT * FROM users WHERE user_level = 15 ');

                               		foreach ($stm as $key) {
                               			?>

                               			<option value="<?= addZero($key['id']) ?>"><?= addZero($key['id']) ?> - <?= $key['first_name'] ?> <?= $key['last_name'] ?> <?= $key['father_name'] ?></option>

                               			<?php
                               		}

                               ?>
                            </select>
                        </div>
					</div>
					<div class="col-md-4">
							<div class="form-group">
	                            <label>Выберите группу:</label>
	                            <select data-placeholder="Выберите специалиста" name="region" class="form-control form-control-select2" data-fouc>
	                               <?php

	                               		$stm = $db->query('SELECT * FROM users WHERE user_level = 6 ');

	                               		foreach ($stm as $key) {
	                               			?>

	                               			<option value="<?= addZero($key['id']) ?>"><?= addZero($key['id']) ?> - <?= $key['first_name'] ?> <?= $key['last_name'] ?> <?= $key['father_name'] ?></option>

	                               			<?php
	                               		}

	                               ?>
	                            </select>
	                        </div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
	                            <label>Выберите категорию:</label>
	                            <select data-placeholder="Выберите специалиста" name="region" class="form-control form-control-select2" data-fouc>
	                               <?php

	                               		$stm = $db->query('SELECT * FROM users WHERE user_level = 5 ');

	                               		foreach ($stm as $key) {
	                               			?>

	                               			<option value="<?= addZero($key['id']) ?>"><?= addZero($key['id']) ?> - <?= $key['first_name'] ?> <?= $key['last_name'] ?> <?= $key['father_name'] ?></option>

	                               			<?php
	                               		}

	                               ?>
	                            </select>
	                        </div>
						</div>
				</div>

				<div class="row">
					
					<div class="col-md-4">
							<div class="form-group">
	                            <label>Выберите услугу:</label>
	                            <select data-placeholder="Выберите специалиста" name="region" class="form-control form-control-select2" data-fouc>
	                               <?php

	                               		$stm = $db->query('SELECT * FROM users WHERE user_level = 5 ');

	                               		foreach ($stm as $key) {
	                               			?>

	                               			<option value="<?= addZero($key['id']) ?>"><?= addZero($key['id']) ?> - <?= $key['first_name'] ?> <?= $key['last_name'] ?> <?= $key['father_name'] ?></option>

	                               			<?php
	                               		}

	                               ?>
	                            </select>
	                        </div>
						</div>

						<div class="col-md-4">
                            <div class="form-group">
                                <label>Специалист:</label>
                                <input type="text" name="residenceAddress" class="form-control" placeholder="Специалист" value="<?= $_SESSION[$form_name]['residenceAddress']?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>№ кабинета:</label>
                                <input type="text" name="registrationAddress" class="form-control" placeholder="Кабинета" value="<?= $_SESSION[$form_name]['registrationAddress']?>">
                            </div>
                        </div>

				</div>

			</div>

			<div class="tab-pane fade" id="basic-justified-tab4">
				<div class="card card-table table-responsive shadow-0 mb-0">
				    <table class="table table-bordered">
						<thead>
							<tr>
								<th>ID</th>
								<th>Имя</th>
								<th>Фамилия</th>
								<th>Отчество</th>
								<th>Дата рождение</th>
								<th>Телефон</th>
								<th>Мед услуга</th>
								<th>Дата визита</th>
								<!-- <th>Тип визита</th> -->
								<th class="text-center">Действия</th>
							</tr>
						</thead>
						<tbody>
				            <?php 
				            $i = 1;
				            foreach($db->query('SELECT * FROM users WHERE user_level = 15') as $row) {
				                ?>
				                <tr>
				                    <td><?= addZero($row['id']) ?></td>
				                    <td><?= $row['first_name'] ?></td>
				                    <td><?= $row['last_name'] ?></td>
				                    <td><?= $row['father_name'] ?></td>
				                    <td><?= $row['dateBith'] ?></td>
				                    <td><?= $row['numberPhone'] ?></td>
				                    <td><?= $row['service'] ?></td>
				                    <td><?= $row['add_date'] ?></td>
				                    <td>
				                        <div class="list-icons">
				                            <a href="model/update.php?id=<?= $row['id'] ?>&form=PatientRegistration" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
				                            <!-- <a href="#" class="list-icons-item text-teal-600"><i class="icon-cog6"></i></a> -->
				                        </div>
				                    </td>
				                </tr>
				                <?php
				            }
				            ?>
				        </tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>
