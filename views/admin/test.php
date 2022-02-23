<?php

use Mixin\Model;

require_once '../../tools/warframe.php';

importModel('Province');

use Mixin\Hell;
$session->is_auth();
$header = "";
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
                        <h5 class="card-title">_____________</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" id="form_card">
                        <?php ($tb = new Province)->form(); ?>
                    </div>

                </div>

                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h5 class="card-title">Список Направителей</h5>
                    </div>

                    <div class="card-body" id="search_display">

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="<?= $classes['table-thead'] ?>">
                                    <th style="width:50px">№</th>
                                    <th style="width:50%">ФИО</th>
                                    <th style="width: 100px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($tb->list(1) as $row): ?>
                                        <tr>
                                        <td><?= $row->count ?></td>
                                        <td><?= $row->name ?></td>
                                            <td>
                                            <div class="list-icons">
                                                <a onclick="Update('<?= Hell::apiGet('Province', $row->id, 'form') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                                <a href="<?= Hell::apiDelete('Province', $row->id) ?>" onclick="return confirm('Вы уверены что хотите удалить направителя?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
