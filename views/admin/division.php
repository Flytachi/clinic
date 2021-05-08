<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Класификация персонала";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack('global_assets/js/plugins/forms/inputs/touchspin.min.js') ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack('global_assets/js/demo_pages/form_input_groups.js') ?>"></script>
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

        		<div class="<?= $classes['card'] ?>">

              		<div class="<?= $classes['card-header'] ?>">
                      	<h5 class="card-title">Добавить Разделение</h5>
                      	<div class="header-elements">
                          	<div class="list-icons">
                              	<a class="list-icons-item" data-action="collapse"></a>
                          	</div>
                      	</div>
                  	</div>
                  	<div class="card-body" id="form_card">
                      	<?php (new DivisionModel)->form(); ?>
                  	</div>

            	</div>

                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h5 class="card-title">Список Разделений</h5>
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
                                    <tr class="<?= $classes['table-thead'] ?>">
                                        <th style="width:7%">Id</th>
                                        <th>Роль</th>
                                        <th>Отдел</th>
                                        <th>Название специолиста</th>
                                        <th style="width: 100px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($db->query('SELECT * from division') as $row): ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $PERSONAL[$row['level']] ?></td>
                                            <td><?= $row['title'] ?></td>
                                            <td><?= $row['name'] ?> <?= ($row['assist'] == 1) ? "\"Ассистент\"" : "" ?></td>
                                            <td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row['id'], 'DivisionModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'DivisionModel') ?>" onclick="return confirm('Вы уверены что хотите удалить отдел?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
				                                </div>
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
