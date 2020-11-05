
<div class="card">

    <div class="card-header header-elements-inline">
        <h5 class="card-title">Добавить Пользователя</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>



    <div class="card-body">
        <?php
        form('UserForm');
        ?>
    </div>

</div>

<div class="card">

    <div class="card-header header-elements-inline">
        <h5 class="card-title">Список Пользователей</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr class="bg-blue">
                        <th>#</th>
                        <th>Логин</th>
                        <th>Ф.И.О</th>
                        <th>Роль</th>
                        <th style="width: 100px">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach($db->query('SELECT * from users WHERE not user_level = 15') as $row) {
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= get_full_name($row['id']); ?></td>
                            <td><?= level_name($row['id']); ?></td>
                            <td>
                                <div class="list-icons">
                                    <a href="model/update.php?id=<?= $row['id'] ?>&form=UserForm" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                    <a href="model/delete.php?<?= delete($row['id'], 'users', $_SERVER['PHP_SELF']) ?>" onclick="return confirm('Вы уверены что хотите удалить пользоватиля?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                                    <!-- <a href="#" class="list-icons-item text-teal-600"><i class="icon-cog6"></i></a> -->
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
