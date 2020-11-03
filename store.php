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
                  // prit($_SESSION);
                  ?>
                  <form class="" action="#" method="post">

                  </form>
              </div>

        </div>

        <div class="card">

              <div class="card-header header-elements-inline">
                  <h5 class="card-title">Услуги</h5>
                  <div class="header-elements">
                      <div class="list-icons">
                          <a class="list-icons-item" data-action="collapse"></a>
                          <a class="list-icons-item" data-action="reload"></a>
                          <a class="list-icons-item" data-action="remove"></a>
                      </div>
                  </div>
              </div>

              <div class="card-body">
                  <div class="table-responsive">
                      <!-- <table class="table table-hover">
                          <thead>
                              <tr class="bg-blue">
                                  <th>Planet</th>
                                  <th>Color</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              foreach($db->query('SELECT * from planets') as $row) {
                                  ?>
                                  <tr>
                                      <td><?= $row['name'] ?></td>
                                      <td><?= $row['color'] ?></td>
                                      <td>
                                          <a href="model/update.php?id=<?= $row['id'] ?>&form=PlanetForm" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                      </td>
                                  </tr>
                                  <?php
                              }
                              ?>
                          </tbody>
                      </table> -->
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
