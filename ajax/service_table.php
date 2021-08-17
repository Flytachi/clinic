<?php
require_once '../tools/warframe.php';
$session->is_auth();

$db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$i = 0; $cost = 0;
$requared = "";
?>

<?php if( isset($_GET['divisions']) ): ?>

    <?php if ( isset($_GET['divisions']) and $_GET['divisions'] ): ?>

        <?php
        if (isset($_GET['is_requared']) and $_GET['is_requared']) $requared = "required";
        $divisions = implode(',', $_GET['divisions']);
        if ( isset($_GET['is_foreigner']) and $_GET['is_foreigner']) {
            $data = "dv.id 'division_id', sc.id, sc.user_level, dv.title, sc.name, sc.type, sc.price_foreigner 'price'";
        } else {
            $data = "dv.id 'division_id', sc.id, sc.user_level, dv.title, sc.name, sc.type, sc.price";
        }
        ?>

        <?php if ( isset($_GET['search']) ): ?>
            <?php $ser = $_GET['search']; ?>
            <?php $sql = "SELECT $data FROM services sc LEFT JOIN divisions dv ON(dv.id=sc.division_id) WHERE sc.is_active IS NOT NULL AND sc.division_id IN($divisions) AND sc.type IN ({$_GET['types']}) AND (LOWER(dv.title) LIKE LOWER('%$ser%') OR LOWER(sc.name) LIKE LOWER('%$ser%') )"; ?>
        <?php else: ?>
            <?php $sql = "SELECT $data FROM services sc LEFT JOIN divisions dv ON(dv.id=sc.division_id) WHERE sc.is_active IS NOT NULL AND sc.division_id IN($divisions) AND sc.type IN ({$_GET['types']})"; ?>
        <?php endif; ?>

        <?php foreach ($db->query($sql) as $row): ?>
            <?php
            $result = ""; $i++;
            if ( isset($_GET['selected']) and in_array($row->id, array_keys($_GET['selected'])) ) {
                $result = "checked";
                $cost += ($row->price * $_GET['selected'][$row->id]['count']);
            }
            ?>
            <?php if ( (isset($_GET['is_service_checked']) and $_GET['is_service_checked'] and $result == "checked") or empty($_GET['is_service_checked']) ): ?>
                <tr>
    
                    <td>
                        <input type="checkbox" name="service[<?= $i ?>]" value="<?= $row->id ?>" class="form-input-styled" onchange="tot_sum(this)" <?= $result ?>>
                        <input type="hidden" name="division_id[<?= $i ?>]" value="<?= $row->division_id ?>">
                    </td>
    
                    <?php if ($_GET['cols'] < 2): ?>
                        <td><?= $row->title ?></td>
                    <?php endif; ?>
    
                    <td><?= $row->name ?></td>
    
                    <!-- Type -->
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
    
                    <!-- Parent -->
                    <?php if (empty($_GET['head'])): ?>
                        <td>
                            <select name="parent_id[<?= $i ?>]" id="parent_input_<?= $row->id ?>" class="<?= $classes['form-select'] ?> parents" data-id="<?= $row->id ?>" <?= $requared ?>>
                                <?php if ($requared == ""): ?>
                                    <option value="">Выберан весь отдел</option>
                                <?php endif; ?>
                                <?php if ($row->user_level == 6): ?>
                                    <?php foreach ($db->query("SELECT id FROM users WHERE user_level = 6 AND is_active IS NOT NULL") as $parent): ?>
                                        <option value="<?= $parent->id ?>" <?= ( isset($_GET['selected'][$row->id]) and isset($_GET['selected'][$row->id]['parent']) and  $_GET['selected'][$row->id]['parent'] == $parent->id ) ? "selected" : "" ?>><?= get_full_name($parent->id) ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php foreach ($db->query("SELECT id FROM users WHERE division_id = $row->division_id AND is_active IS NOT NULL") as $parent): ?>
                                        <option value="<?= $parent->id ?>" <?= ( isset($_GET['selected'][$row->id]) and isset($_GET['selected'][$row->id]['parent']) and  $_GET['selected'][$row->id]['parent'] == $parent->id ) ? "selected" : "" ?>><?= get_full_name($parent->id) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </td>
                    <?php endif; ?>
                    
                    <!-- Count -->
                    <td style="width:70px;">
                        <input type="number" id="count_input_<?= $row->id ?>" data-id="<?= $row->id ?>" data-price="<?= $row->price ?>" class="counts form-control" name="count[<?= $i ?>]" value="<?= ( isset($_GET['selected']) and isset($_GET['selected'][$row->id]['count']) ) ? $_GET['selected'][$row->id]['count'] : "1" ?>" min="1" max="1000000">
                    </td>

                    <!-- Price -->
                    <?php if( isset($_GET['is_order']) and $_GET['is_order'] ): ?>
                        <td class="text-right">
                            <span class="text-muted">Бесплатно</span>
                        </td>
                    <?php else: ?>
                        <td class="text-right text-<?= number_color($row->price) ?>">
                            <?= number_format($row->price) ?>
                        </td>                    
                    <?php endif; ?>
    
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
       
    <?php endif; ?>

    <tr class="table-secondary">
        <th class="text-right" colspan="<?= 6-$_GET['cols'] ?>">Итого:</th>
        <?php if( isset($_GET['is_order']) and $_GET['is_order'] ): ?>
            <th class="text-right"><span class="text-muted">Бесплатно</span></th>
        <?php else: ?>                
            <th class="text-right" id="total_price"><?= number_format($cost) ?></th>
        <?php endif; ?>
    </tr>
    <script type="text/javascript">
        $( document ).ready(function() {
            FormLayouts.init();
        });

        function tot_sum(the) {
            var order = "<?= ( isset($_GET['is_order']) and $_GET['is_order'] ) ? null : 1 ?>";
            var total = $('#total_price');
            var cost = total.text().replace(/,/g,'');
            var price = (document.querySelector('#count_input_'+the.value)).dataset.price;

            if (the.checked) {
                service[the.value] = {};
                service[the.value]['parent'] = $("#parent_input_"+the.value).val();
                service[the.value]['count'] = $("#count_input_"+the.value).val();
                if (order) {
                    total.text( number_format(Number(cost) + (Number(price) * service[the.value]['count']), '.', ',') );
                }
            }else {
                if (order) {
                    total.text( number_format(Number(cost) - (Number(price) * service[the.value]['count']), '.', ',') );
                }
                delete service[the.value];
            }

            
        }

        $(".parents").change(function() {
            if (typeof service[this.dataset.id] !== "undefined") {
                service[this.dataset.id]['parent'] = this.value;
            }
        });

        $(".counts").keyup(function() {
            var order = "<?= ( isset($_GET['is_order']) and $_GET['is_order'] ) ? null : 1 ?>";
            var total = $('#total_price');
            var cost = total.text().replace(/,/g,'');

            if (typeof service[this.dataset.id] !== "undefined") {
                if (order) {
                    total.text( number_format(Number(cost) + (this.dataset.price * (this.value - service[this.dataset.id]['count'])), '.', ',') );
                }
                service[this.dataset.id]['count'] = this.value;
            }

        });

    </script>
<?php endif; ?>