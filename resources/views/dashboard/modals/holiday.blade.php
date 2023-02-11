<!-- Add Holiday Modal-->
<div
    class="modal fade"
    id="addHolidayModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add New Holiday
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
                <form id="HolidayForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="holiday_name">Holiday Name</label>
						<input type="text" name="holiday_name" id="holiday_name" class="form-control"  placeholder="eg. Christmas,New Year" />
					  </div>
                      

                    <div class="form-group">
                        <label for="holiday_date">Date</label>
                        <input type="date" name="holiday_date" id="holiday_date" class="form-control" />
                    </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

<!-- Edit Holiday Modal-->
<div
    class="modal fade"
    id="editHolidayModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Holiday
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
                <form id="EditHolidayForm" role="form" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="form-group">
						<label for="edit_holiday_name">Holiday Name</label>
						<input type="text" name="edit_holiday_name" id="edit_holiday_name" class="form-control"  placeholder="eg. Christmas,New Year" />
					  </div>
                      
                      
                    <div class="form-group">
                        <label for="edit_holiday_date">Date</label>
                        <input type="date" name="edit_holiday_date" id="edit_holiday_date" class="form-control" />
                    </div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>

