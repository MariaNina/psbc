@extends('dashboard.layouts.main')

@section('title')
    View Payslip
@endsection

@section('content')
@include('dashboard.layouts.payslipmenu')
<!-- Page Heading -->
<div class="float-right">
<h5 class="float-left">Salary Date:</h5>
<select required style=" margin-left:5px;padding:2px; font-size:18px;" name="salary_date" id="salary_date" class="js-example-basic-single float-left ">
    <option>--Select--</option>
    @foreach ($cutOff as $co)
    <option value="{{$co->id}}">{{$co->pay_day}}</option>  
    @endforeach
</select>
<button type="submit" id="generate" class="btn btn-success ml-3">Generate</button>
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
      @media print{
        body *{
          visibility: hidden;
        }

        .print_container, .print_container *{
          visibility: visible;
        }
        .print_container table{
          width: 100%;
          margin: auto;
          padding: 0px;
        }
      }
    </style>
    <div class="card-body print_container raw">
      <div id="payslips" class="col-12">
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
@endsection