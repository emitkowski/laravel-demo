<?php

namespace App\Models\Traits;

/**
 * Trait Defaultable
 *
 * @package App\Models\Traits
 */
trait Defaultable
{

    /**
     * Default Display
     *
     * @return string
     */
    public function getDefaultDisplayAttribute()
    {
        return ($this->default ? 'Default' : '');
    }

    /**
     * Check if default
     *
     * @return mixed
     */
    public function isDefault()
    {
        return (bool) $this->default;
    }

    /**
     * Add default setting
     *
     * @return mixed
     */
    public function setDefault()
    {
        $this->default = 1;

        return $this->save();
    }

    /**
     * Remove default setting
     *
     * @return mixed
     */
    public function removeDefault()
    {
        $this->default = 0;

        return $this->save();
    }

}