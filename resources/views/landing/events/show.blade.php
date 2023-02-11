@extends('landing.layouts.app')

@section('title')
    Events
@endsection

@section('content')
    <!-- SINGLE EVENT -->

    <header id="page-header" class="p-5">
        <div class="bg-overlay">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="container pt-5 mt-3 text-center">
                            <h1 class="text-uppercase">Event</h1>
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
                        <h1 class="m-0 p-0 text-dark">{{ $event->title }}</h1>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small><i>{{ \Carbon\Carbon::parse($event->upcoming_at)->isoFormat('MMMM D YYYY') }}</i></small>
                            </div>
                            <div>
                                <span
                                    class="badge badge-pill badge-{{ ($event->upcoming_at > now()) ? 'success' : 'danger' }}">
                                    {{ ($event->upcoming_at > now()) ? 'Upcoming' : 'Ended' }}
                                </span>
                            </div>
                        </div>
                        <p>{!! $event->body !!}</p>
                        <a href="{{ $event->link }}">{{ $event->link }}</a>
                    </div>

                    <a href="/events" class="btn btn-orange text-white mt-3 mb-3">
                        <i class="fas fa-arrow-left"></i>
                        Go Back
                    </a>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid"
                         src="{{ $event->eventImage() }}"
                         width="650"
                         height="940"
                         alt="event-2">
                </div>
            </div>
        </div>
    </section>

@endsection
