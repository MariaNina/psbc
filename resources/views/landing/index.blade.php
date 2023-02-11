@extends('landing.layouts.app')

@section('title')
    PSBC - Home
@endsection

@section('extra-css')
    <!-- MAPBOX -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js"></script>
    <link
        href="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css"
        rel="stylesheet"
    />
@endsection

@section('content')
    <div class="index-page">

        <section id="showcase">
            <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">

                    <div class="carousel-item active">

                        <img
                            class="d-block w-100 img-fluid carousel-img-1"
                            src="{{ $home->sliderOne() }}"
                            alt="First slide"
                        />
                        <div class="carousel-image-overlay">
                            <div class="container">
                                <div class="carousel-caption">
                                    <div class="carousel-text">
                                        <h1>{{ $home->carousel_title }}</h1>
                                        <p class="text-white">{{ $home->carousel_subtitle }}</p>
                                    </div>
                                    <a href="{{ $home->carousel_link1 }}"
                                       class="carousel-link btn btn-outline-primary btn-md">
                                        <i class="fas fa-arrow-right"></i>
                                        Enroll Here
                                    </a>
                                    <a href="{{ $home->carousel_link2 }}"
                                       class="carousel-link btn btn-outline-primary btn-md">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        LMS
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img
                            class="d-block w-100 img-fluid carousel-img-1"
                            src="{{ $home->sliderTwo() }}"
                            alt="First slide"
                        />
                        <div class="carousel-image-overlay">
                            <div class="container">
                                <div class="carousel-caption">
                                    <div class="carousel-text">
                                        <h1>{{ $home->carousel_title }}</h1>
                                        <p class="text-white">{{ $home->carousel_subtitle }}</p>
                                    </div>
                                    <a href="{{ $home->carousel_link1 }}"
                                       class="carousel-link btn btn-outline-primary btn-md">
                                        <i class="fas fa-arrow-right"></i>
                                        Enroll Here
                                    </a>
                                    <a href="{{ $home->carousel_link2 }}"
                                       class="carousel-link btn btn-outline-primary btn-md">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        LMS
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img
                            class="d-block w-100 img-fluid carousel-img-1"
                            src="{{ $home->sliderThree() }}"
                            alt="First slide"
                        />
                        <div class="carousel-image-overlay">
                            <div class="container">
                                <div class="carousel-caption">
                                    <div class="carousel-text">
                                        <h1>{{ $home->carousel_title }}</h1>
                                        <p class="text-white">{{ $home->carousel_subtitle }}</p>
                                    </div>
                                    <a href="{{ $home->carousel_link1 }}"
                                       class="carousel-link btn btn-outline-primary btn-md">
                                        <i class="fas fa-arrow-right"></i>
                                        Enroll Here
                                    </a>
                                    <a href="{{ $home->carousel_link2 }}"
                                       class="carousel-link btn btn-outline-primary btn-md">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        LMS
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#myCarousel" data-slide="prev" class="carousel-control-prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>

                <a href="#myCarousel" data-slide="next" class="carousel-control-next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
        </section>

        <!-- END OF SHOWCASE -->

        <!--HOME ICON SECTION  -->
        <section id="home-icons" class="py-5 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4 text-center">
                        <i class="fas fa-graduation-cap fa-3x mb-2 text-orange"></i>
                        <h3 class="text-dark">{{ $home->home_icon_title1 }}</h3>
                        <p class="text-muted" style="color: #111 !important;">
                            {!! $home->home_icon_subtitle1 !!}
                        </p>
                    </div>
                    <div class="col-md-4 mb-4 text-center">
                        <i class="fas fa-book fa-3x mb-2 text-orange"></i>
                        <h3 class="text-dark">{{ $home->home_icon_title2 }}</h3>
                        <p class="text-muted">
                            {!! $home->home_icon_subtitle2 !!}
                        </p>
                    </div>
                    <div class="col-md-4 mb-4 text-center">
                        <i class="fas fa-school fa-3x mb-2 text-orange"></i>
                        <h3 class="text-dark">{{ $home->home_icon_title3 }}</h3>
                        <p class="text-muted">
                            {!! $home->home_icon_subtitle3 !!}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- END  OF HOME ICONS -->

        <!-- ANNOUNCEMENT SECTION -->
        <section id="info" class="bg-light"
                 style="background: url('/storage<?= $home->home_announcement_img_background ?>') no-repeat fixed; background-size: cover;">
            <div class="container">

                {{--  ANNOUNCEMENT  --}}
                <div class="container text-center pb-5">
                    <div>
                        <h3 class="p-2 text-white text-center text-uppercase font-weight-bold">LATEST ANNOUNCEMENTS</h3>
                        <div class="line"></div>
                    </div>
                </div>

                @forelse($announcements as $announcement)
                    <div class="row mb-3 pb-3">
                        <div class="col-lg-6 w-100 align-self-center" data-aos="fade-up">
                            <div>
                                <h3 class="text-white" id="about">{{ $announcement->announcement_title }}</h3>
                                <div id="featured_annoncement">
                                    {!! $announcement->announcement_body !!}
                                </div>
                                <a href="{{ route('announcements.show', $announcement->id) }}"
                                   class="btn btn-outline-danger btn-lg mt-3"
                                   target="_blank"
                                >Learn More</a
                                >
                            </div>
                        </div>
                        <div class="col-lg-6 info-img p-3" data-aos="fade-up">
                            <div>
                                <img
                                    src="{{ $announcement->announcementImage() }}"
                                    alt="" class="w-100"/>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h3 class="p-2 text-dark text-center text-uppercase font-weight-bold">STAY TUNED FOR
                                    ANNOUNCEMENTS</h3>
                                <div class="line"></div>
                            </div>
                        </div>
                    </div>
                @endforelse

                <div class="d-flex justify-content-center text-center my-5">
                    <a href="{{ route('announcements.index') }}"
                       class="btn btn-orange text-white text-uppercase mt-3 mb-3">
                        SEE ALL ANNOUNCEMENTS
                    </a>
                </div>
            </div>
        </section>
        <!-- END OF INFO -->

        {{--  EVENTS  --}}
        <div class="container text-center mt-5">
            <div>
                <h3 class="p-2 text-dark text-center text-uppercase font-weight-bold">UPCOMING EVENTS</h3>
                <div class="line"></div>
                <p class="px-3 text-center">Let's take a look of PSBC current and future events</p>
            </div>
        </div>

        {{-- Events --}}
        <div class="container" id="all-events">
            <div class="row">
                @forelse($events as $event)
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('events.show', $event->id) }}">
                            <img class="w-100"
                                 src="{{ $event->eventImage() }}"
                                 height="370"
                                 alt="event-{{ $loop->iteration }}">
                        </a>
                        <div class="d-flex align-items-center mt-3">
                            <div class="event-date">
                                <h3 class="m-0 p-0 event-day">{{ $event->day }}</h3>
                                <p class="m-0 p-0 event-year text-white">
                                    <span>{{ $event->month }}</span>
                                    {{ $event->year }}
                                </p>
                            </div>
                            <h4 class="ml-3 text-dark">{{ $event->title }}</h4>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 mb-4">
                        <div class="d-flex justify-content-center align-items-center mt-3">
                            <h4 class="text-center" id="no-events-txt">
                                <i class="far fa-calendar-alt fa-2x text-orange"></i>
                                <span class="text-dark text-uppercase">No Events Currently</span>
                            </h4>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center text-center my-5">
                <a href="/events" class="btn btn-orange text-white text-uppercase mt-3 mb-3">
                    SEE ALL EVENTS
                </a>
            </div>
        </div>

        <section id="events" class="py-5">
            <div class="container text-center">
                <div>
                    <h3 class="p-2 text-uppercase font-weight-bold text-dark">{{ $home->campus_title }}</h3>
                    <div class="line"></div>
                    <p class="py-3">
                        {!! $home->campus_subtitle !!}
                    </p>
                </div>

                <div class="owl-carousel owl-theme" data-aos="fade-up">
                    @forelse($campus_photos as $photo)
                        <div class="image-{{ $loop->iteration }}">
                            <a href="{{ asset('/storage'.$photo->file) }}" data-toggle="lightbox"
                               data-gallery="campus-gallery">
                                <img src="{{ asset('/storage'.$photo->file) }}" class="img-thumbnail" alt="project1"/>
                            </a>
                        </div>
                    @empty
                        <div class="image-1">
                            <h2>Please add an campus image</h2>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="programs" class="bg-white py-5">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6" data-aos="fade-up-right">
                        <h3 class="text-dark">{{ $home->offer_title }}</h3>
                        <p>
                            {!! $home->offer_subtitle !!}
                        </p>
                        <ul class="more-info-list">
                            @if(count($home->offers) > 0 || !is_null($home->offers))
                                @foreach($home->offers as $offer)
                                    <li>
                                        <i class="fas fa-check-square fa-2x text-primary"></i>
                                        <span>{{ $offer }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <a href="/our-programs" class="btn btn-orange text-white mt-3 mb-3">
                            Our Programs
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="col-md-6" data-aos="fade-up-left">
                        <img src="{{ $home->offerImage() }}" class="img-fluid" alt="img3"/>
                    </div>
                </div>
            </div>
        </section>


        <!-- Map Box   -->
        <div id='map'></div>

        {{-- Floating Button --}}
 <!--       <div id="body-con" style="-->
 <!--   font-family:Verdana, Geneva, sans-serif;-->
	<!--font-size:18px;-->
	<!--background-color:#CCC;-->
 <!--   ">-->
 <!--   <span id="messageInquire" style="-->
 <!--   position:fixed;-->
	<!--width:60px;-->
	<!--height:60px;-->
	<!--bottom:40px;-->
	<!--right:40px;-->
	<!--background-color:orange;-->
	<!--color:#FFF;-->
	<!--border-radius:50px;-->
	<!--text-align:center;-->
	<!--box-shadow: 2px 2px 3px #999;-->
	<!--z-index:1;-->
 <!--   ">-->
<!--        <i style="margin-top:22px;" class="fa fa-envelope"></i>-->
<!--</span>-->
<!--            <span id="elemJhsBtn" style="-->
<!--    position:fixed;-->
<!--	width:100px;-->
<!--	height:40px;-->
<!--	bottom:100px;-->
<!--	right:40px;-->
<!--	background-color:orange;-->
<!--	color:#FFF;-->
<!--	border-radius:50px;-->
<!--	text-align:center;-->
<!--	box-shadow: 2px 2px 3px #999;-->
<!--	z-index:1;-->
<!--    ">-->
<!--        <label style="margin-top:5px;">Elem-JHS</label>-->
<!--</span>-->
<!--            <span id="shsBtn" style="-->
<!--    position:fixed;-->
<!--	width:100px;-->
<!--	height:40px;-->
<!--	bottom:140px;-->
<!--	right:40px;-->
<!--	background-color:orange;-->
<!--	color:#FFF;-->
<!--	border-radius:50px;-->
<!--	text-align:center;-->
<!--	box-shadow: 2px 2px 3px #999;-->
<!--	z-index:1;-->
<!--    ">-->
<!--        <label style="margin-top:5px;">SHS</label>-->
<!--</span>-->
<!--            <span id="collegeBtn" style="-->
<!--    position:fixed;-->
<!--	width:100px;-->
<!--	height:40px;-->
<!--	bottom:180px;-->
<!--	right:40px;-->
<!--	background-color:orange;-->
<!--	color:#FFF;-->
<!--	border-radius:50px;-->
<!--	text-align:center;-->
<!--	box-shadow: 2px 2px 3px #999;-->
<!--	z-index:1;-->
<!--    ">-->
<!--        <label style="margin-top:5px;">College</label>-->
<!--</span>-->
        </div>
    </div>




@endsection

@section('extra-js')
    <!-- MAPBOX -->
    <script src="{{ asset('js/mapbox.js') }}"></script>
    <script src="{{ asset('js/floating.js') }}"></script>
@endsection
