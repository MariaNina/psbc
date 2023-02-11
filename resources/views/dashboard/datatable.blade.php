@extends('dashboard.layouts.main')

@section('title')
    {{ env('APP_NAME') }}
@endsection

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
							Total Administrators
						</div>
						<div class="small text-xs text-muted mb-0 font-weight-bold">
								Number of admin
						</div>
					</div>
					<div class="col-auto">
						<span class="text-lg text-primary font-weight-bold">5</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
							Total Enrolled</div>
						<div class="small text-xs text-muted mb-0 font-weight-bold">
							Number of enrolees
						</div>
					</div>
					<div class="col-auto">
						<span class="text-lg text-success font-weight-bold">35</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Subjects
						</div>
						<div class="small text-xs text-muted mb-0 font-weight-bold">
							Number of subjects registered
						</div>
					</div>
					<div class="col-auto">
						<span class="text-lg text-info font-weight-bold">87</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
							Total Courses
						</div>
						<div class="small text-xs text-muted mb-0 font-weight-bold">
							Number of course registered
						</div>
					</div>
					<div class="col-auto">
						<span class="text-lg text-warning font-weight-bold">20</span>
					</div>
				</div>
			</div>
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
				<h6 class="m-0 font-weight-bold text-primary">Example Serverside Datatable</h6>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table  class="table cust-datatable" id="filtertable" width="100%" cellspacing="0">
					<thead>
						<tr>
						<th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>			
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
	
</div>


@endsection
@section('extra-js')
	{{-- Script for serverside DataTable --}}
	<script src="{{ asset('js/serversideDatatable.js') }}"></script>

@endsection