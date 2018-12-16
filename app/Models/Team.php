<?php

namespace App\Models;

use App\Models\Traits\Activable;
use App\Models\Traits\Addressable;
use Bnb\Laravel\Attachments\HasAttachment;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 *
 * @package App\Models
 */
class Team extends Model
{
    use Activable, Addressable, HasAttachment;

    /**
     * Players relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function players()
    {
        return $this->belongsToMany(Player::class);
    }

    /**
     * Address polymorphic relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    /**
     * Attachment polymorphic relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'model')->orderBy('created_at', 'desc');
    }
}
