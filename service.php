<?php
require_once 'tools/warframe.php';
is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'layout/head.php' ?>

<body>

	<!-- Main navbar -->
	<?php include 'layout/navbar.php' ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include 'layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">

        <div class="card">

	          <div class="card-header header-elements-inline">
	              <h5 class="card-title">Добавить услугу</h5>
	              <div class="header-elements">
	                  <div class="list-icons">
	                      <a class="list-icons-item" data-action="collapse"></a>
	                  </div>
	              </div>
	          </div>

	          <div class="card-body">
	                <?php
									form('ServiceForm');
	                ?>
	          </div>

        </div>

        <div class="card">

              <div class="card-header header-elements-inline">
                  <h5 class="card-title">Услуги</h5>
                  <div class="header-elements">
                      <div class="list-icons">
                          <a class="list-icons-item" data-action="collapse"></a>
                      </div>
                  </div>
              </div>

              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table table-hover">
                          <thead>
                              <tr class="bg-blue">
																	<th style="width:20%">Id</th>
																	<th>Группа</th>
																	<th>Категория</th>
																	<th>Роль</th>
																	<th>Название</th>
																	<th>Цена</th>
																	<th style="width: 100px">Действия</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              foreach($db->query('SELECT * from service') as $row) {
                                  ?>
                                  <tr>
																			<td><?= $row['id'] ?></td>
                                      <td>
																					<?php
																							$stmt = $db->query("SELECT * from service_group where id = ".$row['group_id'])->fetch(PDO::FETCH_OBJ);
																							echo $stmt->name;
																					?>
																			</td>
                                      <td>
																					<?php
																							$stmt = $db->query("SELECT * from service_category where id = ".$row['category_id'])->fetch(PDO::FETCH_OBJ);
																							echo $stmt->name;
																					?>
																			</td>
																			<td><?= level_name($row['user_level']); ?></td>
                                      <td><?= $row['name'] ?></td>
																			<td><?= $row['price'] ?></td>
                                      <td>
																					<a href="model/update.php?id=<?= $row['id'] ?>&form=ServiceForm" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
																					<a href="model/delete.php?<?= delete($row['id'], 'serviсe', $_SERVER['PHP_SELF']) ?>" onclick="return confirm('Вы уверены что хотите удалить койку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
    <?php include 'layout/footer.php' ?>
    <!-- /footer -->

</body>
</html>
