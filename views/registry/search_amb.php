<?php
require_once '../../tools/warframe.php';
is_auth();

$ser = $_GET['search']; $i; $cost = 0;
?>

<?php foreach ($_GET['divisions'] as $divis_pk): ?>

    <?php if ($ser): ?>
        <?php $sql = "SELECT sc.id, dv.title, sc.name, sc.type, sc.price from service sc LEFT JOIN division dv ON(dv.id=sc.division_id) WHERE sc.division_id = $divis_pk AND sc.type != 101 AND (dv.title LIKE '%$ser%' OR sc.name LIKE '%$ser%' )"; ?>
    <?php else: ?>
        <?php $sql = "SELECT sc.id, dv.title, sc.name, sc.type, sc.price from service sc LEFT JOIN division dv ON(dv.id=sc.division_id) WHERE sc.division_id = $divis_pk AND sc.type != 101"; ?>
    <?php endif; ?>

    <?php foreach ($db->query($sql) as $row): ?>
        <?php $i++; ?>
        <tr>
            <td>
                <?php
                if (in_array($row['id'], $_GET['selected'])) {
                    $result = "checked";
                    $cost += $row['price'];
                }else {
                    $result = "";
                }
                ?>
                <input type="checkbox" name="service[<?= $i ?>]" value="<?= $row['id'] ?>" class="form-input-styled" onchange="tot_sum(this, <?= $row['price'] ?>)" <?= $result ?>>
                <input type="hidden" name="division_id[<?= $i ?>]" value="<?= $divis_pk ?>">
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
                <select data-placeholder="Выберите специалиста" name="parent_id[<?= $i ?>]" class="form-control select" required>
                    <?php foreach ($db->query("SELECT id from users WHERE division_id = $divis_pk") as $par): ?>
                        <option value="<?= $par['id'] ?>"><?= get_full_name($par['id']) ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td class="text-right text-success"><?= number_format($row['price']) ?></td>
        </tr>
    <?php endforeach; ?>

<?php endforeach; ?>
<tr class="table-secondary">
    <th class="text-right" colspan="5">Итого:</th>
    <th class="text-right" id="total_price"><?= number_format($cost) ?></th>
</tr>
<script type="text/javascript">

    function number_format(number, decimals, decPoint, thousandsSep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
        var n = !isFinite(+number) ? 0 : +number
        var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
        var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
        var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
        var s = ''

        var toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec)
            return '' + (Math.round(n * k) / k)
            .toFixed(prec)
        }

        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || ''
            s[1] += new Array(prec - s[1].length + 1).join('0')
        }
        return s.join(dec)
    }

    function tot_sum(the, price) {
        var total = $('#total_price');
        var cost = total.text().replace(',','');
        if (the.checked) {

            service.push(the.value);
            total.text( number_format(Number(cost) + Number(price), '.', ',') );

        }else {

            service.pop(the.value);
            total.text( number_format(Number(cost) - Number(price), '.', ',') );

        }
    }

</script>
