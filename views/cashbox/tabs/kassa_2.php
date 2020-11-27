<div class="row">

    <div class="col-md-5">

        <div class="card border-1 border-info">
            <div class="card-body">

                <div class="form-group form-group-float">
                    <label class="form-group-float-label text-success font-weight-semibold animate">ID или имя пациента</label>
                    <div class="form-group-feedback form-group-feedback-right">
                        <input type="text" class="form-control border-success" id="search_tab-2" placeholder="Введите ID или имя">
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
                                <th>ID</th>
                                <th class="text-center">ФИО</th>
                            </tr>
                        </thead>
                        <tbody id="displ_tab-2">
                            <?php
                            foreach($db->query("SELECT DISTINCT user_id 'id' FROM visit WHERE direction IS NOT NULL AND priced_date IS NULL AND status IS NOT NULL") as $row) {
                                ?>
                                    <tr onclick="CheckSt('get_mod.php?pk=<?= $row['id'] ?>', '<?= $row['id'] ?>')">
                                        <td><?= addZero($row['id']) ?></td>
                                        <td class="text-center">
                                            <a>
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

    <div class="col-md-7" id="check-st">
        <?php
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
    </div>

</div>
