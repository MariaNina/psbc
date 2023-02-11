<input type="hidden" value="{{$room->room_no}}" class="room_no"/>
<form id="ScheduleForm{{$room->room_no}}" role="form">
    @csrf
    <input type="hidden" value="{{$schoolYears->id}}" name="sy"/>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="department{{$room->room_no}}">Department</label>
                <select required name="department" id="department{{$room->room_no}}"
                        class="form-control js-example-basic-single dept">
                    <option value=""></option>
                    <option value="Elementary">Elementary</option>
                    <option value="JHS">JHS</option>
                    <option value="SHS">SHS</option>
                </select>
            </div>
        </div>

        {{-- <div class="col-sm-4">
            <div class="form-group">
        <label for="term{{$room->room_no}}">Term</label>
        <select required name="term" id="term{{$room->room_no}}" class="form-control js-example-basic-single">
        <option value=""></option>
        @foreach ($terms as $term)
            <option value="{{$term->id}}">{{$term->term_name}}</option>
        @endforeach
        </select>
        </div>
        </div> --}}

    </div>

    <div class="table-responsive">
        <table class="table cust-datatable" id="filtertable{{$room->room_no}}" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th class="all">Time</th>
                <th class="all">Days</th>
                <th class="all">Section</th>
                <th class="">Subject</th>
                <th class="">
                    <select class="form-control filter-select" data-column="4">

                        @if($staffs->count() > 0)
                            <option value="">All Teachers</option>
                            @foreach($staffs as $staff)
                                <option
                                    value="{{ $staff->last_name }}">{{ $staff->last_name }} {{ $staff->first_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </th>
                <th class="">Room</th>
                <th class="all">
                    <button type="button" id="addRow{{$room->room_no}}" class="btn btn-primary addInput"><i
                            class="fas fa-plus"></i></button>
                </th>
            </tr>
            </thead>
            <input type="hidden" id="roomNumber{{$room->room_no}}" value="{{$room->id}}" name="roomNumber">
            <tbody id="inputBody{{$room->room_no}}">
            </tbody>
        </table>
    </div>
    <button class="btn btn-success float-right mr-4 subm" id="submitBtn{{$room->room_no}}" type="submit">Submit</button>
</form>


