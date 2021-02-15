<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('card/content_1').$agr ?>" class="nav-link <?= viv_link('card/content_1') ?> legitRipple" style="white-space:nowrap;">
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
            <a href="<?= viv('card/content_2').$agr ?>" class="nav-link <?= viv_link('card/content_2') ?> legitRipple" style="white-space:nowrap;">Другие визиты</a>
        </li>
    <?php endif; ?>
    <li class="nav-item">
        <a href="<?= viv('card/content_3').$agr ?>" class="nav-link <?= viv_link('card/content_3') ?> legitRipple" style="white-space:nowrap;"><i class="icon-add mr-1"></i>Назначенные визиты</a>
    </li>
    <?php if (permission([5])): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content_4').$agr ?>" class="nav-link <?= viv_link('card/content_4') ?> legitRipple" style="white-space:nowrap;">Визиты</a>
        </li>
    <?php endif; ?>
    <li class="nav-item">
        <a href="<?= viv('card/content_5').$agr ?>" class="nav-link <?= viv_link('card/content_5') ?> legitRipple" style="white-space:nowrap;"><i class="icon-fire2 mr-1"></i>Анализы</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('card/content_6').$agr ?>" class="nav-link <?= viv_link('card/content_6') ?> legitRipple" style="white-space:nowrap;"><i class="icon-pulse2 mr-1"></i>Диагностика</a>
    </li>
    <?php if ($patient->direction): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content_7').$agr ?>" class="nav-link <?= viv_link('card/content_7') ?> legitRipple" style="white-space:nowrap;"><i class="icon-magazine mr-1"></i>Лист назначений</a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('card/content_8').$agr ?>" class="nav-link <?= viv_link('card/content_8') ?> legitRipple" style="white-space:nowrap;"><i class="icon-clipboard2 mr-1"></i>Состояние</a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('card/content_9').$agr ?>" class="nav-link <?= viv_link('card/content_9') ?> legitRipple" style="white-space:nowrap;"><i class="icon-bed2 mr-1"></i>Операционный блок</a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('card/content_10').$agr ?>" class="nav-link <?= viv_link('card/content_10') ?> legitRipple" style="white-space:nowrap;"><i class="icon-fire mr-1"></i>Анестезия</a>
        </li>
    <?php endif; ?>
    <li class="nav-item">
        <a href="<?= viv('card/content_11').$agr ?>" class="nav-link <?= viv_link('card/content_11') ?> legitRipple" style="white-space:nowrap;"><i class="icon-pulse2 mr-1"></i>Физиотерапия/Процедурная</a>
    </li>
    <?php if (permission([7])): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content_12').$agr ?>" class="nav-link <?= viv_link('card/content_12') ?> legitRipple" style="white-space:nowrap;">Расходные материалы</a>
        </li>
    <?php endif; ?>
</ul>

<?php
if($_SESSION['message']){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
