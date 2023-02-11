<!-- Add User and Staff Modal-->
<div
    class="modal fade"
    id="addUserModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
<div class="alert alert-danger" id="userError">
    <span id="errorMessage"></span>
</div>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New User
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
                <form id="addUserForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="row">
                    <div class="col-sm-4">
                    <div class="form-group">
                      <label for="firstName">First Name</label>
                      <input type="text" required name="firstName" id="firstName" class="form-control"  placeholder="eg. Jose,Bonifacio,Marilou">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="middleName">Middle Name</label>
                        <input type="text" required name="middleName" id="middleName" class="form-control"  placeholder="eg. Rizal,Fadul,Calma">
                      </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" required name="lastName" id="lastName" class="form-control"  placeholder="eg. Cabit,Romulo,Santos">
                      </div>
                </div>
                @if(session('user')->id===1)
                <div class="col-sm-4">
                      <div class="form-group">
                        <label for="branchName">Branch</label>
                        <select style="width: 100%; padding:2px; font-size:18px;" name="branchName" id="branchName" class="select2 form-control">
                            <option value=""></option>
                            @foreach ($branches as $branch )
                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
            <div class="col-sm-4">
            <div class="form-group">
                <label for="branchName1">Branch</label>
                <input type="text" readonly value="{{$branches->branch_name}}" id="branchName1" class="form-control">
                <input type="hidden" value="{{$branches->id}}" name="branchName" id="branchName" class="form-control">
            </div>
            </div>
            @endif
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="roleName">Role</label>
                        <select style="width: 100%; padding:2px; font-size:18px;" name="roleName" id="roleName" class="select2 form-control">
                            <option value=""></option>
                            @foreach ($roles as $role )
                            <option value="{{$role->id}}">{{$role->role_name}}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="username">User Name</label>
                        <input type="text" required name="username" id="username" class="form-control"  placeholder="eg. psbc_gemmacalma">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" required name="email" id="email" class="form-control"  placeholder="eg. psbc@gmail.com">
                    </div>
                </div>
                <div class="col-sm-8 border-left">
                    <label for="permission">User Permission - Note: you can select Multiple Permissions</label>
                    <select name="permission[]" id="permission" class="select2 form-control" multiple>
                        @foreach ($pages as $page)
                            <option value="{{$page->id}}">{{$page->page_name}}</option>
                        @endforeach
                    </select>
                    {{-- <div class="form-group" id="permission_container">

                    </div> --}}
                </div>
            </div>
            <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
<!-- Edit User Modal-->
<div
    class="modal fade"
    id="editUserModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
<div class="alert alert-danger" id="userError2">
    <span id="errorMessage2"></span>
</div>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Edit User Information
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
                <form id="editUserForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                    <div class="form-group">
                      <label for="upfirstName">First Name</label>
                      <input  type="text" required name="firstName" id="upfirstName" class="form-control"  placeholder="eg. Jose,Bonifacio,Marilou">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="upmiddleName">Middle Name</label>
                        <input  type="text" required name="middleName" id="upmiddleName" class="form-control"  placeholder="eg. Rizal,Fadul,Calma">
                      </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label for="uplastName">Last Name</label>
                        <input  type="text" required name="lastName" id="uplastName" class="form-control"  placeholder="eg. Cabit,Romulo,Santos">
                      </div>
                </div>
                @if(session('user')->id===1)
                <div class="col-sm-4">
                      <div class="form-group">
                        <label for="branchName">Branch</label>
                        <select style="width: 100%; padding:2px; font-size:18px;" name="branchName" id="upbranchName" class="select2 form-control">
                            <option value=""></option>
                            @foreach ($branches as $branch )
                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
            <div class="col-sm-4">
            <div class="form-group">
                <label for="branchName1">Branch</label>
                <input type="text" readonly value="{{$branches->branch_name}}" id="branchName1" class="form-control">
                <input type="hidden" value="{{$branches->id}}" name="branchName" id="branchName" class="form-control">
            </div>
            </div>
            @endif
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="uproleName">Role</label>
                        <select style="width: 100%; padding:2px; font-size:18px;" name="roleName" id="uproleName" class="js-example-basic-single form-control">
                            <option value=""></option>
                            @foreach ($roles as $role )
                            <option value="{{$role->id}}">{{$role->role_name}}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="upusername">User Name</label>
                        <input type="text" required name="username" id="upusername" class="form-control"  placeholder="eg. psbc_gemmacalma">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="upemail">Email Address</label>
                        <input type="email" required name="email" id="upemail" class="form-control"  placeholder="eg. psbc@gmail.com">
                    </div>
                </div>
                <div class="col-sm-8 border-left">
                    <label for="editPermission">User Permission - Note: you can select Multiple Permissions</label>
                    <select name="editPermission[]" id="editPermission" class="select2 form-control" multiple>
                        @foreach ($pages as $page)
                            <option value="{{$page->id}}">{{$page->page_name}}</option>
                        @endforeach
                    </select>
                </div>
                </div>
                <input type="hidden" value="" id="hidden" name="id"/>
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

