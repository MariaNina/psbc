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
  <h1 class="h3 mb-0 text-gray-800">Curriculum</h1>

  <div class="dropdown no-arrow">
    <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm dropdown-toggle"  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
      New Curriculum
    </a>
  
    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#elemCurriculumModal">Elementary</a>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#jhsCurriculumModal">Junior Highschool</a>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#shsCurriculumModal">Senior Highschool</a>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#collegeCurriculumModal">College</a>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#gradStudCurriculumModal">Graduate Studies</a>

    </div>
  </div>

  
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
								<th>Curriculum Year</th>
								<th class="all">Program</th>
								<th class="all">Major</th>
								<th>Description</th>
								<th>Student Department</th>
                <th>Student Level</th>
								{{-- <th>No. of Subjects</th>
								<th>Total Units</th> --}}
								<th class="all">School Year</th>
                <th class="all">Status</th>
								<th class="all">Action</th>
							</tr>
						</thead>
					
					</table>
        </div>
      </div>
    </div>
  </div>
    
</div>

  @include('dashboard.modals.curriculum.collegeModal')
  @include('dashboard.modals.curriculum.shsModal')
  @include('dashboard.modals.curriculum.elemModal')
  @include('dashboard.modals.curriculum.jhsModal')
  @include('dashboard.modals.curriculum.gradStudModal')

@endsection

@section('extra-js')

<script type="text/javascript" src="{{ asset('js/form-scripts/collegeCurriculum.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/form-scripts/gradStudCurriculum.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/form-scripts/shsCurriculum.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/form-scripts/elemCurriculum.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/form-scripts/jhsCurriculum.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/datatable-scripts/collegeCurriculum.js') }}"></script>

@endsection