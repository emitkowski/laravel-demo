<?php

namespace App\Models;

use App\Models\Traits\Activable;
use App\Models\Traits\Defaultable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 *
 * @package App\Models
 */
class Address extends Model
{
    use Activable, Defaultable;

    /**
     * Get all of the owning addressable models.
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}
