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
		$data = $db->query("SELECT id, is_grant FROM warehouse_setting_permissions WHERE warehouse_id = $warehouse->id AND user_id = $session->session_id AND is_application IS NOT NULL")->fetch();
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
						<h5 class="card-title">Добавить Заявку</h5>
					</div>

					<div class="card-body" id="form_card">

                        <?php
                        if ($data['is_grant']) (new WarehouseStorage)->warehousesPanel(null, $warehouse->id, 2);
						else (new WarehouseStorage)->warehousesPanel(null, $warehouse->id);
						?>

					</div>

				</div>

                <div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h5 class="card-title"><?= ($data['is_grant']) ? "Все Заявки" : "Мои Заявки"; ?></h5>
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

    <script type="text/javascript">

		function credoSearch(params = '') {
            if (document.querySelector('#search_display')) {
                var display = document.querySelector('#search_display');
                isLoading(display);

                $.ajax({
                    type: "GET",
                    url: "<?= api('table/warehouse/Application') ?>"+params,
					data: {
						warehouse: <?= $warehouse->id ?>, 
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

		function Delete(index, url){
			event.preventDefault();
			$.ajax({
				type: "GET",
				url: url,
				success: function (res) {
					if (res.status == "success") {
						
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

		function ConfirmApplication(index, url) {
			event.preventDefault();
			$.ajax({
				type: "GET",
				url: url,
				success: function (res) {
					if (res.status == "success") {
						
						new Noty({
							text: "Успешно подтверждено!",
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

		$("#search_input").keyup(() => credoSearch());
        $(document).ready(() => credoSearch());

    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
