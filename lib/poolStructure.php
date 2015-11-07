<?php

class poolStructure {

    const COLOR_BASALTGREY = 10;
    const COLOR_BEIGE = 20;
    const COLOR_BURGUNDY = 30;
    const COLOR_CACAO = 40;
    const COLOR_CHOCOBROWN = 50;
    const COLOR_ONYX = 60;

    private $color;

    function __construct($color) {
        $this->color = $color;
    }

    private function buildBase() {
        $baseImage = '';
        switch ($this->color) {
            case self::COLOR_BEIGE:
                $baseImage = 'images/R24_HORIZON-level_01.png';
                break;
            case self::COLOR_BASALTGREY:
            case self::COLOR_CACAO:
                $baseImage = 'images/R24_HORIZON-level_02.png';
                break;
            case self::COLOR_ONYX:
                $baseImage = 'images/R24_HORIZON-level_03.png';
                break;
            case self::COLOR_BURGUNDY:
            case self::COLOR_CHOCOBROWN:
                $baseImage = 'images/R24_HORIZON-level_04.png';
                break;
        }

        return new Imagick($baseImage);
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

    private function applyPartColor($maskFile) {
        $part = $this->buildBase();

        $partMask = new Imagick($maskFile);

        $im = new Imagick();
        $im->newimage(1280, 720, $this->getRGB(), 'png');
        $part->compositeimage($im, Imagick::COMPOSITE_MULTIPLY, 0, 0);

        $part->setimagematte(1);
        $part->compositeimage($partMask, Imagick::COMPOSITE_DSTIN, 0, 0);

        $im->clear();
        $im->destroy();

        $partMask->clear();
        $partMask->destroy();
        
        return $part;
    }

    private function applyCoverMask() {
        if ($this->color == self::COLOR_CHOCOBROWN) {
            return false;
        }

        return $this->applyPartColor('images/R24_HORIZON-mask_COVERS.png');
    }

    private function applyFootMask() {
        if ($this->color == self::COLOR_CHOCOBROWN) {
            return false;
        }

        return $this->applyPartColor('images/R24_HORIZON-mask_FOOT.png');
    }

    private function applyLedgeMask() {
        if ($this->color == self::COLOR_CHOCOBROWN) {
            return false;
        }

        return $this->applyPartColor('images/R24_HORIZON-mask_LEDGES.png');
    }

    private function applyRailsMask() {
        if ($this->color == self::COLOR_CHOCOBROWN) {
            return false;
        }

        return $this->applyPartColor('images/R24_HORIZON-mask_RAILS.png');
    }

    private function applyUprightsMask() {
        if ($this->color == self::COLOR_CACAO) {
            return false;
        }

        return $this->applyPartColor('images/R24_HORIZON-mask_UPRIGHTS.png');
    }

    public function generateStructure() {
        $structure = $this->buildBase();
        $structureUpright = $this->applyUprightsMask();
        $structureCover = $this->applyCoverMask();
        $structureLedge = $this->applyLedgeMask();
        $structureFoot = $this->applyFootMask();
        $structureRails = $this->applyRailsMask();

        if ($structureUpright) {
            $structure->compositeimage($structureUpright, Imagick::COMPOSITE_DEFAULT, 0, 0);
            $structureUpright->clear();
            $structureUpright->destroy();
        }

        if ($structureCover) {
            $structure->compositeimage($structureCover, Imagick::COMPOSITE_DEFAULT, 0, 0);
            $structureCover->clear();
            $structureCover->destroy();
        }

        if ($structureLedge) {
            $structure->compositeimage($structureLedge, Imagick::COMPOSITE_DEFAULT, 0, 0);
            $structureLedge->clear();
            $structureLedge->destroy();
        }
        
        if ($structureFoot) {
            $structure->compositeimage($structureFoot, Imagick::COMPOSITE_DEFAULT, 0, 0);
            $structureFoot->clear();
            $structureFoot->destroy();
        }

        if ($structureRails) {
            $structure->compositeimage($structureRails, Imagick::COMPOSITE_DEFAULT, 0, 0);
            $structureRails->clear();
            $structureRails->destroy();
        }

        return $structure;
    }

}
