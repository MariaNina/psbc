<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function index() {

        $people = People::limit(30)->get();

        return view('people.people', [
            'people' => $people
        ]);
    }

    public function create()
    {
        return view('people.createpeople');
    }

    // Add
    public function store(Request $request)
    {
        // Add
        $people = new People();
        $people->image = $request->image;
        $people->name = $request->name;
        $people->description = $request->description;
        $people->date = $request->date;
        $people->status = "Active";

        $people->save(); //

    }

}
