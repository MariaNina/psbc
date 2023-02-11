<!-- Edit Staff Modal-->
<div
    class="modal fade"
    id="editStaffModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
<div class="alert alert-danger" id="staffError">
    <span id="errorMessage"></span>
</div>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Employee Information
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
                <form id="editStaffForm" enctype="multipart/form-data" role="form"  data-toggle="validator">
                    @csrf
                    <div class="row">
                        <div class="col-sm-4  border-right">
                            <img src="" width="200" height="200" id="profile_pic" />
                            <div class="form-group">
                                <label class="form-label" for="staffImage">Add Picture</label>
                                <input type="file" class="form-control-file" id="staffImage" name="staffImage" value="">
                                <small class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>
                            </div>
                    <div class="form-group">
                      <label for="firstName">First Name</label>
                      <input type="text" required name="firstName" id="firstName" class="form-control"  placeholder="eg. Juan,Pedro,Angel">
                    </div>
                    <div class="form-group">
                        <label for="middleName">Middle Name</label>
                        <input type="text" required name="middleName" id="middleName" class="form-control"  placeholder="eg. Fadul,Calma,Cabit,Romulo">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" required name="lastName" id="lastName" class="form-control"  placeholder="eg. Fadul,Calma,Cabit,Romulo">
                    </div>
                    <div class="form-group">
                        <label for="extensionName">Extension Name</label>
                        <input type="text" name="extensionName" id="extensionName" class="form-control"  placeholder="eg. Jr., Sr., III">
                    </div>
                    <div class="form-group">
                        <label for="cscNumber">Employee Number</label>
                        <input type="text" name="cscNumber" id="cscNumber" class="form-control"  placeholder="eg. 2009-001">
                    </div>
                    <div class="form-group">
						<label for="employmentType">Employee Type</label>
						<select style="width: 100%; padding:2px; font-size:18px;" name="employmentType" id="employmentType" class="js-example-basic-single form-control">
                            <option></option>
                            <option value="Admin">Admin</option>
                            <option value="Academic">Academic</option>
                            <option value="Janitor/Guard">Janitor/Guard</option>
                        </select>
					</div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" name="position" id="position" class="form-control"  placeholder="eg. Teacher, Secretary, Auditor">
                    </div>
                    <div class="form-group">
                        <label for="department">Department</label>
                        <input type="text" name="department" id="department" class="form-control"  placeholder="eg. Elementary,CBMA,JHS,SHS">
                    </div>
                        </div>
                        <div class="col-sm-4 border-right">
                            <div class="form-group">
                                <label for="bio_id">Biometric Id</label>
                                <input type="number" name="bio_id" id="bio_id" class="form-control"  placeholder="eg. Elementary,CBMA,JHS,SHS">
                            </div>
                            <div class="form-group">
                                <label for="majorIn">Major In</label>
                                <select style="width: 100%; padding:2px; font-size:18px;" name="majorIn" id="majorIn" class="js-example-basic-single form-control">
                                    <option></option>
                                @foreach ($majors as $major)
                                    <option value="{{$major}}">{{$major->subject_name}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="isMasteral">Is Masteral</label>
                                <select style="width: 100%; padding:2px; font-size:18px;" name="isMasteral" id="isMasteral" class="js-example-basic-single form-control">
                                    <option></option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="licenseNumber">License Number</label>
                                <input type="text" name="licenseNumber" id="licenseNumber" class="form-control"  placeholder="eg. 10021221222">
                            </div>
                            <div class="form-group">
                                <label for="birthday">Date of Birth</label>
                                <input type="date" name="birthday" id="birthday" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="birthPlace">Place of Birth</label>
                                <textarea name="birthPlace" id="birthPlace" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select style="width: 100%; padding:2px; font-size:18px;" name="gender" id="gender" class="js-example-basic-single form-control">
                                    <option></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group">
                                <label for="civilStatus">Civil Status</label>
                                <select style="width: 100%; padding:2px; font-size:18px;" name="civilStatus" id="civilStatus" class="js-example-basic-single form-control">
                                    <option></option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Separated">Separated</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="height">Height(cm)</label>
                                <input type="number" name="height" id="height" class="form-control" placeholder="eg. 142,144,150" >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="weight">Weight(kg)</label>
                                <input type="number" name="weight" id="weight" class="form-control" placeholder="eg. 50,70,80" >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="bloodType">Blood Type</label>
                                <select style="width: 100%; padding:2px; font-size:18px;" name="bloodType" id="bloodType" class="js-example-basic-single form-control">
                                    <option></option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="gsis">GSIS Id Number</label>
                            <input type="text" name="gsis" id="gsis" class="form-control">
                        </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="sss">SSS Id Number</label>
                                <input type="text" name="sss" id="sss" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="philHealth">PhilHealth Id Number</label>
                                <input type="text" name="philHealth" id="philHealth" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pagibig">Pag-ibig Id Number</label>
                                <input type="text" name="pagibig" id="pagibig" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="tin">TIN Id Number</label>
                                <input type="text" name="tin" id="tin" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="agencyNumber">Agency Employee Number</label>
                                <input type="text" name="agencyNumber" id="agencyNumber" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="citizenship">Citizenship</label>
                                <input type="text" name="citizenship" id="citizenship" class="form-control" placeholder="eg. Filipino">
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-4">
                        <div class="form-group">
                            <label for="zipCode">Zip Code</label>
                            <input type="number" name="zipCode" id="zipCode" class="form-control" placeholder="eg. 4016">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                    <div class="form-group">
                        <label for="telNumber">Telephone Number</label>
                        <input type="text" name="telNumber" id="telNumber" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mobileNumber">Mobile Number</label>
                        <input type="text" name="mobileNumber" id="mobileNumber" class="form-control">
                    </div>
                </div>
                </div>
                        </div>
                    
                </div>
                <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
