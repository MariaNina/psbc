<?php $__env->startSection('title'); ?>
    Grade Settings
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Grades Sets Lists</h1>

        <div>
            <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" href="#" role="button"
               data-toggle="modal" data-target="#addGradeSetModal">
                <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
                Create New Grade Set
            </a>

            <a class="text-decoration-none no-arrow d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm"
               href="#" id="settingsGradeDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bullseye fa-sm"></i>
                Show Grade Settings
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="settingsGradeDropdown">


                <a class="dropdown-item"
                   href="#" id="showDepedGradeBtn">
                    <?php if(!$showGrades->show_deped_grade): ?>
                        <div>
                            <i class="fas fa-eye fa-sm fa-fw mr-2 text-gray-400"></i>
                            Show DepEd Grades
                        </div>
                    <?php else: ?>
                        <div>
                            <i class="fas fa-eye-slash fa-sm fa-fw mr-2 text-gray-400"></i>
                            Hide DepEd Grades
                        </div>
                    <?php endif; ?>
                </a>

                <a class="dropdown-item"
                   href="#" id="showChedGradeBtn">
                    <?php if(!$showGrades->show_ched_grade): ?>
                        <div>
                            <i class="fas fa-eye fa-sm fa-fw mr-2 text-gray-400"></i>
                            Show Ched Grades
                        </div>
                    <?php else: ?>
                        <div>
                            <i class="fas fa-eye-slash fa-sm fa-fw mr-2 text-gray-400"></i>
                            Hide Ched Grades
                        </div>
                    <?php endif; ?>
                </a>


            </div>
        </div>


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
                                <th>Grade Range</th>
                                <th>Level Department</th>
                                <th>Point Equivalent</th>
                                <th>Letter Equivalent</th>
                                <th>Grade Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php echo $__env->make('dashboard.modals.gradeSettings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
    <script src="<?php echo e(asset('js/datatable-scripts/gradeSettings.js')); ?>"></script>
    <script src="<?php echo e(asset('js/form-scripts/gradeSettings.js')); ?>"></script>
    <script src="<?php echo e(asset('js/form-scripts/show_grades_settings.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\psbc\resources\views/dashboard/grade_settings.blade.php ENDPATH**/ ?>