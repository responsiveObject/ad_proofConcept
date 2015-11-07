<?php
define('__ROOT__', dirname(__FILE__));

function exception_handler($exception) {
    echo "Uncaught exception: <br>" . $exception->getMessage() . "\n";
}

set_exception_handler('exception_handler');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

ini_set('error_log', __ROOT__ . 'log/my_file.log');

require_once(__ROOT__ . '/lib/poolBuilder.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Trendium - Proof of concept</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/color.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container-fluid">
            <form method="post">
                <?php
                $color = isset($_POST['structure_color']) ? $_POST['structure_color'] : 10;
                ?>
                <div class="row">
                    <div class="col-sm-4">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-success"><h3>Select your color</h3></li>
                            <li class="list-group-item">
                                <input type="radio" class="selector" id="structure_color" name="structure_color" value="10" <?php if ($color == 10) echo 'checked'; ?> >
                                <label>Basalt Grey</label>
                            </li>
                            <li class="list-group-item">
                                <input type="radio" class="selector" id="structure_color" name="structure_color" value="20" <?php if ($color == 20) echo 'checked'; ?> >
                                <label>Beige</label>
                            </li>
                            <li class="list-group-item">
                                <input type="radio" class="selector" id="structure_color" name="structure_color" value="30" <?php if ($color == 30) echo 'checked'; ?> >
                                <label>Burgundy</label>
                            </li>
                            <li class="list-group-item">
                                <input type="radio" class="selector" id="structure_color" name="structure_color" value="40" <?php if ($color == 40) echo 'checked'; ?> >
                                <label>Cacao</label>
                            </li>
                            <li class="list-group-item">
                                <input type="radio" class="selector" id="structure_color" name="structure_color" value="50" <?php if ($color == 50) echo 'checked'; ?> >
                                <label>Choco Brown</label>
                            </li>
                        </ul>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <?php
                        try {
                            $color = isset($_POST['structure_color']) ? $_POST['structure_color'] : 10;
                            $colorName = 'Basalt Grey';
                            switch ($color) {
                                case 20:
                                    $colorName = 'Beige';
                                    break;
                                case 30:
                                    $colorName = 'Burgundy';
                                    break;
                                case 40:
                                    $colorName = 'Cacao';
                                    break;
                                case 50:
                                    $colorName = 'Choco Brown';
                                    break;
                            }

                            echo "<h3>Current color: $colorName</h3>";


                            $poolBuilder = new \poolBuilder();
                            echo '<img class="img-responsive" src="data:image/jpg;base64,' . $poolBuilder->generatePool($color) . '" alt="" />';
                        } catch (Exception $ex) {
                            echo $ex->getMessage();
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

