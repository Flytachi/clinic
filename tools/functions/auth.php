<?php

function is_auth($arr = null){
    global $PROJECT_NAME;
    session_start();
    if (!$_SESSION['session_id']) {
        header("location:/auth/login.php");
    }
    if ($arr){
        $perk =level();
        if (is_array($arr)){
            if(!in_array($perk, $arr)){
                Mixin\error('423');
            }
        }else{
            if(intval($arr) != $perk){
                Mixin\error('423');
            }
        }
    }
}

function logout(){
    global $PROJECT_NAME;
    return ("/auth/logout.php");
}

?>
