<?php
require_once '../../tools/warframe.php';
is_auth(1);
$header = "Анализы";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

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
                      	<h5 class="card-title">Добавить Анализ</h5>
                      	<div class="header-elements">
                          	<div class="list-icons">
                              	<a class="list-icons-item" data-action="collapse"></a>
                          	</div>
                      	</div>
                  	</div>
                  	<div class="card-body" id="form_card">
                      	<?php LaboratoryAnalyzeTypeModel::form(); ?>
                  	</div>

            	</div>

                <div class="card">

                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Список Анализов</h5>
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
                                        <th style="width:7%">№</th>
                                        <th>Код</th>
                                        <th>Название</th>
                                        <th>Услуга</th>
                                        <th>Норматив</th>
                                        <th>Статус</th>
                                        <th style="width: 100px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($db->query('SELECT * from laboratory_analyze_type') as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $row['code'] ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td>
                                                <?php
                                                $stmt = $db->query("SELECT * from service where id = ".$row['service_id'])->fetch(PDO::FETCH_OBJ);
                                                echo $stmt->name;
                                                ?>
                                            </td>
                                            <td><?= $row['standart'] ?></td>
                                            <td><?= ($row['status']) ? "Активный" : "Не активный" ?></td>
                                            <td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row['id'], 'LaboratoryAnalyzeTypeModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'LaboratoryAnalyzeTypeModel') ?>" onclick="return confirm('Вы уверены что хотите удалить койку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
	</script>

</body>
</html>
