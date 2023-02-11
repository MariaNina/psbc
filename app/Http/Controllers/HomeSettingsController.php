<?php

namespace App\Http\Controllers;

use App\Models\AboutSettings;
use App\Models\Announcement;
use App\Models\BranchTbl;
use App\Models\CampusPhotos;
use App\Models\Event;
use App\Models\HomeSettings;
use App\Models\ProgramPhotos;
use App\Utilities\AccessRoute;
use App\Utilities\Filepond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HomeSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('authenticated')->except('home');
        $this->middleware('has_permission:settings')->except('home');
        // has_permission:<name of page on the database>

    }

    // Return the Home landing page
    public function home(Request $request)
    {
        $home = HomeSettings::first();
        // Check for maintenance mode
        if ($home->is_maintenance == true) {
            return view('ui.maintenance');
        }

        $events = Event::limit(2)->latest('created_at')->get();
        $announcements = Announcement::limit(3)->latest('created_at')->get();

        $campus_photos = CampusPhotos::all();
        $branches = BranchTbl::all();

        return view('landing.index', compact('home', 'events', 'announcements', 'campus_photos', 'branches'));

    }

    // All Settings Forms - Home, About
    public function index(Request $request)
    {
        $home = HomeSettings::first();
        $about = AboutSettings::first();
        $campus_photos = CampusPhotos::all();
        $program_photos = ProgramPhotos::all();

        $permissions = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.settings', compact('home', 'about', 'campus_photos', 'program_photos', 'permissions'));
    }

    // Update Home Settings
    public function update(Request $request, HomeSettings $setting)
    {
        // Setup the validator
        $rules = array(
            'email' => 'email',
            'facebook' => 'url',
            'carousel_link1' => 'url',
            'carousel_link2' => 'url',
            'home_announcement_link' => 'url',
        );

        $validator = Validator::make($request->all(), $rules);

        // Validate the input and return correct response
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => array_map(function ($fieldErrors) {
                    return $fieldErrors[0];
                }, $validator->getMessageBag()->toArray())
            ], 422);
            // 400 being the HTTP code for an invalid request.
        }

        $data = array_merge($request->all(), []);

        $home = HomeSettings::first();

        if ($request->has('logo')) {
            // If file does exist, remove file and add new file
            Filepond::deleteFileWhenFound($home->logo);
            $path = Filepond::getUploadedFile($request, 'logo');
            $data = array_merge($data, ['logo' => $path]);
        }

        if ($request->has('carousel_img1')) {
            // If file does exist, remove file and add new file
            Filepond::deleteFileWhenFound($home->carousel_img1);
            $path = Filepond::getUploadedFile($request, 'carousel_img1');
            $data = array_merge($data, ['carousel_img1' => $path]);
        }

        if ($request->has('carousel_img2')) {
            Filepond::deleteFileWhenFound($home->carousel_img2);
            $path = Filepond::getUploadedFile($request, 'carousel_img2');
            $data = array_merge($data, ['carousel_img2' => $path]);
        }

        if ($request->has('carousel_img3')) {
            Filepond::deleteFileWhenFound($home->carousel_img3);
            $path = Filepond::getUploadedFile($request, 'carousel_img3');
            $data = array_merge($data, ['carousel_img3' => $path]);
        }

        if ($request->has('home_announcement_img')) {
            // If file does exist, remove file and add new file
            Filepond::deleteFileWhenFound($home->home_announcement_img);
            $path = Filepond::getUploadedFile($request, 'home_announcement_img');
            $data = array_merge($data, ['home_announcement_img' => $path]);
        }

        if ($request->has('home_announcement_img_background')) {
            // If file does exist, remove file and add new file
            Filepond::deleteFileWhenFound($home->home_announcement_img_background);
            $path = Filepond::getUploadedFile($request, 'home_announcement_img_background');
            $data = array_merge($data, ['home_announcement_img_background' => $path]);
        }

        if ($request->has('offer_img')) {
            // If file does exist, remove file and add new file
            Filepond::deleteFileWhenFound($home->offer_img);
            $path = Filepond::getUploadedFile($request, 'offer_img');
            $data = array_merge($data, ['offer_img' => $path]);
        }
        try {

            $setting->update($data);

            return response()->json([
                'msg' => 'Home content has been updated',
                'request' => $request->all()
            ]);

        } catch (\Exception $e) {
            return back()->with('errors', 'Something went wrong, try again later!');
        }


    }

    public function addCampusImage(Request $request)
    {
        $path = null;
        if ($request->has('file')) {
            $path = Filepond::getUploadedFile($request, 'file');
        }

        CampusPhotos::create(['file' => $path]);
        $all_campus = CampusPhotos::all();
        $images = '';

        foreach ($all_campus as $photo) {
            $images .= '<div class="col-md-4 mb-3">
             <img class="img-fluid img-relative" src="/storage' . $photo->file . '"
                 width="350"
                 height="300"
                 alt="{{ $photo->file }}" />
                 <div class="delete-icon">
                   <a data-id="' . $photo->id . '" id="deleteCampusImg" href="#campus_images">
                        <i class="fas fa-trash-alt text-white"></i>
                   </a>
                 </div>
            </div>';
        }

        return response()->json([
            'msg' => 'Image has been added',
            'data' => $images
        ]);


    }

    public function deleteCampusImage(CampusPhotos $photo)
    {
        // If file does exist, remove file from file system
        Filepond::deleteFileWhenFound($photo->file);

        $photo->delete(); // Delete from database

        $all_campus = CampusPhotos::all();

        $images = '';

        foreach ($all_campus as $photo) {
            $images .= '<div class="col-md-4 mb-3">
             <img class="img-fluid img-relative" src="/storage' . $photo->file . '"
                 width="350"
                 height="300"
                 alt="{{ $photo->file }}" />
                 <div class="delete-icon">
                   <a data-id="' . $photo->id . '" id="deleteCampusImg" href="#campus_images">
                        <i class="fas fa-trash-alt text-white"></i>
                   </a>
                 </div>
            </div>';
        }

        return response()->json([
            'msg' => 'Image has been removed',
            'data' => $images
        ]);


    }

    public function maintenance()
    {
        $home = HomeSettings::first();

        $value = null;
        if ($home->is_maintenance == true) {
            $value = 0;
        } else {
            $value = 1;
        }

        $home->update([
            'is_maintenance' => $value
        ]);

        return response()->json(['msg' => 'Maintenance mode has been changed.']);
    }
}
