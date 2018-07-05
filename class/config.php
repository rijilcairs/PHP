<?php
class Config {
    public static function get($path = null) {
        if ($path){
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            foreach($path as $path1) {
                if(isset($config[$path1])) {
                    $config = $config[$path1];
                }
            }
            return $config;
        }
        return false;
    }
}
?>