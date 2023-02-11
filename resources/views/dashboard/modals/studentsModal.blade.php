{{-- Add Students Modal --}}
<div
    class="modal fade"
    id="addStudentsModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Student
                </h5>
                <button
                    class="close"
                    type="button"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" enctype="multipart/form-data">
					@csrf
                       <div class="row">
						<div class="col col-lg-6">
								<label for="school_branch"
								>Branch</label
								>
								<select class="form-control" name="school_branch">
									<option value="" disabled selected>Select...</option>
									@foreach($branches as $branch)
										<option value="{{$branch->id}}">{{$branch->branch_name}}</option>
									@endforeach
								</select>
								<label for="lrn"
								>LRN</label
								>
								<input
									type="text"
									class="form-control"
									name="lrn"

								/>
								<label for="first_name"
								>First Name</label
								>
								<input
									type="text"
									class="form-control"
									name="first_name"

								/>
								<label for="last_name"
								>Last Name</label
								>
								<input
									type="text"
									class="form-control"
									name="last_name"

								/>
							<div class="row">
								<div class="col col-lg-6">
										<label for="middle_name"
										>Middle Name</label
										>
										<input
											type="text"
											class="form-control"
											name="middle_name"

										/>
								</div>
								<div class="col col-lg-6">
										<label for="suffix_name"
										>Suffix Name</label
										>
										<input
											type="text"
											class="form-control"
											name="suffix_name"

										/>
								</div>
							</div>
							<div class="row">
								<div class="col col-lg-6">
										<label for="gender"
										>Gender</label
										>
										<select class="form-control" name="gender">
											<option value="" disabled selected>Select...</option>
											<option value="Female">Female</option>
											<option value="Male">Male</option>
										</select>
								</div>
								<div class="col col-lg-6">
										<label for="birthday"
										>Birthday</label
										>
										<input
											type="date"
											class="form-control"
											name="birth_day"
											max="2019-12-31"
										/>
								</div>
							</div>
							<div class="row">
								<div class="col col-lg-6">
									<label for="email_address"
									>Email</label
									>
									<input
										type="email"
										class="form-control"
										name="email_address"

									/>
								</div>
								<div class="col col-lg-6">
									<label for="contact_no"
									>Contact Number</label
									>
									<input
										type="number"
										class="form-control"
										name="contact_no"
										onkeypress="return isNumber(event)"

									/>
								</div>
							</div>
								<label for="address"
								>Address</label
								>
								<input
									type="text"
									class="form-control"
									name="address"

								/>
							
						   </div>
						   {{-- Guardian's Info --}}
						   <div class="col col-lg-6">
							<label for="citizenship">Citizenship</label>
							<select class="form-control"
									name="citizenship">
								<option value="" disabled selected>Select...</option>
								<option value="Filipino">Filipino</option>
								<option value="American">American</option>
								<option value="Japanese">Japanese</option>
								<option value="Korean">Korean</option>
								<option value="Chinese">Chinese</option>
								<option value="Others">Others</option>

							</select>
							<label for="civil_status">Civil Status</label>
								<select class="form-control"
										name="civil_status">
									<option value="" disabled selected>Select...</option>
									<option value="Single">Single</option>
									<option value="Married">Married</option>
									<option value="Separated">Separated</option>
									<option value="Divorced">Divorced</option>
									<option value="Widowed">Widowed</option>
								</select>
							<label for="religion">Religion</label>
									<select class="form-control" name="religion">
									<option value="" disabled selected>Select...</option>
									<option value="Catholic">Roman Catholic</option>
									<option value="Protestant">Protestant</option>
									<option value="INC">INC</option>
									<option value="Islam">Islam</option>
									<option value="Christian">Christian</option>
									<option value="Others">Others</option>
								</select>
								<label for="g_first_name"
								>Guardian's First Name</label
								>
								<input
									type="text"
									class="form-control"
									name="g_first_name"

								/>
								<label for="g_last_name"
								>Guardian's Last Name</label
								>
								<input
									type="text"
									class="form-control"
									name="g_last_name"

								/>
								<label for="g_middle_name"
								>Guardian's Middle Name</label
								>
								<input
									type="text"
									class="form-control"
									name="g_middle_name"

								/>
								<label for="g_address"
								>Guardian's Address</label
								>
								<input
									type="text"
									class="form-control"
									name="g_address"

								/>
								<label for="g_contact_number"
								>Guardian's Contact Number</label
								>
								<input
									type="text"
									class="form-control"
									name="g_contact_number"
									onkeypress="return isNumber(event)"

								/>
						   </div>
					   </div>
					   <button type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>


{{-- Add Multiple Students Modal --}}
<div
    class="modal fade"
    id="addMultipleStudentsModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add Multiple Students
                </h5>
                <button
                    class="close"
                    type="button"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
             
				<form method="post" id="import_excel_form" enctype="multipart/form-data">
					@csrf
					<div class="col col-lg-12">
						<a href="{{ asset('template/PSBC_STUDENTS_TEMPLATE.xlsx') }}">Click to Download Empty Template</a>
					</div>
					<hr>
					<div class="col col-lg-12">
						<input type="file" name="import_excel" class="form-control-file"/>
					</div>
						<input type="submit" id="import"  class="btn btn-success float-right" value="Import" />
				
				  </form>
            </div>
        </div>
    </div>
</div>

{{-- update modal --}}

<div
    class="modal fade"
    id="updateStudentModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>


    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Student Details
                </h5>
                <button
                    class="close"
                    type="button"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">×</span>
                </button>
            </div>
			<div class="modal-body">
                <form id="updateForm" enctype="multipart/form-data">
					@csrf
					<input type="hidden" id="user_id" name="user_id" value="">
					<input type="hidden" id="guardian_id" name="guardian_id" value="">
                       <div class="row">
						<div class="col col-lg-6">
							<img src="" id="profile_pic" width="200" height="200" />
							<div class="form-group">
								<label class="form-label" for="studentImage">Add Picture</label>
								<input type="file" class="form-control-file" id="studentImage" name="studentImage" value="">
								<small class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>
							</div>
								<label for="school_branch"
								>Branch</label
								>
								<select class="form-control" id="school_branch" name="school_branch">
									<option value="" disabled selected>Select...</option>
								</select>
								<label for="lrn"
								>LRN</label
								>
								<input
									type="text"
									class="form-control"
									name="lrn"
									id="lrn"

								/>
								<label for="first_name"
								>First Name</label
								>
								<input
									type="text"
									class="form-control"
									name="first_name"
									id="first_name"

								/>
								<label for="last_name"
								>Last Name</label
								>
								<input
									type="text"
									class="form-control"
									name="last_name"
									id="last_name"

								/>
							<div class="row">
								<div class="col col-lg-6">
										<label for="middle_name"
										>Middle Name</label
										>
										<input
											type="text"
											class="form-control"
											name="middle_name"
											id="middle_name"

										/>
								</div>
								<div class="col col-lg-6">
										<label for="suffix_name"
										>Suffix Name</label
										>
										<input
											type="text"
											class="form-control"
											name="suffix_name"
											id="suffix_name"

										/>
								</div>
							</div>
							<div class="row">
								<div class="col col-lg-6">
										<label for="gender"
										>Gender</label
										>
										<select class="form-control" name="gender" id="gender">
										</select>
								</div>
								<div class="col col-lg-6">
										<label for="birthday"
										>Birthday</label
										>
										<input
											type="date"
											class="form-control"
											name="birth_day"
											id="birth_day"
										/>
								</div>
							</div>
							<div class="row">
								<div class="col col-lg-6">
									<label for="email_address"
									>Email</label
									>
									<input
										type="email"
										class="form-control"
										name="email_address"
										id="email_address"

									/>
								</div>
								<div class="col col-lg-6">
									<label for="contact_no"
									>Contact Number</label
									>
									<input
										type="number"
										class="form-control"
										name="contact_no"
										id="contact_no"
										onkeypress="return isNumber(event)"

									/>
								</div>
							</div>
								<label for="address"
								>Address</label
								>
								<input
									type="text"
									class="form-control"
									name="address"
									id="address"

								/>
							
						   </div>
						   {{-- Guardian's Info --}}
						   <div class="col col-lg-6">
							<label for="citizenship">Citizenship</label>
							<select class="form-control" id="citizenship"
									name="citizenship">
								<option value="" disabled selected>Select...</option>
							</select>
							<label for="civil_status">Civil Status</label>
								<select class="form-control" id="civil_status"
										name="civil_status">
									<option value="" disabled selected>Select...</option>
								</select>
							<label for="religion">Religion</label>
								<select class="form-control" id="religion" name="religion">
								</select>
								<label for="g_first_name"
								>Guardian's First Name</label
								>
								<input
									type="text"
									class="form-control"
									name="g_first_name"
									id="g_first_name"

								/>
								<label for="g_last_name"
								>Guardian's Last Name</label
								>
								<input
									type="text"
									class="form-control"
									name="g_last_name"
									id="g_last_name"

								/>
								<label for="g_middle_name"
								>Guardian's Middle Name</label
								>
								<input
									type="text"
									class="form-control"
									name="g_middle_name"
									id="g_middle_name"

								/>
								<label for="g_address"
								>Guardian's Address</label
								>
								<input
									type="text"
									class="form-control"
									name="g_address"
									id="g_address"

								/>
								<label for="g_contact_number"
								>Guardian's Contact Number</label
								>
								<input
									type="text"
									class="form-control"
									name="g_contact_number"
									id="g_contact_number"
									onkeypress="return isNumber(event)"

								/>
						   </div>
					   </div>
					   <button type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
