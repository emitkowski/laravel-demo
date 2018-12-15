<?php

namespace App\Models\Traits;

/**
 * Trait Activable
 *
 * @package App\Models\Traits
 */
trait Activable
{
    /**
     * Status Display
     *
     * @return string
     */
    public function getStatusDisplayAttribute()
    {
        return ($this->status ? 'Active' : 'Inactive');
    }

    /**
     * Activate
     *
     * @return bool
     */
    public function activate()
    {
        $this->status = 1;
        $this->save();

        return true;
    }

    /**
     * Deactivate
     *
     * @return bool
     */
    public function deactivate()
    {
        $this->status = 0;
        $this->save();

        return true;
    }

    /**
     * Deactivate
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool) $this->status;
    }

}