<form id="other_card_details_form" method="POST">

    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="staff_type">Staff Type</label>
                <select class="form-control" name="staff_type" id="staff_type">
                    <option value="Admin" {{ $user->staff->staff_type == "Admin" ? 'selected' : null }}>Admin</option>
                    <option value="Academic" {{ $user->staff->staff_type == "Academic" ? 'selected' : null }}>Academic
                    </option>
                    <option value="Janitor/Guard" {{ $user->staff->staff_type == "Janitor/Guard" ? 'selected' : null }}>
                        Janitor/Guard
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" class="form-control" name="position" id="position"
                       placeholder="eg. Your position" value="{{ $user->staff->position }}"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" class="form-control" name="department" id="department"
                       placeholder="eg. Department of ..." value="{{ $user->staff->Department }}"/>

                <div class="form-group form-check mt-2">
                    <input type="checkbox" class="form-check-input" name="is_masteral"
                           id="is_masteral" {{ $user->staff->is_masteral == 1 ? 'checked' : null }} />
                    <label class="form-check-label" for="exampleCheck1">Is Masteral</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <hr/>
        </div>
    </div>

    <div class="form-group">
        <label for="agency_employee_no">Agency Employee No.</label>
        <input type="text" class="form-control" name="agency_employee_no" id="agency_employee_no"
               placeholder="eg. 12345678901" value="{{ $user->staff->agency_employee_no }}"/>
    </div>

    <div class="form-group">
        <label for="tin">TIN</label>
        <input type="text" class="form-control" name="tin" id="tin"
               placeholder="eg. 12345678901" value="{{ $user->staff->tin }}"/>
    </div>

    <div class="form-group">
        <label for="gisis">GISIS</label>
        <input type="text" class="form-control" name="gisis" id="gisis"
               placeholder="eg. 12345678901" value="{{ $user->staff->gisis }}"/>
    </div>

    <div class="form-group">
        <label for="sss">SSS</label>
        <input type="text" class="form-control" name="sss" id="sss"
               placeholder="eg. 123-4567-8901" value="{{ $user->staff->sss }}"/>
    </div>

    <div class="form-group">
        <label for="phil_health">Philhealth</label>
        <input type="text" class="form-control" name="phil_health" id="phil_health"
               placeholder="eg. 02-8123-4567" value="{{ $user->staff->phil_health }}"/>
    </div>

    <hr/>
    <button class="btn btn-sm btn-secondary text-white px-3 py-1" type="submit">Save Changes</button>

</form>
