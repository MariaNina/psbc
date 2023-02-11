@extends('landing.layouts.app')

@section('title')
    PSBC - Online Enrollment
@endsection

@section('content')
<style>
    .swal2-title {
        color: #595959 !important;
    }
    a.active {
        color: #fff !important;
    }
</style>
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

    <!-- ABOUT SECTION -->
    <section id="about" class="py-3">
        <div class="container">
            <div class="row">
                <div class="card mx-auto">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <strong>Application Form</strong>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                    <input id="serach_box" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                    <button id="search_application_button" class="btn btn-outline-success my-2 my-sm-0" type="button">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="registrationForm" role="form" data-toggle="validator">
                        @csrf
                        <div id="smartwizard">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-1"> Application Type </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-2"> Enrollment Info </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-3"> Student's Personal Info </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-4"> Guardian's Info </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-5"> Documents</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-6"> </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                {{-- Step 1 --}}
                                <div
                                id="step-1"
                                class="tab-pane registrationForm-tab"
                                role="tabpanel"
                                aria-labelledby="step-2">
                                <div class="container m-auto p-5">
                                    <div class="row">
                                        <div class="col col-lg-6 col-sm-12 mt-2">
                                            <a href="{{ route('login') }}" class="btn btn-orange btn-block">Old Student</a>
                                        </div>
                                        <div class="col col-lg-6 col-sm-12 mt-2">
                                            <button id="newEnrollee" class="btn btn-orange sw-btn-next btn-block">New Enrollee</button>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                {{-- Step 2 --}}
                                <div id="step-2" class="tab-pane registrationForm-tab" role="tabpanel"   aria-labelledby="step-2">
                                    {{-- school year --}}
                                    <div class="form-group">
                                        <label for="school_year">School Year: </label>
                                        {{$school_year}}
                                    </div>
                                    {{-- School Branch --}}
                                    <div class="form-group">
                                        <label for="school_branch">School Branch</label>
                                        <select class="form-control" id="school_branch" name="school_branch">
                                            <option value="" disabled selected>Select...</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    {{-- Department --}}
                                    <div class="form-group">
                                        <label for="student_department">Department</label>
                                        <select class="form-control" id="student_department" name="student_department">
                                            <option value="" disabled selected>Select...</option>
                                            <option value="Elementary"> Pre Elementary / Elementary </option>
                                            <option value="JHS">Junior High School</option>
                                            <option value="SHS">Senior High School</option>
                                            <option value="College">College</option>
                                            <option value="Graduate Studies">Graduate Studies</option>
                                        </select>
                                    </div>
                                    {{-- Student Type and Level --}}
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="student_type">Student Type</label>
                                                    <select class="form-control" id="student_type"
                                                            name="student_type">
                                                        <option value="" disabled selected>Select...</option>
                                                        <option value="New">New</option>
                                                        <option value="Transferee">Transferee</option>
                                                        <option value="Cross Enrollee">Cross Enrollee</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="student_level">Student Level</label>
                                                    <select class="form-control selectpicker" id="student_level"
                                                            name="student_level" data-live-search="true">
                                                        <option value="" disabled selected>Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="grad_programs"
                                            >Programs/Tracks/Strands/Majors</label
                                            >
                                            <select
                                                class="form-control selectpicker" id="curriculum" name="curriculum"
                                                data-live-search="true">
                                                <option value="" disabled selected>Select...</option>
                                            </select>
                                        </div>
                                        {{-- Div for Graduate Studies --}}
                                        <div>

                                            <div class="form-group" id="for_gradstuds">

                                                <label for="under_grad_program_taken"
                                                >Under Graduate Program/Course Taken</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="under_grad_program_taken"
                                                    name="under_grad_program_taken"

                                                />
                                            </div>
                                            {{-- Div for college --}}
                                            <div class="form-group" id="for_college">

                                                <label for="college_shs_track"
                                                >Are You a SHS Graduate? <sub>(If Yes Select Strand or Tracks. If No
                                                        Select N/A)</sub></label
                                                >
                                                <select
                                                    class="form-control selectpicker" id="college_shs_track"
                                                    name="college_shs_track" data-live-search="true">
                                                    <option value="" disabled selected>Select...</option>
                                                    <option value="ABM">ABM</option>
                                                    <option value="STEM">STEM</option>
                                                    <option value="HUMSS">HUMSS</option>
                                                    <option value="TVL">TVL</option>
                                                    <option value="N/A">N/A</option>
                                                
                                                </select>
                                                {{-- <input
                                                    type="text"
                                                    class="form-control"
                                                    id="college_shs_track"
                                                    name="college_shs_track"
                                                    placeholder="e.g. STEM, HUMSS, ABM, TVL-ICT etc. "
                                                /> --}}
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="last_school_attended"
                                            >Last School Attended - (Public or Private) <sup style='color:red'>if applicable</sup></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="last_school_attended"
                                                name="last_school_attended"
                                                placeholder="e.g. School Name - (Private)"

                                            />

                                        </div>
                                        <div class="form-group">
                                            <label for="courseTitle"
                                            >Year Graduated <sup style='color:red'>if applicable</sup></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="year_graduated"
                                                name="year_graduated"
                                                placeholder="e.g. 2020 , 2021"
                                                onkeypress="return isNumber(event)"
                                            />

                                        </div>
                                    </div>
                                    {{-- Student's Information --}}
                                    <div
                                        id="step-3"
                                        class="tab-pane registrationForm-tab"
                                        role="tabpanel"
                                        aria-labelledby="step-3">

                                        <div class="form-group">
                                            <label for="lrn"
                                            >LRN <sub>(Learner's Reference Number)</sub></label
                                            >
                                            <input
                                                type="number"
                                                class="form-control"
                                                id="lrn"
                                                name="lrn"
                                                onkeypress="return isNumber(event)"
                                            />
                                        </div>
                                        <div class="form-group">
                                            <label for="first_name"
                                            >First Name</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="first_name"
                                                name="first_name"

                                            />

                                        </div>
                                        <div class="form-group">
                                            <label for="middle_name"
                                            >Middle Name</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="middle_name"
                                                name="middle_name"
                                                value=""
                                            />

                                        </div>
                                        <div class="form-group">
                                            <label for="last_name"
                                            >Last Name</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="last_name"
                                                name="last_name"

                                            />

                                        </div>
                                        <div class="form-group">
                                            <label for="suffix_name"
                                            >Suffix Name</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="suffix_name"
                                                name="suffix_name"
                                                value=""
                                            />

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select class="form-control" id="gender" name="gender">
                                                        <option value="" disabled selected>Select...</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Male">Male</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="citizenship">Citizenship</label>
                                                    <select class="form-control" id="citizenship"
                                                            name="citizenship">
                                                        <option value="" disabled selected>Select...</option>
                                                        <option value="Filipino">Filipino</option>
                                                        <option value="American">American</option>
                                                        <option value="Japanese">Japanese</option>
                                                        <option value="Korean">Korean</option>
                                                        <option value="Chinese">Chinese</option>
                                                        <option value="Others">Others</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="civil_status">Civil Status</label>
                                                    <select class="form-control" id="civil_status"
                                                            name="civil_status">
                                                        <option value="" disabled selected>Select...</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Separated">Separated</option>
                                                        <option value="Divorced">Divorced</option>
                                                        <option value="Widowed">Widowed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="religion">Religion</label>
                                                    <select class="form-control" id="religion"
                                                            name="religion">
                                                        <option value="" disabled selected>Select...</option>
                                                        <option value="Catholic">Roman Catholic</option>
                                                        <option value="Protestant">Protestant</option>
                                                        <option value="INC">INC</option>
                                                        <option value="Islam">Islam</option>
                                                        <option value="Christian">Christian</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email_address"
                                            >Email Address</label
                                            >
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="email_address"
                                                name="email_address"

                                            />

                                        </div>
                                        <div class="form-group">
                                            <label for="contact_number"
                                            >Contact Number</label
                                            >
                                            <input
                                                type="number"
                                                class="form-control"
                                                id="contact_number"
                                                name="contact_number"
                                                pattern=".{11,}"
                                                onkeypress="return isNumber(event)"
                                            />

                                        </div>
                                        <div class="form-group">
                                            <label for="address"
                                            >Complete Home Address</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="address"
                                                name="address"

                                            />

                                        </div>
                                        <div class="form-group">
                                            <label for="birth_day"
                                            >Birthdate</label
                                            >
                                            <input
                                                type="date"
                                                class="form-control"
                                                id="birth_day"
                                                name="birth_day"
                                                max="2019-12-31"
                                            />

                                        </div>
                                        <div class="form-group">
                                            <label for="birth_place"
                                            >Birth Place</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="birth_place"
                                                name="birth_place"

                                            />

                                        </div>

                                    </div>
                                    {{-- Guardian's Information --}}
                                    <div
                                        id="step-4"
                                        class="tab-pane registrationForm-tab"
                                        role="tabpanel"
                                        aria-labelledby="step-4">

                                        <div class="form-group">
                                            <label for="guardian_first_name"
                                            >Guardian's First Name</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="guardian_first_name"
                                                name="guardian_first_name"

                                            />

                                        </div>
                                        <div class="form-group">
                                            <label for="guardian_middle_name"
                                            >Guardian's Middle Name</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="guardian_middle_name"
                                                name="guardian_middle_name"

                                            />

                                        </div>
                                        <div class="form-group">
                                            <label for="guardian_last_name"
                                            >Guardian's Last Name</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="guardian_last_name"
                                                name="guardian_last_name"

                                            />

                                        </div>

                                        <div class="form-group">
                                            <label for="guardian_address">Guardian's Address</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="guardian_address"
                                                name="guardian_address"
                                            />

                                        </div>

                                        <div class="form-group">
                                            <label for="guardian_contact_number">Guardian's Contact Number</label>
                                            <input
                                                type="number"
                                                min="1"
                                                class="form-control"
                                                id="guardian_contact_number"
                                                name="guardian_contact_number"
                                                onkeypress="return isNumber(event)"
                                            />

                                        </div>

                                    </div>
                                    {{-- Documents --}}
                                    <div
                                    id="step-5"
                                    class="tab-pane registrationForm-tab"
                                    role="tabpanel"
                                    aria-labelledby="step-5">
                                    <div class="form-group">
                                        <label for="image">Image <sup style="color:red">(jpg, jpeg, png)</sup></label>
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="image"
                                            name="image"
                                            accept="image/jpeg,image/png"
                                            onchange="validateImage(this)"
                                        />

                                    </div>
                                    <div id="documents">
                                      

                                    </div>
                                    </div>
                                    {{-- Data Privacy --}}
                                    <div
                                    id="step-6"
                                    class="tab-pane registrationForm-tab"
                                    role="tabpanel"
                                    aria-labelledby="step-6">
                                    <fieldset class="border p-2">
                                        <legend class="w-auto">Data Privacy</legend>
                                                <p>In submitting this form I agree to my details being used for the purposes of [insert reason for data collection e.g. administering/managing the conference]. The information will only be accessed by necessary university staff. I understand my data will be held securely and will not be distributed to third parties. I have a right to change or access my information. I understand that when this information is no longer required for this purpose, official university procedure will be followed to dispose of my data.</p>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
                                                <label class="form-check-label" for="exampleCheck1">I Agree</label>
                                            </div>
                                    </fieldset>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- </div>
        </div> --}}
    </section>

@endsection
@section('extra-js')

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
        integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>

    <script type="text/javascript" src="{{ asset('js/multi-step/onlineEnrollment.js') }}"></script>
<script>
     function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function validateImage(input) {

        const fileSize = input.files[0].size / 1024 / 1024; // in MiB
        var fileName, fileExtension;
            fileName = $(input).val();

            if (fileSize > 2) {
                Swal.fire({
                    title: "Invalid File Size",
                    text: "File size exceeds 2 MiB",
                    icon: "error",
                    showCloseButton: true,
                    confirmButtonColor: "#3085d6",
                    closeButtonColor: "#d33",
                })
                $(input).val(''); //for clearing with Jquery

            } else {

                var validExtensions = ["jpg", "jpeg", "png", "jfif", "pjpeg", "gif", "pjp"]; //array of valid extensions
                fileExtension = fileName.replace(/^.*\./, '');
                fileExtension = fileExtension.toLowerCase();

                if ($.inArray(fileExtension, validExtensions) === -1){
                    Swal.fire({
                        title: "Invalid File Type",
                        text: 'File must be "jpg", "jpeg", "png"',
                        icon: "error",
                        showCloseButton: true,
                        confirmButtonColor: "#3085d6",
                        closeButtonColor: "#d33",
                    })
                    $(input).val('');
                }else{
                return true;
                }
        }
    }

    function validateFile(input) {

        const fileSize = input.files[0].size / 1024 / 1024; // in MiB
        var fileName, fileExtension;
            fileName = $(input).val();

            if (fileSize > 5) {
                Swal.fire({
                    title: "Invalid File Size",
                    text: "File size exceeds 5 MB",
                    icon: "error",
                    showCloseButton: true,
                    confirmButtonColor: "#3085d6",
                    closeButtonColor: "#d33",
                })
                $(input).val(''); //for clearing with Jquery

            } else {

                var validExtensions = ["jpg", "jpeg", "png", "jfif", "pjpeg", "gif", "pjp", "pdf"]; //array of valid extensions
                fileExtension = fileName.replace(/^.*\./, '');
                fileExtension = fileExtension.toLowerCase();

                if ($.inArray(fileExtension, validExtensions) === -1){
                    Swal.fire({
                        title: "Invalid File Type",
                        text: 'File must be "jpg", "jpeg", "png", "pdf',
                        icon: "error",
                        showCloseButton: true,
                        confirmButtonColor: "#3085d6",
                        closeButtonColor: "#d33",
                    })
                    $(input).val('');
                }else{
                   return true;
                }
        }
    }
   
</script>
@endsection
