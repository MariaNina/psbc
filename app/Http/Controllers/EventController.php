<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Models\BranchTbl;
use App\Models\Event;
use App\Models\HomeSettings;
use App\Models\UsersTbl;
use App\Utilities\Filepond;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    public function datatable(Request $request)
    {
        $events = Event::where('branch_id', session('user')->branch_id)
            ->latest()
            ->get()
            ->makeHidden(['created_at', 'updated_at']);

        // Datatable
        if ($request->ajax()) {
            return DataTables::of($events)
                ->addColumn('body', function ($events) {

                    $body = '
                <span class="text-start">' . $events->body . '</span>
                ';

                    return $body; // Return Button
                })
                ->addColumn('upcoming_at', function ($events) {

                    $upcoming_at = '
                    <span>' . Carbon::parse($events->upcoming_at)->isoFormat('MMM Do YYYY') . '</span>
                    ';

                    return $upcoming_at; // Return Button
                })
                ->addColumn('status', function ($events) {

                    $class = ($events->upcoming_at > now()) ? 'mode_on' : 'mode_off';
                    $is_upcoming = ($events->upcoming_at > now()) ? 'Upcoming' : 'Ended';

                    $status = '
                    <span class="mode ' . $class . ' ">
                    ' . $is_upcoming . '
                    </span>
                    ';

                    return $status; // Return Button
                })
                ->addColumn('action', function ($events) {
                    $button = '
                    <span class="actionCust">
                        <a href="#!" class="editEventModalBtn" id="editEventModalBtn" data-id="' . $events->id . '" role="button" data-toggle="modal" data-target="#editEventModal"><i class="fas fa-edit"></i></a>
                    </span>
                    <span class="actionCust">
                        <a href="#!" id="editDeleteEventModalBtn" data-id="' . $events->id . '" class="delete-btn"><i class="fa fa-trash"></i></a>
                    </span>
                    <span class="actionCust">
                        <a href="' . route('events.show', $events->id) . '" target="_blank"><i class="fas fa-eye"></i></a>
                    </span>
                    ';

                    return $button; // Return Button
                })
                ->rawColumns(['body', 'upcoming_at', 'status', 'action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        return redirect()->route('landing.home');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = null;
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
            $events = Event::latest('created_at')->paginate(6); // Returb ALL
        }

        // If there is NO query parameters
        if (!isset($_GET['search']) || empty($_GET['search']) || $_GET['search'] == "" || !isset($_GET['branch_filter']) || empty($_GET['branch_filter'])) {
            $events = Event::latest('created_at')->paginate(6); // Returb ALL
        }

        // Search for both
        if (isset($filterBranch) && isset($search) && !empty($filterBranch) && !empty($search) && $isValidBranch) {
            $events = Event::where('title', 'like', '%' . $search . '%')
                ->where('branch_id', $filterBranch)
                ->latest()
                ->paginate(6)
                ->withQUeryString();
        }

        // Return results by branch
        if (isset($filterBranch) && !empty($filterBranch) && $isValidBranch && empty($search)) {
            $events = Event::where('branch_id', $filterBranch)
                ->latest()
                ->paginate(6)
                ->withQUeryString();
        }

        // Return results by search
        if (isset($search) && !empty($search) && !$isValidBranch) {
            $events = Event::where('title', 'like', '%' . $search . '%')
                ->latest()
                ->paginate(6)
                ->withQUeryString();
        }


        $events->append([
            'search' => $search ?? '',
            'branch_filter' => $filterBranch ?? ''
        ]);

        $home = HomeSettings::first();

        // Check for maintenance mode
        if ($home->is_maintenance == true) {
            return view('ui.maintenance');
        }

        return view('landing.events.index', compact('home', 'events', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEventRequest $request
     * @return JsonResponse
     */
    public function store(StoreEventRequest $request)
    {
        $path = null;

        $data = array_merge($request->validated(), []);

        if ($request->has('image')) {

            $path = Filepond::getUploadedFile($request, 'image');

            $data = array_merge($data, ['image' => $path]);

        }

        // get branch where authenticated user belongs
        $user = UsersTbl::findOrFail(session('user')->id);

        Event::create(array_merge($data, ['branch_id' => $user->branch_id]));

        return response()->json(['msg' => 'New event has been created']);

    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return Application|Factory|View
     */
    public function show(Event $event)
    {
        $home = HomeSettings::first();
        if ($home->is_maintenance == true) {
            return view('ui.maintenance');
        }

        $branches = BranchTbl::all();

        return view('landing.events.show', compact('event', 'home', 'branches'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return JsonResponse
     */
    public function edit(Event $event)
    {
        $event = $event->with('branch')->findOrFail($event->id);
        $event->date = Carbon::parse($event->upcoming_at)->toDateString();
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Event $event
     * @return JsonResponse
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required',
            'upcoming_at' => ['required', 'date'],
            'image' => '',
            'body' => 'required',
            'link' => ''
        ]);

        $path = null;

        $data = array_merge($validated, []);

        if ($request->has('image')) {

            // If file does exist, remove file
            Filepond::deleteFileWhenFound($event->image);

            $path = Filepond::getUploadedFile($request, 'image');
            $data = array_merge($data, ['image' => $path]);

        }

        $event->update($data);

        return response()->json(['msg' => 'An event has been updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return JsonResponse
     */
    public function destroy(Event $event)
    {
        Filepond::deleteFileWhenFound($event->image);

        $event->delete();
        return response()->json(['msg' => 'Your data has been deleted.']);
    }


}
