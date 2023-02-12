<?php $__env->startSection('title'); ?>
    College Encode Grades
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Subject Lists</h1>
</div>
<!-- Content Row -->

<div class="row">

  <div class="col-lg-12">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table cust-datatable" id="filtertable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>No.</th>
								<th>Subjects</th> 
                <th>Action</th>
							</tr>
						</thead>
					</table>
        </div>
      </div>
    </div>
  </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
<script src="<?php echo e(asset('js/datatable-scripts/college_grade.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\psbc\resources\views/dashboard/grades/college_grade.blade.php ENDPATH**/ ?>