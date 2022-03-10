<?php
require_once '../../tools/warframe.php';
$session->is_auth();

importModel('Visit', 'Region');
$tb = new Visit('v');
$tb->Data('v.id, v.parad_id, v.grant_id, v.patient_id, v.icd_id, v.icd_autor, v.add_date, p.last_name, p.first_name, p.father_name, p.region_id, p.address_residence, p.phone_number, v.completed');
$search = $tb->getSearch();
$where = array(
	"v.direction IS NOT NULL", 
	"v.direction IS NOT NULL AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
);
$tb->JoinLEFT('patients p', 'p.id=v.patient_id')->Where($where)->Order('v.add_date ASC')->Limit(20);
$tb->returnPath(viv('archive/journal'));
?>
<div class="table-responsive card">
    <table class="table table-hover table-sm">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>№</th>
                <th>ID</th>
                <th>Дата</th>
                <th>ФИО</th>
                <th>Адресс</th>
                <th>Телефон</th>
                <th>Диагноз</th>
                <th>Отдел</th>
                <th>Дата выписки</th>
                <th>Лечащий врач</th>
                <th class="text-center" style="width:210px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->list() as $row): ?>
                <tr>	
                    <td><?= $row->parad_id ?></td>
                    <td><?= addZero($row->patient_id) ?></td>
                    <td><?= date_f($row->add_date, 1) ?></td>
                    <td><?= patient_name($row) ?></td>
                    <td>г. <?= (new Region)->byId($row->region_id, 'name')->name . " " . $row->address_residence ?></td>
                    <td><?= $row->phone_number ?></td>
                    <td>
                        <?php if ( $row->icd_id ): ?>
                            <?php $icd = icd($row->icd_id) ?>
                            <span class="badge badge-flat border-pink text-pink" data-trigger="hover" data-popup="popover" data-html="true" data-placement="right" title="" 
                                data-original-title="<div class='d-flex justify-content-between'><?= $icd['code'] ?><span class='font-size-sm text-muted'><?= get_full_name($row->icd_autor) ?></span></div>"
                                data-content="<?= $icd['decryption'] ?>" style="font-size:15px;">
                                ICD <?= $icd['code'] ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td><?= division_title($row->grant_id) ?></td>
                    <td><?= ($row->completed) ? date_f($row->completed) : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td><?= get_full_name($row->grant_id) ?></td>
                    <td class="text-right">
                        <button type="button" class="<?= $classes['btn-detail'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                            <a href="<?= viv('card/content-2') ?>?pk=<?= $row->id ?>" class="dropdown-item"><i class="icon-history"></i>История болезни</a>
                            <a onclick="Check('<?= viv('doctor/report-2') ?>?pk=<?= $row->id ?>')" class="dropdown-item"><i class="icon-eye"></i>Просмотр</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->panel(); ?>