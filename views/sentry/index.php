<?php
require_once '../../tools/warframe.php';
$session->is_auth([5,8]);
$header = "Пациенты";

$tb = (new VisitModel)->as("v")->Data("d.id, d.title")->Join("divisions d ON(d.id=v.division_id)")->Where("v.direction IS NOT NULL AND v.completed IS NULL AND v.is_active IS NOT NULL");
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
						<h6 class="card-title">Стационарные пациенты</h6>
						<div class="header-elements">
                            <div class="form-group-feedback form-group-feedback-right mr-2 wmin-350">
                                <select data-placeholder="Выберите отдел" id="division_input" class="<?= $classes['form-select'] ?>">
                                    <option></option>
                                    <?php foreach($tb->Group("d.title")->list() as $row): ?>
                                        <option value="<?= $row->id ?>" <?= ( $search and $search == $row->id) ? "selected" : "" ?>><?= $row->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
						</div>
						
					</div>

					<div class="card-body" id="search_display"></div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script type="text/javascript">

		<?php if($search): ?>
			Search('<?= json_encode($_GET) ?>');
		<?php endif; ?>

		$("#division_input").change(SearchDublicate);

		function SearchDublicate(){
			Search(null);
		}

		function Search(data = null) {
			var input = document.querySelector('#division_input');
			var display = document.querySelector('#search_display');
			if(data) var data = JSON.parse(data);
			else var data = {CRD_search: input.value};
			$.ajax({
				type: "GET",
				url: "<?= viv('sentry/search') ?>",
				data: data,
				success: function (result) {
					display.innerHTML = result;
				},
			});
		}

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>