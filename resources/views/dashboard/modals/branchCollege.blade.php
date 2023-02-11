<!-- Add Branch Modal-->

<div
    class="modal fade"
    id="addBranchCollegeModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Assign Branch College
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
                <form id="BranchCollgeForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="branchName">Select Branch</label>
						<select style="width: 100%; padding:5px; font-size:28px;" name="branchName" id="branchName" class="js-example-basic-single form-control">
                            <option></option>
                            @foreach ($branches as $branch)
                                <option value=" {{$branch->id}}">{{$branch->branch_name}}</option>
                            @endforeach
                        </select>
					  </div>

                      <div class="form-group">
						<label for="collegeName">Select College</label>
						<select style="width: 100%; padding:5px; font-size:28px;" name="collegeName" id="collegeName" class="js-example-basic-single form-control">
                            <option></option>
                            @foreach ($colleges as $college)
                                <option value=" {{$college->id}}">{{$college->college_name}}</option>
                            @endforeach
                        </select>
					  </div>

                      <div class="form-group">
						<label for="programMajor">Assign Program Major</label>
						<select style="width: 100%; padding:5px; font-size:28px;" name="programMajor" id="programMajor" class="js-example-basic-single form-control">
                            <option></option>
                            @foreach ($programMajors as $programMajor)
                                <option value=" {{$programMajor->id}}">{{$programMajor->program_name}} {{$programMajor->major_name}}</option>
                            @endforeach
                        </select>
					  </div>

                              <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Update Branch Modal --}}

<div
    class="modal fade"
    id="editBranchCollegeModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Edit Branch College
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
                <form id="upBranchCollgeForm" role="form" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="upbranchName">Select Branch</label>
						<select style="width: 100%; padding:5px; font-size:28px;" name="branchName" id="upbranchName" class="js-example-basic-single form-control">
                            <option></option>
                            @foreach ($branches as $branch)
                                <option value=" {{$branch->id}}">{{$branch->branch_name}}</option>
                            @endforeach
                        </select>
					  </div>

                      <div class="form-group">
						<label for="upcollegeName">Select College</label>
						<select style="width: 100%; padding:5px; font-size:28px;" name="collegeName" id="upcollegeName" class="js-example-basic-single form-control">
                            <option></option>
                            @foreach ($colleges as $college)
                                <option value=" {{$college->id}}">{{$college->college_name}}</option>
                            @endforeach
                        </select>
					  </div>

                      <div class="form-group">
						<label for="upprogramMajor">Assign Program Major</label>
						<select style="width: 100%; padding:5px; font-size:28px;" name="programMajor" id="upprogramMajor" class="js-example-basic-single form-control">
                            <option></option>
                            @foreach ($programMajors as $programMajor)
                                <option value=" {{$programMajor->id}}">{{$programMajor->program_name}} {{$programMajor->major_name}}</option>
                            @endforeach
                        </select>
					  </div>

                              <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>