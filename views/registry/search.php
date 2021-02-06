<?php
require_once '../../tools/warframe.php';
is_auth([2, 32]);

if(empty($_GET['search'])){
    $sql = "SELECT * FROM users WHERE user_level = 15 ORDER BY add_date DESC LIMIT 20";
}else {
    $ser = $_GET['search'];
    $sql = "SELECT * FROM users WHERE user_level = 15 AND (id LIKE '%$ser%' OR first_name LIKE '%$ser%' OR last_name LIKE '%$ser%' OR father_name LIKE '%$ser%')";
}
$i = 1;
foreach($db->query($sql) as $row) {
    ?>
    <tr>
        <td><?= addZero($row['id']) ?></td>
        <td>
            <div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
            <div class="text-muted">
                <?php
                if($stm = $db->query('SELECT wd.floor, wd.ward, bd.bed FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) WHERE bd.user_id='.$row['id'])->fetch()){
                    echo $stm['floor']." этаж ".$stm['ward']." палата ".$stm['bed']." койка";
                }
                ?>
            </div>
        </td>
        <td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
        <td><?= $row['numberPhone'] ?></td>
        <td><?= $row['region'] ?></td>
        <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
        <?php
        if($stm_dr = $db->query("SELECT direction, status FROM visit WHERE completed IS NULL AND user_id={$row['id']} ORDER BY add_date ASC")->fetch()){
            if($stm_dr['direction']){
                ?>
                <td>
                    <span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
                </td>
                <td>
                    <?php
                    switch ($stm_dr['status']):
                        case 1:
                            ?>
                            <span style="font-size:15px;" class="badge badge-flat border-success text-success">Размещён</span>
                            <?php
                            break;
                        case 2:
                            ?>
                            <span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
                            <?php
                            break;
                        default:
                            ?>
                            <span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
                            <?php
                            break;
                    endswitch;
                    ?>
                </td>
                <?php
            }else{
                ?>
                <td>
                    <span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
                </td>
                <td>
                    <?php
                    switch ($stm_dr['status']):
                        case 1:
                            ?>
                            <span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Ожидание</span>
                            <?php
                            break;
                        case 2:
                            ?>
                            <span style="font-size:15px;" class="badge badge-flat border-success text-success">У специолиста</span>
                            <?php
                            break;
                        default:
                            ?>
                            <span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
                            <?php
                            break;
                    endswitch;
                    ?>
                </td>
                <?php
            }
        }else {
            ?>
                <td>
                    <?= ($row['status']) ?
                    '<span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Status error</span>' :
                    '<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-600">Закрытый</span>'
                    ?>

                </td>
                <td>
                    <span style="font-size:15px;" class="badge badge-flat border-grey text-grey-300">Не активный</span>
                </td>
            <?php
        }
        ?>
        <td class="text-center">
            <button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                <a onclick="Update('<?= up_url($row['id'], 'PatientForm') ?>')" class="dropdown-item"><i class="icon-quill2"></i>Редактировать</a>
                <a href="<?= viv('archive/all/list_visit') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-users4"></i> Визиты</a>
            </div>
        </td>
    </tr>
    <?php
}
?>
