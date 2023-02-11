@extends('dashboard.layouts.main')

@section('title')
    Students
@endsection

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Parents/Guardians Lists</h1>
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
                                    <th class="all">First Name</th>
                                    <th class="all">Last Name</th>
                                    <th class="all">Middle Name</th>
                                    <th class="">Address</th>
                                    <th class="">Contact Number</th>
                                    <th style="all" class="all">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    @include('dashboard.modals.parentsModal')

@endsection

@section('extra-js')
    <script src="{{ asset('js/datatable-scripts/parents.js') }}"></script>
    <script src="{{ asset('js/form-scripts/parents.js') }}"></script>
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
