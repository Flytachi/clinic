<?php

use Mixin\Hell;

require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Логи";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include 'navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include 'sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
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

					<a href="<?= viv('master/mr_patient_add') ?>" target="_blank" rel="noopener noreferrer">users => set => patients</a><br>
					<a href="<?= viv('master/mr_patient_delete') ?>" target="_blank" rel="noopener noreferrer">users delete patients</a><br>
					<a href="<?= viv('master/mr_bd_change') ?>?status=new" target="_blank" rel="noopener noreferrer">set user_id => patient_id</a><br>
					<a href="<?= viv('master/mr_bd_change') ?>?status=old" target="_blank" rel="noopener noreferrer">set patient_id => user_id</a><br>

          		</div>
				
			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

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
