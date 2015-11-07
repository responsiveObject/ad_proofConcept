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
    </head>
    <body>
        <div class="container-fluid">
            <form method="post">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="wall_color_red">Red</label>
                            <input type="text" class="form-control" id="wall_color_red" name="wall_color_red" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="wall_color_green">Green</label>
                            <input type="text" class="form-control" id="wall_color_green" name="wall_color_green" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="wall_color_blue">Blue</label>
                            <input type="text" class="form-control" id="wall_color_blue" name="wall_color_blue" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                        try {
//                            $red = isset($_POST['wall_color_red']) ? $_POST['wall_color_red'] : 204;
//                            $green = isset($_POST['wall_color_red']) ? $_POST['wall_color_green'] : 196;
//                            $blue = isset($_POST['wall_color_red']) ? $_POST['wall_color_blue'] : 192;
//                            
//                            echo "<h3>Current color: $red - $green - $blue</h3>";
//                            $poolBuilder = new \poolBuilder();
//                            $poolBuilder->setWallColor("rgb($red,$green,$blue)");
                            
                            $poolBuilder = new \poolBuilder();
                            echo '<img src="data:image/jpg;base64,' . $poolBuilder->generatePool() . '" alt="" />';
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

