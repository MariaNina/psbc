<?php


namespace App\Utilities;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Filepond
{
    /**
     * Moves the file where its belong and return the path to be uploaded
     *
     * @param Request $request
     * @param STRING $key
     * @return STRING $path of the image
     */
    public static function getUploadedFile(Request $request, $key)
    {
        $temporaryFile = TemporaryFile::where('folder', $request->input($key))->first();

        $data = null;

        if ($temporaryFile) {
            $filename = $temporaryFile->filename;
            $saveToFolder = $temporaryFile->save_to;

            $from = trim($saveToFolder . '/tmp/' . $request->input($key) . '/' . $filename);

            $to = trim('/' . $saveToFolder . '/' . $filename);

            // Move file from tmp folder to where its belong
            Storage::disk('public')->move($from, $to);

            $path = trim('/' . $saveToFolder . '/' . $filename);

            $data = $path;

            rmdir('storage/' . $saveToFolder . '/tmp/' . $request->input($key)); // Remove directory

            $temporaryFile->delete();

        }

        return $data; // Return data path
    }


    /**
     * Deletes the file when exist
     *
     * @param STRING $path
     * @return BOOLEAN Return true if file is found and deleted
     */
    public static function deleteFileWhenFound($path)
    {
        $success = false;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            $success = true;
        }

        return $success;
    }


    /**
     * Upload file on temporary folder on filesystem
     *
     * @param Request $request
     * @param STRING $key request key
     * @param STRING $saveToFolder folder to be saved to
     * @return string[] Return the associative array of tmp folder, filename and where folder to be saved to
     */
    public static function uploadFileTemporarily(Request $request, $key, $saveToFolder)
    {

        // Get The File Name With Extension
        $filenameWithExt = $request->file($key)->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        $extension = $request->file($key)->extension();

        $folder = uniqid() . '-' . now()->timestamp;

        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        // Upload Image
        $request->file($key)->storeAs(
            'public/' . $saveToFolder . '/tmp/' . $folder, $fileNameToStore
        );

        return [
            'tmp_folder' => $folder,
            'fileName' => $fileNameToStore,
            'saveToFolder' => $saveToFolder
        ];

    }


    /**
     * Upload file on storage filesystem (public disk)
     *
     * @param Request $request
     * @param STRING $key request key
     * @param STRING $folder folder to be saved to
     * @return STRING Return the uploaded path
     */
    public static function saveFile(Request $request, $key, $folder)
    {
        // Get The File Name With Extension
        $filenameWithExt = $request->file($key)->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        $extension = $request->file($key)->extension();

        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        $saveToFolder = 'public/' . $folder;

        // Upload Image
        $request->file($key)->storeAs(
            $saveToFolder, $fileNameToStore
        );

        $path = '/' . $folder . '/' . $fileNameToStore;

        return $path;
    }

}
