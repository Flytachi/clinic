<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('cashbox/index') ?>" class="nav-link <?= (viv('cashbox/index')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Приём платежей</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('cashbox/stationary') ?>" class="nav-link <?= (viv('cashbox/stationary')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Стационар</a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('cashbox/debtor') ?>" class="nav-link <?= (viv('cashbox/debtor')== $_SERVER['PHP_SELF']) ? "active": "" ?> legitRipple">Должники</a>
    </li>
</ul>
