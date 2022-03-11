<?php

use Mixin\Hell;

require_once '../../tools/warframe.php';
$session->is_auth();
is_module('pharmacy');
$header = "Рабочий стол";

if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {

    $warehouse = $db->query("SELECT * FROM warehouses WHERE id = {$_GET['pk']} AND is_active IS NOT NULL")->fetch();
	$is_payment = $warehouse['is_payment'];
	if ($warehouse) {
		$data = $db->query("SELECT id, is_grant FROM warehouse_setting_permissions WHERE warehouse_id = {$warehouse['id']} AND responsible_id = $session->session_id")->fetch();
		$is_grant = $data['is_grant'];
		if(!$data) Mixin\error('404');
	} else Mixin\error('404');
    
} else Mixin\error('404');

$tb = new Table($db, "warehouse_storage wc");
$search = $tb->get_serch();
$tb->set_data("wc.id, wc.warehouse_id, wc.item_name_id, wc.item_manufacturer_id, wc.item_price, win.name, wim.manufacturer, wc.item_qty, wc.item_die_date")->additions("LEFT JOIN warehouse_item_names win ON(win.id=wc.item_name_id) LEFT JOIN warehouse_item_manufacturers wim ON(wim.id=wc.item_manufacturer_id)");
$where_search = array(
    "wc.warehouse_id = {$_GET['pk']}", 
    "wc.warehouse_id = {$_GET['pk']} AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
);
$tb->where_or_serch($where_search)->order_by("win.name ASC, wim.manufacturer ASC")->set_limit(20);
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
						<h5 class="card-title">Склад "<?= $warehouse['name'] ?>"</h5>
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

						<?php
						if( isset($_SESSION['message']) ){
							echo $_SESSION['message'];
							unset($_SESSION['message']);
						}
						?>

                        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="<?= $classes['table-thead'] ?>">
				                        <th>Наименование</th>
                                        <th style="width:250px">Производитель</th>
										<?php if($is_payment): ?>
                                        	<th class="text-right" style="width:200px">Стоимость</th>
                                        <?php endif; ?>
										<th class="text-center" style="width:2s00px">Кол-во доступно/бронь</th>
                                        <th class="text-center">Срок годности</th>
										<th class="text-right" style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
									<?php foreach ($tb->get_table() as $row): ?>
                                        <tr>
                                            <td><?= $row->name ?></td>
                                            <td><?= $row->manufacturer ?></td>
											<?php if($is_payment): ?>
												<td class="text-right"><?= number_format($row->item_price) ?></td>
											<?php endif; ?>
                                            <td class="text-center">
												<?php
												$price = ($is_payment) ? "AND item_price = $row->item_price" : null;
												$row->reservation = $db->query("SELECT SUM(item_qty) FROM warehouse_storage_applications WHERE status IN(1,2) AND warehouse_id_from = $row->warehouse_id AND item_name_id = $row->item_name_id AND item_manufacturer_id = $row->item_manufacturer_id $price")->fetchColumn();
												$row->reservation += $db->query("SELECT SUM(item_qty) FROM visit_bypass_event_applications WHERE warehouse_id = $row->warehouse_id AND item_name_id = $row->item_name_id AND item_manufacturer_id = $row->item_manufacturer_id $price")->fetchColumn();
												?>
                                                <?= number_format($row->item_qty - $row->reservation) ?> /
                                                <span class="<?= ($row->reservation) ? "text-danger" : "text-muted" ?>"> <?= number_format($row->reservation) ?></span>
                                            </td>
                                            <td class="text-center"><?= $row->item_die_date ?></td>
											<td class="text-right"s>
												<div class="list-icons">
													<a href="#" onclick="Check('<?= Hell::apiAxe('WarehouseStorage', array('form' => 'listAplications', 'id' => $row->id)) ?>')" class="list-icons-item text-primary-600"><i class="icon-list"></i></a>
													<a href="#" onclick="Check('<?= Hell::apiAxe('WarehouseStorage', array('form' => 'refundItem', 'id' => $row->id)) ?>')" class="list-icons-item text-warning-600"><i class="icon-redo"></i></a>
													<?php if($is_grant): ?>
														<a href="#" onclick="Check('<?= up_url($row->id, 'WarehouseStorageTransactionModel') ?>')" class="list-icons-item text-danger-600"><i class="icon-clipboard6"></i></a>
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

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>

    <script type="text/javascript">

		function Check(events) {
			event.preventDefault();
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_default').modal('show');
					$('#form_card').html(result);
				},
			});
		};

		$("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('warehouse/search-index') ?>",
				data: {
                    pk: <?= $_GET['pk'] ?>,
					is_payment: <?= ($is_payment) ? 1 : 0 ?>,
					is_grant: <?= ($is_grant) ? 1 : 0 ?>,
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
