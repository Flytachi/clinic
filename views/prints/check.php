<?php
require_once '../../tools/warframe.php';
is_auth();
?>
<style>
    #invoice-POS{
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        padding:2mm;
        margin: 0 auto;
        width: 44mm;
        background: #FFF;
    }
    ::selection {background: #f31544; color: #FFF;}
    ::moz-selection {background: #f31544; color: #FFF;}
    h1{
      font-size: 1.5em;
      color: #222;
    }
    h2{font-size: .9em;}
    h3{
      font-size: 1.2em;
      font-weight: 300;
      line-height: 2em;
    }
    p{
      font-size: .7em;
      color: #666;
      line-height: 1.2em;
    }

    #top, #mid,#bot{ /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
    }

    #top{min-height: 100px;}
    #mid{min-height: 80px;}
    #bot{ min-height: 50px;}

    #top .logo{
        //float: left;
    	height: 60px;
    	width: 60px;
    	background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
    	background-size: 60px 60px;
    }
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
      //padding: 5px;
      font-size: .5em;
      background: #EEE;
    }
    .service{border-bottom: 1px solid #EEE;}
    .item{width: 24mm;}
    .itemtext{font-size: .5em;}

    #legalcopy{
      margin-top: 5mm;
    }

</style>

<body onload="window.print();">

    <div id="invoice-POS" >

        <center id="top">
            <div class="logo"></div>
            <div class="info">
                <h2>SBISTechs Inc</h2>
            </div>
        </center>

        <div id="mid">

            <div class="info">
                <!-- <h2><?= addZero($_GET['id']) ?></h2> -->
                <p class="h4">
                    <b>№</b>: <?= addZero($_GET['id']) ?></br>
                    <b>ФИО</b>: <?= get_full_name($_GET['id']) ?></br>
                    <b>Дата</b>: <?= date('d.m.Y H:i') ?>
                </p>
            </div>

        </div>

        <div id="bot">

            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item"><h2>Item</h2></td>
                        <td class="Hours"><h2>Qty</h2></td>
                        <td class="Rate"><h2>Sub Total</h2></td>
                    </tr>

                    <?php $total_price = 0; ?>

                    <?php foreach ($db->query("SELECT vs.id, vs.parent_id, vs.add_date, sc.name, sc.price FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = {$_GET['id']} AND vs.priced_date IS NULL") as $row): ?>
                        <tr class="service">
        					<td class="tableitem"><p class="itemtext"><?= $row['name'] ?></p></td>
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
    					<td class="Rate"><h2>Total</h2></td>
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
