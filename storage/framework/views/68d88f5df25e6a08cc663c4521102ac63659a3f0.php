<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="This is Paete Science and Business College Official Website">
    <meta name="keywords" content="psbc website, psbc paete, psbc, paete psbc, iampsbc">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <link rel="icon" href="<?php echo e(asset('img/logo.png')); ?>"/>

    <!-- Bootstrap CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
        crossorigin="anonymous"
    />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" rel="stylesheet">

    <!-- Fontawesome -->
    <link
        href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        rel="stylesheet"
    />

    
    <link rel="stylesheet" href="<?php echo e(asset('vendor/owl-carousel/owl.carousel.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/owl-carousel/owl.theme.default.min.css')); ?>"/>

    <!-- CUSTOM STYLING -->
    <link rel="stylesheet" href="<?php echo e(asset('css/utils.css')); ?>"/>

    <link href="<?php echo e(asset('css/landing.css')); ?>" rel="stylesheet"/>

    <link href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css" rel="stylesheet"
          type="text/css"/>

    
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>

    <script async charset="utf-8" src="http://cdn.embedly.com/widgets/platform.js"></script>

    
    <?php echo $__env->yieldContent('extra-css'); ?>

</head>
<body>
<div id="main">
    <?php echo $__env->make('landing.layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main id="app"><?php echo $__env->yieldContent('content'); ?></main>

    <?php echo $__env->make('landing.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<!-- JQUERY WITH POPPER -->
<script src="<?php echo e(asset('vendor/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/bootstrap/bootstrap.bundle.min.js')); ?>"></script>

<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>




















<!-- Your Chat Plugin code -->
<div
    class="fb-customerchat"
    attribution="page_inbox"
    page_id="102851758163320"
></div>

<!-- OWL -->
<script src="<?php echo e(asset('vendor/owl-carousel/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/carousel.js')); ?>"></script>


<script
    src="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/js/jquery.smartWizard.min.js"
    type="text/javascript"
></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

<!-- AOS -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<?php echo $__env->make('landing.layouts.landing_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
    $(document).ready(function () {
        AOS.init({
            offset: 150,
            duration: 800
        }); // Animation


        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    });
</script>

<?php echo $__env->yieldContent('extra-js'); ?>
</body>
</html>
<?php /**PATH C:\Users\user\Documents\psbc\resources\views/landing/layouts/app.blade.php ENDPATH**/ ?>