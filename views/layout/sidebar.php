<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">
    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
			<div class="sidebar-user-material-body">
				<div class="card-body text-center">
					<h4 class="mb-0 text-white text-shadow-dark siya"><?= get_full_name() ?></h4>
					<span class="font-size-sm text-white text-shadow-dark siya"><?= level_name() ." ". division_name() ?></span>
				</div>

				<div class="sidebar-user-material-footer">
					<a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>My account</span></a>
				</div>
			</div>

			<div class="collapse" id="user-nav">
				<ul class="nav nav-sidebar">
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="icon-user-plus"></i>
							<span>My profile</span>
						</a>
					</li>
					<!-- <li class="nav-item">
						<a href="#" class="nav-link">
							<i class="icon-coins"></i>
							<span>My balance</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="icon-comment-discussion"></i>
							<span>Messages</span>
							<span class="badge bg-teal-400 badge-pill align-self-center ml-auto">58</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="icon-cog5"></i>
							<span>Account settings</span>
						</a>
					</li> -->
					<li class="nav-item">
						<a href="<?= logout() ?>" class="nav-link">
							<i class="icon-switch2"></i>
							<span>Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">

            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Рабочий стол</div> <i class="icon-menu" title="Main"></i></li>

                    <?php
                    switch (level()):
                        case 1:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('admin/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-users"></i>
                                    <span>Персонал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/division') ?>" class="nav-link legitRipple">
                                    <i class="icon-users"></i>
                                    <span>Класификация персонала</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/ward') ?>" class="nav-link legitRipple">
                                    <i class="icon-switch22"></i>
                                    <span>Палаты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/bed') ?>" class="nav-link legitRipple">
                                    <i class="icon-bed2"></i>
                                    <span>Койки</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/service') ?>" class="nav-link legitRipple">
                                    <i class="icon-bag"></i>
                                    <span>Услуги</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/analyze') ?>" class="nav-link legitRipple">
                                    <i class="icon-fire"></i>
                                    <span>Анализы</span>
                                </a>
                            </li>
                            <!--<li class="nav-item">
                                <a href="#" class="nav-link legitRipple">
                                    <i class="icon-store"></i>
                                    <span>Пакеты</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="<?= viv('admin/storage') ?>" class="nav-link legitRipple">
                                    <i class="icon-width"></i>
                                    <span>Склад</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 2:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('registry/index') ?>" class="nav-link">
                                    <i class="icon-display"></i>
                                    <span>Рабочий стол</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('registry/list_patient') ?>" class="nav-link">
                                    <i class="icon-users"></i>
                                    <span>Список пациентов</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 3:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('cashbox/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-display"></i>
                                    <span>Приём платежей</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('cashbox/list_payment') ?>" class="nav-link legitRipple">
                                    <i class="icon-display"></i>
                                    <span>История платежей</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('cashbox/list_investment') ?>" class="nav-link legitRipple">
                                    <i class="icon-display"></i>
                                    <span>Инвестиции</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('cashbox/list_report') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Отчёт</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 4:
                            ?>
                            <li class="nav-item">
                                <a href="orders.php" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Заказы</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="application.php" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="sales.php?id=cash&invoice" class="nav-link legitRipple">
                                    <i class="icon-users"></i>
                                    <span>Продажа</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="products.php" class="nav-link legitRipple">
                                    <i class="icon-users"></i>
                                    <span>Препараты (товары)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="customer.php" class="nav-link legitRipple">
                                    <i class="icon-bed2"></i>
                                    <span>Клиенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="supplier.php" class="nav-link legitRipple">
                                    <i class="icon-bed2"></i>
                                    <span>Поставщики</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#" class="nav-link legitRipple">
                                    <i class="icon-bed2"></i>
                                    <span>Отчет продаж</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="sales_inventory.php" class="nav-link legitRipple">
                                    <i class="icon-width"></i>
                                    <span>Инвентаризация продаж</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="all_prep.php" class="nav-link legitRipple">
                                    <i class="icon-width"></i>
                                    <span>Все наименования</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 5:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('doctor/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-user-plus"></i>
                                    <span>Принять пациентов</span>
                                    <?php
                                    $con_one = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 1 AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('doctor/list_outpatient') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2 "></i>
                                    <span>Амбулаторные пациенты</span>
                                    <?php
                                    $con_two = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_two) {
                                        ?>
                                        <span class="badge bg-blue badge-pill ml-auto"><?=$con_two?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('doctor/list_stationary') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Стационарные пациенты</span>
                                    <?php
                                    $con_tree = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_tree) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('doctor/list_completed') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Завершёные пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('maindoctor/list_all') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Все пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('doctor/note') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 6:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('laboratory/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-display"></i>
                                    <span>Рабочий стол</span>
                                    <?php
                                    $con_one = $db->query("SELECT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 1 AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('laboratory/list_outpatient') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2 "></i>
                                    <span>Амбулаторные пациенты</span>
                                    <?php
                                    $con_two = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_two) {
                                        ?>
                                        <span class="badge bg-blue badge-pill ml-auto"><?=$con_two?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('laboratory/list_stationary') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Стационарные пациенты</span>
                                    <?php
                                    $con_tree = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_tree) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('laboratory/list_completed') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Завершёные пациенты</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 7:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('nurce/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Стационарные пациенты</span>
                                    <?php
                                    $con_one = $db->query("SELECT id FROM beds WHERE user_id IS NOT NULL")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('nurce/list_task') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Задания</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('nurce/storage') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Склад</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('journal/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Журнал</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 8:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('maindoctor/index') ?>" class="nav-link">
                                    <i class="icon-display"></i>
                                    <span>Рабочий стол</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('maindoctor/list_operation') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Операционные пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('maindoctor/list_all') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Все пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('maindoctor/reports/content_1') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Отчёт</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 9:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('coock/index') ?>" class="nav-link">
                                    <i class="icon-display"></i>
                                    <span>Рабочий стол</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 10:
                            ?>
                            <?php if (division_assist() == 1): ?>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/index') ?>" class="nav-link legitRipple">
                                        <i class="icon-display"></i>
                                        <span>Рабочий стол</span>
                                        <?php
                                        $con_one = $db->query("SELECT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 1 AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                        if ($con_one) {
                                            ?>
                                            <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                            <?php elseif (division_assist() == 2): ?>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/list_outpatient') ?>" class="nav-link legitRipple">
                                        <i class="icon-users2 "></i>
                                        <span>Амбулаторные пациенты</span>
                                        <?php
                                        $con_two = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.assist_id IS NOT NULL ORDER BY vs.add_date ASC")->rowCount();
                                        if ($con_two) {
                                            ?>
                                            <span class="badge bg-blue badge-pill ml-auto"><?=$con_two?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/list_stationary') ?>" class="nav-link legitRipple">
                                        <i class="icon-users2"></i>
                                        <span>Стационарные пациенты</span>
                                        <?php
                                        $con_tree = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.assist_id IS NOT NULL ORDER BY vs.add_date ASC")->rowCount();
                                        if ($con_tree) {
                                            ?>
                                            <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/index') ?>" class="nav-link legitRipple">
                                        <i class="icon-display"></i>
                                        <span>Рабочий стол</span>
                                        <?php
                                        $con_one = $db->query("SELECT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 1 AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                        if ($con_one) {
                                            ?>
                                            <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/list_outpatient') ?>" class="nav-link legitRipple">
                                        <i class="icon-users2 "></i>
                                        <span>Амбулаторные пациенты</span>
                                        <?php
                                        $con_two = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                        if ($con_two) {
                                            ?>
                                            <span class="badge bg-blue badge-pill ml-auto"><?=$con_two?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/list_stationary') ?>" class="nav-link legitRipple">
                                        <i class="icon-users2"></i>
                                        <span>Стационарные пациенты</span>
                                        <?php
                                        $con_tree = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                        if ($con_tree) {
                                            ?>
                                            <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a href="<?= viv('diagnostic/list_completed') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Завершёные пациенты</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 11:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('anesthetist/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Пациенты</span>
                                    <?php
                                    $con_tree = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.oper_date IS NOT NULL ORDER BY us.id ASC")->rowCount();
                                    if ($con_tree) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('anesthetist/storage') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Склад</span>
                                </a>
                            </li>
                            <?php
                            break;
                    endswitch;
                    ?>

                <!-- <li class="nav-item">
                    <a href="test.php" class="nav-link legitRipple">
                        <i class="icon-width"></i>
                        <span>Tests</span>
                        <span class="badge bg-blue-400 align-self-center ml-auto">2.0</span>
                    </a>
                </li> -->
                <!-- /main -->
            </ul>

        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->
</div>
