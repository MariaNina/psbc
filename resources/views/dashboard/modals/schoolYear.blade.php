<!-- Add Year Modal-->
<div
    class="modal fade"
    id="addYearModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New School Year
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
                <form id="schoolYearForm" role="form">
                    @csrf
                    <div class="form-group">
                      <label for="sy">School Year</label>
                      <input type="text" name="sy" id="sy" class="form-control" pattern="[0-9]{4}-[0-9]{4}" placeholder="eg. 2021-2022">
                    </div>
                    <button id="btnCreate" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

{{-- Edit Year Modal --}}

<div
    class="modal fade"
    id="editYearModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update School Year
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
                <form id="updateSchoolYearForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="sy">School Year</label>
                      <input type="text" name="sy" id="updateSy" class="form-control" pattern="[0-9]{4}-[0-9]{4}" placeholder="eg. 2021-2022">
                    </div>
                    <button id="btnUpdate" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

