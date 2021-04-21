<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
$header = "Заявки";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("vendors/js/custom.js") ?>"></script>

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

                <form method="post" action="<?= add_url() ?>">
                    <input type="hidden" name="model" value="StorageHomeModel">

                    <div class="card border-1 border-info">

                        <div class="card-header text-dark header-elements-inline alpha-info">
                            <h5 class="card-title">Список Заявок</h5>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <select data-placeholder="Выберите специалиста" name="parent_id" onchange="CallMed(this.value)" class="form-control form-control-select2" required>
                                        <option></option>
                                        <?php
                                        foreach($db->query("SELECT * from users WHERE user_level = 7") as $row) {
                                            ?>
                                            <option value="<?= $row['id'] ?>" ><?= get_full_name($row['id']) ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive card">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr class="bg-blue">
											<th>Дата</th>
											<th>Информация</th>
                                            <th style="width: 20%">Препарат</th>
                                            <th class="text-center">На складе</th>
                                            <th class="text-center">Ко-во (требуется)</th>
                                            <th class="text-center" style="width: 100px">Ко-во</th>
                                            <th class="text-right">Цена ед.</th>
                                            <th class="text-right">Сумма</th>
                                            <th class="text-right">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach ($db->query("SELECT sr.id, sr.date, sr.parent_id, sr.user_id, st.name, sr.qty, st.price, sr.qty*st.price 'total_price', st.qty 'qty_have' FROM storage_orders sr LEFT JOIN storage st ON(st.id=sr.preparat_id) ORDER BY sr.preparat_id") as $row): ?>
                                            <tr id="TR_<?= $row['id'] ?>">
												<td><?= date('d.m.Y', strtotime($row['date'])) ?></td>
												<td>
													(<?= ($row['user_id']) ? "Пациент" : "Заказ" ?>)
													<?= get_full_name($row['parent_id']) ?>
												</td>
                                                <td><?= $row['name'] ?></td>
                                                <td class="text-center">
                                                    <?php if ($row['qty_have'] > $row['qty']): ?>
                                                        <span class="text-success"><?= $row['qty_have'] ?></span>
                                                    <?php else: ?>
                                                        <span class="text-danger"><?= $row['qty_have'] ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><?= $row['qty'] ?></td>
                                                <td class="text-center table-primary">
                                                    <input type="number" id="input_count-<?= $row['id'] ?>"
															data-price="<?= $row['price'] ?>" class="form-control counts"
															min="1" max="<?= $row['qty_have'] ?>"
															name="orders[<?= $row['id'] ?>]" value="<?= ($row['qty_have'] < $row['qty']) ? $row['qty_have'] : $row['qty'] ?>"
															style="border-width: 0px 0; padding: 0.2rem 0;" disabled>
                                                </td>
                                                <td class="text-right"><?= number_format($row['price']) ?></td>
                                                <td class="text-right"><?= $row['total_price']; ?></td>
                                                <td class="text-right">
                                                    <div class="list-icons">
                                                        <a onclick="Delete('<?= del_url($row['id'], 'StorageOrdersModel') ?>', '#TR_<?= $row['id'] ?>')" href="#" class="list-icons-item text-danger-600"><i class="icon-x"></i></a>
														<input type="checkbox" class="swit" value="input_count-<?= $row['id'] ?>" onchange="On_check(this)">
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr class="table-secondary">
                                            <th colspan="7" class="text-right">Итого:</th>
                                            <th class="text-right" id="total_cost">0</th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-right">
                                <button type="submit" id="btn_send" class="btn btn-sm btn-outline-success" disabled>Отправить</button>
                            </div>

                        </div>

                    </div>

                </form>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <script type="text/javascript">
		function SendVerification(){
			var btn = document.getElementById('btn_send');
			var total_cost = document.getElementById('total_cost');
			var sum = Number(total_cost.textContent.replace(/,/g,''));
			if (sum > 0) {
				btn.disabled = false;
			}else {
				btn.disabled = true;
			}
		}

		$(".counts").keyup(function() {
			var total_cost = document.getElementById('total_cost');
			var sum = Number(total_cost.textContent.replace(/,/g,''));
			var inputs = document.getElementsByClassName('counts');
			var new_sum = 0;

			for (var input of inputs) {
				if (!input.disabled) {
					new_sum += Number(input.value * input.dataset.price);
				}
			}
			total_cost.textContent = number_format(new_sum, 1);
			SendVerification();
	    });

		function On_check(check) {
			var input = $('#'+check.value);
			if(!input.prop('disabled')){
				input.attr("disabled", "disabled");
				Downsum(input);
			}else {
				input.removeAttr("disabled");
				Upsum(input);
			}
			SendVerification();
		}

		function Downsum(input) {
			var input_total = $('#total_cost');
			var total = Number(input_total.text().replace(/,/g,''));
			var new_total = number_format(total - Number(input.val() * input.data().price), 1);
			input_total.text(new_total);
		}

		function Upsum(input) {
			var input_total = $('#total_cost');
			var total = Number(input_total.text().replace(/,/g,''));
			var new_total = number_format(total + Number(input.val() * input.data().price), 1);
			input_total.text(new_total);
		}

	    function tot_sum(the, price) {
	        var total = $('#total_price');
	        var cost = total.text().replace(/,/g,'');
	        if (the.checked) {
	            service[the.value] = $("#count_input_"+the.value).val();
	            total.text( number_format(Number(cost) + (Number(price) * service[the.value]), '.', ',') );
	        }else {
	            total.text( number_format(Number(cost) - (Number(price) * service[the.value]), '.', ',') );
	            delete service[the.value];
	        }
	        // console.log(service);
	    }

        function Delete(url, tr) {
            event.preventDefault();
            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    $(tr).css("background-color", "rgb(244, 67, 54)");
                    $(tr).css("color", "white");
                    $(tr).fadeOut(900, function() {
                        $(tr).remove();
                    });
                },
            });
        };

		function CallMed(id){
			if (id) {
				let obj = JSON.stringify({ type : 'alert_pharmacy_call',  id : id, message: "Забрать препараты!" });
				conn.send(obj);
			}
		}

    </script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
