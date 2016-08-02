<?php

class Configuration
{
    public static $configurationPath = null;
    public static $uploadPath = null;


    public static function getConfigurationPath()
    {
        if (self::$configurationPath == null)
            self::setConfigurationPath(null);
        return self::$configurationPath;
    }

    public static function setConfigurationPath($path = null)
    {
        if (!is_null($path))
            self::$configurationPath = $path;
        elseif (self::$configurationPath == null)
            self::$configurationPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." .
                DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR .
                ".." . DIRECTORY_SEPARATOR . "myConfig.ini";
    }

    public static function getUploadPath()
    {
        if (self::$uploadPath == null)
            self::setUploadPath(null);
        return self::$uploadPath;
    }

    public static function setUploadPath($path = null)
    {
        if (!is_null($path))
            self::$uploadPath = $path;
        elseif (self::$uploadPath == null)
            self::$uploadPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." .
                DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR .
                ".." . DIRECTORY_SEPARATOR . "uploads";
    }

}

?>