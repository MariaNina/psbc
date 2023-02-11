@extends('dashboard.layouts.main')

@section('title')
    PSBC - Profile
@endsection

@section('content')


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-cog"></i>
            Student Profile
        </h1>
    </div>


    <div class="row">

        <div class="col-lg-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="profile-wrapper py-3">
                        <div class="avatar-wrapper text-center">
                            <img
                                src="{{ session('user')->avatar }}"
                                width="128" height="128"
                                id="avatar" class="img-relative img-fluid border-radius-50 mb-3" alt="profile_img">
                            <div class="avatar_overlay">
                                <div class="avatar_overlay_content_icon">
                                    <a href="#!" id="avatar_edit"><i
                                            class="fas fa-user-edit text-white fa-2x avatar_edit_icon"></i></a>
                                    <form id="avatar_form" enctype="multipart/form-data" method="POST"
                                          style="display: inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <input type="file" class="d-none" name="image" id="image"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-5">
                            <p id="name" class="m-0 p-0 text-uppercase font-weight-bold text-dark font-sm text-center">
                                <span id="first_name_txt">{{ $user->student->first_name }}</span>
                                <span id="middle_name_txt">{{ $user->student->middle_name }}</span>
                                <span id="last_name_txt">{{ $user->student->last_name }}</span>
                            </p>
                            <small id="email_txt">{{ $user->email }}</small>
                        </div>

                        {{-- OTHER INFO --}}
                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <p class="small text-dark">Department</p>
                            </div>
                            <div>
                                <p class="small text-uppercase _position font-weight-bold text-info">{{ $user->student->latestEnrollment->student_department ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <p class="small text-dark">Level</p>
                            </div>
                            <div>
                                <p class="small text-uppercase font-weight-bold text-info">{{ $user->student->latestEnrollment->level->level_name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <p class="small text-dark">Section</p>
                            </div>
                            <div>
                                <p class="small text-uppercase _type font-weight-bold text-info">{{ $user->student->latestEnrollment->section->section_label ?? 'N/A' }}</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card shadow mb-4">
                <div class="card-body">

                    <div class="mb-4">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#staff_info_tab">Basic Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#user_account_tab">Account Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#address_tab">Address</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#other_tabs">Guardian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#documents">Documents</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="student_profile">
                        <div id="staff_info_tab" class="tab-pane fade show active">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pt-3">
                                        <h5>Personal Details</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    @include('dashboard.student_profile_tabs.basic_info')
                                </div>
                            </div>

                        </div>
                        <div id="user_account_tab" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pt-3">
                                        <h5>Credential Info</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    @include('dashboard.student_profile_tabs.account_details')
                                </div>
                            </div>
                        </div>
                        <div id="address_tab" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pt-3">
                                        <h5>Address</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    @include('dashboard.student_profile_tabs.address_details')
                                </div>
                            </div>
                        </div>
                        <div id="other_tabs" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pt-3">
                                        <h5>Guardian</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    @include('dashboard.student_profile_tabs.guardian_details')
                                </div>
                            </div>
                        </div>
                        <div id="documents" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pt-3">
                                        <h5>Documents</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    @include('dashboard.student_profile_tabs.documents_details')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('dashboard.student_profile_tabs.modals.change_password')

@endsection

@section('extra-js')
    <script>
        $(document).ready(function () {
            // For Tabs
            $(".nav-tabs a").click(function () {
                $(this).tab('show');
            });

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            

        });
    </script>

    <script src="{{ asset('js/form-scripts/student_profile/basic_info.js') }}"></script>
    <script src="{{ asset('js/form-scripts/student_profile/account_details.js') }}"></script>
    <script src="{{ asset('js/form-scripts/student_profile/change_password.js') }}"></script>
    <script src="{{ asset('js/form-scripts/student_profile/address_details.js') }}"></script>
    <script src="{{ asset('js/form-scripts/student_profile/guardian_details.js') }}"></script>
    <script src="{{ asset('js/form-scripts/student_profile/change_avatar.js') }}"></script>
    <script src="{{ asset('js/form-scripts/student_profile/document_details.js') }}"></script>


@endsection
