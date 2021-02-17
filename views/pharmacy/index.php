<?php
require_once '../../tools/warframe.php';
is_auth(4);
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

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Препараты</h6>
						<div class="header-elements">
							<div class="list-icons">

							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover table-sm datatable-basic">
                                <thead>
                                    <tr class="bg-info">
                                        <th>Препарат</th>
                                        <th>Поставщик</th>
                                        <th>Код</th>
										<th>Категория</th>
                                        <th>Доступное кол-во</th>
                                        <th>Цена</th>
                                        <th>Срок годности</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

					</div>

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
</body>
</html>
