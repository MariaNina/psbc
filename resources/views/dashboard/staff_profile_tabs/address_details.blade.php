<form id="adress_details_form" method="POST">

    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="address">Complete Address</label>
        <textarea class="form-control form-control-textarea" name="address" id="address" rows="3"
                  placeholder="eg. 7114 Kundiman Street, Sampaloc...">{{ $user->staff->address }}</textarea>
    </div>

    <div class="form-group">
        <label for="zip_code">Zipcode</label>
        <input type="text" class="form-control" name="zip_code" id="zip_code"
               placeholder="eg. 4013" value="{{ $user->staff->zip_code }}"/>
    </div>

    <div class="form-group">
        <label for="telephone_number">Telephone No.</label>
        <input type="text" class="form-control" name="telephone_number" id="telephone_number"
               placeholder="eg. 02-8123-4567" value="{{ $user->staff->telephone_number }}"/>
    </div>

    <div class="form-group">
        <label for="telephone_number">Mobile No.</label>
        <input type="text" class="form-control" name="mobile_number" id="mobile_number"
               placeholder="eg. +63-2-8123-4567" value="{{ $user->staff->mobile_number }}"/>
    </div>

    <hr/>
    <button class="btn btn-sm btn-secondary text-white px-3 py-1" type="submit">Save Changes</button>

</form>
