<!-- Add User Permission Settings Modal-->
<div
    class="modal fade"
    id="userPermissionModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Give user access on some pages
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
                <form id="userPermissionForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group" id="permission_wrapper">

                    </div>

                    <button id="btn" type="submit" class="btn btn-info float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
