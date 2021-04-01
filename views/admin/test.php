<?php 
require_once '../../tools/warframe.php';
prit($_POST);
?>
<h1>Label:</h1> <?php echo $_POST['label'] ?>
<h1>Password:</h1> <?php echo $_POST['pass'] ?> 
<select id="">
<?php
foreach ($db->query("SELECT * FROM region WHERE province_id = {$_POST['province']}") as $row) {
echo "<option value='".$row['id']."'>".$row['name']."</option>";}
?>
</select>
<?php
                            foreach($db->query('SELECT * FROM wards') as $row) {
                                foreach($db->query("SELECT * FROM beds WHERE ward_id = {$row['id']}") as $row1) {
                                ?>
                                <tr>
                                    <td><?= $row['floor'] ?></td>
                                    <td><?= $row['ward'] ?></td>
                                    <td><?= $row1['bed'] ?></td>
                              </tr>
                               
                   <?php
                           }}?> 
                           <?php
                for ($i=0; $i < 30; $i++) { 
                    $date = new DateTime('+'.$i.' day');
                    echo ' <td colspan="'.count($times).'" class="trasform_text">'.$date->format('d.m.Y').'</td>';
                }
                ?>   