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

/* saturation
 * convert R24_BASE-wall_WRINKLE.png -colorspace HSL -channel Saturation -negate -evaluate multiply 0.75 -negate -colorspace RGB a_s.png
 * convert R24_BASE-wall_WRINKLE.png -set option:modulate:colorspace hsb -modulate 100,125,100 aa.png
 * convert R24_BASE-wall_WRINKLE.png \( +clone -fill "rgb(142,86,86)" -colorize 100% \) -compose colorize -composite aaa.png
 * 
 * brighten
 * convert R24_BASE-wall_WRINKLE.png -fill white -colorize 40% b.png
 * 
 * darken
 * convert R24_BASE-wall_WRINKLE.png -modulate 50 c.png
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

    public function generatePool($color, $darken, $hue=180, $saturation=0) {
        set_time_limit(0);
        $cacheKey = "c{$color}d{$darken}";
        $poolCache = new \poolCaching($cacheKey);
        if (false && $poolCache->is_cached()) {
            $poolImageCached = $poolCache->read_cache();
            return $poolImageCached;
        } else {
            $wall = $this->wall->generatePoolWall($color, $darken, $hue, $saturation);
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
