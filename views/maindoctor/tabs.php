<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('maindoctor/stationary_current') ?>" class="nav-link <?= (viv('maindoctor/stationary_current')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Текущие</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('maindoctor/stationary_completed') ?>" class="nav-link <?= (viv('maindoctor/stationary_completed')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Завершёные</a>
    </li>
</ul>
