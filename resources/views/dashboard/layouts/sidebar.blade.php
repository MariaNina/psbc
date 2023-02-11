<!-- Sidebar -->
<ul class="navbar-nav bg-gray sidebar shadow-lg sidebar-dark accordion fixed-top" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('img/logo.png') }}" width="50" height="50" alt="psbc-logo">
        </div>
        <div class="sidebar-brand-text mx-3">PSBC</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Push Links -->
    <div class="mt-3"></div>
    @if(session('user')->role != "Student")
        <li class="nav-item {{ Request::url() == url('/dashboard') ? 'active' : '' }} {{ Request::url() == url('/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard">
                <img src="{{ asset('img/dashboard-icon.svg') }}" width="17" height="17" alt="dashboard">
                <span>Dashboard</span>
            </a>
        </li>
    @else
        <li class="nav-item {{ Request::url() == url('/profile') ? 'active' : '' }} {{ Request::url() == url('/profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('profile.index') }}">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
        </li>
@endif

<!-- Push Links -->
    <div class="mt-4"></div>

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <div class="menu-wrapper">
        @if(in_array("employees", $permissions))
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-money-check-alt"></i>
                    <span>HR/Payroll Module</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right animated--fade-in"
                     aria-labelledby="userDropdown">

                    @if(in_array("employees", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/employees') ? 'sidebar-active' : '' }}"
                           href="{{ route('employees.index') }}">
                            <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/employees') ? 'sidebar-active' : '' }}"></i>
                            Employees
                        </a>
                    @endif
                    @if(in_array("cutoff_settings", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/cutoff_settings') ? 'sidebar-active' : '' }}"
                           href="{{ route('cutoff_settings.index') }}">
                            <i class="fas fa-calendar fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/cutoff_settings') ? 'sidebar-active' : '' }}"></i>
                            Cut-Off Settings
                        </a>
                    @endif
                    @if(in_array("staff_attendance", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/staff_attendance') ? 'sidebar-active' : '' }}"
                           href="{{ route('staff_attendance.index') }}">
                            <i class="fas fa-calendar fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/staff_attendance') ? 'sidebar-active' : '' }}"></i>
                            Attendance
                        </a>
                        <a class="dropdown-item {{ Request::url() == url('/college_attendance_histories') ? 'sidebar-active' : '' }}"
                           href="{{ route('college_attendance_histories.index') }}">
                            <i class="fas fa-calendar fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/college_attendance_histories') ? 'sidebar-active' : '' }}"></i>
                            College Attendance
                        </a>
                    @endif
                    <a class="dropdown-item {{ Request::url() == url('/college_attendance_view') ? 'sidebar-active' : '' }}"
                    href="{{ route('college_attendance_view.index') }}">
                     <i class="fas fa-calendar fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/college_attendance_view') ? 'sidebar-active' : '' }}"></i>
                     College Attendance View
                 </a>
                    @if(in_array("payslip", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/payslip') ? 'sidebar-active' : '' }}"
                           href="{{ '/payslip/' }}">
                            <i class="fas fa-book fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/payslip') ? 'sidebar-active' : '' }}"></i>
                            Payslips
                        </a>
                    @endif

                    <a class="dropdown-item {{ Request::url() == url('/view_payslip') ? 'sidebar-active' : '' }}"
                       href="{{ '/view_payslip' }}">
                        <i class="fas fa-book fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/view_payslip') ? 'sidebar-active' : '' }}"></i>
                        View Payslip
                    </a>

                    @if(in_array("staff_deductions", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/staff_deductions') ? 'sidebar-active' : '' }}"
                           href="{{ route('staff_deductions.index') }}">
                            <i class="fas fa-calendar fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/staff_deductions') ? 'sidebar-active' : '' }}"></i>
                            Staff Deductions
                        </a>
                    @endif
                    {{-- @if(in_array("staff_other_earnings", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/staff_other_earnings') ? 'sidebar-active' : '' }}"
                           href="{{ route('staff_other_earnings.index') }}">
                            <i class="fas fa-calendar fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/staff_other_earnings') ? 'sidebar-active' : '' }}"></i>
                            Staff Other Earnings
                        </a>
                    @endif --}}
                    @if(in_array("holiday_settings", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/holiday_settings') ? 'sidebar-active' : '' }}"
                           href="{{ route('holiday_settings.index') }}">
                            <i class="fas fa-calendar fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/holiday_settings') ? 'sidebar-active' : '' }}"></i>
                            Holiday Settings
                        </a>
                    @endif
                    {{-- @if(in_array("deduction_settings", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/deduction_settings') ? 'sidebar-active' : '' }}"
                           href="{{ route('deduction_settings.index') }}">
                            <i class="fas fa-wallet fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/deduction_settings') ? 'sidebar-active' : '' }}"></i>
                            Deduction Settings
                        </a>
                    @endif --}}
                    @if(in_array("salary_settings", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/salary_settings') ? 'sidebar-active' : '' }}"
                           href="{{ route('salary_settings.index') }}">
                            <i class="fas fa-money-check fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/salary_settings') ? 'sidebar-active' : '' }}"></i>
                            Salary Settings
                        </a>
                    @endif

                    <a class="dropdown-item {{ Request::url() == url('/time_settings') ? 'sidebar-active' : '' }}"
                    href="{{ route('time_settings.index') }}">
                     <i class="fas fa-clock fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/time_settings') ? 'sidebar-active' : '' }}"></i>
                     Time Settings
                 </a>

                </div>
            </li>
        @endif

        @if(in_array("assessments", $permissions))
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-graduate"></i>
                    <span>Accounting Module</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right animated--fade-in"
                     aria-labelledby="userDropdown">

                    <a class="dropdown-item {{ Request::url() == url('/assessments') ? 'sidebar-active' : '' }}"
                       href="{{ route('assessments.index') }}">
                        <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/assessments') ? 'sidebar-active' : '' }}"></i>
                        Assessments
                    </a>

                    <a class="dropdown-item {{ Request::url() == url('/payments') ? 'sidebar-active' : '' }}"
                       href="{{ route('payments.index') }}">
                        <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/payments') ? 'sidebar-active' : '' }}"></i>
                        Payments
                    </a>

                </div>
            </li>
        @endif

        @if(in_array("students", $permissions) || in_array("majors", $permissions) || in_array("document_settings", $permissions) || in_array("fees", $permissions) || in_array("discounts", $permissions))
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-graduate"></i>
                    <span>Enrollment Module</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right animated--fade-in"
                     aria-labelledby="userDropdown">

                    @if(in_array("students", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/students_enrollment') ? 'sidebar-active' : '' }}"
                           href="/students_enrollment">
                            <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/students_enrollment') ? 'sidebar-active' : '' }}"></i>
                            Enrollment List
                        </a>
                    @endif
                    @if(in_array("students", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/students') ? 'sidebar-active' : '' }}"
                           href="{{ route('students.index') }}">
                            <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/students') ? 'sidebar-active' : '' }}"></i>
                            Students
                        </a>
                    @endif

                    {{-- @if(in_array("parents", $permissions)) --}}
                    <a class="dropdown-item {{ Request::url() == url('/parents') ? 'sidebar-active' : '' }}"
                       href="{{ route('parents.index') }}">
                        <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/majors') ? 'sidebar-active' : '' }}"></i>
                        Parents
                    </a>
                    {{-- @endif --}}

                    @if(in_array("document_settings", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/document_settings') ? 'sidebar-active' : '' }}"
                           href="{{ route('document_settings.index') }}">
                            <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/document_settings') ? 'sidebar-active' : '' }}"></i>
                            Documents Setting
                        </a>
                    @endif

                    @if(in_array("fees", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/fees') ? 'sidebar-active' : '' }}"
                           href="{{ route('fees.index') }}">
                            <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/fees') ? 'sidebar-active' : '' }}"></i>
                            Fees Setting
                        </a>
                    @endif

                    @if(in_array("discounts", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/discounts') ? 'sidebar-active' : '' }}"
                           href="{{ route('discounts.index') }}">
                            <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/discounts') ? 'sidebar-active' : '' }}"></i>
                            Discounts Setting
                        </a>
                    @endif

                </div>
            </li>
        @endif

        @if(in_array("grade_settings", $permissions) || in_array("college_grade", $permissions) || in_array("deped_grade", $permissions) )
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-chart-bar"></i>
                    <span>Grade Settings</span>
                </a>


                <div class="dropdown-menu dropdown-menu-right animated--fade-in"
                     aria-labelledby="userDropdown">
                    @if(in_array("college_grade", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/college_grade') ? 'sidebar-active' : '' }}"
                           href="/college_grade">
                            <i class="fas fa-poll fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/college_grade') ? 'sidebar-active' : '' }}"></i>
                            College-Graduate Studies
                        </a>
                    @endif
                    @if(in_array("deped_grade", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/deped_grade') ? 'sidebar-active' : '' }}"
                           href="/deped_grade">
                            <i class="fas fa-poll fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/deped_grade') ? 'sidebar-active' : '' }}"></i>
                            Elementary-SHS
                        </a>
                    @endif
                    @if(in_array("grade_settings", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/grade_settings') ? 'sidebar-active' : '' }}"
                           href="/grade_settings">
                            <i class="fas fa-poll fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/grade_settings') ? 'sidebar-active' : '' }}"></i>
                            Grade Settings
                        </a>
                    @endif
                </div>

            </li>
        @endif

        @if(in_array("branches", $permissions) || in_array("school_years", $permissions) || in_array("colleges", $permissions) || in_array("programs", $permissions) || in_array("majors", $permissions) || in_array("terms", $permissions) || in_array("levels", $permissions) || in_array("subjects", $permissions) || in_array("sections", $permissions) || in_array("rooms", $permissions))
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-pencil-ruler"></i>
                    <span>Academic Settings</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right animated--fade-in"
                     aria-labelledby="userDropdown">

                    @if(in_array("branches", $permissions))
                        <a class="dropdown-item
			{{ Request::url() == url('/branches') ? 'sidebar-active' : '' }}" href="{{ route('branches.index') }}">
                            <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/branches') ? 'sidebar-active' : '' }}"></i>
                            Branches
                        </a>
                    @endif

                    @if(in_array("school_years", $permissions))
                        <a class="dropdown-item
			{{ Request::url() == url('/school_years') ? 'sidebar-active' : '' }}"
                           href="{{ route('school_years.index') }}">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/school_years') ? 'sidebar-active' : '' }}"></i>
                            School Year
                        </a>
                    @endif

                    @if(in_array("colleges", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/colleges') ? 'sidebar-active' : '' }}"
                           href="{{ route('colleges.index') }}">
                            <i class="fas fa-university fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/colleges') ? 'sidebar-active' : '' }}"></i>
                            Colleges
                        </a>
                    @endif

                    @if(in_array("programs", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/programs') ? 'sidebar-active' : '' }}"
                           href="/programs">
                            <i class="fas fa-graduation-cap fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/programs') ? 'sidebar-active' : '' }}"></i>
                            Programs/Courses
                        </a>
                    @endif

                    @if(in_array("majors", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/majors') ? 'sidebar-active' : '' }}"
                           href="{{ route('majors.index') }}">
                            <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/majors') ? 'sidebar-active' : '' }}"></i>
                            Majors
                        </a>
                    @endif

                    @if(in_array("terms", $permissions))
                        <a class="dropdown-item
			{{ Request::url() == url('/terms') ? 'sidebar-active' : '' }}" href="{{ route('terms.index') }}">
                            <i class="far fa-calendar-alt fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/terms') ? 'sidebar-active' : '' }}"></i>
                            Semesters
                        </a>
                    @endif

                    @if(in_array("levels", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/levels') ? 'sidebar-active' : '' }}"
                           href="{{ route('levels.index') }}">
                            <i class="fas fa-level-up-alt fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/levels') ? 'sidebar-active' : '' }}"></i>
                            Student Levels
                        </a>
                    @endif

                    @if(in_array("subjects", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/subjects') ? 'sidebar-active' : '' }}"
                           href="{{ route('subjects.index') }}">
                            <i class="fas fa-bookmark fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/subjects') ? 'sidebar-active' : '' }}"></i>
                            Subjects
                        </a>
                    @endif

                    @if(in_array("sections", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/sections') ? 'sidebar-active' : '' }}"
                           href="{{ route('sections.index') }}">
                            <i class="fas fa-level-up-alt fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/sections') ? 'sidebar-active' : '' }}"></i>
                            Sections
                        </a>
                    @endif

                    @if(in_array("rooms", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/rooms') ? 'sidebar-active' : '' }}"
                           href="{{ route('rooms.index') }}">
                            <i class="fas fa-door-open fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/rooms') ? 'sidebar-active' : '' }}"></i>
                            Rooms
                        </a>
                    @endif

                </div>
            </li>
        @endif

        @if(in_array("programmajors", $permissions) || in_array("branch_college_program_majors", $permissions) || in_array("curriculums", $permissions))
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sliders-h"></i>
                    <span>Curriculum Settings</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right animated--fade-in"
                     aria-labelledby="userDropdown">

                    @if(in_array("programmajors", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/programmajors') ? 'sidebar-active' : '' }}"
                           href="{{ route('programmajors.index') }}">
                            <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/programmajors') ? 'sidebar-active' : '' }}"></i>
                            Assign Program Majors
                        </a>
                    @endif

                    @if(in_array("branch_college_program_majors", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/branch_college_program_majors') ? 'sidebar-active' : '' }}"
                           href="{{ route('branch_college_program_majors.index') }}">
                            <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/branch_college_program_majors') ? 'sidebar-active' : '' }}"></i>
                            Assign Branch Colleges
                        </a>
                    @endif

                    @if(in_array("curriculums", $permissions))
                        <a class="dropdown-item
			{{ Request::url() == url('/curriculums') ? 'sidebar-active' : '' }}" href="/curriculums">
                            <i class="fab fa-cuttlefish fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/curriculums') ? 'sidebar-active' : '' }}"></i>
                            Curriculum
                        </a>
                    @endif

                </div>
            </li>
        @endif

        @if(in_array("roles", $permissions) || in_array("pages", $permissions) || in_array("users", $permissions))
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-cog"></i>
                    <span>User Accounts Setting</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right animated--fade-in"
                     aria-labelledby="userDropdown">

                    @if(in_array("roles", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/roles') ? 'sidebar-active' : '' }}"
                           href="/roles">
                            <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/roles') ? 'sidebar-active' : '' }}"></i>
                            Roles
                        </a>
                    @endif

                    @if(in_array("pages", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/pages') ? 'sidebar-active' : '' }}"
                           href="/pages">
                            <i class="fas fa-file-alt fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/pages') ? 'sidebar-active' : '' }}"></i>
                            Pages
                        </a>
                    @endif

                    @if(in_array("users", $permissions))
                        <a class="dropdown-item {{ Request::url() == url('/users') ? 'sidebar-active' : '' }}"
                           href="/users">
                            <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/users') ? 'sidebar-active' : '' }}"></i>
                            Users
                        </a>
                    @endif

                </div>
            </li>
        @endif

        @if(in_array("schedule", $permissions))
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#!" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Schedule Settings</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right animated--fade-in"
                     aria-labelledby="userDropdown">

                    <a class="dropdown-item {{ Request::url() == url('/schedule') ? 'sidebar-active' : '' }}"
                       href="{{ route('schedule.index') }}">
                        <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/schedule') ? 'sidebar-active' : '' }}"></i>
                        Not College
                    </a>

                    <a class="dropdown-item {{ Request::url() == url('/college_schedule') ? 'sidebar-active' : '' }}"
                       href="{{ route('schedule.college') }}">
                        <i class="fas fa-book-reader fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/college_schedule') ? 'sidebar-active' : '' }}"></i>
                        College
                    </a>

                </div>
            </li>
        @endif

        @if(session('user') && session('user')->role !== 'Admin' && session('user')->role !== 'Super Admin' && session('user')->role !== 'Student')
            <li class="nav-item">
                <a class="nav-link {{ Request::url() == url('/view_payslip') ? 'sidebar-active' : '' }}"
                   href="/view_payslip" role="button"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-book fa-sm fa-fw mr-2 text-gray-400 {{ Request::url() == url('/view_payslip') ? 'sidebar-active' : '' }}"></i>
                    <span>View Payslip</span>
                </a>
            </li>
        @endif

        @if(in_array("settings", $permissions))
            <li class="nav-item">
                <a class="nav-link {{ Request::url() == url('/settings') ? 'sidebar-active' : '' }}"
                   href="{{ route('settings.index') }}" role="button"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cogs {{ Request::url() == url('/settings') ? 'sidebar-active' : '' }}"></i>
                    <span>Landing Page Settings</span>
                </a>
            </li>
        @endif

        @if(session('user')->role == "Student")
            {{--  FOR STUDENTS  --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::url() == url('/my_schedule') ? 'sidebar-active' : '' }}"
                   href="/my_schedule"
                   role="button"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-book {{ Request::url() == url('/my_schedule') ? 'sidebar-active' : '' }}"></i>
                    <span>Schedule</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::url() == url('/my_grades') ? 'sidebar-active' : '' }}" href="/my_grades"
                   role="button"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-poll fa-sm fa-fw {{ Request::url() == url('/my_grades') ? 'sidebar-active' : '' }}"></i>
                    <span>Grades</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::url() == url('/enrollment_history') ? 'sidebar-active' : '' }}"
                   href="/enrollment_history"
                   role="button"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-poll fa-sm fa-fw {{ Request::url() == url('/enrollment_history') ? 'sidebar-active' : '' }}"></i>
                    <span>Enrollment History</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::url() == url('/payments') ? 'sidebar-active' : '' }}" href="/payments"
                   role="button"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-poll fa-sm fa-fw {{ Request::url() == url('/payments') ? 'sidebar-active' : '' }}"></i>
                    <span>Payments</span>
                </a>
            </li>

        @endif
    </div>

</ul>
<!-- End of Sidebar -->
