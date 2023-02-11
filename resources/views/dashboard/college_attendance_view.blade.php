@extends('dashboard.layouts.main')

@section('title','Attendance')
@section('content')

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">College Time Sheet</h1>

    </div>
    <!-- Content Row -->
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label for="cutoff">Cut-Off</label>
            <select class="form-control border-radius-2" name="cutoff" id="cutoff" required>
                {{-- <option value="" disabled selected>Select...</option> --}}
               @foreach ($cutoffs as $row)
                 <option value="{{$row->id}}">{{$row->start_date.' to '.$row->end_date }}</option>
               @endforeach
            </select>
        </div>
    </div>
</div>
    <div class="row">

        <div class="col-lg-12">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table cust-datatable" id="filtertable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>No. of Hour</th>
                                    <th>Rate</th>
                                </tr>
                                </thead>
                                <tbody class="table_body">
        
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="{{ asset('js/form-scripts/college_attendance_view.js') }}"></script>
@endsection
