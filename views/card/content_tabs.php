<?php include "content_tabs-old.php"; ?>
<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <?php if ( $activity ): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-1').$agr ?>" class="nav-link <?= viv_link('card/content-1') ?> legitRipple" style="white-space:nowrap;">
                <i class="icon-repo-forked mr-1"></i>
                <?php if ($patient->direction): ?>
                    <?php if (is_grant()): ?>
                        Обход
                    <?php else: ?>
                        Осмотр
                    <?php endif; ?>
                <?php else: ?>
                    Осмотр
                <?php endif; ?>
            </a>
        </li>
    <?php endif; ?>
    <?php if ( !$activity and $patient->direction ): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-2').$agr ?>" class="nav-link <?= viv_link('card/content-2') ?> legitRipple" style="white-space:nowrap;"><i class="icon-archive mr-1"></i>Услуги</a>
        </li>
    <?php endif; ?>
    <?php if ( $activity and $patient->direction and !permission(11)): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-3').$agr ?>" class="nav-link <?= viv_link('card/content-3') ?> legitRipple" style="white-space:nowrap;"><i class="icon-archive mr-1"></i>Другие визиты</a>
        </li>
    <?php endif; ?>
    <?php if ( ($activity or !$patient->direction) and !permission(11) ): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-4').$agr ?>" class="nav-link <?= viv_link('card/content-4') ?> legitRipple" style="white-space:nowrap;"><i class="icon-clipboard6 mr-1"></i>Другие услуги</a>
        </li>
    <?php endif; ?>
    <?php if ( ($activity or !$patient->direction) and !permission(11) ): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-5').$agr ?>" class="nav-link <?= viv_link('card/content-5') ?> legitRipple" style="white-space:nowrap;"><i class="icon-add mr-1"></i>Назначенные услуги</a>
        </li>
    <?php endif; ?>
    <?php if ( !$activity and !$patient->direction ): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-6').$agr ?>" class="nav-link <?= viv_link('card/content-6') ?> legitRipple" style="white-space:nowrap;"><i class="icon-vcard mr-1"></i>Мои заключения</a>
        </li>
    <?php endif; ?>
    <?php if(module('module_laboratory')): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-7').$agr ?>" class="nav-link <?= viv_link('card/content-7') ?> legitRipple" style="white-space:nowrap;"><i class="icon-fire2 mr-1"></i>Анализы</a>
        </li>
    <?php endif; ?>
    <?php if(module('module_diagnostic')): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-8').$agr ?>" class="nav-link <?= viv_link('card/content-8') ?> legitRipple" style="white-space:nowrap;"><i class="icon-pulse2 mr-1"></i>Диагностика</a>
        </li>
    <?php endif; ?>
    <?php if(module('module_bypass')): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-9').$agr ?>" class="nav-link <?= viv_link('card/content-9') ?> legitRipple" style="white-space:nowrap;"><i class="icon-magazine mr-1"></i>Лист назначений</a>
        </li>
    <?php endif; ?>
    <?php if(module('module_physio') and !permission(11)): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-10').$agr ?>" class="nav-link <?= viv_link('card/content-10') ?> legitRipple" style="white-space:nowrap;"><i class="icon-googleplus5 mr-1"></i>Физиотерапия</a>
        </li>
    <?php endif; ?>
    <?php if(!permission(11)): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-11').$agr ?>" class="nav-link <?= viv_link('card/content-11') ?> legitRipple" style="white-space:nowrap;"><i class="icon-files-empty mr-1"></i>Документы</a>
        </li>
    <?php endif; ?>
    <?php if($patient->direction): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-12').$agr ?>" class="nav-link <?= viv_link('card/content-12') ?> legitRipple" style="white-space:nowrap;"><i class="icon-clipboard2 mr-1"></i>Состояние</a>
        </li>
        <li class="nav-item">
            <a href="<?= viv('card/content-13').$agr ?>" class="nav-link <?= viv_link('card/content-13') ?> legitRipple" style="white-space:nowrap;"><i class="icon-bed2 mr-1"></i>Операционный блок</a>
        </li>
    <?php endif; ?>

    <?php if(module('module_pharmacy')): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-15').$agr ?>" class="nav-link <?= viv_link('card/content-15') ?> legitRipple" style="white-space:nowrap;"><i class="icon-puzzle3 mr-1"></i>Расходные материалы</a>
        </li>
    <?php endif; ?>

    <?php if( !$activity and $patient->direction ): ?>
        <li class="nav-item">
            <a href="<?= viv('card/content-16').$agr ?>" class="nav-link <?= viv_link('card/content-16') ?> legitRipple" style="white-space:nowrap;"><i class="icon-calculator3 mr-1"></i>Расходы</a>
        </li>
    <?php endif; ?>

    
</ul>

<?php
if( isset($_SESSION['message']) ){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
