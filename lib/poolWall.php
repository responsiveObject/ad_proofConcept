<?php

class poolWall {

    const MIN_LIGHTNESS = -50;
    const MAX_LIGHTNESS = 40;

    public $lightness = 0;
    public $saturation = 0;
    private $wallImage;
    private $mask;

    function __construct() {
        $this->wallImage = 'images/R24_BASE-wall_WRINKLE.png';
        $this->mask = new Imagick('images/R24_BASE-mask_WALL.png');
        $this->saturation = 25;
    }

    function __destruct() {
        $this->mask->clear();
        $this->mask->destroy();
    }

    private function setHSL($wall, $hue, $saturation, $lightness) {
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
                //if ($hslColor['saturation'] != 0)
                $pixel->sethsl($hslColor['hue'], 2, $hslColor['luminosity']);
            }
            $wallIterator->synciterator();
        }

        //$wall->modulateimage(-5, 0, 0);
        return $wall;
    }

    private function applyAttribute(Imagick $wall) {
//        $h = $wall->getimageheight();
//        $w = $wall->getimagewidth();
        if ($this->saturation === 0 && $this->lightness === 0) {
            return $wall;
        }
        $wall->modulateimage(100, 150, 100);
        //return $this->setHSL($wall, 0, $this->saturation, 0);

        return $wall;
    }

    private function buildZeroColorWall() {
        $wall = new Imagick($this->wallImage);
        $wall->compositeimage($this->mask, Imagick::COMPOSITE_DSTIN, 0, 0);

        return $wall;
    }

    public function generatePoolWall() {
        
        $baseWall = new Imagick($this->wallImage);
        $wall = $this->buildZeroColorWall();
        //$wall->modulateimage(50, 100, 100);
        $baseWall->compositeimage($wall, Imagick::COMPOSITE_DEFAULT, 0, 0);
        return $baseWall;
    }

}
