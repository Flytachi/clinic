<?php
require_once '../../tools/warframe.php';
$session->is_auth(3);
$header = "Класификация персонала";

$tb = (new DivisionModel);
$search = $tb->getSearch();
$where_search = array("branch_id = $session->branch", "branch_id = $session->branch AND (LOWER(title) LIKE LOWER('%$search%') OR LOWER(name) LIKE LOWER('%$search%'))");
$tb->Where($where_search)->Order("level, title ASC")->Limit(20);
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
                      	<h5 class="card-title">Добавить Отдел</h5>
                      	<div class="header-elements">
                          	<div class="list-icons">
                              	<a class="list-icons-item" data-action="collapse"></a>
                          	</div>
                      	</div>
                  	</div>
                  	<div class="card-body" id="form_card">
                      	<?php $tb->form(); ?>
                  	</div>

            	</div>

                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h5 class="card-title">Список Отделов</h5>
						<div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите отдел или название специолиста">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
				        </div>
                    </div>

                    <div class="card-body" id="search_display">

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="<?= $classes['table-thead'] ?>">
                                        <th style="width:7%">№</th>
                                        <th>Метка</th>
                                        <th>Роль</th>
                                        <th>Отдел</th>
                                        <th>Название специолиста</th>
                                        <th style="width: 100px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($tb->list(1) as $row): ?>
                                        <tr>
                                            <td><?= $row->count ?></td>
                                            <td><?= $row->mark ?></td>
                                            <td><?= $PERSONAL[$row->level] ?></td>
                                            <td><?= $row->title ?></td>
                                            <td><?= $row->name ?> <?= ($row->assist == 1) ? "\"Ассистент\"" : "" ?></td>
                                            <td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row->id, 'DivisionModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row->id, 'DivisionModel') ?>" onclick="return confirm('Вы уверены что хотите удалить отдел?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
				                                </div>
                                            </td>
                                        </tr>
									<?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

						<?php $tb->panel(); ?>

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
		$("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('admin/search_division') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

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
