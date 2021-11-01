<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('cashbox/refund') ?>" class="nav-link <?= viv_link('cashbox/refund') ?> legitRipple">
            Возврат <span class="badge bg-danger ml-auto"><?= $db->query("SELECT DISTINCT vs.visit_id, v.client_id FROM visits v LEFT JOIN visit_services vs ON(vs.visit_id=v.id) LEFT JOIN clients c ON(c.id=vs.client_id) WHERE v.branch_id = $session->branch AND v.direction IS NULL AND v.completed IS NULL AND vs.status = 5")->rowCount() ?></span>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('cashbox/services_not_accepted') ?>" class="nav-link <?= viv_link('cashbox/services_not_accepted') ?> legitRipple">Не принятые услуги</a>
    </li>
</ul>
