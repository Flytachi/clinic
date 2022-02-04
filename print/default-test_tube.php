<?php
require_once '../tools/warframe.php';
$session->is_auth();
is_module('laboratory');
?>
<style>
    #invoice-POS{
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        /*padding:2mm;*/
        margin: 0 auto;
        width: 56mm;
        background: #FFF;
    }
    ::selection {background: #f31544; color: #FFF;}
    ::moz-selection {background: #f31544; color: #FFF;}
    #mid{
        border-bottom: 1px solid #EEE;
        min-height: 80px;
    }
    .info{
      display: block;
      /* float:left; */
      margin-left: 3px;
    }

</style>

<body> 

    <div id="invoice-POS">

        <div id="mid">

            <div class="info">
                <b>ID:</b> <?= $_GET['pk'] ?></br>
                <b>FIO:</b> <?= get_full_name($_GET['pk']) ?></br>
                <b>Date:</b> <?= date('d.m.Y H:i') ?>
            </div>

        </div>

    </div>

</body>
