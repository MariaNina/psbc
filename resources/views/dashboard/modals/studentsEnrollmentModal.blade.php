<!-- Add Students Enrollment Modal-->
<div
    class="modal fade"
    id="addStudentModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                   Student Details
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
                <form id="addEnrolleeForm" role="form" data-toggle="validator">
					@csrf
					<div class="row">
						<div class="col-lg-8">
							<div class="form-group">
								<label for="school_years">Student Name</label>
								<select class="form-control js-example-basic-single" title="No selected student" id="add_student_id"
										name="student">
									<option value="" disabled selected>Select...</option>
									@foreach ($students as $row)
									<option value="{{$row->id}}" >{{$row->last_name}},{{$row->first_name}} {{$row->middle_name}} </option>
										
									@endforeach
								</select>
							</div>
						</div>
					</div>
						<div class="row">
								
							<div class="col-md-8">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="school_years">School Year</label>
											<select class="form-control" id="add_school_years" name="school_years">
												<option value="" disabled selected>Select...</option>
												@foreach ($school_years as $row)
												<option value="{{$row->id}}" @if($row->id == $school_year_id)
													{{'selected'}}
													@endif>{{$row->school_years}}</option>
													
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="std_dept">Branch</label>
											<select class="form-control" id="add_branch" name="branch">
													<option value="" disabled selected>Select...</option>
													@foreach ($branches as $row)
														<option value="{{$row->id}}">{{$row->branch_name}}</option>
													@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="std_dept">Department</label>
											<select class="form-control" id="add_student_department" name="student_department">
												<option value="" disabled selected>Select...</option>
												<option value="Elementary"> Pre Elementary / Elementary </option>
												<option value="JHS">Junior High School</option>
												<option value="SHS">Senior High School</option>
												<option value="College">College</option>
												<option value="Graduate Studies">Graduate Studies</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="curriculum">Level</label>
											<select class="form-control" id="add_student_level"
													name="student_level">
									
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="curriculum">Programs/Tracks/Strands/Majors</label>
											<select class="form-control" id="add_curriculum"
													name="curriculum">
											
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="section">Section</label>
											<select class="form-control" id="add_section"
													name="section">
												<option value="" disabled selected>Select...</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="term">Term</label>
											<select class="form-control" id="add_term"
													name="term">
													@foreach ($terms as $term)
														<option value="{{$term->id}}">{{$term->term_name}}</option>
													@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
								
									<div class="col-lg-12" id="add_subject_tbl">
									
									
									</div>
							
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<center>
										<img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y" alt="" height="100px" width="100px">
									</center>
								</div>
								<div class="form-group">
									<div id="docs">
										{{-- documents here --}}
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label for="civil_status">Remarks</label>
										<textarea class="form-control" name="remarks" id="add_remarks" rows="3"></textarea>
									</div>
								</div>
								{{-- <div class="col-lg-12">
									<div class="form-group">
										<label for="user_name"
											>User Name</label
											>
											<input
												type="text"
												class="form-control"
												id="user_name"
												name="user_name"

											/>
									</div>
								</div> --}}
							</div>
						</div>
						<button type="submit" class="btn btn-success float-right">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- View and update Students Enrollment Modal-->
