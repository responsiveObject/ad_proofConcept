<?php

class poolCaching {

    // Number of seconds a pool should remain cached for
    private $cache_expires = 31536000; // 1 year
    private $cache_folder;
    private $cache_file;

    function __construct($poolId, $ext = '.html') {
        $this->cache_folder = __ROOT__ . '/cache/';
        $poolFile = 'alto' . $poolId . 'design';
        $this->cache_file = md5($poolFile) . $ext;
    }

    // Checks whether the page has been cached or not
    public function is_cached() {
        $cachefile = $this->cache_folder . $this->cache_file;
        $cachefile_created = (file_exists($cachefile)) ? @filemtime($cachefile) : 0;

        return (time() - $this->cache_expires < $cachefile_created);
    }

    function getCacheFile() {
        return $this->cache_folder . $this->cache_file;
    }
    
    // Reads from a cached file
    function read_cache() {
        return file_get_contents($this->getCacheFile());
    }

    // Writes to a cached file
    // $out = content of the file
    function write_cache($out) {
        $cachefile = $this->cache_folder . $this->cache_file;
        $fp = fopen($cachefile, 'w');
        fwrite($fp, $out);
        fclose($fp);
    }

}
