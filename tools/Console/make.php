<?php

class __Seed
{
    protected String $name;
    private String $path = "tools/Data/ci"; 
    private String $format = "json"; 
    private Array $json = array();

    function __construct(string $name = null)
    {
        if ($name) {
            $this->name = $name;
            if ($this->generate()) {
                echo "\033[32m". " Генерация прошла успешно.\n";
            }else {
                echo "\033[31m"." Ошибка при генерации.\n";
            }
        } else {
            echo "\033[33m"." Введите название таблицы.\n";
            return 0;
        }
        
    }

    public function generate()
    {
        global $db;
        require_once dirname(__DIR__).'/functions/connection.php';
        foreach ($db->query("SELECT * FROM $this->name") as $value) {
            $this->json[] = $value;
        }
        return $this->create_file();
    }

    public function create_file()
    {
        $file = fopen("$this->path/$this->name.$this->format", "w");
        fwrite($file, json_encode($this->json));
        return fclose($file);
    }
}

class __Model
{
    protected String $model_name;

    function __construct(string $model_name = null)
    {
        if ($model_name) {
            $this->model_name = $model_name;
            if ($this->create()) {
                echo "\033[32m". " Модель успешно создана.\n";
            }else {
                echo "\033[31m"." Ошибка при создании модели.\n";
            }
        } else {
            echo "\033[33m"." Введите название модели.\n";
            return 0;
        }
        
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
        ?>
        <form method="post" action="<-?= add_url() ?>">
            <input type="hidden" name="model" value="<-?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<-?= $pk ?>">
        </form>
        <-?php
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
