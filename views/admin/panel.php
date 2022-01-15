<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Койки";
is_module('queue');
$tb = new Table($db, "panels");
$search = $tb->get_serch();
$where_search = array(null, "LOWER(ip) LIKE LOWER('%$search%')");

$tb->where_or_serch($where_search)->order_by("ip ASC")->set_limit(15);
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
                        <h5 class="card-title">Добавить Койку</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" id="form_card">
		    			<?php (new PanelModel)->form(); ?>
		          	</div>

                </div>

                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h5 class="card-title">Список Коек</h5>
                        <div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите название объекта или палату">
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
                                        <th>Адрес</th>
                                        <th>Кабинеты</th>
                                        <th style="width: 100px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tb->get_table() as $row): ?>
										<tr>
				                            <td><?= $row->ip ?></td>
				                            <td>
												<?php 
												$str = "";
												if ($row->rooms) {
													foreach(json_decode($row->rooms) as $room) $str .= $db->query("SELECT title FROM rooms WHERE id = $room")->fetchColumn().", ";
													$str = substr($str, 0, -2);
												} else $str = '<span class="text-muted">Нет даных</span>';
												echo $str;
												?>
											</td>
				                            <td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row->id, 'PanelModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row->id, 'PanelModel') ?>" onclick="return confirm('Вы уверены что хотите удалить койку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
				                                </div>
	                                      	</td>
				                        </tr>
									<?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php $tb->get_panel(); ?>

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

        $("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			/*
			$.ajax({
				type: "GET",
				url: "<?= ajax('admin/search_room') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
			*/
		});
	</script>

</body>
</html>
