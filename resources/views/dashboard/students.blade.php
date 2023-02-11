@extends('dashboard.layouts.main')

@section('title')
    Students
@endsection

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Students Lists</h1>
        <div>
            <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" data-toggle="modal"
            data-target="#addStudentsModal" href="#" role="button">
                <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
                Add Student
            </a>
            <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" data-toggle="modal"
            data-target="#addMultipleStudentsModal" href="#" role="button">
                <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
                Add Multiple Student
            </a>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-12">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table cust-datatable" width="100%" id="filtertable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="all">No.</th>
                                    <th>User Name</th>
                                    <th class="">Student Type</th>
                                    <th class="">LRN</th>
                                    <th class="all">First Name</th>
                                    <th class="all">Middle Name</th>
                                    <th class="all">Last Name</th>
                                    <th class="">Email</th>
                                    <th class="">Contact Number</th>
                                    <th class="">Address</th>
                                    <th class="all">Status</th>
                                    <th style="min-width: 170px !important;" class="all">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    @include('dashboard.modals.studentsModal')
    @include('dashboard.modals.qrcode')

@endsection

@section('extra-js')
    <script src="{{ asset('js/datatable-scripts/students.js') }}"></script>
    <script src="{{ asset('js/form-scripts/students.js') }}"></script>
    <script src="{{ asset('js/qrcode2.js') }}"></script>
    <script src="{{ asset('js/qrcode.js') }}"></script>
    <script>
        function isNumber(evt) {
           evt = (evt) ? evt : window.event;
           var charCode = (evt.which) ? evt.which : evt.keyCode;
           if (charCode > 31 && (charCode < 48 || charCode > 57)) {
               return false;
           }
           return true;
       }
      
   </script>
@endsection
