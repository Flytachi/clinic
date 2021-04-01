<?php

class __Model
{
    protected string $model_name;

    function __construct(string $model_name = null)
    {
        $this->model_name = $model_name;
    }

    public function create()
    {
        ob_start(null);
        ?>
class <?= ucfirst($this->model_name) ?>Model extends Model
{
    public $table = '<?= lcfirst($this->model_name) ?>';

    public function form($pk = null)
    {
        global $db;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ? >
        <form method="post" action="< ?= add_url() ?>">
            <input type="hidden" name="model" value="< ?= __CLASS__ ?>">
        </form>
        < ?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo "Успешно";
    }

    public function error($message)
    {
        echo $message;
    }
}
        <?php
        $code = ob_get_clean();
        return $this->create_file($code);
    }

    public function create_file($code = "")
    {
        $code = "<?php\n\n" . $code . "\n?>";
        $file_name = "models/".ucfirst($this->model_name).".php";
        if (!file_exists($file_name)) {
            $fp = fopen($file_name, "x");
            fwrite($fp, $code);
            return fclose($fp);
        }
        return 0;
    }
}

?>
