@extends('landing.layouts.app')

@section('title')
    PSBC - Online Enrollment
@endsection

@section('content')
    <!-- SHOWCASE -->
    <header id="page-header" class="p-5">
        <div class="bg-overlay">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="container pt-5 text-center">
                            <h1>Online Registration</h1>

                            <p>Paete Science and Business College Inc. Online Registration Form for all Enrollees</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

<section class="py-3">
	<div class="container">
		<div class="row pt-2 pb-2">
			<div class="col-lg-6">
				<a href="/enrollment">
				<button type="button" class="btn btn-light align-right"><i class="fas fa-arrow-left font-lg fa-lg text-dark-50"></i></button>
				</a>
				<button type="button" class="btn btn-light align-right" onclick="printForm('application_form')"><i class="fa fa-print"></i> Print</button>
			</div>
			<div class="col-lg-6 d-flex justify-content-end">
					<input id="serach_box" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" value={{$app_no}}>
					<button id="search_application_button" class="btn btn-outline-success my-2 my-sm-0" type="button">Search</button>
			</div>
		</div>
	</div>
	<div class="container p-4" style="margin: auto; border: 1px solid black; box-shadow: 3px 3px 5px 6px #ccc;">	
		@if ($details)
		<div id="application_form">

				<style>

					.header {
						margin: 0;
						margin-bottom: 3px;
						padding: 0;
						text-align: center;
					}
				
					.heading {
						margin: 0;
						padding: 2px;
						font-size: 10pt;
						font-weight: bold;
						background-color: rgb(240, 224, 194)
					}
					.header-info-title {
						margin: 0;
						margin-bottom: 3px;
						padding: 0;
						text-align: center;
						font-size: 10pt;
						font-weight: bold;
					}
				
					.header-info {
						margin: 0;
						margin-bottom: 3px;
						padding: 0;
						text-align: center;
					font-size: 9pt;
					}
				
					.underlined {
						text-decoration: underline;
					}
					.table {
						border-collapse: collapse;
						width: 100%;
					}
					.table_header {
						border: 1px solid black;
						border-left: none;
						border-right: none;
						padding: 2px;
					}
					.list {
						list-style: none;
						padding: 0px;
						padding-left: 10px;
						padding-right: 10px;
					}
					.td {
						vertical-align:top;
						border: 1px solid black;
						width: 25%;
						padding: 2px;
						font-size: 12px;
					}
					.no-left-border {
						border-left: none;
					}
					.no-right-border {
						border-right: none;
					}
					.no-top-border {
						border-top: none;
					}
					.itemlabel {
						margin: 0px;
						font-size: 10pt;
						font-weight: bold;
						padding-left: 10px;
					}
					.item {
						margin: 0px;
						font-size: 11pt;
						padding-left: 10px;
					}
					.indent {
						margin-left: 40px;
					}
					.line {
						height: 1px;
						color: black;
						margin-top: 5px;
						margin-bottom: 5px;
						border-top: 1px solid black;
					}
					.no-bottom-border {
						border-bottom: none;
					}
					.date-column {
						margin: 0;
						padding: 0;
						border: 1px solid black;
						border-left: none;
						border-top: none;
						border-bottom: none;
						width: 10%;
						text-align: center;
					}
					.address-font {
						font-size: 9px;
						text-align: center;
						font-style: italic;
					}
					.break-line {
						border-top: 1px dashed black;
					}
					</style>
						<center>
							<img src="{{ $home->logo() }}" width="85" height="85" alt="psbc-logo"/>
							{{-- <p class="header-info">Paete Science and Business College</p> --}}
						</center>	
						<p class="header-info-title">APPLICATION FORM</strong>
						<p class="header-info">School Year: {{$details->school_year->school_years}}</p>
						{{-- <p class="header-info">Date and Time of Application: {{$details->date_submitted}} </p> --}}
						<p class="header-info" >Application No: <strong> {{$app_no}}</strong></p>
			
				
					<br>
					<p class="heading">ENROLLMENT DETAILS:</p>
						<br>
					<table style="width: 100%;margin-bottom: 10px">
				
						<tr>
							<td><p class="itemlabel">Student Department/Level/Type</p></td>
							<td><p class="item">{{$details->student_department}}/ {{$details->level->level_name}}/ {{$details->student_type}}</p></td>
						</tr>
						<tr>
							<td><p class="itemlabel">Program/Track/Strand</p></td>
							<td><p class="item">{{$details->curriculum->programMajors->programs->program_name}}</p></td>
						</tr>
						<tr>
							<td><p class="itemlabel">Major (if Applicable)</p></td>
							<td><p class="item">{{$details->curriculum->programMajors->majors->major_name}}</p></td>
						</tr>
						<tr>
							<td><p class="itemlabel">Application Status</p></td>
							<td><p class="item">
								{{$details->app_status}}
								</p>
							</td>
						</tr>
					</table>
					<hr>
					<p class="heading">STUDENT DETAILS:</p>
			<br>
					<table style="width: 100%;margin-bottom: 10px">
					<tr>
						<td><p class="itemlabel">First Name:</p></td>
						<td><p class="item">{{$details->student->first_name}}</p></td>
						<td><p class="itemlabel">Last Name:</p></td>
						<td><p class="item">{{$details->student->last_name}}</p></td>
					</tr>
					<tr>
						<td><p class="itemlabel">Middle Name (if any):</p></td>
						<td><p class="item">{{$details->student->middle_name}}</p></td>
						<td><p class="itemlabel">Email:</p></td>
						<td><p class="item">{{$details->student->email}}</p></td>
					</tr>
					<tr>
						<td><p class="itemlabel">LRN:</p></td>
						<td><p class="item">{{$details->student->lrn}}</p></td>
						<td><p class="itemlabel">Cellphone No.:</p></td>
						<td><p class="item">{{$details->student->contact_number}}</p></td>
					</tr>
					<tr>
						<td><p class="itemlabel">Birthday:</p></td>
						<td><p class="item">
							{{$details->student->birth_day}}
						</p></td>
						<td><p class="itemlabel">Gender:</p></td>
						<td><p class="item">
							{{$details->student->gender}}
						</p></td>
					</tr>

					<tr>
						<td><p class="itemlabel">Address:</p></td>
						<td><p class="item">
							{{$details->student->address}}
						</p></td>
					</tr>
					</table>
					<hr>
					<p class="heading">GUARDIAN DETAILS:</p>
					<br>
					<table style="width: 100%;margin-bottom: 10px">
						<tr>
							<td><p class="itemlabel">First Name:</p></td>
							<td><p class="item">{{$details->student->guardian->first_name}}</p></td>
							<td><p class="itemlabel">Last Name:</p></td>
							<td><p class="item">{{$details->student->guardian->last_name}}</p></td>
						</tr>
						<tr>
							<td><p class="itemlabel">Middle Name (if any):</p></td>
							<td><p class="item">{{$details->student->guardian->middle_name}}</p></td>
							<td><p class="itemlabel">Contact Number</p></td>
							<td><p class="item">{{$details->student->guardian->contact_number}}</p></td>
						</tr>

					</table>

					<hr>
			<br>
			<br>
			<br>
			_________________________________________ <br>
			*<em>To be signed by assigned Coordinator</em>
			<br>
			<br>
			<br>
			
		</div>	
		@else
			No Application Found
		@endif
	</div>
</section>

@endsection
@section('extra-js')
<script type="text/javascript">
	   function printForm(div) {

         let printContents = document.getElementById(div).innerHTML;
         let originalContents = document.body.innerHTML;
         document.body.innerHTML = printContents;
         window.print();
         document.body.innerHTML = originalContents;
        }

		$('#search_application_button').on('click', function() {
			let app_no = $('#serach_box').val();
			window.location.href = "/application/"+app_no;
   		});

</script>
@endsection