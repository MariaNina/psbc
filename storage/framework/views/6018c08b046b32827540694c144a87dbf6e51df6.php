
<div
    class="modal fade"
    id="updateModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Payment Assessment
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
                <form id="updateForm" role="form" data-toggle="validator">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" value="" id="student_department" name="student_department"/>
                    <input type="hidden" value="" id="student_id" name="student_id"/>
                    <input type="hidden" value="" name="enrollment_id" id="enrollment_id"/>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="application_no">Application Number</label>
                                <input type="text" required name="application_no" id="application_no" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="student_name">Student Name</label>
                                <input type="text" required name="student_name" id="student_name" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="program_major">Program/Major/Strand</label>
                                <input type="text" required name="program_major" id="program_major" class="form-control" readonly>
                            </div>
                        </div>
                        
                    </div>
                
                        <div id="accordion">
                            <div class="card">
                              <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                  <a class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                   Fees And Discounts
                                  </a>
                                </h5>
                              </div>
                              <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 border-right">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-between mb-2">
                                                    <h6>Discountable Fees</h6>
                                                    <div class="new_fees">
                                                        <a id="add_fee" class="btn btn-success btn-sm btn-block" style="color:white;">+</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row" id="collegeFees">
                                           
                                                    </div>

                                                    <div class="row" id='addField'>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 border-right">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-between mb-2">
                                                    <h6>Other Fees</h6>
                                                    <div class="other_fees">
                                                        <a id="add_other_fee" class="btn btn-success btn-sm btn-block" style="color:white;">+</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row" id='addOtherField'>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-between mb-2">
                                                    <h6>Discounts</h6>
                                                    
                                                        <a id="add_discount" class="btn btn-success btn-sm " style="color:white;">+</a>
                                                    
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row" id="discount_area">              
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                  <h5 class="mb-0">
                                    <a class="btn btn-link" data-toggle="collapse" data-target="#collapsethree" aria-expanded="false" aria-controls="collapsethree">
                                     Other Details
                                    </a>
                                  </h5>
                                </div>
                                <div id="collapsethree" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="row">
                                        <div class="col col-md-3">
                                            <label class="control-label">Total Tuition Fees</label>
                                            <input id="total_fees" class="form-control" name="total_fees" type="text" style="text-align: center" readonly>
                                        </div>
                                        <div class="col col-md-3">
                                            <label class="control-label">Total Other Fees</label>
                                            <input id="total_other_fees" class="form-control" name="total_other_fees" type="text" style="text-align: center" readonly>
                                        </div>
                                        <div class="col col-md-3">
                                            <label class="control-label">Total Discounts</label>
                                            <input id="total_discount" class="form-control" name="total_discount" type="text" style="text-align: center" readonly>
                                        </div>
                                        <div class="col col-md-3">
                                            <label class="control-label">Total Amount</label>
                                            <input id="total_amount" class="form-control" name="total_amount" type="text" style="text-align: center" readonly>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php /**PATH C:\Users\user\Documents\psbc\resources\views/dashboard/modals/assessmentModal.blade.php ENDPATH**/ ?>