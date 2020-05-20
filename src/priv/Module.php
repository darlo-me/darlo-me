<?php
require_once('libs/external/dist/php2static/Module.php');

class Module extends php2static\Module {
    public static $globals = [];
    function __construct(string $filename, bool $directFilename=false) {
        parent::__construct($filename, $directFilename);
        foreach(static::$globals as $key => $value) {
          $this->offsetSet($key, $value);
        }
    }
}
