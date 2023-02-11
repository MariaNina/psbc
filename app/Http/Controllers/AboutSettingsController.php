<?php

namespace App\Http\Controllers;

use App\Models\AboutSettings;
use App\Models\BranchTbl;
use App\Models\CampusPhotos;
use App\Models\HomeSettings;
use App\Models\TemporaryFile;
use App\Utilities\AuditTrail;
use App\Utilities\Filepond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AboutSettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('authenticated')->except('index');

    }

    // Return About Page
    public function index()
    {
        $home = HomeSettings::first();
        $about = AboutSettings::first();
        $campus_photos = CampusPhotos::all();
        $branches = BranchTbl::all();

        // Check for maintenance mode
        if ($home->is_maintenance == true) {
            return view('ui.maintenance');
        }

        return view('landing.about', compact('home', 'about', 'branches', 'campus_photos'));
    }

    // Update the About Form Settings
    public function update(Request $request, AboutSettings $about)
    {
        /**
         * set old data for audit trail
        **/
        $old_data = AboutSettings::first();

        $input = $request->only([
            'page_title',
            'page_subtitle',
            'about_title',
            'about_content',
            'vision',
            'mission'
        ]);

        $data = array_merge($input, []);

        $about = AboutSettings::first();

        if ($request->has('about_img')) {

            // If file does exist, remove file and add new file
            Filepond::deleteFileWhenFound($about->about_img);

            $path = Filepond::getUploadedFile($request, 'about_img');

            $data = array_merge($data, ['about_img' => $path]);

        }
        try {
            $about->update($data);

            //add log in audit trail
            $new_data = $about;
            $action_taken = 'Update';
            $description = 'Update About Settings';
            AuditTrail::logAuditTrail( $action_taken , $description, $new_data, $old_data);
            //

            return response()->json([
                'msg' => 'About content has been updated.'
            ], 200);
            
        } catch (\Exception $e) {
            return back()->with('errors', 'Something went wrong, try again later!');

        }
    }

}
