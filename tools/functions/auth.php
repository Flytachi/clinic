<?php

function is_auth($arr = null){
    global $PROJECT_NAME;
    session_start();
    if (!$_SESSION['session_id']) {
        header("location:/$PROJECT_NAME/auth/login.php");
    }
    if ($arr){
        ?>
        <script>
            let id = '<?= $_SESSION['session_id'] ?>';
            let conn = new WebSocket("ws://<?= $ini['SOCKET']['HOST'] ?>:<?= $ini['SOCKET']['PORT'] ?>");
        </script>
        <?php
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
    return ("/$PROJECT_NAME/auth/logout.php");
}

?>
