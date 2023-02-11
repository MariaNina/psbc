<!-- Topbar -->
<nav class="navbar navbar-expand bg-orange topbar mb-4 static-top shadow">


    <?php if(Request::url() == url('/dashboard')): ?>
        <div class="ml-2">
            <div class="d-flex align-items-center">
                
                <img class="mr-1" src="<?php echo e(asset('img/schedule.svg')); ?>" width="32" height="32" alt="calendar">
                <?php if($schoolYear->count() != 0 && $terms->count() != 0): ?>
                    <form id="school_year_form" action="<?php echo e(route('dashboard.index')); ?>" class="d-inline-block"
                          method="GET">

                        <div class="d-flex">
                            <div>
                                
                                <select class="custom-select border-0 custom-select-sm" id="school_year_select"
                                        name="school_year_select" style="border-radius: 0;">

                                    <?php $__currentLoopData = $schoolYear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($_GET['school_year_select']) && !empty($_GET['school_year_select']) && $_GET['school_year_select'] == $sy->school_years): ?>
                                            <option
                                                value="<?php echo e($sy->school_years); ?>" selected>
                                                <?php echo e($sy->school_years); ?>

                                            </option>
                                        <?php else: ?>
                                            <option
                                                value="<?php echo e($sy->school_years); ?>" <?php echo e(empty($_GET['school_year_select']) && $loop->last ? 'selected' : null); ?>>
                                                <?php echo e($sy->school_years); ?>

                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                
                                <select class="custom-select border-0 custom-select-sm" id="term_select"
                                        name="term_select" style="border-radius: 0;">
                                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($_GET['term_select']) && !empty($_GET['term_select']) && $_GET['term_select'] == $term->term_name): ?>
                                            <option
                                                value="<?php echo e($term->term_name); ?>" selected>
                                                <?php echo e($term->term_name); ?>

                                            </option>
                                        <?php else: ?>
                                            <option
                                                value="<?php echo e($term->term_name); ?>" <?php echo e(empty($_GET['term_select']) && $loop->first ? 'selected' : null); ?>>
                                                <?php echo e($term->term_name); ?>

                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>


                    </form>
                <?php endif; ?>
            </div>
        </div>
<?php endif; ?>


<!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img id="topbar_avatar" class="img-profile rounded-circle"
                     src="<?php echo e(session('user')->avatar ?? 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'); ?>">
                <div class="d-flex flex-column align-items-center">
                    <span
                        class="text-white user-name ml-2 d-none d-lg-inline small"><?php echo e(session('user')->full_name); ?></span>
                    <small
                        class="user-role d-none d-lg-inline text-white smalld-none d-lg-inline small"><?php echo e(session('user')->role); ?></small>
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item"
                   href="<?php echo e(session('user')->role == 'Student' ? '/profile' : '/staff_profile'); ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                 <?php if(session('user')->role != "Student"): ?>
                <a class="dropdown-item"
                href="<?php echo e(route('audit_trail.index')); ?>">
                 <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                 Audit Trail
                </a>
                <?php endif; ?>
                
                <form id="logoutForm" action="/logout" method="POST" style="display: inline-block !important;">
                    <?php echo csrf_field(); ?>
                    <a href="#" class="dropdown-item" id="logout-btn">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </form>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
<?php /**PATH C:\Users\user\Documents\psbc\resources\views/dashboard/layouts/topbar.blade.php ENDPATH**/ ?>