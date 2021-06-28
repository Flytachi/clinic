<?php
require_once '../tools/warframe.php';
$session->is_auth();

$db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$i = 0; $cost = 0;
?>

<?php if( isset($_GET['divisions']) ): ?>
    <?php $divisions = implode(',', $_GET['divisions']) ?>

    <?php if ( isset($_GET['search']) ): ?>
        <?php $ser = $_GET['search']; ?>
        <?php $sql = "SELECT dv.id 'division_id', sc.id, sc.user_level, dv.title, sc.name, sc.type, sc.price from service sc LEFT JOIN division dv ON(dv.id=sc.division_id) WHERE sc.division_id IN($divisions) AND sc.type IN ({$_GET['types']}) AND (LOWER(dv.title) LIKE LOWER('%$ser%') OR LOWER(sc.name) LIKE LOWER('%$ser%') )"; ?>
    <?php else: ?>
        <?php $sql = "SELECT dv.id 'division_id', sc.id, sc.user_level, dv.title, sc.name, sc.type, sc.price from service sc LEFT JOIN division dv ON(dv.id=sc.division_id) WHERE sc.division_id IN($divisions) AND sc.type IN ({$_GET['types']})"; ?>
    <?php endif; ?>

    <?php foreach ($db->query($sql) as $row): ?>
        <?php $i++; ?>
        <tr>

            <td>
                <?php
                $result = "";
                if ( isset($_GET['selected']) and in_array($row->id, array_keys($_GET['selected']))) {
                    $result = "checked";
                    $cost += ($row->price * $_GET['selected'][$row->id]);
                }
                ?>
                <input type="checkbox" name="service[<?= $i ?>]" value="<?= $row->id ?>" class="form-input-styled" onchange="tot_sum(this, <?= $row->price ?>)" <?= $result ?>>
                <input type="hidden" name="division_id[<?= $i ?>]" value="<?= $row->division_id ?>">
            </td>

            <?php if ($_GET['cols'] < 2): ?>
                <td><?= $row->title ?></td>
            <?php endif; ?>

            <td><?= $row->name ?></td>

            <?php if ($_GET['cols'] < 1): ?>
                <td>
                    <?php switch ($row->type) {
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

            <?php if (empty($_GET['head'])): ?>
                <td>
                    <select data-placeholder="Выберите специалиста" name="parent_id[<?= $i ?>]" class="<?= $classes['form-select'] ?>" required>
                        <?php if ($row->user_level == 6): ?>
                            <?php foreach ($db->query("SELECT id from users WHERE user_level = 6 AND is_active IS NOT NULL") as $parent): ?>
                                <option value="<?= $parent->id ?>"><?= get_full_name($parent->id) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach ($db->query("SELECT id from users WHERE division_id = $row->division_id AND is_active IS NOT NULL") as $parent): ?>
                                <option value="<?= $parent->id ?>"><?= get_full_name($parent->id) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
            <?php endif; ?>
            <td style="width:70px;">
                <input type="number" id="count_input_<?= $row->id ?>" data-id="<?= $row->id ?>" data-price="<?= $row->price ?>" class="counts" name="count[<?= $i ?>]" value="<?= ( isset($_GET['selected']) and isset($_GET['selected'][$row->id]) ) ? $_GET['selected'][$row->id] : "1" ?>" min="1" max="1000000">
            </td>
            <td class="text-right text-success"><?= number_format($row->price) ?></td>

        </tr>
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
<?php endif; ?>