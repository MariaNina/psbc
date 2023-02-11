<form id="basic_info_form" method="POST">

    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" name="last_name" id="last_name"
               placeholder="eg. Rizal" value="{{ $user->student->last_name }}"/>
    </div>

    <div class="form-group">
        <label for="middle_name">Middle Name</label>
        <input type="text" class="form-control" name="middle_name" id="middle_name"
               placeholder="eg. Protacio" value="{{ $user->student->middle_name }}"/>
    </div>

    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" name="first_name" id="first_name"
               placeholder="eg. Jose" value="{{ $user->student->first_name }}"/>
    </div>

    <div class="form-group">
        <label for="suffix_name">Extension Name (if any)</label>
        <input type="text" class="form-control" name="suffix_name" id="suffix_name"
               placeholder="eg. John" value="{{ $user->student->extension_name }}"/>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pt-3">
                <h5>Other Info</h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="Male" {{ $user->student->gender == "Male" ? 'selected' : null }}>Male</option>
                    <option value="Female" {{ $user->student->gender == "Female" ? 'selected' : null }}>Female</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="civil_status">Civil Status</label>
                <select class="form-control" name="civil_status" id="civil_status">
                    <option value="Single" {{ $user->student->civil_status == "Single" ? 'selected' : null }}>Single
                    </option>
                    <option value="Married" {{ $user->student->civil_status == "Married" ? 'selected' : null }}>Married
                    </option>
                    <option value="Separated" {{ $user->student->civil_status == "Separated" ? 'selected' : null }}>
                        Separated
                    </option>
                    <option value="Widowed" {{ $user->student->civil_status == "Widowed" ? 'selected' : null }}>Widowed
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="citizenship">Citizenship</label>
                <input type="text" class="form-control" name="citizenship" id="citizenship"
                       placeholder="eg. Manila Hospital..." value="{{ $user->student->citizenship }}"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="birth_day">Birth Day</label>
                <input type="date" class="form-control" name="birth_day" id="birth_day"
                       value="{{ $user->student->birth_day }}"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="birth_place">Birth Place</label>
                <input type="text" class="form-control" name="birth_place" id="birth_place"
                       placeholder="eg. Manila Hospital..." value="{{ $user->student->birth_place }}"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="religion">Religion</label>
                <input type="text" class="form-control" name="religion" id="religion"
                       placeholder="eg. Manila Hospital..." value="{{ $user->student->religion }}"/>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="lrn">#LRN</label>
        <input type="text" class="form-control" name="lrn" id="lrn"
               placeholder="eg. Manila Hospital..." value="{{ $user->student->lrn }}"/>
    </div>

    <hr/>
    <button class="btn btn-sm btn-secondary text-white px-3 py-1" type="submit">Save Changes</button>

</form>
