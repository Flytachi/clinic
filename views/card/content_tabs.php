<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('card/content_1').$agr ?>" class="nav-link <?= (viv('card/content_1')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">
            <i class="icon-repo-forked mr-1"></i>
            <?php if (permission([5])): ?>
                <?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
                    Обход
                <?php else: ?>
                    Осмотр
                <?php endif; ?>
            <?php else: ?>
                Обход
            <?php endif; ?>
        </a>
    </li>
    <?php if (permission([5])): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content_2').$agr ?>" class="nav-link <?= (viv('card/content_2')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Другие визиты</a>
        </li>
    <?php endif; ?>
    <li class="nav-item">
        <a href="<?= viv('card/content_3').$agr ?>" class="nav-link <?= (viv('card/content_3')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-add mr-1"></i>Назначенные визиты</a>
    </li>
    <?php if (permission([5])): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content_4').$agr ?>" class="nav-link <?= (viv('card/content_4')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Визиты</a>
        </li>
    <?php endif; ?>
    <li class="nav-item">
        <a href="<?= viv('card/content_5').$agr ?>" class="nav-link <?= (viv('card/content_5')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-fire2 mr-1"></i>Анализы</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('card/content_6').$agr ?>" class="nav-link <?= (viv('card/content_6')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-pulse2 mr-1"></i>Диагностика</a>
    </li>
    <?php if ($patient->direction): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content_7').$agr ?>" class="nav-link <?= (viv('card/content_7')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-magazine mr-1"></i>Лист назначений</a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('card/content_8').$agr ?>" class="nav-link <?= (viv('card/content_8')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-clipboard2 mr-1"></i>Состояние</a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('card/content_9').$agr ?>" class="nav-link <?= (viv('card/content_9')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-bed2 mr-1"></i>Операционный блок</a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('card/content_10').$agr ?>" class="nav-link <?= (viv('card/content_10')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-fire mr-1"></i>Анестезия</a>
        </li>
    <?php endif; ?>
    <li class="nav-item">
        <a href="<?= viv('card/content_11').$agr ?>" class="nav-link <?= (viv('card/content_11')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;"><i class="icon-pulse2 mr-1"></i>Физиотерапия/Процедурная</a>
    </li>
    <?php if (permission([7])): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content_12').$agr ?>" class="nav-link <?= (viv('card/content_12')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple" style="white-space:nowrap;">Расходные материалы</a>
        </li>
    <?php endif; ?>
</ul>

<?php
if($_SESSION['message']){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
