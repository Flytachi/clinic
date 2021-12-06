<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Персонал";

$tb = (new CorpBranchModel)->Order("add_date ASC")->Limit(15);
$search = $tb->getSearch();
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
				        <h5 class="card-title">Добавить XXX</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body" id="form_card">
				        <?php (new CorpBranchModel)->form(); ?>
				    </div>

				</div>

				<div class="<?= $classes['card'] ?>">

				    <div class="<?= $classes['card-header'] ?>">
				        <h5 class="card-title">Список XXX</h5>
				    </div>

				    <div class="card-body" id="search_display">

				        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="<?= $classes['table-thead'] ?>">
				                        <th>#</th>
				                        <th>Name</th>
				                        <th>Address</th>
				                        <th>AddDate</th>
				                        <th style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
									<?php foreach ($tb->list(1) as $row): ?>
										<tr>
				                            <td><?= $row->count ?></td>
				                            <td><?= $row->name ?></td>
				                            <td><?= $row->address ?></td>
				                            <td><?= date_f($row->add_date) ?></td>
				                            <td>
				                                <div class="list-icons">

													<div class="dropdown">                      
														<?php if ($row->is_active): ?>
															<a href="#" id="status_change_<?= $row->id ?>" class="badge bg-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Active</a>
														<?php else: ?>
															<a href="#" id="status_change_<?= $row->id ?>" class="badge bg-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Pasive</a>
														<?php endif; ?>

														<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(74px, 21px, 0px);">
															<a onclick="Change(<?= $row->id ?>, 1)" class="dropdown-item">
																<span class="badge badge-mark mr-2 border-success"></span>
																Active
															</a>
															<a onclick="Change(<?= $row->id ?>, 0)" class="dropdown-item">
																<span class="badge badge-mark mr-2 border-secondary"></span>
																Pasive
															</a>
														</div>
													</div>

													<a onclick="Update('<?= up_url($row->id, 'CorpBranchModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<?php if (config("admin_delete_button_branch")): ?>
														<a href="<?= del_url($row->id, 'CorpBranchModel') ?>" onclick="return confirm('Вы уверены что хотите удалить пользоватиля?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
													<?php endif; ?>
				                                </div>
				                            </td>
				                        </tr>
									<?php endforeach; ?>
				                </tbody>
				            </table>
				        </div>

						<?php $tb->panel(); ?>

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

		function Change(id, stat = null) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: "<?= ajax('admin_status') ?>",
				data: { table:"corp_branchs", id:id, is_active: stat },
				success: function (data) {
                    if (data) {
						var badge = document.getElementById(`status_change_${id}`);
						if (data == 1) {
							badge.className = "badge bg-success dropdown-toggle";
							badge.innerHTML = "Active";
							badge.onclick = `Change(${id}, 1)`;
						}else if (data == 0) {
							badge.className = "badge bg-secondary dropdown-toggle";
							badge.innerHTML = "Pasive";
							badge.onclick = `Change(${id}, 0)`;
						}
                    }
				},
			});
        }

		function Update(events) {
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
