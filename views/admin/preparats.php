<?php
require_once '../../tools/warframe.php';
is_auth(1);
$header = "Препараты к услугам";
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
		              	<h5 class="card-title">Добавить Препарат к услуге</h5>
		          	</div>

                    <div class="card-body" id="form_card">
                      	<?php ServicePreparatModel::form(); ?>
                  	</div>

	        	</div>

                <div class="card">

                    <div class="card-body">

                        <form method="post" action="#">

                            <div class="form-group">
                                <label>Услуга:</label>
                                <select data-placeholder="Выбрать услугу" name="service" class="form-control form-control-select2" required>
                                    <option></option>
                                    <?php foreach ($db->query("SELECT DISTINCT sc.id, sc.name FROM service sc LEFT JOIN service_preparat scp ON(scp.service_id=sc.id) WHERE scp.id IS NOT NULL") as $row): ?>
                                        <option value="<?= $row['id'] ?>" <?php if($row['id'] == $_POST['service']){echo'selected';} ?>><?= $row['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-outline-info">Поиск</button>
                            </div>

                        </form>

                  	</div>

	        	</div>

                <?php if ($_POST): ?>
                    <div class="card">

    	          		<div class="card-header header-elements-inline">
    	                  	<h5 class="card-title">Список Препаратов к услугам</h5>
    	              	</div>

                  		<div class="card-body">
                      		<div class="table-responsive">
    	                      	<table class="table table-hover datatable-basic">
    	                          	<thead>
    	                              	<tr class="bg-blue">
    										<th style="width:70%">Препарат</th>
    										<th>Кол-во</th>
    										<th class="text-right">Сумма</th>
    										<th style="width: 100px">Действия</th>
    	                              	</tr>
    	                          	</thead>
    	                          	<tbody>
                                        <?php $total_price=0; foreach ($db->query("SELECT scp.id, scp.qty, st.price, st.name, st.supplier, st.die_date from service_preparat scp LEFT JOIN storage st ON(st.id=scp.preparat_id) WHERE scp.service_id = {$_POST['service']}") as $row): ?>
                                            <tr>
    											<td><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>)</td>
    											<td><?= $row['qty'] ?></td>
    											<td class="text-right">
                                                    <?php
                                                    $total_price += $row['qty'] * $row['price'];
                                                    echo number_format($row['qty'] * $row['price'], 1);
                                                    ?>
                                                </td>
    	                                      	<td>
    												<div class="list-icons">
    													<a onclick="Update('<?= up_url($row['id'], 'ServicePreparatModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
    													<a href="<?= del_url($row['id'], 'ServicePreparatModel') ?>" onclick="return confirm('Вы уверены что хотите удалить услугу?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
    				                                </div>
    	                                      	</td>
                                  			</tr>
                                        <?php endforeach; ?>
                                        <tr class="table-secondary text-right">
                                            <th colspan="2">Итого:</th>
                                            <th><?= number_format($total_price, 1) ?></th>
                                            <th></th>
                                        </tr>
    	                          	</tbody>
    	                      	</table>
    	                  	</div>
    	              	</div>

              		</div>
                <?php endif; ?>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

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

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
