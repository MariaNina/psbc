@extends('dashboard.layouts.main')

@section('title')
    Grades
@endsection

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">View Grades</h1>
    </div>

    <div class="row">

        <div class="col-lg-12">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table cust-datatable" width="100%" id="filtertable" cellspacing="0">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Subject Name</th>
                                @if($canShow)
                                    <th>Grade</th>
                                @endif
                                <th>Grade Status</th>
                            </tr>
                            </thead>
                            <tbody>
                        @if(!empty($enrollment->grades))
                            @forelse($enrollment->grades as $grades)
                                <tr>
                                    <td>{{ $grades->No }}</td>
                                    <td>
                                        {{ $grades->subjects->subject_code }}
                                        :
                                        {{ $grades->subjects->subject_name }}
                                    </td>
                                    @if($canShow)
                                        <td>
                                            {{ $isCollege ? $grades->student_grade['point_equivalent'] : $grades->grade }}
                                        </td>
                                    @endif
                                    <td>
                                        <span
                                            class="mode @if($grades->student_grade['msg'] == "Passed")
                                                mode_on
                                                @elseif($grades->student_grade['msg'] == "Failed")
                                                mode_danger
                                                @else
                                                mode_off
                                            @endif">
                                            {{ $grades->student_grade['msg'] }}
                                        </span>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $canShow ? '4' : '3' }}">No data available in table</td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="{{ $canShow ? '4' : '3' }}">No data available in table</td>
                            </tr>
                        @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@section('extra-js')
    {{--    <script src="{{ asset('js/datatable-scripts/student_grade.js') }}"></script>--}}
@endsection
