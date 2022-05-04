<?php
require_once '../../../tools/warframe.php';
?>
<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
    <li class="nav-item"><a onclick="Detail_control('<?= viv('reports/income/detail_1') ?>')" href="#" class="nav-link legitRipple active show" data-toggle="tab">Амбулаторные Консультации</a></li>
    <li class="nav-item"><a onclick="Detail_control('<?= viv('reports/income/detail_2') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Амбулаторные Услуги</a></li>
    <li class="nav-item"><a onclick="Detail_control('<?= viv('reports/income/detail_3') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Стационарные Консультации</a></li>
    <li class="nav-item"><a onclick="Detail_control('<?= viv('reports/income/detail_4') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Стационарные Услуги</a></li>
    <li class="nav-item"><a onclick="Detail_control('<?= viv('reports/income/detail_5') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Стационарные Осмотры</a></li>
    <li class="nav-item"><a onclick="Detail_control('<?= viv('reports/income/detail_6') ?>')" href="#" class="nav-link legitRipple" data-toggle="tab">Стационарные Дипозиты</a></li>
</ul>

<div class="table-responsive" id="div_show_detail">
    <script>
        $(document).ready(function(){
            Detail_control('<?= viv('reports/income/detail_1') ?>');
        });
    </script>
</div>