@extends('dashboard.layouts.main')

@section('title')
    Payslip Summary
@endsection

@section('content')
@include('dashboard.layouts.payslipmenu')
<!-- Page Heading -->

    <!-- CONTENT ROW -->
    <div class="row">
        <div class="col-sm-12">
        <div class="float-right">
            <h5 class="float-left">Salary Date:</h5>
            <select required style=" margin-left:5px;padding:2px; font-size:18px;" name="salary_date" id="salary_date" class="js-example-basic-single float-left ">
                @foreach ($cutOff as $co)
                <option value="{{$co->pay_day}},{{$co->start_date.'-'.$co->end_date}}">{{$co->pay_day}}</option>  
                @endforeach
            </select>            
        </div>
        </div>
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
                              <td>Pay Date</td>
                              <th>Name of Employee</th>
                              <th>Basic Pay</th>
                              <th>Hourly/Daily Rate</th>
                              <th>No. of Hours/Days</th>
                              <th>Hourly/Daily Pay</th>
                              <th>Special Allowance/Adjustment</th>
                              <th>Gross Pay</th>
                              <th>Lates/Under Time</th>
                              <th>Absences</th>
                              <th>Canteen</th>
                              <th>T/F</th>
                              <th>Cash Advance</th>
                              <th>Other Deduction</th>
                              <th>SSS</th>
                              <th>Total Deduction</th>
                              <th>Net Pay</th>
                              <th>Signature</th>
                          </tr>
                          </thead>
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
<script src="{{ asset('js/datatable-scripts/payslip_summary.js') }}"></script>
@endsection