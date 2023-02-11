@extends('landing.layouts.app')

@section('title')
    Announcement
@endsection

@section('content')
    <!-- SINGLE EVENT -->

    <header id="page-header" class="p-5">
        <div class="bg-overlay">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="container pt-5 mt-3 text-center">
                            <h1 class="text-uppercase">Announcement</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ABOUT SECTION -->
    <section id="about" class="py-3">
        <div class="container">
            <div class="row my-5">
                <div class="col-md-6 mt-3 p-3">
                    <div>
                        <h1 class="m-0 p-0 text-dark">{{ $announcement->announcement_title }}</h1>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small>
                                    <i>
                                        Posted
                                        {{ \Carbon\Carbon::parse($announcement->created_at)->diffForHumans() }}
                                    </i>
                                </small>
                            </div>
                        </div>
                        <p>{!! $announcement->announcement_body !!}</p>
                    </div>

                    <a href="{{ route('announcements.index') }}" class="btn btn-orange text-white mt-3 mb-3">
                        <i class="fas fa-arrow-left"></i>
                        Go Back
                    </a>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid"
                         src="{{ $announcement->announcementImage() }}"
                         width="650"
                         height="940"
                         alt="event-2">
                </div>
            </div>
        </div>
    </section>

@endsection
