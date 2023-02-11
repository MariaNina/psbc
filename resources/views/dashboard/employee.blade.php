@extends('dashboard.layouts.main')

@section('title')
   Employees
@endsection

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Employees Lists</h1>

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
								<th class="all">No.</th>
                <th class="all">Picture</th>
								<th class="all">Fullname</th>
                <th class="">Biometric Id</th>
                <th class="">Employee ID No.</th>
								<th class="">Employment Type</th>
                <th class="all">Position</th>
                <th class="all">Department</th>
                <th class="">Major In</th>
                <th class="">Is Masteral</th>
                <th class="">Licence No.</th>
                <th class="">Birth Day</th>
                <th class="">Birth Place</th>
                <th class="all">Gender</th>
                <th class="all">Civil Status</th>
                <th class="">Height(m)</th>
                <th class="">Weight(kg)</th>
                <th class="">Blood Type</th>
                <th class="">GSIS No.</th>
                <th class="">SSS No.</th>
                <th class="">PhilHealth No.</th>
                <th class="">Pag-ibig No.</th>
                <th class="">Tin No.</th>
                <th class="">Agency Employee No.</th>
                <th class="">Citizenship</th>
                <th>Address</th>
                <th class="">Zip Code</th>
                <th class="">Telephone No.</th>
                <th class="all">Mobile No.</th>
                <th class="all" style="min-width: 120px !important;" class="">Action</th>
							</tr>
						</thead>
            <tbody></tbody>
					</table>
        </div>
      </div>
    </div>
  </div>

</div>
@include('dashboard.modals.employee')
@include('dashboard.modals.qrcode')

@endsection

@section('extra-js')

<script src="{{ asset('js/datatable-scripts/employee.js') }}"></script>
<script src="{{ asset('js/form-scripts/employee.js') }}"></script>
<script src="{{ asset('js/qrcode.min.js') }}"></script>
<script src="{{ asset('js/qrcode.js') }}"></script>
@endsection
