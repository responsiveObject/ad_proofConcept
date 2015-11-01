
<div style="width: 1280px; height:720px">
<?php

echo 'create imagick image';

try {
    $im = new Imagick();
    $im->newimage(200, 100, 'red', 'png');
    //$im->writeimage('/var/www/media/test.png');
    // start buffering
//    ob_start();
//    $thumbnail = $im->getImageBlob();
//    $contents = ob_get_contents();
//    ob_end_clean();
//    echo "<img src='data:image/jpg;base64,".base64_encode($contents)."' />";
    echo '<img src="data:image/jpg;base64,'.base64_encode($im->getImageBlob()).'" alt="" />';
    $im->destroy();
    
} catch (Exception $ex) {
    echo $e->getMessage();
}

?>

    <img src="images/R24_BASE-wall_WRINKLE.png">
</div>
