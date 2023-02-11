@extends('dashboard.layouts.main')

@section('title')
    Schedule for College
@endsection

@section('content')
    <!-- Content Row -->

    <div class="row">

        <div class="col-lg-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-lg-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-dark">
                            <a class="d-none d-sm-inline-block btn btn-sm btn-light shadow-sm"
                               href="{{redirect()->back()->getTargetUrl()}}">
                                <i class="fas fa-arrow-left font-lg fa-lg text-dark-50"></i>
                            </a>
                            Scheduler
                        </h6>
                    </div>
                </div>
                <div class="card-body">

                    <div class="mb-4">
                        <h3>{{$branch->branch_name}} College Schedule</h3>

                        <div class="mb-4">


                            <ul class="nav nav-tabs">
                                @foreach($subjects as $i => $subject)
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           id="{{ $subject->id }}"
                                           href="#subject_{{$subject->id}}">
                                            {{ $subject->subject_code }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>


                        </div>

                        <div class="tab-content" id="collge_sched">

                            @foreach($subjects as $i => $subject)
                                <div id="subject_{{$subject->id}}"
                                     class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @include('dashboard.schedule_tab.editor_college')
                                        </div>
                                    </div>

                                </div>

                            @endforeach


                        </div>
                    </div>
                </div>
            </div>

            @endsection

            @section('extra-js')
                <script>
                    $(document).ready(function () {
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                        });
                    });
                </script>
                <script src="{{ asset('js/datatable-scripts/schedule_college.js') }}"></script>
                <script src="{{ asset('js/form-scripts/schedule_college.js') }}"></script>
@endsection
