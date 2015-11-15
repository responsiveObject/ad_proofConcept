<?php
define('__ROOT__', dirname(__FILE__));

function exception_handler($exception) {
    echo "Uncaught exception: <br>" . $exception->getMessage() . "\n";
}

set_exception_handler('exception_handler');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

ini_set('error_log', __ROOT__ . '/log/my_file.log');

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
        <link href="css/bootstrap-slider.min.css" rel="stylesheet" type="text/css"/>
        <style type='text/css'>
            /* Example 1 custom styles */
            #ex1Slider .slider-selection, #exHueSlider .slider-selection, #exSaturationSlider .slider-selection {
                background-image: none;
                webkit-box-shadow: none;
                box-shadow: none;
            }
            .slider.slider-horizontal {
                width: 100%;
            }

            .list-group-item-success {
                color: white;
                background-color: #0480be;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <form method="post">
                <?php
                $color = isset($_POST['structure_color']) ? $_POST['structure_color'] : 10;
                $darken = isset($_POST['wall_darken']) ? $_POST['wall_darken'] : 100;
                $hue = isset($_POST['wall_hue']) ? $_POST['wall_hue'] : 180;
                $saturation = isset($_POST['wall_saturation']) ? $_POST['wall_saturation'] : 0;
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
                            <li class="list-group-item">
                                <input type="radio" class="selector" id="structure_color" name="structure_color" value="60" <?php if ($color == 60) echo 'checked'; ?> >
                                <label>Onyx</label>
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
                                case 60:
                                    $colorName = 'Onyx';
                                    break;
                            }

                            echo "<h3>Current color: $colorName</h3>";


                            $poolBuilder = new \poolBuilder();
                            echo '<img class="img-responsive" src="data:image/jpg;base64,' . $poolBuilder->generatePool($color, $darken, $hue, $saturation) . '" alt="" />';
                        } catch (Exception $ex) {
                            echo $ex->getMessage();
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-8">
                        <label>Hue</label>
                        <input id="exHue" name="wall_hue" data-slider-id='exHueSlider' type="text" data-slider-min="0" data-slider-max="360" data-slider-step="1" data-slider-value="180"/>
                    </div>
                    <div class="col-sm-offset-4 col-sm-8" style="margin-top: 20px; margin-bottom: 30px;">
                        <label>Saturation</label>
                        <input id="exSaturation" name="wall_saturation" data-slider-id='exSaturationSlider' type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0"/>
                    </div>
                    <div class="col-sm-offset-4 col-sm-8">
                        <div class="row">
                            <div class="col-sm-12">    
                                <label>Brightness</label>
                                <input id="ex1" name="wall_darken" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="200" data-slider-step="1" data-slider-value="100"/>
                            </div>
                            <div class="col-sm-6 text-center" style="border-right: 1px solid #0480be">
                                <label>Lighten</label>
                            </div>
                            <div class="col-sm-6 text-center" style="border-left: 1px solid #0480be">
                                <label>Darken</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/bootstrap-slider.min.js" type="text/javascript"></script>
        <script type='text/javascript'>
            $(document).ready(function () {
                var darkenValue = <?php echo "$darken" ?>;
                var hueValue = <?php echo "$hue" ?>;
                var saturationValue = <?php echo "$saturation" ?>;
                $('#ex1').slider({
                    value: darkenValue,
                    formatter: function (value) {
                        return Math.abs(value - 100) + ' %';
                    }
                });
                $('#exHue').slider({
                    value: hueValue
                });
                $('#exSaturation').slider({
                    value: saturationValue
                });
            });
        </script>
    </body>
</html>
