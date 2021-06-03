<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('cashbox/index') ?>" class="nav-link <?= viv_link('cashbox/index') ?> legitRipple">
            Приём платежей <span class="badge bg-danger ml-auto"><?= $db->query("SELECT DISTINCT vss.visit_id, vs.user_id FROM visits vs LEFT JOIN visit_services vss ON(vss.visit_id=vs.id) LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 1")->rowCount() ?></span>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('cashbox/stationary') ?>" class="nav-link <?= viv_link('cashbox/stationary') ?> legitRipple">Стационар</a>
    </li>
</ul>
