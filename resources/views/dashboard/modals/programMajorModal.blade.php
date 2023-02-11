<!-- Add Program Modal-->
<div
    class="modal fade"
    id="addProgramMajorModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    <div class="alert alert-danger" id="programMajorError">
        <span id="errorMessage"></span>
    </div>

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Program Major
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
                <form id="ProgramMajorForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="programName">Choose Program</label>
						<select style="width: 100%; padding:2px; font-size:18px;" name="programName" id="programName" class="js-example-basic-single form-control">
                            <option value=""></option>
                            @foreach ($programs as $program)
                                <option value=" {{$program->id}}">{{$program->program_name}}</option>
                            @endforeach 
                        </select>
					</div>

                    <div class="form-group">
						<label for="majorName">Choose Major</label>
						<select style="width: 100%; padding:2px; font-size:18px;" name="majorName" id="majorName" class="js-example-basic-single form-control">
                            <option value=""></option>
                            @foreach ($majors as $major)
                                <option value=" {{$major->id}}">{{$major->major_name}}</option>
                            @endforeach 
                        </select>
					</div>
                    <div class="form-group">
                        <label for="studentDept">Student Department</label>
                        <select name="studentDept" id="studentDept" class="form-control">
                            <option value="">Select ...</option>
                            <option value="Elementary">Elementary</option>
                            <option value="JHS">JHS</option>
                            <option value="SHS">SHS</option>
                            <option value="College">College</option>
                            <option value="Graduate Studies">Graduate Studies</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Program Major Description</label>
                        <textarea class="form-control form-control-textarea" name="description" id="description" placeholder="eg. This is program major description..."></textarea>
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

<!-- Add Program Modal-->
<div
    class="modal fade"
    id="editProgramMajorModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    <div class="alert alert-danger" id="programMajorError2">
        <span id="errorMessage2"></span>
    </div>

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Edit Program Major
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
                <form id="updProgramMajorForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="up_programName">Choose Program</label>
						<select style="width: 100%; padding:2px; font-size:18px;" name="programName" id="up_programName" class="js-example-basic-single form-control">
                        </select>
					</div>

                    <div class="form-group">
						<label for="up_majorName">Choose Major</label>
						<select style="width: 100%; padding:2px; font-size:18px;" name="majorName" id="up_majorName" class="js-example-basic-single form-control">
                        </select>
					</div>
                    <div class="form-group">
                        <label for="studentDept">Student Department</label>
                        <select name="studentDept" id="upd_studentDept" class="form-control">
                           
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Program Major Description</label>
                        <textarea class="form-control form-control-textarea" name="description" id="up_description" placeholder="eg. This is program major description..."></textarea>
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>