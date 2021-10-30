<?php

class Session
{
    /**
     * 
     *  My Session
     * 
     *  @version 9.9
     **/

    protected $db;
    protected $login_url = DIR."/auth/login".EXT;
    protected $index_url = "../index".EXT; //../index.php
    protected $logout_url = DIR."/auth/logout".EXT;
    protected $confirm_password_url = DIR."/auth/confirm_password".EXT;
    protected $timeout_mark_url = DIR."/auth/timeout_mark".EXT;
    
    protected $table = "sessions";
    public $life_session = 5; // minute

    function __construct($database, $life_session = null)
    {
        $this->db = $database;
        if ($life_session) $this->life_session = $life_session;
        session_start();
    }

    protected function init()
    {
        $this->session_id = $_SESSION['session_id'];
        $this->session_login = $_SESSION['session_login'];
        if( isset($_SESSION['status']) ) $this->status = $_SESSION['status'];
        if( isset($_SESSION['session_get_full_name']) ) $this->session_get_full_name = $_SESSION['session_get_full_name'];
        if( isset($_SESSION['session_level']) ) $this->session_level = $_SESSION['session_level'];
        
        if ( isset($_SESSION['browser']) ) {
            $this->browser = $_SESSION['browser'];
        }else{
            if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) $_SESSION['browser'] = "Firefox";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) $_SESSION['browser'] = "Opera";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) $_SESSION['browser'] = "Chrome";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) $_SESSION['browser'] = "Explorer";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Safari") !== false) $_SESSION['browser'] = "Safari";
            else $_SESSION['browser'] = "Неизвестный";
        }
    }

    public function is_auth($arr = null)
    {
        if ( isset($_SESSION['session_timeout_logout']) ) {
            $this->logout();
        }elseif ( isset($_SESSION['session_id']) ) {
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
        if ( isset($_SESSION['session_id']) and $_SESSION['session_id'] != "master") {
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

        if( isset($_SESSION['session_id']) and $this->session_id != "master" and empty($this->status) ){
            $sessionActive = true;
        }

    }

    protected function auth(string $login = null, string $password = null)
    {
        $username = Mixin\clean($login);
        $password = sha1(Mixin\clean($password));

        if ($this->master_confirm($username, $password)) {
            $this->set_data("master");
            $this->login_success();
        }

        try {
            $stmt = $this->db->query("SELECT id FROM users WHERE username = '$username' AND password = '$password' AND is_active IS NOT NULL")->fetch(PDO::FETCH_OBJ);
            if($stmt){
                $this->set_data($stmt->id);
                $this->login_success();
            }else{
                $_SESSION['message'] = 'Не верный логин или пароль';
            }
        } catch (\Throwable $th) {
            $_SESSION['message'] = 'Не верный логин или пароль';
        }

        
    }

    protected function session_check()
    {
        $sid = session_id();
        $this->session_confirm($sid);
        $object = $this->db->query("SELECT * FROM $this->table WHERE session_id = \"$sid\"")->fetch();
        if ($object) {
            $this->init();
            $this->session_create_or_update();  
        }else {
            $this->destroy();
        }
    }

    protected function session_confirm($sid)
    {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE session_id = \"$sid\" AND last_update + INTERVAL $this->life_session MINUTE < CURRENT_TIMESTAMP()");
        $stmt->execute();
    }

    protected function session_create_or_update()
    {
        $date = date("Y-m-d H:i:s");
        $new_ses = array(
            'session_id' => session_id(), 
            'self_id' => $_SESSION['session_id'], 
            'self_ip' => $_SERVER['REMOTE_ADDR'], 
            'self_login' => $_SESSION['session_login'], 
            'self_render' => $_SERVER['PHP_SELF'], 
            'self_agent' => $_SERVER['HTTP_USER_AGENT'], 
            'last_update' => $date);
        Mixin\insert_or_update($this->table, $new_ses, 'session_id');        
    }

    protected function gen_password()
    {
        if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) $browser = "Firefox";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) $browser = "Opera";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) $browser = "Chrome";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) $browser = "Explorer";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Safari") !== false) $browser = "Safari";
        else $browser = "Unknown";
        
        return sha1("browser-$browser|key-".date('YdH'));
    }

    public function destroy()
    {
        Mixin\delete($this->table, session_id(), 'session_id');
        session_destroy();
        header("location: $this->login_url");
        exit;
    }

    public function set_data($pk) {
        if ($pk == "master") {
            $_SESSION['session_id'] = "master";
            $_SESSION['session_login'] = "master";
            $_SESSION['session_level'] = "master";
            
        }else {
            $this->data = $this->db->query("SELECT * FROM users WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
            unset($this->data->password);
            $_SESSION['session_id'] = $pk;
            $_SESSION['session_login'] = $this->data->username;
            $_SESSION['session_get_full_name'] = ucwords($this->data->last_name." ".$this->data->first_name." ".$this->data->father_name);
            $_SESSION['session_level'] = $this->data->user_level;
        }
        
    }

    protected function master_confirm(string $username = null, string $password = null)
    {
        global $ini;
        if ( isset($_POST['master-key']) and $_POST['master-key'] == "master-key" ) {
            if ( isset($ini['MASTER_IPS']) and in_array(trim($_SERVER['REMOTE_ADDR']), $ini['MASTER_IPS']) and $username == null) {
                return true;
            }else {
                return false;
            }
        }elseif ($username == "master" and $password == $this->gen_password()) {
            return true;
        } else {
            return false;
        }
        
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

    public function logout_avatar_link($status)
    {
        return DIR."/auth/avatar_logout".EXT."?pk=$status";
    }

    public function timeout_mark_link()
    {
        return $this->timeout_mark_url;
    }

    public function confirm_password_link()
    {
        return $this->confirm_password_url;
    }

    public function get_session_create_or_update()
    {
        $this->session_create_or_update();
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

}

?>