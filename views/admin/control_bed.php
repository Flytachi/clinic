<?php 
require_once '../../tools/warframe.php';
$session->is_auth(1);
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
                        <h6 class="card-title" >Фильтр</h6>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <form action="" method="post">

                            <div class="form-group row">

                                <div class="col-md-2">
                                    <label>Этаж:</label>
                                    <select name="floor" id="floor" class="<?= $classes['form-select'] ?>">
                                        <option value="">Выбрать этаж</option>
                                        <?php foreach ($FLOOR as $key => $value): ?>
                                            <option value="<?= $key ?>" <?= ($_POST['floor'] == $key) ? "selected" : "" ?>><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label>Палата:</label>
                                    <select name="ward" id="ward" class="<?= $classes['form-select'] ?>">
                                        <option value="">Выбрать палату</option>
                                        <?php foreach ($db->query("SELECT ws.id, ws.floor, ws.ward FROM wards ws") as $row): ?>
                                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['floor'] ?>" <?= ($_POST['ward'] == $row['id']) ? "selected" : "" ?>><?= $row['ward'] ?> палата</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Койка:</label>
                                    <select name="bed" id="bed" class="<?= $classes['form-select_price'] ?>">
                                        <option value="">Выбрать койку</option>
                                        <?php foreach ($db->query('SELECT bd.*, bdt.price, bdt.name from beds bd LEFT JOIN bed_type bdt ON(bd.types=bdt.id)') as $row): ?>
                                            <?php if ($row['user_id']): ?>
                                                <option value="<?= $row['id'] ?>" <?= ($_POST['bed'] == $row['id']) ? "selected" : "" ?> data-chained="<?= $row['ward_id'] ?>" data-price="<?= $row['price'] ?>" data-name="<?= $row['name'] ?>"><?= $row['bed'] ?> койка (<?= ($db->query("SELECT gender FROM users WHERE id = {$row['user_id']}")->fetchColumn()) ? "Male" : "Female" ?>)</option>
                                            <?php else: ?>
                                                <option value="<?= $row['id'] ?>" <?= ($_POST['bed'] == $row['id']) ? "selected" : "" ?> data-chained="<?= $row['ward_id'] ?>" data-price="<?= $row['price'] ?>" data-name="<?= $row['name'] ?>"><?= $row['bed'] ?> койка</option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>

                            <!-- <div class="from-group row">

                                <div class="col-md-3">
                                    <label>Тип визита:</label>
                                    <select class="form-control form-control-select2" name="direction" data-fouc>
                                        <option value="">Выберите тип визита</option>
                                        <option value="1" <?= ($_POST['direction']==1) ? "selected" : "" ?>>Амбулаторный</option>
                                        <option value="2" <?= ($_POST['direction']==2) ? "selected" : "" ?>>Стационарный</option>
                                    </select>
                                </div>

                            </div> -->

                            <div class="text-right">
                                <button type="submit" id="submit" class="btn btn-outline-info"><i class="icon-search4 mr-2"></i>Поиск</button>
                            </div>


                        </form>

                    </div>

                </div>

                <div id="message">
                    <?php
                    if( isset($_SESSION['message']) ){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                    ?>
                </div>

                <?php if ($_POST): ?>
					<?php
					$sql = "SELECT bd.id,  wd.floor, wd.ward, 
                                bd.bed, bdt.name 'bed_type', bd.user_id,
                                (SELECT COUNT(id) FROM visit WHERE bed_id = bd.id AND add_date IS NOT NULL AND completed IS NULL) 'status'
                            FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) LEFT JOIN bed_type bdt ON(bdt.id=bd.types) 
                            WHERE bd.add_date IS NOT NULL";
					if ($_POST['floor']) {
						$sql .= " AND wd.floor = {$_POST['floor']}";
					}
                    if ($_POST['ward']) {
						$sql .= " AND wd.id = {$_POST['ward']}";
					}
                    if ($_POST['bed']) {
						$sql .= " AND bd.id = {$_POST['bed']}";
					}
					// if (!$_POST['status_true'] or !$_POST['status_false']) {
					// 	if ($_POST['status_true']) {
					// 		$sql .= " AND us.status IS NOT NULL";
					// 	}
					// 	if ($_POST['status_false']) {
					// 		$sql .= " AND us.status IS NULL";
					// 	}
					// }
					?>
					<div class="<?= $classes['card'] ?>" id="table_div">

                        <div class="<?= $classes['card-header'] ?>">
                            <h6 class="card-title">Beds</h6>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-hover table-sm table-bordered" id="table">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>Этаж</th>
                                            <th>Палата</th>
                                            <th>Койка</th>
                                            <th>Тип</th>
                                            <th>User</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($db->query($sql) as $row): ?>
											<tr>
                                                <td><?= $row['floor'] ?> этаж</td>
                                                <td><?= $row['ward'] ?> палата</td>
                                                <td><?= $row['bed'] ?> койка</td>
                                                <td><?= $row['bed_type']?></td>
                                                <td>
                                                    <?php if($row['user_id']): ?>
                                                        <?= addZero($row['user_id']) ." => ". get_full_name($row['user_id']) ?>
                                                    <?php else: ?>
                                                        <span class="text-secondary">Free</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($row['user_id']): ?>
                                                        <?php if($row['status']): ?>
                                                            <span class="badge badge-success">Normal</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-danger">Error (pleace change passive)</span>
                                                        <?php endif; ?>   
                                                    <?php else: ?>
                                                        <?php if($row['status']): ?>
                                                            <span class="badge badge-danger">Error!</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">Normal</span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-right">
													<div class="list-icons">
														<a onclick="Update('<?= up_url($row['id'], 'BedModel') ?>')" href="#" class="list-icons-item text-danger-600"><i class="icon-undo"></i></a>
													</div>
												</td>
                                            </tr>
										<?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
				<?php endif; ?>
			
            </div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <script type="text/javascript">
        function Update(events, tr) {
            event.preventDefault();
			$.ajax({
				type: "GET",
				url: events+"&type=1",
				success: function (result) {
					$('#submit').click();
				},
			});
		};
        $(function(){
            $("#ward").chained("#floor");
            $("#bed").chained("#ward");
        });
    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>