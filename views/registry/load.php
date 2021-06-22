<?php
require_once '../../tools/warframe.php';
$session->is_auth([2, 32]);
$header = "Список пациентов";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<link href="<?= stack("vendors/css/load.css") ?>" rel="stylesheet" type="text/css">

<body>
	<!-- Main navbar -->
	<?php include layout('navbar') ?>
	<!-- /main navbar -->

	<div class="preloader">
		<div class="preloader__image"></div>
	</div>

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

				<?php include 'tabs.php' ?>

				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h6 class="card-title">Список пациентов</h6>
						<div class="header-elements">
							<form action="" class="mr-2">
								<div class="form-group-feedback form-group-feedback-right">
									<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите ID или имя">
									<div class="form-control-feedback">
										<i class="icon-search4 font-size-base text-muted"></i>
									</div>
								</div>
							</form>
							<a onclick="Update('<?= up_url(null, 'PatientForm') ?>')" class="btn bg-success btn-icon ml-2 legitRipple"><i class="icon-plus22"></i></a>
						</div>
					</div>

					<div class="card-body" id="search_display">

						<img src="load.gif" alt="this slowpoke moves"  width="250" />
						<?php 
						$a;
						while ($a <= 100000) {
							$a++;
							echo "<span>Good</span><br>";
						}
						?>

					</div>

				</div>


			</div>
            <!-- /content area -->
		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">
		window.onload = function () {
			const $body = document.body;
			const $preloader = $body.querySelector('.preloader');
			function afterTransition() {
				$body.classList.add('loaded');
				$body.classList.remove('loaded_hiding');
				$preloader.removeEventListener('transitionend', afterTransition);
			}
			$body.classList.add('loaded_hiding');
			$preloader.addEventListener('transitionend', afterTransition);
		}
	</script>

</body>
</html>
