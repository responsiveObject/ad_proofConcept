
<?php include 'vendor/ImagickLayerable.php'; ?>

<div style="width: 1280px; height:720px">
    <?php
    try {
//        //This would create a white canvas of dimensions 1280px x 720px
//        $layerStack = new ImagickLayerable(1280, 720, '#ffffff');
//        $layerStack->addLayerToStack("base_wall", new Imagick("images/R24_BASE-wall_WRINKLE.png"));
//        $layerStack->addLayerToStack("base_mask_wall", new Imagick("images/R24_BASE-mask_WALL.png"), 0, 0, Imagick::COMPOSITE_MULTIPLY);
//
//        $im = $layerStack->getFinalResult();
//        $im->setImageFormat('png');
        //echo '<img src="data:image/jpg;base64,' . base64_encode($im->getImageBlob()) . '" alt="" />';

        $base = new Imagick('images/R24_BASE-wall_WRINKLE.png');
        $mask = new Imagick('images/R24_BASE-mask_WALL.png');

        //$base->colorizeimage('#ccc401', 1.0);
        $draw = new ImagickDraw();

        $draw->setFillColor('#ccc401');
        $draw->setFillAlpha(0.2);
        $geometry = $base->getImageGeometry();
        $width = $geometry['width'];
        $height = $geometry['height'];

        $draw->rectangle(0, 0, $width, $height);
        $base->drawImage($draw);
        // Copy opacity mask
        $base->compositeImage($mask, Imagick::COMPOSITE_MULTIPLY, 0, 0, Imagick::CHANNEL_ALPHA);

        $final = new Imagick('images/R24_BASE-wall_WRINKLE.png');
        $final->compositeImage($base, Imagick::COMPOSITE_DEFAULT, 0, 0);
        echo '<img src="data:image/jpg;base64,' . base64_encode($final->getImageBlob()) . '" alt="" />';

    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
    ?>

</div>
