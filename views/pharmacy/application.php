<?php
require_once '../../tools/warframe.php';
is_auth(4);
$header = "Заявки";
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
                                            <th style="width: 50%">Препарат</th>
                                            <th class="text-center">На складе</th>
                                            <th class="text-center">Ко-во (требуется)</th>
                                            <th class="text-center" style="width: 100px">Ко-во</th>
                                            <th class="text-right">Цена ед.</th>
                                            <th class="text-right">Сумма</th>
                                            <th class="text-right">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total_cost=0;$i=1; foreach ($db->query("SELECT sr.id, st.name, sr.qty, st.price, sr.qty*st.price 'total_price', st.qty 'qty_have' FROM storage_orders sr LEFT JOIN storage st ON(st.id=sr.preparat_id) ORDER BY sr.preparat_id") as $row): ?>
                                            <tr id="TR_<?= $row['id'] ?>">
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
                                                    <input type="number" class="form-control" name="orders[<?= $row['id'] ?>]" value="<?= ($row['qty_have'] < $row['qty']) ? $row['qty_have'] : $row['qty'] ?>" style="border-width: 0px 0; padding: 0.2rem 0;">
                                                </td>
                                                <td class="text-right"><?= number_format($row['price']) ?></td>
                                                <td class="text-right">
                                                    <?php
                                                    $total_cost += $row['total_price'];
                                                    echo number_format($row['total_price']);
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    <div class="list-icons">
                                                        <a onclick="Delete('<?= del_url($row['id'], 'StorageOrdersModel') ?>', '#TR_<?= $row['id'] ?>')" href="#" class="list-icons-item text-danger-600"><i class="icon-x"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr class="table-secondary">
                                            <td colspan="5" class="text-right"><b>Итого:</b></td>
                                            <td class="text-right"><b><?= number_format($total_cost) ?></b></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-sm btn-outline-success" <?= ($total_cost) ? "" : "disabled" ?>>Отправить</button>
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
