<!-- Add Subject Modal-->
<div
    class="modal fade"
    id="addSubjectModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Subject
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
                <form id="SubjectForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="subject_code">Subject Code</label>
								<input type="text" required name="subject_code" id="subject_code" class="form-control subject_code"  placeholder="eg. PHED111, GEC103" />
							  </div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="subject_name">Subject Name</label>
								<input type="text" required name="subject_name" id="subject_name" class="form-control"  placeholder="eg. Calculus, ICT" />
						  </div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="subject_type">Type</label>
								<select
									class="form-control required"
									id="subject_type"
									name="subject_type"
									title="No selected type...">
									<option value="" selected disabled>
										Select ..
									</option>
									<option value="Acad">
										Academic
									</option>
									<option value="Non-acad">
										Non-Academic
									</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="form-label" for="subject_image">Add Image</label>
						<input type="file" class="form-control-file" id="subject_image" name="subject_image" value="">
						<small class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>
					</div>

                    <div class="form-group">
                        <label for="subject_desc">Subject Description</label>
                        <textarea class="form-control form-control-textarea" name="subject_desc" id="subject_desc" placeholder="eg. This is subject description..."></textarea>
                    </div>

                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="lect_units">Lec Units Number</label>
								<input type="number" id="lect_units" required name="lect_units" class="form-control" min="0" placeholder="eg. 3">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="lab_units">Lab Units Number</label>
								<input type="number" id="lab_units" required name="lab_units" class="form-control" min="0" placeholder="eg. 3">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="subject_type">For College?</label>
								<select
									class="form-control required"
									id="is_for_college"
									name="is_for_college"
									title="No selected type...">
									<option value="1">
										Yes
									</option>
									<option value="0">
										No
									</option>
								</select>
							</div>
						</div>
					</div>
{{-- 
					<div class="d-flex justify-content-around mb-3">
						  <div class="form-check">
							<input class="form-check-input" type="radio" name="is_for_college" id="is_for_college" value="1">
							<label class="form-check-label" for="is_for_college">
							  For college
							</label>
						  </div>
					</div> --}}
					

                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

{{--EDIT SUBJECT MODAL--}}

<div
    class="modal fade"
    id="editSubjectModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Subject
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
                <form id="editSubjectForm"  role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="subject_code">Subject Code</label>
								<input type="text" required name="subject_code" id="edit_subject_code" class="form-control subject_code"  placeholder="eg. PHED111, GEC103" />
							  </div>
						</div>
						<div class="col-md-6">
						<div class="form-group">
							<label for="subject_name">Subject Name</label>
							<input type="text" required name="subject_name" id="edit_subject_name" class="form-control"  placeholder="eg. Calculus, ICT" />
						  </div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="subject_type">Type</label>
								<select
									class="form-control required"
									id="edit_subject_type"
									name="subject_type"
									title="No selected type...">
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="form-label" for="subject_image">Add Image</label>
						<input type="file" class="form-control-file" id="edit_subject_image" name="subject_image">
						<small class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>
					</div>

                    <div class="form-group">
                        <label for="subject_desc">Subject Description</label>
                        <textarea class="form-control form-control-textarea" name="subject_desc" id="edit_subject_desc" placeholder="eg. This is subject description..."></textarea>
                    </div>

                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="lect_units">Lec Units Number</label>
								<input type="number" id="edit_lect_units" required name="lect_units" class="form-control" min="0" placeholder="eg. 3">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="lab_units">Lab Units Number</label>
								<input type="number" id="edit_lab_units" required name="lab_units" class="form-control" min="0" placeholder="eg. 3">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="subject_type">For College?</label>
								<select
									class="form-control required"
									id="edit_is_for_college"
									name="is_for_college"
									title="No selected type...">
								</select>
							</div>
						</div>
					</div>

					{{-- <div class="d-flex justify-content-around mb-3">
						  <div class="form-check">
							<input class="form-check-input" type="checkbox" name="is_for_college" id="edit_is_for_college" value="0">
							<label class="form-check-label" for="edit_is_for_college">
							  For college
							</label>
						  </div>
					</div> --}}

                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
