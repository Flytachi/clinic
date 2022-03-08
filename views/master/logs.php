<?php

use Mixin\Cluster;
use Mixin\Model;

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
				<a href="<?= viv('master/mr_patient_add') ?>" target="_blank" rel="noopener noreferrer">users => set => patients</a><br>
				<a href="<?= viv('master/mr_patient_delete') ?>" target="_blank" rel="noopener noreferrer">users delete patients</a><br>
				<a href="<?= viv('master/mr_bd_change') ?>?status=new" target="_blank" rel="noopener noreferrer">set user_id => patient_id</a><br>
				<a href="<?= viv('master/mr_bd_change') ?>?status=old" target="_blank" rel="noopener noreferrer">set patient_id => user_id</a><br>
				<?php

				// function insertPacs($tb, $post){
				// 	global $pacs;
				// 	$col = implode(",", array_keys($post));
				// 	$val = ":".implode(", :", array_keys($post));
				// 	$sql = "INSERT INTO $tb ($col) VALUES ($val)";
				// 	try{
				// 		$stm = $pacs->prepare($sql)->execute($post);
				// 		return $pacs->lastInsertId();
				// 	}
				// 	catch (\PDOException $ex) {
				// 		return $ex->getMessage();
				// 	}
				// }

				dd(PDO::getAvailableDrivers());
				
				//* 1 Step *//

				// $DNS = "odbc:Driver=ODBC Driver 17 for SQL Server;Server=192.168.10.89;Port:1433;Database=OCS;";

				// try {
				// 	$pacs = new PDO($DNS, "OCS", "OCS");
				// 	$pacs->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				// 	$pacs->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
				// 	$pacs->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				// } catch (\PDOException $e) {
				// 	die($e->getMessage());
				// } 


				//* 2 Step *//
				// $DNS = "sqlsrv:Server=213.230.90.9;Database=OCS;";

				// try {
				// 	$pacs = new PDO($DNS, "OCS", "OCS");
				// 	$pacs->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				// 	$pacs->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
				// 	$pacs->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				// } catch (\PDOException $e) {
				// 	die($e->getMessage());
				// } 

				// parad("PACS", $pacs->query("SELECT * FROM QueueRecord")->fetchAll());

				// $data = array(
				// 	'PatientID' => '21', 
				// 	'FirstName' => 'Farhod', 
				// 	'MiddleName' => 'Yakubov', 
				// 	'LastName' => 'Abdurasulovich', 
				// 	'Sex' => 'M', 
				// 	'BirthDate' => '1988-04-19', 
				// 	'Modality' => '1', 
				// 	'Department' => 'МРТ', 
				// );
				// insertPacs("QueueRecord", $data);
				/* $pacs->query("INSERT INTO QueueRecord
					(PatientID, FirstName, MiddleName, LastName, Sex, BirthDate, Modality, Department)
					VALUES('21', 'Farhod', 'Yakubov', 'Abdurasulovich', 'M', '1988-04-19', '1', 'МРТ');"); */

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
