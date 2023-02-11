@extends('dashboard.layouts.main')

@section('title')
Attendance
@endsection

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Staff Attendance</h1>
    
  <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" data-toggle="modal" data-target="#uplaodAttendance" href="#" role="button">
    <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
     Upload
  </a>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="form-group">
            <label for="cut_off">From</label>
            <input class="form-control border-radius-2" type="date" name="" id="from_date">
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="form-group">
            <label for="cut_off">To</label>
            <input class="form-control border-radius-2" type="date" name="" id="to_date">
        </div>
    </div>
    <div class="col-lg-2 col-md-6 col-sm-12">
        <div class="form-group">
            <label for="department">Department</label>
            <select class="form-control border-radius-2" name="department" id="department" required>
                <option selected value="all">Select Department</option>
                <option value="Elementary">Elementary</option>
                <option value="JHS">Junior High School</option>
                <option value="SHS">Senior High School</option>
                <option value="College">College</option>
                <option value="Graduate Studies">Graduate Studies</option>
            </select>
        </div>
    </div>
    {{-- <div class="col-lg-2 col-md-6 col-sm-12">
        <div class="form-group">
            <label for="status">Punch Type</label>
            <select class="form-control border-radius-2" name="punch_type" id="punch_type" required>
                <option selected value="all">All</option>
                <option value="0">Time In</option>
                <option value="1">Time Out</option>
                <option value="2">Break Out</option>
                <option value="3">Break In</option>
                <option value="4">OT In</option>
                <option value="5">OT Out</option>
            </select>
        </div>
    </div> --}}
    <div class="col-lg-2 col-md-6 col-sm-12">
        <div class="form-group">
            <label for=""></label>
            <input id="btn_filter" type="submit" class="btn btn-secondary btn-block" value="Filter"/>
        </div>
    </div>
</div>
<!-- CONTENT ROW -->
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
                                <th>No.</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Shift</th>
                                <th>Shift Hours</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Lates</th>
                                <th>Undertime</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


@include('dashboard.staff.staff_modals.modal_staff_attendance')

@endsection

@section('extra-js')
<script src="{{ asset('js/form-scripts/staff-attendance.js') }}"></script>
<script src="{{ asset('js/datatable-scripts/staff-attendance.js') }}"></script>
@endsection
