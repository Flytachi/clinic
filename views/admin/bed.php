<?php
require_once '../../tools/warframe.php';
is_auth(1);
$header = "Койки";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

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

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

                <div class="card">

                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Добавить Койку</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">
                                <legend class="font-weight-semibold"> Добавить койку</legend>
								<div id="form_card">
								   <?php BedModel::form(); ?>
							   	</div>
                            </div>

                            <div class="col-md-6">
                            <legend class="font-weight-semibold"> Добавить тип коек</legend>
								<div id="form_card2">
								   <?php BedTypeModel::form(); ?>
							   	</div>

                                <table class="table table-hover">
                                    <thead>
                                        <tr class="">
                                            <th>Вид</th>
                                            <th>Цена</th>
                                            <th style="width: 100px">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($db->query('SELECT * from bed_type') as $row) {
                                            ?>
                                            <tr>
                                                <td><?= $row['name'] ?></td>
                                                <td><?= $row['price'] ?></td>
                                                <td>
													<div class="list-icons">
														<a onclick="Update2('<?= up_url($row['id'], 'BedTypeModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
														<a href="<?= del_url($row['id'], 'BedTypeModel') ?>" onclick="return confirm('Вы уверены что хотите удалить койку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
													</div>
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

                </div>

                <div class="card">

                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Список Коек</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="bg-blue">
                                        <th>Этаж</th>
                                        <th>Палата</th>
                                        <th>Койка</th>
                                        <th>Тип</th>
                                        <th>Цена</th>
                                        <th style="width: 100px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($db->query('SELECT wd.floor, wd.ward, bd.bed, bd.types from beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id)') as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $row['floor'] ?> этаж</td>
                                            <td><?= $row['ward'] ?> палата</td>
                                            <td><?= $row['bed'] ?> койка</td>
                                            <td>
                                                <?php
                                                    $stmt = $db->query("SELECT * from bed_type where id = ".$row['types'])->fetch(PDO::FETCH_OBJ);
                                                    echo $stmt->name;
                                                ?>
                                            </td>
                                            <td><?= $stmt->price ?></td>
                                            <td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row['id'], 'BedModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'BedModel') ?>" onclick="return confirm('Вы уверены что хотите удалить койку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
				                                </div>
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

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->

	<script type="text/javascript">
		function Update(events) {
			events
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#form_card').html(result);
				},
			});
		};
		function Update2(events) {
			events
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#form_card2').html(result);
				},
			});
		};
	</script>

</body>
</html>
