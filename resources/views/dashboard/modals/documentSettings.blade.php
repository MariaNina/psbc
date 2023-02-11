<!-- Add Year Modal-->
@toastr_css
@jquery
@toastr_js
<div
    class="modal fade"
    id="addDocumentModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Document
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
                <form id="addDocumentForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="levelCode">Document Name</label>
                      <input type="text" required name="document_name" class="form-control"  placeholder="e.g.  PSA, Form138, Diploma etc.">
                    </div>
                    <div class="form-group">
                        <label for="studentDept">Student Type</label>
                        <select name="student_type" class="form-control">
                            <option value="">Select ...</option>
                            <option value="New">New</option>
                            <option value="Old">Old</option>
                            <option value="Transferee">Transferee</option>
                            <option value="Cross Enrollee">Cross Enrollee</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="studentDept">Student Department</label>
                        <select name="student_dept" class="form-control">
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

<!-- Add Year Modal-->
@toastr_css
@jquery
@toastr_js
<div
    class="modal fade"
    id="editDocumentModal"
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
                <form id="editDocumentForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="levelCode">Document Name</label>
                      <input type="text" required name="document_name" id="document_name" class="form-control"  placeholder="e.g.  PSA, Form138, Diploma etc.">
                    </div>
                    <div class="form-group">
                        <label for="studentDept">Student Type</label>
                        <select name="student_type" id="student_type" class="form-control">  
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="studentDept">Student Department</label>
                        <select name="student_dept" id="student_dept" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="studentDept">Required</label>
                        <select name="is_required" id="is_required" class="form-control">
                        </select>
                    </div>
                
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
