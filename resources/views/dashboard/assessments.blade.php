@extends('dashboard.layouts.main')

@section('title')
    {{$title}}
@endsection

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 mb-3">Assessments</h1>
                     <form id="branch_filter_form" class="d-inline-block d-flex mt-3">
                <div class="form-group">
                    <label for="branches">Branches</label>
                    <select class="form-control" style="border: 1px solid #222;" id="branches" name="branches">
                        <option selected value="All">All</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="form-group ml-3">
                    <label for="levels">Grade levels</label>
                <select class="form-control" style="border: 1px solid #222;" id="levels" name="levels">
                    <option selected value="All">All</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group ml-3">
                    <label for="programs">Programs</label>
                <select class="form-control" style="border: 1px solid #222;" id="programs" name="programs">
                    <option selected value="All">All</option>
                </select>
                </div>
                <div class="form-group ml-3">
                    <button class="btn btn-secondary" style="margin-top:38%" id="filter-search" type="button">Search</button>
                </div>

            </form>
        </div>

        @if (session('user')->role != "Student")
            <div class="card shadow h-100 py-2" style="border-right: 3px solid #138915;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-5">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Balance
                            </div>
                            <div id="total_balance" class="h5 mb-0 font-weight-bold text-gray-800">
                                ₱ {{ $balance }}
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
                                    <th>Application Number</th>
                                    <th>Student Name</th>
                                    <th>Total Units</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                    {{-- <th>Payment Type</th> --}}
                                    <th>Student Department</th>
                                    <th>Program</th>
                                    <th>Status</th>
                                    <th class="all">Action</th>
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
    @include('dashboard.modals.paymentModal')

@endsection

@section('extra-js')
    <script src="{{ asset('js/datatable-scripts/assessments.js') }}"></script>
    <script src="{{ asset('js/form-scripts/assessments.js') }}"></script>
    <script src="{{ asset('js/form-scripts/assessment_balance.js') }}"></script>
    <script src="{{ asset('js/form-scripts/payments.js') }}"></script>
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
