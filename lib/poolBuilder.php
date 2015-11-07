<?php

require_once(__ROOT__ . '/lib/poolWall.php');
require_once(__ROOT__ . '/lib/poolStructure.php');

class poolBuilder {

    public $wall;

    function __construct() {
        $this->wall = new \poolWall();
    }

    private function applyShadow($poolWall) {
        $shadow = new Imagick('images/R24_HORIZON-shadow.png');
        // Reduce the alpha by 50%
        $shadow->evaluateimage(Imagick::EVALUATE_DIVIDE, 2, Imagick::CHANNEL_ALPHA);
        return $shadow;
    }

    public function generatePool($color) {
        $wall = $this->wall->generatePoolWall();
        $shadowMask = $this->applyShadow($wall);
        $wall->compositeimage($shadowMask, Imagick::COMPOSITE_MULTIPLY, 0, 0);

        $structure = new \poolStructure($color);
        $structureImage = $structure->generateStructure();
        
        $wall->compositeimage($structureImage, Imagick::COMPOSITE_DEFAULT, 0, 0);

        return base64_encode($wall->getImageBlob());
        //return base64_encode($structureImage->getImageBlob());
    }

}
