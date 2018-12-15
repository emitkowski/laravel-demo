<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PolymorphicResponse;
use App\Models\Attachment;
use App\Services\Deliverable\AttachmentManager\Uploader;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

/**
 * Class AttachmentController
 *
 * @package App\Http\Controllers\Portal
 */
class AttachmentController extends Controller
{
    use PolymorphicResponse;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get Attachments
     *
     * @param $group
     * @param $type
     * @param $id
     * @return JsonResponse
     */
    public function index($type, $id, $group = null)
    {

        if (auth()->user()->cant('view', [Attachment::class, $id])) {
            return response()->json(['Permission Denied']);
        }

        $object = $this->getObject($type, $id);

        if (is_a($object, JsonResponse::class)) {
            return $object;
        }

        // Load attachments in group
        if (!is_null($group)) {
            $object = $object->load(['attachments'=> function ($query) use ($group) {
                $query->where('group', $group);
            }]);
        }

        return response()->json($object->attachments);
    }

    /**
     * Store Attachment
     *
     * @param Uploader $uploader
     * @param Request $request
     * @param $type
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Uploader $uploader, Request $request, $type, $id)
    {
        if (auth()->user()->cant('create', [Attachment::class, $id])) {
            return response()->json(['Permission Denied']);
        }

        $object = $this->getObject($type, $id);

        if (is_a($object, JsonResponse::class)) {
            return $object;
        }

        return $uploader->upload($request, $object);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Attachment $attachment_model
     * @param $uuid
     * @return JsonResponse
     */
    public function destroy(Attachment $attachment_model, $uuid)
    {
        $attachment = $attachment_model->where('uuid', $uuid)->first();

        if (!$attachment) {
            return response()->json('Attachment Not Found');
        }

        if (auth()->user()->cant('delete', $attachment)) {
            return response()->json('Permission Denied');
        }

        if ($attachment) {
            try {
                $attachment->delete();
            } catch (QueryException $exception) {
                return response()->json(['failed'], 400);
            }
        }

        return response()->json('success');
    }

    /**
     * Download Attachment
     *
     * @param $id
     * @param Request $request
     * @return void
     */
    public function download($id, Request $request)
    {
        $disposition = ($disposition = $request->input('disposition')) === 'inline' ? $disposition : 'attachment';

        $attachment = Attachment::where('uuid', $id)->first();

        if (!$attachment) {
            abort(404, Lang::get('attachments::messages.errors.file_not_found'));
        }

        if (auth()->user()->cant('download', $attachment)) {
            abort(403);
        }

        /** @var Attachment $file */
        if (!$attachment->output($disposition)) {
            abort(403, Lang::get('attachments::messages.errors.access_denied'));
        }
    }
}
