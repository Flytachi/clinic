<?php

use Mixin\Hell;

require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Методы ввода лекарств";
importModel('Method');
$tb = new Method();
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
				        <h5 class="card-title">Добавить Метод</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body" id="form_card">
				        <?= $tb->form(); ?>
				    </div>

				</div>

				<div class="<?= $classes['card'] ?>">

				    <div class="<?= $classes['card-header'] ?>">
				        <h5 class="card-title">Список Пользователей</h5>
				        <div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите логин или имя">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
				        </div>
				    </div>

				    <div class="card-body" id="search_display">

				        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="<?= $classes['table-thead'] ?>">
				                        <th>#</th>
				                        <th>Наименование</th>
				                        <th class="text-right" style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
									<?php foreach ($tb->list(1) as $row): ?>
										<tr>
				                            <td><?= $row->count ?></td>
				                            <td><?= $row->name ?></td>
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

													<a onclick="Update('<?= Hell::ApiGet('Method', $row->id, 'form') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= Hell::apiDelete('Method', $row->id) ?>" onclick="return confirm('Вы уверены что хотите удалить метод?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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

    <script type="text/javascript">

		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#form_card').html(result);
				},
			});
		};

        function Change(id, status) {
            $.post(`<?= Hell::apiHook(array('model' => 'Method')) ?>&id=${id}`, {is_active: status})
                .then(() => setStatus(id, status))
        }

        function setStatus(id, status) {
            var badge = document.getElementById(`status_change_${id}`);
            if (status == 1) {
                badge.className = "badge bg-success dropdown-toggle";
                badge.innerHTML = "Active";
                badge.onclick = `Change(${id}, 1)`;
            }else if (status == 0) {
                badge.className = "badge bg-secondary dropdown-toggle";
                badge.innerHTML = "Pasive";
                badge.onclick = `Change(${id}, 0)`;
            }
        }

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
