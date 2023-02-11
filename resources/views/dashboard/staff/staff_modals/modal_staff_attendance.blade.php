{{-- Update Assessment --}}
<div
    class="modal fade"
    id="uplaodAttendance"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Upload Attendance
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
                <form id="import_excel_form" role="form" data-toggle="validator">
                    @csrf
                    <div class="alert alert-danger" id="failed" role="alert" hidden></div>
                    <div class="col col-lg-12">
						<input id="attendanceFile" type="file" name="import_excel" class="form-control-file"/>
					</div>
                    <input id="import" type="submit" value="Import" class="btn btn-success float-right"/>
                </form>
            </div>
        </div>
    </div>
</div>

