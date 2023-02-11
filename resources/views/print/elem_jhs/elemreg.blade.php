@extends('print.main')

@section('title')
Elementary Registration
@endsection

@section('content')

@for($type = 0; $type < count($form_type_array); $type++)
<!-- Records -->
<div id="elem-records-copy" class="container mb-3">

  <!-- Header -->
  <header class="">
    <center>
      <div class="top-header">
        <img src="{{ asset('img/logo.png') }}" class="mr-3" alt="psbc-logo" width="75" height="75" />
        <span class="font-weight-bold header-title">
            PAETE SCIENCE AND BUSINESS COLLEGE, INC.
            <span>
                <p class="location">{{strtoupper($assessment->enrollment->branch->branch_name)}}, LAGUNA</p>
                <h3 class="elem-form-title">Application for Registration</h3>
    </div>
    </center>
  </header>

  <!-- Input -->
  <div class="form-wrapper mt-3">

      <div class="d-flex justify-content-between">
          <h4 class="text-uppercase underline">{{$form_type_array[$type]}}</h4>
          <h5 class="text-uppercase">Student No. <span
                  class="underline">{{($assessment->student->lrn != NULL) ? $assessment->student->lrn : $assessment->enrollment->application_no}}</span>
          </h5>
      </div>

      <div class="d-flex justify-content-between">
          <h5>Name: <span class="underline">{{$assessment->student->last_name}}, {{$assessment->student->first_name}}
                  {{$assessment->student->middle_name}}</span></h5>
          <h5 class="text-align-end">Department: <span class="underline">{{$assessment->student_department}}</span>
          </h5>
      </div>

      <div class="d-flex justify-content-between">
          <h5>Date or Registration: <span
                  class="underline">{{date('F d, Y',strtotime($assessment->enrollment->date_submitted))}}</span></h5>
          <h5>Year: <span class="underline">{{$assessment->enrollment->level->level_name}}</span></h5>
          <h5>Sch Yr: <span class="underline">{{$assessment->enrollment->school_year->school_years}}</span></h5>
      </div>

  </div>

  <div class="row">
      <div class="col-8 p-1">

          <table class="basic-table">
              <thead>
                  <tr>
                      <th class="text-uppercase min-w-100px">Subjects</th>
                      <th class="text-uppercase min-w-25px">Units</th>
                      <th class="text-uppercase min-w-100px">Instructors</th>
                      <th class="text-uppercase min-w-25px">Day</th>
                      <th class="text-uppercase min-w-25px">Time</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($subjects_with_schedule as $item)
                  <tr>
                      <td>{{$item->subject_name}}</td>
                      <td class="cell-center">{{(int)$item->lect_unit + (int)$item->lab_unit}}</td>
                      <td>{{$item->first_name}}</td>
                      <td class="cell-center">{{$item->days}}</td>
                      <td class="cell-center">{{$item->start_time}}</td>
                  </tr>
                  @endforeach
                  @for($i = 0; $i < 10 - count($subjects_with_schedule); $i++) <tr>
                      <td>-</td>
                      <td>-</td>
                      <td>-</td>
                      <td>-</td>
                      <td>-</td>
                      </tr>
                      @endfor
              </tbody>
          </table>
      </div>
      <div class="col-4 p-1">
          <!-- Table -->
          <table class="basic-table">
              <thead>
                  <tr>
                      <th class="text-uppercase min-w-100px">Fees</th>
                      <th class="text-uppercase min-w-50px">Amount</th>
                  </tr>
              </thead>
              <tbody>
                  <?php $lines = 0; ?>
                  @if($assessment->fees != NULL)
                  @foreach (json_decode($assessment->fees) as $fees)
                  <tr>
                      @if ($fees->fee_type != '')
                      <td class="">{{$fees->fee_type}}</td>
                      <td style="text-align:right;">{{$fees->fee_amount}}</td>
                      @endif
                  </tr>
                  @endforeach
                  <?php $lines += count(json_decode($assessment->fees)); ?>
                  @endif

                  @if($assessment->other_fees != NULL)
                  @foreach (json_decode($assessment->other_fees) as $fees)
                  <tr>
                      @if ($fees->other_fee_types != '')
                      <td class="">{{$fees->other_fee_types}}</td>
                      <td style="text-align:right;">{{$fees->other_fee_amount}}</td>
                      @endif
                  </tr>
                  @endforeach
                  <?php $lines += count(json_decode($assessment->other_fees)); ?>
                  @else
                  <tr>
                      <td></td>
                      <td></td>
                  <tr>
                      @endif
                      <thead>
                          <tr>
                              <th class=" min-w-100px">Discounts</th>
                              <th class="text-uppercase min-w-50px">Amount</th>
                          </tr>
                      </thead>
                      @if($assessment->discounts != NULL)
                      @foreach (json_decode($assessment->discounts) as $fees)
                  <tr>
                      @if ($fees->discount_type != '')
                      <td class="">{{$fees->discount_type}}</td>
                      <td style="text-align:right;">{{$fees->discount_amount}}</td>
                      @endif
                  </tr>
                  @endforeach
                  <?php $lines += count(json_decode($assessment->discounts)); ?>
                  @endif
                  @for($i = 0; $i < 8 - $lines; $i++) <tr>
                      <td>-</td>
                      <td>-</td>
                      </tr>
                      @endfor
                      <tr>
                          <td style="text-align:right;"> Total Fee : </td>
                          <td style="text-align:right;" class="text-uppercase">{{($assessment->fee_amount) ? "₱ ".$assessment->fee_amount : ""}}</td>
                      </tr>
              </tbody>
          </table>
      </div>
  </div>

  <div class="signatures mt-4">

      <div class="d-flex justify-content-around">

          <p class="signature-line text-center">{{$assessment->student_department}} Coordinator/Principal</p>
          <p class="signature-line text-center">Treasurer</p>
      </div>

  </div>


</div>
<div class="container-fluid">
  <div class="page-br"></div>
</div>

@endfor

@include('print.backpage')

@endsection
