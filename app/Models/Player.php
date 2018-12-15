<?php

namespace App\Models;

use App\Models\Traits\Activable;
use App\Models\Traits\Addressable;
use Bnb\Laravel\Attachments\HasAttachment;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Player
 *
 * @package App\Models
 */
class Player extends Model
{
    use Activable, Addressable, HasAttachment;

    /**
     * Get all of the owning addressable models.
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    /**
     * Get the attachments relation morphed to the current model class
     *
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'model')->orderBy('created_at', 'desc');
    }
}
