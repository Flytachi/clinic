<?php

use Mixin\Hell;

require_once '../../tools/warframe.php';
$session->is_auth(1);
is_module('pharmacy');
$header = "Склады";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("assets/js/custom.js") ?>"></script>

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
	                  	<h5 class="card-title">Склады</h5>
						<div class="header-elements">
							<div class="list-icons">
								<a onclick="ModalCheck('<?= Hell::apiGet('Warehouse', null, 'form') ?>')" href="#" class="list-icons-item text-success"><i class="icon-add"></i></a>
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
			<div class="<?= $classes['modal-global_content'] ?>" id="modal_default_card"></div>
		</div>
	</div>

	<script type="text/javascript">

		function Change(id, stat = null) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: "<?= ajax('admin_status') ?>",
				data: { table:"warehouses", id:id, is_active: stat },
				success: function (data) {
                    if (data) {
						var badge = document.getElementById(`status_change_${id}`);
						if (data == 1) {
							badge.className = "badge bg-success dropdown-toggle";
							badge.innerHTML = "Active";
							badge.onclick = `Change(${id}, 1)`;
						}else if (data == 0) {
							badge.className = "badge bg-secondary dropdown-toggle";
							badge.innerHTML = "Pasive";
							badge.onclick = `Change(${id}, 0)`;
						}
                    }
				},
			});
        }

		function ModalCheck(events) {
			event.preventDefault();
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_default').modal('show');
					$('#modal_default_card').html(result);
				},
			});
		};

		function Delete(events, item) {
			event.preventDefault();
			if (confirm(`Вы уверены что хотите удалить \"${item}\"?`)) {
				$.ajax({
					type: "GET",
					url: events,
					success: function (res) {
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
		};

		function submitForm(up = 1) {
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
						if (up) credoSearch();
					} else {
						new Noty({
							text: res.message,
							type: "error",
						}).show();
					}
				},
			});
		}

		function credoSearch(params = '') {
            if (document.querySelector('#search_display')) {
                var display = document.querySelector('#search_display');
                isLoading(display);

                $.ajax({
                    type: "GET",
                    url: "<?= api('table/admin/Warehouse') ?>"+params,
                    success: function (result) {
                        isLoaded(display);
                        display.innerHTML = result;
                    },
                });

            }
        }

        $(document).ready(() => credoSearch());

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
