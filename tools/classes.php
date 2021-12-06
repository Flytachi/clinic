<?php

/* 
    My Classes
*/

use Mixin\HellCrud;

class MySession extends Mixin\Session
{

    protected function init()
    {
        $this->session_id = $_SESSION['session_id'];
        $this->session_login = $_SESSION['session_login'];
        if( isset($_SESSION['status']) ) $this->status = $_SESSION['status'];
        if( isset($_SESSION['session_branch']) ) $this->branch = $_SESSION['session_branch'];
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

    protected function auth(string $login = null, string $password = null)
    {
        $username = HellCrud::clean($login);
        $password = sha1(HellCrud::clean($password));

        if ($this->master_confirm($username, $password)) {
            $this->set_data("master");
            $this->login_success();
        }

        try {
            $stmt = $this->db->query("SELECT id FROM users WHERE username = '$username' AND password = '$password' AND is_active IS NOT NULL")->fetch(PDO::FETCH_OBJ);
            if($stmt){
                $this->set_data($stmt->id);
                $slot = $this->db->query("SELECT slot FROM multi_accounts WHERE user_id = $stmt->id")->fetchColumn();
                if ($slot) {
                    $_SESSION['session_slot'] = HellCrud::clean($slot);
                }
                $this->login_success();
            }else{
                $_SESSION['message'] = 'Не верный логин или пароль';
            }
        } catch (\Throwable $th) {
            $_SESSION['message'] = 'Не верный логин или пароль';
        }

        
    }

    public function set_data($pk) {
        if ($pk == "master") {
            $_SESSION['session_id'] = "master";
            $_SESSION['session_login'] = "master";
            $_SESSION['session_level'] = "master";
	        $_SESSION['session_division'] = "master";
        }else {
            $this->data = $this->db->query("SELECT * FROM users WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
            unset($this->data->password);
            $_SESSION['session_id'] = $pk;
            $_SESSION['session_branch'] = $this->data->branch_id;
            $_SESSION['session_login'] = $this->data->username;
            $_SESSION['session_get_full_name'] = ucwords($this->data->last_name." ".$this->data->first_name." ".$this->data->father_name);
            $_SESSION['session_level'] = $this->data->user_level;
	        $_SESSION['session_division'] = $this->data->division_id;
        }
        
    }

    public function get_accounts()
    {
        if (isset($this->session_slot)) {
            return $this->db->query("SELECT us.id, us.username FROM multi_accounts mca LEFT JOIN users us ON(mca.user_id=us.id) WHERE mca.slot = \"$this->session_slot\" ")->fetchAll();
        }
        return [];
    }

    public function get_division() {
        return $this->data->division_id;
    }

    public function avatar_link($status)
    {
        return DIR."/auth/avatar".EXT."?pk=$status";
    }

}

?>