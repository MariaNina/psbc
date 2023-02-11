<?php

namespace App\Http\Controllers;

use App\Models\BranchTbl;
use App\Models\CampusPhotos;
use App\Models\HomeSettings;
use App\Models\ProgramPhotos;
use App\Utilities\AccessRoute;
use App\Utilities\Filepond;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('authenticated')->except('index', 'show');
    }

    // Show the our programs landing page
    public function index()
    {
        $home = HomeSettings::first();
        $branches = BranchTbl::all();

        $program_photos = ProgramPhotos::all();

        // Check for maintenance mode
        if ($home->is_maintenance == true) {
            return view('ui.maintenance');
        }

        return view('landing.programs', compact('home', 'branches', 'program_photos'));
    }

    public function show($id)
    {
        return ProgramPhotos::find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        // Add Image
        $request->validate([
            'program_file' => 'required',
            'program_name' => 'required',
            'program_description' => 'required'
        ]);

        $path = null;

        $data = [
            'name' => $request->program_name,
            'description' => $request->program_description
        ];

        if ($request->has('program_file')) {

            $path = Filepond::getUploadedFile($request, 'program_file');

            $data = array_merge($data, ['file' => $path]);

        }

        ProgramPhotos::create($data);

        $program_photo = ProgramPhotos::all();

        $images = '';

        foreach ($program_photo as $photo) {
            $images .= '<div class="col-md-4">
                            <div class="d-flex justify-content-center mb-3">
                                <img class="circle-wrapper img-relative" src="' . asset('/storage' . $photo->file) . '" alt="' . $photo->id . '">
                            </div>
                            <div class="delete-icon">
                                <a data-id="' . $photo->id . '" id="deleteProgramImg" href="#programs_photos">
                                    <i class="fas fa-trash-alt text-white"></i>
                                </a>
                            </div>
                            <div class="text-center">
                                <p>' . $photo->name . '</p>
                            </div>
                      </div>';
        }

        return response()->json([
            'msg' => 'Data has been added',
            'data' => $images
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\ProgramSettings $programSettings
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $home = HomeSettings::first();

        $home->update([
            'program_pagetitle' => $request->program_pagetitle,
            'program_contentitle' => $request->program_contentitle
        ]);

        return response()->json([
            'msg' => 'Content has been updated'
        ]);
    }

    public function destroy($id)
    {
        $program = ProgramPhotos::findOrFail($id);
        // If file does exist, remove file
        Filepond::deleteFileWhenFound($program->file);

        // Delete from database
        ProgramPhotos::destroy($id);

        //  Update UI
        $program_photo = ProgramPhotos::all();

        $images = '';

        foreach ($program_photo as $photo) {
            $images .= '<div class="col-md-4">
                            <div class="d-flex justify-content-center mb-3">
                                <img class="circle-wrapper img-relative" src="' . asset('/storage' . $photo->file) . '" alt="' . $photo->id . '">
                            </div>
                            <div class="delete-icon">
                                <a data-id="' . $photo->id . '" id="deleteProgramImg" href="#programs_photos">
                                    <i class="fas fa-trash-alt text-white"></i>
                                </a>
                            </div>
                            <div class="text-center">
                                <p>' . $photo->name . '</p>
                            </div>
                      </div>';
        }

        return response()->json([
            'msg' => 'Data has been removed',
            'data' => $images
        ]);
    }

}
