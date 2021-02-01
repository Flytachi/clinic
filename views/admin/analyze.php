<?php
require_once '../../tools/warframe.php';
is_auth(1);
$header = "Анализы";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

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
                            <table class="table table-hover datatable-basic">
                                <thead>
                                    <tr class="bg-blue">
                                        <th style="width:7%">№</th>
                                        <th>Код</th>
                                        <th>Название</th>
                                        <th>Услуга</th>
                                        <th>Норма</th>
										<th>Ед</th>
                                        <th>Статус</th>
                                        <th style="width: 100px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($db->query('SELECT * from laboratory_analyze_type ORDER BY id DESC') as $row) {
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
                                            <td>
												<?php
												switch ($row['standart_type']) {
													case 1:
														echo $row['standart_min']." ".$row['standart_sign']." ".$row['standart_max'];
														break;
													case 2:
														if ($row['standart_fun'] == 2) {
															echo "Положительный (+)";
														}else {
															echo "Отрицательный (-)";
														};
														break;
													case 3:
														echo "Жен (".$row['standart_sex0_min']." ".$row['standart_sex0_sign']." ".$row['standart_sex0_max'].") <br>";
														echo "Муж (".$row['standart_sex1_min']." ".$row['standart_sex1_sign']." ".$row['standart_sex1_max'].")";
														break;
												}
												?>
											</td>
											<td><?= $row['unit'] ?></td>
                                            <td><?= ($row['status']) ? "Активный" : "Не активный" ?></td>
                                            <td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row['id'], 'LaboratoryAnalyzeTypeModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'LaboratoryAnalyzeTypeModel') ?>" onclick="return confirm('Вы уверены что хотите удалить анализ?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
    <?php include layout('footer') ?>
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
