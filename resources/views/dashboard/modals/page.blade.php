<!-- Add Role Modal-->
<div
    class="modal fade"
    id="addPageModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="alert alert-danger" id="pageError">
        <span id="errorMessage"></span>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add New Page
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
                <form id="addPageForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="pageName">Route Name</label>
                      <input type="text" required name="pageName" id="pageName" class="form-control"  placeholder="eg. students, settings...">
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Edit Year Modal-->
<div
    class="modal fade"
    id="editPageModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="alert alert-danger" id="pageError2">
        <span id="errorMessage2"></span>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Edit Page
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
                <form id="editPageForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="editPageName">Role Name</label>
                      <input type="text" required name="editPageName" id="editPageName" class="form-control"  placeholder="eg. super admin,admin,teacher">
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>

            </div>
        </div>
    </div>
</div>
