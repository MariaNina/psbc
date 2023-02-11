<!-- Add Role Modal-->
<div
    class="modal fade"
    id="addRoleModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="alert alert-danger" id="roleError">
        <span id="errorMessage"></span>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Role
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
                <form id="addRoleForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="roleName">Role Name</label>
                      <input type="text" required name="roleName" id="roleName" class="form-control"  placeholder="eg. super admin,admin,teacher">
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
    id="editRoleModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="alert alert-danger" id="roleError2">
        <span id="errorMessage2"></span>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Edit Role
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
                <form id="editRoleForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="editRole">Role Name</label>
                      <input type="text" required name="editRole" id="editRole" class="form-control"  placeholder="eg. super admin,admin,teacher">
                    </div>
                
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>