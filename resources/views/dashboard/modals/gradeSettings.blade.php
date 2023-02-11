<!-- Add Grade Set Modal-->

<div
    class="modal fade"
    id="addGradeSetModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                   Create New Grade Set
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
                <form id="GradeSetForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="grade_range">Grade Range</label>
                      <input type="text" required name="grade_range" id="grade_range" class="form-control @error('title') is-invalid @enderror"  placeholder="eg. 99-100">
                      @error('grade_range')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="form-group">
                        <label for="department">Level Department</label>
                        <select class="form-control" name="department" id="department">
                            <option value="">--Select Department--</option>
                            <option value="Elementary">Elementary</option>
                            <option value="JHS">JHS</option>
                            <option value="SHS">SHS</option>
                            <option value="College">College</option>
                            <option value="Graduate Studies">Graduate Studies</option>
                        </select>
                    </div>
                    <div class="form-group" id="point">
                        <label for="point_equivalent">Point Equivalent</label>
                        <input type="text" class="form-control" name="point_equivalant" id="point_equivalent" placeholder="eg. 1, 1.25, 1.5" />
                    </div>
                    <div class="form-group" id="letter">
                        <label for="letter_equivalent">Letter Equivalent</label>
                        <input type="text" class="form-control"  name="letter_equivalent" id="letter_equivalent" placeholder="eg. A, A+, B" />
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">--Select Status--</option>
                            <option value="Passed">Passed</option>
                            <option value="Failed">Failed</option>
                            <option value="For Completion">For Completion</option>
                        </select>
                    </div>
                    
                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Grade Set Modal-->

<div
    class="modal fade"
    id="editGradeSetModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                   Update Grade Set
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
                <form id="editGradeSetForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="grade_range1">Grade Range</label>
                      <input type="text" required name="grade_range1" id="grade_range1" class="form-control @error('title') is-invalid @enderror"  placeholder="eg. 99-100">
                      @error('grade_range1')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="form-group">
                        <label for="department1">Department</label>
                        <select class="form-control" disabled name="department1" id="department1">
                            <option value="">--Select Department--</option>
                            <option value="Elementary">Elementary</option>
                            <option value="JHS">JHS</option>
                            <option value="SHS">SHS</option>
                            <option value="College">College</option>
                            <option value="Graduate Studies">Graduate Studies</option>
                        </select>
                    </div>
                    <div class="form-group" id="point1">
                        <label for="point_equivalent1">Point Equivalent</label>
                        <input type="text" class="form-control" name="point_equivalent1" id="point_equivalent1" placeholder="eg. 1, 1.25, 1.5" />
                    </div>
                    <div class="form-group" id="letter1">
                        <label for="letter_equivalent1">Letter Equivalent</label>
                        <input type="text" class="form-control"  name="letter_equivalent1" id="letter_equivalent1" placeholder="eg. A, A+, B" />
                    </div>
                    <div class="form-group">
                        <label for="status1">Status</label>
                        <select class="form-control" name="status1" id="status1">
                            <option value="">--Select Status--</option>
                            <option value="Passed">Passed</option>
                            <option value="Failed">Failed</option>
                            <option value="For Completion">For Completion</option>
                        </select>
                    </div>
                    
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
