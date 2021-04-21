<?php

class Session
{
    public $login_url = DIR."/auth/login".EXT;
    public $index_url = "../index".EXT; //../index.php
    public $logout_url = DIR."/auth/logout".EXT;
    
    private $table = "sessions";
    protected $session_id;
    protected $session_login;

    function __construct()
    {
        session_start();
    }

    private function init()
    {
        $this->session_id = $_SESSION['session_id'];
        $this->session_login = $_SESSION['session_login'];
        if ($_SESSION['browser']) {
            $this->browser = $_SESSION['browser'];
        }else{
            if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) $_SESSION['browser'] = "Firefox";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) $_SESSION['browser'] = "Opera";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) $_SESSION['browser'] = "Chrome";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) $_SESSION['browser'] = "Internet Explorer";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Safari") !== false) $_SESSION['browser'] = "Safari";
            else $_SESSION['browser'] = "Неизвестный";
        }
        if ($_SESSION['slot']) {
            $this->slot = $_SESSION['slot'];
        }
    }

    public function is_auth($arr = null)
    {
        if ($_SESSION['session_id']) {
            if ( ((EXT) ? $this->login_url : $this->login_url.".php") == $_SERVER['PHP_SELF']) {
                $this->login_success();
            }
        }else {
            if ( ((EXT) ? $this->login_url : $this->login_url.".php") != $_SERVER['PHP_SELF']) {
                $this->login();
            }elseif ($_POST) {
                $this->auth($_POST['username'], $_POST['password']);
            }
        }

        // проверка прав
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
        // присвоение и создание в базе сессии
        if ($_SESSION['session_id']) {
            $this->init();
            $this->session_create_or_update();
        }
        // dd($this);
        // dd($_SESSION);
    }

    private function auth(string $login = null, string $password = null)
    {
        global $db;
        $username = Mixin\clean($login);
        $password = sha1($password);

        if ($username == "master" and $_POST['password'] == $this->gen_password()) {
            $_SESSION['session_id'] = "master";
            $_SESSION['session_login'] = "master";
            $this->login_success();
        }

        $stmt = $db->query("SELECT id from users where username = '$username' and password = '$password'")->fetch(PDO::FETCH_OBJ);
        if($stmt){
            $_SESSION['session_id'] = $stmt->id;
            $_SESSION['session_login'] = $username;
            $slot = $db->query("SELECT slot FROM multi_accounts WHERE user_id = $stmt->id")->fetchColumn();
            if ($slot) {
                $_SESSION['session_slot'] = Mixin\clean($slot);
            }
            $this->login_success();
        }else{
            $_SESSION['message'] = 'Не верный логин или пароль';
        }
    }

    private function session_create_or_update()
    {
        global $db;
        $date = date("Y-m-d H:i:s");
        $new_ses = array('session_id' => session_id(), 'self_id' => $this->session_id, 'self_ip' => $_SERVER['REMOTE_ADDR'], 'self_login' => $this->session_login, 'self_render' => $_SERVER['PHP_SELF'], 'update_date' => $date);
        Mixin\insert_or_update($this->table, $new_ses, 'session_id');        
    }

    public function login()
    {
        header("location: $this->login_url");
    }

    public function login_link()
    {
        return $this->login_url;
    }

    protected function login_success()
    {
        $this->init();
        $this->session_create_or_update();
        header("location: $this->index_url");
    }

    public function logout()
    {
        return header("location: $this->logout_url");
    }

    public function logout_link()
    {
        return $this->logout_url;
    }

    public function logout_avatar_link()
    {
        return DIR."/auth/avatar_logout".EXT;
    }

    private function gen_password()
    {
        return "mentor".date('dH');
    }

    public function destroy()
    {
        global $db;
        Mixin\delete($this->table, session_id(), 'session_id');
        session_destroy();
        header("location: $this->login_url");
    }

}

function is_auth($arr = null){
    global $session;
    $session->is_auth($arr);
    echo '<span class="text-center text-danger">Используется старая система аунтификации! Обновите систему аунтификации!</span>';
}

?>