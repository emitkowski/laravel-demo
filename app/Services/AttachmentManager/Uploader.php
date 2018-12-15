<?php

namespace App\Services\AttachmentManager;

use App\Models\User;
use App\Notifications\AttachmentUpload;
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

        // Check if user email verified
        if (!$this->checkEmailedVerified($object)) {
            return response()->json(['success' => false, 'message' => 'Must verify your email before uploading files'], 400);
        }

        // Check if user limits met
        $limit_check = $this->checkUserFileLimits($object, $file);

        if ($limit_check !== true) {
            return $limit_check;
        }

        // Attach File to Object
        $attachment = $object->attach($file, ['group' => $request->input('group')]);

        $this->sendNotification($attachment, $request->input('group'));

        return response()->json(['success' => true]);
    }

    /**
     * Send Upload Notification
     *
     * @param $attachment
     * @param null $group
     * @return bool
     */
    private function sendNotification($attachment, $group = null)
    {
        if (is_null($group)) {
            $group = 'general';
        }

        $this->notification->route('mail', config('company.upload_notifications.' . snake_case(strtolower($group))))->notify(new AttachmentUpload($attachment));

        return true;
    }

    /**
     * Check email verification
     *
     * @param $object
     * @return bool
     */
    private function checkEmailedVerified($object)
    {
        if (!is_a($object, User::class)) {
            return true;
        }

        return $object->isVerified();
    }


    /**
     * Check User File Limits
     *
     * @param $object
     * @param $file
     * @return bool
     */
    private function checkUserFileLimits($object, $file)
    {
        if (!is_a($object, User::class)) {
            return true;
        }

        if ($object->isApproved()) {
            $qty_limit = config('attachments.limits.user.approved.quantity');
            $storage_limit = config('attachments.limits.user.approved.storage');
        } else {
            $qty_limit = config('attachments.limits.user.unapproved.quantity');
            $storage_limit = config('attachments.limits.user.unapproved.storage');
        }

        $storage_limit_bytes = $storage_limit * 1048576;

        if ($object->attachment_count >= $qty_limit) {
            return response()->json(['success' => false, 'message' => 'You have reached your upload limit of '. $qty_limit . ' files.'], 400);
        }

        if ($object->attachment_storage_used + $file->getSize() >= $storage_limit_bytes) {
            return response()->json(['success' => false, 'message' => 'This upload exceeds your storage limit of '. $storage_limit . ' MB.'], 400);
        }

        return true;
    }
}
