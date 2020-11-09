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
                                            <a onclick="CheckAmb('get_mod.php?pk=<?= $row['id'] ?>')">
                                                <div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
                                            </a>
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
    </div>

    <div class="col-md-7" id="check-amb">

    </div>

</div>
