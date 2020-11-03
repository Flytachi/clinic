<?php
require_once 'tools/warframe.php';
is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'layout/head.php' ?>

<body>

	<!-- Main navbar -->
	<?php include 'layout/navbar.php' ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include 'layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">

                <div class="card">

                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Добавить Койку</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">
                                <legend class="font-weight-semibold"> Добавить койку</legend>
                                <?php
                                form('BedForm');
                                ?>
                            </div>

                            <div class="col-md-6">
                            <legend class="font-weight-semibold"> Добавить тип коек</legend>
                                <?php
                                form('BedTypeForm');
                                ?>

                                <table class="table table-hover">
                                    <thead>
                                        <tr class="">
                                            <th>Вид</th>
                                            <th>Цена</th>
                                            <th style="width: 100px">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($db->query('SELECT * from bed_type') as $row) {
                                            ?>
                                            <tr>
                                                <td><?= $row['name'] ?></td>
                                                <td><?= $row['price'] ?></td>
                                                <td>
                                                    <a href="model/update.php?id=<?= $row['id'] ?>&form=BedTypeForm" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                                    <a href="model/delete.php?<?= delete($row['id'], 'bed_type', $_SERVER['PHP_SELF']) ?>" onclick="return confirm('Вы уверены что хотите удалить койку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="card">

                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Список Коек</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="bg-blue">
                                        <th>Этаж</th>
                                        <th>Палата</th>
                                        <th>Койка</th>
                                        <th>Тип</th>
                                        <th>Цена</th>
                                        <th style="width: 100px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($db->query('SELECT * from beds') as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $row['floor'] ?> этаж</td>
                                            <td><?= $row['ward'] ?> палата</td>
                                            <td><?= $row['num'] ?> койка</td>
                                            <td>
                                                <?php
                                                    $stmt = $db->query("SELECT * from bed_type where id = ".$row['types'])->fetch(PDO::FETCH_OBJ);
                                                    echo $stmt->name;
                                                ?>
                                            </td>
                                            <td><?= $stmt->price ?></td>
                                            <td>
                                                <a href="model/update.php?id=<?= $row['id'] ?>&form=BedForm" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                                <a href="model/delete.php?<?= delete($row['id'], 'beds', $_SERVER['PHP_SELF']) ?>" onclick="return confirm('Вы уверены что хотите удалить койку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


    <!-- Footer -->
    <?php include 'layout/footer.php' ?>
    <!-- /footer -->

</body>
</html>
