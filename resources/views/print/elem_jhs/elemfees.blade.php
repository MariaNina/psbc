@extends('print.main')

@section('title')
    Elementary Form
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

  <ul class="list-style-none rules-list line-h">
    <li class="mb-3">
     <span>1.</span>
     Entrance fees are payable in cash and not refundable. Tuition fees are payable in cash. Fees are on a semestral or quarterly basis in the Collegiate and on a yearly basis in the High School and Elementary Deperments Payments by installment may be allowed for the convenience of a student. If a student stops, studying or transfers to another school, he/she shall be liable to pay the full unpaid balance for the entire semester/summer or year, as the case may be.
    </li>
    <li>
      <span>2.</span> 
      When tuition and other fees are paid in full for a semester or a year or for a length of not longer than one month such fees may be refunded to a students who widthraws within the first 30 days from the date of his/her registration, under the following conditions:

      <ul class="list-style-none ml-3" id="sub-rules">
        <li>
          a.
          5% discount on full cash payments at time registration
        </li>
        <li>
          b.
          80% of the amount paid for the tuition fee if he/she withdraws during the first week after registration, whether, he/she attended classes or not
        </li>
        <li>
          c.
          50% within the second week, 30^ for the third week and 20% for the fourth week.
        </li>
        <li>
          d.
          No refund will be made 30days after registration
        </li>
        <li>
          e.
          A charge of 5% of the amount due shall be imposed for every month of delay
        </li>
        <li>
          f.
          Dropping of course 30 days after the date of enrollment
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

<div class="container my-5">
  <div class="form-wrapper mb-1">
    <div class="d-flex justify-content-between mb-3">
      <h5>Student's Name: 
        <span id="student-name" class="underline-bottom">

         <span id="family-name" class="family-name">
          Miras 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;         
         </span>

         <small class="family-name-hint">(Family Name)</small>


         <span id="first-name" class="first-name">
          Robert 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         </span>

          <small class="first-name-hint">(First Name)</small>

         <span id="middle-initial" class="middle-initial">
          B. 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
         </span>
         <small class="middle-initial-hint">(M.I)</small>

        </span>
      </h5>
      <h5>School Year: <span class="underline-bottom">2021-2022</span></h5>
    </div>

    <div class="d-flex justify-content-between">
      <h5>Civil Status: <span class="underline-bottom">Single
      </span></h5>
      <h5>Nationaility: <span class="underline-bottom">Filipino</span></h5>
    </div>

    <div class="d-flex justify-content-between">
      <h5>Contact Number: <span class="underline-bottom">09542289123</span></h5>
      <h5>Grade/Yr & Sec: <span class="underline-bottom">1st Year - Section A</span></h5>
    </div>

    <div class="d-flex justify-content-between">
      <h5>Provincial Address: <span class="underline-bottom">Pedro Guevara Ave, Santa Cruz, Laguna</span></h5>
      <h5>Parents/Guardians: <span class="underline-bottom">Mrs. Jane Doe</span></h5>
    </div>
  </div>


  <!-- Table -->
<table class="basic-table" >
  <thead>
    <tr>
      <th class="text-uppercase min-w-25px"></th>
      <th class="text-uppercase min-w-100px">Misc Fee</th>
      <th class="text-uppercase min-w-100px">Tuition Fee</th>
      <th class="text-uppercase min-w-100px">Books</th>
      <th class="text-uppercase min-w-100px">Others</th>
      <th class="text-uppercase min-w-100px">Receipt #</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Jun</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Jul</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Aug</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Sept</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Oct</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td> 
      <td></td>
    </tr>
    <tr>
      <td>Nov</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Dec</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Jan</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Feb</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Mar</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>
</div>
    
@endsection
