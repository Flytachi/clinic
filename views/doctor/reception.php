<?php
require_once '../../tools/warframe.php';
is_auth();
$header = "Приём пациетов";
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

                    <div class="card-header">
                        <h4>Пациенты на приём</h4>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-hover table-columned">
                                <thead>
                                    <tr class="bg-blue text-center">
                                        <th>ID</th>
                                        <th>ФИО</th>
                                        <th>Дата рождения</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
                                        <th>Тип визита</th>
                                        <th style="width:300px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($db->query('SELECT vs.id, vs.user_id, us.dateBith, vs.route_id, vs.direction FROM visit vs LEFT JOIN users us ON (vs.user_id = us.id) WHERE vs.die_date IS NULL AND vs.status = 1 AND vs.parent_id = '.$_SESSION['session_id'].' ORDER BY vs.add_date ASC') as $row) {
                                        ?>
                                        <tr id="PatientFailure_tr_<?= $row['id'] ?>">
                                            <td><?= addZero($row['user_id']) ?></td>
                                            <td><?= get_full_name($row['user_id']) ?></td>
                                            <td><?= $row['dateBith'] ?></td>
                                            <td>
                                                <?php
                                                foreach ($db->query('SELECT sr.name FROM visit_service vsr LEFT JOIN service sr ON (vsr.service_id = sr.id) WHERE status IS NULL AND visit_id ='. $row['id']) as $serv) {
                                                    echo $serv['name']."<br>";
                                                }
                                                ?>
                                            </td>
                                            <td><?= get_full_name($row['route_id']) ?></td>
                                            <td class="text-center">
                                                <?php
                                                if($row['direction']){
                                                    ?>
                                                    <span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <button onclick="Recept('PatientFailure_tr_<?= $row['id'] ?>')" type="button" class="btn btn-outline-primary btn-lg legitRipple">Принять</button>
                                                <button onclick="$('#vis_id').val(<?= $row['id'] ?>); $('#vis_title').text('<?= get_full_name($row['user_id']) ?>');" data-toggle="modal" data-target="#modal_failure" type="button" class="btn btn-outline-danger btn-lg legitRipple">Отказ</button>
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

    <!-- Failure modal -->
	<div id="modal_failure" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header bg-danger">
					<h5 class="modal-title">Отказ приёма: <span id="vis_title"></h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<?= PatientFailure::form(); ?>
			</div>
		</div>
	</div>
	<!-- /failure modal -->

    <!-- Footer -->
    <?php include 'layout/footer.php' ?>
    <!-- /footer -->

    <script type="text/javascript">

		function Recept(tr) {
			$('#'+tr).css("background-color", "blue");
			$('#'+tr).css("color", "white");
			$('#'+tr).fadeOut('slow', function() {
				$(this).remove();
			});
		}

        $('#form_PatientFailure').submit(function (events) {
            events.preventDefault();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: $(this).serializeArray(),
                success: function (result) {
					$('#modal_failure').modal('hide');
					$('#'+result).css("background-color", "red");
					$('#'+result).css("color", "white");
					$('#'+result).fadeOut('slow', function() {
						$(this).remove();
					});
                },
            });
        });
    </script>

</body>
</html>
