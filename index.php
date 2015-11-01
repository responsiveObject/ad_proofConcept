<?php
define('__ROOT__', dirname(__FILE__)); 

function exception_handler($exception) {
  echo "Uncaught exception: <br>". $exception->getMessage(). "\n";
}

set_exception_handler('exception_handler');

error_reporting(E_ALL);
ini_set('display_errors','On');

ini_set('error_log',__ROOT__ . 'log/my_file.log');

require_once(__ROOT__.'/lib/poolBuilder.php'); 
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
        <div>
            <?php
            try {
                $poolBuilder = new \poolBuilder('rgb(51,42,37)');

                echo '<img src="data:image/jpg;base64,' . $poolBuilder->getWallImage() . '" alt="" />';
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
            ?>

        </div>
        <img src="images/R24_BASE-wall_WRINKLE.png">
    </body>
</html>

