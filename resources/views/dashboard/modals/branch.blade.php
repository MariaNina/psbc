<!-- Add Branch Modal-->

<div
    class="modal fade"
    id="addBranchModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New School Branch
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
                <!-- Page Heading -->

                {{-- Alert --}}
                <div class="alert alert-danger errorAlert" hidden>
                </div>
                {{-- end alert --}}

                <form id="BranchForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="branch_name">Branch Name</label>
                      <input type="text" required name="branch_name" id="branch_name" class="form-control @error('title') is-invalid @enderror"  placeholder="eg. Paete Branch">
                      @error('branch_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="form-group">
                        <label for="branch_address">Branch Address</label>
                        <textarea class="form-control form-control-textarea" required name="branch_address" id="branch_address" placeholder="eg. J.P. Rizal St. Paete, Laguna"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="branch_desc">Branch Description</label>
                        <textarea class="form-control form-control-textarea" name="branch_desc" id="branch_desc" placeholder="eg. This is PSBC Main Branch"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="branch_email">Email Address</label>
                        <input type="email"  required name="branch_email" required id="branch_email" class="form-control"  placeholder="eg. psbc@gmail.com">
                    </div>
                    <div class="form-group">
                        <label for="branch_tel">Telephone No.</label>
                        <input type="text" id="branch_tel" required name="branch_tel" class="form-control" placeholder="eg. 09123456789">
                    </div>
                    <div class="form-group">
                        <label for="branch_contact">Mobile No.</label>
                        <input type="number" id="branch_contact" required name="branch_contact" class="form-control" pattern="[0-9]{11}" placeholder="eg. 09123456789">
                    </div>
                    <button id="btnCreate" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Update Branch Modal --}}
<div
    class="modal fade"
    id="updateBranchModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update School Branch
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

                <form id="updateBranchForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="branch_name">Branch Name</label>
                      <input type="text" required name="branch_name" id="upd_branch_name" class="form-control"  placeholder="eg. Paete Branch">
                    </div>
                    <div class="form-group">
                        <label for="branch_address">Branch Address</label>
                        <textarea class="form-control form-control-textarea" required name="branch_address" id="upd_branch_address" placeholder="eg. J.P. Rizal St. Paete, Laguna"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="branch_desc">Branch Description</label>
                        <textarea class="form-control form-control-textarea" name="branch_desc" id="upd_branch_desc" placeholder="eg. This is PSBC Main Branch"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="branch_email">Email Address</label>
                        <input type="email"  required name="branch_email" required id="upd_branch_email" class="form-control"  placeholder="eg. psbc@gmail.com">
                    </div>
                    <div class="form-group">
                        <label for="branch_tel">Telephone No.</label>
                        <input type="text" id="upd_branch_tel" required name="branch_tel" class="form-control" placeholder="eg. 09123456789">
                    </div>
                    <div class="form-group">
                        <label for="branch_contact">Contact Number</label>
                        <input type="tel" id="upd_branch_contact" required name="branch_contact" class="form-control" pattern="[0-9]{11}" placeholder="eg. 09123456789">
                    </div>
                    <button id="btnUpdate" type="submit" class="btn btn-success float-right">Update</button>
                </form>

            </div>
        </div>
    </div>
</div>
