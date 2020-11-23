<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
    <li class="nav-item">
        <a href="<?= viv('maindoctor/reports/content_1') ?>" class="nav-link <?= (viv('maindoctor/reports/content_1')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Услуги</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('maindoctor/reports/content_2') ?>" class="nav-link <?= (viv('maindoctor/reports/content_2')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Врачи</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('maindoctor/reports/content_3') ?>" class="nav-link <?= (viv('maindoctor/reports/content_3')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Визиты</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('maindoctor/reports/content_4') ?>" class="nav-link <?= (viv('maindoctor/reports/content_4')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Отделы</a>
    </li>
</ul>

<script src="<?= stack('global_assets/js/plugins/ui/moment/moment.min.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/daterangepicker.js') ?>"></script>
<script src="<?= stack('global_assets/js/demo_pages/picker_date.js') ?>"></script>
