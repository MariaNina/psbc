@extends('dashboard.layouts.main')

@section('title')
    Majors
@endsection

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Majors Lists</h1>

  <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" data-toggle="modal" data-target="#addMajorModal" href="#" role="button">
    <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
    Create New Major
  </a>
</div>
<!-- CONTENT ROW -->
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
								<th>Major Code</th>
								<th>Major Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
							</tr>
						</thead>
					</table>
        </div>
      </div>
    </div>
  </div>

</div>
@include('dashboard.modals.majorModal')

@endsection

@section('extra-js')

<script src="{{ asset('js/form-scripts/major.js') }}"></script>
<script src="{{ asset('js/datatable-scripts/major.js') }}"></script>
@endsection
