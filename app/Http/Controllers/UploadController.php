<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use App\Utilities\Filepond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request, $saveToFolder = 'landing_img')
    {
        $data = $request->except('_token');

        // Loop in each incoming request
        foreach ($data as $key => $value) {

            if ($request->hasFile($key)) {

                $file = Filepond::uploadFileTemporarily($request, $key, $saveToFolder);

                // Save the temporary File -- Will be deleted later
                $tmp = TemporaryFile::create([
                    'folder' => $file["tmp_folder"],
                    'filename' => $file["fileName"],
                    'save_to' => $file["saveToFolder"]
                ]);

                return $tmp->folder; // Return the folder for filepond
            }

        }

        return '';
    }

    // For CKEDITOR Image Uploading
    public function upload(Request $request)
    {
        $path = Filepond::saveFile($request, 'upload', 'landing_img');

        $path = '/storage' . $path;

        return response()->json([
            'url' => $path
        ]);
    }

}
