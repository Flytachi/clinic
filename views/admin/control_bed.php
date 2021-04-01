<?php 
require_once '../../tools/warframe.php';
is_auth(1);
$header = "";
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
                        <h6 class="card-title">Beds</h6>
                        <div class="header-elements">
                            <div class="list-icons">
                                <button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered" id="table">
                                <thead>
                                    <tr class="bg-info">
                                        <th>Этаж</th>
                                        <th>Палата</th>
                                        <th>Койка</th>
                                        <th>Тип</th>
                                        <th>user_id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach($db->query('SELECT * FROM beds') as $row) {
                                        $row1 = $db->query("SELECT * FROM wards WHERE id = {$row['ward_id']}")->fetch(); 
                                        $row2 = $db->query("SELECT * FROM bed_type WHERE id = {$row['types']}")->fetch();
                                        // prit($user1);
                                        ?>
                                        <tr>
                                            <td><?= $row1['floor'] ?> этаж</td>
                                            <td><?= $row1['ward'] ?> палата</td>
                                            <td><?= $row['bed'] ?> койка</td>
                                            <td><?= $row2['name']?></td>
                                            <td><?= get_full_name($row['user_id']) ?></td>
                                    </tr>
                                    <?php
                                }?> 
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

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>