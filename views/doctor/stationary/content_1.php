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

				<?php include "../profile_card.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">

				        <?php include "content_tabs.php"; ?>

                        <div class="card">
                            <table class="table table-togglable table-hover">
                                <thead>
                                    <tr class="bg-blue text-center">
                                        <th>ID</th>
                                        <th>ФИО</th>
                                        <th>Дата визита</th>
                                        <th>Мед Услуга</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>00001</td>
                                        <td>Якубов Фарход Абдурасулович</td>
                                        <td>04.10.2020</td>
                                        <td>Осмотр терапевта</td>
                                        <td><span class="badge badge-success">Оплачено</span></td>
                                    </tr>
                                </tbody>
                            </table>
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
