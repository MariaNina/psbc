@extends('dashboard.layouts.main')

@section('title')
    Discounts
@endsection

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Discounts List</h1>

        <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" data-toggle="modal"
           data-target="#addDiscountModal" href="#" role="button">
            <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
            Create New Discount
        </a>

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
                                <th>No.</th>
                                <th>Discount Name</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Discount Type</th>
                                <th>Student Department</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    @include('dashboard.modals.discountsModal')

@endsection

@section('extra-js')
    <script src="{{ asset('js/datatable-scripts/discounts.js') }}"></script>
    <script src="{{ asset('js/form-scripts/discounts.js') }}"></script>
@endsection
