<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

// logo
if ( isset($_FILES['constant_print_header_logotype']) and $_FILES['constant_print_header_logotype']['name'] ) {

    if ($_FILES['constant_print_header_logotype']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['constant_print_header_logotype']['tmp_name'];
        $fileName = $_FILES['constant_print_header_logotype']['name'];
        $fileSize = $_FILES['constant_print_header_logotype']['size'];
        $fileType = $_FILES['constant_print_header_logotype']['type'];

        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = sha1(time() . $fileName) . '.' . $fileExtension;
        $allowedfileExtensions = array('jpg', 'png');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = $_SERVER['DOCUMENT_ROOT'].DIR."/storage/images/";
            $dest_path = $uploadFileDir . $newFileName;

            $select = $db->query("SELECT const_value FROM company_constants WHERE const_label = 'constant_print_header_logotype'")->fetchColumn();
            if ($select) {
                unlink($_SERVER['DOCUMENT_ROOT'].DIR.$select);
            }
            $logo = Mixin\insert_or_update("company_constants", array('const_label' => "constant_print_header_logotype", 'const_value' => "/storage/images/".$newFileName), "const_label");
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
    $_SESSION['message'] .= '
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
        Нет данных!
    </div>
    ';
    render();
}

?>
