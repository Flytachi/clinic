<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
is_module('pharmacy');
$header = "Препараты";
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

				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h6 class="card-title">Препараты</h6>
						<div class="header-elements">
							<div class="list-icons">
								<div class="header-elements">
									<div class="list-icons">
										<a href="<?= viv("pharmacy/storage") ?>" class="list-icons-item text-success">
											<i class="icon-plus22"></i>Склад
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body">



					</div>

				</div>

			</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script type="text/javascript">
        function Check(events) {
            $.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#check_div').html(result);
					setTimeout(function () {
						$('#check_card').fadeOut(900, function() {
                            $(this).remove();
                        });
		            }, 5000)
				},
			});
        }
    </script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
