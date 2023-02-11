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

  <div class="col-lg-8 m-auto">
    <!-- DataTales Example -->
    <div class="card shadow mb-12">
      <div class="card-header py-3">
        <div class="d-lg-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-dark">
            <a class="d-none d-sm-inline-block btn btn-sm btn-light shadow-sm"  href="{{redirect()->back()->getTargetUrl()}}">
              <i class="fas fa-arrow-left font-lg fa-lg text-dark-50"></i>
            </a>
           Sections Under {{$staff->last_name}}, {{$staff->first_name}}
          </h6>
        </div>
      </div>
      <div class="card-body">
        <div class="mb-12">
          @foreach ($sections as $section)
          <a href="/encode_grades/{{$section->id}}" class="btn btn-primary mb-2" style="width: 100%">{{$section->section_label}}</a>
          @endforeach 
        </div>
          
      </div>
      </div>
    </div>
  </div>

   @include('dashboard.modals.encode_grade')

@endsection

@section('extra-js')

<script type="text/javascript" src="{{ asset('js/datatable-scripts/encode_grade.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('js/form-scripts/schedule.js') }}"></script> --}}

@endsection