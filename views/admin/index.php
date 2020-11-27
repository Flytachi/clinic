<?php
require_once '../../tools/warframe.php';
is_auth(1);
$header = "Персонал";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include '../layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->

		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Добавить Пользователя</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body" id="form_card">
				        <?php UserModel::form(); ?>
				    </div>

				</div>

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Список Пользователей</h5>
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
				                        <th>#</th>
				                        <th>Логин</th>
				                        <th>ФИО</th>
				                        <th>Роль</th>
				                        <th style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
				                    <?php
				                    $i = 1;
				                    foreach($db->query('SELECT * from users WHERE not user_level = 15') as $row) {
				                        ?>
				                        <tr>
				                            <td><?= $i++ ?></td>
				                            <td><?= $row['username'] ?></td>
				                            <td><?= get_full_name($row['id']); ?></td>
				                            <td><?php
				                                echo $PERSONAL[$row['user_level']];
				                                if(division_name($row['id'])){
				                                    echo " (".division_name($row['id']).")";
				                                }
				                                ?>
				                            </td>
				                            <td>
				                                <div class="list-icons">
													<a onclick="Update('<?= up_url($row['id'], 'UserModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<?php
													if ($row['user_level'] !=1) {
														?>
														<a href="<?= del_url($row['id'], 'UserModel') ?>" onclick="return confirm('Вы уверены что хотите удалить пользоватиля?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
														<?php
													}
													?>
				                                </div>
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
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->

	<script type="text/javascript">
		function Update(events) {
			events
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#form_card').html(result);
				},
			});
		};
	</script>

</body>
</html>
