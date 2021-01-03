<?php
require_once '../../tools/warframe.php';
is_auth(4);
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<?php
	function formatMoney($number, $fractional=false) {
		if ($fractional) {
			$number = sprintf('%.2f', $number);
			// echo " ff ". $number." ff ";
		}
		while (true) {
			$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
			// echo " ff ". $replaced." ff ";
			if ($replaced != $number) {
				$number = $replaced;
			} else {
				break;
			}
		}
		return $number;
	}

?>

<script src="<?= stack("global_assets/js/plugins/extensions/jquery_ui/interactions.min.js")?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js")?>"></script>

<script src="<?= stack("assets/js/app.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js")?>"></script>

<body>
	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include '../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->

		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<div class="card">

					<div class="card-body">

						<div class="card-header header-elements-inline">
			              	<h5 class="card-title">Шаблон</h5>
			              	<div class="header-elements">
		                  		<div class="list-icons">
									<a href="../templates/supliers.xlsx" class="btn" download>Шаблон</a>
			                      	<a class="list-icons-item" data-action="collapse"></a>
			                  	</div>
			              	</div>
			          	</div>
						
						<?php SupliersModel::form_template(); ?>
					</div>

				</div>

				<div class="card">
					
					<div class="card-body">
						
						<?php 
							$rowcount = $db->query("SELECT * FROM supliers ORDER BY suplier_id DESC")->rowcount();
						?>

						<div class="row">
							<div class="col-md-6">
								Общее количество поставщиков: <span class="badge badge-flat badge-pill border-success text-success-600"><?= $rowcount;?></span>
							</div>
						</div>
					</div>

				</div>

				<div class="card">

					<div class="card-body">
						<form action="incoming.php" method="post" >
							<div class="row">
								<div class="col-md-10">
									<input type="text" name="qty" id="qty"  class="form-control">	
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_form_vertical" />Добавить</button>	
									<!-- <button type="button" class="btn btn-light legitRipple" data-toggle="modal" data-target="#modal_form_vertical">Launch <i class="icon-play3 ml-2"></i></button> -->
								</div>
							</div>
						</form>
					</div>
					
				</div>

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Список Поставщики</h5>
				    </div>

				    <div class="card-body">

				        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="bg-blue">
					                    <th> Название поставщика </th>
										<th> Контактное лицо </th>
										<th> Адрес </th>
										<th> Телефон.</th>
										<th>Р/с</th>
										<th>Банк</th>
										<th>МФО</th>
										<th>ИНН</th>
										<th> Заметки</th>
										<th width="120"> Действия </th>
				                    </tr>
				                </thead>
				                <tbody>

				                	<?php

				                	$result = $db->query("SELECT * FROM supliers ORDER BY suplier_id DESC");
									while($row = $result->fetch(PDO::FETCH_ASSOC)) {
									?>
							
									<tr>
										<td><?= $row['suplier_name']; ?></td>
										<td><?= $row['contact_person']; ?></td>
										<td><?= $row['suplier_address']; ?></td>
										<td><?= $row['suplier_contact']; ?></td>
										<td><?= $row['rsh']; ?></td>
										<td><?= $row['bank']; ?></td>
										<td><?= $row['mf']; ?></td>
										<td><?= $row['inn']; ?></td>
										<td><?= $row['note']; ?></td>

										<td>
											<i class="icon-pencil7" data-toggle="modal" data-target="#a<?= $row['suplier_id'] ?>"></i>
											<a href="deletesupplier.php?id=<?= $row['suplier_id'] ?>" class="delbutton" title="Удалить"><i class="icon-trash"></i></a>
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
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<div id="modal_form_vertical" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Новый поставщик</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<form action="savesupplier.php" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Имя поставщика </label>
									<input type="text" name="suplier_name" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Адрес</label>
									<input type="text" name="suplier_address" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Контактное лицо</label>
									<input type="text" name="suplier_contact" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Телефон</label>
									<input type="text" name="contact_person" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Р/с</label>
									<input type="text" name="rsh" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Банк</label>
									<input type="text" name="bank" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>МФО</label>
									<input type="text" name="mf" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>ИНН</label>
									<input type="text" name="inn" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Заметки</label>
									<textarea rows="3" cols="3" name="note" class="form-control" ></textarea>
								</div>
							</div>
						</div>


					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Закрыть</button>
						<button type="submit" class="btn bg-primary legitRipple">Сохранить</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php

		$result = $db->query("SELECT * FROM supliers ORDER BY suplier_id DESC");
		while($row = $result->fetch()) {
	?>

		<div id="a<?= $row['suplier_id'] ?>" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Новый поставщик</h5>
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>

					<form action="saveeditsuppler.php" method="POST">
						<input type="hidden" name="id" value="<?= $row['suplier_id'] ?>">
						<div class="modal-body">
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Имя поставщика </label>
										<input type="text" name="suplier_name" value="<?= $row['suplier_name'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Адрес</label>
										<input type="text" name="suplier_address" value="<?= $row['suplier_address'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Контактное лицо</label>
										<input type="text" name="suplier_contact" value="<?= $row['suplier_contact'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Телефон</label>
										<input type="text" name="contact_person" value="<?= $row['contact_person'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Р/с</label>
										<input type="text" name="rsh" value="<?= $row['rsh'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Банк</label>
										<input type="text" name="bank" value="<?= $row['bank'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>МФО</label>
										<input type="text" name="mf" value="<?= $row['mf'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>ИНН</label>
										<input type="text" name="inn" value="<?= $row['inn'] ?>" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Заметки</label>
										<textarea rows="3" cols="3" name="note" value="<?= $row['note'] ?>" class="form-control" ><?= $row['note'] ?></textarea>
									</div>
								</div>
							</div>


						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Закрыть</button>
							<button type="submit" class="btn bg-primary legitRipple">Сохранить</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	<?php

		}
	?>


	<!-- /page content -->

    <!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
