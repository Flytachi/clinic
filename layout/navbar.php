<div class="navbar navbar-expand-md navbar-dark bg-indigo navbar-static">
    <div class="navbar-brand">
        <a href="index.php" class="d-inline-block">
            <img src="global_assets/images/logo_light.png" alt="">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>

        <span class="navbar-text ml-md-3">
            <span class="badge badge-mark border-orange-300 mr-2"></span>
            <?= get_full_name() ?> - <?= level_name() ?>
        </span>



        <ul class="navbar-nav ml-md-auto">

            <?php
                if(permission(2)){
            ?>
            

            <li class="nav-item">
                <div id="sessionButton" style="margin-top: 5px;"><button class="btn bg-teal legitRipple" onclick="setTime()" type="button">Открыть сессию</button></div>
            </li>

            <li class="nav-item navbar-nav-link" >
                <h6 id="timeSession" class="font-size-lg">00:00:00</h6>
            </li>
        <?php } ?>

            <li class="nav-item">
                <a href="auth/logout.php" class="navbar-nav-link">
                    <i class="icon-switch2"></i>
                    <span class="d-md-none ml-2">Logout</span>
                </a>
            </li>
        </ul>

    </div>
</div>
