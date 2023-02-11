<!-- Add Holiday Modal-->
<div
    class="modal fade"
    id="addCutOffModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add New Cut-off Date
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
                <form id="CutOffForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="start_date">Start date</label>
						<input type="date" name="start_date" id="start_date" class="form-control" />
					  </div>
                      

                    <div class="form-group">
                        <label for="end_date">End date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="pay_date">Pay date</label>
                        <input type="date" name="pay_date" id="pay_date" class="form-control" />
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

<!-- Edit CutOff Modal-->
<div
    class="modal fade"
    id="editCutOffModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Cut-off Date
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
                <form id="EditCutOffForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="edit_start_date">Start date</label>
						<input type="date" name="edit_start_date" id="edit_start_date" class="form-control" />
					  </div>
                      

                    <div class="form-group">
                        <label for="edit_end_date">End date</label>
                        <input type="date" name="edit_end_date" id="edit_end_date" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="edit_pay_date">Pay date</label>
                        <input type="date" name="edit_pay_date" id="edit_pay_date" class="form-control" />
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
