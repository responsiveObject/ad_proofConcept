<?php

class poolBuilder {

    public $wallColor = 'rgb(255,255,255)';
    
    function __construct($wallColor = '') {
        if ($wallColor) {
            $this->wallColor = $wallColor;
        }
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

}
