<?php
$pathDir = dirname(__FILE__);
$paths = array('controllers', 'models', 'views');
for ($k = 0; $k < count($paths); $k++) {
    set_include_path(get_include_path() . PATH_SEPARATOR .
        $pathDir . DIRECTORY_SEPARATOR . $paths[$k]);
}

spl_autoload_register('myClassLoader');

function myClassLoader($className)
{
    $paths = explode(PATH_SEPARATOR, get_include_path());
    foreach ($paths as $path) {
        $file = $path . DIRECTORY_SEPARATOR . $className . '.class.php';
        if (file_exists($file)) {
            include_once $file;
            break;
        }
    }
}

?>