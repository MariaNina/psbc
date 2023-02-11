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

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <a class="d-none d-sm-inline-block btn btn-sm btn-light shadow-sm"  href="{{route('curriculum.getCurriculums')}}">
    <i class="fas fa-arrow-left font-sm fa-sm text-dark-50"></i>
  </a><h1 class="h3 mb-0 text-gray-800" id="cur_des">{{ucwords(strtolower($cur_id->curriculum_description))}} Subjects</h1>

  <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm"  href="#" role="button" data-toggle="modal" data-target="#addCurriculumSubjectsModal">
    <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
    Add Subjects
  </a>
  
</div>
<!-- Content Row -->

<div class="row">

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
                        <th>#</th>
                        <th>Term</th>
                        <th class="all">Subject</th>
                        <th class="all">Pre-Requisite</th>
                        <th>Offered</th>
                        <th>Active</th>
                        <th class="all">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
    </div>
  </div>
    
</div>

  @include('dashboard.modals.curriculumSubjectsModal')

@endsection

@section('extra-js')

<script type="text/javascript" src="{{ asset('js/datatable-scripts/curriculumSubjects.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/form-scripts/curriculumSubjects.js') }}"></script>

@endsection