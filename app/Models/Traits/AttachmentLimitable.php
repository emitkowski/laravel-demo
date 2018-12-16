<?php

namespace App\Models\Traits;

/**
 * Trait AttachmentLimitable
 *
 * @package App\Models\Traits
 */
trait AttachmentLimitable
{

    /**
     * Get Attachment Count Attribute
     *
     * @return int
     */
    public function getAttachmentCountAttribute()
    {
        return $this->attachments()->count();
    }

    /**
     * Get Attachment Storage Used Attribute
     *
     * @return int
     */
    public function getAttachmentStorageUsedAttribute()
    {
        return $this->attachments()->sum('filesize');
    }
}