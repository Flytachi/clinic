<!-- Информация об отделах -->
<div class="mb-3">
	<div class="header-elements-sm-inline">
		<span class="mb-0 text-muted d-block">Отделы</span>
		<h4 class="font-weight-semibold d-block">Информация о отделах</h4>
		<span class="mb-0 text-muted d-block">Сегодня</span>
	</div>
</div>

<div class="row">

	<?php foreach ((new DivisionModel)->Data("id, title")->Where("level IN(5, 6, 12) OR level = 10 AND (assist IS NULL OR assist = 1)")->Order("level")->list() as $row): ?>
		<div class="col-sm-4 col-xl-3" onclick="selDivision(<?= $row->id ?>)">
			<div class="card card-body">
				<div class="media">
					<div class="media-body">
						<h3 class="font-weight-semibold mb-0">
							<?= $db->query("SELECT id FROM visit_services WHERE division_id = $row->id AND DATE_FORMAT(accept_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?>
						</h3>
						<span class="text-uppercase font-size-sm text-muted"><?= $row->title ?></span>
					</div>

					<div class="ml-3 align-self-center">
						<i class="icon-cube4 icon-3x text-blue-400"></i>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

</div>
<!-- /Информация об отделах -->
<script>
	function selDivision(pk) {
		$.ajax({
			type: "GET",
			url: "<?= ajax("main/divisionService") ?>",
			data: {pk},
			success: function (result) {
				$('#modal_default').modal('show');
				$('#form_card').html(result);
			},
		});
	}
</script>

<div id="modal_default" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
	</div>
</div>