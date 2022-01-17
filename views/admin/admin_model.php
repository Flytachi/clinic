<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

// Print
if ( isset($_POST['print_header_title']) ) Mixin\insert_or_update("company_constants", array('const_label' => "print_header_title", 'const_value' => $_POST['print_header_title']), "const_label");
if ( isset($_POST['print_header_address']) ) Mixin\insert_or_update("company_constants", array('const_label' => "print_header_address", 'const_value' => $_POST['print_header_address']), "const_label");
if ( isset($_POST['print_header_phones']) ) Mixin\insert_or_update("company_constants", array('const_label' => "print_header_phones", 'const_value' => $_POST['print_header_phones']), "const_label");
if ( isset($_POST['print_check_size']) ) Mixin\insert_or_update("company_constants", array('const_label' => "print_check_size", 'const_value' => $_POST['print_check_size']), "const_label");
Mixin\insert_or_update("company_constants", array('const_label' => "print_type_center", 'const_value' => $_POST['print_type_center']), "const_label");

// Floor
if ( isset($_POST['floors']) ) Mixin\insert_or_update("company_constants", array('const_label' => "floors", 'const_value' => json_encode($_POST['floors'])), "const_label");

if ( isset($_POST['const_throughput_from']) ) Mixin\insert_or_update("company_constants", array('const_label' => "const_throughput_from", 'const_value' => $_POST['const_throughput_from']), "const_label");
if ( isset($_POST['const_throughput_before']) ) Mixin\insert_or_update("company_constants", array('const_label' => "const_throughput_before", 'const_value' => $_POST['const_throughput_before']), "const_label");


// Diet
if ( isset($_POST['const_diet_time']) ) Mixin\insert_or_update("company_constants", array('const_label' => "const_diet_time", 'const_value' => json_encode($_POST['const_diet_time'])), "const_label");

// Pacs
if ( isset($_POST['const_zetta_pacs_IP']) ) Mixin\insert_or_update("company_constants", array('const_label' => "const_zetta_pacs_IP", 'const_value' => $_POST['const_zetta_pacs_IP']), "const_label");
if ( isset($_POST['const_zetta_pacs_LICD']) ) Mixin\insert_or_update("company_constants", array('const_label' => "const_zetta_pacs_LICD", 'const_value' => $_POST['const_zetta_pacs_LICD']), "const_label");
if ( isset($_POST['const_zetta_pacs_VTYPE']) ) Mixin\insert_or_update("company_constants", array('const_label' => "const_zetta_pacs_VTYPE", 'const_value' => $_POST['const_zetta_pacs_VTYPE']), "const_label");

// Logo
if ( isset($_FILES['print_header_logotype']) and $_FILES['print_header_logotype']['name'] ) {

    if ($_FILES['print_header_logotype']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['print_header_logotype']['tmp_name'];
        $fileName = $_FILES['print_header_logotype']['name'];
        $fileSize = $_FILES['print_header_logotype']['size'];
        $fileType = $_FILES['print_header_logotype']['type'];

        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = sha1(time() . $fileName) . '.' . $fileExtension;
        $allowedfileExtensions = array('jpg', 'png');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = $_SERVER['DOCUMENT_ROOT'].DIR."/storage/";
            $dest_path = $uploadFileDir . $newFileName;

            $select = $db->query("SELECT const_value FROM company_constants WHERE const_label = 'print_header_logotype'")->fetchColumn();
            if ($select) {
                unlink($_SERVER['DOCUMENT_ROOT'].DIR.$select);
            }
            $logo = Mixin\insert_or_update("company_constants", array('const_label' => "print_header_logotype", 'const_value' => "/storage/".$newFileName), "const_label");
            if(intval($logo) >= 0 and move_uploaded_file($fileTmpPath, $dest_path)){
                $_SESSION['message'] = '
                <div class="alert alert-primary" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    File is successfully uploaded.
                </div>
                ';
            }else{
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    Error writing to database or saving file!
                </div>
                ';
                render();
            }

        }else {
            $_SESSION['message'] = '
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Error unsupported file format!
            </div>
            ';
            render();
        }
    }else {
        $_SESSION['message'] = '
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Error loading to temporary folder!
        </div>
        ';
        render();
    }

}

$_SESSION['message'] .= '
<div class="alert alert-primary" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
    Данные внесены.
</div>
';

render();
?>
