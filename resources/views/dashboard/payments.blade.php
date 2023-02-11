@extends('dashboard.layouts.main')

@section('title')
    {{$title}}
@endsection

@section('content')

    <!-- Page Heading -->
   
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 mb-3">List Of Transactions</h1>
            <div class="form-group">
                @if (session('user')->role != "Student")
                <label for="branches">Grade levels</label>
                <select class="form-control" style="border: 1px solid #222;" id="levels" name="levels">
                    <option selected value="">All</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                    @endforeach
                </select>
                @endif
            </div>
           
            <div class="form-group">
                @if (session('user')->role != "Student")
                <input type="date" class="form-control form-control-user mb-1"
                       id="date" name="date">
                <div class="d-flex">
                    <button id="refresh" class="btn btn-sm btn-secondary text-white px-3 py-1"><i
                            class="fas fa-redo"></i></button>
                    <button id="filter_date" class="btn btn-sm ml-1 text-white"
                            style="background: #0c66ea; box-shadow: 1px 1px #0c6af3;">Filter <i
                            class="fas fa-filter"></i></button>
                </div>
                @endif
            </div>
        </div>

        
        @if (session('user')->role != "Student")
            <div class="card shadow h-100 py-2" style="border-right: 3px solid #138915;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-5">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Income
                            </div>
                            <div id="total_income" class="h5 mb-0 font-weight-bold text-gray-800">
                                ₱ {{ $totalIncome }}
                            </div>
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
                                <th>Date of Payment</th>
                                <th>Encoded By</th>
                                <th class="all">Status</th>
                                 @if (session('user')->role != "Student")
                               <th>Actions</th>
                               @else 
                               <th>Actions</th>
                                 @endif
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
    <script src="{{ asset('js/form-scripts/payment_total_income.js') }}"></script>
    <script src="{{ asset('js/form-scripts/payments.js') }}"></script>

@endsection
