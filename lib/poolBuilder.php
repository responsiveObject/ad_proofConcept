<?php

class poolBuilder {

    public $wallColor = 'rgb(255,255,255)';

    function __construct() {
    }

    public function setWallColor($wallColor) {
        if ($wallColor) {
            $this->wallColor = $wallColor;
        }        
    }
    
    private function buildWall() {
        $base = new Imagick('images/R24_BASE-wall_WRINKLE.png');
        $mask = new Imagick('images/R24_BASE-mask_WALL.png');

        $im = new Imagick();
        $im->newimage(1280, 720, $this->wallColor, 'png');
        $base->compositeimage($im, Imagick::COMPOSITE_MULTIPLY, 0, 0);

        $base->setimagematte(1);
        $base->compositeimage($mask, Imagick::COMPOSITE_DSTIN, 0, 0);

        $im->clear();
        $im->destroy();
        $mask->clear();
        $mask->destroy();

        return $base;
    }

    public function getWallImage() {
        $base = new Imagick('images/R24_BASE-wall_WRINKLE.png');
        $mask = new Imagick('images/R24_BASE-mask_WALL.png');

        $draw = new ImagickDraw();

        $draw->setFillColor($this->wallColor);
        $draw->setFillAlpha(0.3);
        $geometry = $base->getImageGeometry();
        $width = $geometry['width'];
        $height = $geometry['height'];

        $draw->rectangle(0, 0, $width, $height);
        $base->drawImage($draw);

        // Copy opacity mask
        $base->compositeImage($mask, Imagick::COMPOSITE_MULTIPLY, 0, 0, Imagick::CHANNEL_ALPHA);

        $final = new Imagick('images/R24_BASE-wall_WRINKLE.png');
        $final->setimagecolorspace($base->getimagecolorspace());
        $final->compositeImage($base, Imagick::COMPOSITE_DEFAULT, 0, 0);
        return base64_encode($final->getImageBlob());
    }

    public function generatePool() {
        $baseWall = new Imagick('images/R24_BASE-wall_WRINKLE.png');
        $wall = $this->buildWall();
        
        $baseWall->setimagecolorspace($wall->getimagecolorspace());
        $baseWall->compositeImage($wall, Imagick::COMPOSITE_DEFAULT, 0, 0);
        return base64_encode($baseWall->getImageBlob());
    }
}
