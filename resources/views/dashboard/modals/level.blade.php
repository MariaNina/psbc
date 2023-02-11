<!-- Add Year Modal-->
@toastr_css
@jquery
@toastr_js
<div
    class="modal fade"
    id="addLevelModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Student Level
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
                <form id="addLevelForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="levelCode">Grade Level Code</label>
                      <input type="text" required name="levelCode" id="levelCode" class="form-control"  placeholder="eg. g1,g7,g11,1stYr">
                    </div>
                    <div class="form-group">
                        <label for="levelName">Level Name</label>
                        <input type="text" required name="levelName" id="levelName" class="form-control"  placeholder="eg. Grade 1,Grade 7,Grade 11, 1st Year">
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
                
                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

<!-- Edit Year Modal-->
@toastr_css
@jquery
@toastr_js
<div
    class="modal fade"
    id="updateLevelModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Student Level
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
                <form id="updateLevelForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="levelCode">Grade Level Code</label>
                      <input type="text" required name="levelCode" id="upd_levelCode" class="form-control"  placeholder="eg. g1,g7,g11,1stYr">
                    </div>
                    <div class="form-group">
                        <label for="levelName">Level Name</label>
                        <input type="text" required name="levelName" id="upd_levelName" class="form-control"  placeholder="eg. Grade 1,Grade 7,Grade 11, 1st Year">
                    </div>
                    <div class="form-group">
                        <label for="studentDept">Student Department</label>
                        <select name="studentDept" id="upd_studentDept" class="form-control">
                           
                        </select>
                    </div>
                
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
