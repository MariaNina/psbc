@extends('landing.layouts.app')

@section('title')
    Announcements
@endsection

@section('content')
    <!-- ALL EVENTS -->

    <header id="page-header" class="p-5">
        <div class="bg-overlay">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="container pt-5 text-center">
                            <h1 class="text-uppercase">Announcements</h1>
                            <p>Find all the announcements here and not miss everything</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ALL EVENTS SECTION -->
    <div class="row justify-content-center mt-5 mb-3">
        <div>
            <h3 class="p-2 text-center text-dark text-uppercase font-weight-bold">ALL ANNOUNCEMENTS</h3>
            <div class="line"></div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-4">
                <form id="show_all_announcement_form" action="{{ route('announcements.index') }}" method="GET">

                    <label class="mb-0 small" for="search">Filter by search:</label>
                    <div class="input-group m-0 mb-3">
                        <input type="text" name="search" class="form-control    " placeholder="Search..."
                               aria-label="search announcement"
                               value="{{ empty($_GET['search']) ? null : trim($_GET['search']) }} ">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="button-addon2">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="m-0 small" for="branch_filter">Filter by branch:</label>
                        <select class="branch_filter form-control m-0" name="branch_filter">
                            <option class="text-dark"
                                    value="All"
                                {{  empty($_GET['branch_filter']) || $_GET['branch_filter'] == "All" ? 'selected' : null }}>
                                All
                            </option>
                            @forelse($branches as $branch)
                                <option class="text-dark"
                                        value="{{ $branch->id }}"
                                    {{  !empty($_GET['branch_filter']) && $_GET['branch_filter'] == $branch->id ? 'selected' : null }}>
                                    {{ $branch->branch_name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Events --}}
    <div class="container">
        <div class="row mb-5">
            @forelse($announcements as $announcement)
                <div class="col-md-6 mb-5 pb-2">
                    <a href="{{ route('announcements.show', $announcement->id ) }}">
                        <img class="w-100"
                             height="330"
                             src="{{ $announcement->announcementImage() }}"
                             alt="event-{{ $loop->iteration }}">
                    </a>
                    <div class="d-flex align-items-center justify-content-start mt-3">
                        <div class="text-start">
                            <h4 class="text-dark">{{ $announcement->announcement_title }}</h4>
                            <a href="{{ route('announcements.show', $announcement->id ) }}"
                               class="btn btn-danger text-white">
                                Read More
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 mb-4">
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <i class="fas fa-frown fa-3x text-dark mr-3 d-none d-lg-block"></i>
                        <span class="text-orange text-uppercase text-dark font-3">No Announcements Currently</span>
                    </div>
                </div>
            @endforelse
        </div>

        {{--  Pagination --}}
        <div class="d-flex justify-content-center align-items-center align-content-center">
            {{ $announcements->links('pagination::bootstrap-4') }}
        </div>
    </div>

@endsection

@section('extra-js')
    <script>
        $('.branch_filter').on('change', function () {
            $('#show_all_announcement_form').submit();
        });
    </script>
@endsection
