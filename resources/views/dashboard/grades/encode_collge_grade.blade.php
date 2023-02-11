@extends('dashboard.layouts.main')
@section('title')
    College Encode Grades
@endsection

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    
	<h1 class="h3 mb-0 text-gray-800">
        <a class="d-none d-sm-inline-block btn btn-sm btn-light shadow-sm"  href="/college_grade">
            <i class="fas fa-arrow-left font-lg fa-lg text-dark-50"></i>
          </a>
        Grades Encoding of subjects {{$subject->subject_name}}
    </h1>
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
								<th>No.</th>
								<th>Students</th> 
                <th>Grade</th>
                <th>Action</th>
							</tr>
						</thead>
					</table>
        </div>
      </div>
    </div>
  </div>

</div>
@include('dashboard.modals.encode_college_grade')
@endsection

@section('extra-js')
<script src="{{ asset('js/datatable-scripts/encode_college_grade.js') }}"></script>
<script src="{{ asset('js/form-scripts/encode_college_grade.js') }}"></script>
@endsection
