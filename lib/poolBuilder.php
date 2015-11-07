<?php

class poolBuilder {

    public $wallColor = 'rgb(255,255,255)';
    public $wallHue = 0;

    function __construct() {
    }

    public function setWallColor($wallColor) {
        if ($wallColor) {
            $this->wallColor = $wallColor;
        }        
    }
    
    private function getWall() {
        $base = new Imagick('images/R24_BASE-wall_WRINKLE.png');
        $mask = new Imagick('images/R24_BASE-mask_WALL.png');

//        $im = new Imagick();
//        $im->newimage(1280, 720, $this->wallColor, 'png');
//        $base->compositeimage($im, Imagick::COMPOSITE_MULTIPLY, 0, 0);

        $base->setimagematte(1);
        $base->compositeimage($mask, Imagick::COMPOSITE_DSTIN, 0, 0);

//        $im->clear();
//        $im->destroy();
        $mask->clear();
        $mask->destroy();

        return $base;
    }

    private function setHSL($hue, $saturation, $lightness) {
        $wall = $this->getWall();
        $wallIterator = $wall->getpixeliterator();
        
        foreach ($wallIterator as $row => $pixels) { // loop through pixel rows
            foreach ($pixels as $column => $pixel) { // Loop through the pixels in the row (columns)
//                if ($column % 2) {
//                    $pixel->setcolor('rgba(0,0,0,0)');
//                }   
                $hslColor = $pixel->gethsl();
//                if ($hslColor['luminosity'] > 0) {
//                    $r = '';
//                }
                $pixel->sethsl($hslColor['hue'], $hslColor['saturation'], $hslColor['luminosity'] * 1.2);
            }
            $wallIterator->synciterator();
        }        
        
        //$wall->modulateimage(-5, 0, 0);
        return $wall;
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
        $wall = $this->setHSL(0, 0, 0.2);
        
        //$baseWall->setimagecolorspace($wall->getimagecolorspace());
        $baseWall->compositeImage($wall, Imagick::COMPOSITE_DEFAULT, 0, 0);
        return base64_encode($wall->getImageBlob());
    }
}
