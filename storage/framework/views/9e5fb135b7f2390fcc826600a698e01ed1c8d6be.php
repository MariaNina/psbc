

<?php $__env->startSection('title'); ?>
Elementary Registration
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php for($type = 0; $type < count($form_type_array); $type++): ?>
<!-- Records -->
<div id="elem-records-copy" class="container mb-3">

  <!-- Header -->
  <header class="">
    <center>
      <div class="top-header">
        <img src="<?php echo e(asset('img/logo.png')); ?>" class="mr-3" alt="psbc-logo" width="75" height="75" />
        <span class="font-weight-bold header-title">
            PAETE SCIENCE AND BUSINESS COLLEGE, INC.
            <span>
                <p class="location"><?php echo e(strtoupper($assessment->enrollment->branch->branch_name)); ?>, LAGUNA</p>
                <h3 class="elem-form-title">Application for Registration</h3>
    </div>
    </center>
  </header>

  <!-- Input -->
  <div class="form-wrapper mt-3">

      <div class="d-flex justify-content-between">
          <h4 class="text-uppercase underline"><?php echo e($form_type_array[$type]); ?></h4>
          <h5 class="text-uppercase">Student No. <span
                  class="underline"><?php echo e(($assessment->student->lrn != NULL) ? $assessment->student->lrn : $assessment->enrollment->application_no); ?></span>
          </h5>
      </div>

      <div class="d-flex justify-content-between">
          <h5>Name: <span class="underline"><?php echo e($assessment->student->last_name); ?>, <?php echo e($assessment->student->first_name); ?>

                  <?php echo e($assessment->student->middle_name); ?></span></h5>
          <h5 class="text-align-end">Department: <span class="underline"><?php echo e($assessment->student_department); ?></span>
          </h5>
      </div>

      <div class="d-flex justify-content-between">
          <h5>Date or Registration: <span
                  class="underline"><?php echo e(date('F d, Y',strtotime($assessment->enrollment->date_submitted))); ?></span></h5>
          <h5>Year: <span class="underline"><?php echo e($assessment->enrollment->level->level_name); ?></span></h5>
          <h5>Sch Yr: <span class="underline"><?php echo e($assessment->enrollment->school_year->school_years); ?></span></h5>
      </div>

  </div>

  <div class="row">
      <div class="col-8 p-1">

          <table class="basic-table">
              <thead>
                  <tr>
                      <th class="text-uppercase min-w-100px">Subjects</th>
                      <th class="text-uppercase min-w-25px">Units</th>
                      <th class="text-uppercase min-w-100px">Instructors</th>
                      <th class="text-uppercase min-w-25px">Day</th>
                      <th class="text-uppercase min-w-25px">Time</th>
                  </tr>
              </thead>
              <tbody>
                  <?php $__currentLoopData = $subjects_with_schedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                      <td><?php echo e($item->subject_name); ?></td>
                      <td class="cell-center"><?php echo e((int)$item->lect_unit + (int)$item->lab_unit); ?></td>
                      <td><?php echo e($item->first_name); ?></td>
                      <td class="cell-center"><?php echo e($item->days); ?></td>
                      <td class="cell-center"><?php echo e($item->start_time); ?></td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php for($i = 0; $i < 10 - count($subjects_with_schedule); $i++): ?> <tr>
                      <td>-</td>
                      <td>-</td>
                      <td>-</td>
                      <td>-</td>
                      <td>-</td>
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
                      <th class="text-uppercase min-w-100px">Fees</th>
                      <th class="text-uppercase min-w-50px">Amount</th>
                  </tr>
              </thead>
              <tbody>
                  <?php $lines = 0; ?>
                  <?php if($assessment->fees != NULL): ?>
                  <?php $__currentLoopData = json_decode($assessment->fees); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                      <?php if($fees->fee_type != ''): ?>
                      <td class=""><?php echo e($fees->fee_type); ?></td>
                      <td style="text-align:right;"><?php echo e($fees->fee_amount); ?></td>
                      <?php endif; ?>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php $lines += count(json_decode($assessment->fees)); ?>
                  <?php endif; ?>

                  <?php if($assessment->other_fees != NULL): ?>
                  <?php $__currentLoopData = json_decode($assessment->other_fees); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                      <?php if($fees->other_fee_types != ''): ?>
                      <td class=""><?php echo e($fees->other_fee_types); ?></td>
                      <td style="text-align:right;"><?php echo e($fees->other_fee_amount); ?></td>
                      <?php endif; ?>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php $lines += count(json_decode($assessment->other_fees)); ?>
                  <?php else: ?>
                  <tr>
                      <td></td>
                      <td></td>
                  <tr>
                      <?php endif; ?>
                      <thead>
                          <tr>
                              <th class=" min-w-100px">Discounts</th>
                              <th class="text-uppercase min-w-50px">Amount</th>
                          </tr>
                      </thead>
                      <?php if($assessment->discounts != NULL): ?>
                      <?php $__currentLoopData = json_decode($assessment->discounts); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                      <?php if($fees->discount_type != ''): ?>
                      <td class=""><?php echo e($fees->discount_type); ?></td>
                      <td style="text-align:right;"><?php echo e($fees->discount_amount); ?></td>
                      <?php endif; ?>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php $lines += count(json_decode($assessment->discounts)); ?>
                  <?php endif; ?>
                  <?php for($i = 0; $i < 8 - $lines; $i++): ?> <tr>
                      <td>-</td>
                      <td>-</td>
                      </tr>
                      <?php endfor; ?>
                      <tr>
                          <td style="text-align:right;"> Total Fee : </td>
                          <td style="text-align:right;" class="text-uppercase"><?php echo e(($assessment->fee_amount) ? "₱ ".$assessment->fee_amount : ""); ?></td>
                      </tr>
              </tbody>
          </table>
      </div>
  </div>

  <div class="signatures mt-4">

      <div class="d-flex justify-content-around">

          <p class="signature-line text-center"><?php echo e($assessment->student_department); ?> Coordinator/Principal</p>
          <p class="signature-line text-center">Treasurer</p>
      </div>

  </div>


</div>
<div class="container-fluid">
  <div class="page-br"></div>
</div>

<?php endfor; ?>

<?php echo $__env->make('print.backpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('print.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\psbc\resources\views/print/elem_jhs/elemreg.blade.php ENDPATH**/ ?>