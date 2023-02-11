@extends('dashboard.layouts.main')

@section('title')
    Schedule
@endsection

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Schedule</h1>
        <small class="text-dark font-weight-bold small">Current Sy: {{$latestSy->school_years}}</small>
    </div>

    <div class="row">

        <div class="col-lg-12">

            <!-- First Term Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-warning">1st Term</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table cust-datatable" width="100%" id="filtertable" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="all">Subject Code</th>
                                <th>Title</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Room</th>
                                <th>Instructor</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (!empty($firstTerm) && $firstTerm->count() > 0 && $hasFirstTerm)
                                @forelse($firstTerm as $sched)
                                    <tr>
                                        <td>{{ $sched->subject->subject_code }}</td>
                                        <td>{{ $sched->subject->subject_name }}</td>
                                        <td>{{ $sched->formated_days }}</td>
                                        <td>
                                            {{ $sched->start_class }} - {{ $sched->end_class }}
                                        </td>
                                        <td>Room {{ $sched->room->room_no }} </td>
                                        <td>
                                            {{ $sched->instructor->first_name }}
                                            {{ $sched->instructor->last_name }}
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="6">No records found</td>
                                @endforelse
                            @else
                                <td colspan="6">No records found</td>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(!$isKto10 && $hasSecondTerm)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-warning">2nd Term</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table cust-datatable" width="100%" id="filtertable" cellspacing="0">
                                <thead>
                                <tr>
                                    <th class="all">Subject Code</th>
                                    <th>Title</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Room</th>
                                    <th>Instructor</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (!is_null($secondTerm->count() > 0))
                                    @forelse($secondTerm as $sched)
                                        <tr>
                                            <td>{{ $sched->subject->subject_code }}</td>
                                            <td>{{ $sched->subject->subject_name }}</td>
                                            <td>{{ $sched->formated_days }}</td>
                                            <td>
                                                {{ $sched->start_class }} - {{ $sched->end_class }}
                                            </td>
                                            <td>Room {{ $sched->room->room_no }} </td>
                                            <td>
                                                {{ $sched->instructor->first_name }}
                                                {{ $sched->instructor->last_name }}
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="6">No records found</td>
                                    @endforelse
                                @else
                                    <td colspan="6">No records found</td>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- For Summer --}}
            @if(!empty($summer) && $summer->count() > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-warning">Summer</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table cust-datatable" width="100%" id="filtertable" cellspacing="0">
                                <thead>
                                <tr>
                                    <th class="all">Subject Code</th>
                                    <th>Title</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Room</th>
                                    <th>Instructor</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($summer as $sched)
                                    <tr>
                                        <td>{{ $sched->subject->subject_code }}</td>
                                        <td>{{ $sched->subject->subject_name }}</td>
                                        <td>{{ $sched->formated_days }}</td>
                                        <td>
                                            {{ $sched->start_class }} - {{ $sched->end_class }}
                                        </td>
                                        <td>Room {{ $sched->room->room_no }} </td>
                                        <td>
                                            {{ $sched->instructor->first_name }}
                                            {{ $sched->instructor->last_name }}
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="6">No records found</td>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>


    @include('dashboard.modals.subjectModal')

@endsection

@section('extra-js')

@endsection
