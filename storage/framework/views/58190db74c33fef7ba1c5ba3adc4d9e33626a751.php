

<div
    class="modal fade"
    id="addPaymentModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Pay Fees
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
                <form id="paymentForm" role="form" data-toggle="validator">
                    <?php echo csrf_field(); ?>
                    <input type="hidden"  required name="branch_id" id="branch_id">
                    <input type="hidden" value="<?php echo e(session('user')->user_name); ?>" required name="created_by" id ="created_by"/>
                    <input type="hidden"  required name="student_dept" id="student_dept">
                    <input type="hidden"  required name="student_id" id="payment_student_id">
                    <input type="hidden"  required name="assessment_id" id="payment_assessment_id">
                    <input type="hidden"  required name="enrollment_id" id="payment_enrollment_id">
                    <input type="hidden"  required name="user_id" id="payment_user_id">
                    <div class="form-group">
                        <label for="payment_total_fees">Total Fees</label>
                        <input type="text" id="payment_total_fees_display" class="form-control" readonly>
                        <input type="hidden"  required name="payment_total_fees" id="payment_total_fees" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="payment_available_balance">Available Balance</label>
                        <input type="text" id="payment_available_balance_display" class="form-control" readonly>
                        <input type="hidden" id="payment_available_balance" required name="payment_available_balance" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="payment_type">Payment Method</label>
                        <select name="payment_type" id="payment_type" class="form-control">
                            <option value="Cash">Cash</option>
                            <option value="GCash">GCash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="ESC">ESC</option>
                            <option value="QVR">QVR</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_for">Payment Type</label>
                        <select name="payment_for" id="payment_for" class="form-control">
                            <option value="Registration Fee">Registration Fee</option>
                            <option value="Tuition Fee">Tuition Fee</option>
                            <option value="Graduation Fee">Graduation Fee</option>
                            <option value="Salary Deduction">Salary Deduction</option>
                            <option value="Back Account Fee">Back Account Fee</option>
                            <option value="Other Fee">Other Fee</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_amount">Amount</label>
                        <input type="number" id="payment_amount" required name="payment_amount" class="form-control" min="0">
                    </div>
                    <div class="form-group">
                        <label for="payment_date">Payment Date</label>
                        <input type="date" id="payment_date" required name="payment_date" class="form-control" min="0">
                    </div>
                    <div class="form-group">
                        <label for="or_number">O.R. Number</label>
                        <input type="text" id="or_number" required name="or_number" class="form-control">
                    </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Save Payment</button>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\user\Documents\psbc\resources\views/dashboard/modals/paymentModal.blade.php ENDPATH**/ ?>