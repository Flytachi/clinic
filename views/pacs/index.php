<?php
require_once '../../tools/warframe.php';
$session->is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head'); ?>

<body>

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">

				<?php
				new Connect("odbc:Driver=ODBC Driver 17 for SQL Server;Server=213.230.90.9;Port:1433;Database=OCS;", "OCS", "OCS", "pacs");
                parad("PACS", $pacs->query("SELECT * FROM QueueRecord")->fetchAll());
				?>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
</body>
</html>