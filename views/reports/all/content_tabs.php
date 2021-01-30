<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('reports/all/content_1') ?>" class="nav-link <?= (viv('reports/all/content_1')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Услуги</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('reports/all/content_2') ?>" class="nav-link <?= (viv('reports/all/content_2')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Врачи</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('reports/all/content_3') ?>" class="nav-link <?= (viv('reports/all/content_3')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Визиты</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('reports/all/content_4') ?>" class="nav-link <?= (viv('reports/all/content_4')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Направители</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('reports/all/content_5') ?>" class="nav-link <?= (viv('reports/all/content_5')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Операционные услуги</a>
    </li>
</ul>


<script src="<?= stack('global_assets/js/plugins/pickers/daterangepicker.js') ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/bootstrap_multiselect.js") ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/anytime.min.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.date.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.time.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/legacy.js') ?>"></script>

<script src="<?= stack('global_assets/js/demo_pages/picker_date.js') ?>"></script>

<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>
<script src="<?= stack('global_assets/js/demo_pages/form_multiselect.js') ?>"></script>