<?php
require_once '../../tools/warframe.php';
$session->is_auth(3);
$header = "Койки";

$tb = (new BedTypeModel)->tb();
$tb->where("branch_id = $session->branch")->set_limit(20);
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

                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h5 class="card-title">Добавить Койку</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" id="form_card">
		    			<?php (new BedTypeModel)->form(); ?>
		          	</div>


                </div>

                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h5 class="card-title">Список Коек</h5>
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
                                    <tr class="<?= $classes['table-thead'] ?>">
                                        <th>Вид</th>
                                        <th class="text-right" style="width: 200px">Цена</th>
                                        <th class="text-right" style="width: 200px">Цена(для иностранцев)</th>
                                        <th style="width: 100px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tb->get_table() as $row): ?>
										<tr>
				                            <td><?= $row->name ?></td>
				                            <td class="text-right"><?= number_format($row->price) ?></td>
				                            <td class="text-right"><?= number_format($row->price_foreigner) ?></td>
				                            <td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row->id, 'BedTypeModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row->id, 'BedTypeModel') ?>" onclick="return confirm('Вы уверены что хотите удалить вид коек?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
				                                </div>
	                                      	</td>
				                        </tr>
									<?php endforeach; ?>
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
    <?php include layout('footer') ?>
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
