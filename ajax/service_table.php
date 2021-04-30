<?php
require_once '../tools/warframe.php';
$session->is_auth();

$i = 0; $cost = 0;
?>
<?php if( isset($_GET['divisions']) ): ?>
    <?php foreach ($_GET['divisions'] as $divis_pk): ?>

        <?php foreach ($db->query("SELECT sc.id, sc.user_level, dv.title, sc.name, sc.type, sc.price from service sc LEFT JOIN division dv ON(dv.id=sc.division_id) WHERE sc.division_id = $divis_pk AND sc.type IN ({$_GET['types']})") as $row): ?>
            <?php $i++; ?>
            <tr>

                <td>
                    <?php
                    if ( isset($_GET['selected']) and in_array($row['id'], array_keys($_GET['selected']))) {
                        $result = "checked";
                        $cost += ($row['price'] * $_GET['selected'][$row['id']]);
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
                        <select data-placeholder="Выберите специалиста" name="parent_id[<?= $i ?>]" class="<?= $classes['form-select'] ?>" required>
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
                    <input type="number" id="count_input_<?= $row['id'] ?>" data-id="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>" class="counts" name="count[<?= $i ?>]" value="<?= ( isset($_GET['selected']) and isset($_GET['selected'][$row['id']]) ) ? $_GET['selected'][$row['id']] : "1" ?>" min="1" max="1000000">
                </td>
                <td class="text-right text-success"><?= number_format($row['price']) ?></td>

            </tr>
        <?php endforeach; ?>

    <?php endforeach; ?>
    <tr class="table-secondary">
        <th class="text-right" colspan="<?= 6-$_GET['cols'] ?>">Итого:</th>
        <th class="text-right" id="total_price"><?= number_format($cost) ?></th>
    </tr>
    <script type="text/javascript">
        $( document ).ready(function() {
            FormLayouts.init();
        });

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
            console.log(service);
        }

        $(".counts").keyup(function() {
            var total = $('#total_price');
            var cost = total.text().replace(/,/g,'');

            if (typeof service[this.dataset.id] !== "undefined") {
                total.text( number_format(Number(cost) + (this.dataset.price * (this.value - service[this.dataset.id])), '.', ',') );
                service[this.dataset.id] = this.value;
            }
            console.log(service);
        });

    </script>
<?php endif; ?>
