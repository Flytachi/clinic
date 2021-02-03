<?php
require_once '../../tools/warframe.php';
is_auth(3);
$header = "История платежей";
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

				<div class="card">
					 <div class="card-header header-elements-inline">
                        <h5 class="card-title">История платежей</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>
					<div class="card-body">
						<div class="table-responsive">
                            <table class="table table-hover datatable-basic">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
										<th class="text-center" colspan="5">ФИО</th>


                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									foreach($db->query("SELECT DISTINCT vs.user_id FROM visit_price vsp LEFT JOIN visit vs ON(vs.id=vsp.visit_id)") as $row) {
                                        ?>
                                        <tr>
                                            <td><?= addZero($row['user_id']) ?></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center"><div class="font-weight-semibold"><?= get_full_name($row['user_id']) ?></div></td>
                                            <td></td>
                                            <td></td>

                                            <td class="text-center">
												<a href="<?= viv('cashbox/detail_payment') ?>?pk=<?= $row['user_id'] ?>" class="btn btn-outline-info btn-sm legitRipple">Детально</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
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

    <script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

	<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>
</body>
</html>
