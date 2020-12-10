<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

<?php
    $id = $_SESSION['session_id'];

    $sql = "SELECT COUNT(*) FROM chat WHERE id_pull = \"$id\"AND `activity` = 0";

    $count = $db->query($sql)->fetchColumn();

    $count = $count == 0 ? '' : "<span class=\"badge bg-danger badge-pill ml-auto\">$count</span>";

?>
<ul class="nav nav-tabs nav-tabs-highlight">
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_1') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_1')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Осмотр<i class="icon-repo-forked ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_2') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_2')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Другие визиты<i class="icon-users4 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_3') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_3')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Назначеные визиты<i class="icon-add ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_4') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_4')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Визиты<i class="icon-spinner11 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_5') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_5')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Анализы<i class="icon-fire2 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_6') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_6')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" >Диагностика<i class="icon-pulse2 ml-3"></i></a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_7') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_7')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" >Переписка<b id="noticeus"><?= $count ?></b> <i class="icon-bubbles2 ml-3"></i></a>
    </li>
    <?php
    if ($patient->direction) {
        ?>
        <li class="nav-item">
            <a href="<?= viv('doctor/card/content_8') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_8')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Обход<i class="icon-magazine ml-3"></i></a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('doctor/card/content_9') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_9')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" >Состаяние<i class="icon-clipboard2 ml-3"></i></a>
        </li>
        <?php
    }
    ?>
    <li class="nav-item">
        <a href="<?= viv('doctor/card/content_10') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('doctor/card/content_10')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Заметки<i class="icon-clipboard3 ml-3"></i></a>
    </li>
</ul>
<!-- /footer -->
