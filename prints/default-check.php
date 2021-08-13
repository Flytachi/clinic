<?php
require_once '../tools/warframe.php';
$session->is_auth();
?>
<style>
    #invoice-POS{
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        padding:2mm;
        margin: 0 auto;
        width: 50mm;
        background: #FFF;
    }
    #image{
        text-align: center;
        height: 25mm;
        width: 50mm;
    }
    table{
        width: 50mm;
        border-collapse: collapse;
    }

    ::selection { background: #f31544; color: #FFF; }
    ::moz-selection { background: #f31544; color: #FFF; }
    h1{ font-size: 1.5em; color: #222; }
    h2{ font-size: .7em; }
    h3{ font-size: 1.0em; font-weight: 300; line-height: 2em; }
    p{ font-size: .7em; line-height: 1.2em; }
    
    #top, #mid, #bot{ border-bottom: 1px solid #EEE; }
    #top{ min-height: 60px; }
    #mid{ min-height: 60px; }
    #bot{ min-height: 50px; }

    .tabletitle{ background: #9e9e9e; }
    .service{ border-bottom: 1px solid #EEE; }
    .item{ width: 24mm; }
    .itemtext{ font-size: .5em; }
    #legalcopy{ margin-top: 5mm; }

    .info{
        display: block;
        /* float:left; */
        margin-left: 0;
    }

</style>

<body style="color: black; font-size: 140%;">

    <div id="invoice-POS">

        <div id="top">
            <center><img id="image" src="<?= ( config('print_header_logotype') ) ? config('print_header_logotype') : stack('global_assets/images/placeholders/cover.jpg') ; ?>" alt="Логотип"></center>
        </div>

        <div id="mid">

            <div class="info">
                <span style="text-align: center;">
                    <h2><?= $_GET['pk'] ?></h2>
                </span>
                <p class="h4">
                    <b>ФИО</b>: <?= get_full_name($_GET['pk']) ?></br>
                    <b>Дата</b>: <?= date('d.m.Y H:i') ?></br>
                    <b>Дата рождения</b>: <?= date_f($db->query("SELECT birth_date FROM users WHERE id = {$_GET['pk']}")->fetchColumn()) ?>
                </p>
            </div>

        </div>

        <div id="bot">

            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item"><h2>Услуга</h2></td>
                        <td class="Hours"><h2>шт</h2></td>
                        <td class="Rate"><h2>сумма</h2></td>
                    </tr>

                    <?php $total_price = 0; ?>

                    <?php foreach (json_decode($_GET['items']) as $item): ?>
                        <?php $row = $db->query("SELECT id, item_name, (price_cash + price_card + price_transfer) 'price' FROM visit_prices WHERE id = $item AND price_date IS NOT NULL")->fetch() ?>
                        <tr class="service" style="font-size:150%;">
        					<td class="tableitem"><p class="itemtext"><?= $row['item_name'] ?></p></td>
        					<td class="tableitem"><p class="itemtext">1</p></td>
        					<td class="tableitem">
                                <p class="itemtext">
                                    <?php
                                    echo number_format($row['price']);
                                    $total_price += $row['price'];
                                    ?>
                                </p>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- <tr class="tabletitle">
                        <td></td>
                        <td class="Rate"><h2>tax</h2></td>
                        <td class="payment"><h2>$419.25</h2></td>
                    </tr> -->

                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate"><h2>Итого</h2></td>
                        <td class="payment"><h2><?= number_format($total_price) ?></h2></td>
                    </tr>

                </table>
            </div>

            <!-- <div id="legalcopy">
                <p class="legal">
                    <strong>Thank you for your business!</strong>
                    Payment is expected within 31 days; please process this invoice within that time.
                    There will be a 5% interest charge per month on late invoices.
                </p>
            </div> -->

        </div>

    </div>

</body>
