<!-- Информация о пациентах -->
<?php 
require_once '../../../tools/warframe.php';
$session->is_auth(8);

importModel('Patient');
?>
<div class="mb-3">
	<div class="header-elements-sm-inline">
		<span class="mb-0 text-muted d-block">Пациенты</span>
		<h4 class="font-weight-semibold d-block">Информация о пациентах</h4>
		<span class="mb-0 text-muted d-block">Сегодня</span>
	</div>
</div>

<div class="row">

	<div class="col-sm-6 col-xl-4">
		<div class="card card-body">
			<div class="media">
				<div class="media-body">
					<h3 class="font-weight-semibold mb-0">
						<?= 
							number_format(
								(new Patient)->Data("COUNT(id) 'c'")
								->Where("DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->get()->c
							);
						?>
					</h3>
					<span class="text-uppercase font-size-sm text-muted">Новые пациенты</span>
				</div>

				<div class="ml-3 align-self-center">
					<i class="icon-users2 icon-3x text-success-400"></i>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xl-4">
		<div class="card card-body">
			<div class="media">
				<div class="media-body">
					<h3 class="font-weight-semibold mb-0">
						<?= 
							number_format(
								(new VisitServicesModel)->as("vs")
									->Data("COUNT(DISTINCT vs.patient_id) 'c'")
									->Join("visits v", "v.id=vs.visit_id")
									->Where("v.direction IS NULL AND DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE()")->get()->c
							);
						?>
					</h3>
					<span class="text-uppercase font-size-sm text-muted">Посещаемость (Амбулатор)</span>
				</div>

				<div class="ml-3 align-self-center">
					<i class="icon-users4 icon-3x text-blue-400"></i>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xl-4">
		<div class="card card-body">
			<div class="media">
				<div class="media-body">
					<h3 class="font-weight-semibold mb-0">
						<?= 
							number_format(
								(new VisitServicesModel)->as("vs")
									->Data("COUNT(DISTINCT vs.patient_id) 'c'")
									->Join("visits v", "v.id=vs.visit_id")
									->Where("v.direction IS NOT NULL AND DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE()")->get()->c
							);
						?>					
					</h3>
					<span class="text-uppercase font-size-sm text-muted">Посещаемость (Стационар)</span>
				</div>

				<div class="ml-3 align-self-center">
					<i class="icon-users4 icon-3x text-danger-400"></i>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /Информация о пациентах -->