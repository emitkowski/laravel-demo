<?php

namespace App\Http\Resources;

/**
 * Trait ResourceWrapper
 * @package App\Http\Resources
 */
trait ResourceWrapper
{

    /**
     * Remove data wrap from response
     */
    protected function removeDataWrap()
    {
        $this->withoutWrapping();
    }
}