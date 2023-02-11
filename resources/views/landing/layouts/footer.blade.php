<!-- Start Footer -->
<footer id="footer" class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">

                <div class="footer-columns">

                    <div class="branch-contact-wrapper">

                        <p class="text-uppercase font-weight-bold">Contacts</p>

                        @forelse($branches as $branch)
                            <div class="contacts mb-2">
                                <p class="m-0 p-0 pb-2">
                                    {{ $branch->branch_name }}
                                </p>
                                <p class="m-0 p-0 pb-2">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $branch->branch_address }}
                                </p>
                                <p class="m-0 p-0 pb-2">
                                    <i class="fas fa-phone"></i>
                                    Phone: {{ $branch->telephone_no }}
                                </p>
                                <p class="m-0 p-0 pb-2">
                                    <i class="fas fa-envelope"></i>
                                    Email: {{ $branch->email }}
                                </p>
                            </div>
                        @empty
                            <div class="contacts mb-2">
                                <p class="m-0 p-0 pb-2">
                                    Main Branch
                                </p>
                                <p class="m-0 p-0 pb-2">
                                    <i class="fas fa-map-marker-alt"></i>
                                    J.P. Rizal St, Paete, 4016 Laguna
                                </p>
                                <p class="m-0 p-0 pb-2">
                                    <i class="fas fa-phone"></i>
                                    Phoone: (049) 557-0184
                                </p>
                                <p class="m-0 p-0 pb-2">
                                    <i class="fas fa-envelope"></i>
                                    Email: psbc.k12hs@gmail.com
                                </p>
                            </div>
                        @endforelse

                    </div>

                    <div id="links">
                        <p class="text-uppercase font-weight-bold">Quick Links</p>
                        <p><a href="#top-header">Home</a></p>
                        <p><a href="/about">About Us</a></p>
                        <p><a href="/lms">LMS</a></p>
                        <p><a href="/enrollment">Enrollment</a></p>
                    </div>

                    <div id="links">
                        <p class="text-uppercase font-weight-bold">Connect with us</p>
                        <p><a href="{{ $home->facebook }}">Facebook</a></p>
                        <p><a href="/our-programs">Programs</a></p>
                        <p><a href="{{ route('events.index') }}">Events</a></p>
                    </div>

                </div>

            </div>
            <div class="col-lg-2 d-flex justify-content-center align-items-center">
                <img src="{{ asset('img/logo.png') }}" width="110" height="110" alt="logo">
            </div>
        </div>

        <div class="line-hr"></div>

        {{--  All rights reserved --}}
        <div class="end-footer">
            <p style="color: #fcef09; font-weight: 500;">
                &copy; Copyright <span style="color: #fcef09 !important; font-weight: 500;" id="footer_year"></span> All
                Rights
                Reserved by Paete Science and Business
                College
            </p>
        </div>
    </div>
</footer>

<script>
    document.getElementById("footer_year").innerHTML = new Date().getFullYear();
</script>
<!-- End Footer -->
