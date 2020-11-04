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
                        <a href="auth/logout.php" class="nav-link">
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
                        if(permission(1)){
                            ?>
                            <li class="nav-item">
                                <a href="index.php" class="nav-link legitRipple">
                                    <i class="icon-users"></i>
                                    <span>Персонал</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="inventory.php" class="nav-link legitRipple">
                                    <i class="icon-bed2"></i>
                                    <span>Койки</span>
                                </a>
                            </li>
                            <li class="nav-item nav-item-submenu">
                                <a href="#" class="nav-link legitRipple"><i class="icon-tree6"></i> <span>Услуги</span></a>
                                <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                                    <li class="nav-item"><a href="service.php" class="nav-link legitRipple">Услуги</a></li>
                                    <li class="nav-item"><a href="service_group.php" class="nav-link legitRipple">Группы</a></li>
                                    <li class="nav-item"><a href="service_category.php" class="nav-link legitRipple">Категории</a></li>
                                </ul>
                            </li>
                            <?php
                        }elseif (permission(2)) {
                            ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="icon-user-plus"></i>
                                    <span>Сегодня зарегистроваль</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="icon-coins"></i>
                                    <span>Отправили на консультацию</span>
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
                            </li>
                            <?php
                        }
                        ?>

                    <li class="nav-item">
                        <a href="test.php" class="nav-link legitRipple">
                            <i class="icon-width"></i>
                            <span>Tests</span>
                            <span class="badge bg-blue-400 align-self-center ml-auto">2.0</span>
                        </a>
                    </li>
                    <!-- /main -->
                </ul>

            </div>
            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
</div>
