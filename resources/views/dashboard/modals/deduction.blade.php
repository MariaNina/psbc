<!-- Add Deduction Modal-->
<div
    class="modal fade"
    id="addDeductionModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add New Deduction
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
                <form id="deductionForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="deduction_name">Deduction Name</label>
						<input type="text" name="deduction_name" id="deduction_name" class="form-control"  placeholder="eg. SSS,PhilHealth" />
					  </div>
{{--                       
                    <div class="form-group">
                        <label for="deduction_amount">Amount</label>
                        <input type="number" name="deduction_amount" id="deduction_amount" class="form-control" placeholder="eg. 500,1000" />
                    </div> --}}
                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>


<!-- Edit Deduction Modal-->
<div
    class="modal fade"
    id="editDeductionModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Deduction
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
                <form id="editDeductionForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="edit_deduction_name">Deduction Name</label>
						<input type="text" name="edit_deduction_name" id="edit_deduction_name" class="form-control"  placeholder="eg. SSS,PhilHealth" />
					  </div>
{{--                       
                    <div class="form-group">
                        <label for="edit_amount">Amount</label>
                        <input type="number" name="edit_amount" id="edit_amount" class="form-control" placeholder="eg. 500,1000" />
                    </div> --}}
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>


