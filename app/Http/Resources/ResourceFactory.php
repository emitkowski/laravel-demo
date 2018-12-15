<?php

namespace App\Http\Resources;


/**
 * Class ResourceFactory
 *
 * @package App\Http\Resources
 */
class ResourceFactory
{
    /**
     * @param $name
     * @param $resource
     * @return mixed
     */
    public static function resource($name, $resource)
    {
        $class_name = 'App\Http\Resources\\'.ucfirst($name);

        return new $class_name($resource);
    }

    /**
     * @param $name
     * @param $resource
     * @return mixed
     */
    public static function resourceCollection($name, $resource)
    {
        $class_name = 'App\Http\Resources\\'.ucfirst($name).'Collection';

        return new $class_name($resource);
    }
}