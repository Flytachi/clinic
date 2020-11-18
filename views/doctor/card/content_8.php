<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "profile.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">
				        <?php include "content_tabs.php"; ?>

						<div class="row">
							<div class="col-md-6">
								<div class="card">
									<div class="card-header header-elements-inline">
										<h6 class="card-title">Примечание медсестры</h6>
										<div class="header-elements">
											<div class="list-icons">
												<a class="list-icons-item" data-action="reload"></a>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<div id="modal_iconified" class="modal fade" tabindex="-1">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title"><i class="icon-menu7 mr-2"></i> &nbsp;Modal with icons</h5>
														<button type="button" class="close" data-dismiss="modal">×</button>
													</div>

													<div class="modal-body">
														<div class="alert alert-info alert-dismissible alert-styled-left border-top-0 border-bottom-0 border-right-0">
															<span class="font-weight-semibold">Here we go!</span> Example of an alert inside modal.
															<button type="button" class="close" data-dismiss="alert">×</button>
														</div>

														<h6 class="font-weight-semibold"><i class="icon-law mr-2"></i> Sample heading with icon</h6>
														<p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>

														<hr />

														<p>
															<i class="icon-mention mr-2"></i> Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec
															ullamcorper nulla non metus auctor fringilla.
														</p>
													</div>

													<div class="modal-footer">
														<button class="btn btn-link legitRipple" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
														<button class="btn bg-primary legitRipple"><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
													</div>
												</div>
											</div>
										</div>
										<table class="table">
											<thead>
												<tr>
													<th style="width: 40px;">№</th>
													<th>Записки медсестры</th>
													<th>Дата и время</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>3</td>
													<td data-toggle="modal" data-target="#modal_iconified"><a href="#">Имя Медсестры</a></td>
													<td>16.10.2020 11:08</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card">
									<div class="card-header header-elements-inline">
										<h6 class="card-title">Примечание Врача</h6>
										<div class="header-elements">
											<div class="list-icons">
												<a class="list-icons-item" data-action="collapse"></a>
												<a class="list-icons-item" data-action="reload"></a>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th style="width: 40px;">№</th>
													<th>Записки врача</th>
													<th>Дата и время</th>
													<th class="text-center" style="width: 100px;">Добавить Запись</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>3</td>
													<td><a href="#">Имя Врача</a></td>
													<td>16.10.2020 11:08</td>
													<td class="text-center">
														<div class="list-icons">
															<a href="#" class="list-icons-item" data-toggle="context" data-target=".context-table-content">
																<i class="icon-plus22"></i>
															</a>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

				    </div>

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
