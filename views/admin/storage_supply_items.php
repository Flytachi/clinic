<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
is_module('module_pharmacy');

if (is_numeric($_GET['pk'])) {
	$supply = $db->query("SELECT * FROM storage_supply WHERE id = {$_GET['pk']}")->fetch(PDO::FETCH_OBJ);
	if ($supply->parent_id != $session->session_id) {
		Mixin\error('404');
	}
}else{
	Mixin\error('404');
}

$header = "Аптека / Поставка $supply->uniq_key";
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
	                  	<h5 class="card-title">Поставка: <?= date_f($supply->add_date, 1) ?></h5>
						<span class="text-right"><b><?= get_full_name($supply->parent_id) ?></b></span>
	              	</div>

              		<div class="card-body">
                  		<div class="table-responsive card">
						  <table class="table table-hover">
	                          	<thead>
	                              	<tr class="<?= $classes['table-thead'] ?>">
									  	<th>Ключ</th>
									  	<th>Препарат</th>
                                        <th>Поставщик</th>
                                        <th>Кол-во</th>
                                        <th>Цена прихода</th>
                                        <th>Цена расхода</th>
                                        <th>Счёт фактура</th>
                                        <th>Штрих код</th>
                                        <th>Срок годности</th>
										<th class="text-right" style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
									<?php
									$tb = new Table($db, "storage_supply_items");
									$tb->where("uniq_key = '$supply->uniq_key'");
									?>
                                    <?php foreach ($tb->get_table(1) as $row): ?>
										<tr>
											<td><?= $row->item_key ?></td>
											<td><?= $row->item_name ?></td>
											<td><?= $row->item_supplier ?></td>
											<td><?= $row->item_qty ?></td>
											<td><?= $row->item_cost ?></td>
											<td><?= $row->item_price ?></td>
											<td><?= $row->item_faktura ?></td>
											<td><?= $row->item_shtrih ?></td>
											<td><?= $row->item_die_date ?></td>
											<td class="text-right">
												<div class="list-icons">
													<a href="" onclick="return confirm('Вы уверены что хотите удалить препарат?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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

</body>
</html>
