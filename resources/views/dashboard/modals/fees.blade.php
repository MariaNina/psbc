<!-- Add Year Modal-->
@toastr_css
@jquery
@toastr_js
<div
    class="modal fade"
    id="addFeeModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Fee
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
                <form id="addFeeForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="feeName">Fee Name</label>
                      <input type="text" required name="feeName" class="form-control"  placeholder="eg. College Tuition Fee, Misc Fee ">
                    </div>
                    <div class="form-group">
                        <label for="feeDesc">Description</label>
                        <textarea class="form-control form-control-textarea" name="feeDesc" placeholder="eg. This is Fee for College"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="feeAmount">Constant Amount</label>
                        <input type="number" required name="feeAmount" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="feeType">Fee Type</label>
                        <select name="feeType" class="form-control">
                            <option value="">Select ...</option>
                            <option value="Discountable Fee">Discountable Fee</option>
                            <option value="Lec Unit">Lec Unit</option>
                            <option value="Lab Unit">Lab Unit</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="studentDept">Student Department</label>
                        <select name="studentDept" class="form-control">
                            <option value="">Select ...</option>
                            <option value="Elementary">Elementary</option>
                            <option value="JHS">JHS</option>
                            <option value="SHS">SHS</option>
                            <option value="College">College</option>
                            <option value="Graduate Studies">Graduate Studies</option>
                        </select>
                    </div>
                
                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

<!-- Add Year Modal-->
@toastr_css
@jquery
@toastr_js
<div
    class="modal fade"
    id="updateFeeModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Student Level
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
                <form id="updateFeeForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                        <label for="feeName">Fee Name</label>
                        <input type="text" required name="feeName" id="feeName" class="form-control"  placeholder="eg. College Tuition Fee, Misc Fee ">
                      </div>
                      <div class="form-group">
                          <label for="feeDesc">Description</label>
                          <textarea class="form-control form-control-textarea" name="feeDesc" id="feeDesc" placeholder="eg. This is Fee for College"></textarea>
                      </div>
                      <div class="form-group">
                          <label for="feeAmount">Constant Amount</label>
                          <input type="number" required name="feeAmount" id="feeAmount" class="form-control" >
                      </div>
                      <div class="form-group">
                          <label for="feeType">Fee Type</label>
                          <select name="feeType" id="feeType" class="form-control">
                              <option value="">Select ...</option>
                              <option value="Discountable Fee">Discountable Fee</option>
                              <option value="Lec Unit">Lec Unit</option>
                              <option value="Lab Unit">Lab Unit</option>
                              <option value="Others">Others</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="studentDept">Student Department</label>
                          <select name="studentDept" id="studentDept" class="form-control">
                              <option value="">Select ...</option>
                              <option value="Elementary">Elementary</option>
                              <option value="JHS">JHS</option>
                              <option value="SHS">SHS</option>
                              <option value="College">College</option>
                              <option value="Graduate Studies">Graduate Studies</option>
                          </select>
                      </div>
                
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
