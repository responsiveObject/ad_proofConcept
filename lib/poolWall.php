<?php

class poolWall {

    const COLOR_BASALTGREY = 10;
    const COLOR_BEIGE = 20;
    const COLOR_BURGUNDY = 30;
    const COLOR_CACAO = 40;
    const COLOR_CHOCOBROWN = 50;
    const COLOR_ONYX = 60;

    private $wallImage;
    private $mask;
    private $color;
    private $baseColor;
    private $darkenValue;
    private $lightenValue;
    private $hueValue;
    private $saturationValue;

    function __construct() {
        $this->wallImage = 'images/R24_BASE-wall_WRINKLE.png';
        $this->mask = new Imagick('images/R24_BASE-mask_WALL.png');
        $this->saturation = 25;
    }

    function __destruct() {
        $this->mask->clear();
    }

    private function setColor($color) {
        $this->color = $color;
        $this->baseColor = $this->getRGB();
    }

    private function setDarkenValue($darken) {
        $this->darkenValue = 100;
        $this->lightenValue = 0;

        if ($darken > 100) {
            // brightness should be from 100 to 50
            $offset = (($darken - 100) / 100) * 50;
            $this->darkenValue = 100 - $offset;
        }

        if ($darken < 100) {
            // set opacity is from 0 to 40
            $offset = ((100 - $darken) / 100) * 40;
            $this->lightenValue = $offset;
        }
    }

    private function setHueSaturationValue($hue, $saturation) {
        $this->hueValue = 100;
        $this->saturationValue = 100;
        
        if ($hue) {
            $this->hueValue = 200 * $hue / 360; // 100 + (($hue - 180) * 100/360);
        }

        if ($saturation) {
            // saturation is between 100 - 125
            $this->saturationValue = 100 + (($saturation / 100) * 25);
        }
    }

    private function getRGB() {
        $baseColor = 'rgb(204,196,192)';
        switch ($this->color) {
            case self::COLOR_BASALTGREY:
                $baseColor = 'rgb(188,196,204)';
                break;
            case self::COLOR_BEIGE:
                $baseColor = 'rgb(242,240,236)';
                break;
            case self::COLOR_BURGUNDY:
                $baseColor = 'rgb(230,202,204)';
                break;
            case self::COLOR_CACAO:
                $baseColor = 'rgb(204,196,192)';
                break;
            case self::COLOR_CHOCOBROWN:
                $baseColor = 'rgb(204,192,182)';
                break;
            case self::COLOR_ONYX:
                $baseColor = 'rgb(194,206,218)';
                break;
        }

        return $baseColor;
    }

    private function colorizeWall() {
        $wall = new Imagick($this->wallImage);

        $im = new Imagick();
        $im->newimage(1280, 720, $this->baseColor, 'png');
        $wall->compositeimage($im, Imagick::COMPOSITE_MULTIPLY, 0, 0);
        $im->clear();

        // darken image
        if ($this->darkenValue < 100 && $this->darkenValue >= 50) {
            $wallAdjust = clone $wall;
            $wallAdjust->modulateimage($this->darkenValue, 100, 100);
            $wall->compositeimage($wallAdjust, Imagick::COMPOSITE_MULTIPLY, 0, 0);
            $wallAdjust->clear();
        }

        // lighten image
        if ($this->lightenValue > 0) {
            $wallAdjust = clone $wall;
            $draw = new ImagickDraw();
            $draw->setFillColor('#ffffff');
            $draw->setfillopacity($this->lightenValue / 100);

            $geometry = $wallAdjust->getImageGeometry();
            $width = $geometry['width'];
            $height = $geometry['height'];
            $draw->rectangle(0, 0, $width, $height);
            $wallAdjust->drawImage($draw);
            $wall->compositeimage($wallAdjust, Imagick::COMPOSITE_DEFAULT, 0, 0);
            $wallAdjust->clear();
        }

        // apply hue/saturation
        $wall->modulateimage(100, $this->saturationValue, $this->hueValue);

        $wall->compositeimage($this->mask, Imagick::COMPOSITE_DSTIN, 0, 0);

        return $wall;
    }

    public function generatePoolWall($color, $darken, $hue, $saturation) {
        $this->setColor($color);
        $this->setDarkenValue($darken);
        $this->setHueSaturationValue($hue, $saturation);

        $baseWall = new Imagick($this->wallImage);
        $wall = $this->colorizeWall();

        $baseWall->compositeimage($wall, Imagick::COMPOSITE_DEFAULT, 0, 0);
        $wall->clear();

        return $baseWall;
    }

}
