<div class="navbar navbar-expand-md navbar-dark bg-info navbar-static">
    <div class="navbar-brand">
        <a href="index.php" class="d-inline-block">
            <img src="<?= stack("global_assets/images/logo_5.png") ?>" style="height: 2rem !important;" alt="">
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

        <span class=" ml-md-3">
            <span class="siya"><?= get_full_name() ." - ". level_name() ." ". division_name() ?></span>
        </span>



        <ul class="navbar-nav ml-md-auto">
            <li class="nav-item">
                <a href="<?= logout() ?>" class="navbar-nav-link">
                    <i class="icon-switch2"></i>
                    <span class="d-md-none ml-2">Logout</span>
                </a>
            </li>
        </ul>

    </div>
</div>
