<?php
require_once '../tools/warframe.php';

$code = bin2hex( basename(__FILE__, '.php').array_to_url($_GET) );
$qr = "http://".config("print_document_qrcode_ip")."/api/document?code=$code";
if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {
    $docs = $db->query("SELECT vs.user_id, vs.parent_id, us.birth_date, vs.service_title, vs.service_report, vs.accept_date FROM visit_services vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.id={$_GET['pk']}")->fetch(PDO::FETCH_OBJ);
    if (!$docs) Mixin\error('404');
}elseif (isset($_GET['pk']) and $_GET['pk'] == "template" ) {
    $docs = new stdClass();
    $docs->user_id = 1;
    $docs->birth_date = date("Y-m-d");
    $docs->accept_date = date("Y-m-d H-i-s");
    $docs->parent_id = 1;
    $docs->service_title = "Test Print Document";
    $docs->service_report = 
        "
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, alias saepe ipsum odio atque sapiente nihil mollitia nulla quam eligendi recusandae 
        iste voluptate illo sunt! Nulla voluptatem fuga facilis laborum recusandae ipsum numquam. Molestias magnam accusantium rem maxime vel dolor repudiandae 
        officiis facilis cumque unde amet culpa maiores quo quae illo voluptates error ad eligendi provident eveniet, soluta, dolore debitis fuga obcaecati. 
        Iste vero illo voluptatem soluta nesciunt quas ipsa nostrum rerum, hic ut! Laborum deleniti rerum amet quas numquam eligendi temporibus ducimus ipsum 
        qui libero praesentium modi, ut quod nisi blanditiis id mollitia incidunt perferendis iste quibusdam. Saepe non fuga voluptatibus eius aspernatur 
        cupiditate sunt ab adipisci commodi, fugit velit omnis excepturi harum atque nam dolor praesentium neque optio ipsa eveniet maiores ut. Ullam dignissimos 
        omnis aliquam sit, eaque facilis nam suscipit quo, aperiam aspernatur natus corporis, sapiente eligendi quae. Dolore in eligendi dignissimos quasi officia 
        facere incidunt vel laborum temporibus. Nihil reprehenderit quisquam minima eos blanditiis molestias ea cumque saepe tenetur, fuga voluptates sunt 
        doloremque adipisci. Quis architecto beatae deserunt dolore repudiandae obcaecati vero, odio facere esse doloremque alias in sint. Blanditiis, vitae rerum? 
        Quasi consequuntur unde animi! Inventore dolor veniam dicta deserunt optio ut vel? Ducimus quam odit dignissimos fugiat nam, unde doloremque quo? Molestias 
        aliquid velit dolorum cumque est quo aspernatur quos itaque. Fuga cumque itaque qui ut, odit adipisci corrupti rerum dignissimos, numquam nihil voluptatem 
        praesentium quam possimus id, et porro fugiat eveniet expedita molestiae? Repudiandae blanditiis cum nihil architecto asperiores in, nam tempora autem? 
        Quos ratione atque temporibus itaque hic, aperiam laboriosam quisquam voluptate quibusdam ea sunt autem velit, officiis, explicabo rerum esse laudantium 
        possimus architecto sit corporis. Non, consequuntur aspernatur id voluptas perspiciatis facilis recusandae quo illum autem sequi nemo voluptates voluptate 
        nobis, libero aliquam deserunt nam maxime ipsa quos quas unde cupiditate.
        ";
}else{
    Mixin\error('404');
}
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("assets/my_css/document.css") ?>">

    <body>

        <div class="row">

            <?php $block = (config('print_document_blocks') < 5) ? 12 / config('print_document_blocks') : 3; ?>

            <?php for ($i=1; $i <= config('print_document_blocks'); $i++): ?>
                
                <div class="col-<?= $block ?> text-<?= config("print_document_$i-aligin") ?>">
                    
                    <?php if ( config("print_document_$i-type") ): ?>
                        <img
                            class="img-fluid shadow-1 <?= (config("print_document_$i-logotype-is_circle") ) ? 'rounded-circle': '' ?>"
                            src="<?= ( config("print_document_$i-logotype") ) ? config("print_document_$i-logotype") : stack('global_assets/images/placeholders/cover.jpg') ; ?>" 
                            height="<?= ( config("print_document_$i-logotype-height") ) ? config("print_document_$i-logotype-height") : 120 ?>"
                            width="<?= ( config("print_document_$i-logotype-width") ) ? config("print_document_$i-logotype-width") : 400 ?>"
                        >
                    <?php else: ?>

                        <?php for ($t=1; $t <= $print_text_count; $t++): ?>

                            <?php if ( config("print_document_$i-text-$t") ): ?>
                                <span 
                                    class="<?= ( config("print_document_$i-text-$t-is_bold") ) ? 'font-weight-bold' : '' ?>" 
                                    style="font-size:<?= config("print_document_$i-text-$t-size") ?>px; color:<?= config("print_document_$i-text-$t-color") ?>"
                                ><?= config("print_document_$i-text-$t") ?></span><br>
                            <?php endif; ?>

                        <?php endfor; ?>

                    <?php endif; ?>
                

                </div>
            <?php endfor; ?>

        </div>

        <?php if (config("print_document_hr-1")) echo '<div class="my_hr-1" style="border-color:'.config("print_document_hr-1-color").'"></div>' ; ?>
        <?php if (config("print_document_hr-2")) echo '<div class="my_hr-2" style="border-color:'.config("print_document_hr-2-color").'"></div>' ; ?>

        <div class="row">
            <div class="col-8 text-left h3">
                <b>Ф.И.О.: </b><?= get_full_name($docs->user_id) ?><br>
                <b>ID Пациента: </b><?= addZero($docs->user_id) ?><br>
                <b>Дата рождения: </b><?= ($docs->birth_date) ? date_f($docs->birth_date) : '<span class="text-muted">Нет данных</span>' ?><br>
                <b>Дата исследования: </b><?= ($docs->accept_date) ? date_f($docs->accept_date, 1) : '<span class="text-muted">Нет данных</span>' ?><br>
                <b>Врач: </b><?= get_full_name($docs->parent_id) ?><br>
            </div>
            <div class="col-4 text-right">
                <?php if (config("print_document_qrcode")): ?>
                    <img src="<?= apiMy('QRcode', $qr); ?>" width="150" height="150">
                <?php endif; ?>
            </div>
        </div>

        <?php if (config("print_document_hr-3")) echo '<div class="my_hr-1" style="border-color:'.config("print_document_hr-3-color").'"></div>' ; ?>
        <?php if (config("print_document_hr-4")) echo '<div class="my_hr-2" style="border-color:'.config("print_document_hr-4-color").'"></div>' ; ?>

        <div class="text-left">

            <h3 class="text-center h1"><b><?= $docs->service_title ?></b></h3>
            <div class="h3">
                <?= $docs->service_report ?>
            </div>

        </div>

        <div class="btn_panel text-center">
            <button class="btn btn-sm" onclick="print();">Печать</button>
        </div>

    </body>

</html>