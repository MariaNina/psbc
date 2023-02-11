@extends('dashboard.layouts.main')

@section('title')
    Scanner
@endsection

@section('content') 
<div class="row p-0 m-0">
  <div class="col-lg-12" style="background-color: yellow">
<div class="text-center mt-0">
    <h6 class="p-1 mt-0">QR CODE SMART ID CARD AND THE FAST TRACK OF THE STUDENTS AND FACULTY IN PAETE SCIENCE AND BUSINESS COLLEGE INC.</h6>
</div>
  </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <input type="text" class="form-control" id="infobar" style="border:0px; background-color:transparent " />
        {{-- <video class="col-sm-12" id="preview"></video> --}}
        <div id="reader" class="col-sm-12" style="height: 300px;"></div>

    </div>
    <div class="col-lg-6 ">
        <div class="=row">
            <div class="col-sm-12 text-center">
                <img src="https://st.depositphotos.com/2101611/3925/v/600/depositphotos_39258143-stock-illustration-businessman-avatar-profile-picture.jpg" alt="" width="300" height="310" id="avatar">
                </div>
            <div class="col-sm-12 text-center">
            <h4 for="fname">Name:<span id="fname"></span></h4>
            </div>
            <div class="col-sm-12 text-center">
                <h4 id="se" for="lrn">LRN:<span id="lrn"></span></h4>
            </div>
            <div class="col-sm-12 text-center">
              <h4 id="se" for="dep">Department:<span id="dep"></span></h4>
          </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-12">
      
      <!-- DataTales Example -->
      <div class="card shadow mb-4 text-center">
        <div class="card-header py-3 justify-content-center">
          
            <h6 class="m-0 text-center font-weight-bold text-primary">PSBC Attendance Record</h6>

        </div>
        <div class="card-body p-0 m-0">
          <div class="table-responsive">
            <table class="table cust-datatable mt-0" id="filtertable" width="100%" cellspacing="0">
                          <thead>
                              <tr>
                                  <th>Name</th>
                                  <th>LRN</th>
                                  <th>Department</th>
                                    <th>Date/Time</th>
                                    <th>Status</th>
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

<script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
<script src="{{ asset('js/scanner.js') }}"></script>
<script src="{{ asset('js/datatable-scripts/logged.js') }}"></script>
@endsection