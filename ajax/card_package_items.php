<?php
require_once '../tools/warframe.php';
is_auth();

$package = $db->query("SELECT * FROM package WHERE id = {$_POST['id']}")->fetch();
$post['items'] = json_decode($package['items']);
foreach ($post['items'] as $key => $value) {
    $service_pk[] = $key;
    if (!isset($division) or ($division and !in_array($value->division_id, $division))) {
        $division[] = $value->division_id;
    }
}

// foreach ($post['items'] as $key => $value) {
//     prit($key." -> ".$value->count);
// }
?>
<script type="text/javascript">var service = {};</script>
<?php foreach ($post['items'] as $key => $value): ?>
    <script type="text/javascript">service["<?= $key ?>"] = "<?= $value->count ?>";</script>
<?php endforeach; ?>

<div class="form-group">

    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="bg-dark">
                    <th>#</th>
                    <th>Отдел</th>
                    <th>Услуга</th>
                    <th>Тип</th>
                    <th>Доктор</th>
                    <th style="width:100px">Кол-во</th>
                    <th class="text-right">Цена</th>
                </tr>
            </thead>
            <tbody id="table_form">

                <?php if ($post['items']): ?>
                    <?php $i=$cost=0; foreach ($division as $divis_pk): ?>

                        <?php foreach ($db->query("SELECT sc.id, sc.user_level, dv.title, sc.name, sc.type, sc.price from service sc LEFT JOIN division dv ON(dv.id=sc.division_id) WHERE sc.division_id = $divis_pk AND sc.type IN (1,2) AND sc.id IN (".implode(', ', $service_pk).")") as $row): ?>
                            <?php $i++; ?>
                            <tr>

                                <td>
                                    <?php
                                    if (in_array($row['id'], $service_pk)) {
                                        $result = "checked";
                                        $cost += ($row['price'] * ((array) $post['items'])[$row['id']]->count);
                                    }else {
                                        $result = "";
                                    }
                                    ?>
                                    <input type="checkbox" name="service[<?= $i ?>]" value="<?= $row['id'] ?>" class="form-input-styled" onchange="tot_sum(this, <?= $row['price'] ?>)" <?= $result ?>>
                                    <input type="hidden" name="division_id[<?= $i ?>]" value="<?= $divis_pk ?>">
                                </td>

                                <?php if ($_GET['cols'] < 2): ?>
                                    <td><?= $row['title'] ?></td>
                                <?php endif; ?>
                                <td><?= $row['name'] ?></td>
                                <?php if ($_GET['cols'] < 1): ?>
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
                                <?php endif; ?>
                                <?php if (!$_GET['head']): ?>
                                    <td>
                                        <select data-placeholder="Выберите специалиста" name="parent_id[<?= $i ?>]" class="form-control select" required>
                                            <?php if ($row['user_level'] == 6): ?>
                                                <?php foreach ($db->query("SELECT id from users WHERE user_level = 6") as $par): ?>
                                                    <option value="<?= $par['id'] ?>"><?= get_full_name($par['id']) ?></option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <?php foreach ($db->query("SELECT id from users WHERE division_id = $divis_pk") as $par): ?>
                                                    <option value="<?= $par['id'] ?>"><?= get_full_name($par['id']) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                <?php endif; ?>
                                <td style="width:70px;">
                                    <input type="number" id="count_input_<?= $row['id'] ?>" data-id="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>" class="counts" name="count[<?= $i ?>]" value="<?= ((array) $post['items'])[$row['id']]->count ?>" min="1" max="1000000">
                                </td>
                                <td class="text-right text-success"><?= number_format($row['price']) ?></td>

                            </tr>
                        <?php endforeach; ?>

                    <?php endforeach; ?>
                    <tr class="table-secondary">
                        <th class="text-right" colspan="<?= 6-$_GET['cols'] ?>">Итого:</th>
                        <th class="text-right" id="total_price"><?= number_format($cost) ?></th>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

<script type="text/javascript">

    function tot_sum(the, price) {
        var total = $('#total_price');
        var cost = total.text().replace(/,/g,'');
        if (the.checked) {
            service[the.value] = $("#count_input_"+the.value).val();
            total.text( number_format(Number(cost) + (Number(price) * service[the.value]), '.', ',') );
        }else {
            total.text( number_format(Number(cost) - (Number(price) * service[the.value]), '.', ',') );
            delete service[the.value];
        }
        // console.log(service);
    }

    $(".counts").keyup(function() {
        var total = $('#total_price');
        var cost = total.text().replace(/,/g,'');

        if (typeof service[this.dataset.id] !== "undefined") {
            total.text( number_format(Number(cost) + (this.dataset.price * (this.value - service[this.dataset.id])), '.', ',') );
            service[this.dataset.id] = this.value;
        }
        // console.log(service);
    });

</script>