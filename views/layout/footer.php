<div class="<?= $classes['footer'] ?>">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Footer
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-footer">
        <span class="navbar-text">
            &copy; 2021. <span class="text-primary">Version 2</span>
        </span>

        <ul class="navbar-nav ml-lg-auto">
            <li class="nav-item">
                <a href="http://med24line.uz/" target="_blank" class="navbar-nav-link font-weight-semibold"><span class="text-pink-400"><?= showTitle() ?>.uz</span></a>
            </li>
        </ul>
    </div>
    
    <?php debugPanel() ?>
</div>
