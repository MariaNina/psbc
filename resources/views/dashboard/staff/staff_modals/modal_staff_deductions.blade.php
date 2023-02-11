<div class="modal fade" id="addDeductionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add Deduction
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                        <label for="staff_name">Staff Name</label>
                        <select name="staff_name" class="js-example-basic-single form-control">
                            <option value="" disabled selected>Select...</option>
                            @foreach ($staffs as $staff)
                            <option value="{{$staff->id}}">{{$staff->first_name.' '.$staff->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sss">SSS</label>
                        <input type="text" name="sss" id="" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                            <label for="tuition_fee">Tuition Fee</label>
                            <input type="text" name="tuition_fee" id="" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                        <label for="canteen">Canteen</label>
                        <input type="text" name="canteen" id="" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                            <label for="cash_advance">Cash Advance</label>
                            <input type="text" name="cash_advance" id="" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                        <label for="others">Others</label>
                        <input type="text" name="others" id="" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                        <label for="late_undertime">Late/Undertime</label>
                        <input type="text" name="late_undertime" id="" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Update --}}

<div class="modal fade" id="updateDeductionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Deduction
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                        <label for="staff_name">Staff Name</label>
                        <select name="staff_name" id="staff_name" class="js-example-basic-single form-control">
                            <option value="" disabled selected>Select...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sss">SSS</label>
                        <input type="text" name="sss" id="sss" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                            <label for="tuition_fee">Tuition Fee</label>
                            <input type="text" name="tuition_fee" id="tuition_fee" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                        <label for="canteen">Canteen</label>
                        <input type="text" name="canteen" id="canteen" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                            <label for="cash_advance">Cash Advance</label>
                            <input type="text" name="cash_advance" id="cash_advance" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                        <label for="others">Others</label>
                        <input type="text" name="others" id="others" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                        <label for="late_undertime">Late/Undertime</label>
                        <input type="text" name="late_undertime" id="late_undertime" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
