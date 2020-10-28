<?php

// Database Constants
define("DB_HOST", "localhost");
define("DB_NAME", "clinic");
define("DB_USER", "clinic");
define("DB_PASS", "clin_pik27");
$DNS = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";user=".DB_USER.";password=".DB_PASS."";

// print_r(PDO::getAvailableDrivers()); 
try {
    $pdo = new PDO($DNS);
    $pdo->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pds = new PDO($DNS);
    $pds->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}


class Planet
{
    private $name;
    private $color;

    public function __construct($name=null, $color=null)
    {
        $this->name = $name;
        $this->color = $color;
    }

    public function setName($planet_name)
    {
        $this->name = $planet_name;
    }

    public function setColor($planet_color)
    {
        $this->color = $planet_color;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function form($local)
    {
        global $pdo;
        ?>
        <form method="post" action="">
            <input class="form-control" type="text" name="name">
            <input class="form-control" type="text" name="color">
            <button type="submit">Отправить</button>
        </form>
        <?php

        if(isset($_POST)){
            $stmt = $pdo->prepare("INSERT INTO planets(name, color) VALUES(:name, :color)");
            $stmt->execute($_POST);
            if($stmt){
                header("location:$local");
            }
        };
        
    }
} 
// $stmt = $pdo->query("SELECT name, color FROM planets");
// $stmt->setFetchMode(PDO::FETCH_CLASS, 'Planet');
// $planet = $stmt->fetch();
// var_dump($planet);
?>
<table>
    <tbody>
    <?php
    foreach($pdo->query('SELECT * from planets') as $row) {
        ?>
        <tr>
            <th><?= $row['name'] ?></th>
            <th><?= $row['color'] ?></th>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<?php
// $stmt = $pdo->prepare("INSERT INTO planets(name, color) VALUES(:name, :color)");
// $stmt->execute(['name' => 'leyt', 'color' => 'green']);

Planet::form('test.php');

// if(isset($_POST['save_planet'])){
//     $stmt = $pdo->prepare("INSERT INTO planets(name, color) VALUES(:name, :color)");
//     $stmt->execute(['name' => $planet->name, 'color' => $planet->color]);
// }
?>

