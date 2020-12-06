<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">
    <!-- sidebar content -->
    <div class="sidebar-content">

        <!-- user menu -->
        <div class="sidebar-user-material">
            <div class="sidebar-user-material-body">
                <div class="card-body text-center">
                    <h4 class="mb-0 text-white text-shadow-dark siya"><?= get_full_name() ?></h4>
                    <span class="font-size-sm text-white text-shadow-dark siya"><?= level_name() ." ". division_name() ?></span>
                </div>

                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>my account</span></a>
                </div>
            </div>

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-user-plus"></i>
                            <span>my profile</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-coins"></i>
                            <span>my balance</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-comment-discussion"></i>
                            <span>messages</span>
                            <span class="badge bg-teal-400 badge-pill align-self-center ml-auto">58</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-cog5"></i>
                            <span>account settings</span>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a href="<?= logout() ?>" class="nav-link">
                            <i class="icon-switch2"></i>
                            <span>logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->

        <!-- main navigation -->
        <div class="card card-sidebar-mobile">

            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">рабочий стол</div> <i class="icon-menu" title="main"></i></li>

                    <?php
                    switch (level()):
                        case 1:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('admin/index') ?>" class="nav-link legitripple">
                                    <i class="icon-users"></i>
                                    <span>персонал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/division') ?>" class="nav-link legitripple">
                                    <i class="icon-users"></i>
                                    <span>класификация персонала</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/ward') ?>" class="nav-link legitripple">
                                    <i class="icon-switch22"></i>
                                    <span>палаты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/bed') ?>" class="nav-link legitripple">
                                    <i class="icon-bed2"></i>
                                    <span>койки</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/service') ?>" class="nav-link legitripple">
                                    <i class="icon-bag"></i>
                                    <span>услуги</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('admin/analyze') ?>" class="nav-link legitripple">
                                    <i class="icon-fire"></i>
                                    <span>анализы</span>
                                </a>
                            </li>
                            <!--<li class="nav-item">
                                <a href="#" class="nav-link legitripple">
                                    <i class="icon-store"></i>
                                    <span>пакеты</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="<?= viv('admin/storage') ?>" class="nav-link legitripple">
                                    <i class="icon-width"></i>
                                    <span>склад</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 2:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('registry/index') ?>" class="nav-link">
                                    <i class="icon-display"></i>
                                    <span>рабочий стол</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('registry/list_patient') ?>" class="nav-link">
                                    <i class="icon-users"></i>
                                    <span>список пациентов</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 3:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('cashbox/index') ?>" class="nav-link legitripple">
                                    <i class="icon-display"></i>
                                    <span>приём платежей</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('cashbox/list_payment') ?>" class="nav-link legitripple">
                                    <i class="icon-display"></i>
                                    <span>история платежей</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('cashbox/list_investment') ?>" class="nav-link legitripple">
                                    <i class="icon-display"></i>
                                    <span>инвестиции</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 4:
                            ?>
                            <li class="nav-item">
                                <a href="sales.php?id=cash&invoice" class="nav-link legitripple">
                                    <i class="icon-users"></i>
                                    <span>продажа</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="products.php" class="nav-link legitripple">
                                    <i class="icon-users"></i>
                                    <span>препараты (товары)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="customer.php" class="nav-link legitripple">
                                    <i class="icon-bed2"></i>
                                    <span>клиенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="supplier.php" class="nav-link legitripple">
                                    <i class="icon-bed2"></i>
                                    <span>поставщики</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#" class="nav-link legitripple">
                                    <i class="icon-bed2"></i>
                                    <span>отчет продаж</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="sales_inventory.php" class="nav-link legitripple">
                                    <i class="icon-width"></i>
                                    <span>инвентаризация продаж</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="all_prep.php" class="nav-link legitripple">
                                    <i class="icon-width"></i>
                                    <span>все наименования</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 5:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('doctor/index') ?>" class="nav-link legitripple">
                                    <i class="icon-user-plus"></i>
                                    <span>принять пациентов</span>
                                    <?php
                                    $con_one = $db->query("select distinct us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 1 and vs.parent_id = {$_session['session_id']} order by vs.add_date asc")->rowcount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('doctor/list_outpatient') ?>" class="nav-link legitripple">
                                    <i class="icon-users2 "></i>
                                    <span>амбулаторные пациенты</span>
                                    <?php
                                    $con_two = $db->query("select distinct us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 2 and vs.direction is null and vs.parent_id = {$_session['session_id']} order by vs.add_date asc")->rowcount();
                                    if ($con_two) {
                                        ?>
                                        <span class="badge bg-blue badge-pill ml-auto"><?=$con_two?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('doctor/list_stationary') ?>" class="nav-link legitripple">
                                    <i class="icon-users2"></i>
                                    <span>стационарные пациенты</span>
                                    <?php
                                    $con_tree = $db->query("select distinct us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 2 and vs.direction is not null and vs.parent_id = {$_session['session_id']} order by vs.add_date asc")->rowcount();
                                    if ($con_tree) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="<?= viv('doctor/list_surgical') ?>" class="nav-link legitripple">
                                    <i class="icon-collaboration"></i>
                                    <span>операционные пациенты</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="<?= viv('doctor/list_completed') ?>" class="nav-link legitripple">
                                    <i class="icon-collaboration"></i>
                                    <span>завершёные пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('maindoctor/list_all') ?>" class="nav-link legitripple">
                                    <i class="icon-collaboration"></i>
                                    <span>все пациенты</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 6:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('laboratory/index') ?>" class="nav-link legitripple">
                                    <i class="icon-display"></i>
                                    <span>рабочий стол</span>
                                    <?php
                                    $con_one = $db->query("select us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 1 and vs.parent_id = {$_session['session_id']} order by vs.add_date asc")->rowcount();
                                    if ($con_one) {
                                        ?>
                                        <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('laboratory/list_outpatient') ?>" class="nav-link legitripple">
                                    <i class="icon-users2 "></i>
                                    <span>амбулаторные пациенты</span>
                                    <?php
                                    $con_two = $db->query("select distinct us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 2 and vs.direction is null and vs.parent_id = {$_session['session_id']} order by vs.add_date asc")->rowcount();
                                    if ($con_two) {
                                        ?>
                                        <span class="badge bg-blue badge-pill ml-auto"><?=$con_two?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('laboratory/list_stationary') ?>" class="nav-link legitripple">
                                    <i class="icon-users2"></i>
                                    <span>стационарные пациенты</span>
                                    <?php
                                    $con_tree = $db->query("select distinct us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 2 and vs.direction is not null and vs.parent_id = {$_session['session_id']} order by vs.add_date asc")->rowcount();
                                    if ($con_tree) {
                                        ?>
                                        <span class="badge bg-green badge-pill ml-auto"><?=$con_tree?></span>
                                        <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('laboratory/list_completed') ?>" class="nav-link legitripple">
                                    <i class="icon-collaboration"></i>
                                    <span>завершёные пациенты</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 7:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('nurce/index') ?>" class="nav-link legitripple">
                                    <i class="icon-users2"></i>
                                    <span>стационарные пациенты</span>
                                    <?php
                                    $con_one = $db->query("select id from beds where user_id is not null")->rowcount();
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
                        case 8:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('maindoctor/index') ?>" class="nav-link">
                                    <i class="icon-display"></i>
                                    <span>рабочий стол</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('maindoctor/list_all') ?>" class="nav-link legitripple">
                                    <i class="icon-collaboration"></i>
                                    <span>все пациенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= viv('maindoctor/reports/content_1') ?>" class="nav-link legitripple">
                                    <i class="icon-collaboration"></i>
                                    <span>отчёт</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 9:
                            ?>
                            <li class="nav-item">
                                <a href="<?= viv('coock/index') ?>" class="nav-link">
                                    <i class="icon-display"></i>
                                    <span>рабочий стол</span>
                                </a>
                            </li>
                            <?php
                            break;
                        case 10:
                            ?>
                            <?php if (division_assist() == 1): ?>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/index') ?>" class="nav-link legitripple">
                                        <i class="icon-display"></i>
                                        <span>рабочий стол</span>
                                        <?php
                                        $con_one = $db->query("select us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 1 and vs.parent_id = {$_session['session_id']} order by vs.add_date asc")->rowcount();
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
                                    <a href="<?= viv('diagnostic/list_outpatient') ?>" class="nav-link legitripple">
                                        <i class="icon-users2 "></i>
                                        <span>амбулаторные пациенты</span>
                                        <?php
                                        $con_two = $db->query("select distinct us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 2 and vs.direction is null and vs.assist_id is not null order by vs.add_date asc")->rowcount();
                                        if ($con_two) {
                                            ?>
                                            <span class="badge bg-blue badge-pill ml-auto"><?=$con_two?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/list_stationary') ?>" class="nav-link legitripple">
                                        <i class="icon-users2"></i>
                                        <span>стационарные пациенты</span>
                                        <?php
                                        $con_tree = $db->query("select distinct us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 2 and vs.direction is not null and vs.assist_id is not null order by vs.add_date asc")->rowcount();
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
                                    <a href="<?= viv('diagnostic/index') ?>" class="nav-link legitripple">
                                        <i class="icon-display"></i>
                                        <span>рабочий стол</span>
                                        <?php
                                        $con_one = $db->query("select us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 1 and vs.parent_id = {$_session['session_id']} order by vs.add_date asc")->rowcount();
                                        if ($con_one) {
                                            ?>
                                            <span class="badge bg-danger badge-pill ml-auto"><?=$con_one?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/list_outpatient') ?>" class="nav-link legitripple">
                                        <i class="icon-users2 "></i>
                                        <span>амбулаторные пациенты</span>
                                        <?php
                                        $con_two = $db->query("select distinct us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 2 and vs.direction is null and vs.parent_id = {$_session['session_id']} order by vs.add_date asc")->rowcount();
                                        if ($con_two) {
                                            ?>
                                            <span class="badge bg-blue badge-pill ml-auto"><?=$con_two?></span>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= viv('diagnostic/list_stationary') ?>" class="nav-link legitripple">
                                        <i class="icon-users2"></i>
                                        <span>стационарные пациенты</span>
                                        <?php
                                        $con_tree = $db->query("select distinct us.id from users us left join visit vs on(us.id=vs.user_id) where vs.completed is null and vs.status = 2 and vs.direction is not null and vs.parent_id = {$_session['session_id']} order by vs.add_date asc")->rowcount();
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
                                <a href="<?= viv('diagnostic/list_completed') ?>" class="nav-link legitripple">
                                    <i class="icon-collaboration"></i>
                                    <span>завершёные пациенты</span>
                                </a>
                            </li>
                            <?php
                    endswitch;
                    ?>

                <!-- <li class="nav-item">
                    <a href="test.php" class="nav-link legitripple">
                        <i class="icon-width"></i>
                        <span>tests</span>
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
