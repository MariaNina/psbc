<!-- Add Major Modal-->
<div
    class="modal fade"
    id="addMajorModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="alert alert-danger" id="majorError">
        <span id="errorMessage"></span>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Major
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
                <form id="MajorForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="majorCode">Major Code</label>
						<input type="text" required name="majorCode" id="majorCode" class="form-control major_code"  
						placeholder="eg. Elementary Education and Teaching - 417, Computer Programming - 302..." />
					</div>
                    <div class="form-group">
                      <label for="majorName">Major Name</label>
                      <input type="text" required name="majorName" id="majorName" class="form-control"  placeholder="eg. Major in Marketing Management,  Major in English, Filipino, Mathematics..." />
                    </div>
                    <div class="form-group">
                        <label for="majorDesc">Program Description</label>
                        <textarea class="form-control form-control-textarea" name="majorDesc" id="majorDesc" placeholder="eg. This is major description..."></textarea>
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

{{--Update Major Modal--}}

<!-- Add Major Modal-->
<div
    class="modal fade"
    id="updateMajorModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="alert alert-danger" id="majorError2">
        <span id="errorMessage2"></span>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Major
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
                <form id="updateMajorForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="majorCode">Major Code</label>
						<input type="text" required name="majorCode" id="updateMajorCode" class="form-control major_code"  
						placeholder="eg. Elementary Education and Teaching - 417, Computer Programming - 302..." />
					</div>
                    <div class="form-group">
                      <label for="majorName">Major Name</label>
                      <input type="text" required name="majorName" id="updateMajorName" class="form-control"  placeholder="eg. Major in Marketing Management,  Major in English, Filipino, Mathematics..." />
                    </div>
                    <div class="form-group">
                        <label for="majorDesc">Major Description</label>
                        <textarea class="form-control form-control-textarea" name="majorDesc" id="updateMajorDesc" placeholder="eg. This is major description..."></textarea>
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
