@extends('dashboard.layouts.main')

@section('title')
    View Payslip
@endsection

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#!">View Payslip</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <!-- Page Heading -->
    <div class="float-right">
        <h5 class="float-left">Salary Date:</h5>
        <select required style=" margin-left:5px;padding:2px; font-size:18px;" name="salary_date" id="salary_date"
                class="js-example-basic-single float-left ">
            <option selected value="">--Select--</option>
            @foreach ($cutOff as $co)
                <option value="{{$co->id}}">{{$co->pay_day}}</option>
            @endforeach
        </select>
        <button type="submit" id="viewBtn" class="btn btn-success ml-3">View</button>
    </div>
    <!-- CONTENT ROW -->
    <br><br>
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>
            <button onclick="window.print()" class="float-right border-0" style="background-color: transparent">
                <i class="fas fa-print" style="font-size: 20px;"></i>
            </button>

        </div>
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                .print_container, .print_container * {
                    visibility: visible;
                }

                .print_container table {
                    width: 100%;
                    margin: auto;
                    padding: 0px;
                }
            }
        </style>
        <div class="card-body print_container row">
            <div id="payslip" class="col-12">
                <h5 class="text-center">Choose salary date</h5>
            </div>
        </div>
    </div>


    <div class="col-lg-12">

        <!-- DataTales Example -->


    </div>


    {{-- @include('dashboard.modals.roomModal') --}}

@endsection

@section('extra-js')
    {{-- <script src="{{ asset('js/form-scripts/room.js') }}"></script> --}}
    <script src="{{ asset('js/payslip.js') }}"></script>
    <script src="{{ asset('js/form-scripts/view_payslip.js') }}"></script>
@endsection
