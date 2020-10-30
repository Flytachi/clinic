<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">
    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="sidebar-user-material-body">
                <div class="card-body text-center">
                    <a href="#">
                        <img src="global_assets/images/placeholders/placeholder.jpg" class="img-fluid rounded-circle shadow-1 mb-3" width="80" height="80" alt="">
                    </a>
                    <h6 class="mb-0 text-white text-shadow-dark"><?= get_full_name() ?></h6>
                    <span class="font-size-sm text-white text-shadow-dark"><?= level_name() ?></span>
                </div>
                                            
                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>Сессия открыто</span></a>
                </div>
            </div>

            <div class="" id="user-nav">
                <ul class="nav nav-sidebar">

                    <?php
                    if(permission(1)){
                        ?>
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="icon-user-plus"></i>
                                <span>Персонал</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="inventory.php" class="nav-link">
                                <i class="icon-user-plus"></i>
                                <span>Инвентарь</span>
                            </a>
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
                        <li class="nav-item">
                            <a href="test.php" class="nav-link">
                                <i class="icon-cog5"></i>
                                <span>Test</span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    
                    <!-- <li class="nav-item">
                        <a href="auth/logout.php" class="nav-link">
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

            

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->
    
</div>