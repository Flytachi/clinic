<?php
require_once '../../tools/warframe.php';
// require_once 'in.php';
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
									<a href="../templates/goods.xlsx" class="btn" download>Шаблон</a>
			                      	<a class="list-icons-item" data-action="collapse"></a>
			                  	</div>
			              	</div>
			          	</div>
					
						<?php GoodsModel::form_template(); ?>
					</div>

				</div>

				<div class="card">
					
					<div class="card-body">
						
						<?php 
							$rowcount = $db->query("SELECT * FROM goods ORDER BY id DESC")->rowcount();
						?>

						<div class="row">
							<div class="col-md-6">
								Количество вида препаратов: <span class="badge badge-flat badge-pill border-success text-success-600"><?= $rowcount;?></span>
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
								</div>
							</div>
						</form>
					</div>
					
				</div>

				<div class="card">

				    <div class="card-body">

				        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="bg-blue">
					                    <th> Название </th>
										<th> Действия </th>
				                    </tr>
				                </thead>
				                <tbody>

				                	<?php

				                	$count = ceil(intval($db->query("SELECT COUNT(*) FROM goods ")->fetch()['COUNT(*)']) / 5); 

				                	$offset = intval($_GET['of']) * 5 ;

				                	$slq = "SELECT * FROM goods ORDER BY id DESC LIMIT 5 OFFSET $offset ";

				                	$result = $db->query($slq);
									while($row = $result->fetch(PDO::FETCH_ASSOC)) {
									?>
							
									<tr class="record">
										<td><?= $row['goodname']; ?></td>

										<td>
											<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#a<?= $row['id'] ?>"><i class="icon-pencil3"></i></button>
											<a href="deleteprep.php?id=<?= $row['id']; ?>" id="" class="delbutton" title="Удалить"><button class="btn btn-danger"><i class="icon-trash"></i></button></a>
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

				<div class="card card-body text-center">
					<ul class="pagination align-self-center">

						<?php 

							for ($i= intval($_GET['of']) <= 5 ? (intval($_GET['of']) - (intval($_GET['of']) - 1)) : intval($_GET['of']) - 5; $i < intval($_GET['of']) and $i >= 1 ; $i++) {
						 ?>
							<li class="page-item"><a href="all_prep.php?of=<?= $i ?>" class="page-link legitRipple"><?= $i ?></a></li>

						<?php 
							}
						 ?>

							<li class="page-item"><a href="all_prep.php?of=<?= $i ?>" class="page-link legitRipple"><?= intval($_GET['of']) ?></a></li>


						 <?php 

							for ($i= (intval($_GET['of'])+1) ; $i < (intval($_GET['of'])+5) and $i < $count; $i++) {
						 ?>
							<li class="page-item"><a href="all_prep.php?of=<?= $i ?>" class="page-link legitRipple"><?= $i ?></a></li>

						<?php 
							}
						 ?>
					
					</ul>
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
					<h5 class="modal-title"> Добавить клиента</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<form action="savenewpr.php" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<div class="col-md-12">
								<input type="text" name="goodname"  class="form-control">	
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

		$result = $db->query("SELECT * FROM goods ORDER BY id DESC");
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		?>

		<div id="a<?= $row['id'] ?>" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"> Добавить клиента</h5>
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>

					<form action="savenewpr.php" method="POST">
						<div class="modal-body">
							<div class="form-group">
								<div class="col-md-12">
									<input type="text" name="goodname" value="<?= $row['goodname'] ?>"  class="form-control">	
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
