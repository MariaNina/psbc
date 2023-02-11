@extends('dashboard.layouts.main')

@section('title')
    PSBC - Settings
@endsection

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-cogs"></i>
            Landing Page Settings
        </h1>
    </div>


    <div class="row">

        <div class="col-lg-12">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">

                    <div class="mb-4">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#our-program">Programs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#campus">Campus</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="announcement_tab_btn" href="#announcements">Announcement</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="events_tab_btn" href="#events">Events</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade show active">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <div>
                                    <h3>
                                        Home Page
                                        @if($home->is_maintenance == true)
                                            <span>
                                                <small style="font-size: 0.8rem !important;" class="text-danger">
                                                    (Under Maintenance)
                                                </small>
                                            </span>
                                        @endif
                                    </h3>
                                    <p>Manage your home content</p>
                                </div>

                                <a id="maintenanceBtn" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
                                   href="#">
                                    <i class="fas fa-power-off text-danger font-sm fa-sm text-white-50"></i>
                                    Maintenance Mode <span class="font-weight-bold">({{ ($home->is_maintenance == true) ? 'On' : 'Off' }})</span>
                                </a>

                            </div>

                            @include('dashboard.settings_tabs.home')
                        </div>
                        <div id="about" class="tab-pane fade">
                            <div>
                                <h3>About Page</h3>
                                <p>Manage your about content</p>
                            </div>

                            @include('dashboard.settings_tabs.about')
                        </div>
                        <div id="our-program" class="tab-pane fade">
                            <div>
                                <h3>Programs Page</h3>
                                <p>Manage your program content</p>
                            </div>

                            @include('dashboard.settings_tabs.programs')
                        </div>
                        <div id="campus" class="tab-pane fade">
                            <div>
                                <h3>Home / About Campus Images</h3>
                                <p>Manage your campus images</p>
                            </div>

                            @include('dashboard.settings_tabs.campus')
                        </div>
                        <div id="announcements" class="tab-pane fade">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <div>
                                    <h3>Announcements</h3>
                                    <p>Manage your announcements here</p>
                                </div>

                                <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" href="#!"
                                   role="button" data-toggle="modal" data-target="#addAnnouncementModal">
                                    <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
                                    New Announcement
                                </a>
                            </div>

                            @include('dashboard.settings_tabs.announcements')
                        </div>
                        <div id="events" class="tab-pane fade">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <div>
                                    <h3>Event Page</h3>
                                    <p>Manage your events here</p>
                                </div>

                                <a class="d-none d-sm-inline-block btn btn-sm btn-orange shadow-sm" href="#!"
                                   role="button" data-toggle="modal" data-target="#addEventModal">
                                    <i class="fas fa-plus font-sm fa-sm text-white-50"></i>
                                    New Event
                                </a>
                            </div>

                            @include('dashboard.settings_tabs.events')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- MODALS --}}
    @include('dashboard.settings_tabs.modals.add_event')
    @include('dashboard.settings_tabs.modals.edit_event')

    {{-- MODALS --}}
    @include('dashboard.settings_tabs.modals.add_announcement')
    @include('dashboard.settings_tabs.modals.edit_announcement')

@endsection

@section('extra-js')

    @include('dashboard.settings_scripts')

@endsection
