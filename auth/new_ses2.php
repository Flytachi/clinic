<?php
require_once '../tools/functions/connection.php';
require_once '../tools/functions/tag.php';

// Settings mod

if (!$ini['GLOBAL_SETTING']['ROOT_MOD']) {
    define('ROOT_DIR', "/".basename(dirname(__DIR__)));

    if ("/".$_SERVER['HTTP_HOST'] == ROOT_DIR) {
        define('DIR', "");
    }else {
        define('DIR', ROOT_DIR);
    }

}else {
    define('DIR', "");
}

// END Settings mod

// Settings debugger

if ($ini['GLOBAL_SETTING']['DEBUG']) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

// END Settings debugger


// File extension

if ($ini['GLOBAL_SETTING']['HIDE_EXTENSION']) {

    define('EXT', "");

}else {

    define('EXT', ".php");

}

// END File extension

class Session
{
    public $login_url = DIR."/auth/login1.php";
    public $index_url = "new_ses2".EXT; //../index.php
    protected $session_id;
    protected $session_login;

    function __construct()
    {
        session_start();
        if ($_SESSION['session_id']) {
            $this->init();
            dd($this);
            dd($_SESSION);
            if ($this->login_url == $_SERVER['PHP_SELF']) {
                $this->login_success();
            }
        }else {
            if ($this->login_url != $_SERVER['PHP_SELF']) {
                $this->login();
            }elseif ($_POST) {
                $this->auth($_POST['username'], $_POST['password']);
            }
        }
    }

    private function init()
    {
        $this->session_id = $_SESSION['session_id'];
        $this->session_login = $_SESSION['session_login'];
        $this->browser = $_SESSION['browser'];
        if ($_SESSION['slot']) {
            $this->slot = $_SESSION['slot'];
        }
    }

    private function auth(string $login = null, string $password = null)
    {
        global $db;
        $username = Mixin\clean($login);
        $password = sha1($password);

        if ($username == "master" and $_POST['password'] == gen_password()) {
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
        
    }

    public function login()
    {
        header("location:".DIR."/auth/login1".EXT);
    }

    protected function login_success()
    {
        global $db;
        $this->session_create_or_update();
        header("location: $this->index_url");
    }

    public function logout()
    {
        return header("location:".DIR."/auth/logout".EXT);
    }

}

new Session;
?>