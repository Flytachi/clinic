<?php

class ServicePanel extends Model
{
    public $table = 'services';
    public $i = 0;
    public $cost = 0;
    public $requared = "";

    public function get_or_404(int $pk)
    {
        global $db;
        if ( isset($_GET) and $_GET['id'] == 1 and isset($_POST) ) {
            $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->set_post($_POST);
            unset($_POST);
            if ( isset($this->post['divisions']) and $this->post['divisions'] ) {

                if (isset($this->post['is_requared']) and $this->post['is_requared']) $this->requared = "required";
                $this->divisions = implode(',', $this->post['divisions']);
                $this->types = $this->post['types'];
                $this->branch = $this->post['branch_id'];
                

                $this->table();

            }else {
                $this->empty_result();
            }
        }

    }

    public function table()
    {
        global $db, $classes;
        if ( isset($this->post['is_foreigner']) and $this->post['is_foreigner']) {
            $data = "dv.id 'division_id', sc.id, sc.level, dv.title, sc.name, sc.type, sc.price_foreigner 'price'";
        } else {
            $data = "dv.id 'division_id', sc.id, sc.level, dv.title, sc.name, sc.type, sc.price";
        }
        if ( isset($this->post['search']) ){
            $ser = $this->post['search'];
            $sql = "SELECT $data FROM services sc LEFT JOIN divisions dv ON(dv.id=sc.division_id) WHERE sc.branch_id = $this->branch AND sc.is_active IS NOT NULL AND sc.division_id IN($this->divisions) AND sc.type IN ($this->types) AND (LOWER(dv.title) LIKE LOWER('%$ser%') OR LOWER(sc.name) LIKE LOWER('%$ser%') )";
        }else{
            $sql = "SELECT $data FROM services sc LEFT JOIN divisions dv ON(dv.id=sc.division_id) WHERE sc.branch_id = $this->branch AND sc.is_active IS NOT NULL AND sc.division_id IN($this->divisions) AND sc.type IN ($this->types)";
        }

        foreach ($db->query($sql) as $row){
            $this->result = ""; 
            $this->i++;
            if ( isset($this->post['selected']) and in_array($row->id, array_keys($this->post['selected'])) ) {
                $this->result = "checked";
                $this->cost += ($row->price * $this->post['selected'][$row->id]['count']);
            }

            if ( (isset($this->post['is_service_checked']) and $this->post['is_service_checked'] and $this->result == "checked") or empty($this->post['is_service_checked']) ) {
                ?>
                <tr>
                    
                    <td>
                        <input type="checkbox" name="service[<?= $this->i ?>]" value="<?= $row->id ?>" class="form-input-styled" onchange="tot_sum(this)" <?= $this->result ?>>
                        <input type="hidden" name="division_id[<?= $this->i ?>]" value="<?= $row->division_id ?>">
                    </td>

                    <?php if ($this->post['cols'] < 2): ?>
                        <td><?= $row->title ?></td>
                    <?php endif; ?>

                    <td><?= $row->name ?></td>

                    <!-- Type -->
                    <?php if ($this->post['cols'] < 1): ?>
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

                    <!-- Responsible -->
                    <?php if (empty($this->post['head'])): ?>
                        <td>
                            <select name="responsible_id[<?= $this->i ?>]" id="responsible_input_<?= $row->id ?>" class="<?= $classes['form-select'] ?> responsibles" data-id="<?= $row->id ?>" <?= $this->requared ?>>
                                <?php if ($this->result == ""): ?>
                                    <option value="">Выбран весь отдел</option>
                                <?php endif; ?>
                                <?php if ($row->level == 6): ?>
                                    <?php foreach ($db->query("SELECT id FROM users WHERE branch_id = $this->branch AND user_level = 6 AND is_active IS NOT NULL") as $responsible): ?>
                                        <option value="<?= $responsible->id ?>" <?= ( isset($this->post['selected'][$row->id]) and isset($this->post['selected'][$row->id]['responsible']) and  $this->post['selected'][$row->id]['responsible'] == $responsible->id ) ? "selected" : "" ?>><?= get_full_name($responsible->id) ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php foreach ($db->query("SELECT id FROM users WHERE branch_id = $this->branch AND division_id = $row->division_id AND is_active IS NOT NULL") as $responsible): ?>
                                        <option value="<?= $responsible->id ?>" <?= ( isset($this->post['selected'][$row->id]) and isset($this->post['selected'][$row->id]['responsible']) and  $this->post['selected'][$row->id]['responsible'] == $responsible->id ) ? "selected" : "" ?>><?= get_full_name($responsible->id) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </td>
                    <?php endif; ?>
                    
                    <!-- Count -->
                    <td style="width:70px;">
                        <input type="number" id="count_input_<?= $row->id ?>" data-id="<?= $row->id ?>" data-price="<?= $row->price ?>" class="counts form-control" name="count[<?= $this->i ?>]" value="<?= ( isset($this->post['selected']) and isset($this->post['selected'][$row->id]['count']) ) ? $this->post['selected'][$row->id]['count'] : "1" ?>" min="1" max="1000000">
                    </td>

                    <!-- Price -->
                    <?php if( isset($this->post['is_order']) and $this->post['is_order'] ): ?>
                        <td class="text-right">
                            <span class="text-muted">Бесплатно</span>
                        </td>
                    <?php else: ?>
                        <td class="text-right text-<?= number_color($row->price) ?>">
                            <?= number_format($row->price) ?>
                        </td>                    
                    <?php endif; ?>

                </tr>
                <?php
            }
        }

        ?>
        <tr class="table-secondary">
            <th class="text-right" colspan="<?= 6-$this->post['cols'] ?>">Итого:</th>
            <?php if( isset($this->post['is_order']) and $this->post['is_order'] ): ?>
                <th class="text-right"><span class="text-muted">Бесплатно</span></th>
            <?php else: ?>                
                <th class="text-right" id="total_price"><?= number_format($this->cost) ?></th>
            <?php endif; ?>
        </tr>
        <script type="text/javascript">
            $( document ).ready(function() {
                FormLayouts.init();
            });

            function tot_sum(the) {
                var order = "<?= ( isset($this->post['is_order']) and $this->post['is_order'] ) ? null : 1 ?>";
                var total = $('#total_price');
                var cost = total.text().replace(/,/g,'');
                var price = (document.querySelector('#count_input_'+the.value)).dataset.price;

                if (the.checked) {
                    service[the.value] = {};
                    service[the.value]['responsible'] = $("#responsible_input_"+the.value).val();
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

            $(".responsibles").change(function() {
                if (typeof service[this.dataset.id] !== "undefined") {
                    service[this.dataset.id]['responsible'] = this.value;
                }
            });

            $(".counts").keyup(function() {
                var order = "<?= ( isset($this->post['is_order']) and $this->post['is_order'] ) ? null : 1 ?>";
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
        <?php
    }

    public function empty_result()
    {
        ?>
        <tr class="table-secondary">
            <th class="text-center" colspan="<?= 7-$this->post['cols'] ?>">Нет данных</th>
        </tr>
        <?php
    }

}
        
?>