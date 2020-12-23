<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>
<ul class="nav nav-tabs nav-tabs-highlight">
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_1') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_1')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Обход<i class="icon-users4 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_2') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_2')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Лист назначений<i class="icon-users4 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_3') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_3')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">История пациента<i class="icon-nbsp ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_4') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_4')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Анализы<i class="icon-fire2 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_5') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_5')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Блюда<i class="icon-spinner11 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_6') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_6')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Состаение<i class="icon-bubble9 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_7') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_7')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" >Заметки<i class="icon-clipboard3 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_8') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_8')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" >Расходные материалы</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_9') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_9')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" >Операционный блок</a>
    </li>
</ul>
