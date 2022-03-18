<?php

use Mixin\Hell;

require_once '../../tools/warframe.php';
$session->is_auth();
is_module('pharmacy');
$header = "Рабочий стол";

if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {

	importModel('Warehouse', 'WarehouseStorage', 'WarehouseStorageApplication');

	$warehouse = (new Warehouse)->byId($_GET['pk']);
	if ($warehouse) {
		$data = $db->query("SELECT id, is_grant FROM warehouse_setting_permissions WHERE warehouse_id = $warehouse->id AND responsible_id = $session->session_id")->fetch();
		if(!$data) Hell::error('404');
	} else Hell::error('404');
    
} else Hell::error('404');
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
						<h5 class="card-title">Склад "<?= $warehouse->name ?>"</h5>
                        <div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" id="search_input" placeholder="Поиск..." title="Введите наименование препарата">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
				        </div>
					</div>

					<div class="card-body" id="search_display"></div>

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

		function submitForm() {
			event.preventDefault();
			$.ajax({
				type: $(event.target).attr("method"),
				url: $(event.target).attr("action"),
				data: $(event.target).serializeArray(),
				success: function (res) {
					$('#modal_default').modal('hide');
					if (res.status == "success") {
						new Noty({
							text: "Успешно!",
							type: "success",
						}).show();
						credoSearch();
					} else {
						new Noty({
							text: res.message,
							type: "error",
						}).show();
					}
				},
			});
		}

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

        function credoSearch(params = '') {
            if (document.querySelector('#search_display')) {
                var display = document.querySelector('#search_display');
                isLoading(display);

                $.ajax({
                    type: "GET",
                    url: "<?= api('table/warehouse/Storage') ?>"+params,
					data: {
						warehouse: <?= $warehouse->id ?>,
						is_payment: <?= ($warehouse->is_payment) ? 1 : 0 ?>,
						is_grant: <?= ($data['is_grant']) ? 1 : 0 ?>,
						CRD_search: document.querySelector('#search_input').value,
					},
                    success: function (result) {
                        isLoaded(display);
                        display.innerHTML = result;
                    },
                });

            }
        }

        $(document).ready(() => credoSearch());
		$("#search_input").keyup(() => credoSearch());

    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
