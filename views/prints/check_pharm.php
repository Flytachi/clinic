<?php
require_once '../../tools/warframe.php';
is_auth();

$comp = $db->query("SELECT * FROM company")->fetchAll();
foreach ($comp as $value) {
    $company[$value['const_label']] = $value['const_value'];
}
?>
<style>
    #invoice-POS{
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        /*padding:2mm;*/
        margin: 0 auto;
        margin-left: -5px;
        width: 50mm;
        background: #FFF;
    }
    ::selection {background: #f31544; color: #FFF;}
    ::moz-selection {background: #f31544; color: #FFF;}
    h1{
      font-size: 1.5em;
      color: #222;
    }
    h2{font-size: .7em;}
    h3{
      font-size: 1.0em;
      font-weight: 300;
      line-height: 2em;
    }
    p{
      font-size: .7em;
      line-height: 1.2em;
    }

    #top, #mid,#bot{ /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
    }

    #top{min-height: 100px;}
    #mid{min-height: 80px;}
    #bot{ min-height: 50px;}
    .clientlogo{
        float: left;
        height: 60px;
        width: 60px;
        background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
        background-size: 60px 60px;
        border-radius: 50px;
    }
    .info{
      display: block;
      //float:left;
      margin-left: 0;
    }
    .title{
      float: right;
    }
    .title p{text-align: right;}
    table{
      width: 100%;
      border-collapse: collapse;
    }
    td{
      //padding: 5px 0 5px 15px;
      //border: 1px solid #EEE
    }
    .tabletitle{
      background: #9e9e9e;
    }
    .service{border-bottom: 1px solid #EEE;}
    .item{width: 24mm;}
    .itemtext{font-size: .5em;}

    #legalcopy{
      margin-top: 5mm;
    }

</style>

<body style="color: black; font-size: 140%;">

    <div id="invoice-POS" >

        <center>
            <img src="<?= $company['print_header_logotype'] ?>" alt="альтернативный текст" height="100" width="140">
        </center>

        <div id="mid">

            <div class="info">
                <p class="h4">
                    <b>Дата</b>: <?= date('d.m.Y H:i') ?></br>
                </p>
            </div>

        </div>

        <div id="bot">

            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item"><h2>Препарат</h2></td>
                        <td class="Hours"><h2>шт</h2></td>
                        <td class="Rate"><h2>сумма</h2></td>
                    </tr>

                    <?php $total_price = 0; ?>

                    <?php foreach (json_decode($_GET['items']) as $item): ?>
                        <?php $row = $db->query("SELECT name, qty, (amount_cash + amount_card + amount_transfer) 'amount' FROM storage_sales WHERE id = $item")->fetch() ?>
                        <tr class="service" style="font-size:150%;">
        					<td class="tableitem"><p class="itemtext"><?= $row['name'] ?></p></td>
        					<td class="tableitem"><p class="itemtext"><?= $row['qty'] ?></p></td>
        					<td class="tableitem">
                                <p class="itemtext">
                                    <?php
                                    echo number_format($row['amount']);
                                    $total_price += $row['amount'];
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
