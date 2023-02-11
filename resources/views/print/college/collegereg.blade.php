@extends('print.main')

@section('title')
    College
@endsection

@section('content')

@for($type = 0; $type < count($form_type_array); $type++)
    <!-- Student's Copy -->
    <div id="college-students-copy" class="container mb-3">

        <!-- Header -->
        <header class="">
          <center>
          <div class="top-header mt-2">
            <img
              src="{{ asset('img/logo.png') }}"
              class="mr-3"
              alt="psbc-logo"
              width="73"
              height="73"
            />
            <span class="font-weight-bold header-title">
              PAETE SCIENCE AND BUSINESS COLLEGE, INC.<br>
            <span>
            <p class="location">{{strtoupper($assessment->enrollment->branch->branch_name)}}, LAGUNA</p>
            <h3 class="elem-form-title">CERTIFICATE OF MALTRICULATION</h3>
          </div>
        </center>
        </header>

        <!-- Input -->
        <div class="form-wrapper mt-2">

          <div class="d-flex justify-content-between m-3">
            <h5 class="text-uppercase underline">{{$form_type_array[$type]}}</h5>
            
            <h5 class="text-uppercase">Student No. :
              <span class="underline">{{($assessment->student->lrn != NULL) ? $assessment->student->lrn : $assessment->enrollment->application_no}}</span>
            </h5>
          </div>

          <div class="d-flex justify-content-between" id="college_of_row">
            <h5>Name: <span class="underline">{{$assessment->student->last_name}}, {{$assessment->student->first_name}} {{$assessment->student->middle_name}}</span></h5>
            <h5 id="college_of" class="text-align-end">College of: 
              <span class="underline">{{$assessment->enrollment->curriculum->programMajors->description}}<!-- New -->
            
              

              <small id="new">[
                {{ ($assessment->enrollment->student_type == 'New') ? '✔' : '__' }}
              
                ] New	
              </small>
              <small id="old">[   
                {{ ($assessment->enrollment->student_type == 'Old') ? '✔' : '__' }}
                  ] Old
              </small>

            </span>
            </h5>

          </div>

          <div class="d-flex justify-content-between">
            <h5>Date or Registration: <span class="underline">{{date('F d, Y',strtotime($assessment->enrollment->date_submitted))}}</span></h5>
            <h5>Year: <span class="underline">{{$assessment->enrollment->level->level_name}}</span></h5>
            <h5>Sem/Sum: <span class="underline">{{$assessment->enrollment->term->term_name}} / {{$assessment->enrollment->school_year->school_years}}</span></h5>
          </div>

        </div>
        <div class="row">
            <div class="col-8 p-1">
              
                <table class="basic-table" >
                  <thead>
                    <tr>
                      <th style="font-size:11px;" class="text-uppercase min-w-100px">Subjects</th>
                      <th style="font-size:11px;" class="text-uppercase min-w-25px">Units</th>
                      <th style="font-size:11px;" class="text-uppercase min-w-100px">Instructors</th>
                      <th style="font-size:11px;" class="text-uppercase min-w-25px">Day</th>
                      <th style="font-size:11px;" class="text-uppercase min-w-25px">Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($subjects_with_schedule as $item)
                      <tr>
                        <td style="font-size:11px;">{{$item->subject_code}}</td>
                        <td style="font-size:11px;" class="cell-center">{{(int)$item->lect_unit + (int)$item->lab_unit}}</td>
                        <td style="font-size:11px;">{{$item->last_name}}</td>
                        <td style="font-size:11px;" class="cell-center">{{$item->days}}</td>
                        <td style="font-size:11px;" class="cell-center">{{$item->start_time}}</td>
                      </tr>      
                    @endforeach
                    @for($i = 0; $i < 10 - count($subjects_with_schedule); $i++) <tr>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
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
                        <th style="font-size:11px;" class="text-uppercase min-w-100px">Fees</th>
                        <th style="font-size:11px;" class="text-uppercase min-w-50px">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $lines = 0; ?>
                    @if($assessment->fees != NULL)
                    @foreach (json_decode($assessment->fees) as $fees)
                    <tr>
                        @if ($fees->fee_type != '')
                        <td style="font-size:11px;"  class="">{{$fees->fee_type}}</td>
                        <td style="font-size:11px;" style="text-align:right;">{{$fees->fee_amount}}</td>
                        @endif
                    </tr>
                    @endforeach
                    <?php $lines += count(json_decode($assessment->fees)); ?>
                    @endif

                    @if($assessment->other_fees != NULL)
                    @foreach (json_decode($assessment->other_fees) as $fees)
                    <tr>
                        @if ($fees->other_fee_types != '')
                        <td style="font-size:11px;" class="">{{$fees->other_fee_types}}</td>
                        <td style="font-size:11px;" style="text-align:right;">{{$fees->other_fee_amount}}</td>
                        @endif
                    </tr>
                    @endforeach
                    <?php $lines += count(json_decode($assessment->other_fees)); ?>
                    @else
                    <tr>
                        <td style="font-size:11px;"></td>
                        <td style="font-size:11px;"></td>
                    <tr>
                        @endif
                        <thead>
                            <tr>
                                <th style="font-size:11px;" class=" min-w-100px">Discounts</th>
                                <th style="font-size:11px;" class="text-uppercase min-w-50px">Amount</th>
                            </tr>
                        </thead>
                        @if($assessment->discounts != NULL)
                        @foreach (json_decode($assessment->discounts) as $fees)
                    <tr>
                        @if ($fees->discount_type != '')
                        <td style="font-size:11px;" class="">{{$fees->discount_type}}</td>
                        <td style="font-size:11px;" style="text-align:right;">{{$fees->discount_amount}}</td>
                        @endif
                    </tr>
                    @endforeach
                    <?php $lines += count(json_decode($assessment->discounts)); ?>
                    @endif
                    @for($i = 0; $i < 7 - $lines; $i++) <tr>
                        <td style="font-size:11px;">-</td>
                        <td style="font-size:11px;">-</td>
                        </tr>
                        @endfor
                        <tr>
                            <td style="text-align:right; font-size:9px;"> Total Fee : </td>
                            <td style="text-align:right; font-size:9px;" class="text-uppercase">{{($assessment->fee_amount) ? "₱ ".$assessment->fee_amount : ""}}</td>
                        </tr>
                </tbody>
            </table>
          
          </div>
        </div>
 

        <p class="m-0 p-0"><i>Approved by:</i></p>

        <div class="signatures mt-4">

          <div class="d-flex justify-content-between">
          
            <p class="signature-line text-center text-uppercase">Treasurer</p>
            <p class="signature-line text-center text-uppercase">Registrar</p>
            <p class="signature-line text-center text-uppercase">Dean</p>
          </div>
        <br>
        </div>

    </div>

    <div class="container-fluid">
      <div class="page-br"></div>
  </div>
@endfor
    @include('print.backpage')
@endsection
