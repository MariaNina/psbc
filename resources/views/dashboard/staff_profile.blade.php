@extends('dashboard.layouts.main')

@section('title')
    PSBC - Profile
@endsection

@section('content')


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-cog"></i>
            Staff Profile
        </h1>
    </div>


    <div class="row">

        <div class="col-lg-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="profile-wrapper py-3">
                        <div class="avatar-wrapper text-center">
                            <img
                                src="{{ is_null($user->staff->image) ? 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y' : '/storage'.$user->staff->image }}"
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
                                <span id="first_name_txt">{{ $user->staff->first_name }}</span>
                                <span id="middle_name_txt">{{ $user->staff->middle_name }}</span>
                                <span id="last_name_txt">{{ $user->staff->last_name }}</span>
                            </p>
                            <small id="email_txt">{{ $user->email }}</small>
                        </div>

                        {{-- OTHER INFO --}}
                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <p class="small text-dark">Username</p>
                            </div>
                            <div>
                                <p class="small text-uppercase font-weight-bold text-info">{{ $user->user_name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <p class="small text-dark">Position</p>
                            </div>
                            <div>
                                <p class="small text-uppercase _position font-weight-bold text-info">{{ $user->staff->position ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <p class="small text-dark">Type</p>
                            </div>
                            <div>
                                <p class="small text-uppercase _type font-weight-bold text-info">{{ $user->staff->staff_type ?? 'N/A' }}</p>
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
                                <a class="nav-link" href="#other_tabs">Other</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="staff_profile">
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
                                    @include('dashboard.staff_profile_tabs.basic_info')
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
                                    @include('dashboard.staff_profile_tabs.account_details')
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
                                    @include('dashboard.staff_profile_tabs.address_details')
                                </div>
                            </div>
                        </div>
                        <div id="other_tabs" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pt-3">
                                        <h5>Other Info</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    @include('dashboard.staff_profile_tabs.other_card_details')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('dashboard.staff_profile_tabs.modals.change_password')

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

    <script src="{{ asset('js/form-scripts/staff_profile/basic_info.js') }}"></script>
    <script src="{{ asset('js/form-scripts/staff_profile/account_details.js') }}"></script>
    <script src="{{ asset('js/form-scripts/staff_profile/address_details.js') }}"></script>
    <script src="{{ asset('js/form-scripts/staff_profile/other_card_details.js') }}"></script>
    <script src="{{ asset('js/form-scripts/staff_profile/change_password.js') }}"></script>
    <script src="{{ asset('js/form-scripts/staff_profile/change_avatar.js') }}"></script>


@endsection

