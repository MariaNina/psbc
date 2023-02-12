<?php $__env->startSection('title'); ?>
    Students
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Students Enrollment Lists</h1>
            <form id="branch_filter_form" class="d-inline-block d-flex mt-3" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="branches">Branches</label>
                    <select class="form-control" style="border: 1px solid #222;" id="branches" name="branches">
                        <option selected value="All">All</option>
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($branch->branch_name); ?>"><?php echo e($branch->branch_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group ml-3">
                    <label for="department">Department</label>
                    <select class="form-control" style="border: 1px solid #222;" id="department" name="department">
                        <option selected value="All">All</option>
                        <option value="Elementary">Elementary</option>
                        <option value="JHS">JHS</option>
                        <option value="SHS">SHS</option>
                        <option value="College">College</option>
                        <option value="Graduate Studies">Graduate Studies</option>
                    </select>
                </div>
            </form>

            <div class="form-group ml-3" id="strand-wrapper" style="display:none">
                <label for="strand">Course/Strand</label>
                <select class="form-control" style="border: 1px solid #222;" id="strand" name="strand">
                </select>
            </div>
        </div>

        <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" data-toggle="modal"
            data-target="#addStudentModal" href="#" role="button">
            <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
            Enroll Student
        </a>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table cust-datatable" width="100%" id="filtertable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="all">No.</th>
                                    <th class="all">Application No.</th>
                                    <th class="">Student Type</th>
                                    <th class="">LRN</th>
                                    <th class="all">First Name</th>
                                    <th class="all">Middle Name</th>
                                    <th class="all">Last Name</th>
                                    <th class="">Email</th>
                                    <th class="">Contact Number</th>
                                    <th class="">Address</th>
                                    <th class="">Department</th>
                                    <th class="">Program/Strand</th>
                                    <th class="">Major</th>
                                    <th class="">Level</th>
                                    <th class="all">Status</th>
                                    <th style="min-width: 160px;" class="all">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <?php echo $__env->make('dashboard.modals.studentsEnrollmentModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
    <script src="<?php echo e(asset('js/datatable-scripts/studentsEnrollment.js')); ?>"></script>
    <script src="<?php echo e(asset('js/datatable-scripts/studentEnrollmentFilterByBranch.js')); ?>"></script>
    <script src="<?php echo e(asset('js/form-scripts/students_enrollment.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\psbc\resources\views/dashboard/students_enrollment.blade.php ENDPATH**/ ?>