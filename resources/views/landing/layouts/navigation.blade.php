<!-- START NAVBAR -->
{{--(049) 557-0184--}}
<div id="top-header" class="top-header bg-orange">
    <div class="container">
        <div class="top-info-wrapper">
            <div class="top-info">
                <span>
                  <i class="fas fa-phone-alt"></i>
                  Call Us: {{ $home->contact_no }}
                </span>
            </div>
            <div class="top-social">
                <a href="#">
                      <span class="">
                          <i class="fas fa-envelope"></i>
                          {{ $home->email }}
                      </span>
                </a>
                <a class="d-none d-lg-inline" href="{{ $home->facebook }}" target="_blank">
                    <span><i class="fab fa-facebook-f"></i></span>
                </a>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ $home->logo() }}" width="50" height="50" alt="psbc-logo"/>
            <h4 class="d-inline align-middle text-dark">PSBC</h4>
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::url() == url('/') ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Request::url() == url('/about') ? 'active' : '' }}" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Request::url() == url('/our-programs') ? 'active' : '' }}"
                       href="/our-programs">Programs</a>
                </li>
                {{--          <li class="nav-item">--}}
                {{--            <a class="nav-link" href="#footer">Contact</a>--}}
                {{--          </li>--}}
                <li class="nav-item d-lg-none d-block">
                    <a class="nav-link" href="lms/">LMS</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- END OF NAVBAR -->
