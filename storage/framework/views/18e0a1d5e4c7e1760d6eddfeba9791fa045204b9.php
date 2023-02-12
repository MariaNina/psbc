

<?php $__env->startSection('title'); ?>
    College
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php for($type = 0; $type < count($form_type_array); $type++): ?>
    <!-- Student's Copy -->
    <div id="college-students-copy" class="container mb-3">

        <!-- Header -->
        <header class="">
          <center>
          <div class="top-header mt-2">
            <img
              src="<?php echo e(asset('img/logo.png')); ?>"
              class="mr-3"
              alt="psbc-logo"
              width="73"
              height="73"
            />
            <span class="font-weight-bold header-title">
              PAETE SCIENCE AND BUSINESS COLLEGE, INC.<br>
            <span>
            <p class="location"><?php echo e(strtoupper($assessment->enrollment->branch->branch_name)); ?>, LAGUNA</p>
            <h3 class="elem-form-title">CERTIFICATE OF MALTRICULATION</h3>
          </div>
        </center>
        </header>

        <!-- Input -->
        <div class="form-wrapper mt-2">

          <div class="d-flex justify-content-between m-3">
            <h5 class="text-uppercase underline"><?php echo e($form_type_array[$type]); ?></h5>
            
            <h5 class="text-uppercase">Student No. :
              <span class="underline"><?php echo e(($assessment->student->lrn != NULL) ? $assessment->student->lrn : $assessment->enrollment->application_no); ?></span>
            </h5>
          </div>

          <div class="d-flex justify-content-between" id="college_of_row">
            <h5>Name: <span class="underline"><?php echo e($assessment->student->last_name); ?>, <?php echo e($assessment->student->first_name); ?> <?php echo e($assessment->student->middle_name); ?></span></h5>
            <h5 id="college_of" class="text-align-end">College of: 
              <span class="underline"><?php echo e($assessment->enrollment->curriculum->programMajors->description); ?><!-- New -->
            
              

              <small id="new">[
                <?php echo e(($assessment->enrollment->student_type == 'New') ? '✔' : '__'); ?>

              
                ] New	
              </small>
              <small id="old">[   
                <?php echo e(($assessment->enrollment->student_type == 'Old') ? '✔' : '__'); ?>

                  ] Old
              </small>

            </span>
            </h5>

          </div>

          <div class="d-flex justify-content-between">
            <h5>Date or Registration: <span class="underline"><?php echo e(date('F d, Y',strtotime($assessment->enrollment->date_submitted))); ?></span></h5>
            <h5>Year: <span class="underline"><?php echo e($assessment->enrollment->level->level_name); ?></span></h5>
            <h5>Sem/Sum: <span class="underline"><?php echo e($assessment->enrollment->term->term_name); ?> / <?php echo e($assessment->enrollment->school_year->school_years); ?></span></h5>
          </div>

        </div>
        <div class="row">
            <div class="col-8 p-1">
              
                <table class="basic-table" >
                  <thead>
                    <tr>
                      <th style="font-size:11px;" class="text-uppercase min-w-100px">Subjects</th>
                      <th style="font-size:11px;" class="text-uppercase min-w-25px">Units</th>
                      <th style="font-size:11px;" class="text-uppercase min-w-100px">Instructors</th>
                      <th style="font-size:11px;" class="text-uppercase min-w-25px">Day</th>
                      <th style="font-size:11px;" class="text-uppercase min-w-25px">Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $subjects_with_schedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td style="font-size:11px;"><?php echo e($item->subject_code); ?></td>
                        <td style="font-size:11px;" class="cell-center"><?php echo e((int)$item->lect_unit + (int)$item->lab_unit); ?></td>
                        <td style="font-size:11px;"><?php echo e($item->last_name); ?></td>
                        <td style="font-size:11px;" class="cell-center"><?php echo e($item->days); ?></td>
                        <td style="font-size:11px;" class="cell-center"><?php echo e($item->start_time); ?></td>
                      </tr>      
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php for($i = 0; $i < 10 - count($subjects_with_schedule); $i++): ?> <tr>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      <td style="font-size:11px;">-</td>
                      </tr>
                    <?php endfor; ?>
                  </tbody>
                </table>
            </div>
          <div class="col-4 p-1">
              <!-- Table -->
              <table class="basic-table">
                <thead>
                    <tr>
                        <th style="font-size:11px;" class="text-uppercase min-w-100px">Fees</th>
                        <th style="font-size:11px;" class="text-uppercase min-w-50px">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $lines = 0; ?>
                    <?php if($assessment->fees != NULL): ?>
                    <?php $__currentLoopData = json_decode($assessment->fees); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if($fees->fee_type != ''): ?>
                        <td style="font-size:11px;"  class=""><?php echo e($fees->fee_type); ?></td>
                        <td style="font-size:11px;" style="text-align:right;"><?php echo e($fees->fee_amount); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $lines += count(json_decode($assessment->fees)); ?>
                    <?php endif; ?>

                    <?php if($assessment->other_fees != NULL): ?>
                    <?php $__currentLoopData = json_decode($assessment->other_fees); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if($fees->other_fee_types != ''): ?>
                        <td style="font-size:11px;" class=""><?php echo e($fees->other_fee_types); ?></td>
                        <td style="font-size:11px;" style="text-align:right;"><?php echo e($fees->other_fee_amount); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $lines += count(json_decode($assessment->other_fees)); ?>
                    <?php else: ?>
                    <tr>
                        <td style="font-size:11px;"></td>
                        <td style="font-size:11px;"></td>
                    <tr>
                        <?php endif; ?>
                        <thead>
                            <tr>
                                <th style="font-size:11px;" class=" min-w-100px">Discounts</th>
                                <th style="font-size:11px;" class="text-uppercase min-w-50px">Amount</th>
                            </tr>
                        </thead>
                        <?php if($assessment->discounts != NULL): ?>
                        <?php $__currentLoopData = json_decode($assessment->discounts); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if($fees->discount_type != ''): ?>
                        <td style="font-size:11px;" class=""><?php echo e($fees->discount_type); ?></td>
                        <td style="font-size:11px;" style="text-align:right;"><?php echo e($fees->discount_amount); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $lines += count(json_decode($assessment->discounts)); ?>
                    <?php endif; ?>
                    <?php for($i = 0; $i < 7 - $lines; $i++): ?> <tr>
                        <td style="font-size:11px;">-</td>
                        <td style="font-size:11px;">-</td>
                        </tr>
                        <?php endfor; ?>
                        <tr>
                            <td style="text-align:right; font-size:9px;"> Total Fee : </td>
                            <td style="text-align:right; font-size:9px;" class="text-uppercase"><?php echo e(($assessment->fee_amount) ? "₱ ".$assessment->fee_amount : ""); ?></td>
                        </tr>
                </tbody>
            </table>
          
          </div>
        </div>
 

        <p class="m-0 p-0"><i>Approved by:</i></p>

        <div class="signatures mt-4">

          <div class="d-flex justify-content-between">
          
            <p class="signature-line text-center text-uppercase">Treasurer</p>
            <p class="signature-line text-center text-uppercase">Registrar</p>
            <p class="signature-line text-center text-uppercase">Dean</p>
          </div>
        <br>
        </div>

    </div>

    <div class="container-fluid">
      <div class="page-br"></div>
  </div>
<?php endfor; ?>
    <?php echo $__env->make('print.backpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('print.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\psbc\resources\views/print/college/collegereg.blade.php ENDPATH**/ ?>