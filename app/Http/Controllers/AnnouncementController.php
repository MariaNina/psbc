<?php

namespace App\Http\Controllers;

use App\Http\Requests\Announcement\StoreAnnouncementRequest;
use App\Http\Requests\Announcement\UpdateAnnouncementRequest;
use App\Models\Announcement;
use App\Models\BranchTbl;
use App\Models\HomeSettings;
use App\Models\TemporaryFile;
use App\Models\UsersTbl;
use App\Utilities\Filepond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('authenticated')->except('index', 'show');
    }

    public function announcements(Request $request)
    {
        $announcement = Announcement::where('branch_id', session('user')->branch_id)->latest()
            ->get()
            ->makeHidden(['created_at', 'updated_at']);

        // Datatable
        if ($request->ajax()) {
            return DataTables::of($announcement)
                ->addColumn('announcement_body', function ($announcement) {

                    $body = '
                <span class="text-start">' . $announcement->announcement_body . '</span>
                ';

                    return $body; // Return Button
                })
                ->addColumn('action', function ($announcement) {
                    $button = '
                    <span class="actionCust">
                        <a href="#!" class="editEventModalBtn" id="editAnnouncementModalBtn" data-id="' . $announcement->id . '" role="button" data-toggle="modal" data-target="#editAnnouncementModal"><i class="fas fa-edit"></i></a>
                    </span>
                    <span class="actionCust">
                        <a href="#!" id="editDeleteAnnouncementModalBtn" data-id="' . $announcement->id . '" class="delete-btn"><i class="fa fa-trash"></i></a>
                    </span>
                    <span class="actionCust">
                        <a href="' . route('announcements.show', $announcement->id) . '" target="_blank"><i class="fas fa-eye"></i></a>
                    </span>
                    ';

                    return $button; // Return Button
                })
                ->rawColumns(['announcement_body', 'action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        return redirect()->route('landing.home');
    }

    public function index()
    {
        $announcements = null;
        $search = null;
        $filterBranch = null;


        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = trim(strip_tags($_GET['search']));
        }

        if (isset($_GET['branch_filter']) && !empty($_GET['branch_filter'])) {
            $filterBranch = trim(strip_tags($_GET['branch_filter']));
        }

        $branches = BranchTbl::all();

        // Check if $_GET['branch_filter'] is a valid branch
        $isValidBranch = false;
        foreach ($branches as $branch) {
            if ($branch->id == $filterBranch) {
                $isValidBranch = true;
                break;
            }
        }

        // URL has been manually changed or ALL
        if (!$isValidBranch) {
            $announcements = Announcement::latest('created_at')->paginate(6); // Returb ALL
        }

        // If there is NO query parameters
        if (!isset($_GET['search']) || empty($_GET['search']) || $_GET['search'] == "" || !isset($_GET['branch_filter']) || empty($_GET['branch_filter'])) {
            $announcements = Announcement::latest('created_at')->paginate(6); // Returb ALL
        }

        // Search for both
        if (isset($filterBranch) && isset($search) && !empty($filterBranch) && !empty($search) && $isValidBranch) {
            $announcements = Announcement::where('announcement_title', 'like', '%' . $search . '%')
                ->where('branch_id', $filterBranch)
                ->latest()
                ->paginate(6)
                ->withQUeryString();
        }

        // Return results by branch
        if (isset($filterBranch) && !empty($filterBranch) && $isValidBranch && empty($search)) {
            $announcements = Announcement::where('branch_id', $filterBranch)
                ->latest()
                ->paginate(6)
                ->withQUeryString();
        }

        // Return results by search
        if (isset($search) && !empty($search) && !$isValidBranch) {
            $announcements = Announcement::where('announcement_title', 'like', '%' . $search . '%')
                ->latest()
                ->paginate(6)
                ->withQUeryString();
        }


        $announcements->append([
            'search' => $search ?? '',
            'branch_filter' => $filterBranch ?? ''
        ]);

        $home = HomeSettings::first();

        // Check for maintenance mode
        if ($home->is_maintenance == true) {
            return view('ui.maintenance');
        }

        return view('landing.announcements.index', compact('announcements', 'home', 'branches'));
    }

    public function show(Announcement $announcement)
    {
        $home = HomeSettings::first();
        if ($home->is_maintenance == true) {
            return view('ui.maintenance');
        }

        $branches = BranchTbl::all();

        return view('landing.announcements.show', compact('announcement', 'home', 'branches'));
    }

    public function store(StoreAnnouncementRequest $request)
    {


        $path = null;

        $data = array_merge($request->validated());

        if ($request->has('announcement_image')) {

            $path = Filepond::getUploadedFile($request, 'announcement_image');
            $data = array_merge($data, ['announcement_image' => $path]);
        }

        // get branch where authenticated user belongs
        $user = UsersTbl::findOrFail(session('user')->id);

        Announcement::create(array_merge($data, ['branch_id' => $user->branch_id]));

        return response()->json(['msg' => 'New announcement has been created']);
    }

    public function edit(Announcement $announcement)
    {
        $announcement = $announcement->with('branch')->findOrFail($announcement->id);
        return response()->json($announcement);
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $path = null;

        $data = array_merge($request->validated(), []);

        if ($request->has('announcement_image')) {
            // If file does exist, remove file
            Filepond::deleteFileWhenFound($announcement->announcement_image);
            $path = Filepond::getUploadedFile($request, 'announcement_image');
            $data = array_merge($data, ['announcement_image' => $path]);
        }

        $announcement->update($data);

        return response()->json(['msg' => 'An announcement has been updated']);

    }

    public function destroy(Announcement $announcement)
    {
        // If file does exist, remove file
        Filepond::deleteFileWhenFound($announcement->announcement_image);
        $announcement->delete();
        return response()->json(['msg' => 'Your data has been deleted.']);
    }


}
