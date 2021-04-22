<?php
ini_set('display_errors', 1);

// SessionIdInterface
new SessionIdInterface();
class SessionH 
{
    protected $savePath;
    protected $sessionName;
 
    public function __construct() {
        session_set_save_handler(
            array($this, 'open'),
            array($this, 'close'),
            array($this, 'read'),
            array($this, 'write'),
            array($this, 'destroy'),
            array($this, 'gc')
        );
        session_start();
    }
 
    public function open($savePath, $sessionName) {
        // ... code ...
        return true;
    }
 
    public function close() {
        // ... code ...
        return true;
    }
 
    public function read($id) {
        // ... code ...
        echo'Сессия прочитана<br />';
        echo'ID сессии: '.$id.'<br />';

        return "";
    }
 
    public function write($id, $data) {
        // ... code ...
        echo'Сессия записана<br />';
        echo'ID сессии: '.$id.'<br />';
        echo'Данные: '.$data.'<br />';

        return true;
    }
 
    public function destroy($id) {
        // ... code ...
        echo'Сессия уничтожена<br />';

        return true;
    }
 
    public function gc($maxlifetime) {
        // ... code ...
        return true;
    }
}
 
$se = new SessionH();
// session_destroy();

?>