<?php
require_once '../../tools/warframe.php';
is_auth(1);
$header = "Настройки";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

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

				<?php if ($_FILES): ?>
					<?php

					if ($_FILES['logo']['error'] === UPLOAD_ERR_OK) {
						$fileTmpPath = $_FILES['logo']['tmp_name'];
						$fileName = $_FILES['logo']['name'];
						$fileSize = $_FILES['logo']['size'];
						$fileType = $_FILES['logo']['type'];

						$fileNameCmps = explode(".", $fileName);
						$fileExtension = strtolower(end($fileNameCmps));
						$newFileName = sha1(time() . $fileName) . '.' . $fileExtension;
						$allowedfileExtensions = array('jpg', 'png');

						if (in_array($fileExtension, $allowedfileExtensions)) {
							$uploadFileDir = $_SERVER['DOCUMENT_ROOT'].DIR."/storage/";
							$dest_path = $uploadFileDir . $newFileName;

							$select = $db->query("SELECT const_value FROM company WHERE const_label = 'logotype'")->fetchColumn();
							if ($select) {
								unlink($_SERVER['DOCUMENT_ROOT'].DIR.$select);
							}

							$logo = Mixin\insert_or_update("company", array('const_label' => 'logotype', 'const_value' => "/storage/".$newFileName), "const_label");
							if(intval($logo) and move_uploaded_file($fileTmpPath, $dest_path)){
							  	echo 'File is successfully uploaded.';
							}
							else{
							  	echo 'Ошибка.';
							}

						}else {
							// Ошибка расширения
						}
					}else {
						// Ошибка при загрузке
					}

					?>
				<?php endif; ?>

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Настройки</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">

						<form action="" method="post" enctype="multipart/form-data">

							<input type="file" name="logo" class="form-control">
							<!-- <input type="text" name="title" class="form-control"> -->
							<button type="submit" class="btn">Send</button>

						</form>

				    </div>

				</div>


			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
