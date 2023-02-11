<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\People;
use Yajra\DataTables\DataTables;

class DatatableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $people = People::all();

            return DataTables::of($people)
                ->addColumn('action', function ($people) {


                    $button = '<span class="actionCust">
                                    <a class=""><i class="fas fa-edit"></i></a>
                                </span>
                                <span clawebss="actionCust">
                                    <a class="delete-btn"><i class="fa fa-trash"></i></a>
                                </span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }

        return view('dashboard.datatable');
    }
}

