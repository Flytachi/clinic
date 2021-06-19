<?php
require_once '../../tools/warframe.php';

$docs = $db->query("SELECT * FROM users WHERE id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <style>
        .tir{
            border:0;
            border-bottom: 1px solid #000000;
        }
    </style>

    <body>

        <div class="row">

            <div class="col-6 h4">
                <b>
                    O‘zbekiston Respublikasi sog‘liqni saqlash vazirligi<br>
                    “ULUG‘BEK ULTRAMED”xususiy klinikasi 
                </b>  
            </div>

            <div class="col-6 text-right h4">
                <b>
                    25.12.2017 yil 777-buyruq<br>
                    bilan tasdiqlangan 025/h tibbiy hujjat
                </b>
            </div>

        </div>

        <div class="my_hr-1"></div>
        <div class="my_hr-2"></div>

        <div class="text-left">

            <h2 class="text-center"><b>Амбулатор беморнинг тиббий картаси №</b></h2>

            <div class="row">

                <div class="col-6 h4">
                    <b>Ф.И.О.: </b><?= get_full_name($docs->id) ?><br>
                    <b>Телефон номер: </b><?= addZero($docs->numberPhone) ?><br>
                    <b>Уй манзили: </b><?= $docs->registrationAddress ?><br>
                </div>

                <div class="col-6 text-right h4">
                    <b>Жинси: </b><?= ($docs->gender) ? "Эркак" : "Аёл" ?><br>
                    <b>Тугилган санаси: </b><?= date('d.m.Y', strtotime($docs->dateBith)) ?><br>
                    <b>Иш (укиш) жойи: </b><?= $docs->placeWork ?><br>
                </div>

            </div>
            
            <div class="h3">

                <div class="row">
                    <div class="col-1">Диагноз:</div>
                    <div class="col-11 tir"></div>
                </div>
                <div class="row">
                    <div class="col-1"><b>Сана:</b></div>
                    <div class="col-5 tir"></div>
                    <div class="col-1"><b>Вакт:</b></div>
                    <div class="col-5 tir"></div>
                </div>
                <div class="row">
                    <div class="col-3"><b>Беморнинг шикоятлари:</b></div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row"><div class="col-12 tir">.</div></div>
                <div class="row"><div class="col-12 tir">.</div></div>
                <div class="row"><div class="col-12 tir">.</div></div>

                <div class="row">
                    <div class="col-2"><b>Анамнези:</b></div>
                    <div class="col-10 tir"></div>
                </div>
                <div class="row"><div class="col-12 tir">.</div></div>
                <div class="row"><div class="col-12 tir">.</div></div>
                <div class="row"><div class="col-12 tir">.</div></div>

                <div class="row">
                    <div class="col-3"><b>Зарарли одатлари:</b></div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row">
                    <div class="col-3"><b>Аллергик анамнези:</b></div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row">
                    <div class="col-3"><b>Эпид анамнези:</b></div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row">
                    <div class="col-4"><b>Нафас олиш системаси шикояти:</b></div>
                    <div class="col-8 tir"></div>
                </div>
                <div class="row">
                    <div class="col-1">НОС</div>
                    <div class="col-5 tir"></div>
                    <div class="col-2">Сатурация</div>
                    <div class="col-4 tir"></div>
                </div>
                <div class="row">
                    <div class="col-3">Упка аускультацияси:</div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row"><div class="col-12 tir">.</div></div>
                <div class="row"><div class="col-12 tir">.</div></div>
                <div class="row"><div class="col-12 tir">.</div></div>

                <div class="row">
                    <div class="col-5">Юрак кон томир системаси шикояти:</div>
                    <div class="col-7 tir"></div>
                </div>
                <div class="row">
                    <div class="col-1">А/Д</div>
                    <div class="col-5 tir"></div>
                    <div class="col-1">Пульс</div>
                    <div class="col-5 tir"></div>
                </div>
                <div class="row">
                    <div class="col-3">Юрак аускультацияси:</div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row">
                    <div class="col-5"><b>Овкат хазм килиш системаси шикояти:</b></div>
                    <div class="col-7 tir"></div>
                </div>
                <div class="row">
                    <div class="col-3">Объектив курув:</div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row"><div class="col-12 tir">.</div></div>
                <div class="row"><div class="col-12 tir">.</div></div>

                <div class="row">
                    <div class="col-5"><b>Сийдик ажратиш системаси шикояти:</b></div>
                    <div class="col-7 tir"></div>
                </div>
                <div class="row">
                    <div class="col-3">Туккиллатиш симптоми:</div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row">
                    <div class="col-3"><b>Асаб тизими шикояти:</b></div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row">
                    <div class="col-3">Патологик рефлекслар:</div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row"><div class="col-12 tir">.</div></div>
                <div class="row"><div class="col-12 tir">.</div></div>

                <div class="row">
                    <div class="col-3"><b>Дастлабки диагноз:</b></div>
                    <div class="col-9 tir"></div>
                </div>
                <div class="row"><div class="col-12 tir">.</div></div>
                <div class="row"><div class="col-12 tir">.</div></div>

                <div class="row">
                    <div class="col-5"><b>Лаборатор инструментал текширувлар:</b></div>
                    <div class="col-7 tir"></div>
                </div>
                <div class="row"><div class="col-12 tir">.</div></div>
                <div class="row"><div class="col-12 tir">.</div></div>
            </div>

        </div>

    </body>

</html>
