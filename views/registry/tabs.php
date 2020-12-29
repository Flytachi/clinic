<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('registry/index') ?>" class="nav-link <?= (viv('registry/index')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Регистрация</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('registry/outpatient') ?>" class="nav-link <?= (viv('registry/outpatient')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple" >Амбулаторная</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('registry/stationary') ?>" class="nav-link <?= (viv('registry/stationary')== $_SERVER['PHP_SELF']) ? "active show": "" ?> legitRipple">Стационарная</a>
    </li>
</ul>
