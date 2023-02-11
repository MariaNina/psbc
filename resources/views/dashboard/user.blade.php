@extends('dashboard.layouts.main')

@section('title')
   Users
@endsection

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Users Account Lists</h1>

</div>
<!-- CONTENT ROW -->
<div class="row">

  <div class="col-lg-12">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>

          <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm createUser"  href="#" role="button" data-id="{{$one->id+1}}" data-toggle="modal" data-target="#addUserModal">
            <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
            Create New User
          </a>

        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table cust-datatable" id="filtertable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>No.</th>
                <th>Full Name</th>
								<th>Branch</th>
                <th>Username</th>
                <th>Email Address</th>
                <th>User Role</th>
                <th>Status</th>
                <th style="min-width: 165px !important;">Action</th>
							</tr>
						</thead>
					</table>
        </div>
      </div>
    </div>
  </div>

</div>
@include('dashboard.modals.user')
@include('dashboard.modals.user_permission')

@endsection

@section('extra-js')

<script src="{{ asset('js/datatable-scripts/user.js') }}"></script>
<script src="{{ asset('js/form-scripts/user.js') }}"></script>
<script src="{{ asset('js/form-scripts/user_permission.js') }}"></script>
<script src="{{ asset('js/form-scripts/user_reset_password.js') }}"></script>



@endsection
