<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Рабочий стол";

$tb = new Table($db, "warehouse_applications wa");
$search = $tb->get_serch();
$tb->set_data('wa.id, win.name, wa.item_manufacturer_id, wa.item_supplier_id, wa.add_date, wa.item_qty')->additions("LEFT JOIN warehouse_item_names win ON(win.id=wa.item_name_id)");
$where_search = array(
    "wa.warehouse_id = {$_GET['pk']} AND wa.tran_status = 1 AND wa.parent_id = $session->session_id", 
    "wa.warehouse_id = {$_GET['pk']} AND wa.tran_status = 1 AND wa.parent_id = $session->session_id AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
);

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

                        <?php (new WarehouseApplicationsModel)->store() ?>

					</div>

				</div>

                <div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h5 class="card-title">Мои Заявки</h5>
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
				                        <th>Наименование</th>
                                        <th style="width:300px">Производитель</th>
                                        <th style="width:300px">Поставщик</th>
                                        <th style="width:200px">Дата заяки</th>
                                        <th class="text-right" style="width:100px">Кол-во</th>
				                        <th class="text-right" style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
									<?php foreach ($tb->get_table(1) as $row): ?>
										<tr>
				                            <td><?= $row->count ?></td>
				                            <td><?= $row->name ?></td>
				                            <td>
                                                <?php if($row->item_manufacturer_id): ?>
                                                    <span><?= $db->query("SELECT manufacturer FROM warehouse_item_manufacturers WHERE id = $row->item_manufacturer_id")->fetchColumn() ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">Нет данных</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($row->item_supplier_id): ?>
                                                    <span><?= $db->query("SELECT supplier FROM warehouse_item_suppliers WHERE id = $row->item_supplier_id")->fetchColumn() ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">Нет данных</span>
                                                <?php endif; ?>
                                            </td>
				                            <td><?= date_f($row->add_date, 1) ?></td>
				                            <td class="text-right"><?= $row->item_qty ?></td>
				                            <td class="text-right"s>
				                                <div class="list-icons">
                                                    <a href="<?= del_url($row->id, 'WarehouseApplicationsModel') ?>" onclick="return confirm('Вы уверены что хотите удалить заявку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
                    pk: "<?= $_GET['pk'] ?>",
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
