

<?php $__env->startSection('title'); ?>
    Login
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center align-items-center min-vh-100">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow my-5 login">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="<?php echo e(asset('img/logo.png')); ?>" alt="logo" width="100" height="100"
                                             class="m-0 p-0">
                                        <h1 class="h4 text-gray-900 mb-4 mt-2">Sign In</h1>
                                    </div>
                                    <form class="user" method="POST" id="loginForm" role="form" data-toggle="validator">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                   id="email" name="email" aria-describedby="emailHelp"
                                                   placeholder="Enter Email Address...">

                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                   id="password" name="password" placeholder="Password">
                                        </div>
                                        
                                        <button class="mt-4 btn btn-orange btn-user btn-block" type="submit">
                                            Login
                                        </button>
                      
                                    </form>
             
                                </div>
                            </div>
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <div class="bg-login-overlay">
                                    <div class="login-inner">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div>
                                                <h1 class="text-white">
                                                    Join us in <strong class="text-primary">PSBC</strong>
                                                </h1>
                                                <p class="text-white">
                                                    Login with your credentials and connect with Paete Science and
                                                    Business College

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('extra-js'); ?>
    <script src="<?php echo e(asset('js/form-scripts/login.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('authentication.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\psbc\resources\views/authentication/login.blade.php ENDPATH**/ ?>