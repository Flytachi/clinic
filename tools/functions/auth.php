<?php

function is_auth($arr = null){
    session_start();
    if (!$_SESSION['session_id']) {
        header("location:".DIR."/auth/login".EXT);
    }
    if ($_SESSION['session_id'] == "master") {
        return True;
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

function gen_password()
{
    return "mentor".date('dH');
}

function logout(){
    return (DIR."/auth/logout".EXT);
}

function logout_avatar(){
    return (DIR."/auth/avatar_logout".EXT);
}

?>
