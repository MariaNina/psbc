{{-- EDIT MODAL --}}
<div
    class="modal fade event_modal"
    id="editTimeSettingsModal"
    role="dialog"
    aria-hidden="true"
>
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span id="edit_branch_badge" class="badge badge-info"></span>
                    Modify Settings
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
                <form id="editTimeSettingsForm" role="form" data-toggle="validator" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="staff_name">Staff Name</label>
                        <input type="text" class="form-control" name="staff_name" id="staff_name"
                               value="" disabled readonly/>
                    </div>

                    <div class="form-group">
                        <label for="morning_in">Morning In</label>
                        <input type="time" class="form-control" name="morning_in" id="morning_in" value=""/>
                    </div>

                    <div class="form-group">
                        <label for="morning_out">Morning Out</label>
                        <input type="time" class="form-control" name="morning_out" id="morning_out" value=""/>
                    </div>

                    <div class="form-group">
                        <label for="afternoon_in">Afternoon In</label>
                        <input type="time" class="form-control" name="afternoon_in" id="afternoon_in" value=""/>
                    </div>

                    <div class="form-group">
                        <label for="afternoon_out">Afternoon Out</label>
                        <input type="time" class="form-control" name="afternoon_out" id="afternoon_out" value=""/>
                    </div>

                    <div class="form-group">
                        <label for="days">Days</label>
                        <select name="days[]" id="days" class="select2 form-control" multiple>
                            <option value="MON">Monday</option>
                            <option value="TUE">Tuesday</option>
                            <option value="WED">Wednesday</option>
                            <option value="THU">Thursday</option>
                            <option value="FRI">Friday</option>
                            <option value="SAT">Saturday</option>
                            <option value="SUN">Sunday</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="required_time">Shift Hours</label>
                        <input type="text" class="form-control" name="required_time" id="required_time"
                               value=""/>
                    </div>

                    <button id="btn" type="submit" class="btn btn-info float-right">Update</button>
                </form>

            </div>
        </div>
    </div>
</div>
