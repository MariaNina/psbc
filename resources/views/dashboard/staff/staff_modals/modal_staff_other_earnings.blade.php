<div class="modal fade" id="addAllowanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add Other Earnings
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
                        <label for="earnings">Other Earnings/Allowance</label>
                        <input type="text" name="earnings" class="form-control" placeholder="" />
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="eg. 500,1000" />
                </div>
                    <div class="form-group">
                        <label for="period">Cut-Off Period</label>
                        <select name="period" class="js-example-basic-single form-control">
                            <option value="" disabled selected>Select...</option>
                            <option value="semi-monthly">Semi-Monthly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="" disabled selected>Select...</option>
                            <option value="Pending">Pending</option>
                            <option value="Approve">Approve</option>
                            <option value="Paid">Paid</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Update --}}

<div class="modal fade" id="updateAllowanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <label for="earnings">Other Earnings/Allowance</label>
                        <input type="text" name="earnings" id="earnings" class="form-control" placeholder="" />
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="edit_amount" class="form-control" placeholder="eg. 500,1000" />
                    </div>
                    <div class="form-group">
                        <label for="period">Cut-Off Period</label>
                        <select name="period" id="period" class="js-example-basic-single form-control">
                            <option value="" disabled selected>Select...</option>
                            <option value="semi-annual">Semi-Annual</option>
                            <option value="annual">Annual</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="js-example-basic-single form-control">
                            <option value="" disabled selected>Select...</option>
                        </select>
                    </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
