

<?php $__env->startSection('content'); ?>
<section>
    <div class="container">
        <div class="row justify-content-center min-vh-50 py-5  m align-content-center align-items-center">
            <div class="col-lg-6">
                <div>
                    <img src="<?php echo e(asset('img/maintenance.svg')); ?>" class="img-fluid" alt="under-maintenance">
                    <p class="lead text-center text-dark font-weight-bold">404</p>
                    <div class="d-flex justify-content-center">
                        <div class="w-75">
                            <p class="text-muted text-center">
                                Page not Found
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('ui.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\psbc\resources\views/ui/404.blade.php ENDPATH**/ ?>