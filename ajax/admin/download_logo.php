<?php

foreach ($_FILES as $KEY => $FILE) {

    if ( $FILE['name'] ) {

        if ($FILE['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $FILE['tmp_name'];
            $fileName = $FILE['name'];
            $fileSize = $FILE['size'];
            $fileType = $FILE['type'];
    
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = sha1(time() . $fileName) . '.' . $fileExtension;
            $allowedfileExtensions = array('jpg', 'png');
    
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $uploadFileDir = $_SERVER['DOCUMENT_ROOT'].DIR."/storage/images/";
                $dest_path = $uploadFileDir . $newFileName;
    
                $select = $db->query("SELECT const_value FROM company_constants WHERE const_label = '$KEY'")->fetchColumn();
                if ($select) {
                    unlink($_SERVER['DOCUMENT_ROOT'].DIR.$select);
                }
                $logo = Mixin\insert_or_update("company_constants", array('const_label' => $KEY, 'const_value' => "/storage/images/".$newFileName), "const_label");
                if(!(intval($logo) >= 0)){
                    $_SESSION['message'] = '
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Error writing to database or saving file!
                    </div>
                    ';
                    render();
                }
                if (!move_uploaded_file($fileTmpPath, $dest_path)) {
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

}

?>
