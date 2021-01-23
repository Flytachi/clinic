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
<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('anesthetist/card/content_1') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('anesthetist/card/content_1')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">
            <i class="icon-repo-forked mr-1"></i>
            <?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
                Обход
            <?php else: ?>
                Осмотр
            <?php endif; ?>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('anesthetist/card/content_2') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('anesthetist/card/content_2')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Другие визиты</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('anesthetist/card/content_3') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('anesthetist/card/content_3')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-add mr-1"></i>Назначеные визиты</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('anesthetist/card/content_4') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('anesthetist/card/content_4')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Визиты</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('anesthetist/card/content_5') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('anesthetist/card/content_5')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-fire2 mr-1"></i>Анализы</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('anesthetist/card/content_6') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('anesthetist/card/content_6')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-pulse2 mr-1"></i>Диагностика</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('anesthetist/card/content_7') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('anesthetist/card/content_7')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-magazine mr-1"></i>Лист назначений</a>
    </li>
    <?php if ($patient->direction): ?>
        <li class="nav-item">
            <a href="<?= viv('anesthetist/card/content_8') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('anesthetist/card/content_8')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-clipboard2 mr-1"></i>Состаяние</a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('anesthetist/card/content_9') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('anesthetist/card/content_9')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-bed2 mr-1"></i>Операционный блок</a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('anesthetist/card/content_10') ?>?id=<?= $_GET['id'] ?>" class="nav-link <?= (viv('anesthetist/card/content_10')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-fire mr-1"></i>Анестезия</a>
        </li>
    <?php endif; ?>
</ul>

<?php
if($_SESSION['message']){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
