<?php

class Session
{
    public $login_url = DIR."/auth/login".EXT;
    public $index_url = "../index".EXT; //../index.php
    public $logout_url = DIR."/auth/logout".EXT;
    
    private $table = "sessions";
    public $session_id;
    public $session_login;
    public $session_browser;
    public $session_slot;

    function __construct()
    {
        session_set_save_handler(
            array($this, '_open'),
            array($this, '_close'),
            array($this, '_read'),
            array($this, '_write'),
            array($this, '_destroy'),
            array($this, '_gc')
        );
        if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) $this->session_browser = "Firefox";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) $this->session_browser = "Opera";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) $this->session_browser = "Chrome";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) $this->session_browser = "Internet Explorer";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Safari") !== false) $this->session_browser = "Safari";
        else $this->session_browser = "Неизвестный";
        session_start();
        // dd($_SESSION);
        
    }

    private function init()
    {
        if (!$_SESSION) {
            $_SESSION['session_id'] ??= $this->session_id;
            $_SESSION['session_login'] ??= $this->session_login;
            $_SESSION['session_browser'] ??= $this->session_browser;
            $_SESSION['session_slot'] ??= $this->session_slot;
            return $_SESSION;
        } else {
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
            return $_SESSION;
        }
    }

    public function is_auth($arr = null)
    {
        dd($_SESSION);
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
    }

    private function auth(string $login = null, string $password = null)
    {
        global $db;
        $username = Mixin\clean($login);
        $password = sha1($password);

        // if ($username == "master" and $_POST['password'] == $this->gen_password()) {
        //     $this->session_id = "master";
        //     $this->session_login = "master";
        //     $this->login_success();
        // }

        $stmt = $db->query("SELECT id from users where username = '$username' and password = '$password'")->fetch(PDO::FETCH_OBJ);
        if($stmt){
            $this->session_id = $stmt->id;
            $this->session_login = $username;
            $slot = $db->query("SELECT slot FROM multi_accounts WHERE user_id = $stmt->id")->fetchColumn();
            if ($slot) {
                $this->session_slot = Mixin\clean($slot);
            }
            $this->login_success();
        }else{
            $_SESSION['message'] = 'Не верный логин или пароль';
        }
    }

    private function session_create_or_update($data = null)
    {
        global $db;
        $date = date("Y-m-d H:i:s");
        $new_ses = array(
            'session_id' => $this->sid, 
            'self_id' => $this->session_id, 
            'self_ip' => $_SERVER['REMOTE_ADDR'], 
            'self_login' => $this->session_login, 
            'self_render' => $_SERVER['PHP_SELF'], 
            'update_date' => $date);
        if ($data) {
            $new_ses['self_data'] = $data;
        }
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
        $this->session_create_or_update($this->init());
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

    public function _open($savePath, $sessionName) {
        // ... code ...
        $this->session_create_or_update($this->init());
        parad("open", $this);
        return true;
    }
 
    public function _close() {
        // ... code ...
        parad("end", $this);
        return true;
    }
 
    public function _read($id) {
        global $db;
        $this->sid = $id;
        $result = $db->query("SELECT * FROM $this->table WHERE session_id = \"$id\"")->fetch();
        if ($result){
            $this->session_create_or_update($this->init());
            return html_entity_decode($result['self_data']);
        }
    }
 
    public function _write($id, $data) {
        if ($data) {
            $data = htmlentities($data, ENT_QUOTES);
            $this->session_create_or_update($data);
        }
        return true;
    }

    public function _destroy($id)
    {
        global $db;
        Mixin\delete($this->table, $id, 'session_id');
        header("location: $this->login_url");
    }
 
    public function _gc($maxlifetime) {
        // ... code ...
        // global $db;
        // $current_time = date('Y-m-d H:m:s') ;
        
        // $sql = "DELETE FROM $this->table WHERE 1";
        // $result = $db->query($sql)->fetch();
    
        return true;
    }

}

function is_auth($arr = null){
    global $session;
    $session->is_auth($arr);
    echo '<span class="text-center text-danger">Используется старая система аунтификации! Обновите систему аунтификации!</span>';
}

?>