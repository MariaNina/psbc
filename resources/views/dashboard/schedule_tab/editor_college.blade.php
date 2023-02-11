<input type="hidden" value="{{ $subject->id }}" class="room_no"/>
<form id="ScheduleForm_{{$subject->id}}" role="form">
    @csrf

    <input type="hidden" value="{{ $sy->id }}" name="sy"/>
    <input type="hidden" value="{{ $subject->id }}" name="subject_id"/>

    <div class="d-flex justify-content-between h-100 align-items-center">
        <div>
            <h5 id="subject_name_{{$subject->id}}">{{ $subject->subject_name }}</h5>
        </div>
        {{--        <div class="form-group">--}}
        {{--            <label for="department{{ $subject->id }}">Department</label>--}}
        {{--            <select required name="department" id="department{{ $subject->id }}"--}}
        {{--                    class="form-control js-example-basic-single dept">--}}
        {{--                <option value="" disabled selected>Choose...</option>--}}
        {{--                <option value="SHS">SHS</option>--}}
        {{--                <option value="College">College/Graduate Studies</option>--}}
        {{--            </select>--}}
        {{--        </div>--}}

        {{--        <div class="form-group">--}}
        {{--            <label>Term</label>--}}
        {{--            <select required name="term" id="term"--}}
        {{--                    class="form-control js-example-basic-single">--}}
        {{--                @if($terms->count() > 0)--}}
        {{--                    @foreach($terms as $term)--}}
        {{--                        <option--}}
        {{--                            value="{{ $term->id }}" {{ $loop->first ? 'selected' : '' }}>{{ $term->term_name }}</option>--}}
        {{--                    @endforeach--}}
        {{--                @endif--}}
        {{--            </select>--}}
        {{--        </div>--}}


    </div>


    <div class="table-responsive">
        <table class="table cust-datatable" id="filtertable_{{$subject->id}}" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>Time</th>
                <th>Days</th>
                <th>Section</th>
                <th>
                    <select class="form-control filter-select" data-column="3">
                        @if($staffs->count() > 0)
                            <option value="">All Teachers</option>
                            @foreach($staffs as $staff)
                                <option
                                    value="{{ $staff->last_name }}">{{ $staff->last_name }} {{ $staff->first_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </th>
                <th>Room</th>
                <th>Term</th>
                <th>
                    <button type="button" id="addRow_{{ $subject->subject_code }}" class="btn btn-success addInput">
                        <i class="fas fa-plus"></i>
                    </button>
                </th>
            </tr>
            </thead>
            <input type="hidden" id="sub_{{$subject->id}}" value="subject_id" name="subjectId">
            <tbody id="inputBody_{{$subject->id}}">

            </tbody>
        </table>
    </div>
    <button class="btn btn-sm btn-secondary text-white px-3 py-1 mt-3 float-right mr-4 subm"
            id="submitBtn_{{$subject->id}}"
            type="submit">Save Changes
    </button>

</form>


