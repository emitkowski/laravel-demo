<?php

namespace App\Services\AttachmentManager;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

/**
 * Class Uploader
 *
 * @package App\Services\AttachmentManager
 */
class Uploader
{
    /**
     * Uploader constructor.
     *
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Upload File Attachment
     *
     * @param Request $request
     * @param $object
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, $object)
    {
        $file = $request->file('file');

        // Check file upload errors
        if (!$file->isValid()) {
            return response()->json(['success' => false, 'message' => $file->getErrorMessage()], 400);
        }

        // Check if user limits met
        $limit_check = $this->checkFileLimits($object, $file);

        if ($limit_check !== true) {
            return $limit_check;
        }

        // Attach File to Object
        $object->attach($file, ['group' => $request->input('group')]);

        return response()->json(['success' => true]);
    }

    /**
     * Check File Limits
     *
     * @param $object
     * @param $file
     * @return bool
     */
    private function checkFileLimits($object, $file)
    {
        if (!is_a($object, Player::class)) {
            return true;
        }

        $qty_limit = config('attachments.limits.player.quantity');
        $storage_limit = config('attachments.limits.player.storage');

        $storage_limit_bytes = $storage_limit * 1048576;

        if ($object->attachment_count >= $qty_limit) {
            return response()->json(['success' => false, 'message' => 'You have reached your upload limit of ' . $qty_limit . ' files.'], 400);
        }

        if ($object->attachment_storage_used + $file->getSize() >= $storage_limit_bytes) {
            return response()->json(['success' => false, 'message' => 'This upload exceeds your storage limit of ' . $storage_limit . ' MB.'], 400);
        }

        return true;
    }
}
