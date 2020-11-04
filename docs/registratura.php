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
			<li class="nav-item"><a href="#basic-justified-tab2" class="nav-link legitRipple" data-toggle="tab">Список пациетов</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane fade active show" id="basic-justified-tab1">
				<?php form('PatientRegistration');?>
			</div>

			<div class="tab-pane fade" id="basic-justified-tab2">
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
				            foreach($db->query('SELECT * FROM users WHERE user_level = 3') as $row) {
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
