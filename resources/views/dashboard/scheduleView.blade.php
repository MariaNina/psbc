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

  <div class="col-lg-12">
    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-dark">
            <a class="d-none d-sm-inline-block btn btn-sm btn-light shadow-sm"  href="{{route('sections.index')}}">
              <i class="fas fa-arrow-left font-lg fa-lg text-dark-50"></i>
            </a>
            Schedule for {{$level->level_name}} Section {{$section->section_label}}
          </h6>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
                    <table class="table cust-datatable" id="filtertable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Room</th>
                        <th>Days</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th class="all">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
    </div>
  </div>
    
</div>

  @include('dashboard.modals.schedule') 

@endsection

@section('extra-js')

<script type="text/javascript" src="{{ asset('js/datatable-scripts/schedule.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('js/form-scripts/schedule.js') }}"></script> --}}
@endsection