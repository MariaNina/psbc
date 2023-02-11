<!-- Add Section Modal-->
<div
    class="modal fade"
    id="addSectionModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Section
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
                <form id="SectionForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="schoolYear">School Year</label>
                                <select name="schoolYear" id="schoolYear" class="form-control js-example-basic-single" title="No selected year">
                                    @foreach ($school_years as $school_year)
                                        <option value=" {{$school_year->id}}">{{$school_year->school_years}}</option>
                                    @endforeach
                                </select>
                              </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="level">Grade Level</label>
                                <select name="level" id="level" class="form-control js-example-basic-single" title="No selected level">
                                    @foreach ($levels as $level)
                                        <option value=" {{$level->id}}">{{$level->level_name}}</option>
                                    @endforeach
                                </select>
                              </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
						<label for="branch">Select Branch</label>
						<select style="width: 100%; padding:5px; font-size:28px;" name="branch" id="branch" class="js-example-basic-single form-control">
                            <option></option>
                            @foreach ($branches as $branch)
                                <option value=" {{$branch->id}}">{{$branch->branch_name}}</option>
                            @endforeach
                        </select>
					  </div>

                    <div class="form-group">
						<label for="adviser">Assign Adviser</label>
						<select name="adviser" id="adviser" class="js-example-basic-single">
                            <option value=""></option>
                            @foreach ($staffs as $staff)
                                <option value=" {{$staff->id}}">{{$staff->last_name}} {{$staff->first_name}}</option>
                            @endforeach 
                        </select>
					</div>

                    <div class="form-group">
                        <label for="sectionLabel">Section Name</label>
                        <input type="text" required name="sectionLabel" id="sectionLabel" class="form-control"  placeholder="eg. Galatians, Revelation" />
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>


{{--EDIT SECTION MODAL--}}
<div
    class="modal fade"
    id="editSectionModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Section
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
                <form id="editSectionForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="editSy">School Year</label>
						<select name="editSy" id="editSy" class="form-control js-example-basic-single">
                            <option value=""></option>
                            @foreach ($school_years as $school_year)
                                <option value=" {{$school_year->id}}">{{$school_year->school_years}}</option>
                            @endforeach
                        </select>
					  </div>

                      <div class="form-group">
						<label for="editLevel">Grade Level</label>
						<select name="editLevel" id="editLevel" class="form-control js-example-basic-single">
                            
                            @foreach ($levels as $level)
                                <option value=" {{$level->id}}">{{$level->level_name}}</option>
                            @endforeach
                        </select>
					  </div>

                      <div class="form-group">
						<label for="branchEdit">Select Branch</label>
						<select style="width: 100%; padding:5px; font-size:28px;" name="branchEdit" id="branchEdit" class="js-example-basic-single form-control">
                            <option></option>
                            @foreach ($branches as $branch)
                                <option value=" {{$branch->id}}">{{$branch->branch_name}}</option>
                            @endforeach
                        </select>
					  </div>

                      <div class="form-group">
						<label for="editAdviser">Assign Adviser</label>
						<select style="width: 100%; padding:5px; font-size:28px;" name="editAdviser" id="editAdviser" class="js-example-basic-single form-control">
                            <option></option>
                            @foreach ($staffs as $staff)
                                <option value=" {{$staff->id}}">{{$staff->last_name}} {{$staff->first_name}}</option>
                            @endforeach
                        </select>
					  </div>

                      <div class="form-group">
                        <label for="editSection">Section Name</label>
                        <input type="text" required name="editSection" id="editSection" class="form-control"  placeholder="eg. Galatians, Revelation" />
                      </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

{{--SHOW SCHEDULE MODAL--}}
<div
    class="modal fade"
    id="showScheduleModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Section Schedule
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
                <form id="curriculum" method="GET" action="schedule" role="form">
                    @csrf
                    <div class="form-group">
                        <label for="curriculum">Select Curriculum</label>
                        <select style="width: 100%; padding:2px; font-size:18px;" name="curriculum" id="curriculum" class="js-example-basic-single float-right">
                            <option value=""></option>
                            @foreach ($curriculums as $curriculum)
                                <option value=" {{$curriculum->id}}">{{$curriculum->curriculum_description}}</option>
                            @endforeach 
                        </select>
                    </div>
                    <input type="hidden" id="hiddenId" name="section" />
{{-- 
                    <div class="form-group">
                        <label for="branch">Select Branch</label>
                        <select style="width: 100%; padding:2px; font-size:18px;" name="branch" id="branch" class="js-example-basic-single float-right">
                            <option value=""></option>
                            @foreach ($branches as $branch)
                                <option value=" {{$branch->id}}">{{$branch->branch_name}}</option>
                            @endforeach 
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="semester">Select Semester</label>
                        <select style="width: 100%; padding:2px; font-size:18px;" name="semester" id="semester" class="js-example-basic-single float-right">
                            <option value=""></option>
                            @foreach ($terms as $term)
                                <option value=" {{$term->id}}">{{$term->term_name}}</option>
                            @endforeach 
                        </select>
                    </div> --}}
                    <button class="btn btn-info float-right">Submit</button>
                    </form>
            </div>
        </div>
    </div>
</div>
