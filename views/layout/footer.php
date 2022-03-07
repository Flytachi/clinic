<div class="<?= $classes['footer'] ?>">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Footer
        </button>
    </div>

    <?php if(isset(ini['GLOBAL_SETTING']['DEBUG']) and ini['GLOBAL_SETTING']['DEBUG']): ?>
        <?php $DEBUG_time_finish = microtime(true); $delta=round($DEBUG_time_finish-$DEBUG_time_start, 3); if ($delta < 0.001) $delta = 0.001; ?>
        
        <div class="navbar-collapse collapse" id="navbar-footer" style="background-color:black;">
            <span class="navbar-text text-white">
                <b>Memory:</b> <?= round(memory_get_usage()/1024/1024, 2) ?> mb / 
                <b>Time:</b> <?= $delta ?> sec 
            </span>

            <ul class="navbar-nav ml-lg-auto">
                <li class="nav-item navbar-nav-link" style="color: #ff0000;"><em><?= $session->browser ?? "None" ?></em></li>
                <li class="nav-item navbar-nav-link text-white"><b>Level: </b><?= $session->session_level ?? "None" ?></li>
                <li class="nav-item navbar-nav-link text-white"><b>Division: </b><?= $session->session_division ?? "None" ?></li>
            </ul>
        </div>
        <div id="warframe_debug-bar">
            <?php
               /*  dd("<b>Memory:</b> " . round(memory_get_usage()/1024/1024, 2) . " mb / <b>Time:</b> $delta secs");
                dd($_SERVER); */
            ?>
        </div>


    <?php else: ?>
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
    <?php endif; ?>
    
</div>