@extends('print.main')

@section('title')
    {{ env('APP_NAME') }}
@endsection

@section('content')
    <div class="container">

      <!-- Header -->
      <header class="mt-4 mb-5">
        <div class="text-center">
          <span class="font-weight-bold header-title">
			      PAETE SCIENCE AND BUSINESS COLLEGE, INC.
		      <span>
		      <p class="location">PAETE, LAGUNA</p>
      </div>
      </header>

    <!-- Info -->
	  <div class="rule">
      <h4 class="title text-uppercase font-weight-bold underline">
        Rules Concerning Fees and Deposits:
      </h4>

      <ul class="list-style-none ml-5 rules-list line-h">
        <li class="mb-3">
         <span>*</span>
         Entrance fee are payable in cash and not refundable. Tuition fees are payable in cash.
         Fees are on a semestral or quarterly basis in the Collegiate and on a yearly basis in the
         High School and Elementary Departments. Payments by installment may be allowed for the convenience of the student. If the students stops, studying or transfer to another School, he/she shall be liable to pay the full unpaid balance for the entire semester/summer or year, as the case may be.
        </li>
        <li>
          <h5 class="font-weight-bold"><span>*</span>On the SHS VOUCHER Program:</h5>
		  &nbsp;&nbsp;
		  Students shall comply/qualify the requirement's stated in DepEd Order No. 46s. 2015 Permit

          <ul class="list-style-none ml-5 pl-3 line-h">
            <li>
              1st Quarter <span class="underline-bottom">XXX-XXX-XXX</span>
            </li>
            <li>
			  2nd Quarter <span class="underline-bottom">XXX-XXX-XXX</span>
            </li>
            <li>
			  3rd Quarter <span class="underline-bottom">XXX-XXX-XXX</span>
            </li>
            <li>
			  4th Quarter <span class="underline-bottom">XXX-XXX-XXX</span>
            </li>
          </ul>

        </li>
      </ul>

	  </div>

    </div>

    <!-- Page Break -->
    <div class="container-fluid">
      <div class="page-br"></div>
    </div>

    <div class="container mt-3 mb-5">

      <div class="form-wrapper mb-2">
        <div class="d-flex justify-content-between">
          <h5>Student's Name: 
            <span class="underline-bottom">Miras, Robert B.</span>
          </h5>
          <h5>Track: <span class="underline-bottom">Academic Track</span></h5>
          <h5>Strand: <span class="underline-bottom">STEM</span></h5>
        </div>
  
        <div class="d-flex justify-content-between">
          <h5>Semester/Summer 
			<span class="underline-bottom">
				2nd Semester 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          	</span>
			<span class="underline-bottom">
				2021 - 
          	</span>
			<span class="underline-bottom">
				2022 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          	</span>
		  </h5>
		  
        </div>
  
        <div class="d-flex justify-content-between">
			<h5>Address: 
				<span class="underline-bottom">Pedro Guevara Ave, Santa Cruz, Laguna</span>
			</h5>
        </div>

        <div class="d-flex justify-content-between">
          <h5>Guardian: 
			<span class="underline-bottom">Mrs. Jane Doe</span>
		  </h5>
        </div>

        <div class="d-flex justify-content-between">
          <h5>Contact No: 
			<span class="underline-bottom">09890345123</span>
		  </h5>
        </div>
  
        
      </div>


      <!-- Table -->
    <table class="basic-table" >
      <thead>
        <tr>
          <th class="text-uppercase min-w-25px">Date</th>
          <th class="text-uppercase min-w-100px">Receipt No.</th>
          <th class="text-uppercase min-w-50px">Debit</th>
          <th class="text-uppercase min-w-50px">Credit</th>
          <th class="text-uppercase min-w-100px">Balance</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td> 
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>

	<p class="mt-3">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    In consideration for my admission to the PAETE SCIENCE AND BUSINESS COLLEGE and of the privileges of students in this institution, I hereby promise and pledge to abide by and comply with rules and regulations laid down by competent authority thereof, to observe and support the system. Code of Manners Discipline as enforce, in this college.
	</p>

	<p class="mt-3">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		I hereby acknowledge that I have read the rules of the PAETE SCIENCE AND BUSINESS COLLEGE about fees and deposits. Being allowed solely for my convenience to pay my tuition fees by installment. I hereby promise to pay in full the unpaid balance for the entire semester, quarter or year, as the case may be; even if I should stop studying or transfer to another school.
	</p>

	<div class="form-wrapper">
		<div class="d-flex justify-content-between">
			<h5>Name: 
				<span class="underline-bottom">Doe, John D.</span>
			</h5>
			<h5>Age: 
				<span class="underline-bottom">20</span>
			</h5>
			<h5>Sex: 
				<span class="underline-bottom">Male</span>
			</h5>
			<h5>Religion: 
				<span class="underline-bottom">Roman Catholic</span>
			</h5>
        </div>
	</div>
	
	<div class="form-wrapper">
		<div class="d-flex justify-content-between">
			<h5>Date of Birth: 
				<span class="underline-bottom">January 25, 1999</span>
			</h5>
			<h5>Place of Birth: 
				<span class="underline-bottom">Laguna Doctors Hospital, Sta. Cruz Laguna</span>
			</h5>
        </div>

		<div class="d-flex justify-content-between">
			<h5>Parents/Guardian: 
				<span class="underline-bottom">Mrs. Jane Doe</span>
			</h5>
			<h5>Address: 
				<span class="underline-bottom">Pedro Guevara Ave, Santa Cruz, Laguna</span>
			</h5>
        </div>

		<div class="d-flex justify-content-between">
			<h5>City Address: 
				<span class="underline-bottom">Sta. Cruz Laguna</span>
			</h5>
			<h5>Provincial Address: 
				<span class="underline-bottom">Sta. Cruz Laguna</span>
			</h5>
        </div>

		<h5>Contact No:
			<span class="underline-bottom">09890345123</span>
		</h5>

		<div class="d-flex justify-content-between">
			<h5>Intermediate Grade Completed at: 
				<span class="underline-bottom">XXX-XXX-XXX</span>
			</h5>
			<h5>Year: 
				<span class="underline-bottom">2019</span>
			</h5>
        </div>

		<div class="d-flex justify-content-between">
			<h5>Junior High School which Completed: 
				<span class="underline-bottom">XXX-XXX-XXX</span>
			</h5>
			<h5>Year: 
				<span class="underline-bottom">2018</span>
			</h5>
        </div>
	</div>
	

	<div id="requirements" class="row mt-3">
		<div class="column d-flex justify-content-center">
			<p class="text-center signature-line w-50 mt-5">SHS RECORD CLERK</p>
		</div>
		<div class="column">
		  <h5 class="text-uppercase font-weight-bold">Requirements:</h2>
		  <ul class="list-style-none">
			  <li>*PSA/NSO Certified Birth Certificate.</li>
			  <li>*Grade 10 Report Card (Original)</li>
			  <li>*Certificate of Junior High School Completion (Photocopy)</li>
			  <li>*Certificate of Good Moral Character (Original)</li>
			  <li>*ESC Certification Letter from JHS Principal (ESC Grantees Only)</li>
			  <li>*QRV Certificate (Qualified Voucher Applicants Only)</li>
			  <li>*Passport Size Picture with White Background - 2pcs.</li>
			  <li>*Reservation Slip</li>
		  </ul>
		  
		</div>
	</div>

</div> <!-- End of Whole Container -->

@endsection