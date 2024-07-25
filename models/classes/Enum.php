<?php

namespace app\models\classes;

/**
 * Class Enum
 */
abstract class Enum
{
    /**
     */
    public static function getConstants()
    {
        return (new \ReflectionClass(get_called_class()))->getConstants();
    }
}
