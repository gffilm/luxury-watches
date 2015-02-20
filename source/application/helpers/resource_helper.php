<?php

/**
 * Resource loading service
 * using the STATICDIR variable, it creates paths relative to this
 */
class Resource {
    
    /**
     * Holds instance of this object.
     * @var {Object} the instance to handle the singleton method
     */
    private static $instance_;

    /**
     * Base url of the application.
     * @var {string}
     */
    private $baseUrl = "";

    /**
     * Private constructor and clone - singleton.
     */
    private function __construct() {
        $this->generateBaseUrl();
    }

    private function __clone() {}

    /**
     * Given current url. Generates a url to the root of the application (index.php).
     * @return {!String}
     */
    private function generateBaseUrl() {
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'? 'https' : 'http';
        $file = strpos($_SERVER["REQUEST_URI"], 'index.php') >= 0 ? 'index.php' : ''; 
        $uri = substr($_SERVER["REQUEST_URI"], 0, strpos($_SERVER["REQUEST_URI"].$file, 'index.php'));
    
        $this->baseUrl = $protocol.'://'.$_SERVER["SERVER_NAME"].$uri.STATICDIR;
    }

    /**
     * Always returns same instance of this object.
     * @return {!Resource}
     */
    public static function getInstance() { 
        if(!self::$instance_) {
            self::$instance_ = new Resource();
        }

        return self::$instance_;
    }

    /**
     * Returns computed path to static resource.
     * @param  {!String} $filename filename to compute.
     * @return {!String}           Computed path.        
     */
    public function getFile($filename) { 
        return $this->baseUrl . $filename;
    }

    /**
     * Echos out a file path.
     * @param  {!String} $filename filename to compute.
     */
    public function echoPath($filename) {
        echo $this->getFile($filename);
    }

    /**
     * Returns a file path.
     * @param  {!String} $filename filename to compute.
     */
    public function returnPath($filename) {
        return $this->getFile($filename);
    }

}

?>