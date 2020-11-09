<?php
require_once '../../tools/warframe.php';
is_auth(3);
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

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
			<!-- Content area -->
			<div class="content">

				<!-- Highlighted tabs -->
				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Подробнее о пациенте</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body" id="form_card">

						<div class="table-responsive">
		                    <table class="table table-hover">
		                        <thead>
		                            <tr class="bg-blue">
		                                <th>Дата и время</th>
		                                <th>Мед услуги</th>
		                                <th>Сумма</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                            <tr>
		                                <td>04.02.2021</td>
		                                <td>Осмотр терапевта</td>
		                                <td>50 000</td>
		                            </tr>
		                            <tr>
		                                <td>04.02.2021</td>
		                                <td>МРТ</td>
		                                <td>300 000</td>
		                            </tr>
		                            <tr>
		                                <td>04.02.2021</td>
		                                <td>Массаж</td>
		                                <td>60 000</td>
		                            </tr>
		                            <tr>
		                                <td></td>
		                                <td></td>
		                                <td>
		                                    <button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple" data-toggle="modal" data-target="#modal_default">Оплата</button>
		                                </td>
		                            </tr>

		                        </tbody>
		                    </table>
		                </div>

				    </div>

				</div>

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Приём платежей</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body" id="form_card">

						<div class="table-responsive">
		                    <table class="table table-hover">
		                        <thead>
		                            <tr>
		                                <th>#</th>
		                                <th>ID</th>
		                                <th>ФИО</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                            <tr>
		                                <td>1</td>
		                                <td>0007</td>
		                                <td>Kopyov</td>
		                            </tr>

		                        </tbody>
		                    </table>
		                </div>

				    </div>

				</div>
				<!-- /highlighted tabs -->

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


	<!-- Basic modal -->
	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Оплата</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">

								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-md-10 offset-md-1">
											<form action="#">

												<div class="form-group" style="margin-bottom: 0px !important;">
													<label class="col-form-label" style="margin-bottom: -5px !important;">Сумма к оплате:</label>
													<input type="text" class="form-control" value="300 000" disabled>
												</div>

												<div class="form-group" style="margin-bottom: 0px !important;">
													<label class="col-form-label" style="margin-bottom: -5px !important;">Скидка:</label>
													<input type="text" class="form-control" placeholder="%">
												</div>


												<div class="form-group" style="margin-bottom: 0px !important;">
													<label class="col-form-label" style="margin-bottom: -5px !important;">Пластиковая карта:</label>
													<input type="text" class="form-control" placeholder="">
												</div>

												<div class="form-group" style="margin-bottom: 0px !important;">
													<label class="col-form-label" style="margin-bottom: -5px !important;">Перечисление:</label>
													<input type="text" class="form-control" placeholder="">
												</div>

												<div class="form-group" style="margin-bottom: 0px !important;">
													<label class="col-form-label" style="margin-bottom: -5px !important;">Наличный расчет:</label>
													<input type="text" class="form-control" placeholder="" >
												</div>

											</form>
										</div>
									</div>
								</div>
							</div>
						</div>

						<h6 class="mb-0 font-weight-semibold">
							<ul>
								<li style="margin-bottom: -15px !important;">Общая сумма к оплате - 300000</li><br>
								<li style="margin-bottom: -15px !important;">Скидка-0</li><br>
								<li style="margin-bottom: -15px !important;">Сумма с скидками-300000</li>
							</ul>
						</h6>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
					<button type="button" class="btn bg-primary">Печать чека</button>
				</div>
			</div>
		</div>
	</div>


	<div id="modal_default2" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Возврат</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th style="width:20%;">Дата и время</th>
								<th>Мед услуги</th>
								<th>Сумма</th>
								<th>Статус</th>
								<th>Действия</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>02.05.2021 14:30</td>
								<td>Осмотр терапевта</td>
								<td>50000</td>
								<td>Проведен/Пластик</td>
								<td><button type="button" class="btn btn-sm btn-danger legitRipple" data-toggle="button">Отменить</button></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Закрыть</button>
					<button type="button" class="btn bg-primary">Печать чека</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /basic modal -->



    <!-- Footer -->
    <?php include 'layout/footer.php' ?>
    <!-- /footer -->

</body>
</html>
