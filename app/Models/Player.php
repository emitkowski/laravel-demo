<?php

namespace App\Models;

use App\Models\Traits\Activable;
use App\Models\Traits\Addressable;
use App\Models\Traits\AttachmentLimitable;
use Bnb\Laravel\Attachments\HasAttachment;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Player
 *
 * @package App\Models
 */
class Player extends Model
{
    use Activable, Addressable, AttachmentLimitable, HasAttachment;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
    ];

    /**
     * Teams relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
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
