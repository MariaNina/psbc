<!-- Schedule Modal-->
{{--EDIT SECTION MODAL--}}
<div
    class="modal fade"
    id="editScheduleModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Schedule
                </h5>
                <button
                    class="close"
                    type="button"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editScheduleForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input id="subject" name="subject" disabled type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="teacher">Teacher</label>
                        <select name="teacher" id="teacher" class="js-example-basic-single float-right">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                    <div class="form-group">
                        <label for="room">Room</label>
                        <select name="room" id="room" class="js-example-basic-single float-right">
                            <option value=""></option>
                        </select>
                    </div>
                        </div>
                        <div class="col-sm-6">
                    <div class="form-group">
                        <label for="days">Days</label><br/>
                        M <input value="m" id="day1" type="checkbox" style="transform: scale(1.5);" name="day1">
                        T <input value="t" id="day2" type="checkbox" style="transform: scale(1.5);" name="day2">
                        W <input value="w" id="day3" type="checkbox" style="transform: scale(1.5);" name="day3">
                        TH <input value="th" id="day4" type="checkbox" style="transform: scale(1.5);" name="day4">
                        F <input value="f" id="day5" type="checkbox" style="transform: scale(1.5);" name="day5">
                        S <input value="s" id="day6" type="checkbox" style="transform: scale(1.5);" name="day6">
                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="startTime">Start Time</label>
                                <input type="time" name="startTime" id="startTime" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="endTime">Start Time</label>
                                <input type="time" id="endTime" name="endTime" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>


