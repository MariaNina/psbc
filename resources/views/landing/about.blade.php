@extends('landing.layouts.app')

@section('title')
    PSBC - About Us
@endsection

@section('content')
    <!-- SHOWCASE -->
    <header id="page-header" class="p-5">
        <div class="bg-overlay">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="container pt-5 text-center">
                            <h1>{{ $about->page_title }}</h1>
                            @if(!is_null($about->page_subtitle) && $about->page_subtitle != "")
                                <p>{{ $about->page_subtitle }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ABOUT SECTION -->
    <section id="about" class="py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mt-3 p-3">
                    <h1 class="text-dark">{{ $about->about_title }}</h1>
                    <p class="text-dark">{!! $about->about_content !!}</p>
                </div>
                <div class="col-md-6">
                    <img src="{{ $about->aboutImg() }}" alt="about_image"
                         class="img-fluid rounded-circle d-none d-md-block about-img">
                </div>
            </div>
        </div>
    </section>

    <section id="campus" class="primary-light py-5 mt-5">
        <div class="container text-center">

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

    <!-- VISION AND MISSION -->
    <section id="campus-vision" class="py-5 bg-black text-white" data-aos="fade-bottom">
        <div class="container text-center">
            <div class="row justify-content-center align-items-center">
                <div class="vision p-3 w-75">
                    <h3 class="vis">Vision</h3>
                    <div class="line"></div>
                    <p>{{ $about->vision }}</p>
                </div>
                <div class="mission p-3 w-75">
                    <h3 class="mis">Mission</h4>
                        <div class="line"></div>
                        <p>{{ $about->mission }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
