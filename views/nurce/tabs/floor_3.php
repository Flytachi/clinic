<div class="card border-1 border-info">

    <div class="card-header text-dark header-elements-inline alpha-info">
        <h6 class="card-title">3 Этаж</h6>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="bg-info">
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Возрвст</th>
                        <th>Дата размещения</th>
                        <th>Дата выписки</th>
                        <th>Лечущий врач</th>
                        <th class="text-center" style="width:210px">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($db->query("SELECT vs.id, wd.ward, bd.bed, bd.types, vs.user_id, vs.grant_id, vs.add_date, vs.discharge_date, us.dateBith FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) LEFT JOIN visit vs ON (vs.user_id=bd.user_id) LEFT JOIN users us ON (us.id=bd.user_id) WHERE bd.user_id IS NOT NULL AND wd.floor = 3 AND vs.accept_date IS NOT NULL AND vs.completed IS NULL AND vs.grant_id = vs.parent_id") as $row) {
                        ?>
                        <tr>
                            <td><?= addZero($row['user_id']) ?></td>
                            <td>
                                <div class="font-weight-semibold"><?= get_full_name($row['user_id']) ?></div>
                                <div class="text-muted"><?= $row['ward']." палата ".$row['bed']." койка"?></div>
                            </td>
                            <td><?= date_diff(new \DateTime(), new \DateTime($row['dateBith']))->y ?></td>
                            <td><?= date('d.m.Y', strtotime($row['add_date'])) ?></td>
                            <td><?= ($row['discharge_date']) ? date('d.m.Y', strtotime($row['discharge_date'])) : "Не назначено" ?></td>
                            <td>
                                <?= level_name($row['grant_id']) ." ". division_name($row['grant_id']) ?>
                                <div class="text-muted"><?= get_full_name($row['grant_id']) ?></div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                                    <a href="<?= viv('nurce/card/content_1') ?>?id=<?= $row['user_id'] ?>" class="dropdown-item"><i class="icon-users4"></i>Обход</a>
                                    <a href="<?= viv('nurce/card/content_2') ?>?id=<?= $row['user_id'] ?>" class="dropdown-item"><i class="icon-users4"></i>Лист назначений</a>
                                    <a href="<?= viv('nurce/card/content_3') ?>?id=<?= $row['user_id'] ?>" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</div>
