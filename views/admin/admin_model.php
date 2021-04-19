<?php
require_once '../../tools/warframe.php';
is_auth(1);

if ($_POST['const_foreigner_sale']) {

    $sale = Mixin\insert_or_update("company", array('const_label' => "const_foreigner_sale", 'const_value' => $_POST['const_foreigner_sale']), "const_label");
    
    if ($sale == 0) {
        $_SESSION['message'] .= '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Новые данные записаны.
        </div>
        ';
    }else {
        $_SESSION['message'] .= '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Данные обновлены.
        </div>
        ';
    }
    
}else {
    
    if ($_FILES['print_header_logotype']['name']) {

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
    
                $select = $db->query("SELECT const_value FROM company WHERE const_label = 'print_header_logotype'")->fetchColumn();
                if ($select) {
                    unlink($_SERVER['DOCUMENT_ROOT'].DIR.$select);
                }
                $logo = Mixin\insert_or_update("company", array('const_label' => "print_header_logotype", 'const_value' => "/storage/".$newFileName), "const_label");
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
    
    }else{
        $_SESSION['message'] = "";
    }
    
    if ($_POST) {
    
        $tit = Mixin\insert_or_update("company", array('const_label' => "print_header_title", 'const_value' => $_POST['print_header_title']), "const_label");
        $adr = Mixin\insert_or_update("company", array('const_label' => "print_header_address", 'const_value' => $_POST['print_header_address']), "const_label");
        $tel = Mixin\insert_or_update("company", array('const_label' => "print_header_phones", 'const_value' => $_POST['print_header_phones']), "const_label");
    
        if ($tit + $adr + $tel == 0) {
            $_SESSION['message'] .= '
            <div class="alert alert-primary" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Новые данные записаны.
            </div>
            ';
        }else {
            $_SESSION['message'] .= '
            <div class="alert alert-primary" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Данные обновлены.
            </div>
            ';
        }
    
    }

}

render();
?>
