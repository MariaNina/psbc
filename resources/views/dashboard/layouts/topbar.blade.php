<!-- Topbar -->
<nav class="navbar navbar-expand bg-orange topbar mb-4 static-top shadow">


    @if (Request::url() == url('/dashboard'))
        <div class="ml-2">
            <div class="d-flex align-items-center">
                {{-- <i class="far fa-calendar-alt m-0 p-0 text-white mr-1" style="font-size: 1.25rem;"></i> --}}
                <img class="mr-1" src="{{ asset('img/schedule.svg') }}" width="32" height="32" alt="calendar">
                @if($schoolYear->count() != 0 && $terms->count() != 0)
                    <form id="school_year_form" action="{{ route('dashboard.index') }}" class="d-inline-block"
                          method="GET">

                        <div class="d-flex">
                            <div>
                                {{-- SCHOOL YEAR SELECT --}}
                                <select class="custom-select border-0 custom-select-sm" id="school_year_select"
                                        name="school_year_select" style="border-radius: 0;">

                                    @foreach($schoolYear as $key => $sy)
                                        @if(isset($_GET['school_year_select']) && !empty($_GET['school_year_select']) && $_GET['school_year_select'] == $sy->school_years)
                                            <option
                                                value="{{ $sy->school_years }}" selected>
                                                {{ $sy->school_years }}
                                            </option>
                                        @else
                                            <option
                                                value="{{ $sy->school_years }}" {{ empty($_GET['school_year_select']) && $loop->last ? 'selected' : null }}>
                                                {{ $sy->school_years }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                {{-- TERM SELECT--}}
                                <select class="custom-select border-0 custom-select-sm" id="term_select"
                                        name="term_select" style="border-radius: 0;">
                                    @foreach($terms as $key => $term)
                                        @if(isset($_GET['term_select']) && !empty($_GET['term_select']) && $_GET['term_select'] == $term->term_name)
                                            <option
                                                value="{{ $term->term_name }}" selected>
                                                {{ $term->term_name }}
                                            </option>
                                        @else
                                            <option
                                                value="{{ $term->term_name }}" {{ empty($_GET['term_select']) && $loop->first ? 'selected' : null }}>
                                                {{ $term->term_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </form>
                @endif
            </div>
        </div>
@endif


<!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img id="topbar_avatar" class="img-profile rounded-circle"
                     src="{{ session('user')->avatar ?? 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y' }}">
                <div class="d-flex flex-column align-items-center">
                    <span
                        class="text-white user-name ml-2 d-none d-lg-inline small">{{session('user')->full_name }}</span>
                    <small
                        class="user-role d-none d-lg-inline text-white smalld-none d-lg-inline small">{{ session('user')->role }}</small>
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item"
                   href="{{ session('user')->role == 'Student' ? '/profile' : '/staff_profile' }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                 @if(session('user')->role != "Student")
                <a class="dropdown-item"
                href="{{ route('audit_trail.index') }}">
                 <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                 Audit Trail
                </a>
                @endif
                
                <form id="logoutForm" action="/logout" method="POST" style="display: inline-block !important;">
                    @csrf
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
