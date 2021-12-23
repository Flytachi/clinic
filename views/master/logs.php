<?php
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

				<?php

				$DNS = "mysql:host=192.168.10.89;dbname=OCS;charset=utf8";

				try {
					$pacs = new PDO($DNS, "OCS", "OCS");
					$pacs->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
					$pacs->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
					if ( isset($ini['GLOBAL_SETTING']['DEBUG']) and $ini['GLOBAL_SETTING']['DEBUG'] ) $pacs->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} catch (\PDOException $e) {
					die($e->getMessage());
				}

				dd($pacs->query("SELECT * FROM QueueRecord")->fetchAll());

				// foreach ($db->query("SELECT id, report, report_description, report_diagnostic, report_recommendation FROM visit WHERE report_title IS NOT NULL") as $value) {
				// 	$report = "<p>".$value['report_description']."</p><span class=\"text-big\"><strong>Диагноз:</strong></span>"."<p>".$value['report_diagnostic']."</p><span class=\"text-big\"><strong>Рекомендация:</strong></span>"."<p>".$value['report_recommendation']."</p>";
				// 	// dd($value);
				// 	Mixin\update('visit', array('report' => $report), $value['id']);
				// 	// dd($report);
				// }
				
				dd($_SERVER['HTTP_USER_AGENT']);
				?>
				<?php parad("_COOKIE ",$_COOKIE); ?>
				<?php parad("_SERVER ",$_SERVER); ?>
				<?php parad("Modules ",module()); ?>
				<?php parad("_session ",$session); ?>
				<?php parad("_SESSION ",$_SESSION); ?>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
</body>
</html>
