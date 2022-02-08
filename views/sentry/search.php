<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = (new VisitModel)->Data("id, user_id, add_date, discharge_date, grant_id, division_id");
$search = $tb->getSearch();
$search_array = array(
	"division_id = $search AND direction IS NOT NULL AND completed IS NULL AND is_active IS NOT NULL",
	"division_id = $search AND direction IS NOT NULL AND completed IS NULL AND is_active IS NOT NULL",
);
$tb->Where($search_array)->Order("add_date DESC")->Limit(20);
$tb->returnPath(viv('sentry/index'));
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>ФИО</th>
                <th>Дата размещения</th>
                <th>Дата выписки</th>
                <th>Лечущий врач</th>
                <th class="text-center" style="width:210px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->list(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= addZero($row->user_id) ?></td>
                    <td>
                        <div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
                        <div class="text-muted">
                            <?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE user_id = $row->user_id")->fetch()): ?>
                                <?= $stm['building'] ?>  <?= $stm['floor'] ?> этаж <?= $stm['ward'] ?> палата <?= $stm['bed'] ?> койка;
                            <?php endif; ?>
                        </div>
                    </td>
                    <td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td><?= ($row->discharge_date) ? date_f($row->discharge_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td>
                        <?= $db->query("SELECT title FROM divisions WHERE id = $row->division_id")->fetchColumn() ?>
                        <div class="text-muted"><?= get_full_name($row->grant_id) ?></div>
                    </td>
                    <td class="text-right">
                        <button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                            <a href="<?= viv('card/content-1') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-repo-forked"></i>Осмотр Врача</a>
                            <a href="<?= viv('card/content-5') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-add"></i>Назначенные услуги</a>
                            <?php if(module('module_laboratory')): ?>
                                <a href="<?= viv('card/content-7') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
                            <?php endif; ?>
                            <?php if(module('module_diagnostic')): ?>
                                <a href="<?= viv('card/content-8') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-pulse2"></i>Диагностика</a>
                            <?php endif; ?>
                            <?php if(module('module_bypass')): ?>
                                <a href="<?= viv('card/content-9') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-magazine"></i>Лист назначения</a>
                            <?php endif; ?>
                            <a href="<?= viv('card/content-12') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-clipboard2"></i> Состояние</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->panel(); ?>