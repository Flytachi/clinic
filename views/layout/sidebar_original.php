<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">
    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="sidebar-user-material-body">
                <div class="card-body text-center">
                    <h4 class="mb-0 text-white text-shadow-dark"><?= get_full_name() ?></h4>
                    <span class="font-size-sm text-white text-shadow-dark"><?= level_name() ." ". division_name() ?></span>
                </div>

                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>My account</span></a>
                </div>
            </div>

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">

                    <?php foreach ($db->query("SELECT us.id, us.username FROM multi_accounts mca LEFT JOIN users us ON(mca.user_id=us.id) WHERE mca.slot = \"{$_SESSION['slot']}\" ") as $acc): ?>
                        <li class="nav-item">
                            <a href="<?= DIR."/auth/recheck".EXT ?>?slot=<?= $acc['id'] ?>" class="nav-link">
                                <i class="icon-user"></i>
                                <span><?= $acc['username'] ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>

                    <?php if ($_SESSION['master_status']): ?>
                        <li class="nav-item">
                            <a href="<?= logout_avatar() ?>" class="nav-link">
                                <i class="icon-arrow-down16"></i>
                                <span>Logout in avatar</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (permission(5)): ?>
                        <li class="nav-item">
                            <a href="<?= viv('doctor/package') ?>" class="nav-link legitRipple">
                                <i class="icon-bag"></i>
                                <span>Пакеты<span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= viv('doctor/template') ?>" class="nav-link legitRipple">
                                <i class="icon-users"></i>
                                <span>Шаблоны</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- <li class="nav-item">
                        <a href="<?= logout() ?>" class="nav-link">
                            <i class="icon-switch2"></i>
                            <span>Logout</span>
                        </a>
                    </li> -->
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
                                <a href="<?= viv('admin/index') ?>" class="nav-link legitRipple <?= viv_link('admin/index') ?>">
                                    <i class="icon-users"></i>
                                    <span>Персонал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/division') ?>" class="nav-link legitRipple <?= viv_link('admin/division') ?>">
                                    <i class="icon-users"></i>
                                    <span>Класификация персонала</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= viv('admin/service') ?>" class="nav-link legitRipple <?= viv_link('admin/service') ?>">
                                    <i class="icon-bag"></i>
                                    <span>Услуги</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/preparats') ?>" class="nav-link legitRipple <?= viv_link('admin/preparats') ?>">
                                    <i class="icon-package"></i>
                                    <span>Препараты к услугам</span>
                                </a>
                            </li>
                            <?php if(module('module_laboratory')): ?>
                                <li class="nav-item">
                                    <a href="<?= viv('admin/analyze') ?>" class="nav-link legitRipple <?= viv_link('admin/analyze') ?>">
                                        <i class="icon-fire"></i>
                                        <span>Анализы</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <li class="nav-item">
                                <a href="<?= viv('admin/ward') ?>" class="nav-link legitRipple <?= viv_link('admin/ward') ?>">
                                    <i class="icon-switch22"></i>
                                    <span>Палаты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/bed') ?>" class="nav-link legitRipple <?= viv_link('admin/bed') ?>">
                                    <i class="icon-bed2"></i>
                                    <span>Койки</span>
                                </a>
                            </li>
                            <!--<li class="nav-item">
                                <a href="#" class="nav-link legitRipple">
                                    <i class="icon-store"></i>
                                    <span>Пакеты</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="<?= viv('admin/setting') ?>" class="nav-link legitRipple <?= viv_link('admin/setting') ?>">
                                    <i class="icon-cog2"></i>
                                    <span>Настройки</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/guide') ?>" class="nav-link legitRipple <?= viv_link('admin/guide') ?>">
                                    <i class="icon-width"></i>
                                    <span>Направители</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/multi_account') ?>" class="nav-link legitRipple <?= viv_link('admin/multi_account') ?>">
                                    <i class="icon-width"></i>
                                    <span>Мульти-аккаунт</span>
                                </a>
                            </li>
                            <li class="nav-item nav-item-submenu <?= viv_link('admin/storage', 'nav-item-expanded nav-item-open') ?>">
    							<a href="#" class="nav-link legitRipple"><i class="icon-stack2"></i> <span>Аптека</span></a>

    							<ul class="nav nav-group-sub" data-submenu-title="Аптека">
    								<li class="nav-item"><a href="<?= viv('admin/storage') ?>" class="nav-link legitRipple <?= viv_link('admin/storage') ?>">Препараты</a></li>
    							</ul>
    						</li>
                            <li class="nav-item nav-item-submenu <?= viv_link('admin/control_visit', 'nav-item-expanded nav-item-open') ?> <?= viv_link('admin/control_user', 'nav-item-expanded nav-item-open') ?> <?= viv_link('admin/control_bed', 'nav-item-expanded nav-item-open') ?>">
    							<a href="#" class="nav-link legitRipple"><i class="icon-stack2"></i> <span>Контроль</span></a>

    							<ul class="nav nav-group-sub" data-submenu-title="Контроль">
    								<li class="nav-item"><a href="<?= viv('admin/control_visit') ?>" class="nav-link legitRipple <?= viv_link('admin/control_visit') ?>">Визиты</a></li>
                                    <li class="nav-item"><a href="<?= viv('admin/control_user') ?>" class="nav-link legitRipple <?= viv_link('admin/control_user') ?>">Пациент</a></li>
    								<li class="nav-item"><a href="<?= viv('admin/control_bed') ?>" class="nav-link legitRipple <?= viv_link('admin/control_bed') ?>">Койки</a></li>
    							</ul>
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

                            <li class="nav-item">
                                <a href="<?= viv('registry/guide') ?>" class="nav-link legitRipple">
                                    <i class="icon-width"></i>
                                    <span>Направители</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('archive/journal') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Журнал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
                                    <span>Отчёт</span>
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
                                <a href="<?= viv('cashbox/refund') ?>" class="nav-link legitRipple">
                                    <i class="icon-display"></i>
                                    <span>Возврат</span>
                                    <?php
                                    $con_one = $db->query("SELECT DISTINCT user_id 'id' FROM visit WHERE direction IS NULL AND status = 5 AND add_date")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
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
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
                                    <span>Отчёт</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 4:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('pharmacy/sale') ?>" class="nav-link legitRipple">
                                    <i class="icon-coins"></i>
                                    <span>Продажа</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('pharmacy/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-store"></i>
                                    <span>Препараты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('pharmacy/orders') ?>" class="nav-link legitRipple">
                                    <i class="icon-task "></i>
                                    <span>Заказы</span>
                                    <?php
                                    $con_one = $db->query("SELECT DISTINCT parent_id FROM storage_orders WHERE date = CURRENT_DATE() AND user_id IS NULL")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('pharmacy/users') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Пациенты</span>
                                    <?php
                                    $con_two = $db->query("SELECT DISTINCT user_id, parent_id FROM storage_orders WHERE date = CURRENT_DATE() AND user_id IS NOT NULL")->rowCount();
                                    if ($con_two) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_two?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('pharmacy/application') ?>" class="nav-link legitRipple">
                                    <i class="icon-task "></i>
                                    <span>Все заявки</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
                                    <span>Отчёт</span>
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
                                    $con_one = $db->query("SELECT DISTINCT vs.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 1 AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
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
                                <a href="<?= viv('archive/completed/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Завершёные пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('note/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= viv('archive/journal') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Журнал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('archive/all/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-archive"></i>
                                    <span>Архив</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
                                    <span>Отчёт</span>
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
                                    $con_one = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 1 AND vs.laboratory IS NOT NULL ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="<?= viv('laboratory/task') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Текущие задачи</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="<?= viv('laboratory/list_outpatient') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2 "></i>
                                    <span>Амбулаторные пациенты</span>
                                    <?php
                                    $con_two = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.laboratory IS NOT NULL ORDER BY vs.add_date ASC")->rowCount();
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
                                    $con_tree = $db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.laboratory IS NOT NULL ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_tree) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('archive/completed/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Завершёные пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('note/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= viv('archive/journal') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Журнал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('archive/all/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-archive"></i>
                                    <span>Архив</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
                                    <span>Отчёт</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 7:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('nurce/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-bookmark"></i>
                                    <span>Задания</span>
                                    <?php
                                    $con_one = $db->query("SELECT DISTINCT b.user_id FROM bypass_date bd LEFT JOIN bypass b ON(b.id=bd.bypass_id) WHERE bd.date = CURRENT_DATE() AND status IS NOT NULL AND bd.completed IS NULL")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('nurce/list_stationary') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Стационарные пациенты</span>
                                    <?php
                                    $con_two = $db->query("SELECT id FROM beds WHERE user_id IS NOT NULL")->rowCount();
                                    if ($con_two) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_two?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('archive/journal') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Журнал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('note/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('nurce/storage') ?>" class="nav-link legitRipple">
                                    <i class="icon-store"></i>
                                    <span>Склад</span>
                                    <?php
                                    $con_tree = $db->query("SELECT id FROM storage_orders WHERE parent_id = {$_SESSION['session_id']}")->rowCount();
                                    if ($con_tree) {
                                        ?>
                                        <span class="badge bg-indigo badge-pill ml-auto"><?=$con_tree?></span>
                                        <?php
                                    }
                                    ?>
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
                                <a href="<?= viv('maindoctor/stationary_current') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Стационарные пациенты</span>
                                    <?php
                                    $con_one = $db->query("SELECT id FROM visit WHERE service_id = 1 AND bed_id IS NOT NULL AND completed IS NULL")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('maindoctor/list_operation') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Операционные пациенты</span>
                                    <?php
                                    $con_one = $db->query("SELECT id FROM operation WHERE completed IS NULL")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('note/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= viv('archive/journal') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Журнал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('archive/all/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-archive"></i>
                                    <span>Архив</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
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
                            <li class="nav-item">
                                <a href="<?= viv('note/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
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
                                <li class="nav-item">
                                    <a href="<?= viv('archive/assist/list') ?>" class="nav-link legitRipple">
                                        <i class="icon-collaboration"></i>
                                        <span>Завершёные пациенты</span>
                                    </a>
                                </li>
                            <?php elseif (division_assist() == 2): ?>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/list_outpatient') ?>" class="nav-link legitRipple">
                                        <i class="icon-users2 "></i>
                                        <span>Амбулаторные пациенты</span>
                                        <?php
                                        $con_two = $db->query("SELECT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.assist_id IS NOT NULL ORDER BY vs.add_date ASC")->rowCount();
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
                                        $con_tree = $db->query("SELECT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.assist_id IS NOT NULL ORDER BY vs.add_date ASC")->rowCount();
                                        if ($con_tree) {
                                            ?>
                                            <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= viv('archive/completed/list') ?>" class="nav-link legitRipple">
                                        <i class="icon-collaboration"></i>
                                        <span>Завершёные пациенты</span>
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
                                        $con_two = $db->query("SELECT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
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
                                        $con_tree = $db->query("SELECT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                        if ($con_tree) {
                                            ?>
                                            <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= viv('archive/completed/list') ?>" class="nav-link legitRipple">
                                        <i class="icon-collaboration"></i>
                                        <span>Завершёные пациенты</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a href="<?= viv('note/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= viv('archive/journal') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Журнал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('archive/all/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-archive"></i>
                                    <span>Архив</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
                                    <span>Отчёт</span>
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
                                    $con_one = $db->query("SELECT DISTINCT us.id, us.dateBith, vs.route_id FROM operation op LEFT JOIN visit vs ON(vs.id=op.visit_id) LEFT JOIN users us ON(us.id=op.user_id) WHERE vs.completed IS NULL AND vs.accept_date IS NOT NULL")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('note/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('anesthetist/storage') ?>" class="nav-link legitRipple">
                                    <i class="icon-store"></i>
                                    <span>Склад</span>
                                    <?php
                                    $con_two = $db->query("SELECT id FROM storage_orders WHERE parent_id = {$_SESSION['session_id']}")->rowCount();
                                    if ($con_two) {
                                        ?>
                                        <span class="badge bg-indigo badge-pill ml-auto"><?=$con_two?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= viv('archive/all/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-archive"></i>
                                    <span>Архив</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
                                    <span>Отчёт</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 12:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('physio/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2 "></i>
                                    <span>Амбулаторные пациенты</span>
                                    <?php
                                    $con_two = $db->query("SELECT DISTINCT us.id, us.dateBith, vs.priced_date
											FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
											WHERE vs.completed IS NULL AND vs.direction IS NULL AND vs.physio IS NOT NULL AND vs.priced_date IS NOT NULL")->rowCount();
                                    if ($con_two) {
                                        ?>
                                        <span class="badge bg-blue badge-pill ml-auto"><?=$con_two?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('physio/list_stationary') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Стационарные пациенты</span>
                                    <?php
                                    $con_tree = $db->query("SELECT DISTINCT us.id, us.dateBith, vs.add_date
											FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
											WHERE vs.completed IS NULL AND vs.direction IS NOT NULL AND vs.physio IS NOT NULL AND vs.add_date IS NOT NULL ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_tree) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('archive/completed/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Завершёные пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('note/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= viv('archive/all/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-archive"></i>
                                    <span>Архив</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
                                    <span>Отчёт</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 13:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('manipulation/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-display"></i>
                                    <span>Рабочий стол</span>
                                    <?php
                                    $con_one = $db->query("SELECT DISTINCT us.id, vs.service_id  FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 1 AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('manipulation/list_outpatient') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2 "></i>
                                    <span>Амбулаторные пациенты</span>
                                    <?php
                                    $con_two = $db->query("SELECT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_two) {
                                        ?>
                                        <span class="badge bg-blue badge-pill ml-auto"><?=$con_two?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('manipulation/list_stationary') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Стационарные пациенты</span>
                                    <?php
                                    $con_tree = $db->query("SELECT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->rowCount();
                                    if ($con_tree) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('archive/completed/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Завершёные пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('note/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= viv('archive/all/list') ?>" class="nav-link legitRipple">
                                    <i class="icon-archive"></i>
                                    <span>Архив</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
                                    <span>Отчёт</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 32:
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
                            <li class="nav-item">
                                <a href="<?= viv('registry/guide') ?>" class="nav-link legitRipple">
                                    <i class="icon-width"></i>
                                    <span>Направители</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('cashbox/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-display"></i>
                                    <span>Приём платежей</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('cashbox/refund') ?>" class="nav-link legitRipple">
                                    <i class="icon-display"></i>
                                    <span>Возврат</span>
                                    <?php
                                    $con_one = $db->query("SELECT DISTINCT user_id 'id' FROM visit WHERE direction IS NULL AND status = 5 AND add_date")->rowCount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
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
                                <a href="<?= viv('note/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-collaboration"></i>
                                    <span>Заметки</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('archive/journal') ?>" class="nav-link legitRipple">
                                    <i class="icon-users2"></i>
                                    <span>Журнал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('reports/index') ?>" class="nav-link legitRipple">
                                    <i class="icon-stack-text"></i>
                                    <span>Отчёт</span>
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
