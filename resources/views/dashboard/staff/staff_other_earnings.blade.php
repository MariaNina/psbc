@extends('dashboard.layouts.main')

@section('title')
Other Earnings
@endsection

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Staff Other Earnings</h1>

    <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" data-toggle="modal"
        data-target="#addAllowanceModal" href="#" role="button">
        <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
        Add New
    </a>
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
                                <th>Staff Name</th>
                                <th>Other Earnings/ Allowances</th>
                                <th>Amount</th>
                                <th>Cut-off Period</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


@include('dashboard.staff.staff_modals.modal_staff_other_earnings')

@endsection

@section('extra-js')
<script src="{{ asset('js/form-scripts/staff-other-earnings.js') }}"></script>
<script src="{{ asset('js/datatable-scripts/staff-other-earnings.js') }}"></script>
@endsection
