@extends('landing.layouts.app')

@section('title')
    PSBC - Programs
@endsection

@section('content')
    <!-- SHOWCASE -->

    <header id="page-header" class="p-5">
        <div class="bg-overlay">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="container pt-5 text-center">
                            <h1 class="text-uppercase">{{ $home->program_pagetitle }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="row justify-content-center mt-5 mb-5">
        <div>
            <h3 class="p-2 text-dark text-center text-uppercase font-weight-bold">{{ $home->program_contentitle }}</h3>
            <div class="line"></div>
        </div>
    </div>

    <!-- ABOUT SECTION -->
    <section id="our-programs" class="my-5">
        <div class="container">
            <div class="row justify-content-center">
                @forelse($program_photos as $photo)

                    <div class="col-md-4">
                        <div class="d-flex justify-content-center mb-3">
                            {{-- <i class="circle-wrapper fas fa-user-graduate fa-3x"></i> --}}
                            <img class="circle-wrapper" id="program_photo_view"
                                 data-id="{{ $photo->id }}"
                                 data-toggle="modal" data-target="#programDescriptionModal"
                                 src="{{ asset('/storage'.$photo->file) }}"
                                 alt="{{ $loop->iteration }}-icon">
                        </div>
                        <div class="text-center">
                            <p>{{ $photo->name }}</p>
                        </div>
                    </div>

                @empty

                    <div class="col-md-12">
                        <h5>No Programs</h5>
                    </div>

                @endforelse
            </div>
        </div>
    </section>

    {{-- Program Description Modal --}}
    @include('dashboard.settings_tabs.modals.view_programs')

@endsection
@section('extra-js')
    <script>
        // Click image
        $('html').on('click', '#program_photo_view', function () {

            const id = $(this).attr('data-id');

            $.ajax({
                url: `/our-programs/${id}`,
                type: "GET",
                success: function (response) {

                    $('#modal-program-title').text(response.name);
                    $('#modal-program-description').html(response.description);

                    let image = response.file;
                    // Check if image is website url and not folder
                    if (image.includes('https://')) {
                        image = response.file;
                    } else {
                        // If folder, then add the storage folder path
                        image = `/storage${response.file}`;
                    }

                    $("#modal-program-img").attr("src", image);  // Append Image

                },
                error: function (err) {
                    // Show another error message
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: "Something went wrong! Please try again later",
                    });
                },
            });

        });
    </script>
@endsection
