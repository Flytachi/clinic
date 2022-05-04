<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Доход";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<body>
	<!-- Main navbar -->
	<?php include layout('navbar') ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include layout('sidebar') ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include layout('header') ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "content_tabs.php"; ?>

                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h6 class="card-title" >Фильтр UP</h6>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

						<form action="" method="post">

							<div class="form-group row">

								<div class="col-md-3">
									<label>Промежуток времени:</label>
									<div class="input-group">
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_POST['date']) ) ? $_POST['date'] : '' ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

								<div class="col-md-3">
									<label>Отдел:</label>
									<select id="division" name="division_id" class="<?= $classes['form-select'] ?>">
									   <option value="">Выберите отдел</option>
										<?php foreach($db->query("SELECT * from division WHERE level = 5") as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ( isset($_POST['division_id']) and $_POST['division_id']==$row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3">
									<label>Специалист:</label>
									<select id="parent_id" name="parent_id" class="<?= $classes['form-select'] ?>">
										<option value="">Выберите специалиста</option>
										<?php foreach($db->query("SELECT * from users WHERE user_level IN(5)") as $row): ?>
											<option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" <?= ( isset($_POST['parent_id']) and $_POST['parent_id']==$row['id']) ? "selected" : "" ?>><?= get_full_name($row['id']) ?></option>
										<?php endforeach; ?>
									</select>
								</div>

							</div>

							<div class="text-right">
								<button type="submit" class="btn btn-outline-info"><i class="icon-search4 mr-2"></i>Поиск</button>
							</div>


						</form>

                    </div>

                </div>

				<?php if ($_POST): ?>
					<div class="card card-body border-1 border-primary" style="font-size: 1rem;">
						<div class="text-center">
							<h4 class="mb-0 font-weight-semibold"><?= get_full_name($_POST['parent_id']) ?></h4>
							<p class="mb-3 text-muted">Врач <?= division_name($_POST['parent_id']) ?></p>
						</div>

						<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
							<li class="nav-item"><a onclick="Tab_control('<?= viv('reports/income/easy') ?>')" href="#" class="nav-link legitRipple active show" data-toggle="tab">Просмотр</a></li>
							<li class="nav-item"><a onclick="Tab_control('<?= viv('reports/income/detail') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Детально</a></li>
						</ul>

						<div class="card card-body bg-light mb-0" id="div_show_tabs">
							<script>
								$(document).ready(function(){
									Tab_control('<?= viv('reports/income/easy') ?>');
								});
							</script>
						</div>
					</div>

				<?php endif; ?>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

	<script type="text/javascript">
		$(function(){
			$("#parent_id").chained("#division");
		});

		function Tab_control(params) {
            $.ajax({
				type: "POST",
				url: params,
				data: {
					date: "<?= ( isset($_POST['date']) ) ? $_POST['date'] : '' ?>",
					parent_id: "<?= ( isset($_POST['parent_id']) ) ? $_POST['parent_id'] : '' ?>",
				},	
				success: function (result) {
					$('#div_show_tabs').html(result);
				},
			});
		}

		function Detail_control(params) {
            $.ajax({
				type: "POST",
				url: params,
				data: {
					date: "<?= ( isset($_POST['date']) ) ? $_POST['date'] : '' ?>",
					parent_id: "<?= ( isset($_POST['parent_id']) ) ? $_POST['parent_id'] : '' ?>",
				},	
				success: function (result) {
					$('#div_show_detail').html(result);
				},
			});
		}
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
