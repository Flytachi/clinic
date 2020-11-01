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
                    <h6 id="timeSession" class="font-size-lg text-white">00:00:00</h6>
                    <div id="sessionButton"><button class="btn bg-teal legitRipple" onclick="setTime()" type="button">Открыть сессию</button></div>
                </div>
                                            
<<<<<<< HEAD
                <div class="sidebar-user-material-footer" >
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>Сессия открыто</span></a>
=======
                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>Мой профиль</span></a>
>>>>>>> 2fc041ca15bc27e5a4e9820baf21f34831d62105
                </div>
            </div>

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
        </div>
        <!-- /user menu -->


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
                        <li class="nav-item">
                            <a href="#" class="nav-link legitRipple">
                                <i class="icon-tree6"></i>
                                <span>Услуги</span>
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
                        <?php
                    }
                    ?>
                
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link legitRipple"><i class="icon-copy"></i> <span>Layouts</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item"><a href="index.html" class="nav-link active legitRipple">Default layout</a></li>
                        <li class="nav-item"><a href="index.html" class="nav-link legitRipple">Layout 2</a></li>
                        <li class="nav-item"><a href="index.html" class="nav-link legitRipple">Layout 3</a></li>
                        <li class="nav-item"><a href="index.html" class="nav-link legitRipple">Layout 4</a></li>
                        <li class="nav-item"><a href="index.html" class="nav-link legitRipple">Layout 5</a></li>
                        <li class="nav-item"><a href="index.html" class="nav-link disabled">Layout 6 <span class="badge bg-transparent align-self-center ml-auto">Coming soon</span></a></li>
                    </ul>
                </li>
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

    <script src="../vendors/js/cookie.js"></script>

    <script src="../vendors/js/Timer.js"></script>
    <!-- /sidebar content -->
    
</div>