<?php
require_once '../../tools/warframe.php';
is_auth(1);
$header = "Визиты";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<body>
	<!-- Main navbar -->
	<?php include 'navbar.php' ?>
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

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Список Визитов</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

                    <div id="message">

                    </div>

				    <div class="card-body">

				        <div class="table-responsive">
				            <table class="table table-hover table-sm">
				                <thead>
				                    <tr class="bg-info">
				                        <th style="width: 7%">Visit_id</th>
				                        <th style="width: 7%">User_id</th>
                                        <th>ФИО</th>
                                        <th>Route_id</th>
										<th>Status</th>
                                        <th>Service</th>
                                        <th>Cost</th>
				                        <th class="text-right" style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
				                    <?php
				                    $i = 1;
									$count_elem = 20;
									$count = ceil(intval($db->query("SELECT COUNT(*) FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) LEFT JOIN visit_price vp ON(vs.id=vp.visit_id)")->fetchColumn()) / $count_elem);
									$_GET['of'] = isset($_GET['of']) ? $_GET['of'] : 0;
									$offset = intval($_GET['of']) * $count_elem;

				                    foreach($db->query("SELECT vs.*, sc.name, vp.id 'vp_id', vs.status, vp.item_cost FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) ORDER BY vs.id DESC LIMIT $count_elem OFFSET $offset") as $row) {
				                        ?>
				                        <tr id="TR_<?= $row['id'] ?>">
				                            <td><?= $row['id'] ?></td>
				                            <td><?= $row['user_id'] ?></td>
				                            <td><?= get_full_name($row['user_id']); ?></td>
                                            <td><?= get_full_name($row['route_id']); ?></td>
											<td><?= $row['status'] ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= number_format($row['item_cost'], 1) ?></td>
				                            <td class="text-right">
				                                <div class="list-icons">
                                                    <a onclick="Delete('<?= del_url($row['id'], 'VisitModel') ?>', '#TR_<?= $row['id'] ?>')" href="" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
				                                </div>
				                            </td>
				                        </tr>
				                        <?php
				                    }
				                    ?>
				                </tbody>
				            </table>
							<?php pagination_page($count, $count_elem, 2); ?>
				        </div>

				    </div>

				</div>

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
                    $('#message').html(data);
                    $(tr).css("background-color", "rgb(244, 67, 54)");
                    $(tr).css("color", "white");
                    $(tr).fadeOut(900, function() {
                        $(tr).remove();
                    });
				},
			});
        }
    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>