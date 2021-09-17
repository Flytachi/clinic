<div class="<?= $classes['navbar'] ?>"> <!-- fixed-top -->

    <!-- <a href="index.php" class="d-inline-block">
        <img width="50" height="50" src="<?= stack("assets/images/logo.png") ?>" alt="">
    </a> -->
    <!-- <div class="navbar-brand">

    </div> -->

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

        <span class="ml-md-3 siya-long" id="timedisplay"></span>

        <ul class="navbar-nav ml-md-auto">
            <li class="nav-item">
                <a href="<?= $session->logout_link() ?>" class="navbar-nav-link">
                    <i class="icon-switch2"></i>
                    <span class="d-md-none ml-2">Выход</span>
                </a>
            </li>
        </ul>

    </div>
</div>
