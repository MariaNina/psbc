<form id="adress_details_form" method="POST">

    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="address">Complete Address</label>
        <textarea class="form-control form-control-textarea" name="address" id="address" rows="3"
                  placeholder="eg. 7114 Kundiman Street, Sampaloc...">{{ $user->student->address }}</textarea>
    </div>

    <div class="form-group">
        <label for="contact_number">Mobile No.</label>
        <input type="text" class="form-control" name="contact_number" id="contact_number"
               placeholder="eg. +63-2-8123-4567" value="{{ $user->student->contact_number }}"/>
    </div>

    <hr/>
    <button class="btn btn-sm btn-secondary text-white px-3 py-1" type="submit">Save Changes</button>

</form>
