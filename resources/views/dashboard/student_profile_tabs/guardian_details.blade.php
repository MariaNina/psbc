<form id="guardian_info_form" method="POST">

    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" name="last_name"
               placeholder="eg. Rizal" value="{{ $user->student->guardian->last_name }}"/>
    </div>

    <div class="form-group">
        <label for="middle_name">Middle Name</label>
        <input type="text" class="form-control" name="middle_name"
               placeholder="eg. Protacio" value="{{ $user->student->guardian->middle_name }}"/>
    </div>

    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" name="first_name"
               placeholder="eg. Jose" value="{{ $user->student->guardian->first_name }}"/>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pt-3">
                <h5>Other Info</h5>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="address">Complete Address</label>
        <textarea class="form-control form-control-textarea" name="address" rows="3"
                  placeholder="eg. 7114 Kundiman Street, Sampaloc...">{{ $user->student->guardian->address }}</textarea>
    </div>

    <div class="form-group">
        <label for="contact_number">Mobile No.</label>
        <input type="text" class="form-control" name="contact_number"
               placeholder="eg. +63-2-8123-4567" value="{{ $user->student->guardian->contact_number }}"/>
    </div>

    <hr/>
    <button class="btn btn-sm btn-secondary text-white px-3 py-1" type="submit">Save Changes</button>

</form>
