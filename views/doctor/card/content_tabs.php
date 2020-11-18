<ul class="nav nav-tabs nav-tabs-highlight">
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_1') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_1')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Осмотр <i class="icon-repo-forked ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_2') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_2')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Другие визиты <i class="icon-users4 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_3') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_3')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Назначеные визиты <i class="icon-add ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_4') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_4')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Визиты <i class="icon-spinner11 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_5') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_5')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Анализы<i class="icon-droplets ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_6') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_6')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" >Переписка <i class="icon-bubbles2 ml-3"></i> </a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_7') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_7')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" >Заметки </a>
    </li>
    <?php
    if ($patient->direction) {
        ?>
        <li class="nav-item">
            <a href="<?= viv('doctor/card/content_8') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_8')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Обход<i class="icon-magazine ml-3"></i></a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('doctor/card/content_9') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_9')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Койка<i class="icon-magazine ml-3"></i></a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('doctor/card/content_10') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_10')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Состаяние<i class="icon-magazine ml-3"></i></a>
        </li>
        <?php
    }
    ?>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_11') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_11')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" >POS_даные </a>
    </li>
</ul>
