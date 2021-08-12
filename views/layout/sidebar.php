<div class="<?= $classes['sidebar'] ?>">
    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="<?= ($session->status) ? "sidebar-master-material-body" : "sidebar-myuser-material-body";  ?>">
                <div class="card-body text-center">
                    <h4 class="mb-0 text-white text-shadow-dark"><?= get_full_name() ?></h4>
                    <span class="font-size-sm text-white text-shadow-dark"><?= level_name() ." ". division_name() ?></span>
                </div>

                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>My account</span></a>
                </div>
            </div>

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">
                    
                    <?php foreach ($session->get_accounts() as $acc): ?>
                        <li class="nav-item">
                            <a href="<?= DIR."/auth/recheck".EXT ?>?slot=<?= $acc['id'] ?>" class="nav-link">
                                <i class="icon-user"></i>
                                <span><?= $acc['username'] ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>

                    <?php if ( isset($session->status) ): ?>
                        <li class="nav-item">
                            <a href="<?= $session->logout_avatar_link($session->status) ?>" class="nav-link">
                                <i class="icon-arrow-down16"></i>
                                <span>Logout in avatar</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (config("package") and permission(5)): ?>
                        <li class="nav-item">
                            <a href="<?= viv('doctor/package') ?>" class="nav-link legitRipple">
                                <i class="icon-bag"></i>
                                <span>Пакеты<span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (config("template") and permission([5,10])): ?>
                        <li class="nav-item">
                            <a href="<?= viv('doctor/template') ?>" class="nav-link legitRipple">
                                <i class="icon-users"></i>
                                <span>Шаблоны</span>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
        <!-- /user menu -->
        
        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">

            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Рабочий стол</div> <i class="icon-menu" title="Main"></i></li>

                <?php foreach ($db->query("SELECT * FROM sidebar WHERE parent_id IS NULL AND level = $session->session_level ORDER BY sort ASC") as $row): ?>
                    
                    <?php if (!$row['is_division'] or ($row['is_division'] and str_split($row['is_division'])[intval(division_assist())]) ): ?>

                        <?php if($row['is_parent']): ?>

                            <?php if(is_null($row['module']) or ($row['module'] and module($row['module']))): ?>
                                <li class="nav-item nav-item-submenu <?= viv_link(json_decode($row['is_active']), 'nav-item-expanded nav-item-open') ?>">
                                    <a href="#" class="nav-link legitRipple"><i class="<?= $row['icon'] ?>"></i> <span><?= $row['name'] ?></span></a>

                                    <ul class="nav nav-group-sub" data-submenu-title="<?= $row['name'] ?>">

                                        <?php foreach ($db->query("SELECT * FROM sidebar WHERE parent_id = {$row['is_parent']} ORDER BY sort ASC") as $subrow): ?>
                                            <?php if(is_null($subrow['module']) or ($subrow['module'] and module($subrow['module']))): ?>
                                                <li class="nav-item"><a href="<?= viv($subrow['route']) ?>" class="nav-link legitRipple <?= viv_link(json_decode($subrow['is_active'])) ?>"><?= $subrow['name'] ?></a></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                    </ul>
                                </li>
                            <?php endif; ?>
                            
                        <?php else: ?>

                            <?php if(is_null($row['module']) or ($row['module'] and module($row['module']))): ?>
                                <li class="nav-item">
                                    <a href="<?= viv($row['route']) ?>" class="nav-link legitRipple <?= viv_link(json_decode($row['is_active'])) ?>">
                                        <i class="<?= $row['icon'] ?>"></i>
                                        <span><?= $row['name'] ?></span>
                                        <?php if($row['script']): ?>
                                            <?php
                                            if ($row['script_item']) {
                                                $srt = (array) json_decode($row['script_item']);
                                                foreach ($srt as $key => $value) {
                                                    if ($key == "selector") {
                                                        if ($value == 0) {
                                                            $val[$key] = (division()) ? "AND vs.division_id = ".division() : null;
                                                        }
                                                        elseif ($value == 1) {
                                                            $val[$key] = (division_assist()) ? "OR vs.assist_id IS NOT NULL" : null;
                                                        }
                                                    }else {
                                                        $val[$key] = $session->{$value};
                                                    }
                                                }
                                                $new_script = str_replace(array_keys($srt), $val, $row['script']);
                                                unset($val);
                                                // dd($new_script);
                                            }
                                            ?>
                                            <?php $side = $db->query(($row['script_item']) ? $new_script : $row['script'])->rowCount() ?>
                                            <?php if($side): ?>
                                                <span class="<?= $row['badge_class'] ?>"><?= $side ?></span>
                                            <?php endif; ?>
                                            <?php unset($side); unset($new_script); ?>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                        <?php endif; ?>

                    <?php endif ?>
                    

                <?php endforeach; ?>

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
