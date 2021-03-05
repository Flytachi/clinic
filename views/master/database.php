<?php
require_once '../../tools/warframe.php';
is_auth('master');
$header = "База данных";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include 'navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include 'sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

                <div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">База данных</h5>
				    </div>

				    <div class="card-body">

                        <?php
                        if($_SESSION['message']){
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>

				        <div class="table-responsive">
				            <table class="table table-hover table-sm">
				                <thead>
				                    <tr class="bg-dark">
				                        <th>Table</th>
                                        <td>Records</td>
				                        <th class="text-right" style="width: 100px">Action</th>
				                    </tr>
				                </thead>
				                <tbody>
                                    <?php foreach ($db->query("show tables") as $row): ?>
                                        <tr>
                                            <td><?= $row['Tables_in_clinic'] ?></td>
                                            <td>
                                                <?php $rec = $db->query("SELECT count(*) FROM {$row['Tables_in_clinic']}")->fetchColumn() ?>
                                                <?php if ($rec == 0): ?>
                                                    <span class="text-success"><?= $rec ?></span>
                                                <?php elseif ($rec <= 10000000000): ?>
                                                    <span class="text-dark"><?= $rec ?></span>
                                                <?php else: ?>
                                                    <span class="text-danger"><?= $rec ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
	<!-- /page content -->

</body>
</html>
