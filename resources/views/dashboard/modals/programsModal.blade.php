<!-- Add Program Modal-->
<div
    class="modal fade"
    id="addProgramsModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    <div class="alert alert-danger" id="programError">
        <span id="errorMessage"></span>
    </div>

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Program
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
                <form id="ProgramForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="program_code">Program Code</label>
						<input type="text" required name="program_code" id="program_code" class="form-control program_code"  placeholder="eg. BSIT, BSCS, BSHM..." />
					  </div>

                    <div class="form-group">
                      <label for="program_name">Program Name</label>
                      <input type="text" required name="program_name" id="program_name" class="form-control"  placeholder="eg. Bachelor of Elementary Education, Bachelor of Science in Business Administration..." />
                    </div>

                    <div class="form-group">
                        <label for="program_desc">Program Description</label>
                        <textarea class="form-control form-control-textarea" name="program_desc" id="program_desc" placeholder="eg. This is program description..." rows="3"></textarea>
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- Edit Program Modal-->
<div
    class="modal fade"
    id="updateProgramsModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    <div class="alert alert-danger" id="programError2">
        <span id="errorMessage2"></span>
    </div>

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Program
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
                <form id="updateProgramForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="program_code">Program Code</label>
						<input type="text" required name="program_code" id="upd_program_code" class="form-control program_code"  placeholder="eg. BSIT, BSCS, BSHM..." />
					  </div>

                    <div class="form-group">
                      <label for="program_name">Program Name</label>
                      <input type="text" required name="program_name" id="upd_program_name" class="form-control"  placeholder="eg. Bachelor of Elementary Education, Bachelor of Science in Business Administration..." />
                    </div>

                    <div class="form-group">
                        <label for="program_desc">Program Description</label>
                        <textarea class="form-control form-control-textarea" name="program_desc" id="upd_program_desc" placeholder="eg. This is program description..."></textarea>
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>

            </div>
        </div>
    </div>
</div>
