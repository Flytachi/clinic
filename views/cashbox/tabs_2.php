<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item">
        <a href="<?= viv('cashbox/refund') ?>" class="nav-link <?= viv_link('cashbox/refund') ?> legitRipple">
            Возврат <span class="badge bg-danger ml-auto"><?= $db->query("SELECT DISTINCT vss.visit_id, vs.patient_id FROM visits vs LEFT JOIN visit_services vss ON(vss.visit_id=vs.id) LEFT JOIN patients p ON(p.id=vs.patient_id) WHERE vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 5")->rowCount() ?></span>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= viv('cashbox/services_not_accepted') ?>" class="nav-link <?= viv_link('cashbox/services_not_accepted') ?> legitRipple">Не принятые услуги</a>
    </li>
</ul>
