<?php
require_once '../tools/warframe.php';
is_auth();
?>
<?php foreach ($_GET['divisions'] as $divis_pk): ?>

    <?php foreach ($db->query("SELECT dv.title, sc.name, sc.type, sc.price from service sc LEFT JOIN division dv ON(dv.id=sc.division_id) WHERE sc.division_id = $divis_pk AND sc.type != 101") as $row): ?>
        <tr>
            <td>
                <input type="checkbox" class="form-input-styled">
            </td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['name'] ?></td>
            <td>
                <?php switch ($row['type']) {
                    case 1:
                        echo "Обычная";
                        break;
                    case 2:
                        echo "Консультация";
                        break;
                    case 3:
                        echo "Операционная";
                        break;
                } ?>
            </td>
            <td>
                <select data-placeholder="Выберите специалиста" name="parent_id" class="form-control select">
                    <?php foreach ($db->query("SELECT id from users WHERE division_id = $divis_pk") as $par): ?>
                        <option value="<?= $par['id'] ?>"><?= get_full_name($par['id']) ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td class="text-right text-success"><?= number_format($row['price']) ?></td>
        </tr>
    <?php endforeach; ?>
<?php endforeach; ?>