<div
    class="modal fade"
    id="viewStudentModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                   Student Details
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
                <form id="myForm" role="form" data-toggle="validator">
					@csrf
					<input type="hidden" id="enrollment_id" name="enrollment_id">
					<input type="hidden" id="student_id" name="student_id">
					<input type="hidden" id="user_id" name="user_id">
					<input type="hidden" id="guardian_id" name="guardian_id">
					<input type="hidden" id="app_no_" name="app_no_">
                    <div id="smartwizard">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#step-1"> Student's Details </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#step-2"> Documents and Enrollment Details</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div
                                id="step-1"
                                class="tab-pane students-tab"
                                role="tabpanel"
                                aria-labelledby="step-1"
                            >
								<div class="row">
									<div class="col-lg-4">
										<label for="lrn"
										>Application Number</label
										>
										<input
											type="text"
											class="form-control"
											id="app_no"
											readonly
										/>
										<label for="lrn"
										>LRN <sub>(Learner's Reference Number)</sub></label
										>
										<input
											type="number"
											class="form-control"
											id="lrn"
											name="lrn"
										/>
										
										<label for="first_name"
										>First Name</label
										>
										<input
											type="text"
											class="form-control"
											id="first_name"
											name="first_name"

										/>
										<label for="middle_name"
										>Middle Name</label
										>
										<input
											type="text"
											class="form-control"
											id="middle_name"
											name="middle_name"

										/>
										<label for="last_name"
										>Last Name</label
										>
										<input
											type="text"
											class="form-control"
											id="last_name"
											name="last_name"

										/>
										<label for="suffix_name"
										>Suffix Name</label
										>
										<input
											type="text"
											class="form-control"
											id="suffix_name"
											name="suffix_name"

										/>
										
									</div>
									<div class="col-lg-4">
										<label for="email_address"
										>Email Address</label
										>
										<input
											type="email"
											class="form-control"
											id="email_address"
											name="email_address"

										/>
										<label for="contact_number"
										>Contact Number</label
										>
										<input
											type="number"
											class="form-control"
											id="contact_number"
											name="contact_number"

										/>
										<label for="address"
										>Complete Home Address</label
										>
										<input
											type="text"
											class="form-control"
											id="address"
											name="address"

										/>
										<div class="row">
											<div class="col-lg-6">
													<label for="birth_day"
													>Birthdate</label
													>
													<input
														type="date"
														class="form-control"
														id="birth_day"
														name="birth_day"

													/>
											</div>
											<div class="col-lg-6">
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
										<div class="row">
											<div class="col-lg-6">
													<label for="gender">Gender</label>
													<select class="form-control" id="gender" name="gender">
													</select>
											</div>
											<div class="col-lg-6">
													<label for="citizenship">Citizenship</label>
													<select class="form-control" id="citizenship"
															name="citizenship">
			
													</select>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
													<label for="civil_status">Civil Status</label>
													<select class="form-control" id="civil_status"
															name="civil_status">
													</select>
											</div>
											<div class="col-lg-6">
													<label for="religion">Religion</label>
													<input
														type="text"
														class="form-control"
														id="religion"
														name="religion"
			
													/>
											</div>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="row" id="other_details">
									
										</div>
										<div class="row">
											<div class="col-lg-6">
												<label for="g_first_name"
												>Guardian's First Name</label
												>
												<input
													type="text"
													class="form-control"
													id="g_first_name"
													name="g_first_name"
				
												/>
											</div>
											<div class="col-lg-6">
												<label for="g_middle_name"
												>Guardian's Middle Name</label
												>
												<input
													type="text"
													class="form-control"
													id="g_middle_name"
													name="g_middle_name"
				
												/>
											</div>
										</div>
										<label for="g_last_name"
										>Guardian's Last Name</label
										>
										<input
											type="text"
											class="form-control"
											id="g_last_name"
											name="g_last_name"
		
										/>
										<label for="g_address"
										>Guardian's Address</label
										>
										<input
											type="text"
											class="form-control"
											id="g_address"
											name="g_address"
		
										/>
										<label for="g_contact_number"
										>Guardian's Contact Number</label
										>
										<input
											type="text"
											class="form-control"
											id="g_contact_number"
											name="g_contact_number"
		
										/>
									</div>
								</div>
						
                            </div>
							<div
							id="step-2"
							class="tab-pane students-tab"
							role="tabpanel"
							aria-labelledby="step-2">

							<div class="row">
								
								<div class="col-md-8">
									<div class="row">
										<div class="col-lg-4">
											<div class="form-group">
												<label for="school_years">School Year</label>
												<select class="form-control" id="school_years"
														name="school_years">
													<option value="" disabled selected>Select...</option>
												</select>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="std_dept">Branch</label>
												<select class="form-control" id="branch"
														name="branch">
													
												</select>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="std_dept">Department</label>
												<select class="form-control" id="student_department" name="student_department">
													<option value="" disabled selected>Select...</option>
												</select>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="std_dept">Student Type</label>
												<select class="form-control" id="student_type"
														name="student_type">
												</select>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="curriculum">Level</label>
												<select class="form-control" id="student_level"
														name="student_level">
										
												</select>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="curriculum">Programs/Tracks/Strands/Majors</label>
												<select class="form-control" id="curriculum"
														name="curriculum">
												
												</select>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="section">Section</label>
												<select class="form-control" id="section"
														name="section">
													<option value="" disabled selected>Select...</option>
												</select>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="term">Term</label>
												<select class="form-control" id="term"
														name="term">
														<option value="" disabled selected>Select...</option>
													
												</select>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="status">Status</label>
												<select class="form-control" id="status"
														name="status">
													<option value="" disabled selected>Select...</option>
													
												</select>
											</div>
										</div>
									</div>
									<div class="row">
									
										<div class="col-lg-12" id="subject_tbl">
										
										
										</div>
									
										{{-- <div class="col-md-12">
											<div class="form-group">
												<label for="civil_status">Remarks</label>
												<textarea class="form-control" name="" id="" rows="3"></textarea>
											</div>
										</div> --}}
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<center>
											<img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y" alt="" height="100px" width="100px">
										</center>
									</div>
									<div class="form-group">
										<div id="view_docs">
											{{-- documents here --}}
										</div>
									</div>
									<div class="col-lg-12">
										<div class="form-group">
											<label for="civil_status">Remarks</label>
											<textarea class="form-control" name="remarks" id="" rows="3"></textarea>
										</div>
									</div>
									{{-- <div class="col-lg-12">
										<div class="form-group">
											<label for="user_name"
												>User Name</label
												>
												<input
													type="text"
													class="form-control"
													id="user_name"
													name="user_name"

												/>
										</div>
									</div> --}}
								</div>
							</div>
				
						</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


