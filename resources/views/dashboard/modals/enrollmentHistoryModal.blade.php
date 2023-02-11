<div
    class="modal fade"
    id="addModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                  New Enrollment
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
                <form id="addEnrollment" role="form" data-toggle="validator">
					@csrf
                    <div class="row">
								<input type="hidden" name="branch" id="add_branch" value="{{$user->branch_id}}">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="school_years">School Year</label>
                                        <input type="hidden" class="form-control" value="{{ $school_year_id }}" name="school_years" id="school_years">
                                       
                                        <input type="text" class="form-control" value=" {{$school_year}}" name="" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="std_dept">Department</label>
                                        <select class="form-control" id="add_student_department" name="student_department" required>
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
                                                name="student_level" required>
                                
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="curriculum">Programs/Tracks/Strands/Majors</label>
                                        <select class="form-control" id="add_curriculum"
                                                name="curriculum" required>
                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="term">Term</label>
                                        <select class="form-control" id="add_term"
                                                name="term" required>
                                                <option value="" disabled selected>Select...</option>
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
                    </div>
                    <button type="submit" class="btn btn-success float-right">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>


