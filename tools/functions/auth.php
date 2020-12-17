<?php

function is_auth($arr = null){
    session_start();
    if (!$_SESSION['session_id']) {
        header("location:".DIR."/auth/login.php");
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
    return ("/auth/logout.php");
}

?>
