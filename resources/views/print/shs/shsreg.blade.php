@extends('print.main')

@section('title')
{{ env('APP_NAME') }}
@endsection

@section('content')

@for($type = 0; $type < count($form_type_array); $type++)

<div id="shs-students-copy" class="container mb-3">

    <!-- Header -->
    <header class="">
        <center>
        <div class="top-header">
            <img src="{{ asset('img/logo.png') }}" class="mr-3" alt="psbc-logo" width="75" height="75" />
            
                <span class="font-weight-bold header-title">PAETE SCIENCE AND BUSINESS COLLEGE, INC.
               
                    <p class="location">{{strtoupper($assessment->enrollment->branch->branch_name)}}, LAGUNA</p>
                
                    <p class="shs-form-title">Registration Form - SHS Department</p>
                </span>
        </div>
        </center>
    </header>

    <!-- Input -->
    <div class="form-wrapper mt-3">

        <div class="d-flex justify-content-between">
            <h4 class="text-uppercase underline">{{$form_type_array[$type]}}</h4>
            <h5 class="text-uppercase">LRN/ESIDS/QVAN:
                <span
                    class="underline">{{($assessment->student->lrn != NULL) ? $assessment->student->lrn : $assessment->enrollment->application_no}}</span>
            </h5>
        </div>

        <div class="d-flex justify-content-between">
            <h5>Name: <span class="underline">{{$assessment->student->last_name}}, {{$assessment->student->first_name}}
                    {{$assessment->student->middle_name}}.</span></h5>
            <h5>Track/Strand:<span
                    class="underline">{{$assessment->enrollment->curriculum->programMajors->description}}</span></h5>
            {{-- <h5> <span class="underline">STEM</span></h5> --}}
        </div>

        <div class="d-flex justify-content-between">
            <h5>Date of Registration: <span
                    class="underline">{{date('F d, Y',strtotime($assessment->enrollment->date_submitted))}}</span></h5>
            <h5>Grade: <span class="underline">{{$assessment->enrollment->level->level_name}}</span></h5>
            <h5>Sem/Sum: <span class="underline">{{$assessment->enrollment->term->term_name}} /
                    {{$assessment->enrollment->school_year->school_years}}</span></h5>
        </div>

    </div>
    <div class="row">
        <div class="col-8 p-1">
            <!-- Table -->
            <table class="basic-table">
                <thead>
                    <tr>
                        <th class="min-w-100px">Core Subjects</th>
                        <th class="min-w-100px">Instructors</th>
                        <th class="min-w-25px">Day</th>
                        <th class="min-w-25px">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects_with_schedule as $item)
                    <tr>
                        <td>{{$item->subject_name}}</td>
                        <td>{{$item->first_name.' '.$item->last_name}}</td>
                        <td class="cell-center">{{$item->days}}</td>
                        <td class="cell-center">{{$item->start_time}}</td>
                    </tr>
                    @endforeach
                    @for($i = 0; $i < 8 - count($subjects_with_schedule); $i++) <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        </tr>
                      @endfor

                </tbody>
            </table>
            <br>
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
                                <th class="text-uppercase min-w-100px">Discounts</th>
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
                    @for($i = 0; $i < 6 - $lines; $i++) <tr>
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

    <p class="m-0 p-0"><i>Approved by:</i></p>

    <div class="signatures">
        <div class="d-flex justify-content-center">
            <p class="signature-line text-center">SHS RECORD CLERK</p>
        </div>

        <div class="d-flex justify-content-between">
            <p class="signature-line text-center">TREASURER</p>
            <p class="signature-line text-center">SHS COORDINATOR / PRINCIPAL</p>
        </div>


    </div>

</div>

<div class="page-br"></div>


<!--<div class="page-br"></div>-->
@endfor
@include('print.backpage')
@endsection
