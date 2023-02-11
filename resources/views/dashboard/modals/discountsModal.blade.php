<!-- Add Modal-->
<div
    class="modal fade"
    id="addDiscountModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Discount
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
                <form id="addDiscountForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="discount_name">Discount Name</label>
                      <input type="text" required name="discount_name" class="form-control"  placeholder="eg. First Child, Second Child, With Highest Honor, Public Voucher">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control form-control-textarea" required name="description" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="student_dept">Student Department</label>
                        <select name="student_dept" class="form-control">
                            <option value="">Select ...</option>
                            <option value="Elementary">Elementary</option>
                            <option value="JHS">JHS</option>
                            <option value="SHS">SHS</option>
                            <option value="College">College</option>
                            <option value="Graduate Studies">Graduate Studies</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discount_type">Discount Type</label>
                        <select name="discount_type" class="form-control">
                            <option value="">Select ...</option>
                            <option value="Percentage">Percentage</option>
                            <option value="Constant">Constant</option>
                            <option value="Input Value">Input Value</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" required name="amount" class="form-control">
                    </div>
                   
                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Update Modal --}}
<div
    class="modal fade"
    id="updateDiscountModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Discount
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
                <form id="editDiscountForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="discount_name">Discount Name</label>
                      <input type="text" required name="discount_name" id="discount_name" class="form-control @error('title') is-invalid @enderror"  placeholder="eg. First Child, Second Child, With Highest Honor, Public Voucher">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control form-control-textarea" required name="description" id="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="student_dept">Student Department</label>
                        <select name="student_dept" id="student_dept" class="form-control">
                            <option value="">Select ...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discount_type">Discount Type</label>
                        <select name="discount_type" id="discount_type" class="form-control">
                            <option value="">Select ...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" id="amount" required name="amount" class="form-control">
                    </div>
                 
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
