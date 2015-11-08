<?php

/*
 * ImageMagick command line
  $sourceImg = 'source.png';
  $destImg = 'dest.png';
  $background ='#00ff00';

  $command = "convert {$sourceImg}";
  $out = array();

  for($i=1;$i<=5;$i++){
  $command .= " -fill \"{$background}\" ";
  $command .= " -draw 'rectangle {$x1},{$y1} {$x2},{$y2}'";
  }

  $command .= " {$destImg}";
  exec($command,$out);
 */

require_once(__ROOT__ . '/lib/poolCaching.php');
require_once(__ROOT__ . '/lib/poolWall.php');
require_once(__ROOT__ . '/lib/poolStructure.php');

class poolBuilder {

    public $wall;
    private $poolCaching;

    function __construct() {
        $this->wall = new \poolWall();
        $this->poolCaching = array();
    }

    private function applyShadow($poolWall) {
        $shadow = new Imagick('images/R24_HORIZON-shadow.png');
        // Reduce the alpha by 50%
        $shadow->evaluateimage(Imagick::EVALUATE_DIVIDE, 2, Imagick::CHANNEL_ALPHA);
        return $shadow;
    }

    public function generatePool($color) {
        $poolCache = new \poolCaching($color);
        if ($poolCache->is_cached()) {
            $poolImageCached = $poolCache->read_cache();
            return $poolImageCached;
        } else {
            $wall = $this->wall->generatePoolWall();
            $shadowMask = $this->applyShadow($wall);
            $wall->compositeimage($shadowMask, Imagick::COMPOSITE_MULTIPLY, 0, 0);

            $structure = new \poolStructure($color);
            $structureImage = $structure->generateStructure();

            $wall->compositeimage($structureImage, Imagick::COMPOSITE_DEFAULT, 0, 0);

            $poolImage = base64_encode($wall->getImageBlob());
            $poolCache->write_cache($poolImage);
            
            return $poolImage;
        }
    }

}
