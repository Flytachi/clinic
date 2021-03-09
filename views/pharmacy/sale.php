<?php
require_once '../../tools/warframe.php';
is_auth(4);
$header = "Продажа";
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

                <?php
                if($_SESSION['message']){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Продажа</h6>
					</div>

					<div class="card-body">

                        <form action="" method="post" onsubmit="Search_storage(this)">
                            <fieldset class="mb-3">
                                <div class="form-group row">
    								<div class="col-md-12">
    									<div class="input-group">
    										<input type="text" name="search" class="form-control" placeholder="Введите штрих код или название" autofocus>
    										<span class="input-group-append">
    											<button class="btn btn-light legitRipple" type="submit"><i class="icon-search4"></i></button>
    										</span>
    									</div>
    								</div>
    							</div>
    						</fieldset>
                        </form>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="table-responsive card">
        							<table class="table table-hover table-sm">
                                        <thead>
                                            <tr class="bg-info">
                                                <th style="width:45%">Препарат</th>
                                                <th>Срок годности</th>
                                                <th class="text-right">Кол-во</th>
                                                <th class="text-right">Цена ед.</th>
                                                <!-- <th class="text-right" style="width:50px">Действия</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="search_display">

                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <?php StorageSale::form() ?>

                            </div>

                        </div>


					</div>

				</div>

			</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<div id="modal_amount" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Оплата</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<?php StorageSale::modal(); ?>

			</div>
		</div>
	</div>

	<script type="text/javascript">

		function Sum() {
			var total_cost = document.getElementById('total_cost');
			var sum = Number(total_cost.textContent.replace(/,/g,''));
			var inputs = document.getElementsByClassName('counts');
			var new_sum = 0;
			for (var input of inputs) {
				new_sum += Number(input.value * input.dataset.price);
			}
			total_cost.textContent = number_format(new_sum, 1);
		}

        function Search_storage(events) {
            event.preventDefault();
			$.ajax({
				type: "GET",
				url: "<?= ajax('pharmacy_search_item') ?>",
				data: {
					search: events.search.value,
				},
				success: function (result) {
					$('#search_display').html(result);
				},
			});
        }

        function Check(item){
			$.ajax({
				type: "GET",
				url: "<?= ajax('pharmacy_select_item') ?>",
				data: {
					item: item,
				},
				success: function (result) {
					$('#sale_items').append(result);
				},
			});
        }
    </script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
