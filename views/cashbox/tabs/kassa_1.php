<div class="row">

    <div class="col-md-5">
        <div class="card">

            <div class="card-body">
                <div class="form-group form-group-float">
                    <label class="form-group-float-label text-success font-weight-semibold animate">ID или имя пациента</label>
                    <div class="form-group-feedback form-group-feedback-right">
                        <input type="text" class="form-control border-success" id="search_tab-1" placeholder="Введите ID или имя">
                        <div class="form-control-feedback text-success">
                            <i class="icon-search4"></i>
                        </div>
                    </div>
                    <span class="form-text text-success">Выбор пациента</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-left">Дата и время</th>
                                <th class="text-center">ID</th>
                                <th class="text-center">ФИО</th>
                            </tr>
                        </thead>
                        <tbody id="displ_tab-1">
                            <?php
                            foreach($db->query('SELECT * FROM visit WHERE direction IS NULL AND status = 0 ORDER BY add_date ASC LIMIT 5') as $row) {
                            ?>
                                <tr>
                                    <td class="text-left"><?= $row['add_date'] ?></td>
                                    <td class="text-center"><?= addZero($row['user_id']) ?></td>
                                    <td class="text-center">
                                        <a onclick="CheckAmb('get_mod.php?pk=<?= $row['id'] ?>&user_id=<?= $row['user_id'] ?>')">
                                            <div class="font-weight-semibold"><?= get_full_name($row['user_id']) ?></div>
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

    <div class="col-md-7">

        <div id="message_ses">
            <?php
            if($_SESSION['message']){
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>
        </div>

        <div id="check-amb">
        </div>

    </div>

</div>
