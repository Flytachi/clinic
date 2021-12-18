<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('cashbox/index') ?>" class="nav-link <?= viv_link('cashbox/index') ?> legitRipple">
            Приём платежей <span class="badge bg-danger ml-auto"><?= $db->query("SELECT DISTINCT vs.visit_id, v.client_id FROM visits v LEFT JOIN visit_services vs ON(vs.visit_id=v.id) LEFT JOIN clients c ON(c.id=v.client_id) WHERE v.branch_id = $session->branch AND v.direction IS NULL AND v.completed IS NULL AND vs.status = 1")->rowCount() ?></span>
        </a>
    </li>
    <?php if(module('stationar')): ?>
        <li class="nav-item">
            <a href="<?= viv('cashbox/stationary') ?>" class="nav-link <?= viv_link('cashbox/stationary') ?> legitRipple">
                Стационар <span class="badge bg-primary ml-auto"><?= $db->query("SELECT v.id, v.client_id FROM visits v LEFT JOIN clients c ON(c.id=v.client_id) WHERE v.branch_id = $session->branch AND v.direction IS NOT NULL AND v.completed IS NULL")->rowCount() ?></span>
            </a>
        </li>
    <?php endif; ?>
</ul>
