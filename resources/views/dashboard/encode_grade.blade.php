@extends('dashboard.layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('extra-css')
<link
  href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css"
  rel="stylesheet"
  type="text/css"
/>
@endsection

@section('content')
<!-- Content Row -->

<div class="row">
@if($stud_num==0)
<h2>No students found</h2>
@else
  <div class="col-lg-12">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="d-lg-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-dark">
            <a class="d-none d-sm-inline-block btn btn-sm btn-light shadow-sm"  href="/encode_grades">
              <i class="fas fa-arrow-left font-lg fa-lg text-dark-50"></i>
            </a>
            Grades Encoding of section {{$sections->section_label}}
          </h6>
        </div>
      </div>
      <div class="card-body">
        <div class="mb-4">
          @if(session('user')->id !=1 || $staff->position!="Registrar")
          @if ($staff->gender =="Male")
          <h3>Mr. {{$staff->last_name}} {{$staff->first_name}} Advisory</h3>
          @elseif ($staff->gender == "Female" && $staff->civil_status =="Single")
          <h3>Ms. {{$staff->last_name}} {{$staff->first_name}} Advisory</h3>
          @elseif ($staff->gender == "Female" && $staff->civil_status =="Married")
          <h3>Mrs. {{$staff->last_name}} {{$staff->first_name}} Advisory</h3>
          @endif
          @endif
        </div>
        
        <div class="table-responsive">
          <table class="table cust-datatable" id="filtertable" width="100%" cellspacing="0">
              <thead>
          <tr>
              <th class="all">Students</th>
              @foreach ($subjects as $subject)
              <th>{{$subject->subject_name}}</th>
              @endforeach
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
        @php $x=0; @endphp
        @foreach ($students as $student)
        <tr>
         <td>{{$student->student_name}}</td>
         @foreach ($subjects as $subject)
         @if($student->grades!=null)
        <td>{{$grade[$student->rowNum][$x]}}</td>
         @else
         <td>{{60}}</td>
         @endif
         @if ($x<$countSubject)
         @php $x++; @endphp
           @else
           @php $x =0; @endphp
         @endif
         @endforeach
         <td><span class="actionCust viewDocument editGrade" title="encode grades" data-id="{{$student->grade_id}}"><a class=""><i class="fas fa-edit"></i></a></span></td>
        </tr>
        @endforeach
      </tbody>
          </table>
        </div>
          
      </div>
      </div>
    </div>
    @endif
  </div>

   @include('dashboard.modals.encode_grade')

@endsection

@section('extra-js')

<script type="text/javascript" src="{{ asset('js/datatable-scripts/encode_grade.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('js/form-scripts/schedule.js') }}"></script> --}}

@endsection