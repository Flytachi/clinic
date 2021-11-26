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
				$trig = $db->query("SHOW TRIGGERS")->fetch();
				// $query_start = "DROP TRIGGER IF EXISTS  {$trig['Trigger']}; DELIMITER $";
				// $query_body = "CREATE TRIGGER {$trig['Trigger']} {$trig['Timing']} {$trig['Event']} ON {$trig['Table']} FOR EACH ROW {$trig['Statement']}";
				// $query_end = "$ DELIMITER ;";
				// $query = "$query_start $query_body $query_end";
				
				$index = $db->query("SHOW INDEX FROM beds FROM clinic_v3;")->fetchAll();
				dd( $index );
				// $db->exec($query);

				dd(ini_get('session.hash_function'));
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
