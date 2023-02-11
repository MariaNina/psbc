@extends('dashboard.layouts.main')

@section('title')
    {{$title}}
@endsection

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Of Transactions</h1>

        @if (session('user')->role != "Student")
        <div class="card shadow h-100 py-2" style="border-right: 3px solid #138955;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-5">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Income (Today)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">₱ {{ $incomeForToday }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" data-toggle="modal"
           data-target="#addModal" href="#" role="button">
            <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
            Create New Assessment
        </a> --}}



    </div>

    <div class="row">
        @if (session('user')->role == "Student")
        <div class="col-xl-3 col-md-6 mb-4"></div>
        <div class="col-xl-3 col-md-6 mb-4"></div>
        <div class="col-xl-3 col-md-6 mb-4"></div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total Balance
                            </div>
                            <div class="small text-xs text-muted mb-0 font-weight-bold">
                                Total Account Balance
                            </div>
                        </div>
                        <div class="col-auto">
                            <span class="text-lg text-primary font-weight-bold">{{ $balance }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-12">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table cust-datatable" width="100%" id="filtertable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Branch</th>
                                    <th>Student Department</th>
                                    <th>Student Name</th>
                                    <th>Payment Method</th>
                                    <th>Payment Type</th>
                                    <th>Amount</th>
                                    <th>O.R. Number</th>
                                    <th>Daate of Payment</th>
                                    <th>Encoded By</th>
                                    <th class="all">Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    @include('dashboard.modals.assessmentModal')

@endsection

@section('extra-js')
    <script src="{{ asset('js/datatable-scripts/payments.js') }}"></script>
    <script src="{{ asset('js/form-scripts/assessments.js') }}"></script>
@endsection
