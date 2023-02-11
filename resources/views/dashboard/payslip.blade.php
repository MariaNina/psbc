@extends('dashboard.layouts.main')

@section('title')
    View Payslip
@endsection

@section('content')
@include('dashboard.layouts.payslipmenu')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">View Payslip</h1><br>
  <form id="payslipFilter" role="form" enctype="multipart/form-data" data-toggle="validator">
    @csrf
    <h5 class="float-left">Salary Date:</h5>
    <select required style=" margin-left:5px;padding:2px; font-size:18px;" name="salary_date" id="salary_date" class="js-example-basic-single float-left ">
        <option>--Select--</option>
        @foreach ($cutOff as $co)
        <option value="{{$co->id}}">{{$co->pay_day}}</option>  
        @endforeach
    </select>
    <p class="float-left"> </p>
    <h5 class="float-left ml-4"> Employee Name:</h5>
    <select required style=" margin-left:5px;padding:2px; font-size:18px;" name="employee_name" id="employee_name" class="js-example-basic-single ">
        <option>--Select--</option>
        @foreach ($staffs as $staff)
        <option value="{{$staff->id}}">{{$staff->last_name}}{{", " }}{{$staff->first_name}}</option>  
        @endforeach
    </select>
    <button class="btn btn-success"><i class="fas fa-filter"></i>Filter</button>
</form>
</div>

<!-- CONTENT ROW -->
<h3 id="intro" class="text-center"></h3>
<div class="row" id="card_payslip">

  <div class="col-lg-12">
    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <button onclick="window.print()" class="float-right border-0" style="background-color: transparent">
            <i class="fas fa-print" style="font-size: 20px;"></i>
        </button>

      </div>
      <div class="card-body">
        <div>
            <div class="text-center">
                
                <span class="font-weight-bold header-title" style="line-height: 1px;">
                    <img
            src="{{ asset('img/logo.png') }}"
            class="mr-4"
            alt="psbc-logo"
            width="40"
            height="40"
          />
                  PAETE SCIENCE AND BUSINESS COLLEGE, INC.
                  <p class="location" style="line-height: 2px;">PAETE, LAGUNA</p>
                </span>
            </div>
            <div class="row ml-4">
                <div class="col-7">
                    <span class="font-weight-bold">Employee Payslip: </span><span id="payslip_id"></span><br>
                    <span class="font-weight-bold">Pay Type:</span> Semi-Monthly<br>
                    <span class="font-weight-bold">Name:</span><span id="full_name"></span><br>
                    <span class="font-weight-bold">Employee Id:</span><span id="staff_id"></span><br>
                    <span class="font-weight-bold">Department/Position: </span><span id="dept_pos"></span><br>
                </div>
                <div class="col-5">
                    <span class="font-weight-bold">DTR Coverage: </span><span id="dtr_coverage"></span><br>
                    <span class="font-weight-bold">Pay Date: </span><span id="pay_date"></span><br>
                    <span class="font-weight-bold">Print Date: </span><span id="today"></span><br>
                </div>
            </div>
            <table class="table table-borderless" style="border: 1px solid;">
                <thead style="border: 1px solid;">
                <tr>
                    <th>EARNINGS</th>
                    <th>DEDUCTIONS</th>
                    <th>NET PAY</th>
                </tr>
                </thead>
                <tbody style="border: 0px; padding:0;">
                <tr style="line-height: 0px;">
                    <td>
                        <div class="row">
                            <div class="col-6">Basic Pay:</div>
                            <div class="col-6" id="basicpay"></div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-3">Late/UTime</div>
                            <div class="col-3">5</div>
                            <div class="col-3">Others:</div>
                            <div class="col-3">-</div>
                        </div>
                    </td>
                    <td></td>
                </tr>
                {{-- 2 --}}
                <tr style="line-height: 0px;">
                    <td>
                        <div class="row">
                            <div class="col-6">Daily Rate</div>
                            <div class="col-6" id="daily_rate"></div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-3">Absence:</div>
                            <div class="col-3" id="absence"></div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                        </div>
                    </td>
                    <td></td>
                </tr>
                {{--3--}}
                <tr style="line-height: 0px;">
                    <td>
                        <div class="row">
                            <div class="col-6">No. of Days:</div>
                            <div class="col-6" id="no_days"></div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-3">Canteen:</div>
                            <div class="col-3">0</div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                        </div>
                    </td>
                    <td></td>
                </tr>
                {{--4--}}
                <tr style="line-height: 0px;">
                    <td>
                        <div class="row">
                            <div class="col-6">Semi-Monthly Pay:</div>
                            <div class="col-6" id="pay"></div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-3">Tuition Fee:</div>
                            <div class="col-3">0</div>
                            <div class="col-3">CA:</div>
                            <div class="col-3">-</div>
                        </div>
                    </td>
                    <td></td>
                </tr>
                {{--5--}}
                <tr style="line-height: 0px;">
                    <td>
                        <div class="row">
                            <div class="col-6">Special Allow:</div>
                            <div class="col-6">1000</div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-3">SSS:</div>
                            <div class="col-3">5</div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                        </div>
                    </td>
                    <td></td>
                </tr>
                {{--6--}}
                <tr style="line-height: 0px; border:1px solid;">
                    <td>
                        <div class="row">
                            <div class="col-6">Gross Pay:</div>
                            <div class="col-6" id="gross"></div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-3">Deduction</div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3" id="deduction"></div>
                        </div>
                    </td>
                    <td>Total net Pay: <span id="total_net"></span></td>
                </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
    
</div>


{{-- @include('dashboard.modals.roomModal') --}}

@endsection

@section('extra-js')
{{-- <script src="{{ asset('js/form-scripts/room.js') }}"></script> --}}
<script src="{{ asset('js/payslip.js') }}"></script>
@endsection