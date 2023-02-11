<!-- Add Term Modal-->
@toastr_css
@jquery
@toastr_js
<div
    class="modal fade"
    id="addTermModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Term
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
                <form id="TermForm" role="form"  data-toggle="validator">
                    <div class="alert alert-danger" id="termError">
                        <span id="termMessage"></span>
                    </div>
                    <div class="form-group">
                        <label for="termName">Term Name</label>
                        <input type="text" required name="termName" id="termName" class="form-control"  placeholder="eg. 1st Term,2nd Term">
                    </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

{{-- update modal --}}

<div
    class="modal fade"
    id="updateTermModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    <div class="alert alert-danger" id="termError2">
        <span id="termMessage2"></span>
    </div>

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Term
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
                <form id="updateTermForm" role="form"  data-toggle="validator">
                    <div class="form-group">
                        <label for="termName">Term Name</label>
                        <input type="text" required name="termName" id="updateTermName" class="form-control"  placeholder="eg. 1st Term,2nd Term">
                    </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
