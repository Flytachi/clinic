<?php
require_once '../../tools/warframe.php';
$session->is_auth();
is_module('pharmacy');
$header = "Рабочий стол";


if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {

    $warehouse = $db->query("SELECT * FROM warehouses WHERE id = {$_GET['pk']} AND is_active IS NOT NULL")->fetch();
	if ($warehouse) {
		$is_level = level() == $db->query("SELECT level FROM warehouse_setting_permissions WHERE warehouse_id = {$warehouse['id']}")->fetchColumn();
		$is_division = $db->query("SELECT * FROM warehouse_setting_permissions WHERE warehouse_id = {$warehouse['id']} AND level = $session->session_level AND division_id = $session->session_division")->rowCount();
		$is_grant = $db->query("SELECT is_grant FROM warehouse_setting_permissions WHERE warehouse_id = {$warehouse['id']} AND level = $session->session_level AND division_id = $session->session_division AND responsible_id = $session->session_id")->rowCount();
		
		if (!$is_level and !$is_division) Mixin\error('404');
	} else Mixin\error('404');
    
} else Mixin\error('404');

$tb = new Table($db, "warehouse_storage_applications wa");
$search = $tb->get_serch();
$tb->set_data('wa.id, wa.responsible_id, win.name, wa.item_manufacturer_id, wa.item_qty, wa.status, wa.add_date')->additions("LEFT JOIN warehouse_item_names win ON(win.id=wa.item_name_id)");
if ($is_grant) {
	$where_search = array(
		"wa.warehouse_id_in = {$_GET['pk']} AND wa.status != 3", 
		"wa.warehouse_id_in = {$_GET['pk']} AND wa.status != 3 AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
	);
} else {
	$where_search = array(
		"wa.warehouse_id_in = {$_GET['pk']} AND wa.status != 3 AND wa.responsible_id = $session->session_id", 
		"wa.warehouse_id_in = {$_GET['pk']} AND wa.status != 3 AND wa.responsible_id = $session->session_id AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
	);
}


$tb->where_or_serch($where_search)->order_by("win.name ASC")->set_limit(20);
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
						<h5 class="card-title">Добавить Заявку</h5>
					</div>

					<div class="card-body" id="form_card">

                        <?php
						if ($is_grant) (new WarehouseApplication)->panel(null, $warehouse['id'], 2);
						else (new WarehouseApplication)->panel(null, $warehouse['id']);;
						?>

					</div>

				</div>

                <div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h5 class="card-title"><?= ($is_grant) ? "Все Заявки" : "Мои Заявки"; ?></h5>
                        <div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите наименование препарата">
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
				                        <th style="width: 50px">#</th>
										<?php if($is_grant): ?>
                                            <th style="width:200px">Заявитель</th>
										<?php endif; ?>
				                        <th>Наименование</th>
                                        <th style="width:250px">Производитель</th>
                                        <th style="width:200px">Дата заяки</th>
                                        <th class="text-right" style="width:100px">Кол-во</th>
                                        <th class="text-center">Статус</th>
				                        <th class="text-right" style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
									<?php foreach ($tb->get_table(1) as $row): ?>
										<tr id="TR_item_<?= $row->count ?>">
				                            <td><?= $row->count ?></td>
											<?php if($is_grant): ?>
												<td><?= get_full_name($row->responsible_id) ?></td>
											<?php endif; ?>
				                            <td><?= $row->name ?></td>
				                            <td>
                                                <?php if($row->item_manufacturer_id): ?>
                                                    <span><?= $db->query("SELECT manufacturer FROM warehouse_item_manufacturers WHERE id = $row->item_manufacturer_id")->fetchColumn() ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">Нет данных</span>
                                                <?php endif; ?>
                                            </td>
				                            <td><?= date_f($row->add_date, 1) ?></td>
				                            <td class="text-right"><?= $row->item_qty ?></td>
				                            <td class="text-center">
												<?php if ($row->status == 1): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Подтверждение</span>
												<?php elseif ($row->status == 2): ?>
													<span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Перевод</span>
												<?php elseif ($row->status == 3): ?>
													<span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершён</span>
												<?php elseif ($row->status == 4): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Отказано</span>
												<?php else: ?>
													<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Неизвестный</span>
												<?php endif; ?>
											</td>
				                            <td class="text-right"s>
				                                <div class="list-icons">
													<?php if ( ($is_grant or $row->status == 1) and $row->status != 2 ): ?>
														<a href="#" onclick="Delete(<?= $row->count ?>, '<?= del_url($row->id, 'WarehouseApplication') ?>')" onclick="return confirm('Вы уверены что хотите удалить заявку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
													<?php endif; ?>
                                                    <?php if ($is_grant): ?>
														<?php if ( $row->status == 2 ): ?>
															<span class="list-icons-item text-success ml-1"><i class="icon-checkmark-circle"></i></span>
														<?php else: ?>
															<a href="#" onclick="ConfirmApplication(<?= $row->id ?>, <?= $row->count ?>)" class="list-icons-item ml-1"><i class="icon-radio-unchecked"></i></a>
														<?php endif; ?>
													<?php endif; ?>
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
				url: "<?= ajax('warehouse/search-application') ?>",
				data: {
                    pk: <?= $_GET['pk'] ?>,
					is_grant: <?= $is_grant ?>,
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

		function Delete(index, url){
			$.ajax({
				type: "POST",
				url: url,
				success: function (data) {
					data = JSON.parse(data);
					if (data.status == "success") {
						
						new Noty({
							text: "Успешно удаленно!",
							type: "success",
						}).show();

						$(`#TR_item_${index}`).css("background-color", "rgb(244, 67, 54)");
						$(`#TR_item_${index}`).css("color", "white");
						$(`#TR_item_${index}`).fadeOut(900, function() {
							$(this).remove();
						});

					} else {

						new Noty({
							text: data.message,
							type: "error",
						}).show();

					}
				},
			});
		}

		function ConfirmApplication(params, index) {
			$.ajax({
				type: "POST",
				url: "<?= add_url() ?>",
				data: { 
					model: "WarehouseApplication",
					id: params,
					status: 2,
				},
				success: function (data) {
					data = JSON.parse(data);
					if (data.status == "success") {
						
						new Noty({
							text: "Успешно подтверждено!",
							type: "success",
						}).show();

						$(`#TR_item_${index}`).css("background-color", "rgb(70, 200, 150)");
						$(`#TR_item_${index}`).css("color", "black");
						$(`#TR_item_${index}`).fadeOut(900, function() {
							$(this).remove();
						});
						$("#search_input").keyup();

					} else {

						new Noty({
							text: data.message,
							type: "error",
						}).show();

					}
				},
			});
		}

    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
