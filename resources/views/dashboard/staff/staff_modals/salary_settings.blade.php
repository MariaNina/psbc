<!-- Edit Salary Modal-->
<div
    class="modal fade"
    id="editSalaryModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Employee Salary
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
                <form id="editSalaryForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="employee_name">Employee Name</label>
                      <input type="text" required name="employee_name" id="employee_name" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="amount_salary">Amount Salary</label>
                        <input type="number" required name="amount_salary" id="amount_salary" class="form-control"  placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="salary_class">Salary Classification</label>
                        <select name="salary_class" id="salary_class" class="form-control" required>
                            <option value="">--Select--</option>
                           <option value="daily">Daily</option>
                           <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount_salary">Special Allowance</label>
                        <input type="number" name="special_allowance" id="special_allowance" class="form-control"  placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="employment_status">Employment Status</label>
                        <select name="employment_status" id="employment_status" class="form-control" required>
                            <option value="">--Select--</option>
                            <option value="regular">Regular</option>
                            <option value="pattimer">Part-Timer</option>
                        </select>
                    </div>
                
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
