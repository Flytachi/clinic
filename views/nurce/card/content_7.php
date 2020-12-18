<?php
require_once '../../../tools/warframe.php';
is_auth(7);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "profile.php"; ?>

                <div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

					<div class="card-body">

					   <?php
					   include "content_tabs.php";
					   if($_SESSION['message']){
						   echo $_SESSION['message'];
						   unset($_SESSION['message']);
					   }
					   ?>

					   <div class="card">

						   <div class="card-header header-elements-inline">
							   <h6 class="card-title">Расходные материалы</h6>
                               <div class="header-elements">
                                   <div class="list-icons">
                                       <a class="list-icons-item text-success" data-toggle="modal" data-target="#modal_add">
                                           <i class="icon-plus22"></i>Добавить
                                       </a>
                                   </div>
                               </div>
						   </div>

						   <div class="table-responsive">
							   <table class="table table-hover table-sm table-bordered">
 								  <thead>
 									  <tr class="bg-info">
 										  <th style="width: 40px !important;">№</th>
 										  <th>Препарат</th>
                                          <th style="width: 200px;">Цена ед.</th>
                                          <th style="width: 200px;">Сумма</th>
                                          <th style="width: 100px;">Сегоня</th>
 										  <th style="width: 100px;">Всего</th>
 									  </tr>
 								  </thead>
 								  <tbody>
 									  <?php
 									  $i=1;
                                      $total_count_every = 0;
                                      $total_count_all = 0;
                                      $total_total_price = 0;
                                      $sql = "SELECT DISTINCT so.product,
                                                    so.product_code,
                                                    so.price,
                                                    (SELECT COUNT(*) FROM sales_order so2 WHERE so2.product=so.product AND DATE_FORMAT(so2.add_date, '%Y-%m-%d') = CURRENT_DATE()) 'count_every',
                                                    (SELECT COUNT(*) FROM sales_order so2 WHERE so2.product=so.product) 'count_all',
                                                    (SELECT COUNT(*) FROM sales_order so2 WHERE so2.product=so.product) * so.price 'total_price'
                                                FROM sales_order so WHERE so.user_id = $patient->id";
 									  foreach ($db->query($sql) as $row) {
 										  ?>
 										  <tr>
                                              <td><?= $i++ ?></td>
                                              <td><?= $row['product_code'] ?></td>
                                              <td><?= $row['price'] ?></td>
                                              <td>
                                                  <?php
                                                  $total_total_price += $row['total_price'];
                                                  echo number_format($row['total_price'])
                                                  ?>
                                              </td>
                                              <td>
                                                  <?php
                                                  $total_count_every += $row['count_every'];
                                                  echo number_format($row['count_every'])
                                                  ?>
                                              </td>
                                              <td>
                                                  <?php
                                                  $total_count_all += $row['count_all'];
                                                  echo number_format($row['count_all'])
                                                  ?>
                                              </td>
 										  </tr>
 										  <?php
 									  }
 									  ?>
                                      <tr class="table-primary">
                                          <td colspan="3">Итог:</td>
                                          <td><?= number_format($total_total_price) ?></td>
                                          <td><?= $total_count_every ?></td>
                                          <td><?= $total_count_all ?></td>
                                      </tr>
 								  </tbody>
 							  </table>
 						  </div>

					   </div>

				   </div>

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

    <div id="modal_add" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-3 border-info">
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Добавить расходный материал</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <?= SalesOrderAdd::form() ?>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
