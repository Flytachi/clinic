<?php

use Mixin\Hell;
require_once '../tools/warframe.php';

// 
if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {
    $docs = $db->query("SELECT v.id, v.user_id, v.grant_id, v.parad_id, us.birth_date, v.add_date, v.completed, v.division_id, v.icd_id FROM visits v LEFT JOIN users us ON(us.id=v.user_id) WHERE v.id={$_GET['pk']} AND v.direction IS NOT NULL")->fetch(PDO::FETCH_OBJ);
    $data = (new UserModel)->byId($docs->user_id);
    $visit = (new VisitServicesModel)->Where("visit_id = $docs->id AND service_id = 1")->get();
    $dig = (new VisitModel)->Where("user_id = $docs->user_id AND direction IS NULL AND completed IS NOT NULL")->Order("completed DESC")->get();
    $initial = (new VisitInitialModel)->Where("visit_id = $docs->id")->get();
}else Hell::error('404');

function persic($qty=0, $str=""){
    $reponce = "";
    for ($i=0; $i <= ($qty-strlen($str)); $i++) $reponce .= "_";
    return  "<em style=\"color: blue;\">" . $reponce.$str . "</em>";
}
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("assets/my_css/document.css") ?>">

    <body style="line-height: 1.65;">

        <div class="row">

            <div class="col-6 text-center mt-3">
                <strong style="font-size: 20px;">
                    Ўзбекистон Республикаси <br>
                    соғлиқни сақлаш вазиринин <br>
                    бухарский областной многопрофильный медицинский центр
                </strong>
            </div>
            <div class="col-6 text-center">
                <strong style="font-size: 17px;">
                    Ўзбекистон Республикаси<br>
                    Соғлиқни сақлаш вазиринин<br>
                    2020 йил 31 декабрдаги 363-сонли<br>
                    буйруғи билан тасдиқланган<br>
                    003-рақамли тиббий ҳужжат шакли
                </strong>
            </div>

            <div class="col-12 text-center mt-1">
                <h2><b>СТАЦИОНАР БЕМОРНИНГ ТИББИЙ КАРТАСИ № __</b></h2>
            </div>
            
        </div>

        <div class="row" style="font-size: 22px;">
            <div class="col-12 text-justify">
                Касалхонага ётқизилган кун <?= persic(30, date_f($docs->add_date, "d.m.Y")) ?> вақти <?= persic(14, date_f($docs->add_date, "H:i")) ?>
                Касалхонадан чиқарилган кун <?= persic(28, ($docs->completed) ? date_f($docs->completed, "d.m.Y") : null) ?> вақти <?= persic(14, ($docs->completed) ? date_f($docs->completed, "H:i") : null) ?>
                <?= persic(34, (new DivisionModel)->byId($docs->division_id)->name) ?> бўлими,хона №_____________________________________ <!-- палата + койка-->
                Бўлимга _______________________________________________________________________________
                ____________________________________________________________________________ ўтказилган
                __________________________________________ кун ётиб даволанган ____________________
                Беморни олиб юриш турлари: аравачада, замбилда, ўзи юра олади (чизинг)<br>
                Қон гуруҳи _________________________ резус мансублиги ___________________________
                Дориларнинг ножўя таъсири __________________________________________________________
                __________________________________________________________________________________________
                <small style="margin-left: 30%;">(дорининг номи, ножўя таъсирнинг кўриниши)</small><br>
                __________________________________________________________________________________________
                ФИО: <?= persic(65, "$data->last_name $data->first_name $data->father_name") ?>
                2. Жинси <?= persic(7, ($data->gender) ? "Мужской" : "Женский") ?>
                3.Туғилган сана: кун <?= persic(7, date_f($data->birth_date, "d")) ?> ой <?= persic(17, date_f($data->birth_date, "m")) ?> йил <?= persic(25, date_f($data->birth_date, "Y")) ?>
                Бўйи <?= persic(16, ($initial) ? $initial->height : null ) ?>, вазни <?= persic(15, ($initial) ? $initial->weight : null ) ?>, тана ҳарорати <?= persic(20, ($initial) ? $initial->temperature : null ) ?>
                Доимий яшаш жойи: шаҳар, қишлоқ (чизинг)<br>
                <?= persic(89, "$data->province, $data->region $data->address_residence/$data->address_registration") ?><br>
                <small style="margin-left: 10%;">(яшаш жойи кўрсатилсин, вилоят ва туманлардан келганлар учун манзили ва яқин</small><br>
                <?= persic(86, "$data->phone_number") ?>
                <small style="margin-left: 15%;">қариндошларининг яшаш жойи ва телефон рақамлари кўрсатилсин)</small><br>
                6.Иш жойи, касби, лавозими <?= persic(60-10, "$data->work_place $data->work_position") ?>
                __________________________________________________________________________________________
                __________________________________________________________________________________________
                ногиронлар учун-ногиронликнинг тури ва гуруҳи; уруш ногиронликнинг
                __________________________________________________________________________________________
                <small style="margin-left: 47%;">ҳа, йўқ)</small><br>
                7.Бемор қаердан юборилган <?= persic(55, ($visit->guide_id) ? (new GuidesModel)->byId($visit->guide_id)->name : null) ?>
                <small style="margin-left: 55%;">(даволаш муассасасининг номи)</small><br>
                8.Касалхонага шошилинч равишда келтирилган: ҳа, йўқ _____________________________
                Қандай транспортда ___________________________________________________________________
                Касаллик бошлангандан сўнг ўтган вақт, жароҳатдан сўнг, режали равишда 
                9.Бемор йўлланмасидаги ташҳис <?= persic(50, ($dig and $dig->icd_id) ? icd($dig->icd_id, "decryption")['decryption'] : null) ?>
                __________________________________________________________________________________________
            </div>
        </div>

    </body>

</html>