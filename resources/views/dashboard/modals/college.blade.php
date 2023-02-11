<!-- Add Year Modal-->
@toastr_css
@jquery
@toastr_js
<div
    class="modal fade"
    id="addCollegeModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New College
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
                  {{-- Alert --}}
                <div class="alert alert-danger errorAlert" hidden>
                </div>
                {{-- end alert --}}
                <form id="addCollegesForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="college_code">College Code</label>
                      <input type="text" required name="college_code" id="college_code" class="form-control"  placeholder="eg. CTE">
                    </div>
                    <div class="form-group">
                        <label for="college_name">College Name</label>
                        <input type="text" required name="college_name" id="college_name" class="form-control"  placeholder="eg. College of Teacher Education">
                    </div>
                    <div class="form-group">
                        <label for="college_desc">College Description</label>
                        <textarea class="form-control" name="college_desc" id="college_desc" placeholder="eg. This College is all about..."></textarea>
                    </div>
                    <button id="btnCreate" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

{{-- Update Modal --}}

<div
    class="modal fade"
    id="updateCollegeModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update College
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
                  {{-- Alert --}}
                  <div class="alert alert-danger errorAlert" hidden>
                </div>
                {{-- end alert --}}
                <form id="updateCollegesForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="college_code">College Code</label>
                      <input type="text" required name="college_code" id="upd_college_code" class="form-control"  placeholder="eg. CTE">
                    </div>
                    <div class="form-group">
                        <label for="college_name">College Name</label>
                        <input type="text" required name="college_name" id="upd_college_name" class="form-control"  placeholder="eg. College of Teacher Education">
                    </div>
                    <div class="form-group">
                        <label for="college_desc">College Description</label>
                        <textarea class="form-control" name="college_desc" id="upd_college_desc" placeholder="eg. This College is all about..."></textarea>
                    </div>
                    <button id="btnUpdate" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
