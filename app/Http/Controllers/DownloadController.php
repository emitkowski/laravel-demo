<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Services\Deliverable\ManagedContent\FileDownload;

class DownloadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show downloads
     *
     * @param FileDownload $fileDownloads
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(FileDownload $fileDownloads)
    {
        $downloads = $fileDownloads->all();

        $downloads = $downloads->sortBy(function ($download, $key) {
            return $download->attributes->field_file_download_type;
        });

        return view('portal.downloads', compact('downloads'));
    }
}
