<div class="card border-1 border-info">

    <div class="card-header text-dark header-elements-inline alpha-info">
        <h6 class="card-title">2 Этаж</h6>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover table-sm table-bordered">
                <thead>
                    <tr class="bg-info">
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
                    foreach($db->query("SELECT bd.ward, bd.num, bd.types, vs.user_id, vs.grant_id, vs.add_date, vs.discharge_date, us.dateBith FROM beds bd LEFT JOIN visit vs ON (vs.user_id=bd.user_id) LEFT JOIN users us ON (us.id=bd.user_id) WHERE bd.user_id IS NOT NULL AND bd.floor = 2 AND vs.completed IS NULL AND vs.grant_id = vs.parent_id") as $row) {
                        ?>
                        <tr>
                            <td><?= addZero($row['user_id']) ?></td>
                            <td>
                                <div class="font-weight-semibold"><?= get_full_name($row['user_id']) ?></div>
                                <div class="text-muted"><?= $row['ward']." палата ".$row['num']." койка"?></div>
                            </td>
                            <td><?= date_diff(new \DateTime(), new \DateTime($row['dateBith']))->y ?></td>
                            <td><?= date('d.m.Y', strtotime($row['add_date'])) ?></td>
                            <td><?= ($row['discharge_date']) ? date('d.m.Y', strtotime($row['discharge_date'])) : "Не назначено" ?></td>
                            <td><div class="font-weight-semibold"><?= get_full_name($row['grant_id']) ?></div></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                                    <a href="<?= viv('doctor/card/content_1') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-repo-forked"></i> Осмотр Врача</a>
                                    <a href="<?= viv('doctor/card/content_2') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-users4"></i> Другие визити</a>
                                    <a href="<?= viv('doctor/card/content_3') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-add"></i> Добавить визит</a>
                                    <a href="<?= viv('doctor/card/content_5') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
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
