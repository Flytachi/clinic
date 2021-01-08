<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_1') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_1')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Обход</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_2') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_2')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Лист назначений</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_3') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_3')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">История пациента</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_4') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_4')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Анализы</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_5') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_5')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Блюда</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_6') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_6')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Состаение</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_7') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_7')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Расходные материалы</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('nurce/card/content_8') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('nurce/card/content_8')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Операционный блок</a>
    </li>
</ul>

<?php
if($_SESSION['message']){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
