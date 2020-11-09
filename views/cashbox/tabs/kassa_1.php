<div class="row">

    <div class="col-md-5">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Приём платежей</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="reload"></a>

                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>ФИО</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach($db->query('SELECT * FROM users WHERE user_level = 15 AND status_bed IS NULL ORDER BY add_date ASC LIMIT 5') as $row) {
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= addZero($row['id']) ?></td>
                                        <td>
                                            <a onclick="alert('<?= get_full_name($row['id']) ?>')">
                                                <div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
                                            </a>
                                        </td>
                                        <!-- <td class="text-center">
                                            <button onclick="Update('<?= up_url($row['id'], 'PatientForm') ?>')" type="button" class="btn btn-outline-primary btn-lg legitRipple">Редактировать</button>
                                        </td> -->
                                    </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">

        <div class="card">

            <div class="card-header header-elements-inline">
                <h5 class="card-title">Подробнее о пациенте <b>Евгений Копьев</b></h5>
                <div class="header-elements">
                    <div class="list-icons">

                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-blue">
                                <th>Дата и время</th>
                                <th>Мед услуги</th>
                                <th>Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>04.02.2021</td>
                                <td>Осмотр терапевта</td>
                                <td>50 000</td>
                            </tr>
                            <tr>
                                <td>04.02.2021</td>
                                <td>МРТ</td>
                                <td>300 000</td>
                            </tr>
                            <tr>
                                <td>04.02.2021</td>
                                <td>Массаж</td>
                                <td>60 000</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple" data-toggle="modal" data-target="#modal_default">Оплата</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>
