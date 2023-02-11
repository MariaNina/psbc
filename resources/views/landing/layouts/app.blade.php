<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="This is Paete Science and Business College Official Website">
    <meta name="keywords" content="psbc website, psbc paete, psbc, paete psbc, iampsbc">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>@yield('title')</title>

    <link rel="icon" href="{{ asset('img/logo.png') }}"/>

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

    {{-- owl carousel --}}
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/owl.carousel.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/owl.theme.default.min.css') }}"/>

    <!-- CUSTOM STYLING -->
    <link rel="stylesheet" href="{{ asset('css/utils.css') }}"/>

    <link href="{{ asset('css/landing.css') }}" rel="stylesheet"/>

    <link href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css" rel="stylesheet"
          type="text/css"/>

    {{-- AOS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>

    <script async charset="utf-8" src="http://cdn.embedly.com/widgets/platform.js"></script>

    {{-- Extra CSS --}}
    @yield('extra-css')

</head>
<body>
<div id="main">
    @include('landing.layouts.navigation')

    <main id="app">@yield('content')</main>

    @include('landing.layouts.footer')
</div>

<!-- JQUERY WITH POPPER -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>

<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>
{{--        <script>--}}
{{--            window.fbAsyncInit = function () {--}}
{{--                FB.init({--}}
{{--                    xfbml: true,--}}
{{--                    version: "v10.0",--}}
{{--                });--}}
{{--            };--}}

{{--            (function (d, s, id) {--}}
{{--                var js,--}}
{{--                    fjs = d.getElementsByTagName(s)[0];--}}
{{--                if (d.getElementById(id)) return;--}}
{{--                js = d.createElement(s);--}}
{{--                js.id = id;--}}
{{--                js.src =--}}
{{--                    "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";--}}
{{--                fjs.parentNode.insertBefore(js, fjs);--}}
{{--            })(document, "script", "facebook-jssdk");--}}
{{--        </script>--}}

<!-- Your Chat Plugin code -->
<div
    class="fb-customerchat"
    attribution="page_inbox"
    page_id="102851758163320"
></div>

<!-- OWL -->
<script src="{{ asset('vendor/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/carousel.js') }}"></script>

{{-- smartwizard --}}
<script
    src="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/js/jquery.smartWizard.min.js"
    type="text/javascript"
></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

<!-- AOS -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

@include('landing.layouts.landing_scripts')

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

@yield('extra-js')
</body>
</html>
