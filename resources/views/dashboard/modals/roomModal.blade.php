<!-- Add Program Modal-->
<div
    class="modal fade"
    id="addRoomModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="alert alert-danger" id="roomError">
        <span id="errorMessage"></span>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create New Room
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
                <form id="RoomForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="room_number">Room Number</label>
						<input type="text" name="room_number" id="room_number" class="form-control"  placeholder="eg. 101,102,103" />
					  </div>
                      <div class="form-group">
						<label for="branchName">Branch</label>
						<select style="width: 100%; padding:2px; font-size:18px;" name="branchName" id="branchName" class="js-example-basic-single form-control"">
                            <option value=""></option>
                            @foreach ($branches as $branch )
                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option> 
                            @endforeach
                        </select>
					  </div>
                    <div class="form-group">
                        <label for="room_desc">Room Description</label>
                        <textarea class="form-control form-control-textarea" name="room_desc" id="room_desc" placeholder="eg. This is room description..."></textarea>
                    </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

{{--EDIT ROOM MODAL--}}

<div
    class="modal fade"
    id="editRoomModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="alert alert-danger" id="roomError2">
        <span id="errorMessage2"></span>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Room
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
                <form id="updateRoomForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="update_room_number">Room Number</label>
						<input type="text" name="room_number" id="update_room_number" class="form-control"  placeholder="eg. 101,102,103" />
					  </div>
                      <div class="form-group">
						<label for="branchName">Branch</label>
						<select style="width: 100%; padding:2px; font-size:18px;" name="branchName" id="editBranchName" class="js-example-basic-single form-control">
                            <option value=""></option>
                            @foreach ($branches as $branch )
                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option> 
                            @endforeach
                        </select>
					  </div>

                    <div class="form-group">
                        <label for="update_room_desc">Room Description</label>
                        <textarea class="form-control form-control-textarea" name="update_room_desc" id="update_room_desc" placeholder="eg. This is room description..."></textarea>
                    </div>
                    <button id="updatebtn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

