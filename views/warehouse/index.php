<?php
require_once '../../tools/warframe.php';
$session->is_auth();
is_module('pharmacy');
$header = "Рабочий стол";

if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {

    $warehouse = $db->query("SELECT * FROM warehouses WHERE id = {$_GET['pk']} AND is_active IS NOT NULL")->fetch();
	if ($warehouse) {
		$level = ($warehouse['level']) ? json_decode($warehouse['level']) : null;
		$division = ($warehouse['division']) ? json_decode($warehouse['division']) : null;
		$is_parent = ($warehouse['parent_id'] == $session->session_id) ? true : false;

		if ($level) {
			if (permission($level)) {
				if ($division and !( !$session->get_division() or in_array($session->get_division(), $division) )) Mixin\error('423');
			}else {
				Mixin\error('423');
			}
		}

	} else {
		Mixin\error('404');
	}
    
} else {
    Mixin\error('404');
}

$tb = new Table($db, "warehouse_custom wc");
$search = $tb->get_serch();
$tb->set_data("win.name, wim.manufacturer, wc.item_qty, wc.item_price, wc.item_die_date,
    (SELECT SUM(vbea.item_qty) FROM visit_bypass_event_applications vbea WHERE vbea.warehouse_id = wc.warehouse_id AND wc.item_name_id = vbea.item_name_id AND wc.item_manufacturer_id = vbea.item_manufacturer_id AND wc.item_price = vbea.item_price ) 'reservation'")->additions("LEFT JOIN warehouse_item_names win ON(win.id=wc.item_name_id) LEFT JOIN warehouse_item_manufacturers wim ON(wim.id=wc.item_manufacturer_id)");
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

                        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="<?= $classes['table-thead'] ?>">
				                        <th>Наименование</th>
                                        <th style="width:250px">Производитель</th>
                                        <th class="text-right" style="width:200px">Стоимость</th>
                                        <th class="text-center" style="width:2s00px">Кол-во/бронь</th>
                                        <th class="text-center">Срок годности</th>
				                        <!-- <th class="text-right" style="width: 100px">Действия</th> -->
				                    </tr>
				                </thead>
				                <tbody>
									<?php foreach ($tb->get_table() as $row): ?>
                                        <tr>
                                            <td><?= $row->name ?></td>
                                            <td><?= $row->manufacturer ?></td>
                                            <td class="text-right"><?= number_format($row->item_price) ?></td>
                                            <td class="text-center">
                                                <?= number_format($row->item_qty) ?>
                                                <span class="<?= ($row->reservation) ? "text-danger" : "text-muted" ?>">/ <?= number_format($row->reservation) ?></span>
                                            </td>
                                            <td class="text-center"><?= $row->item_die_date ?></td>
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
				url: "<?= ajax('warehouse/search-index') ?>",
				data: {
                    pk: "<?= $_GET['pk'] ?>",
					is_parent: "<?= $is_parent ?>",
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
