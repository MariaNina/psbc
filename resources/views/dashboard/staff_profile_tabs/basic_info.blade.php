<form id="basic_info_form" method="POST">

    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" name="last_name" id="last_name"
               placeholder="eg. Rizal" value="{{ $user->staff->last_name }}"/>
    </div>

    <div class="form-group">
        <label for="middle_name">Middle Name</label>
        <input type="text" class="form-control" name="middle_name" id="middle_name"
               placeholder="eg. Protacio" value="{{ $user->staff->middle_name }}"/>
    </div>

    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" name="first_name" id="first_name"
               placeholder="eg. Jose" value="{{ $user->staff->first_name }}"/>
    </div>

    <div class="form-group">
        <label for="extension_name">Extension Name (if any)</label>
        <input type="text" class="form-control" name="extension_name" id="extension_name"
               placeholder="eg. John" value="{{ $user->staff->extension_name }}"/>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pt-3">
                <h5>Other Info</h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="Male" {{ $user->staff->gender == "Male" ? 'selected' : null }}>Male</option>
                    <option value="Female" {{ $user->staff->gender == "Female" ? 'selected' : null }}>Female</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="civil_status">Civil Status</label>
                <select class="form-control" name="civil_status" id="civil_status">
                    <option value="Single" {{ $user->staff->civil_status == "Single" ? 'selected' : null }}>Single
                    </option>
                    <option value="Married" {{ $user->staff->civil_status == "Married" ? 'selected' : null }}>Married
                    </option>
                    <option value="Separated" {{ $user->staff->civil_status == "Separated" ? 'selected' : null }}>
                        Separated
                    </option>
                    <option value="Widowed" {{ $user->staff->civil_status == "Widowed" ? 'selected' : null }}>Widowed
                    </option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="birth_day">Birth Day</label>
                <input type="date" class="form-control" name="birth_day" id="birth_day"
                       value="{{ $user->staff->birth_day }}"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="birth_place">Birth Place</label>
                <input type="text" class="form-control" name="birth_place" id="birth_place"
                       placeholder="eg. Manila Hospital..." value="{{ $user->staff->birth_place }}"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="height_m">Height</label>
                <input type="text" class="form-control" name="height_m" id="height_m" placeholder="eg. 160cm"
                       value="{{ $user->staff->height_m }}"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="weight_kg">Weight (kg)</label>
                <input type="text" class="form-control" name="weight_kg" id="weight_kg"
                       placeholder="eg. 50kg" value="{{ $user->staff->weight_kg }}"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="citizenship">Citizenship</label>
                <input type="text" class="form-control" name="citizenship" id="citizenship"
                       placeholder="eg. Filipino..." value="{{ $user->staff->citizenship }}"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="blood_type">Blood Type</label>
                <select class="form-control" name="blood_type" id="blood_type">
                    <option value="A" {{ $user->staff->blood_type == "A" ? 'selected' : null }}>A</option>
                    <option value="B" {{ $user->staff->blood_type == "B" ? 'selected' : null }}>B</option>
                    <option value="AB" {{ $user->staff->blood_type == "AB" ? 'selected' : null }}>AB</option>
                    <option value="O" {{ $user->staff->blood_type == "0" ? 'selected' : null }}>O</option>
                </select>
            </div>
        </div>
    </div>

    <hr/>
    <button class="btn btn-sm btn-secondary text-white px-3 py-1" type="submit">Save Changes</button>

</form>
