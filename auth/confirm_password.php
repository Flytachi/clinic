<?php
require_once '../tools/warframe.php';
$pk = $_SESSION['session_id'];

if ( isset($_POST['password']) ) {
    
    if($db->query("SELECT password FROM users WHERE id = $pk AND is_active IS NOT NULL")->fetchColumn() == sha1($_POST['password'])){
        $session->get_session_create_or_update();
        unset($_SESSION['session_timeout_logout']);
        echo 200;
    }else{
        echo "Invalid password";
    }

}else{
    echo "No matching data";
}

?>