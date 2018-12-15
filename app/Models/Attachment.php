<?php

namespace App\Models;

use App\Models\Traits\Activable;

/**
 * Class Attachment
 *
 * @package App\Models
 */
class Attachment extends \Bnb\Laravel\Attachments\Attachment
{
    use Activable;
}
