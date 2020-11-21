<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">
    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="sidebar-user-material-body">

                <div class="sidebar-user-material-footer" >
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>Мой профиль</span></a>
                </div>

            </div>
            <!-- /user menu -->

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">

                    <!-- <li class="nav-item">
                        <a href="index.php" class="nav-link">
                            <i class="icon-users"></i>
                            <span>Персонал</span>
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
                                    <a href="<?= viv('admin/bed') ?>" class="nav-link legitRipple">
                                        <i class="icon-bed2"></i>
                                        <span>Койки</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= viv('admin/service') ?>" class="nav-link legitRipple">
                                        <i class="icon-bed2"></i>
                                        <span>Услуги</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= viv('admin/analyze') ?>" class="nav-link legitRipple">
                                        <i class="icon-bed2"></i>
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
                                    <a href="<?= viv('cashbox/history') ?>" class="nav-link legitRipple">
                                        <i class="icon-display"></i>
                                        <span>История</span>
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
                                        $con_one = $db->query('SELECT id FROM visit WHERE completed IS NULL AND status = 1 AND parent_id = '.$_SESSION['session_id'])->rowCount();
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
                                        $con_two = $db->query('SELECT id FROM visit WHERE completed IS NULL AND status = 2 AND direction IS NULL AND parent_id = '.$_SESSION['session_id'])->rowCount();
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
                                        $con_tree = $db->query('SELECT id FROM visit WHERE completed IS NULL AND status = 2 AND direction IS NOT NULL AND parent_id = '.$_SESSION['session_id'])->rowCount();
                                        if ($con_tree) {
                                            ?>
                                            <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="<?= viv('doctor/list_surgical') ?>" class="nav-link legitRipple">
                                        <i class="icon-collaboration"></i>
                                        <span>Операционные пациенты</span>
                                    </a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="<?= viv('doctor/list_completed') ?>" class="nav-link legitRipple">
                                        <i class="icon-collaboration"></i>
                                        <span>Завершёные пациенты</span>
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
                                        $con_one = $db->query('SELECT id FROM visit WHERE completed IS NULL AND status = 1 AND parent_id = '.$_SESSION['session_id'])->rowCount();
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
                                        $con_two = $db->query('SELECT id FROM visit WHERE completed IS NULL AND status = 2 AND direction IS NULL AND parent_id = '.$_SESSION['session_id'])->rowCount();
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
                                        $con_tree = $db->query('SELECT id FROM visit WHERE completed IS NULL AND status = 2 AND direction IS NOT NULL AND parent_id = '.$_SESSION['session_id'])->rowCount();
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
</div>
