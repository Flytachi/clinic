<?php
require_once '../../tools/warframe.php';
$session->is_auth('master');
$header = "Главная";

$tb = new Table($db, "users");
$search = $tb->get_serch();
$where_search = array("user_level != 15", "user_level != 15 AND (username LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%'))");

$tb->where_or_serch($where_search)->order_by("user_level, last_name ASC")->set_limit(15);
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

				<div class="card border-1">

					<div class="card-header header-elements-inline">
						<h5 class="card-title">Список Пользователей</h5>
						<div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="form-control border-dark wmin-200" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите логин или имя">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body" id="search_display">

						<div class="table-responsive">
				            <table class="table table-hover">
				                <thead class="bg-dark">
				                    <tr>
				                        <th>#</th>
                                        <th>Роль</th>
                                        <th>Логин</th>
				                        <th>ФИО</th>
				                        <th class="text-right" style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
									<?php foreach ($tb->get_table(1) as $row): ?>
										<tr 
										<?php if ($row->user_level == 1): ?>
                                            class="table-dark text-danger"
                                        <?php elseif ($row->user_level == 8): ?>
                                            class="table-dark text-dark"
                                        <?php endif; ?>
										>
											<td><?= $row->count ?></td>
											<td>
                                                <?php if ($row->user_level == 5): ?>
                                                    <span class="text-success"><?= $PERSONAL[$row->user_level] ?></span>
                                                <?php elseif ($row->user_level == 6): ?>
                                                    <span class="text-primary"><?= $PERSONAL[$row->user_level] ?></span>
                                                <?php elseif (in_array($row->user_level, [2, 3, 32])): ?>
                                                    <span class="text-teal"><?= $PERSONAL[$row->user_level] ?></span>
                                                <?php elseif ($row->user_level == 10): ?>
                                                    <span class="text-indigo"><?= $PERSONAL[$row->user_level] ?></span>
                                                <?php elseif (in_array($row->user_level, [7, 9])): ?>
                                                    <span class="text-orange"><?= $PERSONAL[$row->user_level] ?></span>
                                                <?php elseif (in_array($row->user_level, [12, 13, 14])): ?>
                                                    <span class="text-brown"><?= $PERSONAL[$row->user_level] ?></span>
                                                <?php else: ?>
                                                    <span><?= $PERSONAL[$row->user_level] ?></span>
                                                <?php endif; ?>
                                                <?php
				                                if(division_name($row->id)){
				                                    echo " (".division_name($row->id).")";
				                                }
				                                ?>
				                            </td>
                                            <td><?= $row->username ?></td>
				                            <td><?= get_full_name($row->id); ?></td>
				                            <td class="text-right">
				                                <div class="list-icons">
													<a href="<?= ajax("master/avatar") ?>?pk=<?= $row->id ?>" class="list-icons-up text-success"><i class="icon-arrow-up16"></i></a>
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

	<script type="text/javascript">

		$("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('master/search_index') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

	</script>

</body>
</html>
